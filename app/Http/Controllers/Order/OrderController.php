<?php

namespace App\Http\Controllers\Order;

use App\Company;
use App\Order;
use App\Package;
use App\OrderDay;
use App\OrderDate;
use Carbon\Carbon;
use App\Mail\OrderMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Location;
use App\Vendor;
use Artisan;
use DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Log;

class OrderController extends Controller
{
    /**
     * Fetch All Orders
     *
     * @return void
     */
    public function getOrders()
    {
        // Begin query
        $orders = Order::query();

        // ?search=
        if (request()->has('search')) {
            $search = "%" . request()->search . "%";
            $orders->where(function ($query) use ($search) {
                $query->where('billing_email', 'like', $search)
                    ->orWhere('invoice_code', 'like', $search)
                    ->orWhere('billing_name', 'like', $search)
                    ->orWhere('billing_phone', 'like', $search)
                    ->orWhere('billing_discount_code', 'like', $search)
                    ->orWhere('payment_ref', 'like', $search);
            });
        }

        // ?created_at=
        if (request()->has('delivery_date')) {
            $orders->whereDate('delivery_date', Carbon::parse(request()->delivery_date));
        }

        // ?order_status=
        if (request()->has('order_status')) {
            $orders->where('order_status', request()->order_status);
        }

        // ?payment_status=
        if (request()->has('payment_status')) {
            $orders->where('payment_status', request()->payment_status);
        }

        $orders = $orders->with('request_rider')->orderBy('created_at', 'DESC')->paginate(20);

        return response()->json($orders);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $data = Order::findOrFail($id);
        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        // For Pickups append or change billing address
        if ($request->delivery_option == 'pickup') {
            $request->request->add(['billing_address' => '2nd Floor, 23 Jimoh Odutola St, Iganmu, Lagos']);
        }

        $this->validate($request, [
            'items' => 'required|json',
            'delivery_window' => 'required',
            'channel' => 'nullable|string',
            'billing_name' => 'required',
            'billing_email' => 'required',
            'billing_phone' => 'required',
            'billing_address' => 'required',
            'is_gift' => 'nullable',
            'receiver_name' => 'nullable',
            'gift_note' => 'nullable',
            'company_id' => 'nullable|exists:App\Company,id',
            'location_id' => 'required|exists:App\Location,id'
        ]);

        // Check if payment was successful then change the order status to confirmed
        if ($request->payment_status == 'success') {
            $request->request->add(['order_status' => 'confirmed']);
        }
        // Set the invoice code
        $request->request->add(['invoice_code' => Carbon::now()->timestamp]);
        $request->request->add(['created_at' => Carbon::now()->timestamp]);
        $request->request->add(['shop_id' => 1]);
        $order = Order::create($request->all());

        // Attach items IDs
        foreach (json_decode($request->items) as $value) {
            $order->packages()->attach($value->id);
        }

        return response()->json($order, 201);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $this->validate($request, [
            'items' => 'required|json',
            'delivery_date' => 'required|date',
            'delivery_window' => 'required',
            'order_amount' => 'required|numeric',
            'order_status' => 'required|string',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'channel' => 'nullable|string',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'company_id' => 'nullable|exists:App\Company,id',
            'location_id' => 'required|exists:App\Location,id'
        ]);

        $order->update($request->all());
        return response()->json($order, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(null, 204);
    }

    /**
     * Store order and generate pay4me link
     *
     * @param Request $request
     * @return void
     */
    public function storePay4Me(Request $request)
    {
        // For Pickups append or change billing address
        if ($request->delivery_option == 'pickup') {
            $request->request->add(['billing_address' => '2nd Floor, 23 Jimoh Odutola St, Iganmu, Lagos']);
        }

        $this->validate($request, [
            'items' => 'required|json',
            'delivery_window' => 'required',
            'channel' => 'nullable|string',
            'billing_name' => 'required',
            'billing_email' => 'required',
            'billing_phone' => 'required',
            'billing_address' => 'required',
            'company_id' => 'nullable|exists:App\Company,id',
            'location_id' => 'required|exists:App\Location,id'
        ]);

        $request->uuid = Str::uuid();
        $request->invoice_code = Carbon::now()->timestamp;
        $request->type = 'pay4me';

        $order = Order::create($request->all());

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . getenv('PAYSTACK_SECRET_KEY')
        ])->post('https://api.paystack.co/transaction/initialize', [
            'phone' => $request->billing_phone,
            'email' => $request->billing_email,
            'amount' => $request->billing_total * 100,
            'reference' => $request->payment_ref,
            'callback_url' => url('api/orders/callbackPay4Me')
        ], []);

        return response()->json($response->json(), $response->status());
    }

    /**
     * Callback Pay4Me
     *
     * @param Request $request
     * @return void
     */
    public function callbackPay4Me()
    {
        $order = Order::where('payment_ref', request()->reference)->first();
        $order->payment_status = 'success';
        $order->order_status = 'confirmed';
        $order->save();

        return redirect('https://smallchops.ng');
    }

    /**
     * Paystack Webhook
     *
     * @param Type $var
     * @return void
     */
    public function paystackWebhook(Request $request)
    {
        return $request;
        $reference = $request->input('data.reference');
        $order = Order::where('payment_ref', $reference)->first();
        $order->payment_status = 'success';
        $order->order_status = 'confirmed';
        $order->save();

        Mail::to($order->billing_email)->send(new OrderMail($order));
    }

    /**
     * Peer Payment
     * 
     * @param Type $var
     * @return void
     */

     public function payWithPeer(Request $request)
     {
        //get the order
        $order = Order::where('payment_ref', $request['data']['checkout']['meta']['payment_ref'])->first();
        $order->payment_status = 'success';
        $order->order_status = 'confirmed';
        $order->payment_gateway = 'peer';
        $order->save();

        Mail::to($order->billing_email)->send(new OrderMail($order));
     }
     /**
     * Paystack Payment
     * 
     * @param Type $var
     * @return void
     */

     public function payWithPaystack(Request $request)
     {
        //get the order
        $order = Order::where('payment_ref', $request['reference'])->first();
        $order->payment_status = 'success';
        $order->order_status = 'confirmed';
        $order->save();

        Mail::to($order->billing_email)->send(new OrderMail($order));
     }

    /**
     * Fetch list of packages and order counts
     *
     * @return void
     */
    public function fetchPackageOrder()
    {
        $packages = Package::query();

        if (request()->has('delivery_date')) {
            $packages = $packages->select(['name'])->withCount(['orders' => function ($query) {$query->whereDate('delivery_date', Carbon::parse(request()->delivery_date));}])->get();
        }else{         ;
            $packages = $packages->select(['name'])->withCount('orders')->get();
        }
        return response()->json($packages);

    }

    public function changeStatus(Request $request)
    {
        $order = Order::find($request->id);
        $order->order_status = $request->order_status;
        $order->save();
        if($order->order_status==="confirmed"){
            Mail::to($order->billing_email)->send(new OrderMail($order));
        }
        return response()->json($order, 202);
    }

    public function changePaymentStatus(Request $request)
    {
        $order = Order::find($request->id);
        $order->payment_status = $request->payment_status;
        $order->save();

        return response()->json($order, 202);
    }

    public function assignRider(Request $request)
    {
        $order = Order::find($request->orderID);
        $order->logistics_id = $request->companyID;
        $order->company_id = $request->companyID;
        $order->logistics = ['company' => $request->companyID];
        $order->save();

        // change the status of the other stuff 
        $rr = DB::table('request_rider')->where('id', '=', $request->req)->update(['company_id' => $request->companyID, 'status' => 'assigned']);
        return response()->json($order, 202);
    }

    public function requestRider(Request $request)
    {
        $user_id = auth()->id();
        $billing_total = $request->billingTotal;
        $billing_type = $request->billingType;
        $order_id = $request->orderID;
        $request_rider = DB::table('request_rider')->insertGetId([
            'user_id' => $user_id,
            'billing_total' => $billing_total,
            'billing_type' => $billing_type,
            'order_id' => $order_id
        ]);
        Artisan::queue('rider:request', [
            'order' => $order_id, '--queue' => 'default'
        ]);
        return response()->json($request_rider, 202);

    }

    public function riderRequest(Request $request)
    {
        $rider_request = DB::table('request_rider')->where('id', '=', $request[1])->first();
        Log::info($rider_request);
        Log::info($request[1]);
        $order = Order::find($rider_request->order_id);
        $vendor = Vendor::find($order->vendor_id);
        $location = Location::find($order->location_id);
        $company = Company::where('phone', $request[0])->first();
        return response()->json(['request_id'=>$rider_request->id, 'delivery' => $location->delivery_location, 'pickup' => $vendor->address, 'company' => $company->id, 'order' => $order->id, 'status' => $rider_request->status], 202);
        // $user_id = auth()->id();
        // $billing_total = $request->billingTotal;
        // $billing_type = $request->billingType;
        // $order_id = $request->orderID;
        // $request_rider = DB::table('request_rider')->insertGetId([
        //     'user_id' => $user_id,
        //     'billing_total' => $billing_total,
        //     'billing_type' => $billing_type,
        //     'order_id' => $order_id
        // ]);
        // return response()->json($request_rider, 202);

    }

    public function fetchDeliveryDays()
    {
        $deliveryDays = OrderDay::select('*')->get();
        return $deliveryDays;
    }

    public function changeDayStatus(Request $request)
    {
        $orderDay = OrderDay::find($request->id);
        $orderDay->status = $request->status;
        $orderDay->save();
    }

    public function fetchTrackedDeliveryDates()
    {
        $deliveryDate = OrderDate::select('*')->orderBy('updated_at', 'DESC')->get();
        return $deliveryDate;
    }

    public function storeTrackedDate(Request $request)
    {
        $newTrackedDate = new OrderDate();
        $dateInstance = OrderDate::where('date', $request->date)->first();
        if ($dateInstance) {
            $dateInstance->touch();
            return $dateInstance;
        } else {
            $newTrackedDate->date = $request->date;
            $newTrackedDate->status = 'disabled';
            $newTrackedDate->save();
            return $newTrackedDate;
        }
    }

    public function changeTrackedDateStatus(Request $request)
    {
        $orderDay = OrderDate::find($request->id);
        $orderDay->status = $request->status;
        $orderDay->save();

        return $orderDay;
    }

    public function verifyPayments(Request $request)
    {
        $orders = Order::whereNotNull('payment_ref')
            ->whereNotIn('payment_status', ['success', 'failed', 'abandoned'])
            ->get();

        foreach ($orders as $order) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . getenv('PAYSTACK_SECRET_KEY')
            ])->get('https://api.paystack.co/transaction/verify/' . $order['payment_ref']);
            if ($response->json()['status']) {
                $order->payment_status = $response['data']['status'];
                $order->save();
            }
        }

        return $orders;
    }

    public function getOrderFinance()
    {
        // Begin query
        $orders = Order::query();

        // ?search=
        if (request()->has('search')) {
            $search = "%" . request()->search . "%";
            $orders->where(function ($query) use ($search) {
                $query->where('billing_email', 'like', $search)
                    ->orWhere('invoice_code', 'like', $search)
                    ->orWhere('billing_name', 'like', $search)
                    ->orWhere('billing_phone', 'like', $search)
                    ->orWhere('channel', 'like', $search)
                    ->orWhere('billing_discount_code', 'like', $search)
                    ->orWhere('payment_ref', 'like', $search);
            });
        }

        // ?created_at=
        if (request()->has('delivery_date')) {
            $orders->whereDate('delivery_date', Carbon::parse(request()->delivery_date));
        }

        $orders->where('payment_status', 'success');

        // Quick script to update data
        if (request()->has('update')) {
            $orders->whereNull('payment_ref')->update(['payment_gateway' => '-']);
        }

        $per_page = is_int(request()->per_page) || request()->per_page > 500 ? 20 : request()->per_page;

        $orders = $orders->orderBy('created_at', 'DESC')->select(['*'])->paginate($per_page);

        return response()->json($orders);
    }
}

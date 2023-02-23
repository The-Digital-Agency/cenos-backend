<?php

namespace App\Http\Controllers\Order;

use Carbon\Carbon;
use App\CorporateOrder;
use Illuminate\Http\Request;
use App\Mail\CorporateOrderMail;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class CorporateOrderController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $corporateOrders = CorporateOrder::query();

        // ?search=
        if (request()->has('search')) {
            $search = "%" . request()->search . "%";
            $corporateOrders->where(function ($query) use ($search) {
                $query->where('rep_name', 'like', $search)
                    ->orWhere('rep_number', 'like', $search);
            });
        }

        // ?created_at=
        if (request()->has('delivery_date')) {
            $corporateOrders->whereDate('delivery_date', Carbon::parse(request()->delivery_date));
        }

        // ?order_status=
        if (request()->has('order_status')) {
            $corporateOrders->where('order_status', request()->order_status);
        }

        // ?payment_status=
        if (request()->has('payment_status')) {
            $corporateOrders->where('payment_status', request()->payment_status);
        }

        $corporateOrders = $corporateOrders->orderBy('created_at', 'DESC')->paginate(20);

        return response()->json($corporateOrders, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $data = CorporateOrder::findOrFail($id);
        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'company_name' => 'required|string',
            'rep_name' => 'required|string',
            'rep_number' => 'required|string',
            'delivery_date' => 'required|date',
            'items' => 'required|json',
        ]);

        $request->request->add(['delivery_date' => Carbon::parse($request->delivery_date)]);
        $request->request->add(['order_status' => 'Unconfirmed']);
        $request->request->add(['payment_status' => 'Unpaid']);

        $corporateOrder = CorporateOrder::create($request->all());

        // Send to customer
        Mail::to($corporateOrder->rep_email)->send(new CorporateOrderMail($corporateOrder));

        // Send to admin
        $adminEmail = config('app.debug') ? 'dbizzyxy@gmail.com' : 'orders@smallchops.ng';
        Mail::to($adminEmail)->send(new CorporateOrderMail($corporateOrder, true));

        return response()->json($corporateOrder, 201);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $order = CorporateOrder::findOrFail($id);

        $this->validate($request, [
            'company_name' => 'required|string',
            'rep_name' => 'required|string',
            'rep_number' => 'required|email',
            'delivery_date' => 'required|date',
            'items' => 'required|json',
        ]);

        $order->update($request->all());
        return response()->json($order, 200);
    }

    /**
     * Changes order status
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changeStatus(Request $request)
    {
        $order = CorporateOrder::find($request->id);
        $order->order_status = $request->order_status;
        $order->save();

        return response()->json($order, 200);
    }

    public function changePaymentStatus(Request $request)
    {
        $order = CorporateOrder::find($request->id);
        $order->payment_status = $request->payment_status;
        $order->save();

        return response()->json($order, 200);
    }

    public function assignRider(Request $request)
    {
        $order = CorporateOrder::find($request->orderID);
        $order->logistics_id = $request->logisticsID;
        $order->logistics = $request->logistics;
        $order->save();

        return response()->json($order, 202);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $order = CorporateOrder::findOrFail($id);
        $order->delete();

        return response()->json(null, 204);
    }
}

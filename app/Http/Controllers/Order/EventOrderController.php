<?php

namespace App\Http\Controllers\Order;

use Carbon\Carbon;
use App\EventOrder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Mail\EventOrderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class EventOrderController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $eventOrders = EventOrder::query();

        // ?search=
        if (request()->has('search')) {
            $search = "%" . request()->search . "%";
            $eventOrders->where(function ($query) use ($search) {
                $query->where('name', 'like', $search)
                    ->orWhere('phone', 'like', $search);
            });
        }

        // ?created_at=
        if (request()->has('delivery_date')) {
            $eventOrders->whereDate('delivery_date', Carbon::parse(request()->delivery_date));
        }

        // ?order_status=
        if (request()->has('order_status')) {
            $eventOrders->where('order_status', request()->order_status);
        }

        // ?payment_status=
        if (request()->has('payment_status')) {
            $eventOrders->where('payment_status', request()->payment_status);
        }

        $eventOrders = $eventOrders->orderBy('created_at', 'DESC')->paginate(20);

        return response()->json($eventOrders, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $data = EventOrder::findOrFail($id);
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
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'delivery_date' => 'required|date',
            'guests_count' => 'required|numeric',
            'items' => 'required|json',
            'location_id' => 'required|exists:App\Location,id',
        ]);

        $request->request->add(['delivery_date' => Carbon::parse($request->delivery_date)]);
        $request->request->add(['order_status' => 'Unconfirmed']);
        $request->request->add(['payment_status' => 'Unpaid']);

        $eventOrder = EventOrder::create($request->all());

        // Send to customer
        Mail::to($eventOrder->email)->send(new EventOrderMail($eventOrder));

        // Send to admin
        $adminEmail = config('app.debug') ? 'dbizzyxy@gmail.com' : 'orders@smallchops.ng';
        Mail::to($adminEmail)->send(new EventOrderMail($eventOrder, true));

        return response()->json($eventOrder, 201);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $order = EventOrder::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'delivery_date' => 'required|date',
            'guests_count' => 'required|numeric',
            'items' => 'required|json',
            'location_id' => 'required|exists:App\Location,id',
        ]);

        $order->update($request->all());
        return response()->json($order, 200);
    }

    public function changeStatus(Request $request)
    {
        $order = EventOrder::find($request->id);
        $order->order_status = $request->order_status;
        $order->save();

        return response()->json($order, 202);
    }

    public function changePaymentStatus(Request $request)
    {
        $order = EventOrder::find($request->id);
        $order->payment_status = $request->payment_status;
        $order->save();

        return response()->json($order, 202);
    }

    public function assignRider(Request $request)
    {
        $order = EventOrder::find($request->orderID);
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
        $order = EventOrder::findOrFail($id);
        $order->delete();

        return response()->json(null, 204);
    }
}

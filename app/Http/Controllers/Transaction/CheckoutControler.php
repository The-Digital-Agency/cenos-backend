<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\Coupon;
use App\Setting;
use PackageOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Unicodeveloper\Paystack\Paystack;

class CheckoutControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orderValues = $this->getValues($request);
        // Insert into orders table
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_postalcode' => $request->postalcode,
            'billing_phone' => $request->phone,
            'billing_discount' => $orderValues->get('discount'),
            'billing_discount_code' => $orderValues->get('code'),
            'billing_subtotal' => $orderValues->get('newSubtotal'),
            'billing_total' => $orderValues->get('actualTotalPrice'),
            'billing_tax' => $orderValues->get('tax'),
            'location_id' => $orderValues->get('tax'),
            'delivery_window' => $request->delivery_window
        ]);
    }

    /**
     * Stores a temp cart instance customer
     *
     * @param Request $request
     * @return void
     */
    public function storeCart(Request $request)
    {
        $cart = Cart::findByUser();
        // Check if cart exists, else create a new one
        if ($cart) {
            $cart::update(['cart_object' => $request]);
        } else {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'cart_object' => $request
            ]);
        }

        return response()->json($cart);
    }

    /**
     * Store product/order relationship after storing order
     *
     * @param [type] $orderContent
     * @param [type] $order
     * @return void
     */
    public function storePackageOrder($orderContent, $order)
    {
        foreach ($orderContent as $item) {
            PackageOrder::create([
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty,
            ]);
        }
    }

    /**
     * Process complex calculations and return a collection
     *
     * @param [type] $request
     * @return Collection
     */
    public function getValues($request)
    {
        $totalItemsPrice = $request->total_items_price;
        $couponCode = $tax = null;
        $coupon = Coupon::findByCode($request->code);

        $percTax = Setting::tax()->tax / 100;
        $discount = $coupon ? $coupon->discount($totalItemsPrice) : 0;
        $code = $coupon ? $coupon->code : null;
        $subtotal = $totalItemsPrice - $discount;
        if ($subtotal < 0) {
            $newSubtotal = 0;
        }
        $tax = $newSubtotal * $percTax;
        $actualTotalPrice = $newSubtotal * (1 + $percTax);

        return collect([
            'tax' => $tax,
            'discount' => $discount,
            'code' => $code,
            'newSubtotal' => $newSubtotal,
            'actualTotalPrice' => $actualTotalPrice,
        ]);
    }

    /**
     * Go pay with paystack
     *
     * @param Request $request
     * @return void
     */
    public function redirectToGateway(Request $request)
    {
        // computed amount -> $amount;

        $paystack = new Paystack();
        $user = Auth::user();
        $request->email = $user->email;
        // $request->amount = $amount;
        $request->reference = $paystack->genTranxRef();
        $request->key = config('paystack.secretKey');

        return $paystack->getAuthorizationUrl()->redirectNow();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Overview;

use App\BankPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankPayment = BankPayment::orderBy('paid_at', 'DESC')->get();

        return response()->json($bankPayment, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BankPayment  $bankPayment
     * @return \Illuminate\Http\Response
     */
    public function show(BankPayment $bankPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BankPayment  $bankPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(BankPayment $bankPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BankPayment  $bankPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankPayment $bankPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BankPayment  $bankPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankPayment $bankPayment)
    {
        //
    }
}

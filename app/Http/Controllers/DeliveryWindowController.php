<?php

namespace App\Http\Controllers;

use App\OrderDay;
use App\OrderDate;
use Carbon\Carbon;
use App\DeliveryWindow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Exceptions\InvalidFormatException;

class DeliveryWindowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($date = null)
    {
        try {
            $date = $date ? Carbon::parse($date) : Carbon::now();
        } catch (InvalidFormatException $e) {
            $date = Carbon::now();
        }

        $isDayDisabled = OrderDay::where('day', $date->englishDayOfWeek)
            ->where('status', 'disabled')->count() > 0;

        $isDateDisabled = OrderDate::where('date', $date->format('Y-m-d'))
            ->where('status', 'disabled')->count() > 0;

        $deliveryWindow = (!$isDayDisabled && !$isDateDisabled) ?
            DeliveryWindow::where('day', $date->englishDayOfWeek)
            ->where('status', 'active')
            ->orderBy('id', 'ASC')
            ->get() : [];

        return  response()->json($deliveryWindow, 200);
    }

    /**
     * Get all delivery dates
     *
     * @return void
     */
    public function all()
    {
        $date = Carbon::now();
        $deliveryWindows =
            DeliveryWindow::select('*')
            ->orderBy('id', 'ASC')
            ->get();

        return $deliveryWindows;
    }

    /**
     * Get everyday delivery window date
     *
     * @return void
     */
    public function regularDeliveryDate()
    {
        $date = Carbon::now();
        $deliveryWindows =
            DeliveryWindow::select('*')
            ->where('day', $date->englishDayOfWeek)
            ->orderBy('id', 'ASC')
            ->get();

        return $deliveryWindows;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $deliveryWindow = new DeliveryWindow();
        $deliveryWindow->day = $request->day;
        $deliveryWindow->start_time = $request->start_time;
        $deliveryWindow->end_time = $request->end_time;
        $deliveryWindow->save();

        return $deliveryWindow;
    }

    /**
     * Change the delivery window status
     *
     * @param Request $request
     * @return void
     */
    public function changeDeliveryWindowStatus(Request $request)
    {
        $deliveryWindow = DeliveryWindow::find($request->id);
        $deliveryWindow->status = $request->status;
        $deliveryWindow->save();

        return $deliveryWindow;
    }
}

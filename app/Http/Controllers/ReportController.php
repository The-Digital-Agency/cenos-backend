<?php

namespace App\Http\Controllers;

use App\Order;
use Carbon\Carbon;
use App\EventOrder;
use App\CashRequest;
use App\CorporateOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    // Process Start and End Dates
    public function getDuration($startDate, $endDate)
    {
        $startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->startOfDay();
        $endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfDay();

        return [$startDate, $endDate];
    }

    // Get Order Sales Total
    public function getRegularOrdersTotal($startDate = null, $endDate = null)
    {
        $duration = $this->getDuration($startDate, $endDate);
        $startDate = $duration[0];
        $endDate = $duration[1];

        $orders = Order::select('*')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotIn('order_status', ['canceled', 'failed', 'unconfirmed'])
            ->get();

        return $orders->sum('billing_total');
    }

    // Get Event Order Sales Total
    public function getEventOrdersTotal($startDate = null, $endDate = null)
    {
        $duration = $this->getDuration($startDate, $endDate);
        $startDate = $duration[0];
        $endDate = $duration[1];

        $eventOrders = EventOrder::select('*')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotIn('order_status', ['canceled', 'failed', 'unconfirmed'])
            ->get();

        return $eventOrders->sum('order_amount');
    }

    // Get Corprate Order Sales Total
    public function getCorporateOrdersTotal($startDate = null, $endDate = null)
    {
        $duration = $this->getDuration($startDate, $endDate);
        $startDate = $duration[0];
        $endDate = $duration[1];

        $eventOrders = CorporateOrder::select('*')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotIn('order_status', ['canceled', 'failed', 'unconfirmed'])
            ->get();

        return $eventOrders->sum('order_amount');
    }

    // Get Expense Total

    public function getExpenseTotal($type = 'opex', $startDate = null, $endDate = null)
    {
        $duration = $this->getDuration($startDate, $endDate);
        $startDate = $duration[0];
        $endDate = $duration[1];

        $cashRequests = CashRequest::select('*')
            ->where('expense_type', $type)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotIn('status', ['processing', 'rejected'])
            ->get();

        return $cashRequests->sum('amount');
    }

    public function allTotals($startDate, $endDate)
    {
        return [
            'regularOrdersTotal' => $this->getRegularOrdersTotal($startDate, $endDate),
            'eventOrdersTotal' => $this->getEventOrdersTotal($startDate, $endDate),
            'corporateOrdersTotal' => $this->getCorporateOrdersTotal($startDate, $endDate),
            'opex' => $this->getExpenseTotal('opex'),
            'capex' => $this->getExpenseTotal('capex')
        ];
    }

    public function allPackageRevenue($startDate, $endDate)
    {
        $duration = $this->getDuration($startDate, $endDate);
        $startDate = $duration[0];
        $endDate = $duration[1];

        // return $endDate;

        $orders = Order::select('items')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'success')
            ->get()
            ->map(
                function ($el) {
                    return json_decode($el->items, true);
                }
            );

        // return $orders;

        $packageRevenue = collect($orders)->flatten(1)->reduce(function ($carry, $item) {
            if (!isset($carry[$item['id']])) {
                $carry[$item['id']] = $item;
            } else {
                $carry[$item['id']]['quantity'] += $item['quantity'];
            }
            return $carry;
        });

        return array_values($packageRevenue ?? []);
    }

    public function orderRider(Request $request)
    {
        $duration = $this->getDuration($request->startDate, $request->endDate);
        $startDate = $duration[0];
        $endDate = $duration[1];

        $orders = Order::select('*')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('logistics_id', $request->logisticsID)
            ->whereIn('order_status', ['delivered'])
            ->with('deliveryWindow')
            ->with('location')
            ->get();

        return [
            'orderLogistics' => $orders,
            'totalDeliveryCharge' => $orders->pluck('location')->sum('delivery_charge')
        ];
    }

    public function orderPerPeriod(Request $request)
    {
        // Default last 7 days
        $startDate = Carbon::now()->subDays(6);
        $endDate = Carbon::now();
        $delimiter = 'd-M-y';

        if ($request->duration == 'weeks') {
            $startDate = Carbon::now()->subWeeks(6);
            $endDate = Carbon::now();
            $delimiter = 'W';
        } elseif ($request->duration == 'months') {
            $startDate = Carbon::now()->subMonths(6);
            $endDate = Carbon::now();
            $delimiter = 'M';
        }

        $orders = Order::select('*')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotIn('order_status', ['canceled', 'failed', 'unconfirmed'])
            ->orderBy('created_at', 'ASC')
            ->get()->groupBy(function ($item) use ($delimiter) {
                return $item->created_at->format($delimiter);
            });

        return $orders;
    }

    public function revenuePerPeriod(Request $request)
    {
        return $this->orderPerPeriod($request)->map(function ($order) {
            return $order->sum('billing_total');
        });
    }
}

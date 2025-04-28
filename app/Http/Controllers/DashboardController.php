<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\FoodOrder;
use App\Models\Order;


class DashboardController extends Controller
{
    public function index()
    {
        // Weekly Data
        $approvedBookingsWeekly = Booking::where('status', 'approved')
            ->where('created_at', '>=', now()->subWeek())
            ->count();
        $completedOrdersWeekly = FoodOrder::where('status', 'completed')
            ->where('created_at', '>=', now()->subWeek())
            ->count();

        // Monthly Data
        $approvedBookingsMonthly = Booking::where('status', 'approved')
            ->where('created_at', '>=', now()->subMonth())
            ->count();
        $completedOrdersMonthly = FoodOrder::where('status', 'completed')
            ->where('created_at', '>=', now()->subMonth())
            ->count();

        // Yearly Data
        $approvedBookingsYearly = Booking::where('status', 'approved')
            ->where('created_at', '>=', now()->subYear())
            ->count();
        $completedOrdersYearly = FoodOrder::where('status', 'completed')
            ->where('created_at', '>=', now()->subYear())
            ->count();

        return view('admin.dashboardview', compact(
            'approvedBookingsWeekly', 'completedOrdersWeekly',
            'approvedBookingsMonthly', 'completedOrdersMonthly',
            'approvedBookingsYearly', 'completedOrdersYearly'
        ));
    }
}

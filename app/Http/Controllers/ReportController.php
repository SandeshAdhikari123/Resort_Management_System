<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\FoodOrder;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function generateReport(Request $request)
    {
        // Get the date range filter from the request
        $reportType = $request->input('report_type'); // 'daily', 'weekly', 'monthly', or 'yearly'
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Parse the date range
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        } else {
            // Fallback to report_type logic if no custom dates are provided
            $startDate = Carbon::now();
            $endDate = Carbon::now();

            if ($reportType == 'daily') {
                $startDate = Carbon::today();
                $endDate = Carbon::tomorrow();
            } elseif ($reportType == 'weekly') {
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
            } elseif ($reportType == 'monthly') {
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
            } elseif ($reportType == 'yearly') {
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
            }
        }

        // Fetch bookings and food orders within the date range
        $bookings = Booking::whereBetween('created_at', [$startDate, $endDate])->get();
        $foodOrders = FoodOrder::whereBetween('created_at', [$startDate, $endDate])->get();

        // Prepare data to be passed to the PDF view
        $data = [
            'reportType' => ucfirst($reportType) ?: 'Custom',
            'startDate' => $startDate->toDateString(),
            'endDate' => $endDate->toDateString(),
            'bookings' => $bookings,
            'foodOrders' => $foodOrders,
        ];

        // Generate the PDF using a view
        $pdf = PDF::loadView('reports.bill_report', $data);

        // Return the PDF to the browser for download
        return $pdf->download('bill_report.pdf');
    }
}

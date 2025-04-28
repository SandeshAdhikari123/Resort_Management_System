@extends('admin.index')

@section('content')
<form action="{{ route('generate.report') }}" method="GET">
<h1 style="text-align: center; color: #333; margin-bottom: 20px;">Generate Bills</h1>

    <label for="report_type">Select Report Type:</label>
    <select name="report_type" id="report_type">
        <option value="">Select</option>
        <option value="daily">Daily</option>
        <option value="weekly">Weekly</option>
        <option value="monthly">Monthly</option>
        <option value="yearly">Yearly</option>
    </select>

    <label for="start_date">Start Date:</label>
    <input type="date" name="start_date" id="start_date">

    <label for="end_date">End Date:</label>
    <input type="date" name="end_date" id="end_date">

    <button type="submit">Generate Report</button>
</form>

<div class="container mt-4">
<h1 style="text-align: center; color: #333; margin-bottom: 20px;">Chart</h1>
    <!-- Chart Container -->
    <canvas id="dashboardChart" width="200" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Backend data (passed dynamically to the template)
        const weeklyData = {
            bookings: {{ $approvedBookingsWeekly }},
            orders: {{ $completedOrdersWeekly }}
        };
        const monthlyData = {
            bookings: {{ $approvedBookingsMonthly }},
            orders: {{ $completedOrdersMonthly }}
        };
        const yearlyData = {
            bookings: {{ $approvedBookingsYearly }},
            orders: {{ $completedOrdersYearly }}
        };

        // Chart.js configuration
        const ctx = document.getElementById('dashboardChart').getContext('2d');
        const dashboardChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Weekly', 'Monthly', 'Yearly'],
                datasets: [
                    {
                        label: 'Approved Bookings',
                        data: [weeklyData.bookings, monthlyData.bookings, yearlyData.bookings],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Completed Orders',
                        data: [weeklyData.orders, monthlyData.orders, yearlyData.orders],
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
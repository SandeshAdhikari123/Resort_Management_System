<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyFoodOrders</title>
    <base href="/public">
    @include('home.css')
</head>
<body>
<header>
      @include('home.header')
</header>

<div class="my_orders mt-2" style="margin-top: -1px; background-color: #f0f0f0;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>My Orders</h2>
                    <p>Here are all the orders you have placed.</p>
                </div>
            </div>
        </div>
        
        <!-- Display errors if any -->
        @if (session('success'))
            <div class="alert alert-success">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if ($orders->isEmpty())
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <p>You have not placed any orders yet.</p>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Food</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->food->name }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>{{ $order->totalprice}}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>

</body>
</html>
@include('home.footer')
<style>
    /* Styling for My Orders Table */
    .my_orders .table {
        width: 100%;
        border-collapse: collapse;
        background-color: #f8f9fa;
    }

    .my_orders .table th,
    .my_orders .table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .my_orders .table th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    .my_orders .table td {
        font-size: 16px;
    }

    .my_orders .table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .my_orders .table tr:hover {
        background-color: #ddd;
    }

    /* Alert Styling */
    .alert {
        padding: 10px;
        margin-bottom: 20px;
        font-size: 16px;
    }

    .alert-warning {
        background-color: #ffc107;
        color: #fff;
    }

    .alert-success {
        background-color: #28a745;
        color: #fff;
    }

    .alert-danger {
        background-color: #dc3545;
        color: #fff;
    }

</style>
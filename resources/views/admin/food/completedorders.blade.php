@extends('admin.index')

@section('content')
    <h2>Completed Food Orders</h2>

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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Table to display food orders -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Food Name</th>
                <th>Food Price</th>
                <th>User Name</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>OrderFromRoom</th>
                <th>TotalAmount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($foodOrders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->food->name }}</td>
                    <td>Rs. {{ $order->food->price }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>
                        @if ($order->activeBooking)
                            {{ $order->activeBooking->room->room_name }}
                        @else
                            No Active Booking
                        @endif
                    </td>
                    <td>Rs. {{ $order->totalprice}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
<style>
    /* General page styles */
        h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Alerts */
        .alert {
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .alert ul {
            list-style-type: none;
            padding-left: 0;
        }

        /* Table Styles */
        .table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .table td {
            font-size: 14px;
        }

        /* Table Action Button */
        button.btn {
            font-size: 12px;
            padding: 6px 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button.btn:hover {
            background-color: #0056b3;
        }

        /* Select Dropdown for status */
        select {
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
            background-color: #fff;
        }

        select:focus {
            outline: none;
            border-color: #007bff;
        }

        /* Table Row Hover */
        .table tr:hover {
            background-color: #f1f1f1;
        }

        /* Column widths */
        .table td:nth-child(1), .table th:nth-child(1) {
            width: 10%;
        }

        .table td:nth-child(2), .table th:nth-child(2) {
            width: 20%;
        }

        .table td:nth-child(3), .table th:nth-child(3) {
            width: 15%;
        }

        .table td:nth-child(4), .table th:nth-child(4) {
            width: 20%;
        }

        .table td:nth-child(5), .table th:nth-child(5) {
            width: 10%;
        }

        .table td:nth-child(6), .table th:nth-child(6) {
            width: 10%;
        }

        .table td:nth-child(7), .table th:nth-child(7) {
            width: 15%;
        }

        .table td:nth-child(8), .table th:nth-child(8) {
            width: 10%;
        }

        /* Mobile responsiveness */
        @media (max-width: 767px) {
            .table th, .table td {
                font-size: 12px;
                padding: 8px;
            }

            h2 {
                font-size: 20px;
            }

            .table td, .table th {
                text-align: center;
            }

            /* Stack the form button and select on mobile */
            .table td form {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .table td form button {
                margin-top: 5px;
            }
        }

</style>


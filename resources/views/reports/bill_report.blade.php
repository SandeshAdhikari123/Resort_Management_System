<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-title {
            font-size: 18px;
            font-weight: bold;
        }
        .report-date-range {
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Bill Report</h1>
        <p class="report-title">{{ $reportType }} Report</p>
        <p class="report-date-range">From: {{ $startDate }} To: {{ $endDate }}</p>
    </div>
        <!-- Bookings Section -->
        <h2>Bookings</h2>
    @if(count($bookings) > 0)
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>User Name</th>
                    <th>Room Name</th>
                    <th>Room Price</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->room->room_name ?? 'Room name not available' }}</td>
                        <td>{{ $booking->room->room_price ?? 'Price not available' }}</td>
                        <td>{{ $booking->start_date }}</td>
                        <td>{{ $booking->end_date }}</td>
                        <td>{{ $booking->totalprice }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No bookings available for this period.</p>
    @endif

    <h2>Food Orders</h2>
    @if(count($foodOrders) > 0)
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User Name</th>
                    <th>Food Item</th>
                    <th>Food Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($foodOrders as $foodOrder)
                    <tr>
                        <td>{{ $foodOrder->id }}</td>
                        <td>{{ $foodOrder->user->name }}</td>
                        <td>{{ $foodOrder->food->name }}</td>
                        <td>{{ $foodOrder->food->price }}</td>
                        <td>{{ $foodOrder->quantity }}</td>
                        <td>{{ $foodOrder->totalprice }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No food orders available for this period.</p>
    @endif

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookingHistory</title>
        <base href="/public">
        @include('home.css')
</head>
<body>
@include('home.header')
    <h2>Previous Bookings</h2>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Room Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($previousBookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->room->room_name }}</td>
                <td>{{ $booking->start_date }}</td>
                <td>{{ $booking->end_date }}</td>
                <td>{{$booking->status}}</td>
                <td>{{ $booking->totalprice }}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>  
</body>
</html>
<style>
    /* General styling for the page */
    body {
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    /* Header styles */
    h2 {
        text-align: center;
        margin-top: 20px;
        color: #333;
    }

    /* Table styling */
    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Table headers */
    th {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        text-align: left;
        font-size: 16px;
    }

    /* Table data */
    td {
        background-color: #f9f9f9;
        color: #333;
        padding: 10px;
        text-align: left;
        font-size: 14px;
        border-bottom: 1px solid #ddd;
    }

    /* Table row hover effect */
    tr:hover {
        background-color: #f1f1f1;
    }

    /* Add spacing and padding for the table */
    tbody tr:first-child td {
        border-top: 2px solid #ddd;
    }

    tbody tr:last-child td {
        border-bottom: 2px solid #ddd;
    }

    /* Add some padding to the body and table */
    body, table {
        padding: 0 10px;
    }

    /* Responsive design for mobile devices */
    @media (max-width: 768px) {
        table {
            width: 100%;
            font-size: 12px;
        }

        th, td {
            padding: 8px;
        }
    }
</style>


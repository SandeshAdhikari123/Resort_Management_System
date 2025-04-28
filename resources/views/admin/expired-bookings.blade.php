@extends('admin.index')

@section('content')
<div class="container">
    <h2>Expired Bookings</h2>
    @if($expiredBookings->isEmpty())
        <p>No expired bookings found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Room</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Deleted At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expiredBookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->room->name ?? 'Room not found' }}</td>
                        <td>{{ $booking->name }}</td>
                        <td>{{ $booking->email }}</td>
                        <td>{{ $booking->phone }}</td>
                        <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                        <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                        <td>{{ $booking->deleted_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

<style>
    /* Ensure the table has a nice border and spacing */
    .table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 12px 15px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #f2f2f2;
        color: #333;
    }

    .table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .table tbody tr:nth-child(odd) {
        background-color: #fff;
    }

    .table td {
        color: #555;
    }

    .table td, .table th {
        font-size: 14px;
    }

    /* Add styling for the container */
    .container {
        padding: 30px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Title styling */
    h2 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    /* Handle empty state message */
    p {
        color: #777;
        font-size: 16px;
    }

    /* Optional: Add a margin to the top of the page */
    body {
        margin-top: 20px;
    }

</style>

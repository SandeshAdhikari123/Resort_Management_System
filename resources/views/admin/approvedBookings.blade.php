@extends('admin.index')

@section('content')
<div class="container">
    <h1 class="mb-4">Approved Bookings</h1>

    @if($approvedBookings->isEmpty())
        <div class="alert alert-info">
            No approved bookings found.
        </div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Room Name</th>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Payment Mode</th>
                    <th>Total Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approvedBookings as $index => $booking)
                    @php
                        // Find the room for this booking using the room_id
                        $room = $rooms->firstWhere('id', $booking->room_id);
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $room->room_name ?? 'Room not found' }}</td>
                        <td>{{ $booking->name }}</td>
                        <td>{{ $booking->phone }}</td>
                        <td>{{ $booking->start_date }}</td>
                        <td>{{ $booking->end_date }}</td>
                        <td>{{ ucfirst($booking->payment_mode) }}</td>
                        <td>{{$booking->totalprice  }}</td>
                        <td>{{ $booking->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

<style>
    /* Table Styling */
    .table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .table-bordered th, .table-bordered td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .table th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: bold;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .table td {
        font-size: 14px;
    }

    /* Button Styling */
    .btn {
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
        display: inline-block;
    }

    .btn-sm {
        font-size: 14px;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
        border: none;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
    }

    .btn:hover {
        opacity: 0.8;
    }

    /* Alerts */
    .alert {
        margin-top: 20px;
        padding: 10px;
        border-radius: 5px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>
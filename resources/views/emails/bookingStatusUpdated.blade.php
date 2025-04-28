<!DOCTYPE html>
<html>
<head>
    <title>Booking Status Updated</title>
</head>
<body>
    <p>Dear {{ $user->name }},</p>
    <p>Your booking for room "{{ $booking->room->room_name }}" has been {{ $status }}.</p>
    <p>Booking Details:</p>
    <ul>
        <li>Price per Day: {{ $booking->room->room_price }}</li>
        <li>Total Days: {{ $total_days }}</li>
        <li>Total Amount: {{ $total_amount }}</li>
    </ul>
    <p>Thank you for choosing us!</p>
</body>
</html>

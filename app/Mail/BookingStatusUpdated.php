<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;

class BookingStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $status;
    public $booking;
    public $user;
    public $total_days;
    public $total_amount;

    // Constructor to initialize the properties
    public function __construct($status, $booking, $user)
    {
        $this->status = $status;
        $this->booking = $booking;
        $this->user = $user;

        // Ensure the dates are parsed as Carbon instances
        $startDate = Carbon::parse($this->booking->start_date);
        $endDate = Carbon::parse($this->booking->end_date);

        // Access room_price and calculate totals
        $roomPrice = $this->booking->room->room_price;

        // Calculate total days (including both start_date and end_date)
        $this->total_days = $startDate->diffInDays($endDate) + 1;

        // Calculate total amount based on room_price
        $this->total_amount = $this->total_days * $roomPrice;
    }

    public function build()
    {
        return $this->view('emails.bookingStatusUpdated')
                    ->with([
                        'status' => $this->status,
                        'booking' => $this->booking,
                        'user' => $this->user,
                        'total_days' => $this->total_days,
                        'total_amount' => $this->total_amount,
                    ]);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class DeleteExpiredBookings extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'bookings:delete-expired';

    /**
     * The console command description.
     */
    protected $description = 'Delete approved bookings that have expired after their end_date.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredBookings = Booking::where('status', 'approved')
                                   ->where('end_date', '<', now())
                                   ->get();

        if ($expiredBookings->isEmpty()) {
            $this->info('No expired bookings to delete.');
            return 0;
        }

        foreach ($expiredBookings as $booking) {
            // Log the deletion (optional for debugging)
            Log::info("Deleting expired booking: ID {$booking->id}, Room ID: {$booking->room_id}");
            $booking->delete();
        }

        $this->info('Expired bookings have been deleted.');
        return 0;
    }
}

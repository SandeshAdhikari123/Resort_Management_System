<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use App\Mail\BookingStatusUpdated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class DetailsController extends Controller
{
    public function room_details($id)
    {
     $room= Room::find($id);
     return view ('home.room_details',compact('room'));
    }
    
    public function doBooking(Request $request, $id)
    {
        // Check if the user is logged in
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to book a room.');
        }
    
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|digits:10',
            'startDate' => 'required|date|after_or_equal:today',
            'endDate' => 'required|date|after_or_equal:startDate',
            'payment_mode' => 'required|string|in:cash,khalti',
        ]);
    
        // Retrieve the room from the database
        $room = Room::find($id);
    
        if (!$room) {
            return redirect()->back()->withErrors('Room not found.');
        }
    
        // Calculate the total price
        $startDate = \Carbon\Carbon::parse($request->startDate);
        $endDate = \Carbon\Carbon::parse($request->endDate);
        $daysBooked = $startDate->diffInDays($endDate);
    
        // Ensure that room price is not zero or null
        if ($room->room_price <= 0) {
            return redirect()->back()->withErrors('Invalid room price.');
        }
    
        // Calculate the total price for the booking
        $totalPrice = $daysBooked * $room->room_price;
    
        // Check for overlapping bookings
        $existingBooking = Booking::where('room_id', $id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->startDate, $request->endDate])
                      ->orWhereBetween('end_date', [$request->startDate, $request->endDate])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('start_date', '<=', $request->startDate)
                                ->where('end_date', '>=', $request->endDate);
                      });
            })
            ->exists();
    
        if ($existingBooking) {
            return redirect()->back()->withErrors('The selected dates are already booked.');
        }
    
        // Save the booking
        $booking = new Booking();
        $booking->user_id = auth()->id(); // Associate booking with the logged-in user
        $booking->room_id = $id;
        $booking->name = $request->name;
        $booking->email = $request->email;
        $booking->phone = $request->phone;
        $booking->start_date = $request->startDate;
        $booking->end_date = $request->endDate;
        $booking->payment_mode = $request->input('payment_mode');
        $booking->totalprice = $totalPrice; // Save the calculated total price
        $booking->status = 'Pending'; // Default status
        $booking->save();
    
        return redirect()->back()->with('success', 'Booking successfully created. Wait for approval!');
    }
    


    public function bookedRooms()
    {
    $bookings = Booking::all();
    $rooms = Room::all();
    return view('admin.bookedrooms', compact('bookings', 'rooms'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $status = $request->input('status');
        $booking = Booking::findOrFail($id);
        $user = User::find($booking->user_id);

        if (!in_array($status, ['Pending', 'Approved', 'Rejected'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }
        
        // Update the status of the specific booking
        $booking->status = $status;
        $booking->save();

        // Get all bookings for the user (if you want to send an email for all bookings)
        $userBookings = Booking::where('user_id', $user->id)->get();

        // Send an email for each booking of the user
        foreach ($userBookings as $userBooking) {
            Mail::to($user->email)->send(new BookingStatusUpdated($status, $userBooking, $user));
        }

        if ($status == 'Approved') {
            return redirect()->back()->with('success', 'Booking has been approved.');
        }
        if ($status == 'Rejected') {
            return redirect()->back()->with('success', 'Booking has been cancelled.');
        }
        return redirect()->back()->with('success', 'Booking status updated successfully.');
    }

    public function approvedBookings()
    {
        $approvedBookings = DB::table('bookings')->where('status', 'Approved')->get();
        $rooms = DB::table('rooms')->get();
        return view('admin.approvedBookings', compact('approvedBookings', 'rooms'));
    }

    public function expiredBookings()
    {
        $expiredBookings = Booking::onlyTrashed()->with('room')->get();
        return view('admin.expired-bookings', compact('expiredBookings'));
    }
    
    public function previousBookings($userId)
    {
        $previousBookings = Booking::where('user_id', $userId)->get();
        
        return view('home.bookinghistory', compact('previousBookings'));
    }
}

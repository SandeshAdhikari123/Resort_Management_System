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
        // Get all bookings and rooms
        $bookings = DB::table('bookings')->get();
        $rooms = DB::table('rooms')->get();
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
    
        // Get all bookings for the user
        $userBookings = Booking::where('user_id', $user->id)->get();
    
        // Try to send email notifications
        try {
            foreach ($userBookings as $userBooking) {
                Mail::to($user->email)->send(new BookingStatusUpdated($status, $userBooking, $user));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Booking updated, but failed to send email: ' . $e->getMessage());
        }
    
        // Redirect with success message based on status
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

    public function khalticheck(Request $request, $roomId)
    {
        // Validate Request
        $request->validate([
            'startDate' => 'required|date|after_or_equal:today',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        // Retrieve the room details
        $room = Room::findOrFail($roomId);

        // Parse the start and end dates
        $startDate = \Carbon\Carbon::parse($request->startDate);
        $endDate = \Carbon\Carbon::parse($request->endDate);
        
        // Check for overlapping bookings with status 'approved'
        $existingBooking = Booking::where('room_id', $roomId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $endDate);
                    });
            })
            ->where('status', 'approved') // Ensure the status is 'approved'
            ->exists();

        // If there is an existing approved booking on these dates
        if ($existingBooking) {
            return redirect()->back()->withErrors('The selected dates are already booked.');
        }

        // Calculate the number of days booked
        $daysBooked = $startDate->diffInDays($endDate);

        // Calculate the total price
        $totalPrice = $daysBooked * $room->room_price * 100;

        // Generate payload for Khalti API
        $payload = [
            'return_url' => route('paysuccess', [
                'roomId' => $roomId,
                'startDate' => $request->startDate,
                'endDate' => $request->endDate,
            ]),
            'website_url' => URL('http://localhost'),
            'purchase_order_id' => Auth::id(),
            'purchase_order_name' => "Room Booking: {$room->room_name}",
            'amount' => $totalPrice, 
            'customer_info' => [
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
            ],
        ];

        // Khalti API call
        $url = 'https://a.khalti.com/api/v2/epayment/initiate/';
        $headers = ['Authorization' => 'key 8b25d1ced9a545ba88b320fc0d8730e8'];

        $response = Http::withHeaders($headers)->post($url, $payload);
        $response->throw();

        // Retrieve payment URL from Khalti response
        $data = $response->json();

        // Redirect to the Khalti payment page
        return redirect($data['payment_url']);
    }

    
    public function paySuccess(Request $request)
    {
        $roomId = $request->query('roomId');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $user = Auth::user();
    
        // Clean the dates to remove any query parameters
        $startDate = explode('?', $startDate)[0]; // Get only the date part
        $endDate = explode('?', $endDate)[0]; // Get only the date part
    
        // Check for duplicate bookings
        $existingBooking = Booking::where('user_id', $user->id)
            ->where('room_id', $roomId)
            ->where('start_date', $startDate)
            ->where('end_date', $endDate)
            ->exists();
    
        if ($existingBooking) {
            // Redirect back with a success message if the booking already exists
            return redirect()->route('home.index')->with('status', 'Your booking is already confirmed.');
        }
    
        // Find the room and calculate days booked
        $room = Room::findOrFail($roomId);
        $daysBooked = \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate));
        $totalPrice = $daysBooked * $room->room_price;
    
        // Save Booking in Database
        $booking = new Booking();
        $booking->user_id = $user->id;
        $booking->room_id = $roomId;
        $booking->name = $user->name;
        $booking->email = $user->email;
        $booking->phone = $user->phone;
        $booking->start_date = $startDate;
        $booking->end_date = $endDate;
        $booking->payment_mode = 'khalti';
        $booking->totalprice = $totalPrice;
        $booking->status = 'approved';
        $booking->save();
    
        // Send confirmation email
        Mail::to($user->email)->send(new BookingStatusUpdated('approved', $booking, $user));
    
        return redirect()->route('home.index')->with('status', 'Payment Successful! Your booking is confirmed.');
    }    
    
    public function previousBookings($userId)
    {
        $previousBookings = Booking::where('user_id', $userId)->get();
        
        return view('home.bookinghistory', compact('previousBookings'));
    }
}

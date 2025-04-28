<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\Aboutus;
use App\Models\Banner;
use App\Models\Booking;
use App\Models\Food;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $room = Room::all();
        $banners = Banner::all();
        $about = Aboutus::first();
        $bookings = Booking::all();
    
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;

            if ($usertype == 'admin') {
                return view('admin.index');
            }
            elseif ($usertype == 'staff') {
                return view('admin.index');
            }
            elseif ($usertype == 'user') {
                return view('home.index', compact('room', 'banners', 'about', 'bookings'));
            }
            else {
                return redirect()->back()->with('error', 'Invalid user type.');
            }
        }
        return redirect()->route('login');
    }        
    
    public function add_room()
    {
        return view ('admin.add_room');
    } 
    public function store_room(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'room_name' => 'required|string|max:255',
            'room_description' => 'required|string',
            'room_capacity' => 'required|integer',
            'room_type' => 'required|string',
            'room_price' => 'required|numeric',
            'room_image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Handle the image upload
        if ($request->hasFile('room_image')) {
            $image = $request->file('room_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Generate a unique image name
            $image->move(public_path('images/rooms'), $imageName); // Move the image to the 'images/rooms' folder
        }

        // Create a new room and save the data
        $room = new Room();
        $room->room_name = $request->room_name;
        $room->room_description = $request->room_description;
        $room->room_capacity = $request->room_capacity;
        $room->room_type = $request->room_type;
        $room->room_price = $request->room_price;
        $room->room_image = $imageName;  // Save the image file name to the database
        $room->save();
        return redirect()->back()->with('success', 'Room Added Successfully.');
    
    }
    
    public function view_room()
    {
        $rooms = Room::all(); // Fetch all rooms from the database
        return view('admin.view_room', compact('rooms')); // Pass data to the view
    }

    public function delete_room($id)
    {
        $room = Room::findOrFail($id);

        // Optionally delete the room image if it exists
        if ($room->room_image) {
            unlink(public_path('images/rooms/' . $room->room_image));
        }

        // Delete the room
        $room->delete();

        return redirect()->back()->with('success', 'Room deleted successfully');
    }
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.edit_room', compact('room'));
    }
    // Update the room data in the database
    public function update(Request $request, $id)
    {
        // Validate the input
        $validated = $request->validate([
            'room_name' => 'required|string|max:255',
            'room_description' => 'required|string',
            'room_capacity' => 'required|integer',
            'room_type' => 'required|string',
            'room_price' => 'required|numeric',
            'room_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
        ]);

        $room = Room::findOrFail($id);

        // Update the room data
        $room->room_name = $request->room_name;
        $room->room_description = $request->room_description;
        $room->room_capacity = $request->room_capacity;
        $room->room_type = $request->room_type;
        $room->room_price = $request->room_price;

        // Handle image update (if a new image is uploaded)
        if ($request->hasFile('room_image')) {
            // Delete the old image if exists
            if ($room->room_image) {
                unlink(public_path('images/rooms/' . $room->room_image));
            }

            // Upload the new image
            $image = $request->file('room_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/rooms'), $imageName);
            $room->room_image = $imageName;  // Update the image name in the database
        }

        $room->save();  // Save the updated room data

        return redirect()->back()->with('success', 'Room updated successfully');
    }
    
    // Show staff registration form
    
    public function showRegisterForm()
    {
        return view('admin.register_staff');
    }

    // Handle staff registration
    public function registerStaff(Request $request)
    {
        // Validate the input with custom error messages
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Please enter the staff name.',
            'name.string' => 'The staff name must be a valid text.',
            'name.max' => 'The staff name may not be greater than 255 characters.',

            'email.required' => 'Please enter the staff email.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',

            'phone.required' => 'Please enter the staff phone number.',
            'phone.numeric' => 'The phone number must contain only numbers.',
            'phone.digits' => 'The phone number must be exactly 10 digits.',

            'password.required' => 'Please enter a password.',
            'password.string' => 'The password must be a valid string.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        // Create a new staff user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'usertype' => 'staff', // Set usertype to 'staff'
        ]);

        return redirect()->route('admin.registerStaff')->with('success', 'Staff registered successfully!');
    }

    public function showStaffUsers()
    {
        $staffUsers = User::where('usertype', 'staff')->get();
        return view('admin.staffList', compact('staffUsers'));
    }

    public function deleteStaff($id)
    {
        // Find the user by ID
        $staff = User::findOrFail($id);

        // Check if the user is a staff member
        if ($staff->usertype !== 'staff') {
            return redirect()->route('admin.staffUsers')->with('error', 'User is not a staff member.');
        }

        // Delete the staff member
        $staff->delete();

        // Redirect back with a success message
        return redirect()->route('admin.staffUsers')->with('success', 'Staff member deleted successfully.');
    }
}

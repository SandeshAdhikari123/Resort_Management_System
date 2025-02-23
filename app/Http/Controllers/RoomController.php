<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function show_room()
    {
        $room = Room::all(); // Fetch all rooms from the database
        return view('home.show_room', compact('room')); // Pass the $room variable to the view
    }
}

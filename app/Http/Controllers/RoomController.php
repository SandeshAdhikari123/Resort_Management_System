<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function show_room(Request $request)
    {
        $query = Room::query();
    
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where('room_name', 'like', '%' . $request->search . '%')
                  ->orWhere('room_description', 'like', '%' . $request->search . '%');
        }
    
        // Filter by room_type
        if ($request->has('room_type') && $request->room_type != '') {
            $query->where('room_type', $request->room_type);
        }
    
        // Sorting functionality
        if ($request->has('sort')) {
            if ($request->sort === 'room_type') {
                $query->orderByRaw("FIELD(room_type, 'deluxe', 'standard', 'suite')");
            } elseif (in_array($request->sort, ['room_name', 'room_price', 'created_at'])) {
                $query->orderBy($request->sort, 'asc');
            }
        }
    
        $rooms = $query->get();
    
        return view('home.show_room', compact('rooms'));
    }
}
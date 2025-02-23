<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Aboutus;
use App\Models\Banner;
use App\Models\Food;

class HomeController extends Controller
{
    public function home()
    {
        $room = Room::all();
        $about = Aboutus::first();
        $banners = Banner::all();
        return view('home.index', compact('room', 'about', 'banners'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Room;
use App\Models\FoodOrder;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class FoodController extends Controller
{

    public function index()
    {
        $foods = Food::all();
        return view('admin.food.index', compact('foods'));
    }

    public function create()
    {
        return view('admin.food.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('food_images', 'public');
        }

        Food::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath, 
        ]);

        return redirect()->route('admin.food.index')->with('success', 'Food item added successfully.');
    }

    public function edit($id)
    {
        $food = Food::findOrFail($id);
        return view('admin.food.edit', compact('food'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image
        ]);

        $food = Food::findOrFail($id);

        $imagePath = $food->image;
        if ($request->hasFile('image')) {
            if ($food->image && Storage::exists('public/' . $food->image)) {
                Storage::delete('public/' . $food->image);
            }
            $imagePath = $request->file('image')->store('food_images', 'public');
        }

        $food->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.food.index')->with('success', 'Food item updated successfully.');
    }

    public function destroy($id)
    {
        $food = Food::findOrFail($id);
        if ($food->image && Storage::exists('public/' . $food->image)) {
            Storage::delete('public/' . $food->image);
        }
        $food->delete();

        return redirect()->back()->with('success', 'Successfully deleted!');
    }

    public function show()
    {
        $foods = Food::all();
        $booking = Booking::where('user_id', auth()->id())->latest()->first();
        return view('home.food', compact('foods', 'booking'));
    }

    public function order(Request $request)
    {
        // Get the current time in Asia/Kathmandu timezone
        $now = Carbon::now()->setTimezone('Asia/Kathmandu');
    
        // Get the authenticated user
        $user = Auth::user();
    
        // Check if the user has an approved booking within the current date range
        $booking = Booking::where('user_id', $user->id)
            ->where('status', 'Approved')
            ->whereDate('start_date', '<=', $now) 
            ->whereDate('end_date', '>=', $now)
            ->latest()
            ->first();
    
        if (!$booking) {
            return redirect()->back()->with('error', 'You can only order food if you have an approved room booking.');
        }
    
        // Validate the request
        $request->validate([
            'food_id' => 'required|exists:food,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        // Retrieve the selected food item
        $food = Food::find($request->food_id);
    
        // Calculate the total price (food price * quantity)
        $totalPrice = $food->price * $request->quantity; // Use the 'price' column here
    
        // Create a new food order
        FoodOrder::create([
            'user_id' => $user->id,
            'food_id' => $request->food_id,
            'quantity' => $request->quantity,
            'totalprice' => $totalPrice, // Save the calculated total price
            'status' => 'Pending',
        ]);
    
        return redirect()->back()->with('success', 'Your food order has been placed!');
    }
    
    public function showFoodOrders()
    {
        $foodOrders = FoodOrder::with('food', 'user')->get();
        foreach ($foodOrders as $order) {
            $order->activeBooking = $order->user->bookings()
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();
        }
        return view('admin.food.foodorders', compact('foodOrders'));
    }


    public function FoodStatusUpdate(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'status' => ['required', 'in:Pending,Completed,Cancelled'],
        ]);
    
        // Find the food order
        $foodOrder = FoodOrder::findOrFail($id);
    
        // Update the status
        $foodOrder->status = $request->status;
        $foodOrder->save();
    
        return redirect()->route('admin.food.orders')->with('success', 'Order status updated successfully.');
    }
    public function showCompletedOrders()
    {
        $foodOrders = FoodOrder::with(['food', 'user'])
            ->where('status', 'Completed')
            ->get();
            foreach ($foodOrders as $order) {
                $order->activeBooking = $order->user->bookings()
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->first();
            }
        return view('admin.food.completedorders', compact('foodOrders'));
    }

    public function myFoodOrders()
    {
        $orders = FoodOrder::where('user_id', auth()->id())->get();

        // Pass the orders to the view
        return view('home.myfoodorders', compact('orders'));
    }
}
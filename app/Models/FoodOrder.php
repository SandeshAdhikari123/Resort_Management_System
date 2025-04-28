<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodOrder extends Model
{
    protected $fillable = ['user_id', 'food_id', 'quantity', 'status','totalprice'];
    
    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Correct the booking relationship
    public function booking()
    {
        return $this->belongsToThrough(Booking::class, User::class); // Change to correct relation
    }
}


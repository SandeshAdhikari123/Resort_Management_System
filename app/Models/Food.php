<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    
    protected $fillable = ['name', 'description', 'price','image'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function foodOrders()
    {
        return $this->hasMany(FoodOrder::class);
    }
}

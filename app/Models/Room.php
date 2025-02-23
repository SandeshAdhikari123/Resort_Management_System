<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // Optional: explicitly define the table name if it does not match the model name
    protected $table = 'rooms';

    // Define fillable fields for mass assignment
    protected $fillable = [
        'room_name',
        'room_description',
        'room_capacity',
        'room_type',
        'room_price',
        'room_image',
    ];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'room_id', 'name', 'email', 'phone', 
        'start_date', 'end_date', 'payment_mode', 'status','totalprice',
    ];

    protected $dates = [
        'start_date', 'end_date', 'deleted_at',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


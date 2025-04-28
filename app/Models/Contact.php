<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\DB;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'subject', 'message'];

    /**
     * Boot method to hook into model events.
     */
    protected static function booted()
    {
        static::created(function ($contact) {
            // Begin a transaction
            DB::beginTransaction();

            try {
                // Attempt to send the email
                Mail::to(config('mail.from.address'))->send(new ContactMail($contact));

                // If the email is sent successfully, commit the transaction
                DB::commit();
            } catch (\Exception $e) {
                // If an error occurs (email fails), roll back the transaction
                DB::rollBack();

                // Optionally, log the error
                \Log::error('Email sending failed: ' . $e->getMessage());
            }
        });
    }
}

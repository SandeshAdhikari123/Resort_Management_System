<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class RedirectAfterLogin
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Authenticated  $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        $user = $event->user;

        // Redirect based on usertype
        if ($user->usertype === 'admin' || $user->usertype === 'staff') {
            return redirect()->route('admin.index');
        }

        // Redirect for regular user
        return redirect()->route('home.index');
    }
}
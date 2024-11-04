<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RedirectUserBasedOnRole
{
    public function handleLogin(Login $event)
    {
        $user = Auth::user();
        if ($user->rol == 2) {
            return redirect()->route('profesional.dashboard');
        }
    }

    // public function handleRegistered(Registered $event)
    // {
    //     $user = Auth::user();
    //     if ($user->rol == 2) {
    //         return redirect()->route('profesional.dashboard');
    //     }
    // }
}



<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $this->_registerOrLoginUser($user);

        return redirect()->route('dashboard');
    }

    public function _registerOrLoginUser($data)
    {
        $user = User::where('email', '=', $data->email)->first();
        $name = str_replace(" ", "_", strtolower($data->name));

        if (!$user) {
            $user = new User();
            $user->name = $name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->save();
        }

        Auth::login($user);
    }
}

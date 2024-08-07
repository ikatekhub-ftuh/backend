<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user       = User::where('email', $googleUser->getEmail())->first();

            $data = [
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'password'  => Hash::make(uniqid()),
            ];

            
            if (!$user) {
                $user       = User::create($data);
            }
            
            Auth::login($user, true);

            return response()->json(['token' => $user->createToken('authToken')->accessToken]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to authenticate'], 401);
        }
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                return response()->json(['message' => 'Login successful'], 200);

            }else{
                $newUser = User::updateOrCreate(['email' => $user->email],[
                        'username' => $user->name,
                        'google_id'=> $user->id,
                        'password' => encrypt('bRaKingpOinT1654')
                    ]);

                Auth::login($newUser);

                return response()->json(['message' => 'Registration successful'], 200);
            }

        } catch (Exception $e) {
            dd($e->getMessage());
            return response()->json(['error' => $e], 400);
        }
    }
}
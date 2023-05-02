<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect()->getTargetUrl();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        try {

            $user = Socialite::driver('facebook')->user();

            $finduser = User::where('facebook_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                //return response()->json('Belépés sikeres! Kérjük zárja be ezt az oldalt!', 200);
                return redirect()->away("http://localhost:8080");

            }else{
                $newUser = User::updateOrCreate(['email' => $user->email],[
                        'username' => $user->email,
                        'facebook_id'=> $user->id,
                        'password' => encrypt('bRaKingpOinT1654')
                    ]);

                Auth::login($newUser);

                //return redirect()->intended('dashboard');
                return redirect()->away("http://localhost:8080");
            }

        } catch (Exception $e) {
            dd($e->getMessage());
            return response()->json(['error' => $e], 400);

        }
    }
}
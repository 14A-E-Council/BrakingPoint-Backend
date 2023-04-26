<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Http\Request;
class AuthController extends Controller
{
    use HttpResponses, HasApiTokens;

    function register(RegisterUserRequest $request){
        $request->validated($request->all());

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'balance' => 500,
            'registration_date' => Carbon::now()->toDateString(),
            'level' => 1,
            'rank' => 1,
        ]);

        return $this->success(
            [
                "user" => $user,
                "token" => $user->createToken('API token')->plainTextToken
            ],
            null,
            201);
    }

    function login(LoginUserRequest $request)
    {
        //$request->validated($request->all());

        if (!Auth::attempt($request->only('email','password')))
        {
            return $this->error('', 'Credentials do not match',401);
        }

        $user = Auth::user();

        return $this->success(
            [
                "user" => $user,
                "token" => $user->createToken('API token')->plainTextToken
            ]);
    }

    function logout()
    {
        
        $user = Auth::user();
        if (Auth::user()) {
            $accessToken = Auth::user()->currentAccessToken();
            $accessToken->delete();
            return $this->success(
                null,
                'You have logged out successfully and your token has been removed.'
            );
        } 
        else{
            return $this->error(
                null, 'Error'
            );
        }


        
    }
}

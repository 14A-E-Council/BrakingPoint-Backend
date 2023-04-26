<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;

class UserController extends Controller
{
    use HasApiTokens;

    /**
     * Display everything.
     */
    public function index()
    {
        return User::get();
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|min:1|max:255|unique',
            'last_name' => 'min:1|max:255',
            'first_name' => 'min:1|max:255',
            'email' => 'required|min:1|max:50|unique',
            'password' => 'required|min:1|max:255',
            'balance' => 'required|numeric',
            'registration_date' => 'required|date',
            'preferred_category' => 'min:1|max:255',
            'level' => 'required|numeric',
            'picture_frame' => 'min:1',
            'rank' => 'required|numeric',
            'colour_palette' => 'min:1|max:255',
            'profile_picture' => 'min:1|max:255',
        ],
        $messages= [
            'required' => "A(z) :attribute kötelező mező",
            'date' => "Az dátum nem megfelelő formátumú."]);
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }
        $ticket = User::create($request->all());
        return $ticket;
    }

    /**
     * Display the specified resource.
     */
    public function show(User $id)
    {
        return $id;
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response(null, 204);
    }
}

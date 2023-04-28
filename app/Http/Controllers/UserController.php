<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Image;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    private static $xpConst = 500;


     /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function get(){
        $id = Auth::id();
        $users = DB::table('users')->select('*')->where('userID', $id)->get();
        return view('user.edit', ['users'=>$users]);
    }

    public function showUsers(){
            $users = User::all();
            return response()->json($users);
        }

    public function edit(UserRequest $request, $id) {
            $user = Auth::user();
            $data = $request;//->validated();
            // TODO
            // $id = Auth::id();
            $fields = ['username','first_name','last_name','email','profile_picture','preferred_category','colour_palette',];

            if (User::where('userID', $id)->get('username') != $data['username'] &&
                User::where('username', '=', $data['username'])
                    ->where('userID','!=', $id)
                    ->exists()) {
                return response()->json(['error' => 'Username has already been taken!'], 409);
            }

            if (User::where('userID', $id)->get('email') != $data['email'] &&
                User::where('email', '=', $data['email'])
                    ->where('userID','!=', $id)
                    ->exists()) {
                return response()->json(['error' => 'Email has already been taken!'], 409);
            }

            if($request->hasFile('profile_picture')) {
                $user = Auth::user();
                $profile_picture = $request->profile_picture;
                $filename = $user->username . '.' . $profile_picture->getClientOriginalExtension();
                Image::make($profile_picture)->resize(300, 300)->save(public_path('/uploads/profile_pictures/' .  '.png' ));

                $user->profile_picture = $filename;
                $user->save();

            }


            foreach ($fields as $key => $value) {

                User::where('userID',$id)->update([$value => $data[$value]]);

            }
            $user->save();
            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => $user
            ]);
    }


    public function UserResource($request) {
        return [
            'userID' => $this->userID,
            'username' => $this->username,
            'email' => $this->email,
            'level' => $this->level,
            'picture_frame' => $this->picture_frame,
            'profile_picture' => $this->profile_picture,
        ];
    }

    public function giveUserXP($amount) {
        $user = Auth::user();
        if(!$amount >= 0) {
            $user->xp += $amount;
            $this->checkIfLevelUp();
        }
    }


    private function checkIfLevelUp() {
        $user = Auth::user();
        $neededXp = $this::$xpConst * $user->level;
        if ($user->xp >= $neededXp){
            $user->level++;
            $user->xp = 0;
        }

    }
}

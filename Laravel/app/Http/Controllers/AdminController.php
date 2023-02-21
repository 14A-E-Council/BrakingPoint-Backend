<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserModifyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller{

    public function showAllUsers(){
        if($this->checkIfUserAdmin()){
            $users = User::all();
            return view('test', compact('users'));
        }
        else
            return redirect('/dashboard')->with('message', 'You are not allowed to visit this page');
    }

    public function modifyUser(UserModifyRequest $request){
        if($this->checkIfUserAdmin()){
            $data = $request->validated();
            $id = $request->userID;
            $field = ['username','first_name','last_name'];

            if (User::where('userID', $id)->get('username') != $data['username'] &&
            User::where('username', '=', $data['username'])
                ->where('userID','!=', $id)
                    ->exists()) {
                return redirect('/test')->with('message', 'Username has already been taken!');
                }


            User::where('userID', $id)->update([
                'username' => $request->username,
                'first_name' =>$request->first_name,
                'last_name' => $request->last_name
            ]);

            return redirect('/test')->with('message', "Profile updated successfuly");
        }
        else
            return redirect('/dashboard')->with('message', 'You are not allowed to visit this page');
    }

    private function checkIfUserAdmin() {
        $user = Auth::user();
        if ($user->admin == 1)
            return true;
        else
            return false;
    }
}
?>
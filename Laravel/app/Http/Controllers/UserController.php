<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{

    public function get(){
        $id = Auth::id();
        $users = DB::table('users')->select('*')->where('userID', $id)->get();
        //$users = DB::select('select * from users');
        return view('user.edit', ['users'=>$users]);
    }

    public function edit(UserRequest $request) {
        $data = $request->validated();
        $id = Auth::id();
        $fields = ['username','firstName','lastName','email'];

        if (User::where('userID', $id)->get('username') != $data['username'] && 
            User::where('username', '=', $data['username'])
                ->where('userID','!=', $id)
                ->exists()) {
            return redirect('/edit-profile')->with('message', 'Username has already been taken!');
        }

        
        if (User::where('userID', $id)->get('email') != $data['email'] && 
            User::where('email', '=', $data['email'])
                ->where('userID','!=', $id)
                ->exists()) {
            return redirect('/edit-profile')->with('message', 'Email has already been taken!');
        }

        foreach ($fields as $key => $value) {
            
            User::where('userID',$id)->update([$value => $data[$value]]);
            
        }
        
        return redirect('/edit-profile')->with('message', 'Profile updated successfully');
    }


}

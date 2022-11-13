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
        User::where('userID',$id)->update(['firstName'=> $data['firstName'], 'lastName'=>$data['lastName']]);
        return redirect('/edit-profile')->with('message', 'Profile updated successfully');
    }


}

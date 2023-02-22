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

    public function search(Request $request)
{
        $searchedTerm = $request->searchedTerm;
        $project = User::query();
        if ($searchedTerm) {
            $project->where('username', 'Like', '%' . $searchedTerm  . '%');
        }
        $users= $project->orderBy('userID', 'DESC')->paginate(10);
        return $users->values();
}

    public function showUsers(Request $request){
        if($this->checkIfUserAdmin()){
            if (!$request->searchedTerm)
                $users = User::all();
            else {
                $users = $this->search($request);
            }
            return view('admin', compact('users'));
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
                return redirect('/admin')->with('message', 'Username has already been taken!');
                }


            User::where('userID', $id)->update([
                'username' => $request->username,
                'first_name' =>$request->first_name,
                'last_name' => $request->last_name
            ]);

            return redirect('/admin')->with('message', "Profile updated successfuly");
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
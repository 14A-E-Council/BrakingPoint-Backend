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
            return response()->json(['error' => 'You are not allowed to view this page!'], 401);
    }

    public function modifyOrDeleteUser(UserModifyRequest $request){
        if($this->checkIfUserAdmin()){
            if ($request->input('action') == 'save') {
                $data = $request->validated();
                $id = $request->userID;
                $field = ['username','first_name','last_name'];

                if (User::where('userID', $id)->get('username') != $data['username'] &&
                User::where('username', '=', $data['username'])
                    ->where('userID','!=', $id)
                        ->exists()) {
                    return response()->json(['error' => 'Username has already been taken!'], 409);
                    }


                User::where('userID', $id)->update([
                    'username' => $request->username,
                    'first_name' =>$request->first_name,
                    'last_name' => $request->last_name
                ]);

                return response()->json(['message' => 'Profile updated successfully'], 200);
            }

            if($request->input('action') == 'delete') {
                User::where('userID', $request->userID)->delete();
                return response()->json(['message' => 'Profile deleted successfully'], 200);
            }

            // Ban and unban user
            if($request->input('action') == 'ban') {
                $input = $request->all();
                $user = User::find($input['userID']);
                $user->bans()->create([
                    'expired_at' => '+1 month',
                    'comment'=> 'You have benn banned',
                ]);
                return response()->json(['message' => 'Profile was banned successfully'], 200);
            }
            else
                return response()->json(['error' => 'User has already been banned'], 400);


            if($request->input('action') == 'unban'){
                $input = $request->all();
                $user = User::find($input['userID']);
                $user->unban();
                return response()->json(['message' => 'Profile was unbanned successfully'], 200);
            }
            else
             return response()->json(['error' => 'User has already been unbanned'], 400);
        }
        else
            return response()->json(['error' => 'You are not allowed to view this page!'], 401);
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
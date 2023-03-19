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

    public function edit(UserRequest $request) {
        try {
            $data = $request->validated();
            // TODO
            // $id = Auth::id();
            $id = $request->id;
            $fields = ['username','first_name','last_name','email'];

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
                $profile_picture = $request->file('profile_picture');
                $filename = $user->username . '.' . $profile_picture->getClientOriginalExtension();
                Image::make($profile_picture)->resize(300, 300)->save(public_path('/uploads/profile_pictures/' .  $filename ));

                $user->profile_picture = $filename;
                $user->save();

            }


            foreach ($fields as $key => $value) {

                User::where('userID',$id)->update([$value => $data[$value]]);

            }
            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => $user
            ]);

        } catch (\Exception $e) {
        return response()->json(['error' => 'Update failed!'], 400);
    }

        /*Picture frame changer according to level
        CREATE DEFINER=`root`@`localhost` TRIGGER brakingpoint.ChangePictureFrame
	        BEFORE UPDATE
	        ON brakingpoint.users
	        FOR EACH ROW
                BEGIN
                    IF NEW.level < 50 THEN
                        SET NEW.picture_frame = 'bronze.png';

                    ELSEIF NEW.level >= 50 && NEW.level < 125 THEN
                        SET NEW.picture_frame = 'silver.png';

                    ELSE
                        SET NEW.picture_frame = 'gold.png';
                    END IF;
                END

        +500 balance every week
        CREATE
	        DEFINER = 'root'@'localhost'
            EVENT brakingpoint.UpBalanceEveryWeek
	        ON SCHEDULE EVERY '1' WEEK
	        ON COMPLETION PRESERVE
	        DO
                UPDATE users SET balance = balance + 500;

            ALTER
	        DEFINER = 'root'@'localhost'
            EVENT brakingpoint.UpBalanceEveryWeek
	    ENABLE*/
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

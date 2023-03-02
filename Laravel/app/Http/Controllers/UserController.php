<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Image;



class UserController extends Controller
{
    private static $xpConst = 500;


    public function get(){
        $id = Auth::id();
        $users = DB::table('users')->select('*')->where('userID', $id)->get();
        return view('user.edit', ['users'=>$users]);
    }

    public function edit(UserRequest $request) {
        $data = $request->validated();
        $id = Auth::id();
        $fields = ['username','first_name','last_name','email'];

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


        return redirect('/edit-profile')->with('message', 'Profile updated successfully');
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

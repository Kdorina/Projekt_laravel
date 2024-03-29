<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Validator;
use DB;
use Carbon\Carbon;
use App\Http\Resources\User as UserResource;
use App\Http\Controllers\BaseController as BaseController;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){;

        $authUser = Auth::user();
        $success["token"] = $authUser->createToken("MyAuthApp")->plainTextToken;
        $success["name"] = $authUser->name;
        return $this->sendResponse($success, "Sikeres bejelentkezés.");
    }
    else
    {
      return $this->sendError("Unauthorizd.".["error" => "Hibás adatok"], 401);
    }
    }

    public function register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,
        [
            "buildingName" => "required",
            "name" => "required",
            "email" => "required",
            'date_of_birth' => 'required',
            'gender' => 'required',
            "password" => "required",
            "confirm_password" => "required|same:password"
        ]);

        if($validator->fails())
        {
            return $this->sendError("Error validation", $validator->errors() );
        }

        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        $success ["name"] = $user->name;

        return $this->sendResponse($success, "Sikeres regisztráció.");
    }

    public function logout(Request $request){
        auth("sanctum")->user()->currentAccessToken()->delete();
        return response()->json("sikeres kijelentkezés");
    }



    public function getUsers(){
        return User::all();
        // $user = DB::table("users")->select("id", "name", "email")->get();
        // echo "<pre>";
        // print_r($user);
        // return $this->sendResponse( UserResource::collection($user), "OK");

    }

    public function countUsers(){
        $sum = DB::table('users')->select('id')->count('id');
        return $sum;
    }

    public function userAvgAge(){
        $date = DB::select('SELECT ROUND(AVG(YEAR(CURDATE())-Year(date_of_birth))) as "kor" FROM users');
        return $date;

    }

    public function getWomens(){
        $user = DB::table('users')->where("gender", "nő")->get();
        $women = $user->count('id');

        return $women;
    }
    public function getMens(){
        $user = DB::table('users')->where("gender", "férfi")->get();
        $man = $user->count('id');

        return $man;
    }
    public function getElse(){
        $user = DB::table('users')->where("gender", "egyéb")->get();
        $else = $user->count('id');

        return $else;
    }

    public function allBuilding(){

        $shools = DB::table('users')->select("buildingName")->groupBy("buildingName")->get();
        return $shools;
    }
}


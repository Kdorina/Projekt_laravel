<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
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
        // print_r("Sikeres bejelentkezés");
        return $this->sendResponse($success, "Sikeres bejelentkezés.");
    }
    else 
    {
      return $this->sendError("Unauthorizd.".["error" => "Hibás adatok"], 401);
    }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
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

        $input = $request->all();
        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        $success ["name"] = $user->name;
        // print_r("Sikeres regisztráció");
        return $this->sendResponse($success, "Sikeres regisztráció.");
    }

///ADMIN oldalhoz lekérdezés

    public function getUsers(){
        return User::all();
        // $user = DB::table("users")->select("id", "name", "email")->get();
        // echo "<pre>";
        // print_r($user);
        // return $this->sendResponse( UserResource::collection($user), "OK");

    }
    public function showUsers($id){
        $user = User::find($id);
    
        if( is_null($user)){
            return $this->sendError("Post nem létezik");
        }
        return $this->sendResponse( new UserResource ($user), "Post betöltve" );
    }

    public function countUsers(){
        return User::all();
        // $sum = User::get();
        // $number = $sum->count('id');

        // echo "<pre>";
        // print_r($number);
    }

    public function userAge(){

        $ages = User::get();
        foreach ($ages as $age) {
            $number = $age-> date_of_birth;
            $user_age = Carbon::parse($number)->age;

            // print_r($user_age);
            // ->diff(Carbon::now());
            // ->format();
            // echo "<pre>";
            // print_r($user_age);
        }
    
    }
}


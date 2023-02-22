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
        // print_r("Sikeres regisztráció");
        return $this->sendResponse($success, "Sikeres regisztráció.");

        $token = $user->createToken('sajatToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    public function logout(Request $request){
        auth("sanctum")->user()->currentAccessToken()->delete();
        return response()->json("sikeres kijelentkezés");
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

    public function userAge(Request $request){
        
      
        $b = DB::table('users')->select('date_of_birth')->first();
        print_r($b);


    }

    public function getGenders(){

        // $user = DB::table('users')->where("gender", "nő")->get();
        // $women = $user->count('id');
        // echo "<pre>";
        // print_r($women);
        
        // $user = DB::table('users')->where("gender", "férfi")->get();
        // $man = $user->count('id');
        
        //   echo "<pre>";
        //     print_r($man);

        // $user = DB::table('users')->where("gender", "egyéb")->get();
        // $else = $user->count('id');

        // echo "<pre>";
        // print_r($else);
        
        // echo "<pre>";
        // print_r($allUser);
    }

    public function allBuilding(){
        
        $shools = DB::table('users')->select("buildingName")->groupBy("buildingName")->get();
        return $shools;
    }
}


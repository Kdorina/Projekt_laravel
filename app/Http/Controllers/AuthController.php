<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
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
}


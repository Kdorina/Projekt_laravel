<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use App\Models\Admin;
use App\Http\Resources\Admin as AdminResource;
use App\Http\Controllers\BaseController as BaseController;

class AdminController extends BaseController
{
   
    public function adminLogin(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){;

        $authAdmin = Auth::user();
        $success["token"] = $authAdmin->createToken("MyAuthApp")->plainTextToken;
        $success["name"] = $authAdmin->name;
        // print_r("Sikeres bejelentkezés");
        return $this->sendResponse($success, "Sikeres bejelentkezés.");
    }
    else 
    {
    //   return $this->sendError("Unauthorizd.".["error" => "Hibás adatok"], 401);
    }
    }
    public function adminRegister(Request $request)
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
        $user = Admin::create($input);
        $success ["name"] = $user->name;
        // print_r("Sikeres regisztráció");
        return $this->sendResponse($success, "Sikeres regisztráció.");
    }


}

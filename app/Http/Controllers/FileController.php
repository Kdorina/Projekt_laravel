<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Models\File;
use App\Http\Resources\File as FileResource;

class FileController extends Controller
{
    public function create(){
        $file = File::all();
        return $this->sendResponse("ok");
    }

    public function store(Request $request){
        
        $input = $request->all();
        $validator = Validator::make($input, [

            "file" => "required",
           
        ]);

        if($validator->fails()){
             return $this->sendError($validator->errors());
        
         }

        $file = File::create( $input );
        // print_r("siker");
        return $this->sendResponse(new FileResource( $file), "Post létrehozva");
    }
}

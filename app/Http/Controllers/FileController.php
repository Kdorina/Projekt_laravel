<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Models\File;
use App\Http\Resources\File as FileResource;

class FileController extends Controller
{
    public function index(){
        $file = File::all();
        return $this->sendResponse("ok");
    }

    public function show($id){
        $file = File::find($id);

        if(is_null($file)){
            return $this->sendError($validator->errors());
        }else{
            return $this->sendResponse(new FileResource( $file), "OK");
        }
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
        return $this->sendResponse(new FileResource( $file), "File létrehozva");
    }

    public function update(Request $request){
        $input = $request->all();

        $validator = Validator::make($input, [
            "file"=>"required",
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
       
        }

       $file = File::find( $id );
       // print_r("siker");
       return $this->sendResponse(new FileResource( $file), "File frissítve");
    }

    public function destroy($id){
        File::destroy($id);

        return $this->sendResponse([], "Sikeresen törölve");

    }
}

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
            return $this->sendError("A fájl nem létezik");
        }else{
            return $this->sendResponse(new FileResource( $file), "A fájl létezik");
        }
    }

    public function store(Request $request){
        
        $input = $request->all();
        $validator = Validator::make($input, [

            "file" => "required",
           
        ]);

        if($validator->fails()){
             return $this->sendError($validator,"Fájl létrehozása sikertelen");
        
         }

        $file = File::create( $input );
        // print_r("siker");
        return $this->sendResponse(new FileResource( $file), "Fájl létrehozva");
    }

    public function update(Request $request, $id){
        $input = $request->all();

        $validator = Validator::make($input, [
            "file"=>"required",
        ]);

        if($validator->fails()){
            return $this->sendError($validator, "Hiba! Szerkeztés sikertelen");
       
        }

       $file = File::find( $id );
       $file->update($input);
       // print_r("siker");
       return $this->sendResponse(new FileResource( $file), "Fájl frissítve");
    }

    public function destroy($id){
        
        $file=File::find($id);
        $file->delete();
        return $this->sendResponse(new FileResource($file), "Sikeresen törölve");

    }
}

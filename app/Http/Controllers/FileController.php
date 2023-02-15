<?php

namespace App\Http\Controllers;
use Validator;
use App\Http\Requests\ImageStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\Http\Resources\File as FileResource;
use App\Http\Controllers\BaseController as BaseController;
use Symfony\Component\HttpFoundation\Response;

class FileController extends BaseController
{
    public function index(){
        $image = File::all();
        return $image;
        // return $this->sendResponse("ok");
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
                'description'=> 'required',
                'image'=>'required|mimes:png,jpg,gif,jpeg,pdf'
        ]);

        if($validator->fails()){
            return $this->sendError($validator, "Hiba! sikertelen felvétel");
       
        }
        $file = $request->file('image');
        $name = $file->getClientOriginalName();
        $input = File::create($input);
       // print_r("siker");
    //    return $input;
       return $this->sendResponse(new FileResource( $input), "Fájl hozzáadva");
    }

    public function destroy($id){
        
        $file=File::find($id);
        $file->delete();
        return $this->sendResponse(new FileResource($file), "Sikeresen törölve");

    }
}

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

    public function store(ImageStoreRequest $request){

        
        // $validatedData = $request->validated();
        // $validatedData['image'] = $request->file('image')->store('image');
        // $data = Image::create($validatedData);

        // return response($data, Response::HTTP_CREATED);

        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            // 'user_id' => 'required'
        ]);
        $image_path = $request->file('image')->store('image', 'public');

        $data = Image::create([
            'image' => $image_path,
        ]);

        return response($data, Response::HTTP_CREATED);

    //     $input = $request->all();
    //     $validator = Validator::make($input, [
    //         "image"=>"required"
    //     ]);

    //     if($validator->fails()){
    //         return $this->sendError($validator, "Hiba! sikertelen felvétel");
       
    //     }
    //    $input = File::create($input);
    //    // print_r("siker");
    //    return $input;
    //    return $this->sendResponse(new FileResource( $input), "Fájl hozzáadva");
    }

    public function destroy($id){
        
        $file=File::find($id);
        $file->delete();
        return $this->sendResponse(new FileResource($file), "Sikeresen törölve");

    }
}

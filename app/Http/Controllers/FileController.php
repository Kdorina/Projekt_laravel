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
use DB;
use Illuminate\Support\Facades\Auth;

class FileController extends BaseController
{
    public function index(){
        $file = File::get();
        if(Auth::check()){
          $user_id = Auth::user()->id;
          $file =  DB::table("files")->where(['user_id'=>$user_id])->get();
        }
        return $file;
        return $this->sendResponse( NoteResource::collection($file), "Sikeres elérés" );
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
        if (Auth::check())
        {
            $id = Auth::user()->getId();
        }
        // $image = $request->file("image")->store('public/img');

        // $input = File::create([
        //     'description'=> $request->description,
        //     'image'=> $image,
        //     "user_id"=> $id
        // ]);

    //     $image = $request->file('image');
    //     $imageName = $image->getClientOriginalName();
    //     $image = public_path('images/' . $imageName);

    //      $input = File::create([
    //         // 'description'=> $request->description,
    //         'image'=> $image,
    //         "user_id"=> $id
    //     ]);

    //    return $input;
    $input = $request->all();
    $validator = Validator::make($input, [
      "description"=>"required",
      "image"=>"required"
    ]);

    if($validator->fails()){
      return $this->sendError($validator, "Hiba!, Sikertelen feltöltés");
    }
    $image = $request->file('image');
    $imageName = $image->getClientOriginalName();
    $image = public_path('images/' . $imageName);
    $in = File::create([
        "description"=>$request->description,
      "image"=> $image,
      "user_id"=> $id
    ]);
    
    return $in;
    }

    public function destroy($id){
        
        $file=File::find($id);
        $file->delete();
        return $this->sendResponse(new FileResource($file), "Sikeresen törölve");

    }

    public function countFile(){
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $count = DB::table('files')->where(['user_id'=>$user_id])->select('image')->count();
          
          }

          return $count;
    }
}

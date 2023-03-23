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

        // $input = $request->all();
        // $validator = Validator::make($input, [
        // // "description"=>"required",
        // "imgpath"=>"required"
        // ]);



        if(!$request->hasFile('imgpath') && !$request->file('imgpath')->isValid()){
            return response()->json('{"error":" please add image"}');
        }

            $name = $request->file("imgpath")->getClientOriginalName();
            $path = $request->file('imgpath')->storeAs('images', $name);
            $input = File::create(["imgpath"=>$path, "user_id"=>$id]);

        $input = File::create([
            // "description"=>$request->description,
            "imgpath"=>$path,
            "user_id"=>$id
        ]);

        return $this->sendResponse(new FileResource($input),'sikeres felvétel.');
    }
    
    public function destroy($id){
        
        $file=File::find($id);
        $file->delete();
        return $this->sendResponse(new FileResource($file), "Sikeresen törölve");

    }

    public function countFile(){
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $count = DB::table('files')->where(['user_id'=>$user_id])->select('imgpath')->count();
          
          }

          return $count;
    }
}

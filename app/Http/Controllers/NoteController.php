<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Note as NoteResource;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use Validator;
use DB;

class NoteController extends BaseController
{

    public function index(){
        $note = Note::get();
        if(Auth::check()){
          $user_id = Auth::user()->id;
          $note =  DB::table("notes")->where(['user_id'=>$user_id])->get();
        }
        return $note;
        return $this->sendResponse( NoteResource::collection($note), "Sikeres elérés" );

    }

    public function store(Request $request){
        if (Auth::check())
            {
                $id = Auth::user()->getId();
            }

        $input = $request->all();
        $validator = Validator::make($input , [
            "note"=> "required"
        ]);

        if($validator->fails()){
            return $this->sendError($validator, "Sikertelen feltöltés");
        }

        $input = Note::create([
            "note"=> $request->note,
            "user_id"=> $id
        ]);

        return $this->sendResponse( new NoteResource($input), "Sikeres feltöltés");

    }

    public function destroy($id){
        $note = Note::find($id);
        $note->delete();
        return $this->sendResponse(new NoteResource($note), "Note sikeresen törlöve");
    }

    public function countNotes(){
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $count = DB::table('notes')->where(['user_id'=>$user_id])->select('id')->count();

          }

          return $count;
    }

}

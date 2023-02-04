<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Note as NoteResource;
use App\Models\Note;
use App\Http\Controllers\BaseController as BaseController;
use Validator;

class NoteController extends BaseController
{

    public function index(){
        $note = Note::all();
        return $this->sendResponse( NoteResource::collection($note), "Sikeres elérés" );

    }

    public function store(Request $request){
        $input = $request->all();
        $validator = Validator::make($input , [
            "note"=> "required"
        ]);

        if($validator->fails()){
            return $this->senError($validator, "Sikertelen feltöltés");
        }
        $input = Note::create($input);
        return $this->sendResponse( new NoteResource($input), "sSkeres feltöltés");

    }

    public function destroy($id){
        $note = Note::find($id);
        $note->delete();
        return $this->sendResponse(new NoteResource($note), "Note sikeresen törlöve");
    }

}

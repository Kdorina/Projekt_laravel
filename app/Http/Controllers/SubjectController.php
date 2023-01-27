<?php

namespace App\Http\Controllers;
use Validator;
use DB;
use App\Models\Subject;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\Subject as SubjectResource;

class SubjectController extends BaseController
{
        public function index(){
            $data = Subject::all();
            return $data;
            return $this->sendResponse( SubjectResource::collection($data), "Sikeres");
        }
    
    
        public function store(Request $request){
    
          $input = $request->all();
          $validator = Validator::make($input, [
            "subject"=>"required",
            "grade"=>"required"
          ]);

          if($validator->fails()){
            return $this->sendError($validator, "Hiba!, Sikertelen feltöltés");
          }
          $input = Subject::create($input);
        //   return $input;
          return $this->sendResponse( new SubjectResource($input), "Sikeres feltöltés");
        }


        public function show( $id){
            $subject = Subject::find($id);
    
            if( is_null($subject)){
                return $this->sendError("Tantárgy nem létezik");
            }
            return $this->sendResponse( new SubjectResource ($subject), "Tantárgy betöltve" );

        }
    
        public function update(Request $request, $id){
             $input = $request->all();
    
            $validator = Validator::make($input, [
    
              "subject" => "required",
              "grade" => "required",
            
            ]);
    
            if($validator->fails()){
                return $this-sendError($validator, "Hiba! Szerkeztés sikertelen");
            }
    
            $subject = Subject::find( $id );
            $subject->update( $input);
    
            // return $subject;
            return $this->sendResponse( new SubjectResource ($subject), "Tantárgy frissítve" );

        }
    
        public function destroy($id){
    
            $subject = Subject::find($id);
            $subject->delete();
            return $this->sendResponse(new SubjectResource($subject) , "Tantárgy törölve");

    
        
        }


        public function avarageAllSubject(){
          $sum = DB::table('subjects')->sum('grade');

          $count = DB::table('subjects')->select('grade')->count();

          $arg = $sum/$count;
          return $arg;
        }

        public function avarageOneSubject(Request $request){

          $groupSub = DB::table('subjects')->select("subject")->groupBy("subject")->get();
          // echo $groupSub;

          $input= $request->subject;
          $all =  DB::table('subjects')->where("subject", $input)->sum("grade");
          echo $all;

        }
    }
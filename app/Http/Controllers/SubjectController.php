<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\Subject;

use Illuminate\Http\Request;
// use App\Http\Controllers\BaseController;
use App\Http\Resources\Subject as SubjectResource;

class SubjectController extends BaseController
{
        public function index(){
            $subject = Subject::all();
            return $this->sendResponse( SubjectResource::collection($subject), "OK");
        }
    
    
        public function store(Request $request){
    
            $input = $request->all();
            $validator = Validator::make($input, [
    
                "subject" => "required",
               
            ]);
    
            if($validator->fails()){
                 return $this->sendError($validator->errors());
            
             }
    
            $subject = Subject::create( $input );
            // print_r("siker");
            return $this->sendResponse(new SubjectResource( $subject), "Post létrehozva");
        }
        public function show( $id){
            $subject = Subject::find($id);
    
            if( is_null($subject)){
                return $this->sendError("Post nem létezik");
            }
            return $this->sendResponse( new SubjectResource ($subject), "Post betöltve" );
        }
    
        public function update(Request $request, $id){
            $input = $request->all();
    
            $validator = Validator::make($input, [
    
                "subject" => "required",
                
    
            ]);
    
            if($validator->fails()){
                return $this-sendError($validator->errors());
            }
    
            $subject = Subject::find( $id );
            $subject->update( $request->all());
    
    
            return $this->sendResponse( new SubjectResource ($subject), "Post frissítve" );
        }
    
        public function destroy($id){
    
            Subject::destroy($id);
            return $this->sendResponse([], "Post törölve");
        }
    }
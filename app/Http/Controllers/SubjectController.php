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
            return Subject::all();
            // $subject = Subject::all();
            // return $this->sendResponse( SubjectResource::collection($subject), "OK");
        }
    
    
        public function store(Request $request){
    
            return Subject::create($request->all());
        //     $input = $request->all();
        //     $validator = Validator::make($input, [
    
        //         "subject" => "required",
               
        //     ]);
    
        //     if($validator->fails()){
        //          return $this->sendError($validator->errors());
            
        //      }
    
        //     $subject = Subject::create( $input );
        //     // print_r("siker");
        //     return $this->sendResponse(new SubjectResource( $subject), "Tantárgy létrehozva");
        
        }
        public function show( $id){
            // $subject = Subject::find($id);
    
            // if( is_null($subject)){
            //     return $this->sendError("Tantárgy nem létezik");
            // }
            // return $this->sendResponse( new SubjectResource ($subject), "Tantárgy betöltve" );

            return Subject::find($id);
        }
    
        public function update(Request $request, $id){
            // $input = $request->all();
    
            // $validator = Validator::make($input, [
    
            //     "subject" => "required",
                
    
            // ]);
    
            // if($validator->fails()){
            //     return $this-sendError($validator->errors());
            // }
    
            // $subject = Subject::find( $id );
            // $subject->update( $request->all());
    
    
            // return $this->sendResponse( new SubjectResource ($subject), "Tantárgy frissítve" );

            if(Subject::where('id', $id)->exists()){
                $subject = Subject::find($id);
                $subject->subject = $request->subject;
    
                $subject->save();
    
                return response()->json([
                    'message' => "Sikeres adatrögzítés"
                ], 200);
    
            }else{
                return response()->json([
                    'message' => "Sikertelen adatrögzítés"
                ], 404);
            
            }


        }
    
        public function destroy($id){
    
            // Subject::destroy($id);
            // return $this->sendResponse([], "Tantárgy törölve");

            if(Subject::where('id', $id)->exists()){
                $subject = Subject::find($id);
                $subject->delete();
    
                // $subject->save();
    
                return response()->json([
                    'message' => "Sikeres törlés"
                ], 200);
    
            }else{
                return response()->json([
                    'message' => "Sikertelen törlés"
                ], 404);
            
            }
        
        }
    }
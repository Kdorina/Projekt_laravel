<?php

namespace App\Http\Controllers;
use Validator;
use DB;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\Subject as SubjectResource;

class SubjectController extends BaseController
{
        public function index(){
          $subject = Subject::get();
          if(Auth::check()){
            $user_id = Auth::user()->id;
            $subject =  DB::table("subjects")->where(['user_id'=>$user_id])->get();
          }
          return $subject;
          return $this->sendResponse( SubjectResource::collection($subject), "Sikeres elérés");
        }

        public function store(Request $request){

          if (Auth::check())
            {
                $id = Auth::user()->getId();
            }

          $input = $request->all();
          $validator = Validator::make($input, [
            "subject"=>"required",
            "grade"=>"required"
          ]);

          if($validator->fails()){
            return $this->sendError($validator, "Hiba!, Sikertelen felvétel");
          }

          $sub = Subject::create([
            "subject"=> $request->subject,
            "grade"=> $request->grade,
            "user_id"=> $id
          ]);

          return $this->sendResponse( new SubjectResource($sub), "Sikeres felvétel");
        }


        public function update(Request $request, $id){
             $input = $request->all();
            $validator = Validator::make($input, [

              "subject" => "required",
              "grade" => "required",

            ]);

            if($validator->fails()){
                return $this->sendError($validator, "Hiba! Szerkeztés sikertelen");
            }

            $subject = Subject::find( $id );
            $subject->update( $input);

            return $this->sendResponse( new SubjectResource ($subject), "Tantárgy frissítve" );

        }

        public function destroy($id){

            $subject = Subject::find($id);
            $subject->delete();
            return $this->sendResponse(new SubjectResource($subject) , "Tantárgy törölve");

        }

        public function avarageAllSubject(){
          if(Auth::check()){
            $user_id = Auth::user()->id;
            $sum = DB::table('subjects')->where(['user_id'=>$user_id])->sum('grade');
            $count = DB::table('subjects')->where(['user_id'=>$user_id])->select('grade')->count();
            $arg = round($sum/$count, 2);
          }

          return $arg;
        }

        public function mySubject(){
          if(Auth::check()){
            $user_id = Auth::user()->id;
            $groupSub = DB::table('subjects')->where(["user_id"=> $user_id])->select('subject')->groupBy("subject")->get();
          }
          return $groupSub;

        }

        public function avgGradeFromAddSubjects(){
          if(Auth::check()){
            $user_id = Auth::user()->id;
            // $avg = DB::select('SELECT subject,sum(grade)/count(subject), user_id
            // FROM subjects GROUP BY user_id, subject ORDER BY sum(grade), count(subject) ');

            $avg = DB::table('subjects')->where(["user_id"=> $user_id])->
            select('user_id', 'subject',DB::raw('(sum(grade)/count(subject))as atlag, count(subject) as jegydb'))->
            groupBy('user_id','subject')->get();
          }
          return $avg;
        }

        public function usersSubjectsShow(){
          $subject = Subject::get();
        /*   $s = DB::select('SELECT count(subject), user_id FROM `subjects` GROUP BY subject, user_id ORDER BY user_id ' ); */
          $count = DB::table('subjects')->select('subject', 'user_id')->groupBy('subject', 'user_id')->orderBy('user_id')->get();
          // return $s;
          return $count;
        }
    }

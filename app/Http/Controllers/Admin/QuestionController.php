<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Classes;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Session;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam;
class QuestionController extends Controller
{
    public function Index($grade_id){
        $questions=Question::with('subject')->get()->toArray();
        // dd($questions);
        $classes=Classes::get()->toArray();
        // dd($classes);
        $teacher_exam=Admin::with('exam')->where('id', Auth::guard('admin')->user()->id)->first()->toArray();
        // dd($teacher_exam);
        $teachers=Admin::where('role', 0)->get()->toArray();
        $subjects=Subject::get()->toArray();
        Session::put('page', $grade_id);
        // $grades=Grade::with('class')->get()->toArray();
        // dd($grades);
        return View('admin.questions.index', compact('questions', 'teachers', 'subjects', 'grade_id', 'classes', 'teacher_exam'));
    }
    public function addQuestion(Request $request, $grade_id){
        // dd(Session::get('grade_id'));
        if($request->isMethod('post')){
            $data=$request->all();
            $data['answer']=implode(',',$data['answer']);
            $data['correct_answer']=implode(',',$data['correct_answer']);
            $data['exam_id']=0;

            $data['teacher_id']=Auth::guard('admin')->user()->id;
            $data['subject_id']=Auth::guard('admin')->user()->subject_id;
            Question::create($data);
            return redirect('/admin/questions/grade/'.$grade_id)->with('success_message', 'Created Question Successfully');
        }
        return View('admin.questions.add', compact('grade_id'));
    }
    public function editQuestion(Request $request, $id, $grade_id){
        // dd(Session::get('grade_id'));
        $question=Question::find($id);
        // dd($question);
        if($request->isMethod('post')){

            $data=$request->all();
            if($question['teacher_id']==Auth::guard('admin')->user()->id){
            $data['answer']=implode(',',$data['answer']);
            $data['correct_answer']=implode(',',$data['correct_answer']);
            $data['exam_id']=0;

            $data['teacher_id']=Auth::guard('admin')->user()->id;
            $data['subject_id']=Auth::guard('admin')->user()->subject_id;
            // Question::create($data);
            $question->update($data);
            return redirect('/admin/questions/grade/'.$grade_id)->with('success_message', 'Updated Question Successfully');
            }else{
                return redirect()->back()->with('error_message', 'You can not edit this question');
            }
        }
        return View('admin.questions.edit', compact('id', 'grade_id', 'question'));
    }
    public function choseQuestion(Request $request){
        if($request->ajax()){
            $data=$request->all();
            // ($data);
            $data['examid']=$data['examid'].",";
            Question::whereIn('id', explode(",",$data['ids']))->whereIn('subject_id', explode(",",$data['subs']))->update(['select_id'=>$data['examid']]);
            return response()->json(['status'=>true]);
            // return redirect()->back();
        }
    }
}

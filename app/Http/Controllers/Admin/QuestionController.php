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
use App\Models\Answer;

class QuestionController extends Controller
{
    public function Index($subject_id, $grade_id)
    {
        $questions = Question::with('subject')->where('subject_id', $subject_id)->where('grade_id', $grade_id)->get()->toArray();
        // dd($questions);
        $classes = Classes::get()->toArray();
        // dd($classes);
        $teacher_exam = Admin::with('exam')->where('id', Auth::guard('admin')->user()->id)->first()->toArray();
        // dd($teacher_exam);
        $teachers = Admin::where('role', 0)->orWhere('role', -1)->get()->toArray();
        $subjects = Subject::get()->toArray();
        Session::put('page', $grade_id);
        // $grades=Grade::with('class')->get()->toArray();
        // dd($grades);
        return View('admin.questions.index_question', compact('questions', 'subject_id', 'teachers', 'subjects', 'grade_id', 'classes', 'teacher_exam'));
    }
    public function addQuestion(Request $request, $subject_id, $grade_id)
    {
        // dd(Session::get('grade_id'));
        if ($request->isMethod('post')) {
            $data = $request->all();

            // $data['exam_id']=0;
            $data['grade_id']=$grade_id;
            $data['teacher_id'] = Auth::guard('admin')->user()->id;
            $data['subject_id'] = Auth::guard('admin')->user()->subject_id;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $reimage = 'imgckeditor/' . time() . '.' . $image->getClientOriginalExtension();
                $dest = public_path('/imgckeditor');
                $image->move($dest, $reimage);
                $data['image'] = $reimage;
                Question::create($data);
            } else {
                Question::create($data);
            }
            return redirect('/admin/questions/subject/' . $subject_id . '/grade/' . $grade_id)->with('success_message', 'Created Question Successfully');
        }
        return View('admin.questions.add_question', compact('grade_id', 'subject_id'));
    }
    public function editQuestion(Request $request, $question_id, $subject_id, $grade_id)
    {
        // dd(Session::get('grade_id'));
        $question = Question::find($question_id);
        // dd($question);
        if ($request->isMethod('post')) {

            $data = $request->all();
            if ($question['teacher_id'] == Auth::guard('admin')->user()->id) {

                // $data['exam_id']=0;

                $data['teacher_id'] = Auth::guard('admin')->user()->id;
                $data['subject_id'] = Auth::guard('admin')->user()->subject_id;
                // Question::create($data);
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $reimage = 'imgckeditor/' . time() . '.' . $image->getClientOriginalExtension();
                    $dest = public_path('/imgckeditor');
                    $image->move($dest, $reimage);
                    $data['image'] = $reimage;
                    $question->update($data);
                } else {
                    $question->update($data);
                }
                return redirect('/admin/questions/subject/' . $subject_id . '/grade/' . $grade_id)->with('success_message', 'Updated Question Successfully');
            } else {
                return redirect()->back()->with('error_message', 'You can not edit this question');
            }
        }
        return View('admin.questions.edit_question', compact('question_id', 'subject_id', 'grade_id', 'question'));
    }
    public function chooseQuestion(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // $data['exam_id']+=$data['exam_id'].",";
            $questions=Question::whereIn('id', explode(",", $data['allquestion_ids']))->get();
            foreach($questions as $question){
                $question->update(['select_id'=>($question['select_id'].','.$data['exam_id'])]);
            }
            // dd($xxx);
            // dd($data['exam_id']);
            // Question::whereIn('id', explode(",", $data['allquestion_ids']))->update(['select_id'=>$data['exam_id']]);
            return response()->json(['status'=>true]);
            // return redirect()->back();
        }
    }
    public function randomQuestion(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            dd($data);
        }
    }
    public function subjectGrade(Request $request, $grade_id)
    {
        $subjects=Subject::get()->toArray();
        // dd($subjects);
        Session::put('page',$grade_id);
        return View('admin.questions.index_subject', compact('subjects', 'grade_id'));
    }
    public function DeleteAll(Request $request){
        if($request->ajax()){
            $data=$request->all();
            Question::whereIn('id', explode(",",$data['ids']))->delete();
            return response()->json(['status'=>true]);
        }
        return redirect()->back()->with('success_message', 'Deleted Questions Successfully');
    }
}

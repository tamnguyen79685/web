<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class QuestionExamController extends Controller
{
    public function Index(Request $request, $id)
    {
        $questions = Question::with('subject')->get()->toArray();
        // dd($questions[0]['question']);
        // $examid = $id;
        // dd($questions);
        if ($request->isMethod('post')) {
        }
        return View('admin.questionexam.index', compact('questions', 'id'));
    }
    public function StatusQuestion(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                Question::find($data['id'])->update(['status' => 0]);
                return response()->json(['status' => "Active"]);
            } else {
                Question::find($data['id'])->update(['status' => 1]);
                return response()->json(['status' => "Inactive"]);
            }
            // return response()->json(['status'=>true]);
        }
    }
    public function DeleteAll(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            Question::whereIn('id', explode(",", $data['ids']))->delete();
            return response()->json(['status' => true]);
        }
        return redirect()->back()->with('success_message', 'Deleted Questions Successfully');
    }
    public function addQuestion(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $data=$request->all();
            $data['answer']=implode(',',$data['answer']);
            $data['correct_answer']=implode(',',$data['correct_answer']);
            $data['exam_id']=$id;
            $data['teacher_id']=Auth::guard('admin')->user()->id;
            $data['subject_id']=Auth::guard('admin')->user()->subject_id;
            Question::create($data);
            return redirect('/admin/questions/exam/'.$id)->with('success_message', 'Created Question Exam Successfully');
        }
        return View('admin.questionexam.add', compact('id'));
    }
    public function editQuestion(Request $request, $question_id, $id){
        $question=Question::where('id', $question_id)->where('exam_id', $id)->first();
        // dd($question);
        $count=count(explode(",",$question['answer']));
        if($request->isMethod('POST')){
            $data=$request->all();
            $data['answer']=implode(',',$data['answer']);
            $data['correct_answer']=implode(',',$data['correct_answer']);
            $data['teacher_id']=Auth::guard('admin')->user()->id;
            $data['subject_id']=Auth::guard('admin')->user()->subject_id;
            $question->update($data);
            return redirect('/admin/questions/exam/'.$id)->with('success_message', 'Updated Question Exam Successfully');
        }
        return View('admin.questionexam.edit', compact('question', 'question_id', 'id', 'count'));
    }
    public function DeleteQuestion(Request $request, $id){
        $question=Question::where('teacher_id', Auth::guard('admin')->user()->id)->find($id);
        if(!empty($question)){
            $question->delete();
            return redirect()->back()->with('success_message', 'Deleted Question Successfully');
        }else{
            return redirect()->back()->with('error_message', 'You can not delete this question');
        }
    }

}

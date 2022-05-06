<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class QuestionExamController extends Controller
{
    public function Index(Request $request,$grade_id, $id)
    {
        // $questions = Question::with('subject')->get()->toArray();
        // dd($questions[0]['question']);
        // $examid = $id;
        // dd($questions);
        $questions=Question::get()->toArray();
        // dd($questions);
        return View('admin.questionexam.index_question', compact('questions','grade_id', 'id'));
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
        return redirect()->back()->with('success_message', 'Deleted Questions Exam Successfully');
    }

    public function addQuestion(Request $request, $grade_id, $id)
    {
        // dd(Question::orderBy('id', 'desc')->first()->id)
        // Session::put('count', $request->count);
        // dd(Exam::find($id)->with('question')->get()->toArray());
        if ($request->isMethod('POST')) {
            $data = $request->all();
            $data['grade_id']=$grade_id;
            $data['exam_id'] = $id;
            $data['teacher_id'] = Auth::guard('admin')->user()->id;
            $data['subject_id'] = Auth::guard('admin')->user()->subject_id;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $reimage = 'imgckeditor/'.time() . '.' . $image->getClientOriginalExtension();
                $dest = public_path('/imgckeditor');
                $image->move($dest, $reimage);
                $data['image']=$reimage;
                Question::create($data);
            }else{
                Question::create($data);
            }
            return redirect('/admin/questions/grade/'.$grade_id.'/exam/' . $id)->with('success_message', 'Created question successfully');
        }

        return View('admin.questionexam.add_question', compact('id', 'grade_id'));
    }
    public function editQuestion(Request $request, $question_id,$grade_id, $id)
    {
        $question = Question::find($question_id);
        // $data_answers=$question->answer()->get()->toArray();
        // $answers=Question::find($question_id);
        // dd($answers->answer()->get());
        if ($request->isMethod('POST')) {
            $data = $request->all();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $reimage = 'imgckeditor/'.time() . '.' . $image->getClientOriginalExtension();
                $dest = public_path('/imgckeditor');
                $image->move($dest, $reimage);
                $data['image']=$reimage;
               $question->update($data);
            }else{
               $question->update($data);
            }
            return redirect('/admin/questions/grade/'.$grade_id.'/exam/' . $id)->with('success_message', 'Updated question successfully');
            // dd($data);

            // $question->update($data);

            // return redirect('/admin/questions/exam/'.$id)->with('success_message', 'Updated Question Exam Successfully');
        }
        return View('admin.questionexam.edit_question', compact('question', 'question_id', 'id','grade_id'));
    }
    // public function DeleteQuestion(Request $request, $id)
    // {

    //     Question::find($id)->delete();
    //     return redirect()->back()->with('success_message', 'Deleted Question Successfully');

    // }
    public function updateQuestion(Request $request){
        if($request->ajax()){
            $data=$request->all();
            $question=Question::find($data['recordid']);
            $stack=array();
            foreach(explode(",",$question['select_id']) as $select_id){
                if($select_id!=$data['examid']) array_push($stack, $select_id);
            }

            Question::find($data['recordid'])->update(['exam_id'=>0, 'select_id'=>join(",",$stack)]);

            return response()->json(['status'=>true]);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
class ExamController extends Controller
{
    public function Index()
    {
        // $teacher=Admin::find(Auth::guard('admin')->user()->id)->with('subject');
        // dd($teacher);
        $exams = Exam::get()->toArray();
        $subjects = Subject::with('teacher')->first()->toArray();
        $classes= Classes::get()->toArray();
        // dd(explode(",",$subjects['teacher'][0]['class_id']));

        return View('admin.exams.index', compact('exams', 'subjects', 'classes'));
    }
    public function addExam(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Exam::create($data);
            return redirect()->back()->with('success_message', 'Created exam successfully');
        }
    }
    public function editExam(Request $request, $id)
    {
        $exam = Exam::find($id);

        $data = $request->all();
        $exam->update($data);
        return redirect()->back()->with('success_message', 'Updated exam successfully');

        // return View('admin.exams.index', compact('examedit'));
    }
    public function deleteExam($id) {
        Exam::find($id)->delete();
        return redirect()->back()->with('success_message', 'Deleted exam successfully');
    }
    public function indexQuestionExam(Request $request){
        if($request->isMethod('post')){

        }
        return View('admin.questionexam.index');
    }
}

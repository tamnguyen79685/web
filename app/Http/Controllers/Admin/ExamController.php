<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Admin;
use App\Models\Grade;
use App\Models\Question;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Carbon;
class ExamController extends Controller
{
    public function Index()
    {
        // $teacher=Admin::find(Auth::guard('admin')->user()->id)->with('subject');
        // dd($teacher);
        Session::put('page', 'exam');
        $exams = Exam::where('teacher_id', Auth::guard('admin')->user()->id)->get()->toArray();
        $subjects = Subject::get()->toArray();
        $classes = Classes::get()->toArray();
        $grades=Grade::get()->toArray();
        $teacher=Admin::find(Auth::guard('admin')->user()->id);
        $teacher_classes=explode(",", $teacher['class_id']);
        // dd($teacher_classes);
        // dd($subjects);
        // $exam_classes=explode(",", $['class_id']);
        return View('admin.exams.index', compact('exams', 'teacher', 'classes', 'subjects', 'teacher_classes', 'grades'));
    }
    public function addExam(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // Session::put('password', $data['password']);
            $data['password']=Hash::make($data['password']);
            $data['subject_id']=Auth::guard('admin')->user()->subject_id;
            $data['class_id']=implode(",",$data['class_id']);
            Exam::create($data);
            return redirect()->back()->with('success_message', 'Created exam successfully');
        }
    }
    public function editExam(Request $request, $id)
    {
        $exam = Exam::find($id);
        if ($request->isMethod('post')) {
            $data = $request->all();
            Session::put('password', $data['password']);
            // password_
            $data['password']=Hash::make($data['password']);
            $data['subject_id']=Auth::guard('admin')->user()->subject_id;
            $data['class_id']=implode(",",$data['class_id']);

            $exam->update($data);

        }
        return redirect()->back()->with('success_message', 'Updated exam successfully');
        // return View('admin.exams.index', compact('examedit'));
    }
    public function deleteExam($id) {
        Exam::find($id)->delete();
        return redirect()->back()->with('success_message', 'Deleted exam successfully');
    }

    public function StatusExam(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                Exam::find($data['id'])->update(['status' => 0]);
                return response()->json(['status' => "Active"]);
            } else {
                Exam::find($data['id'])->update(['status' => 1]);
                return response()->json(['status' => "Inactive"]);
            }
            // return response()->json(['status'=>true]);
        }
    }
    public function DeleteAll(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            Exam::whereIn('id', explode(",", $data['ids']))->delete();
            return response()->json(['status' => true]);
        }
        return redirect()->back()->with('success_message', 'Deleted Exams Successfully');
    }

}

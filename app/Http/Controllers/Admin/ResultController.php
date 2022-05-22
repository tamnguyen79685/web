<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Result;
use App\Models\Classes;
use App\Models\Grade;
use Illuminate\Support\Facades\Session;
class ResultController extends Controller
{
    public function Index(){
        Session::put('page', 'result');
        // $exams=Exam::where('teacher_id', Auth::guard('admin')->user()->id)->get()->toArray();
        $classes=Classes::get()->toArray();
        $grades=Grade::get()->toArray();
        // dd($exams);
        return View('admin.result.index_class', compact('classes', 'grades'));
    }
    public function ResultStudentExam(Request $request, $exam_id, $class_id){
        $results=Result::where('exam_id', $exam_id)->where('class_id', $class_id)->orderBy('score', 'Desc')->get()->toArray();
        $students=Student::get()->toArray();
        $classes=Classes::get()->toArray();
        return View('admin.result.index_result', compact('results', 'students', 'classes'));
    }

    public function ResultExamClass(Request $request, $class_id){
        $exams=Exam::where('teacher_id', Auth::guard('admin')->user()->id)->get()->toArray();
        return View('admin.result.index_exam', compact('exams', 'class_id'));
    }
}

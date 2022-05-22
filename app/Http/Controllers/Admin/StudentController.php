<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use App\Models\Grade;
use Illuminate\Support\Facades\Session;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Exports\StudentExport;
use Illuminate\Support\Facades\DB;
function normalize($string){
    $string=preg_replace('!\s+!', ' ', $string);;
    $string=mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
    // $string=preg_replace('/[^A-Za-z0-9\-]/', ' ', $string);
    return $string;
}
class StudentController extends Controller
{
    public function Index()
    {
        Session::put('page', 'student');

        if(Auth::guard('admin')->user()->role==1){
            $students = Student::get()->toArray();
        }else{
            $students=Student::whereIn('class_id', explode(",",Auth::guard('admin')->user()->class_id))->get()->toArray();
        }
        $classes = Classes::get()->toArray();
        $grades = Grade::get()->toArray();
        return View('admin.students.index', compact('students', 'classes', 'grades'));
    }
    public function deleteStudent($id){
        Student::find($id)->delete();
        return redirect()->back()->with('success_message', 'Deleted Student Successfully');
    }
    public function addStudent(Request $request)
    {
        $grades = Grade::get()->toArray();
        // dd($grades[0]['classes']);
        if(Auth::guard('admin')->user()->role==1){
            $classes=Classes::get()->toArray();
        }else{
            $classes = Classes::whereIn('id', explode(",", Auth::guard('admin')->user()->class_id))->get()->toArray();
        }
        // dd(Student::orderBy('id', 'desc')->first());
        if ($request->isMethod('post')) {
            $data = $request->all();
            // $data['role'] = 0;
            $data['name']=normalize($data['name']);
            $data['password'] = Hash::make($data['password']);
            $data['year']=date('Y', strtotime($data['year_admission']));

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                // dd($image);
                $reimage = 'imgstudent/' . time() . '.' . $image->getClientOriginalExtension();
                $dest = public_path('/imgstudent');
                $image->move($dest, $reimage);
                $data['image'] = $reimage;
                Student::create($data);
                $student=Student::orderBy('id', 'desc')->first();
                $student->update(['student_code'=>($student['year'].str_pad(Student::where('year', $student['year'])->count(),3,'0',STR_PAD_LEFT))]);
                return redirect('/admin/students')->with('success_message', 'Created Student Successfully');
            }else{

                Student::create($data);
                $student=Student::orderBy('id', 'desc')->first();
                $student->update(['student_code'=>($student['year'].str_pad(Student::where('year', $student['year'])->count(),3,'0',STR_PAD_LEFT))]);
                // Student::find()
                return redirect('/admin/students')->with('success_message', 'Created Student Successfully');
            }
        }
        return View('admin.students.add', compact('classes', 'grades'));
    }
    public function editStudent(Request $request, $id)
    {
        $student = Student::find($id);
        // dd($teacher);
        if(Auth::guard('admin')->user()->role==1){
            $classes=Classes::get()->toArray();
        }else{
            $classes = Classes::whereIn('id', explode(",", Auth::guard('admin')->user()->class_id))->get()->toArray();
        }
        $grades = Grade::get()->toArray();
        // foreach($grades as $grade){
        //     $gradeids[]=$grade['id'];
        // }
        // foreach($classes as $class){
        //     $classids[]=$class['id'];
        // }
        // dd($classids);
        if ($request->isMethod('POST')) {
            $data = $request->all();
            // $data['role']=0;
            $data['name']=normalize($data['name']);
            $data['password'] = Hash::make($data['password']);
            $data['year']=date('Y', strtotime($data['year_admission']));
            if($student['year']!=$data['year']){
                $data['student_code']=$student['year'].str_pad(Student::where('year', $student['year'])->count(),3,'0',STR_PAD_LEFT);
            }
            // $data['email'] = date('Y', strtotime($data['year_admission'])) . $id . '@com';
            // $data['password'] = $student['password'];
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $reimage = 'imgstudent/' . time() . '.' . $image->getClientOriginalExtension();
                $dest = public_path('/imgstudent');
                $image->move($dest, $reimage);
                $data['image'] = $reimage;
                $student->update($data);
                return redirect('/admin/students')->with('success_message', 'Updated Student Successfully');
            } else {
                $student->update($data);
                return redirect('/admin/students')->with('success_message', 'Updated Student Successfully');
            }
        }
        return View('admin.students.edit', compact('student', 'classes', 'grades'));
    }
    public function DeleteAll(Request $request)
    {
        $data = $request->all();

            if ($request->ajax()) {
                $data = $request->all();
                Student::whereIn('id', explode(",", $data['ids']))->delete();
                return response()->json(['status' => true]);
            }
            return redirect()->back()->with('success_message', 'Deleted Student Successfully');

    }
    public function StatusStudent(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                Student::find($data['id'])->update(['status' => 0]);
                return response()->json(['status' => "Active"]);
            } else {
                Student::find($data['id'])->update(['status' => 1]);
                return response()->json(['status' => "Inactive"]);
            }
            // return response()->json(['status'=>true]);
        }
    }
    public function AppendClass(Request $request){
        if($request->isMethod('post')){
            if($request->ajax()){
                $data=$request->all();
                // dd($data);
                // print_r($data);
                if(Auth::guard('admin')->user()->role==1){
                    $getgrades=Classes::where('grade_id', $data['grade_id'])->get()->toArray();
                }else{
                    $getgrades=Classes::where('grade_id', $data['grade_id'])->whereIn('id', explode(",", Auth::guard('admin')->user()->class_id))->get()->toArray();
                }
                // dd($getgrades);
                return response()->json(['getgrades'=>$getgrades]);
            }
        }
        // dd($getgrades);
        // return View('admin.students.append_classes', compact('getgrades'));
    }
    public function ImportFileStudent(Request $request){
        if($request->isMethod('post')){
            // $request->validate(
            //     [
            //         'file'=>'required|mimes:xls, xlsx',
            //     ]
            // );

            Excel::import(new StudentImport,request()->file('file'));
            return redirect('/admin/students')->with('success_message', 'Created Students Successfully');
        }
        return View('admin.students.add_file_student');
    }
    public function ExportFileStudent(Request $request){
        return Excel::download(new StudentExport, 'students.xlsx');
    }
}

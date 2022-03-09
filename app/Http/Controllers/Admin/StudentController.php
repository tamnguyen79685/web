<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use App\Models\Grade;

class StudentController extends Controller
{
    public function Index()
    {
        $students = Student::get()->toArray();
        $classes = Classes::get()->toArray();
        $grades = Grade::get()->toArray();
        return View('admin.students.index', compact('students', 'classes', 'grades'));
    }
    public function addStudent(Request $request)
    {
        $grades = Grade::get()->toArray();
        // dd($grades[0]['classes']);
        $classes = Classes::get()->toArray();
        if ($request->isMethod('post')) {
            $data = $request->all();
            // $data['role'] = 0;
            $data['password'] = Hash::make($data['password']);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $reimage = 'imgstudent/' . time() . '.' . $image->getClientOriginalExtension();
                $dest = public_path('/imgstudent');
                $image->move($dest, $reimage);
                $data['image'] = $reimage;
                Student::create($data);
                $pre = Student::orderBy('id', 'desc')->limit(1)->first();
                Student::find($pre->id)->update(['email' => $data['name'] . $pre->id . '@st.vimaru.edu.vn']);
                return redirect('/admin/students')->with('success_message', 'Created Student Successfully');
            }
        }
        return View('admin.students.add', compact('classes', 'grades'));
    }
    public function editStudent(Request $request, $id)
    {
        $student = Student::find($id);
        // dd($teacher);
        $classes = Classes::get()->toArray();
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
            $data['email'] = $data['name'] . $id . '@st.vimaru.edu.vn';
            $data['password'] = $student['password'];
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
                $getgrades=Grade::with('class')->where('id', $data['grade_id'])->first()->toArray();
                return response()->json(['getgrades'=>$getgrades]);
            }
        }
        // dd($getgrades);
        // return View('admin.students.append_classes', compact('getgrades'));
    }
}

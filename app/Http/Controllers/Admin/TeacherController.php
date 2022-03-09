<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function Index()
    {
        $teachers = Admin::where('role', 0)->get()->toArray();
        $classes = Classes::get()->toArray();
        $subjects = Subject::get()->toArray();
        $class_id = [];
        foreach ($teachers as $key => $teacher) {
            $class_id[$key] = explode(",", $teacher['class_id']);
        }
        // dd($class_id);
        return View('admin.teachers.index', compact('teachers', 'classes', 'class_id', 'subjects'));
    }
    public function addTeacher(Request $request)
    {
        $subjects = Subject::get()->toArray();
        $classes = Classes::get()->toArray();
        if ($request->isMethod('post')) {
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $data['class_id'] = implode(',', $data['class_id']);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $reimage = 'imgs/' . time() . '.' . $image->getClientOriginalExtension();
                $dest = public_path('/imgs');
                $image->move($dest, $reimage);
                $data['image'] = $reimage;
                Admin::create($data);
                return redirect('/admin/teachers')->with('success_message', 'Created Teacher Successfully');
            }
        }
        return View('admin.teachers.add', compact('subjects', 'classes'));
    }
    public function editTeacher(Request $request, $id)
    {
        $teacher = Admin::find($id);
        // dd($teacher);
        $subjects = Subject::get()->toArray();
        $classes = Classes::get()->toArray();
        $class_id = explode(",", $teacher['class_id']);
        // dd($class_id);
        if ($request->isMethod('post')) {
            $data = $request->all();
            $data['password'] = $teacher['password'];
            $data['class_id'] = implode(',', $data['class_id']);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $reimage = 'imgs/' . time() . '.' . $image->getClientOriginalExtension();
                $dest = public_path('/imgs');
                $image->move($dest, $reimage);
                $data['image'] = $reimage;
                $teacher->update($data);
                return redirect('/admin/teachers')->with('success_message', 'Updated Teacher Successfully');
            } else {
                $teacher->update($data);
                return redirect('/admin/teachers')->with('success_message', 'Updated Teacher Successfully');
            }
        }
        return View('admin.teachers.edit', compact('subjects', 'teacher', 'classes', 'class_id'));
    }
    public function DeleteAll(Request $request)
    {
        $data = $request->all();
        
        if ($request->ajax()) {
                
            Admin::whereIn('id', explode(",", $data['ids']))->delete();
            return response()->json(['status' => true]);
        }
        return redirect()->back()->with('success_message', 'Deleted Teachers Successfully');
        
    }
    public function deleteTeacher(Request $request, $id)
    {
        // if ($request->ajax()) {
        Admin::find($id)->delete();
        return redirect()->back()->with('success_message', 'Deleted Teacher Successfully');
        // }
    }
    public function StatusTeacher(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                Admin::find($data['id'])->update(['status' => 0]);
                return response()->json(['status' => "Active"]);
            } else {
                Admin::find($data['id'])->update(['status' => 1]);
                return response()->json(['status' => "Inactive"]);
            }
            // return response()->json(['status'=>true]);
        }
    }
}

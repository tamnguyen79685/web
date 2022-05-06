<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classes;
class StudentController extends Controller
{
    public function Index(){
        $subjects=Subject::get()->toArray();
        return View('frontend.index', compact('subjects'));
    }
    public function Login(Request $request){
        if($request->isMethod('POST')){
            $data=$request->all();
            if(Auth::guard('student')->attempt(['email'=>$data['email'],'password'=>$data['password']])){
                return redirect('/dashboard');
            }else{
                return redirect()->back()->with('error_message', 'Your email or password is incorrect');
            }
        }
        return View('frontend.login');
    }
    public function Logout(){
        Auth::guard('student')->logout();
        return redirect('/');
    }
    public function ChangeDetail(Request $request){
        $student=Student::find(Auth::guard('student')->user()->id);
        $classes=Classes::get()->toArray();
        if($request->isMethod('POST')){
            $data=$request->all();
            $student->update($data);
            return redirect()->back()->with('success_message', 'Updated Profile Successfully');
        }
        return View('frontend.change_detail', compact('student', 'classes'));
    }
}

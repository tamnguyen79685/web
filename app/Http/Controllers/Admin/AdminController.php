<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
class AdminController extends Controller
{
    public function Login(Request $request){
        // dd(Hash::make(1));
        if($request->isMethod('post')){
            $data=$request->all();
            if(Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password']])){
                return redirect('/admin/dashboard')->with('message', 'Welcome back admin');

            }else{
                return redirect()->back()->with('error_message', 'Your email or password incorrect');
            }
        }
        return View('admin.login');
    }
    public function Index(){
        $admin=Admin::where('id', Auth::guard('admin')->user()->id)->first()->toArray();
        // dd($name);
        Session::put('page', 'admin_setting');
        Session::put('name', $admin['name']);
        return View('admin.index');
    }
    public function Logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
    public function changeDetail(Request $request){
        Session::put('page', 'admin_detail');
        $admindetails=Admin::where('id', Auth::guard('admin')->user()->id)->first();
        if($request->isMethod('post')){
            $data=$request->all();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $reimage = 'imgs/'.time() . '.' . $image->getClientOriginalExtension();
                $dest = public_path('/imgs');
                $image->move($dest, $reimage);
                Admin::where('id', Auth::guard('admin')->user()->id)->update(['mobile'=>$data['mobile'], 'image'=>$reimage, 'email'=>$data['email'],'status'=>(($data['status']==1)?1:0), 'name'=>$data['name']]);
                return redirect()->back()->with('success_message', 'Your profile has been updated successfully');
            }else{
                Admin::where('id', Auth::guard('admin')->user()->id)->update(['mobile'=>$data['mobile'], 'image'=>$admindetails->image, 'email'=>$data['email'], 'status'=>(($data['status']==1)?1:0), 'name'=>$data['name']]);
                return redirect()->back()->with('success_message', 'Your profile has been updated successfully');
            }
            Admin::where('id', Auth::guard('admin')->user()->id)->update($data);
        }
        return View('admin.change_detail', compact('admindetails'));
    }
    public function changePassword(Request $request){
        Session::put('page', 'admin_password');
        $admindetails=Admin::where('id', Auth::guard('admin')->user()->id)->first();
        if($request->isMethod('post')){
            $data=$request->all();
            if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
                if($data['new_password']==$data['confirm_password']){
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>Hash::make($data['new_password'])]);
                    return redirect()->back()->with('success_message','Changed password successfully');
                }else{
                    return redirect()->back()->with('error_message','New password and confirm password not same');
                }
            }
        }
        return View('admin.change_password', compact('admindetails'));
    }
    public function checkUpdatePassword(Request $request){
        if($request->ajax()){
            $data=$request->all();
            if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
                return response()->json(['status'=>true]);
            }else return response()->json(['status'=>false]);
        }
    }
}

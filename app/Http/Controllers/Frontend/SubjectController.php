<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function Index(Request $request, $subject_id){
        if($request->isMethod('POST')){
            $data=$request->all();
        }
        return View('frontend.subject.index');
    }
}

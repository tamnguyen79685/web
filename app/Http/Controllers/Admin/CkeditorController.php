<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class CkeditorController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $image = $request->file('upload');
            // $image=$image->resize(100, 100);
            $reimage = 'imgckeditor/'.time() . '.' . $image->getClientOriginalExtension();
            $dest = public_path('/imgckeditor');
            $image->move($dest, $reimage);
            return response()->json(['uploaded'=> true, 'url' => $reimage]);


        }
    }
}

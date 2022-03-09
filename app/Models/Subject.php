<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Subject extends Model
{
    use HasFactory;
    protected $table='subjects';
    protected $fillable=[
        'name',
        'grade_id',
        'status'
    ];
    public function teacher(){
        return $this->hasMany('App\Models\Admin', 'subject_id', 'id')->where('subject_id', Auth::guard('admin')->user()->subject_id);
    }
}

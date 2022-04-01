<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $table='exams';
    protected $fillable=[
        'name',
        'subject_id',
        'teacher_id',
        'class_id',
        'start_time',
        'end_time',
        'status'
    ];
    // public function question(){
    //     return $this->hasMany('App\Models\Question', 'exam_id', 'id');
    // }

}

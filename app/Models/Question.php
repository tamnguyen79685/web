<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table='questions';
    protected $fillable=[
        'exam_id',
        'select_id',
        'teacher_id',
        'subject_id',
        'question',
        'status',
        'image',
        'score',
        'grade_id'
    ];
    public function subject(){
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }
    public function answer(){
        return $this->hasMany('App\Models\Answer', 'question_id', 'id');
    }
}

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
        'answer',
        'status',
        'correct_answer'
    ];
    public function subject(){
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }
    // public function teacher(){
    //     return $this->belongsTo('App\Models\Admin', 'teacher_id', 'id');
    // }
}

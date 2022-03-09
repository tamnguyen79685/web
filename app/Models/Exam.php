<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $table='exams';
    protected $fillable=[
        'subject_id',
        'teacher_id',
        'grade',
        'start_time',
        'end_time'
    ];
}

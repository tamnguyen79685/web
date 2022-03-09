<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher_Class;
class Classes extends Model
{
    use HasFactory;
    protected $table='classes';
    protected $fillable=[
        'name',
        'grade_id',
        'number_of_students',
        'status'
    ];
    public function teacher(){
        return $this->hasMany('App\Models\Admin', 'class_id', 'id');
    }
}

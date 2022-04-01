<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard='admin';
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'image',
        'role',
        'status',
        'subject_id',
        'class_id',
        // 'grade_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    public function subject(){
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }
    public function exam(){
        return $this->hasMany('App\Models\Exam', 'teacher_id', 'id');
    }
}

<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//backend
Route::prefix('admin')->namespace('Admin')->group(function(){
    Route::match(['get', 'post'], '/', 'AdminController@Login');
    Route::group(['middleware'=>'admin'], function(){
        Route::get('/dashboard', 'AdminController@Index');
        Route::get('/logout', 'AdminController@Logout');
        //Admins
        Route::match(['get', 'post'], '/change-detail', 'AdminController@changeDetail');
        Route::match(['get', 'post'], '/change-password', 'AdminController@changePassword');
        Route::post('check-update-pwd', 'AdminController@checkUpdatePassword');
        //Exams
        Route::get('/exams', 'ExamController@Index');
        Route::match(['get', 'post'], '/add-exam', 'ExamController@addExam');
        Route::post('/edit-exam/{id}', 'ExamController@editExam');
        Route::get('/delete-exam/{id}', 'ExamController@deleteExam');
        Route::match(['get', 'post'], 'index-question/exam/{id}', 'ExamController@indexQuestionExam');
        //Teachers
        Route::get('/teachers', 'TeacherController@index');
        Route::match(['get', 'post'], '/add-teacher', 'TeacherController@addTeacher');
        Route::match(['get', 'post'], '/edit-teacher/{id}', 'TeacherController@editTeacher');
        Route::get('/delete-all/teachers', 'TeacherController@DeleteAll');
        Route::get('/delete-teacher/{id}', 'TeacherController@deleteTeacher');
        Route::post('/status/teacher', 'TeacherController@StatusTeacher');
        //subjects
        Route::get('/subjects', 'SubjectController@Index');
        Route::post('/add-subject', 'SubjectController@Add');
        Route::post('/edit-subject/{id}', 'SubjectController@Edit');
        Route::get('/delete-all/subjects', 'SubjectController@DeleteAll');
        Route::post('/status/subject', 'SubjectController@StatusSubject');
        Route::get('/delete-subject', 'SubjectController@Delete');
        //students
        Route::get('/students', 'StudentController@Index');
        Route::match(['get', 'post'], '/add-student', 'StudentController@addStudent');
        Route::match(['get', 'post'], '/edit-student/{id}', 'StudentController@editStudent');
        Route::get('/delete-student/{id}', 'StudentController@deleteStudent');
        Route::get('/delete-all/students', 'StudentController@DeleteAll');
        Route::post('/status/student', 'StudentController@StatusStudent');
        Route::match(['get', 'post'], '/append/class', 'StudentController@AppendClass');
        //Classes
        Route::get('/classes', 'ClassController@Index');
        Route::post('/add-class', 'ClassController@AddClass');
        Route::post('edit-class/{id}', 'ClassController@EditClass');
        Route::get('/delete-class/{id}', 'ClassController@DeleteClass');
        Route::get('/delete-all/classes', 'ClassController@DeleteAll');
        Route::post('/status/class', 'ClassController@StatusClass');

        //Grades
        Route::get('/grades', 'GradeController@Index');
        Route::post('/add-grade', 'GradeController@AddGrade');
        Route::post('edit-grade/{id}', 'GradeController@EditGrade');
        Route::get('/delete-grade/{id}', 'GradeController@DeleteGrade');
        Route::get('/delete-all/grades', 'GradeController@DeleteAll');
        Route::post('/status/grade', 'GradeController@StatusGrade');

    });
});

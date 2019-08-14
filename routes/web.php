<?php

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

Route::get('/', function () {
    return view('welcome');
});




//用户申请成为讲师页面
Route::get('/apply/{user_id?}','teacher\TeacherController@apply');
//申请讲师执行
Route::post('/applyDo','teacher\TeacherController@applyDo');
//课程添加
Route::get('/curr','curr\CurrController@curr');
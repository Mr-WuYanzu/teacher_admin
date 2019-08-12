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
Route::get('/apply','teacher\TeacherController@apply');
//申请讲师执行
Route::post('/applyDo','teacher\TeacherController@applyDo');
//课程添加
Route::get('/curr','curr\CurrController@curr');
//课程添加入库
Route::post('/currAdd','curr\CurrController@currAdd');
//章节添加
Route::get('/chapter','curr\CurrController@chapter');
//章节添加执行
Route::post('/chapterAdd','curr\CurrController@chapterAdd');
//课程的章节号
Route::post('/chapterNum','curr\CurrController@chapterNum');
//课时添加
Route::get('/classHour','curr\CurrController@classHour');
//课时添加执行
Route::post('/classHourAdd','curr\CurrController@classHourAdd');
//文件上传
Route::get('/upload','upload\UploadController@upload');
//章节的课时号
Route::post('/classHourNum','curr\CurrController@classHourNum');



//获取课程的章节的内容
Route::post('/getChapter','curr\CurrController@getChapter');

//课程列表
Route::get('/currList','curr\CurrController@currList');
//课程完结
Route::post('/currEnd','curr\CurrController@currEnd');
//课程上架
Route::post('/currUp','curr\CurrController@currUp');
//课程下架
Route::post('/currDown','curr\CurrController@currDown');
//课程删除
Route::post('/currDel','curr\CurrController@currDel');


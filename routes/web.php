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
    return view('layout/layouts');
});

//用户申请成为讲师页面
Route::get('/apply','teacher\TeacherController@apply');
//申请讲师执行
Route::post('/applyDo','teacher\TeacherController@applyDo');
//课程添加
Route::get('/curr','Curr\CurrController@curr');
//课程添加入库
Route::post('/currAdd','Curr\CurrController@currAdd');
//章节添加
Route::get('/chapter','Curr\CurrController@chapter');
//章节添加执行
Route::post('/chapterAdd','Curr\CurrController@chapterAdd');
//课程的章节号
Route::post('/chapterNum','Curr\CurrController@chapterNum');
//课时添加
Route::get('/classHour','Curr\CurrController@classHour');
//课时添加执行
Route::post('/classHourAdd','Curr\CurrController@classHourAdd');
//文件上传
Route::get('/upload','upload\UploadController@upload');
//章节的课时号
Route::post('/classHourNum','Curr\CurrController@classHourNum');



//获取课程的章节的内容
Route::post('/getChapter','curr\CurrController@getChapter');

//课程列表
Route::get('/currList','Curr\CurrController@currList');
//课程完结
Route::post('/currEnd','Curr\CurrController@currEnd');
//课程上架
Route::post('/currUp','Curr\CurrController@currUp');
//课程下架
Route::post('/currDown','Curr\CurrController@currDown');
//课程删除
Route::post('/currDel','Curr\CurrController@currDel');

//课程测试模块
Route::prefix('/test')->group(function(){
	//测试页面
	Route::get('test','Curr\CurrTestController@test');
	//获取课程章节
	Route::post('getChapter','Curr\CurrTestController@getChapter');
	//获取课程章节课时
	Route::post('getClass','Curr\CurrTestController@getClass');
	//获取课时视频
	Route::post('getVideo','Curr\CurrTestController@getVideo');
});


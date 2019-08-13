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
#teacher后台
Route::get('/teacher_admin',function(){
    return view('admin.index');
});
#题库管理
    #题目管理
    Route::get('/subject',function(){
        return view('item_bank.subject');
    });
    #科目添加执行
    Route::post('/subject_do','subject\SubjectController@subject_do');
    #科目列表
    Route::get('/subject_list','subject\SubjectController@subject_list');
    #科目删除
    Route::get('/subject_del/{id?}','subject\SubjectController@subject_del');
#试题管理
    #添加试题视图
    Route::get('/test','subject\SubjectController@test');
    #试题添加执行
    Route::post('/add_test','subject\SubjectController@add_test');
    #试题列表
    Route::get('/list_test','subject\SubjectController@list_test');
    #点击科目展示对应的试题
    Route::post('/subject_test_list','subject\SubjectController@subject_test_list');
    #题目删除
    Route::post('/test_del','subject\SubjectController@test_del');
    #题目修改
    Route::get('/test_edit/{id?}','subject\SubjectController@test_edit');
    #题目修改执行
    Route::post('/test_update','subject\SubjectController@test_update');
    #修改 检测题目唯一
    Route::post('/test_update_unique','subject\SubjectController@test_update_unique');
//用户申请成为讲师页面
Route::get('/apply','Teacher\TeacherController@apply');
//申请讲师执行
Route::post('/applyDo','Teacher\TeacherController@applyDo');
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

//讲师查询余额页面
Route::get('/teacher/balance','Teacher\TeacherController@balance');
//查询余额
Route::post('/teacher/getBalance','Teacher\TeacherController@getBalance');

Route::get('/curr','curr\CurrController@curr');
#订单管理
Route::get('/order','Order\OrderController@order');

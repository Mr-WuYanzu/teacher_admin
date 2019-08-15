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
})->middleware('login');

#teacher后台
Route::get('/teacher_admin',function(){
    return view('admin.index');
});
#题库管理
    #题目管理
    Route::get('/subject',function(){
        return view('item_bank.subject');
    })->middleware('login');
    #科目添加执行
    Route::post('/subject_do','subject\SubjectController@subject_do')->middleware('login');
    #科目列表
    Route::get('/subject_list','subject\SubjectController@subject_list')->middleware('login');
    #科目删除
    Route::get('/subject_del/{id?}','subject\SubjectController@subject_del')->middleware('login');
#试题管理
    #添加试题视图
    Route::get('/test','subject\SubjectController@test')->middleware('login');
    #试题添加执行
    Route::post('/add_test','subject\SubjectController@add_test')->middleware('login');
    #试题列表
    Route::get('/list_test','subject\SubjectController@list_test')->middleware('login');
    #点击科目展示对应的试题
    Route::post('/subject_test_list','subject\SubjectController@subject_test_list')->middleware('login');
    #题目删除
    Route::post('/test_del','subject\SubjectController@test_del')->middleware('login');
    #题目修改
    Route::get('/test_edit/{id?}','subject\SubjectController@test_edit')->middleware('login');
    #题目修改执行
    Route::post('/test_update','subject\SubjectController@test_update')->middleware('login');
    #修改 检测题目唯一
    Route::post('/test_update_unique','subject\SubjectController@test_update_unique')->middleware('login');
//用户申请成为讲师页面
Route::get('/apply','Teacher\TeacherController@apply');

//用户申请成为讲师页面
Route::get('/apply/{user_id?}','teacher\TeacherController@apply');

//用户头像上传
Route::post('/header_img','Teacher\TeacherController@headerImg');
//申请讲师执行
Route::post('/applyDo','Teacher\TeacherController@applyDo');
//课程添加
Route::get('/curr','Curr\CurrController@curr')->middleware('login');
//课程添加入库
Route::post('/currAdd','Curr\CurrController@currAdd')->middleware('login');
//检测课程名称唯一性
Route::post('/curr/checkCurrName','Curr\CurrController@checkCurrName')->middleware('login');
//章节添加
Route::get('/chapter','Curr\CurrController@chapter')->middleware('login');
Route::get('/chapter','Curr\CurrController@chapter');
//课程图片上传
Route::post('/uploadImg','upload\UploadController@uploadImg');
//章节添加执行
Route::post('/chapterAdd','Curr\CurrController@chapterAdd')->middleware('login');
//课程的章节号
Route::post('/chapterNum','Curr\CurrController@chapterNum')->middleware('login');
//课时添加
Route::get('/classHour','Curr\CurrController@classHour')->middleware('login');
Route::post('/classHour','Curr\CurrController@classHour');
//课时添加执行
Route::post('/classHourAdd','Curr\CurrController@classHourAdd')->middleware('login');
//文件上传
Route::post('/upload','upload\UploadController@upload')->middleware('login');
//章节的课时号
Route::post('/classHourNum','Curr\CurrController@classHourNum')->middleware('login');
Route::post('/classHourNum','Curr\CurrController@classHourNum');
//视频上传
Route::get('/currvideo','Curr\CurrController@currvideo');
//视频上传执行
Route::post('/videoUpload','Curr\CurrController@videoUpload');
//获取课时
Route::post('/getClassHour','Curr\CurrController@getClassHour');
//视频上传成功添加至课时表等待审核
Route::post('/videoAdd','Curr\CurrController@videoAdd');



//获取课程的章节的内容
Route::post('/getChapter','curr\CurrController@getChapter')->middleware('login');

//课程列表
Route::get('/currList','Curr\CurrController@currList')->middleware('login');
//课程完结
Route::post('/currEnd','Curr\CurrController@currEnd')->middleware('login');
//课程上架
Route::post('/currUp','Curr\CurrController@currUp')->middleware('login');
//课程下架
Route::post('/currDown','Curr\CurrController@currDown')->middleware('login');
//课程删除
Route::post('/currDel','Curr\CurrController@currDel')->middleware('login');

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

//讲师个人中心
Route::get('/teacher/center','Teacher\TeacherController@center')->middleware('login');
//讲师查询余额页面
Route::get('/teacher/balance','Teacher\TeacherController@balance')->middleware('login');
//查询余额
Route::post('/teacher/getBalance','Teacher\TeacherController@getBalance')->middleware('login');


Route::get('/curr','curr\CurrController@curr');
#订单管理
Route::get('/order','Order\OrderController@order')->middleware('login');

//讲师端登录
Route::get('/login/login','Login\LoginController@login');
//登录处理
Route::post('/login/doLogin','Login\LoginController@doLogin');
//登出处理
Route::get('/login/quitLogin','Login\LoginController@quitLogin');

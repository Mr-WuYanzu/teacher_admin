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
Route::get('/apply','teacher\TeacherController@apply');
//申请讲师执行
Route::post('/applyDo','teacher\TeacherController@applyDo');
//课程添加
Route::get('/curr','curr\CurrController@curr');
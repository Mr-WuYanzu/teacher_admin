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
Route::get('/login','LoginController@login');//登录页面
Route::post('/sendLogin','LoginController@sendLogin');//发起登录
Route::post('/loginDo','LoginController@loginDo');//登录执行
Route::post('/quit','LoginController@quit');//退出登录接口
Route::get('/quitLogin','LoginController@quitLogin');//退出登录

Route::post('/goodsDown','GoodsController@goodsDown');//商品下架
Route::post('/goodsTop','GoodsController@goodsTop');//商品下架

Route::post('/businessInfo','UserController@businessInfo');//获取商家信息


//商品添加
//Route::post('/sendUpload','UploadController@sendUpload');//商品图片发起上传
Route::post('/upload','UploadController@upload');//文件上传接口
Route::post('/goodsAdd','GoodsController@goodsAdd');//商品添加

Route::post('/shop_goods','GoodsController@shop_goods');//商家商品查询

Route::middleware('login')->group(function (){
    Route::get('admin','AdminController@index');//后台主页
    Route::get('goodsAdd','AdminController@goodsAdd');//后台商品添加
    Route::get('activity','ActivityController@activity');//后台商品活动
    Route::post('activityAdd','ActivityController@activityAdd');//后台商品活动添加
    Route::get('goodslist','AdminController@goodslist');//商品列表
    Route::get('orderlist','AdminController@orderlist');//订单列表
    Route::get('orderAccess','AdminController@orderAccess');//已结算订单列表
    Route::get('orderNoAccess','AdminController@orderNoAccess');//未结算订单列表

});




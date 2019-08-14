<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class OrderController extends Controller
{
    /**
     * [订单展示]
     */
    public function order(){
        #查询出订单表中所有的数据
        $orderInfo=DB::table('curr_order')->get();
        $orderInfo=json_decode($orderInfo,true);
        foreach($orderInfo as $k=>$v){
            $orderInfo[$k]['user_name']=DB::table('user')->where(['user_id'=>$v['user_id']])->value('user_name');
            $orderInfo[$k]['curr_name']=DB::table('curr')->where(['curr_id'=>$v['curr_id']])->value('curr_name');
        }
        return view('order.order',compact('orderInfo'));
    }
}

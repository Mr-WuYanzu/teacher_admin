<?php

namespace App\Http\Controllers\curr;

use App\curr\CurrCate;
use App\curr\LiveModel;
use App\Http\Controllers\Common\CommonController;
use App\Model\CurrModel;
use Illuminate\Http\Request;

class LiveCurrController extends CommonController
{
    //用户直播课程列表
    public function live_curr(){
        $data = $this->teacherInfo();
        if($data['status']!=200){
            return redirect('/login/login');
        }
        $teacherInfo = $data['data'];
        //获取讲师信息
        $teacher_id = $teacherInfo['t_id'];
//        dd($teacher_id);
        //查找这个讲师的课程
        $currInfo = CurrModel::where(['t_id'=>$teacher_id,'is_show'=>1,'curr_status'=>1,'curr_type'=>1])->get();
        //分局课程分类id查找这个分类
        foreach ($currInfo as $k=>$v){
            $currInfo[$k]['cate_name'] = CurrCate::where(['curr_cate_id'=>$v['curr_cate_id']])->value('cate_name');
        }
        return view('curr.live_curr',['data'=>$currInfo]);
    }

    //点击直播开始
    public function start_live(Request $request){
        $curr_id = $request->post('curr_id');
        if(empty($curr_id)){
            return ['status'=>103,'msg'=>'请选择课程'];
        }
        $data = $this->teacherInfo();
        if($data['status']!=200){
            return ['status'=>402,'msg'=>'请使用讲师登录'];
        }
        $teacherInfo = $data['data'];
        //讲师id
        $teacher_id = $teacherInfo['t_id'];
        //查找此讲师是否有此课程
        $currInfo = CurrModel::where(['curr_id'=>$curr_id,'t_id'=>$teacher_id,'is_show'=>1,'curr_status'=>1,'curr_type'=>1])->first();
        if(empty($currInfo)){
            return ['status'=>103,'msg'=>'请选择正确的课程'];
        }
        //查找到此课程返回一个直播地址，再返回一个秘钥
        $key = $this->_create_key(['curr_id'=>$curr_id,'t_id'=>$teacher_id]);
        //查询数据库有没有此用户开播此课程的秘钥
        $keyInfo = LiveModel::where(['curr_id'=>$curr_id,['key_expire','>',time()]])->first();
        if($keyInfo){
            $result = LiveModel::where(['live_id'=>$keyInfo['live_id']])->update(['live_key'=>$key,'key_expire'=>time()+60*60*24]);
            if($result){
                return ['status'=>200,'live_url'=>'rtmp://192.168.136.131:1935/cctvf?key='.$key,'key' => md5($teacherInfo['t_name'])];
            }else{
                return ['status'=>104,'msg'=>'获取秘钥失败请重试'];
            }
        }else{
            //秘钥存入数据库
            $data = [
                'live_key'=>$key,
                'key_expire'=>time()+60*60*24,
                'curr_id'=>$curr_id
            ];
            $result = LiveModel::insert($data);
            if($result){
                return ['status'=>200,'live_url'=>'rtmp://192.168.136.131:1935/cctvf?key='.$key,'key' => md5($teacherInfo['t_name'])];
            }else{
                return ['status'=>104,'msg'=>'获取秘钥失败请重试'];
            }
        }
    }
    //生成key
    private function _create_key($data){
        $key = 'akakakalsldslety';
        $iv = 'zhbzhbzhbzhbzhbn';
        $key = openssl_encrypt(json_encode($data),'AES-128-CBC',$key,OPENSSL_RAW_DATA,$iv);
        return base64_encode($key);
    }
}

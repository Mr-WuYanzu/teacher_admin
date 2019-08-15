<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Common\CommonController;
use App\teacher\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserModel;
/**
 * 讲师模块类
 * class TeacherController
 * @author   <[<email address>]>
 * @package  App\Http\Controllers\Teacher
 * @date 2019-08-10
 */
class TeacherController extends CommonController
{
    //用户申请成为讲师页面
    public function apply(Request $request){

        $type=1;
        //验证用户是否登录
        $user_id = session('user.user_id');

        if(empty($user_id)){
            return redirect('/login/login');
        }
        //根据用户ID查询讲师信息
        $userInfo = UserModel::where(['user_id'=>$user_id,'status'=>1])->first();
        if(!$userInfo){
            return redirect('/login/login');
        }
        //查询此用户有没有申请过
        $where=[
            'user_id'=>$user_id
        ];
        $teacherInfo = Teacher::where($where)->first();
        if($teacherInfo){
            if($teacherInfo['status']==1){
                $type=2;
            }else if($teacherInfo['status']==2){
                $type=3;
            }
        }

        return view('teacher.apply',['type'=>$type]);
    }

    //用户头像上传
    public function headerImg(Request $request){
        //验证用户是否登录
        $user_id = session('user.user_id');
        if(empty($user_id)){
            return ['status'=>402,'msg'=>'请登陆后上传'];
        }
        //根据用户ID查询讲师信息
        $userInfo = UserModel::where(['user_id'=>$user_id,'status'=>1])->first();
        if(!$userInfo){
            return ['status'=>402,'msg'=>'请登录后上传'];
        }
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $photo = $request->file('file');
            $extension = $photo->extension();
            $path = 'headerImg/'.date('Y-m-d');
            if(!is_dir($path)){
                mkdir($path,0777,true);
            }
            $store_result = $photo->store($path);
            $output = [
                'status'=>1000,
                'path' => $store_result
            ];
            return $output;
        }

        return ['status'=>108,'msg'=>'未获取到上传文件或上传过程出错'];
    }

    //讲师申请执行
    public function applyDo(Request $request){
        //验证用户是否登录
        $user_id = session('user.user_id');
        if(empty($user_id)){
            return ['status'=>402,'msg'=>'请登陆后上传'];
        }
        //根据用户ID查询讲师信息
        $userInfo = UserModel::where(['user_id'=>$user_id,'status'=>1])->first();
        if(!$userInfo){
            return ['status'=>402,'msg'=>'请登录'];
        }
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return ['status'=>402,'msg'=>'请登录'];
        }
        $user_id = $teacherInfo['data']['user_id'];
        $teacher_name = $request->post('teacher_name');
        $teacher_desc = $request->post('teacher_desc');
        $teacher_direction = $request->post('teacher_direction');
        $header_img = $request->post('header_img');
        if(empty($teacher_desc) || empty($teacher_name) || empty($teacher_direction)){
            return ['status'=>102,'msg'=>'缺失参数'];
        }
        if(empty($header_img)){
            return ['status'=>102,'msg'=>'请上传头像'];
        }
        //查询此用户有没有申请过
        $where=[
            'user_id'=>$user_id
        ];
        $teacherInfo = Teacher::where($where)->first();
        if($teacherInfo){
            if($teacherInfo['status']==1){
                return ['status'=>102,'msg'=>'您已提交审核，请耐心等待审核'];
            }else if($teacherInfo['status']==2){
                return ['status'=>102,'msg'=>'您已经是讲师了，请勿重复申请'];
            }
        }
        //查询次用户名有没有人使用
        $user_name_info = Teacher::where(['t_name'=>$teacher_name])->first();
        if($user_name_info){
            return ['status'=>102,'msg'=>'此昵称已经有人使用了，请更换一个'];
        }
        //验证能通过，添加审核
        $data=[
            't_name'=>$teacher_name,
            't_desc'=>$teacher_desc,
            'status'=>1,
            'user_id'=>$user_id,
            'teacher_direction'=>$teacher_direction,
            'header_img'=>$header_img,
        ];
        $result = Teacher::insert($data);
        if($result){
            return ['status'=>200,'msg'=>'申请成功，请耐心等待审核'];
        }else{
            return ['status'=>105,'msg'=>'申请失败，请重试'];
        }
    }

    /**
     * [讲师查询余额页面]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function balance(Request $request)
    {
        //实例化模型类
        $teacherModel=new Teacher();
        //获取所有通过审核的讲师信息
        $teacherInfo=$teacherModel->where('status',2)->get()->toArray();
        //渲染视图
        return view('teacher/getbalance',compact('teacherInfo'));
    }

    /**
     * [讲师个人中心]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function center(Request $request)
    {
        $data = $this->teacherInfo();
        if($data['status']!=200){
            return redirect('/login/login');
        }
        $teacherInfo = $data['data'];
        //渲染视图
        return view('teacher/center',compact('teacherInfo'));
    }

    /**
     * [获取讲师余额]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getBalance(Request $request)
    {
        //获取讲师id
        $t_id=$request->get('t_id');
        //实例化模型类
        $teacherModel=new Teacher();
        //查询讲师余额
        $t_balance=$teacherModel->where('t_id',$t_id)->value('t_balance');
        //返回余额
        return $t_balance;
    }
}

<?php

namespace App\Http\Controllers\teacher;

use App\teacher\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherController extends Controller
{
    //用户申请成为讲师页面
    public function apply(Request $request){
        $type=1;
        $user_id = 1;
        if(empty($user_id)){
            echo '禁止访问，请登录';
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

    public function applyDo(Request $request){
        $teacher_name = $request->post('teacher_name');
        $teacher_desc = $request->post('teacher_desc');
        $user_id = 1;
        if(empty($teacher_desc) || empty($teacher_name)){
            return ['status'=>102,'msg'=>'缺失参数'];
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
            'user_id'=>$user_id
        ];
        $result = Teacher::insert($data);
        if($result){
            return ['status'=>200,'msg'=>'申请成功，请耐心等待审核'];
        }else{
            return ['status'=>105,'msg'=>'申请失败，请重试'];
        }
    }
}

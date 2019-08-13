<?php

namespace App\Http\Controllers\subject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class SubjectController extends Controller
{
    /*
     * 科目管理
     * */
    #科目添加执行
    public function subject_do(Request $request){
        $data=$request->all();
        if(empty($data['c_name'])){
            echo "<script>alert('请输入科目名称');location.href='/subject';</script>";exit;
        }
        $usernameInfo=DB::table('topic_cate')->where(['c_name'=>$data['c_name']])->first();
        if($usernameInfo){
            echo "<script>alert('该题目已添加，请重新添加');location.href='/subject';</script>";exit;
        }else{
            $arr=[
                'c_name'=>$data['c_name'],
                'create_time'=>time()
            ];
            $insert=DB::table('topic_cate')->insert($arr);
            if($insert){
                echo "<script>alert('题目添加成功');location.href='/subject';</script>";exit;
            }else{
                echo "<script>alert('题目添加失败--》请重试');location.href='/subject';</script>";exit;
            }
        }
    }
    #科目列表
    public function subject_list(){
        $res=DB::table('topic_cate')->get();
        return view('item_bank.subject_list',compact('res'));
    }
    #科目删除
    public function subject_del(Request $request){
        $c_id=$request->id;
        if(empty($c_id)){
            echo "<script>alert('请选择一个科目进行删除操作');location.href='/subject_list';</script>";exit;
        }
        $res=DB::table('topic_cate')->where(['c_id'=>$c_id])->delete();
        if($res){
            echo "<script>alert('删除科目成功');location.href='/subject_list';</script>";exit;
        }else{
            echo "<script>alert('删除科目失败---》请您稍后重试');location.href='/subject_list';</script>";exit;
        }
    }

    /*
    *试题管理
    **/
    #添加试题视图
    public function test(){
        #查询所有的科目
        $subject=DB::table('topic_cate')->get();
        return view('test.test_add',compact('subject'));
    }
    #添加执行
    public function add_test(Request $request){
        $data=$request->all();
        //验证非空
        if(empty($data['c_id'])){
            return ['code'=>1,'msg'=>'请选择一个科目'];
        }
        if(empty($data['t_title'])){
            return ['code'=>1,'msg'=>'请输入题目'];
        }
        if(empty($data['a'])){
            return ['code'=>1,'msg'=>'请输入a选项'];
        }
        if(empty($data['b'])){
            return ['code'=>1,'msg'=>'请输入b选项'];
        }
        if(empty($data['c'])){
            return ['code'=>1,'msg'=>'请输入c选项'];
        }
        if(empty($data['d'])){
            return ['code'=>1,'msg'=>'请输入d选项'];
        }
        if(empty($data['correct'])){
            return ['code'=>1,'msg'=>'请输入正确答案'];
        }
        //题目唯一
        $titleInfo=$this->test_unique($data);
        if($titleInfo){
            return ['code'=>1,'msg'=>'该题目已添加--》请重新添加题目'];
        }else{
            //将试题入库
            $insert=DB::table('paper')->insert($data);
            if($insert){
                return ['code'=>100,'msg'=>'添加试题成功'];
            }else{
                return ['code'=>1,'msg'=>'添加试题失败---》请重试'];
            }
        }
    }
    #试题列表
    public function list_test(){
        #查询所有的科目
        $subject=DB::table('topic_cate')->get();
        return view('test.test_list',compact('subject'));
    }
    #点击科目展示对应的试题
    public function subject_test_list(Request $request){
        #接受科目id
        $c_id=$request->c_id;
        #根据科目id 查询题目表中的数据
        $Info=DB::table('paper')->where(['c_id'=>$c_id])->get();
        #根据科目id 查询科目
        $c_name=DB::table('topic_cate')->where(['c_id'=>$c_id])->value('c_name');
        return view('test.subject_test_list',compact('Info','c_name'));
    }
    #题目删除
    public function test_del(Request $request){
        $t_id=$request->t_id;
        if(empty($t_id)){
            return ['code'=>1,'msg'=>'请选择一条题目'];
        }else{
            $delete=DB::table('paper')->where(['t_id'=>$t_id])->delete();
            if($delete){
                return ['code'=>100,'msg'=>'删除题目成功'];
            }else{
                return ['code'=>1,'msg'=>'删除题目失败'];
            }
        }

    }
    #题目修改视图
    public function test_edit(Request $request){
        $id=$request->id;
        if(empty($id)){
            echo "<script>alert('请选择一条题目');location.href='/list_test';</script>";exit;
        }else{
            #根据题目查询该题目的信息
            $editInfo=DB::table('paper')->where(['t_id'=>$id])->first();
            return view('test.test_edit',compact('editInfo'));
        }

    }
    #题目修改执行
    public function test_update(Request $request){
        $data=$request->all();
        $update=DB::table('paper')->where(['t_id'=>$data['t_id']])->update($data);
        if($update){
            return ['code'=>100,'msg'=>'修改成功'];
        }else{
            return ['code'=>1,'msg'=>'修改失败'];
        }
    }
    #题目唯一
    public function test_unique($data){
        $res=DB::table('paper')->where(['t_title'=>$data['t_title']])->first();
        return $res;
    }
    #修改检测 题目唯一
    public function test_update_unique(Request $request){
        $data=$request->input();
        $titleInfo=DB::table('paper')->where(['t_title'=>$data['t_title']])->first();
        if($titleInfo){
            return ['code'=>1,'msg'=>'该题目已存在--->请确认修改'];
        }else{
            return ['code'=>100,'msg'=>'ok'];
        }
    }












}

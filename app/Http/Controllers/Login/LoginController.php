<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserModel;
use App\Model\TeacherModel;
/**
 * 登录模块类
 * class LoginController
 * @author   <[<gaojianbo>]>
 * @package  App\Http\Controllers\Login
 * @date 2019-08-14
 */
class LoginController extends Controller
{
	/**
	 * [登录页面]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
    public function login(Request $request)
    {
    	//渲染视图
    	return view('login/login');
    }

    /**
     * [登录处理]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function doLogin(Request $request)
    {
    	//接收账号密码
    	$data=$request->post('data');
    	//检测账号是手机号、邮箱还是用户名
    	$tel_reg='/^[1][3,5,8]\d{9}$/';
    	$mail_reg='/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
    	if(preg_match($tel_reg,$data['account'])){
    		$account='user_tel';
    	}elseif(preg_match($mail_reg,$data['account'])){
    		$account='user_mail';
    	}else{
    		$account='user_name';
    	}
    	//实例化模型类
    	$userModel=new UserModel();
    	//查询用户是否存在
    	$user=$userModel->where($account,$data['account'])->first();
    	//不存在直接返回提示
    	if(empty($user)){
    		$this->response('账号或密码错误',2,5);return;
    	}
    	//取出最后错误时间,次数
    	$now=time();
    	$error_num=$user->error_num;
    	$last_error_time=$user->last_error_time;
    	//检测密码是否正确
    	if($data['pwd']!=decrypt($user->pwd)){
    		//如果错误时间大于一小时,记录一次错误次数和错误时间
    		if($now-$last_error_time>3600){
    			$updateInfo=[
    				'error_num'=>1,
    				'last_error_time'=>$now
    			];
    			$userModel->where('user_id',$user->user_id)->update($updateInfo);
    			$this->response('账号或密码错误,您还有2次机会',2,5);return;
    		}else{
    			//如果小于一小时,判断是否已经输错3次,如果是冻结用户1小时,否则累加错误次数
    			if($error_num>=3){
    				$minutes=60-ceil(($now-$last_error_time)/60);
    				$this->response('账号或密码错误,请'.$minutes.'分钟后登录',2,5);return;
    			}else{
    				$updateInfo=[
    					'error_num'=>$error_num+1,
    					'last_error_time'=>$now
    				];
    				$userModel->where('user_id',$user->user_id)->update($updateInfo);
    				$num=3-($error_num+1);
    				$msg='账号或密码错误,您还有'.$num.'次机会';
    				if($num==0){
    					$msg='账号或密码错误,请一小时后登录';
    				}
    				$this->response($msg,2,5);return;
    			}
    		}
    	}else{
    		//如果用户已被冻结,密码正确也不能登录
    		if($error_num>=3 && $now-$last_error_time<3600){
    			$minutes=60-ceil(($now-$last_error_time)/60);
    			$this->response('账号或密码错误,请,'.$minutes.'分钟后登录',2,5);return;
    		}
    		//解除用户冻结状态
    		$updateInfo=[
    			'error_num'=>0,
    			'last_error_time'=>null
    		];
    		$userModel->where('user_id',$user->user_id)->update($updateInfo);
    		//实例化模型类
    		$teacherModel=new TeacherModel();
    		//用户没被冻结或解冻,判断用户是否为教师
    		$t_id=$teacherModel->where('user_id',$user->user_id)->value('t_id');
    		//如果是教师记录用户登录信息并跳转个人中心,不是教师跳转申请讲师
    		if(!empty($t_id)){
    			session(['user'=>['user_id'=>$t_id,'user_name'=>$user->user_name]]);
    			$this->response('登录成功',1,6);
    		}else{
    			$this->response('你还不是讲师,请先申请',3,$user->user_id);
    		}
    	}
    }

    public function quitLogin(Request $request)
    {
    	$request->session()->forget('user');
    	return redirect('/login/login');
    }

    public function response($msg,$code,$skin)
    {
    	$arr=[
    		'font'=>$msg,
    		'code'=>$code,
    		'skin'=>$skin
    	];
    	echo json_encode($arr,JSON_UNESCAPED_UNICODE);
    }
}

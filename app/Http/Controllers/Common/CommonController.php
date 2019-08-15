<?php

namespace App\Http\Controllers\Common;

use App\Model\TeacherModel;
use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/**
 *
 * @author   <[<gaojianbo>]>
 * @package  App\Http\Controllers\Common
 * @date 2019-08-12
 */
class CommonController extends Controller
{

    public function __construct()
    {

    }

    /**
	 * [跳转页面]
	 * @param  [type] $msg [description]
	 * @param  [type] $url [description]
	 * @return [type]      [description]
	 */
    public function abort($msg,$url)
    {
    	echo "<script>alert('{$msg}');location.href='{$url}';</script>";
    }

	/**
	 * [成功时的响应信息]
	 * @param  string  $msg  [description]
	 * @param  integer $code [description]
	 * @param  integer $skin [description]
	 * @return [type]        [description]
	 */
	public function json_success($msg='success',$code=1,$skin=6)
	{
		return $this->_Output($msg,$code,$skin);
	}

	/**
	 * [失败时的响应信息]
	 * @param  string  $msg  [description]
	 * @param  integer $code [description]
	 * @param  integer $skin [description]
	 * @return [type]        [description]
	 */
	public function json_fail($msg='fail',$code=2,$skin=5)
	{
		return $this->_Output($msg,$code,$skin);
	}

	/**
	 * [返回响应信息]
	 * @param  [type] $msg  [description]
	 * @param  [type] $code [description]
	 * @param  [type] $skin [description]
	 * @return [type]       [description]
	 */
	public function _Output($msg,$code,$skin)
	{
		$arr=[
			'msg'=>$msg,
			'code'=>$code,
			'skin'=>$skin
		];
		return json_encode($arr,JSON_UNESCAPED_UNICODE);
	}

	/**
	 * [递归处理分类信息]
	 * @param  [type]  $cateInfo [description]
	 * @param  integer $pid      [description]
	 * @param  integer $level    [description]
	 * @return [type]            [description]
	 */
    public function getCateInfo($cateInfo,$pid=0,$level=0)
    {
    	static $arr=[];
    	foreach ($cateInfo as $k => $v) {
    		if($v['pid']==$pid){
    			$v['level']=$level;
    			$arr[]=$v;
    			$this->getCateInfo($cateInfo,$v['curr_cate_id'],$level+1);
    		}
    	}
    	return $arr;
    }
    public function teacherInfo(){
        $user_id = session('user.user_id');
        //根据用户ID查询讲师信息
        $userInfo = UserModel::where(['user_id'=>$user_id])->first();
        if($userInfo){
            if($userInfo['status']==2){
                return ['status'=>3,'msg'=>'您的账号已被锁定'];
            }else{
                $teacherInfo = TeacherModel::where(['user_id'=>$userInfo['user_id']])->first();
                if($teacherInfo){
                    return ['status'=>200,'msg'=>'ok','data'=>$teacherInfo];
                }else{
                    return ['status'=>4,'msg'=>'您还不是讲师不能访问'];
                }
            }
        }else{
                return ['status'=>2,'msg'=>'请登录'];
        }


    }
}

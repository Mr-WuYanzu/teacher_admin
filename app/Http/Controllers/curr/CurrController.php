<?php

namespace App\Http\Controllers\Curr;

use App\curr\Chapter;
use App\curr\ClassHour;
use App\curr\Curr;
use App\curr\CurrCate;
use App\Http\Controllers\upload\UploadController;
use App\Http\Controllers\upload\UploadedController;
use App\Model\CurrClassHourModel;
use App\Model\CurrModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Common\CommonController;
/**
 * 课程模块类
 * class CurrController
 * @author   <[<email address>]>
 * @package  App\Http\Controllers\Curr
 * @date 2019-08-10
 */
class CurrController extends CommonController
{
    //课程添加页面
    public function curr(){
        //查找课程分类
        $curr_cate = CurrCate::where('status',1)->get();
        $cateInfo = $this->currcate($curr_cate);
        return view('curr.curr',['cateInfo'=>$cateInfo]);
    }

    //课程添加执行
    public function currAdd(Request $request){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return ['status'=>402,'msg'=>'请登录0'];
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        $curr_name = $request->post('curr_name');  //课程名称
        $curr_cate_id = $request->post('curr_cate_id');   //课程分类
        $is_pay = $request->post('is_pay');     //课程收费状态 1 免费 2收费
        $img_url = $request->post('img_url');  //课程图片路径
        $curr_detail = $request->post('curr_detail');  //课程介绍
        $curr_type = $request->post('curr_type');  //课程类型  1 直播 2 录播
         $curr_status = 2; //课程审核状态
        //验证非空
        if(empty($curr_name) || empty($curr_cate_id) || empty($is_pay) || empty($curr_detail) || empty($curr_type)){
            return ['status'=>104,'msg'=>'缺少参数'];
        }
        if(empty($img_url)){
            return ['status'=>105,'msg'=>'请上传课程图片'];
        }
        //验证分类id是否正确
        $cate_result = CurrCate::where('curr_cate_id',$curr_cate_id)->first();
        if(empty($cate_result)){
            return ['status'=>105,'msg'=>'请选择正确的分类'];
        }
        //查询此分类下有没有此名称的课程
        $result = CurrModel::where(['curr_cate_id'=>$curr_cate_id,'curr_name'=>$curr_name])->first();
        if($result){
            return ['status'=>106,'msg'=>'课程名称重复，请重新输入'];
        }
        //判断是否是付费课程，拼接数据
        if($is_pay==2){
            $price=floatval($request->post('curr_price'));
            if($price=='' || empty($price) || $price <= 0){
                return ['status'=>107,'msg'=>'请输入正常的价格'];
            }
            $data=[
                't_id'=>$teacher_id,
                'curr_name'=>$curr_name,
                'curr_cate_id'=>$curr_cate_id,
                'is_pay'=>$is_pay,
                'curr_detail'=>$curr_detail,
                'curr_hot'=>1,
                'curr_price'=>$price,
                'create_time'=>time(),
                'curr_type'=>$curr_type,
                'curr_status'=>$curr_status,
                'is_show'=>1,
                'curr_img'=>$img_url
            ];
        }else{
            $data=[
                't_id'=>$teacher_id,
                'curr_name'=>$curr_name,
                'curr_cate_id'=>$curr_cate_id,
                'is_pay'=>$is_pay,
                'curr_detail'=>$curr_detail,
                'curr_hot'=>1,
                'create_time'=>time(),
                'curr_type'=>$curr_type,
                'curr_status'=>$curr_status,
                'is_show'=>1,
                'curr_img'=>$img_url
            ];
        }

        //添加入库
        $result = Curr::insert($data);
        if($result){
             return ['status'=>200,'msg'=>'添加成功'];
        }else{
             return ['status'=>106,'msg'=>'添加失败'];
        }

    }

    //章节添加页面
    public function chapter(){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return redirect('/login/login');
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        //查询出当前所有的课程
        $currInfo = Curr::where(['t_id'=>$teacher_id,'status'=>2,'curr_status'=>1,'curr_type'=>2])->get();
        return view('curr.chapter',['currInfo'=>$currInfo]);
    }

    //课程的章节添加
    public function chapterAdd(Request $request){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return ['status'=>402,'msg'=>'请登录0'];
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        $curr_id = $request->post('curr_id');//课程id
        $chapter_name = $request->post('chapter_name');//章节名称
        $chapter_desc = $request->post('chapter_desc');//章节介绍
        //验证课程id
        $currInfo = Curr::where(['t_id'=>$teacher_id,'curr_id'=>$curr_id,'status'=>2,'curr_status'=>1,'curr_type'=>2])->first();
        if(empty($currInfo)){
            return ['status'=>112,'msg'=>'课程不存在'];
        }
        //验证此课程名称有没有使用
        $checkName = Chapter::where(['curr_id'=>$curr_id,'chapter_name'=>$chapter_name])->first();
        if($checkName){
            return ['status'=>113,'msg'=>'此课程中已经存在此章节名'];
        }
        //添加入库
        $data=[
            'curr_id'=>$curr_id,
            'chapter_name'=>$chapter_name,
            'chapter_desc'=>$chapter_desc,
            'chapter_num'=>$currInfo['chapterNum']+1,
            'create_time'=>time()
        ];
        $chapter_result = Chapter::insert($data);
        if($chapter_result){
            Curr::where(['curr_id'=>$curr_id])->update(['chapterNum'=>$currInfo['chapterNum']+1]);
            return ['status'=>200,'msg'=>'添加成功'];
        }else{
            return ['status'=>'115','msg'=>'添加失败请重试'];
        }
    }

    //获取课程章节号
    public function chapterNum(Request $request){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return ['status'=>402,'msg'=>'请登录0'];
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        $curr_id = $request->post('curr_id');
        if(empty($curr_id)){
            return ['status'=>110,'msg'=>'请选择课程'];
        }
        //查询课程章节号
        $chapter_num = Curr::where(['t_id'=>$teacher_id,'curr_id'=>$curr_id])->value('chapterNum');
        if($chapter_num==0 || !empty($chapter_num)){
            return ['status'=>200,'chapterNum'=>$chapter_num+1];
        }else{
            return ['status'=>111,'msg'=>'课程不存在'];
        }
    }

    //获取课程的章节内容
    public function getChapter(Request $request){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return ['status'=>402,'msg'=>'请登录0'];
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        $curr_id = $request->post('curr_id');
        if(empty($curr_id)){
            return ['status'=>108,'msg'=>'请选择课程'];
        }
        //查询课程信息
        $currInfo = Curr::where(['t_id'=>$teacher_id,'curr_id'=>$curr_id,'status'=>2,'curr_status'=>1,'curr_type'=>2])->first();
        if(!$currInfo){
            return ['status'=>109,'msg'=>'课程不存在'];
        }
        //查询章节
        $chapterInfo = Chapter::where(['curr_id'=>$curr_id])->get();
        if(!$chapterInfo){
            return ['status'=>118,'msg'=>'此课程下还没有章节'];
        }
        //章节存在返回章节内容
        return ['status'=>200,'data'=>$chapterInfo];
    }

    //课时添加页面
    public function classHour(){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return redirect('/login/login');
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        $currInfo = Curr::where(['t_id'=>$teacher_id,'status'=>2,'curr_status'=>1,'curr_type'=>2])->get();
        return view('curr.classhour',['currInfo'=>$currInfo]);
    }

    //获取章节的课时号
    public function classHourNum(Request $request){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return ['status'=>402,'msg'=>'请登录'];
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        $curr_id = $request->post('curr_id');
        if(empty($curr_id)){
            return ['status'=>107,'msg'=>'请选择课程'];
        }
        $chapter_id = $request->post('chapter_id');
        if(empty($chapter_id)){
            return ['status'=>116,'msg'=>'请选择章节'];
        }
        //验证课程存在不存在
        $currResult = Curr::where(['t_id'=>$teacher_id,'curr_id'=>$curr_id])->first();
        if(!$currResult){
            return ['status'=>120,'msg'=>'课程不存在'];
        }
        //验证章节
        $chapterInfo = Chapter::where(['curr_id'=>$curr_id,'chapter_id'=>$chapter_id])->first();
        if(!$chapterInfo){
            return ['status'=>121,'msg'=>'此课程下没有这个章节'];
        }
        //验证通过，返回课时号
        return ['status'=>200,'classNum'=>$chapterInfo['class_num']+1];

    }

    //课程的课时添加执行
    public function classHourAdd(Request $request){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return ['status'=>402,'msg'=>'请登录'];
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        $chapter_id = $request->post('chapter_id');
        $class_hour_name = $request->post('class_hour_name');
        $curr_id = $request->post('curr_id');
        if(empty($curr_id)){
            return ['status'=>102,'msg'=>'请选择课程'];
        }
        if(empty($chapter_id)){
            return ['status'=>102,'msg'=>'请选择章节'];
        }
        if(empty($class_hour_name)){
            return ['status'=>102,'msg'=>'请输入课时名称'];
        }
        //要添加数据库的数据
        $data=[
            'class_name'=>$class_hour_name,
            'chapter_id'=>$chapter_id,
            'curr_id'=>$curr_id,
            'create_time'=>time()
        ];
        //验证课程存在不存在
        $currResult = Curr::where(['t_id'=>$teacher_id,'curr_id'=>$curr_id])->first();
        if(!$currResult){
            return ['status'=>120,'msg'=>'课程不存在'];
        }
        //验证章节
        $chapterInfo = Chapter::where(['curr_id'=>$curr_id,'chapter_id'=>$chapter_id])->first();
        if(!$chapterInfo){
            return ['status'=>121,'msg'=>'该课程下没有此章节'];
        }
        //验证课时名称在此章节中是否已经使用
        $className = ClassHour::where(['chapter_id'=>$chapter_id,'class_name'=>$class_hour_name])->first();
        if($className){
            return ['status'=>122,'msg'=>'课时名称在此章节中已经存在，请更换'];
        }
        //当前添加的课时号
        $data['class_hour_num']= $chapterInfo['class_num']+1;
        //验证没问题，入库
        $result = ClassHour::insert($data);
        if($result){
            Chapter::where(['chapter_id'=>$chapter_id])->update(['class_num'=>$chapterInfo['class_num']+1]);
            return ['status'=>200,'msg'=>'添加成功'];
        }else{
            return ['status'=>123,'msg'=>'添加失败，请重试'];
        }
    }
    //课程列表
    public function currList(){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return redirect('/login/login');
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        //根据讲师id查找课程
        $data=[];
        $currInfo = Curr::where(['t_id'=>$teacher_id,'status'=>2,'curr_status'=>1])->get();
        foreach ($currInfo as $k=>$v){
            $data[$k]=$v;
            $data[$k]['cate_name']=CurrCate::where(['status'=>1,'curr_cate_id'=>$v['curr_cate_id']])->value('cate_name');
        }
        return view('curr.list',['data'=>$data]);
    }

    //课程完结
    public function currEnd(Request $request){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return ['status'=>402,'msg'=>'请登录'];
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        $curr_id = intval($request->post('curr_id'));
        if(empty($curr_id)){
            return ['status'=>108,'msg'=>'请选择课程'];
        }
        //验证此课程是不是此讲师的
        $curr = Curr::where(['t_id'=>$teacher_id,'curr_id'=>$curr_id,'status'=>2])->first();
        if(empty($curr)){
            return ['status'=>105,'msg'=>'您没有正在更新的此课程'];
        }
        //验证通过修改状态
        $result = Curr::where('curr_id',$curr_id)->update(['status'=>1]);
        if($result){
            return ['status'=>200,'msg'=>'操作成功'];
        }else{
            return ['status'=>109,'msg'=>'操作失败'];
        }
    }

    //课程上架
    public function currUp(Request $request){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return ['status'=>402,'msg'=>'请登录'];
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        $curr_id = intval($request->post('curr_id'));
        if(empty($curr_id)){
            return ['status'=>108,'msg'=>'请选择课程'];
        }
        //验证此课程是不是此讲师的
        $curr = Curr::where(['t_id'=>$teacher_id,'curr_id'=>$curr_id,'is_show'=>2])->first();
        if(empty($curr)){
            return ['status'=>105,'msg'=>'您没有下架此课程'];
        }
        //验证通过修改状态
        $result = Curr::where('curr_id',$curr_id)->update(['is_show'=>1]);
        if($result){
            return ['status'=>200,'msg'=>'操作成功'];
        }else{
            return ['status'=>109,'msg'=>'操作失败'];
        }
    }

    //课程下架
    public function currDown(Request $request){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return ['status'=>402,'msg'=>'请登录'];
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        $curr_id = intval($request->post('curr_id'));
        if(empty($curr_id)){
            return ['status'=>108,'msg'=>'请选择课程'];
        }
        //验证此课程是不是此讲师的
        $curr = Curr::where(['t_id'=>$teacher_id,'curr_id'=>$curr_id,'is_show'=>1])->first();
        if(empty($curr)){
            return ['status'=>105,'msg'=>'您没有上架此课程'];
        }
        //验证通过修改状态
        $result = Curr::where('curr_id',$curr_id)->update(['is_show'=>2]);
        if($result){
            return ['status'=>200,'msg'=>'操作成功'];
        }else{
            return ['status'=>109,'msg'=>'操作失败'];
        }
    }

    //课程删除
    public function currDel(Request $request){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return ['status'=>402,'msg'=>'请登录'];
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        $curr_id = intval($request->post('curr_id'));
        if(empty($curr_id)){
            return ['status'=>108,'msg'=>'请选择课程'];
        }
        //验证此课程是不是此讲师的
        $curr = Curr::where(['t_id'=>$teacher_id,'curr_id'=>$curr_id])->first();
        if(empty($curr)){
            return ['status'=>105,'msg'=>'您没有此课程'];
        }
        //删除此课程
        $result = Curr::where('curr_id',$curr_id)->delete();
        $chapterResult = Chapter::where(['curr_id'=>$curr_id])->delete();
        $classResult = ClassHour::where(['curr_id'=>$curr_id])->delete();
        if($result!==false && $chapterResult !== false && $classResult !==false){
            return ['status'=>200,'msg'=>'操作成功'];
        }else{
            return ['status'=>109,'msg'=>'操作失败'];
        }
    }

    //递归处理课程分类
    private function currcate($cateInfo,$pid=0,$level=0){
        static $data=[];
        foreach ($cateInfo as $k=>$v){
            if($v['pid']==$pid){
                $v['level']=$level;
                $data[$k]=$v;
                $this->currcate($cateInfo,$v['curr_cate_id'],$level+1);
            }

        }
        return $data;
    }

    //视频文件上传
    public function upload(){
        $file = $_FILES;
        $fileInfo = base64_encode(file_get_contents($file['file']['tmp_name']));//文件数据
        $fileName = $_POST['name']; //文件名
        $size = $_POST['size']; //文件总大小6
        $currentChunk = $_POST['currentChunk'];//当前文件段数
        $chunks = $_POST['chunks']; //总段数
        $upload = new UploadedController();
        $res = $upload->upload($fileName,$size,$currentChunk,$chunks,$fileInfo);
        if(!$res){
            return ['status'=>124,'msg'=>$upload->uploadError()];
        }else{
            if(isset($res['currentChunk'])){
                return ['status'=>201,'msg'=>'ok','data'=>$res];
            }
            return ['status'=>200,'msg'=>'ok','data'=>$res];
        }
    }

    /**
     * [检测课程名称唯一性]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function checkCurrName(Request $request)
    {
        //接收课程名称
        $curr_name=$request->post('curr_name');
        //实例化模型类
        $currModel=new Curr();
        //查询课程名称是否存在
        $count=$currModel->where('curr_name',$curr_name)->count();
        //检测结果,返回响应
        if($count>0){
            echo $this->json_fail('课程名称已被占用');
        }else{
            echo $this->json_success();
        }
    }



    //课程视频上传
    public function currvideo(){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return ['status'=>402,'msg'=>'请登录'];
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        $currInfo = CurrModel::where(['t_id'=>$teacher_id,'status'=>2,'curr_status'=>1,'curr_type'=>2])->get();
        return view('curr.curr_video',['currInfo'=>$currInfo]);
    }
    
    //获取课时
    public function getClassHour(Request $request){
        $chapter_id = $request->post('chapter_id');
        $curr_id = $request->post('curr_id');
        //根据此章节id查询课时
        $ClassInfo = CurrClassHourModel::where(['chapter_id'=>$chapter_id])->get();
        return ['status'=>200,'data'=>$ClassInfo];
    }

    //视频文件上传执行
    public function videoUpload(){
        $file = $_FILES['file']??null;
        if(empty($file)){
            return ['status'=>108,'msg'=>'请选择文件上传'];
        }
        $fileName = $_POST['name']; //文件名
        $size = $_POST['size']; //文件总大小
        $currentChunk = $_POST['currentChunk']??1;//当前文件段数
        $chunks = $_POST['chunks']; //总段数
        $fileInfo = base64_encode(file_get_contents($file['tmp_name']));
        $upload = new UploadController();
        $res = $upload->upload($fileName,$size,$currentChunk,$chunks,$fileInfo);
        if(!$res){
            return ['status'=>'20001','msg'=>'upload faild',$upload->uploadError()];
        }else{
            if(isset($res['currentChunk'])){
                return ['status'=>'201','msg'=>'ok',$res];
            }
            return ['status'=>'200','msg'=>'ok',$res];
        }
    }

    //课程视频连接添加至数据库’
    public function videoAdd(Request $request){
        //接收课程数据
        $teacherInfo = $this->teacherInfo();
        if($teacherInfo['status']!=200){
            return ['status'=>402,'msg'=>'请登录0'];
        }
        $teacher_id = $teacherInfo['data']['t_id'];
        $chapter_id = $request->post('chapter_id');
        $class_id = $request->post('class_id');
        $curr_id = $request->post('curr_id');
        $video_url = $request->post('video_url');
        if(empty($curr_id)){
            return ['status'=>102,'msg'=>'请选择课程'];
        }
        if(empty($chapter_id)){
            return ['status'=>102,'msg'=>'请选择章节'];
        }
        if(empty($class_id)){
            return ['status'=>102,'msg'=>'请选择课时'];
        }
        if(empty($video_url)){
            return ['status'=>102,'msg'=>'请上传视频'];
        }

        //验证课程存在不存在
        $currResult = CurrModel::where(['t_id'=>$teacher_id,'curr_id'=>$curr_id,'status'=>2,'curr_status'=>1,'curr_type'=>2])->first();
        if(!$currResult){
            return ['status'=>120,'msg'=>'课程不存在'];
        }
        //验证章节
        $chapterInfo = Chapter::where(['curr_id'=>$curr_id,'chapter_id'=>$chapter_id])->first();
        if(!$chapterInfo){
            return ['status'=>121,'msg'=>'该课程下没有此章节'];
        }
        //验证课时是否存在
        $className = ClassHour::where(['chapter_id'=>$chapter_id,'class_id'=>$class_id])->first();
        if(!$className){
            return ['status'=>122,'msg'=>'课时不存在'];
        }
        //验证没问题，入库
        $result = ClassHour::where(['class_id'=>$className['class_id']])->update(['class_data'=>$video_url]);
        if($result){
            Chapter::where(['chapter_id'=>$chapter_id])->update(['class_num'=>$chapterInfo['class_num']+1]);
            return ['status'=>200,'msg'=>'添加成功'];
        }else{
            return ['status'=>123,'msg'=>'添加失败，请重试'];
        }
    }

    //课程编辑页面
    public function curr_edit($curr_id){
        $data = $this->teacherInfo();
        if($data['status']!=200){
            return redirect('/login/login');
        }
        //讲师信息
        $teacherInfo = $data['data'];
        //根据课程id查询此课程信息
        $where=[
            'curr_id'=>intval($curr_id),
            't_id'=>$teacherInfo['t_id']
        ];
        $currInfo = CurrModel::where($where)->first();
        if(empty($currInfo)){
            return ['status'=>108,'msg'=>'请选择正确的课程'];
        }
        return view('curr.curr_edit',['currInfo'=>$currInfo]);
    }

    //课程修改执行
    public function curr_update(Request $request){
        $curr_id = intval($request->post('curr_id'));
        if(empty($curr_id)){
            return ['status'=>107,'msg'=>'请修改正确的课程'];
        }
        $curr_name = $request->post('curr_name');
        $is_pay = intval($request->post('is_pay'));
        $curr_detail = $request->post('curr_detail');
        $curr_price = $request->post('curr_price');
        $curr_img = $request->post('img_url');
        if(empty($curr_name) || empty($is_pay) || empty($curr_detail) || empty($curr_img)){
            return ['status'=>107,'msg'=>'不可以有参数为空哦'];
        }

        #验证课程名称的唯一性
        $checkCurrName = CurrModel::where([['curr_id','<>',$curr_id],'curr_name'=>$curr_name])->first();
        if(!empty($checkCurrName)){
            return ['status'=>107,'msg'=>'此课程名称已经有人使用了哦'];
        }
        #课程修改的数据
        $curr_data=[
            'curr_name'=>$curr_name,
            'is_pay'=>$is_pay,
            'curr_img'=>$curr_img,
            'curr_detail'=>$curr_detail,
        ];
        if($is_pay == 2 && empty($curr_price)){
            $curr_data['curr_price']=$curr_price;
            return ['status'=>107,'msg'=>'请填写价格'];
        }

        //获取讲师信息
        $data = $this->teacherInfo();
        if($data['status']!=200){
            return redirect('/login/login');
        }
        //讲师信息
        $teacherInfo = $data['data'];
        #课程修改的条件
        $where=[
            'curr_id'=>intval($curr_id),
            't_id'=>$teacherInfo['t_id']
        ];
        #执行课程修改
        $curr_update_result = CurrModel::where($where)->update($curr_data);
        if($curr_update_result!==false){
            return ['status'=>200,'msg'=>'修改成功'];
        }else{
            return ['status'=>107,'msg'=>'修改失败，请稍后重试'];
        }
    }

    public function test(){
        $data = base64_encode('sdgjksgjkdsa');
        $ch = curl_init('http://teacher.admin.com/ntest1?data='.urlencode($data));
        $ch = curl_exec($ch);
    }

    public function test1(Request $request){
        dd($request->get('data'));
    }

}

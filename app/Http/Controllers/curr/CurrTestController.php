<?php

namespace App\Http\Controllers\Curr;

use Illuminate\Http\Request;
use App\Http\Controllers\Common\CommonController;
use App\Model\CurrCateModel;
use App\Model\CurrModel;
use App\Model\CurrChapterModel;
use App\Model\CurrClassHourModel;
/**
 * 课程测试模块类
 * class CurrTestController
 * @author   <[<gaojianbo>]>
 * @package  App\Http\Controllers\Curr
 * @date 2019-08-12
 */
class CurrTestController extends CommonController
{
	/**
	 * [课程测试页面]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
    public function test(Request $request)
    {
    	//实例化模型类
    	$currModel=new CurrModel();
    	//查询已上架的课程信息
    	$currInfo=$currModel->where('is_show',1)->get()->toArray();
    	//渲染视图
    	return view('test/test',compact('currInfo'));
    }

    /**
     * [获取课程的章节信息]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getChapter(Request $request)
    {
    	//获取课程id
    	$curr_id=$request->post('curr_id');
    	//实例化模型类
    	$chapterModel=new CurrChapterModel();
    	//获取课程章节信息
    	$chapterInfo=$chapterModel->where('curr_id',$curr_id)->orderBy('chapter_num','asc')->get()->toArray();
    	//课程下有章节直接返回
    	if(!empty($chapterInfo)){
    		return $chapterInfo;
    	}else{
    		return 2;
    	}
    }

    /**
     * [获取课程章节的课时信息]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getClass(Request $request)
    {
    	//获取课程章节id
    	$chapter_id=$request->post('chapter_id');
    	//实例化模型类
    	$classHourModel=new CurrClassHourModel();
    	//获取课程章节课时信息
    	$classHourInfo=$classHourModel->where('chapter_id',$chapter_id)->where('class_type',2)->orderBy('class_hour_num','asc')->get()->toArray();
    	//课程章节下有课时直接返回
    	if(!empty($classHourInfo)){
    		return $classHourInfo;
    	}else{
    		return 2;
    	}
    }

    /**
     * [获取课时下的视频]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getVideo(Request $request)
    {
    	//获取课时id
    	$class_id=$request->post('class_id');
    	//实例化模型类
    	$classHourModel=new CurrClassHourModel();
    	//获取课时视频
    	$class_video=$classHourModel->where('class_id',$class_id)->value('class_data');
    	//课时下有视频直接返回
    	if(!empty($class_video)){
    		return $class_video;
    	}else{
   			return 2;
    	}
    }
}

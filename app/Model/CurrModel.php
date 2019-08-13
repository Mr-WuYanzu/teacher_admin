<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
/**
 * 课程模型类
 * class CurrModel
 * @author   <[<gaojianbo>]>
 * @package  App\Model
 * @date 2019-08-12
 */
class CurrModel extends Model
{
    //指定表名
    public $table='curr';
    //指定主键
    public $primaryKey='curr_id';
    //关闭时间戳自动写入
    public $timestamps=false;
    //关联课程分类表(逆向一对多)
    public function cate()
    {
    	return $this->belongsTo('App\Model\CurrCateModel','curr_cate_id','curr_cate_id');
    }
    //关联章节表(一对多)
    public function chapter()
    {
    	return $this->hasMany('App\Model\CurrChapterModel','curr_id','curr_id');
    }
}

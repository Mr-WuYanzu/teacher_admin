<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
/**
 * 课程分类模型类
 * class CurrCateModel
 * @author   <[<gaojianbo>]>
 * @package  App\Model
 * @date 2019-08-12
 */
class CurrCateModel extends Model
{
    //指定表名
    public $table='curr_cate';
    //指定主键
    public $primaryKey='curr_cate_id';
    //关闭时间戳自动写入
    public $timestamps=false;
}

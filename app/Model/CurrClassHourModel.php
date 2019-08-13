<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
/**
 * 课程课节模型类
 * class CurrClassHourModel
 * @author   <[<gaojianbo>]>
 * @package  App\Model
 * @date 2019-08-12
 */
class CurrClassHourModel extends Model
{
    //指定表名
    public $table='curr_class_hour';
    //指定主键
    public $primaryKey='class_id';
    //关闭时间戳自动写入
    public $timestamps=false;
}

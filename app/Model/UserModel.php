<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
/**
 * 用户模型类
 * class UserModel
 * @author   <[<gaojianbo>]>
 * @package  App\Model
 * @date 2019-08-14
 */
class UserModel extends Model
{
	//指定表名
    public $table='user';
    //指定主键
    public $primaryKey='user_id';
    //关闭时间戳自动写入
    public $timestamps=false;
}

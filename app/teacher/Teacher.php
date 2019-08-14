<?php

namespace App\teacher;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public $table='teacher';
    public $primaryKey='t_id';
    public $timestamps=false;
}

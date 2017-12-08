<?php
/**
 * Created by PhpStorm.
 * User: QiuSama
 * Date: 2017/12/7
 * Time: 22:24
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['title','path','user_id'];
}
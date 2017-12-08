<?php
/**
 * Created by PhpStorm.
 * User: QiuSama
 * Date: 2017/12/8
 * Time: 9:36
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Relations extends Model
{
    public function hasManyComments()
    {
        return $this->hasMany('App\Relation', 'id', 'id');
    }
}
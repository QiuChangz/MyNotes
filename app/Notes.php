<?php
/**
 * Created by PhpStorm.
 * User: QiuSama
 * Date: 2017/12/7
 * Time: 22:21
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    public function hasManyNotes()
    {
        return $this->hasMany('App\Note', 'user_id', 'id');
    }
}
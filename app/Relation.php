<?php
/**
 * Created by PhpStorm.
 * User: QiuSama
 * Date: 2017/12/8
 * Time: 9:33
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{

    protected $table = 'relation';
    protected $fillable=['user_id','following_id','perssion','following_name'];

    public function getFollowingIdAttribute($value){
        return ucfirst($value);
    }

}
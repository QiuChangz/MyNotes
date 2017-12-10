<?php
/**
 * Created by PhpStorm.
 * User: QiuSama
 * Date: 2017/12/10
 * Time: 14:22
 */

namespace App\Http\Controllers\Admin;


use Illuminate\Database\Eloquent\Model;
use App\Relation;
use Illuminate\Support\Facades\Auth;

class RelationController extends Model
{
    public function edit($user_id){
        $relation = new Relation();
        $relation->user_id = Auth::id();
        $relation->following_id = $user_id;
        $relation->permission = '可读';
        $exits = Relation::find(Auth::id());//查询关系表中是否已经存在following关系
        if(is_array($exits)){
            foreach ($exits as $exit){
                if($exit->following_id == $user_id){
                    return redirect()->back()->withInput()->withErrors('您已经关注了对方！');
                }
            }
        }
        if($relation->save()){
            return redirect()->back()->withInput()->withRelation('followed');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }

    }

}
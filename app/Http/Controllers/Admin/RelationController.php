<?php
/**
 * Created by PhpStorm.
 * User: QiuSama
 * Date: 2017/12/10
 * Time: 14:22
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Note;
use App\User;
use App\Relation;
use Illuminate\Support\Facades\Auth;

class RelationController extends Controller
{
    public function index(){
        $relation = Relation::where('user_id',Auth::id())->get();
        return view('user.followed')->with('relations',$relation);
    }

    public function edit($user_id){

        $relation = new Relation();
        $relation->user_id = Auth::id();
        $relation->following_id = $user_id;
        $relation->permission = '可读';
        $relation->following_name = User::find($user_id)->name;
        $exits = Relation::where('user_id',Auth::id())->get();//查询关系表中是否已经存在following关系
        if($exits->contains('following_id',$user_id)){
            return redirect()->back()->withInput()->withStatus('您已经关注过对方了！')->withRelation('followed');
        }
        if($relation->save()){
            return redirect()->back()->with('relation','followed')->withInput()->withStatus('成功关注了对方！')->withRelation('followed');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }

    }

    public function destroy($id)
    {
        Relation::where('user_id',Auth::id())->where('following_id',$id)->delete();
        return redirect()->back()->withInput()->withStatus('Unfollow Successfully！');
    }

    public function show(){
        $following = Relation::where('following_id',Auth::id())->get();
        foreach ($following as $relation){
            $relation->following_name = User::find($relation->user_id)->name;
        }
        return view('user.following')->with('relations',$following);
    }

    public function create(){
        $followers = Relation::where('user_id',Auth::id())->get();
        $result=[];
        $count=0;
        foreach ($followers as $follower){
            $notes = Note::where('user_id',$follower->following_id)->get();
            foreach ($notes as $note){
                $note_content = array('following_name'=>$follower->following_name,
                                        'user_id'=>$follower->following_id,
                                        'create_time'=>$note->created_at->toDateTimeString(),
                                        'title'=>$note->title,
                                        'content'=>$note->path);
                $result[$note->created_at->toDateTimeString()]=$note_content;
            }
        }
        krsort($result);

        return view('user.moments')->withNotes($result);
    }

}
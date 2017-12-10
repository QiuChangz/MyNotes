<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Note;
use App\Relation;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    //
    public function index(Request $request){

        $search_note=$request->get('note');
        $search_user=$request->get('name');
        $note=Note::where('user_id',Auth::id())->where('path','like','%'.$search_note.'%')->get();
        $user=User::where('name','like','%'.$search_user.'%')->get();

        /**
         * 判断用户输入是否为空
         */
        if($search_user == ''){
            $user = [];
        }
        if($search_note == ''){
            $note = [];
        }

        //if($note.isEmpty()||is_array($note)){}
        return view('guest.search')->with('note_results',$note)
                                        ->with('user_results',$user);
    }

    public function show($user_id){
        $relations = Relation::find(Auth::id());
        if(is_array($relations)){
            foreach ($relations as $follow){
                if($follow->following_id == $user_id){
                    return view('user.profile')->with('user',User::find($user_id))->withRelation('followed');
                }
            }
        }
        return view('user.profile')->with('user',User::find($user_id))->withRelation('following');

    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Note;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    //
    public function show(Request $request){

        $search_note=$request->get('note');
        $search_user=$request->get('name');
        $note=Note::where('user_id',Auth::id())
                    ->where('path','LIKE','%'.$search_note.'%')->get();
        $user=User::where('name','LIKE','%'.$search_user.'%')->get();
        return view('guest.search')->with('note_results',$note)
                                        ->with('user_results',$user);
    }

}

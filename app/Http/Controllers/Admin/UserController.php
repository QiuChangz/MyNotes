<?php

namespace App\Http\Controllers\Admin;

use App\Notes;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Note;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index(){
        return view('user.profile');
    }

    public function show($user_id){
        $notes=User::find($user_id)->Notes;
        return view('home')->with(['notes' => $notes]);
    }
    public function create()
    {
        return view('user.create');
    }

    public function edit($id)
    {
        return view('user/edit')->withNote(Note::find($id));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:notes|max:255',
            'body' => 'required',
        ]);

        $notes = new Note;
        $notes->title = $request->get('title');
        $notes->path = $request->get('body');
        $notes->user_id = $request->user()->id;

        if ($notes->save()) {
            $note=User::find(Auth::id())->Notes;
            return redirect('home')->with(['notes' => $note]);
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|unique:notes,title,'.$id.'|max:255',
            'body' => 'required',
        ]);
        $note = Note::find($id);
        $note->title = $request->get('title');
        $note->path = $request->get('body');
        if ($note->save()) {
            $notes=User::find(Auth::id())->Notes;
            return redirect('home')->with(['notes' => $notes]);
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    public function destroy($id)
    {
        Note::find($id)->delete();
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }
}

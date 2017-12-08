<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Note;

class UserController extends Controller
{
    //
    public function index(){
        return view('user.profile');
    }

    public function show($id){
        return view('user')->withNotes(Note::with('hasManyNotes')->find($id));
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
            return redirect('home');
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
            return redirect('user');
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

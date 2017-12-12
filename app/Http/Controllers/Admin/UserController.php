<?php

namespace App\Http\Controllers\Admin;

use App\Notes;
use App\Relation;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Note;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index(){
        $notes = Note::where('user_id',Auth::id())->get();
        return view('user.profile')->with('user',Auth::user())->with('notes',$notes);
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
        if($request->hasFile('file')){
            $file = $request->file('file');
            //判断文件上传过程中是否出错
            if(!$file->isValid()){
                return redirect()->back()->withInput()->withErrors('文件保存失败！');
            }
            $destPath = realpath(public_path('files'));
            if(!file_exists($destPath))
                mkdir($destPath,0755,true);
            $filename = $file->getClientOriginalName();
            if(!$file->move($destPath,$filename)){
                return redirect()->back()->withInput()->withErrors('文件保存失败！');
            }
        }

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

    public function download($note_id){
        $note = Note::find($note_id);

        $pdf = new \TCPDF();
        // 设置文档信息
        $pdf->SetCreator(Auth::user()->name);
        $pdf->SetAuthor(Auth::user()->name);
        $pdf->SetTitle($note->title);
        $pdf->SetSubject('PDF');
        $pdf->SetKeywords('TCPDF, PDF, PHP');

        // 设置页眉和页脚信息
        $pdf->SetHeaderData('MyNotes.png', 30, 'MyNotes!', '管理笔记，提升效率！', [0, 64, 255], [0, 64, 128]);
        $pdf->setFooterData([0, 64, 0], [0, 64, 128]);

        // 设置页眉和页脚字体
        $pdf->setHeaderFont(['stsongstdlight', '', '10']);
        $pdf->setFooterFont(['helvetica', '', '8']);

        // 设置默认等宽字体
        $pdf->SetDefaultMonospacedFont('courier');

        // 设置间距
        $pdf->SetMargins(15, 15, 15);//页面间隔
        $pdf->SetHeaderMargin(5);//页眉top间隔
        $pdf->SetFooterMargin(10);//页脚bottom间隔

        // 设置分页
        $pdf->SetAutoPageBreak(true, 25);

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        //设置字体 stsongstdlight支持中文
        $pdf->SetFont('stsongstdlight', '', 14);

        //第一页
        $pdf->AddPage();
        $pdf->writeHTML('<div style="text-align: center"><h1>'.$note->title.'</h1></div>');
        $contents = explode(PHP_EOL,$note->path);
        foreach ($contents as $content){
            $pdf->writeHTML('<p>'.$content.'</p>');
        }
        $pdf->Ln(5);//换行符
//        $pdf->writeHTML('<p><a href="http://www.lanrenkaifa.com/" title="">懒人开发网</a></p>');
//
//        //第二页
//        $pdf->AddPage();
//        $pdf->writeHTML('<h1>第二页内容</h1>');

        //输出PDF
        $pdf->Output($note->title.'.pdf', 'D');
        return Response::download($pdf, '自定义文件名');
    }

}

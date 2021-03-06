@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">新增笔记</div>
                    <div class="panel-body">
                        <form action="{{ url('user') }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="text" name="title" class="form-control" required="required" placeholder="请输入标题">
                            <br>
                            <textarea name="body" rows="10" class="form-control" required="required" placeholder="请输入内容"></textarea>
                            <br>
                            <input type="file" class="form-control" name="file">
                            <button class="btn btn-lg btn-info">新增笔记</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
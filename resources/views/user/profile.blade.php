
@extends('layouts.app')

@section('navbar')
    <form action="{{ url('search') }}" method="POST">
        {!! csrf_field() !!}
        <input type="text" name="note" class="form-control" placeholder="请输入搜索内容" size="10">
        <input type="text" name="name" class="form-control" placeholder="请输入用户名" size="10">
        <button type="submit" class="btn btn-default">搜索</button>
    </form>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                {!! implode('<br>', $errors->all()) !!}
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="panel-body">

                            @if ($user->id == Auth::id())
                            <a href="{{ url('/user/create') }}" class="btn btn-lg btn-success col-xs-2">添加笔记</a>
                            @elseif(str_contains($relation,'ed')||session('relation'))
                                <div class="panel-info">
                                    <div class="panel-content">用户名：{{ $user->name }}</div>
                                    <div class="panel-content">年龄：{{ $user->age }}</div>
                                    <div class="panel-content">邮箱：{{ $user->email }}</div>

                                </div>
                                <div name="unfollow">
                                <form action="{{ url('relation/'.$user->id) }}" method="POST" style="display: inline;">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger">unfollow</button>
                                </form>
                                </div>


                            @else
                                <div class="panel-info">
                                    <div class="panel-content">用户名：{{ $user->name }}</div>
                                    <div class="panel-content">年龄：{{ $user->age }}</div>
                                    <div class="panel-content">邮箱：{{ $user->email }}</div>

                                </div>
                                <a href="{{ url('/relation/'.$user->id.'/edit') }}" id='isFollowing' class="btn btn-lg btn-success col-xs-2">{{ $relation }}</a>
                            @endif

                        </div>


                            @foreach($notes as $note)
                                <div class="panel-title">
                                    <div class="panel-content col-xs-2">
                                        <h3>
                                            <a href="{{ url($note->user_id.'/profile') }}" class="btn btn-lg" >{{ $note->title }}</a>
                                        </h3>
                                    </div>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <div class="panel-body">
                                        <h5>{{ $note->path }}</h5>
                                    </div>
                                </div>
                            @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('navbar')
    <form action="{{ url('search') }}" method="POST">
        {!! csrf_field() !!}
        <input type="text" name="note" class="form-control" placeholder="请输入搜索内容" size="10" />
        <input type="text" name="name" class="form-control" placeholder="请输入用户名" size="10" />
        <button type="submit" class="btn btn-default">搜索</button>
    </form>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">搜索结果</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                {!! implode('<br>', $errors->all()) !!}
                            </div>
                        @endif

                        @foreach ($user_results as $user)
                                <hr>
                                <div class="user">
                                    <h4>
                                        <a href="{{ url($user->id.'/profile') }}" class="btn btn-lg" >{{ $user->name }}</a>
                                    </h4>
                                    <div class="content">
                                        <p>
                                            age:{{ $user->age }}
                                        </p>
                                    </div>
                                </div>

                            @endforeach

                        @foreach ($note_results as $note)
                            <hr>
                            <div class="note">
                                <h4>{{ $note->title }}</h4>
                                <div class="content">
                                    <p>
                                        {{ $note->path }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ url('user/'.$note->id.'/edit') }}" class="btn btn-success">查看</a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
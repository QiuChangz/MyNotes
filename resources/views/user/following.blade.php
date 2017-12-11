
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

                            <h4>您的关注人数：{{ count($relations) }}</h4>
                            @if(count($relations)>0)
                                <ul class="list-group">
                                @foreach($relations as $relation)
                                    <div class="panel-info">
                                        <li class="list-group-item">
                                        <a href="{{ url($relation->user_id.'/profile') }}" class="btn btn-lg" >{{ $relation->following_name }}</a>
                                        </li>
                                    </div>
                                @endforeach
                                </ul>
                            @else
                                <div class="panel-content">
                                    您暂时没有粉丝，快去邀请好友！
                                </div>
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

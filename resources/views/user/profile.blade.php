
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Welcome，{{ Auth::user()->name }}</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="panel-info">
                            <div class="panel-content">用户名：{{ Auth::user()->name }}</div>
                            <div class="panel-content">年龄：{{ Auth::user()->age }}</div>
                            <div class="panel-content">邮箱：{{ Auth::user()->email }}</div>
                        </div>
                        <div class="panel-body">

                            <a href="{{ url('/user/create') }}" class="btn btn-lg btn-success col-xs-12">添加笔记</a>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

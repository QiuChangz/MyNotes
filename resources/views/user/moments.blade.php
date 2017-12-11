
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

                        <h4>Moments</h4>
                            @foreach($followers as $follow)
                                <h1>{{ $follow->title }}</h1>
                            @endforeach
                        @if(!empty($notes))
                            <h1>asdfas</h1>
                            @foreach($notes as $name=>$contents)
                                @foreach($contents as $title=>$content)
                                <div>
                                    {{ $name }}
                                </div>
                                    <div>
                                        {{ $title }}
                                    </div>

                                    <div>
                                        {{ $content }}
                                    </div>
                                @endforeach
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

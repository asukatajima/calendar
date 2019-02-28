@extends('layouts.app')

@section('content')
@if (Auth::check())
@include('events.index')
@else
        <div class="text-center">
            <div style="margin-top: 100px; margin-bottom: 100px;">
            <h1>シンプルなカレンダーで簡単スケジュール管理</h1>
            </div>
        </div>
        <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div style="margin-bottom: 50px;">
            <div class="text-center">
            {!! link_to_route('signup.get', '新規登録', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
            </div>
            {!! Form::open(['route' => 'login.post']) !!}
                <div class="form-group">
                    {!! Form::label('email', 'メールアドレス') !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'パスワード') !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('ログイン', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}

            
        </div>
    </div>
    </div>
    @endif
@endsection
@extends('layouts.default')
@section('body')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h2>Register here</h2>
        {{ Form::open(['action' => 'UserController@store', 'files'=>true]) }}
        <div class="form-group">
            {{ Form::text('username', null, ['class'=>'input-block-level form-control', 'placeholder'=>'User name']) }}
        </div>
        <div class="form-group">
            {{ Form::text('email', null, ['class'=>'input-block-level form-control', 'placeholder'=>'Email Address']) }}
        </div>
        <div class="form-group">
            {{ Form::password('password', ['class'=>'input-block-level form-control', 'placeholder'=>'Password']) }}
        </div>
        <div class="form-group">
            {{ Form::label('avatar_url','Avatar',['id'=>'','class'=>'']) }}
            <span class="btn btn-file">{{ Form::file('avatar_url',['id'=>'avatar_url','class'=>'']) }}</span>
            <img src="#" id="avatar_preview" style="display:none;width:60px;height:60px;"/>
        </div>
        {{Form::submit('Register', ['class' => 'btn btn-primary'])}}
        {{ Form::close() }}
    </div>
</div>

{{ HTML::script('js/users/avatar.js') }}

@stop

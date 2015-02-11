@extends('layouts.default')
@section('body')
<div class="container">
    <div class="user-login col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info" >
            <div class="panel-heading">
                <div class="panel-title">Login</div>
            </div>
            <div class="panel-body" >
                <div id="message_error"></div>
                @if ($errors->has() || Session::has('message'))
                    <div class="alert {{ Session::has('message') ? 'alert-danger' : 'alert-success' }}" id="alert-message">
                        @foreach($errors->all() as $message)
                            <p>{{ $message }}</p>
                        @endforeach
                        @if (Session::has('message'))
                            <p>{{ Session::get('message') }}</p>
                        @endif
                    </div>
                @endif
                {{ Form::open(['action' => 'UserController@postLogin', 'class' => 'form-horizontal', 'id' => 'login-form', 'role' => 'form']) }}
                    <div class="input-group mg-bottom-15">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) }}
                    </div>
                    <div class="input-group mg-bottom-5">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter Password']) }}
                    </div>
                    <div class="input-group mg-bottom-15">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('remember', 1, true) }}
                                <span>Remember me</span>
                            </label>
                        </div>
                    </div>
                    <div class="input-group mg-bottom-15">
                        {{ Form::submit('Login', ['class' => 'btn btn-info']) }}
                        <div class="mg-top-15 alternative-method">
                            <span>
                                Don't have an account!
                            </span>
                            <a href="{{ URL::action('UserController@getRegister') }}">Sign Up Here</a>
                        </div>
                        <div class="mg-top-15 alternative-method">
                            <span>
                                Resend the activation email!
                            </span>
                            <a href="{{ URL::action('UserController@login') }}">Active Here</a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@stop

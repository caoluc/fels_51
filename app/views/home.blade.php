@extends('layouts.default')

@section('css')

@stop

@section('body')
<div class="container">
    <div class="col-xs-6 col-sm-3 ">
        @if($currentUser)
            <img src="{{ asset($currentUser->avatar_url) }}" width="150" height="150">
            <div>{{{ $currentUser->username }}}</div>
            <div>Learned</div>
        @endif
    </div>
    <div class="col-xs-6 col-sm-6">
        <div class="row">
            <div>
                {{ Form::submit('Words', ['class' => 'btn btn-default']) }}
                {{ Form::submit('Lesson', ['class' => 'btn btn-default']) }}
            </div>
            <br>
            <div>
                <strong>Activities</strong>
                <hr>
            </div>
            <div>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')

@stop
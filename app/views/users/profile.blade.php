@extends('layouts.default')

@section('css')

@stop

@section('body')
<div class="container">
    <div class="col-xs-6 col-sm-3 ">
        @if($currentUser)
            <img src="{{ asset(UserService::find($id)->avatar_url) }}" width="150" height="150">
            <div>{{{ UserService::find($id)->username }}}</div>
            <div>Learned {{ WordService::getTotalLearned($id) }} words</div>
        @endif
    </div>
    <div class="col-xs-6 col-sm-6">
        <div class="row">
            <div>
                <strong>Activities</strong>
                @if ($currentUser->id != $id)
                    @if (UserService::follow($currentUser->id, $id))
                        <div class="follow">You are following this person</div>
                    @else
                        {{ Form::open(['action' => ['UserController@follow', $id]]) }}
                        {{ Form::submit('Follow', ['class' => 'btn btn-info']) }}
                        {{ Form::close() }}
                    @endif
                @endif
                <hr>
                <div>
                    @if (!$nonActivity)
                        @foreach ($activities as $activity)
                        <div class="activity-list">
                            <a href="/user/{{ $activity->user_id }}">{{ HTML::image(asset(UserService::find($activity->user_id)->avatar_url),'',['width' => 50, 'height' => 50]) }}</a>
                            Learned {{{ Config::get('lesson.word_num') }}} word in Lesson "{{{ CategoryService::getName($activity->category_id) }}}" - ({{ getFormattedDate(LessonService::getTimeFinish($activity->lesson_id)) }})
                            <br>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')

@stop

@extends('layouts.default')

@section('css')

@stop

@section('body')
<div class="container">
    <div class="col-xs-6 col-sm-3 ">
        @if($currentUser)
            <img src="{{ asset($currentUser->avatar_url) }}" width="150" height="150">
            <div>{{{ $currentUser->username }}}</div>
            <div>Learned {{ WordService::getTotalLearned($currentUser->id) }} words</div>
        @endif
    </div>
    <div class="col-xs-6 col-sm-6">
        <div class="row">
            <div>
                <strong>Activities</strong>
                <hr>
                <div>
                    @foreach ($activities as $activity)
                    <div class="activity-list">
                        <img src="{{ asset($currentUser->avatar_url) }}" width="50" height="50">
                        Learned {{{ Config::get('lesson.word_num') }}} word in Lesson "{{{ CategoryService::getName($activity->category_id) }}}" - ({{ getFormattedDate(LessonService::getTimeFinish($activity->lesson_id)) }})
                        <br>
                    </div>
                    @endforeach
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

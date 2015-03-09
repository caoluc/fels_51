@extends('layouts.default')

@section('css')

@stop

@section('body')
<div class="container col-md-6 col-md-offset-3">
    @foreach ($categories as $category)
        <div>
            <strong class="category-header">{{{ $category->name }}}</strong>
            You've learned {{ WordService::getLearnedNum($category->id) }} / {{ WordService::getTotalWord($category->id) }}
        </div>
        <div>
            {{{ $category->description }}}
        </div>
        {{ link_to_action('LessonController@question', 'Start', [$category->id], ['class' => 'btn btn-info']) }}
    @endforeach
</div>

@stop

@section('script')

@stop

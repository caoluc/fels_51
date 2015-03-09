@extends('layouts.default')

@section('css')

@stop

@section('body')
<div class="container">
    @if ($checkComplete)
    You have leared all word in category
    @else
        <div>
            <strong>{{ CategoryService::getName($currentLesson->category_id) }}</strong>
            {{ AnswerSheetService::answerCount($currentLesson->id) }}/{{ LessonService::getMaxWordLesson($categoryId) }}
        </div>
        <div class="question">
            <div class="question-left">
                {{ WordService::show($question[$learnNum]) }}
            </div>
            <div class="question-right">
                <div>
                    {{ link_to_action('LessonController@submit', AnswerSheetService::show($answerSheet->answer_0), [$answerSheet->id, $answerSheet->answer_0], ['class' => 'question-answer btn btn-default']) }}
                </div>
                <div>
                    {{ link_to_action('LessonController@submit', AnswerSheetService::show($answerSheet->answer_1), [$answerSheet->id, $answerSheet->answer_1], ['class' => 'question-answer btn btn-default']) }}
                </div>
                <div>
                    {{ link_to_action('LessonController@submit', AnswerSheetService::show($answerSheet->answer_2), [$answerSheet->id, $answerSheet->answer_2], ['class' => 'question-answer btn btn-default']) }}
                </div>
                <div>
                    {{ link_to_action('LessonController@submit', AnswerSheetService::show($answerSheet->answer_3), [$answerSheet->id, $answerSheet->answer_3], ['class' => 'question-answer btn btn-default']) }}
                </div>
            </div>
        </div>
    @endif

</div>
<div>

</div>

@stop

@section('script')

@stop

@extends('layouts.default')

@section('css')

@stop

@section('body')
<div class="container">
    <div class="result-list">
        <strong>{{{ $category->name }}} Result</strong>
        {{ AnswerSheetService::answerCount($lessonId) }}/{{ Config::get('lesson.word_num') }}
    </div>
    <table class="result-list">
        @foreach ($answerSheets as $answerSheet)
        <tr>
            <td class="result-list">
                @if (AnswerSheetService::checkResult($answerSheet)) <div class="glyphicon glyphicon-ok"></div>
                @else <div class="glyphicon glyphicon-remove"></div>
                @endif
            </td>
            <td class="result-list">{{ WordService::show($answerSheet->word_id) }}</td>
            <td class="result-list">{{ AnswerSheetService::show($answerSheet->user_answer_id) }}</td>
        </tr>
        @endforeach
    </table>
<div>

</div>

@stop

@section('script')

@stop

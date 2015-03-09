@extends('layouts.default')

@section('css')

@stop

@section('body')
<div class="container col-md-6 col-md-offset-3">
    <div class="view-header">
        <div class="view-header-title">Words list</div>
    </div>

    <strong>Category</strong>

    <div>
        {{ Form::open(['action' => 'WordController@listWord']) }}
            {{ Form::select('category', $categoryData, null, ['class' => 'field']) }}

            @foreach ($filters as $name => $filter)
                {{ Form::radio('filter', $name) }} {{{ $filter }}}
            @endforeach
            {{ Form::submit('Filter', ['class' => 'btn']) }}
        {{ Form::close() }}
    </div>
    <div>
        @if (!empty($words))
            <strong>{{{ $categoryData[$categoryId] }}}</strong>
            <div>
                @foreach ($words as $word)
                <div class="row">
                    <div class="col-md-2">{{{ $word->content }}}</div>
                    <div class="col-md-2">{{{ WordService::getAnswer($word->id) }}}</div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@stop

@section('script')

@stop

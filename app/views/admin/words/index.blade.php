@extends('layout_admins.application')

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
<script src="{{ url_ex('js/pages/words/index.js') }}"></script>
<script src="{{ url_ex('js/plugins/bootstrap-growl/bootstrap-growl.js') }}"></script>
<script src="{{ url_ex('js/shared/datalist.js') }}"></script>
@stop

@section('title')
{{{ $title }}}
@stop

@section('content')
<a class="float: left; btn btn-info" data-bind="click: add">{{{ Lang::get('messages.label.addnew') }}}</a> <a class="float: left; btn btn-info" data-bind="click: saveall($element)">{{{ Lang::get('messages.label.saveall') }}}</a>

<div style="padding-bottom: 20px; float: right;">
    <form data-bind="submit: changeLimit" class="float: right, position: relative"><input data-bind="value: limit"></form>
</div>
<table class="table table-striped">
    <tr id="headers">
        <th id="id" style="width: 60px" data-bind="click: sort">ID<span>^</span></th>
        <th id="category_id" style="width: 20%" data-bind="click: sort">Category Name<span></span></th>
        <th id="content" style="width: 20%" data-bind="click: sort">Name<span></span></th>
        <th id="answer_content" style="width: 20%">Mean<span></span></th>
        <th style="width: 180px">&nbsp;</th>
    </tr>
    <tbody data-bind="foreach: data" style="font-size: 140%;">
    <tr>
        <td data-bind="click: edit, text: id"></td>
        <td data-bind="click: edit"><form>{{ Form::select('categoryID', Category::orderBy('name')->lists('name', 'id'), 'category_id', array('data-bind' => 'value : category_id_edit, enable: editing()', 'style' => 'width : 150px; font-size: 14px;')) }}</form>
        </td>

        <td data-bind="click: edit">
            <span data-bind="visible: !editing(), text: content"></span>
            <form data-bind="if: editing(), submit: save.bind($data, $element)">
                <input data-bind=" value : content_edit, valueUpdate: ['afterkeydown', 'input']">
            </form>
        </td>

        <td data-bind="click: edit">
            <span data-bind="visible: !editing(), text: answer_content"></span>
            <form data-bind="if: editing(), submit: save.bind($data, $element)">
                <input data-bind=" value : answer_content_edit, valueUpdate: ['afterkeydown', 'input']">
            </form>
        </td>

        <td>
            <span data-bind="visible: !editing()"><a class="btn btn-info" data-bind="click: edit">{{{ Lang::get('messages.label.edit') }}}</a> <a class="btn btn-danger ladda-button" data-style="slide-down" data-size="l" data-bind="click: remove.bind($data, $element)">{{{ Lang::get('messages.label.delete') }}}</a></span>
            <span data-bind="visible: editing()"><a class="btn btn-info ladda-button" data-style="slide-down" data-size="l" data-bind="click: save.bind($data, $element)"><span class="ladda-label">{{{ Lang::get('messages.label.save') }}}</span></a> <a class="btn btn-warning" data-bind="click: cancel">{{{ Lang::get('messages.label.cancel') }}}</a></span>
        </td>
    </tr>
    </tbody>
</table>
<ul class="pager">
    <li><a href="#" data-bind="click: prev">{{{ Lang::get('pagination.previous') }}}</a></li>
    <li><a href="#" data-bind="click: next">{{{ Lang::get('pagination.next') }}}</a></li>
</ul>
@stop


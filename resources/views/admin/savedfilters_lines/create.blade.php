@extends('layouts.admin')

@section('title', $savedfilters_line::getMsgTrans('create_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $savedfilters_line::getMsgTrans('create_heading')])

    @include('partials._alerts')

    {{ html()->form('POST', route('admin.savedfilters_lines.store'))->class('')->open() }}

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                @include('partials.inputs._text', ['name' => 'saved_id', 'label' => $savedfilters_line::getAttrsTrans('saved_id').'*'])
            </div>
        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.savedfilters_lines.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}
@stop


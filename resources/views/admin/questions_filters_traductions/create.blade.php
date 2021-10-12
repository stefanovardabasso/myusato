@extends('layouts.admin')

@section('title', $questions_filters_traduction::getMsgTrans('create_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $questions_filters_traduction::getMsgTrans('create_heading')])

    @include('partials._alerts')

    {{ html()->form('POST', route('admin.questions_filters_traductions.store'))->class('')->open() }}

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                @include('partials.inputs._text', ['name' => 'cod_fam', 'label' => $questions_filters_traduction::getAttrsTrans('cod_fam').'*'])
            </div>
        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.questions_filters_traductions.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}
@stop


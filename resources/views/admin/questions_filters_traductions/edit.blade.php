@extends('layouts.admin')

@section('title', $questions_filters_traduction::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $questions_filters_traduction::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($questions_filters_traduction, 'PUT', route('admin.questions_filters_traductions.update', [$questions_filters_traduction]))->open() }}

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


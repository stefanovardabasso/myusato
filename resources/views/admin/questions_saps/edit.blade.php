@extends('layouts.admin')

@section('title', $questions_sap::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $questions_sap::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($questions_sap, 'PUT', route('admin.questions_saps.update', [$questions_sap]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'code_q', 'label' => $questions_sap::getAttrsTrans('code_q').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.questions_saps.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


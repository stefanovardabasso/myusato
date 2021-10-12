@extends('layouts.admin')

@section('title', $sap::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $sap::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($sap, 'PUT', route('admin.saps.update', [$sap]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'date', 'label' => $sap::getAttrsTrans('date').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.saps.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


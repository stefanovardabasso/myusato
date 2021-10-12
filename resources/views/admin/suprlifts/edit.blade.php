@extends('layouts.admin')

@section('title', $suprlift::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $suprlift::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($suprlift, 'PUT', route('admin.suprlifts.update', [$suprlift]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'offert_id', 'label' => $suprlift::getAttrsTrans('offert_id').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.suprlifts.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


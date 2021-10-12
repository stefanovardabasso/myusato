@extends('layouts.admin')

@section('title', $macu::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $macu::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($macu, 'PUT', route('admin.macus.update', [$macu]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'offert_id', 'label' => $macu::getAttrsTrans('offert_id').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.macus.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


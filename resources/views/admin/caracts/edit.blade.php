@extends('layouts.admin')

@section('title', $caract::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $caract::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($caract, 'PUT', route('admin.caracts.update', [$caract]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'cc', 'label' => $caract::getAttrsTrans('cc').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.caracts.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


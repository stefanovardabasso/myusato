@extends('layouts.admin')

@section('title', $component::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $component::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($component, 'PUT', route('admin.components.update', [$component]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'offert_id', 'label' => $component::getAttrsTrans('offert_id').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.components.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


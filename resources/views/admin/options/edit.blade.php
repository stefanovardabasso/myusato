@extends('layouts.admin')

@section('title', $option::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $option::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($option, 'PUT', route('admin.options.update', [$option]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'user_id', 'label' => $option::getAttrsTrans('user_id').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.options.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


@extends('layouts.admin')

@section('title', $vtu::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $vtu::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($vtu, 'PUT', route('admin.vtus.update', [$vtu]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'email', 'label' => $vtu::getAttrsTrans('email').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.vtus.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


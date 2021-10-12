@extends('layouts.admin')

@section('title', $role::getMsgTrans('update_heading'))

@section('content')
@include('partials._content-heading', ['title' => $role::getMsgTrans('update_heading')])

@include('partials._alerts')

{{ html()->modelForm($role, 'PUT', route('admin.roles.update', [$role]))->open() }}

<div class="panel panel-default">
    <div class="panel-body">
        @include('partials.inputs._text', ['name' => 'role_name', 'label' => $role::getAttrsTrans('name').'*', 'width' => 6])
    </div>
</div>

<div class="pull-left">
    {{ html()->submit(__('Save'))->class('btn btn-success') }}
</div>

<div class="pull-right">
    <a href="{{ route('admin.roles.index') }}" class="btn btn-primary">@lang('Back')</a>
</div>
{{ html()->form()->close() }}
@stop

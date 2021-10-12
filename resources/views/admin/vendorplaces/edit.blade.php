@extends('layouts.admin')

@section('title', $vendorplace::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $vendorplace::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($vendorplace, 'PUT', route('admin.vendorplaces.update', [$vendorplace]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'user_id', 'label' => $vendorplace::getAttrsTrans('user_id').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.vendorplaces.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


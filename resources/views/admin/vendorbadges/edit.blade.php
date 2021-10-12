@extends('layouts.admin')

@section('title', $vendorbadge::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $vendorbadge::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($vendorbadge, 'PUT', route('admin.vendorbadges.update', [$vendorbadge]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'user_id', 'label' => $vendorbadge::getAttrsTrans('user_id').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.vendorbadges.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


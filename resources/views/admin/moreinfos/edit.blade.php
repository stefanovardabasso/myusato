@extends('layouts.admin')

@section('title', $moreinfo::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $moreinfo::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($moreinfo, 'PUT', route('admin.moreinfos.update', [$moreinfo]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'user_id', 'label' => $moreinfo::getAttrsTrans('user_id').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.moreinfos.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


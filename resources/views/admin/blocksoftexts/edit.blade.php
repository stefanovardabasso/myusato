@extends('layouts.admin')

@section('title', $blocksoftext::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $blocksoftext::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($blocksoftext, 'PUT', route('admin.blocksoftexts.update', [$blocksoftext]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'alias', 'label' => $blocksoftext::getAttrsTrans('alias').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.blocksoftexts.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop

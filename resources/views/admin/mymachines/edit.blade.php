@extends('layouts.admin')

@section('title', $mymachine::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $mymachine::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($mymachine, 'PUT', route('admin.mymachines.update', [$mymachine]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'id_offert', 'label' => $mymachine::getAttrsTrans('id_offert').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.mymachines.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop

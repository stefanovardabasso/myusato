@extends('layouts.admin')

@section('title', $CRUD_lcfirst::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $CRUD_lcfirst::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($CRUD_lcfirst, 'PUT', route('admin.CRUD_route.update', [$CRUD_lcfirst]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'CRUD_column_name', 'label' => $CRUD_lcfirst::getAttrsTrans('CRUD_column_name').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.CRUD_route.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


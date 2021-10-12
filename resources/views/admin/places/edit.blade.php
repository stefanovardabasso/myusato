@extends('layouts.admin')

@section('title', $place::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $place::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($place, 'PUT', route('admin.places.update', [$place]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'name', 'label' => $place::getAttrsTrans('name').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.places.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


@extends('layouts.admin')

@section('title', $quotation::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $quotation::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($quotation, 'PUT', route('admin.quotations.update', [$quotation]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'id_user', 'label' => $quotation::getAttrsTrans('id_user').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.quotations.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


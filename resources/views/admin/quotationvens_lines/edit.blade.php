@extends('layouts.admin')

@section('title', $quotationvens_line::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $quotationvens_line::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($quotationvens_line, 'PUT', route('admin.quotationvens_lines.update', [$quotationvens_line]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'id_quotationven', 'label' => $quotationvens_line::getAttrsTrans('id_quotationven').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.quotationvens_lines.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


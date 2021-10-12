@extends('layouts.admin')

@section('title', $quotation_line::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $quotation_line::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($quotation_line, 'PUT', route('admin.quotation_lines.update', [$quotation_line]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'id_quotation', 'label' => $quotation_line::getAttrsTrans('id_quotation').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.quotation_lines.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


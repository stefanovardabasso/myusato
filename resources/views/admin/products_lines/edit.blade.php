@extends('layouts.admin')

@section('title', $products_line::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $products_line::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($products_line, 'PUT', route('admin.products_lines.update', [$products_line]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'id_product', 'label' => $products_line::getAttrsTrans('id_product').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.products_lines.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


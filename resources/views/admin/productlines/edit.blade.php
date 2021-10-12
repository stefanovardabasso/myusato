@extends('layouts.admin')

@section('title', $productline::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $productline::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($productline, 'PUT', route('admin.productlines.update', [$productline]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'id_product', 'label' => $productline::getAttrsTrans('id_product').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.productlines.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


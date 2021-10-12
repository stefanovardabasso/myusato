@extends('layouts.admin')

@section('title', $product::getMsgTrans('create_heading'))

@section('content')
    @include('partials._content-heading', ['title' => 'Crea un Prodotto'])

    @include('partials._alerts')

    {{ html()->form('POST', route('admin.products.store'))->class('')->open() }}

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                @include('partials.inputs._text', ['name' => 'family', 'label' => $product::getAttrsTrans('family').'*'])
            </div>
        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}
@stop


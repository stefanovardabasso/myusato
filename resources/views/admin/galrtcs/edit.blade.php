@extends('layouts.admin')

@section('title', $galrtc::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $galrtc::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($galrtc, 'PUT', route('admin.galrtcs.update', [$galrtc]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'product_id', 'label' => $galrtc::getAttrsTrans('product_id').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.galrtcs.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


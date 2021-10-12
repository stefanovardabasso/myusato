@extends('layouts.admin')

@section('title', $fam_select::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $fam_select::getMsgTrans('update_heading')])

    @include('partials._alerts')
    {{ html()->modelForm($fam_select, 'PUT', route('admin.fam_selects.update', [$fam_select]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                @include('partials.inputs._text', ['name' => 'id_button', 'label' => $fam_select::getAttrsTrans('id_button').'*'])
            </div>

        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.fam_selects.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}

@stop


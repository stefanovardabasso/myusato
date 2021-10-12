@extends('layouts.admin')

@section('title', $notification::getMsgTrans('create_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $notification::getMsgTrans('create_heading')])

    @include('partials._alerts')

    {{ html()->form('POST', route('admin.notifications.store'))->class('')->acceptsFiles()->open() }}

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                @include('partials.inputs._text', ['name' => 'title', 'label' => $notification::getAttrsTrans('title').'*', 'width' => 6])

                <div class="col-md-6 form-group @if($errors->has('start') || $errors->has('end')) has-error @endif">
                    {{ html()->label(__('duration-form-label').'*', 'duration')->class('control-label') }}
                    {{ html()->text('duration')->class('form-control date-time-range-picker')->id('duration') }}

                    {{ html()->hidden('start', \Carbon\Carbon::now()->startOfDay()->format('d/m/Y H:i'))->id('duration_start')->attribute('title', $notification::getAttrsTrans('start')) }}
                    {{ html()->hidden('end', \Carbon\Carbon::now()->endOfDay()->format('d/m/Y H:i'))->id('duration_end')->attribute('title', $notification::getAttrsTrans('end')) }}

                    @include('partials._field-error', ['field' => 'start'])
                    @include('partials._field-error', ['field' => 'end'])
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <legend>@lang('Visibility')</legend>
                </div>

                @include('partials.inputs._select-multi', [
                    'name' => 'roles',
                    'label' => $notification::getAttrsTrans('roles').'*',
                    'width' => 6,
                    'options' => $roles,
                    'multiple' => true
                ])

                <div class="col-xs-12 form-group">
                    <hr/>
                </div>
            </div>

            <div class="row">
                @include('partials.inputs._textarea-editor', ['name' => 'text', 'label' => $notification::getAttrsTrans('text').'*'])
            </div>
            <div class="row">
                @include('partials.inputs._file', ['name' => 'attachments', 'label' => __('Attachments'), 'previewContainer' => 'attachments-preview-container', 'multiple' => true])
            </div>
        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}
@stop


@extends('layouts.admin')

@section('title', $contactform::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => __('Messaggio ricevuto')])

    @include('partials._alerts')

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-lg-4">
                    <div class="col-md-12 form-group ">
                        <label for="from_email" class="control-label">{{__('From email').'*'}}</label>
                        <input type="text" value="{{$contactform->from_email}}" name="from_email" id="from_email" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="col-md-12 form-group ">
                        <label for="from_email" class="control-label">{{__('Nome').'*'}}</label>
                        <input type="text" value="{{$contactform->name}}" name="from_email" id="from_email" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="col-md-12 form-group ">
                        <label for="from_email" class="control-label">{{__('Cognome').'*'}}</label>
                        <input type="text" value="{{$contactform->surname}}" name="from_email" id="from_email" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="col-md-12 form-group ">
                        <label for="from_email" class="control-label">{{__('Azienda').'*'}}</label>
                        <input type="text" value="{{$contactform->company}}" name="from_email" id="from_email" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="col-md-12 form-group ">
                        <label for="from_email" class="control-label">{{__('Telefono').'*'}}</label>
                        <input type="text" value="{{$contactform->phone}}" name="from_email" id="from_email" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-lg-10">

                    <div class="col-md-12 form-group ">
                        <label for="from_email" class="control-label">{{__('Messaggio').'*'}}</label>
                        <textarea name="descripit" id="descripit" rows="3" class="form-control" readonly>{{$contactform->message}}</textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <div class="pull-right">
        <a href="{{ route('admin.contactforms.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>


@stop


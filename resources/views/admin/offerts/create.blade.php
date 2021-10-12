@extends('layouts.admin')

@section('title', $offert::getMsgTrans('create_heading'))

@section('content')
    @include('partials._content-heading', ['title' => 'Crea una offerta'])

    @include('partials._alerts')

    {{ html()->form('POST', route('admin.offerts.store'))->class('')->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-lg-4">
                    <input type="hidden" value="{{request()->get('idproduct')}}" name="id_product">
                    <input type="hidden" value="{{ Auth::user()->email }}" name="createdby">
                    @include('partials.inputs._text', ['name' => 'title', 'label' => 'Titolo'.'*'])
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    @include('partials.inputs._textarea', ['name' => 'descripit', 'label' => 'Descrizione offerta IT'.'*'])
                </div>
                <div class="col-lg-4">
                    @include('partials.inputs._textarea', ['name' => 'descripen', 'label' => 'Descrizione offerta EN'.'*'])
                </div>

            </div>


            <div class="row">
                <div class="col-lg-4">
                    <h3>OFFERTA UTENTE FINALE</h3>
                </div>
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'price_cal_uf', 'label' => 'Prezzo calcolato'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'price_min_uf', 'label' => 'Prezzo minimo vendita'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._date', ['name' => 'date_fin_of_uf', 'label' => 'Data scadenza offerta'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'gp_uf', 'label' => 'GP effettivo'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">

                            <?php $name = 'status_fin_uf'; $label = 'Stato fine offerta' ?>
                            <div class="col-md-12 form-group @if($errors->has($name)) has-error @endif">
                                {{ html()->label($label, $name)->class('control-label') }}
                                <select class="form-control" name="status_fin_uf">
                                    <option>In revisione</option>
                                    <option>Revisionato</option>
                                    <option>Venduto</option>
                                </select>
                                @include('partials._field-error', ['field' => $name])
                            </div>

                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'price_uf', 'label' => 'Prezzo vendita pubblicato'.'*'])
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-4">
                    <h3>OFFERTA COMMERCIANTE</h3>
                </div>
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'price_cal_co', 'label' => 'Prezzo calcolato'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'price_min_co', 'label' => 'Prezzo minimo vendita'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._date', ['name' => 'date_fin_of_co', 'label' => 'Data scadenza offerta'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'gp_co', 'label' => 'GP effettivo'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <?php $name = 'status_fin_co'; $label = 'Stato fine offerta' ?>
                            <div class="col-md-12 form-group @if($errors->has($name)) has-error @endif">
                                {{ html()->label($label, $name)->class('control-label') }}
                                <select class="form-control" name="status_fin_co">
                                    <option>In revisione</option>
                                    <option>Revisionato</option>
                                    <option>Venduto</option>
                                </select>
                                @include('partials._field-error', ['field' => $name])
                            </div>

                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'price_co', 'label' => 'Prezzo vendita pubblicato'.'*'])
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <h3>PUBBLICAZIONE OFFERTA SU PORTALI </h3>
                </div>
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-lg-3">
                            @include('partials.inputs._select', ['name' => 'titles', 'label' => 'MYUSATO'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._checkbox', ['name' => 'titles', 'label' => 'USA VALORE MACCHINE'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._checkbox', ['name' => 'titles', 'label' => 'IMPOSTA ALTRO PREZZO'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._text', ['name' => 'titles', 'label' => ''])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            @include('partials.inputs._select', ['name' => 'titles', 'label' => 'FORKLIFT'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._checkbox', ['name' => 'titles', 'label' => 'USA VALORE MACCHINE'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._checkbox', ['name' => 'titles', 'label' => 'IMPOSTA ALTRO PREZZO'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._text', ['name' => 'titles', 'label' => ''])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            @include('partials.inputs._select', ['name' => 'titles', 'label' => 'ALTRO'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._checkbox', ['name' => 'titles', 'label' => 'USA VALORE MACCHINE'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._checkbox', ['name' => 'titles', 'label' => 'IMPOSTA ALTRO PREZZO'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._text', ['name' => 'titles', 'label' => ''])
                        </div>
                        <input type="hidden" name="type_off" value="single">
                    </div>

                </div>
            </div>


        </div>
    </div>

    <div class="pull-left">
        {{ html()->submit(__('Save'))->class('btn btn-success') }}
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.offerts.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>
    {{ html()->form()->close() }}
@stop


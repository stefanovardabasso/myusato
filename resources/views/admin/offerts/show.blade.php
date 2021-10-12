@extends('layouts.admin')

@section('title', $offert::getMsgTrans('view_heading'))

@section('content')
    @include('partials._content-heading', ['title' => 'Vedi la offerta'])

    {{ html()->modelForm($offert, 'PUT', route('admin.offerts.update', [$offert]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-lg-4">
                    <input type="hidden" value="{{request()->get('idproduct')}}" name="id_product">
                    @include('partials.inputs._textreadonlyof', ['name' => 'title', 'label' => 'Titolo'.'*'])
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    @include('partials.inputs.textareareadonlyof', ['name' => 'descripit', 'label' => 'Descrizione offerta IT'.'*'])
                </div>
                <div class="col-lg-4">
                    @include('partials.inputs.textareareadonlyof', ['name' => 'descripen', 'label' => 'Descrizione offerta EN'.'*'])
                </div>

            </div>
            <div class="row">
                <div class="col-lg-4">
                    <h3>Gallery offerta</h3>
                </div>
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-lg-3">
                            <img style="width: 25%; border: 3px solid black;" src="https://faculty.iiit.ac.in/~indranil.chakrabarty/images/empty.png">
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <h3>OFFERTA UTENTE FINALE</h3>
                </div>
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._textreadonlyof', ['name' => 'price_cal_uf', 'label' => 'Prezzo calcolato'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._textreadonlyof', ['name' => 'price_min_uf', 'label' => 'Prezzo minimo vendita'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._textreadonlyof', ['name' => 'date_fin_of_uf', 'label' => 'Data scadenza offerta'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._textreadonlyof', ['name' => 'gp_uf', 'label' => 'GP effettivo'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._textreadonlyof', ['name' => 'status_fin_uf', 'label' => 'Stato fine offerta'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._textreadonlyof', ['name' => 'price_uf', 'label' => 'Prezzo vendita pubblicato'.'*'])
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
                            @include('partials.inputs._textreadonlyof', ['name' => 'price_cal_co', 'label' => 'Prezzo calcolato'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._textreadonlyof', ['name' => 'price_min_co', 'label' => 'Prezzo minimo vendita'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._textreadonlyof', ['name' => 'date_fin_of_co', 'label' => 'Data scadenza offerta'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._textreadonlyof', ['name' => 'gp_co', 'label' => 'GP effettivo'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._textreadonlyof', ['name' => 'status_fin_co', 'label' => 'Stato fine offerta'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._textreadonlyof', ['name' => 'price_co', 'label' => 'Prezzo vendita pubblicato'.'*'])
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
                    </div>

                </div>
            </div>


        </div>
    </div>


    {{ html()->form()->close() }}

    @can('view_all', \App\Models\Admin\Revision::class)
        @include('admin.datatables._datatable-secondary', [
            'dataTableObject' => $revisionsDataTableObject,
            'permissionClass' => \App\Models\Admin\Revision::class,
            'title' => \App\Models\Admin\Revision::getTitleTrans(),
            'disableColumnsSelect' => true
        ])
    @endcan

@stop


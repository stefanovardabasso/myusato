@extends('layouts.admin')

@section('title', $vtu::getMsgTrans('view_heading'))

@section('content')
    @include('partials._content-heading', ['title' => __('Richiesta di valutazione')])
<?php //dd($data); ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>{{ __('Email')  }}</th>
                            <td field-key='email'>{{ $vtu->email }}</td>
                            <th>{{ __('Data')  }}</th>
                            <td field-key='email'>{{ $vtu->created_at }}</td>
                        </tr>
                    </table>
                    <BR>
                        <h3>{{__('Dettagli del richiedente')}}</h3>
                    <table class="table table-bordered table-striped">
                         <tr>
                            <th>{{ __('Nome')  }}</th>
                            <td field-key='email'>{{ $vtu->name }}</td>
                            <th>{{ __('Cognome')  }}</th>
                            <td field-key='email'>{{ $vtu->surname }}</td>
                             <th>{{ __('Azienda')  }}</th>
                             <td field-key='email'>{{ $vtu->company }}</td>
                             <th>{{ __('Telefono')  }}</th>
                             <td field-key='email'>{{ $vtu->phone }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Indirizzo')  }}</th>
                            <td field-key='email'>{{ $vtu->address }}</td>
                            <th>{{ __('Comune')  }}</th>
                            <td field-key='email'>{{ $vtu->comune }}</td>
                            <th>{{ __('Provincia')  }}</th>
                            <td field-key='email'>{{ $vtu->province }}</td>
                        </tr>
                    </table>
                        <BR>
                            <h3>{{__('Dati macchina')}}</h3>
                            <table class="table table-bordered table-striped">
                        <tr>
                            <th>{{ __('Tipo')  }}</th>
                            <td field-key='email'>{{ $vtu->type }}</td>
                            <th>{{ __('Marca')  }}</th>
                            <td field-key='email'>{{ $vtu->brand }}</td>
                            <th>{{ __('Modello')  }}</th>
                            <td field-key='email'>{{ $vtu->model }}</td>
                            <th>{{ __('Anno')  }}</th>
                            <td field-key='email'>{{ $vtu->year }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Montante')  }}</th>
                            <td field-key='email'>{{ $vtu->mont }}</td>
                            <th>{{ __('Sollevamento MIN')  }}</th>
                            <td field-key='email'>{{ $vtu->smin }}</td>
                            <th>{{ __('Sollevamento MAX')  }}</th>
                            <td field-key='email'>{{ $vtu->smax }}</td>
                            <th>{{ __('Portata')  }}</th>
                            <td field-key='email'>{{ $vtu->port }}</td>
                            <th>{{ __('Prezzo indicativo')  }}</th>
                            <td field-key='email'>{{ $vtu->price }}</td>
                        </tr>
                                <tr>
                                    <th>{{ __('Fornitore')  }}</th>
                                    <td field-key='email'><?php if($vtu->fornitore == 'on'){ echo __('Si'); }else{ echo __('No'); } ?></td>
                                    <th>{{ __('Note')  }}</th>
                                    <td field-key='email'>{{ $vtu->notes }}</td>

                                </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.vtus.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>

    <div class="clearfix"></div>

    @can('view_all', \App\Models\Admin\Revision::class)
        @include('admin.datatables._datatable-secondary', [
            'dataTableObject' => $revisionsDataTableObject,
            'permissionClass' => \App\Models\Admin\Revision::class,
            'title' => \App\Models\Admin\Revision::getTitleTrans(),
            'disableColumnsSelect' => true
        ])
    @endcan

@stop


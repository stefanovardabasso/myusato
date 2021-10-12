@extends('layouts.admin')

@section('title', App\Models\Admin\Vtu::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => 'Richieste di valutazione'])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Vtu::class,
        'routeNamespace' => 'vtus'
    ])

@stop



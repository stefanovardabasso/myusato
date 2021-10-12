@extends('layouts.admin')

@section('title', App\Models\Admin\Sap::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Sap::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Sap::class,
        'routeNamespace' => 'saps'
    ])

@stop



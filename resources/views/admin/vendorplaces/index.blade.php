@extends('layouts.admin')

@section('title', App\Models\Admin\Vendorplace::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Vendorplace::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Vendorplace::class,
        'routeNamespace' => 'vendorplaces'
    ])

@stop



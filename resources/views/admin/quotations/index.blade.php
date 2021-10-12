@extends('layouts.admin')

@section('title', App\Models\Admin\Quotation::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Quotation::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Quotation::class,
        'routeNamespace' => 'quotations'
    ])

@stop



@extends('layouts.admin')

@section('title', App\Models\Admin\Products_line::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Products_line::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Products_line::class,
        'routeNamespace' => 'products_lines'
    ])

@stop



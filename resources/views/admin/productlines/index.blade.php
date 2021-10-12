@extends('layouts.admin')

@section('title', App\Models\Admin\Productline::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Productline::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Productline::class,
        'routeNamespace' => 'productlines'
    ])

@stop



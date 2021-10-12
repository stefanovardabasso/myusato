@extends('layouts.admin')

@section('title', App\Models\Admin\Option::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Option::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Option::class,
        'routeNamespace' => 'options'
    ])

@stop



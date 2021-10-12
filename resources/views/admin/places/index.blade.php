@extends('layouts.admin')

@section('title', App\Models\Admin\Place::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Place::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Place::class,
        'routeNamespace' => 'places'
    ])

@stop



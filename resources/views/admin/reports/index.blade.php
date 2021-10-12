@extends('layouts.admin')

@section('title', App\Models\Admin\Report::getTitleTrans())

@section('content')
    @include('partials._content-heading', ['title' => App\Models\Admin\Report::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Report::class,
        'routeNamespace' => 'reports'
    ])

@stop



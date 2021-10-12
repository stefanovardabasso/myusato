@extends('layouts.admin')

@section('title', App\Models\Admin\Cms::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => 'CMS'])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Cms::class,
        'routeNamespace' => 'cmss'
    ])

@stop



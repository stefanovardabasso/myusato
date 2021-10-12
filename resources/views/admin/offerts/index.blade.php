@extends('layouts.admin')

@section('title', App\Models\Admin\Offert::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Offert::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Offert::class,
        'routeNamespace' => 'offerts'
    ])

@stop



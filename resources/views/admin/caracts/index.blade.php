@extends('layouts.admin')

@section('title', App\Models\Admin\Caract::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Caract::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Caract::class,
        'routeNamespace' => 'caracts'
    ])

@stop



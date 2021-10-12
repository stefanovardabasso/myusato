@extends('layouts.admin')

@section('title', App\Models\Admin\Galrtc::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Galrtc::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Galrtc::class,
        'routeNamespace' => 'galrtcs'
    ])

@stop



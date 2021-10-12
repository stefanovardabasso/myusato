@extends('layouts.admin')

@section('title', App\Models\Admin\Component::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Component::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Component::class,
        'routeNamespace' => 'components'
    ])

@stop



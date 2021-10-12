@extends('layouts.admin')

@section('title', App\Models\Admin\Mymachine::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Mymachine::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Mymachine::class,
        'routeNamespace' => 'mymachines'
    ])

@stop



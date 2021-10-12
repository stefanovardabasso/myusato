@extends('layouts.admin')

@section('title', App\Models\Admin\Vendorbadge::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Vendorbadge::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Vendorbadge::class,
        'routeNamespace' => 'vendorbadges'
    ])

@stop



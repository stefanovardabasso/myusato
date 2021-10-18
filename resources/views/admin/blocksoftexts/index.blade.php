@extends('layouts.admin')

@section('title', App\Models\Admin\Blocksoftext::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Blocksoftext::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Blocksoftext::class,
        'routeNamespace' => 'blocksoftexts'
    ])

@stop



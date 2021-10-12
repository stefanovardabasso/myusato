@extends('layouts.admin')

@section('title', App\Models\Admin\Buttons_filter::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Buttons_filter::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Buttons_filter::class,
        'routeNamespace' => 'buttons_filters'
    ])

@stop



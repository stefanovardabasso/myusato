@extends('layouts.admin')

@section('title', 'Prodotti')

@section('content')

    @include('partials._content-heading', ['title' => 'Prodotti'])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
           'dataTableObject' => $dataTableObject,
           'permissionClass' => \App\Models\Admin\Products::class,
           'routeNamespace' => 'products'
       ])


@stop



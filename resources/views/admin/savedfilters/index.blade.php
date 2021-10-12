@extends('layouts.admin')

@section('title', __('Filtri salvati'))

@section('content')

    @include('partials._content-heading', ['title' => __('Filtri salvati')])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Savedfilter::class,
        'routeNamespace' => 'savedfilters'
    ])

@stop



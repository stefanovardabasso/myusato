@extends('layouts.admin')

@section('title', App\Models\Admin\Contactform::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => 'Messaggi'])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Contactform::class,
        'routeNamespace' => 'contactforms'
    ])

@stop



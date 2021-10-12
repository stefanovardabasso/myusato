@extends('layouts.admin')

@section('title', '')

@section('content')


    @include('partials._content-heading', ['title' => $tit])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\User::class,
        'routeNamespace' => 'users'
    ])

@stop

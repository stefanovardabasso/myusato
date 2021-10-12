@extends('layouts.admin')

@section('title', App\Models\Admin\Questions_sap::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Questions_sap::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Questions_sap::class,
        'routeNamespace' => 'questions_saps'
    ])

@stop



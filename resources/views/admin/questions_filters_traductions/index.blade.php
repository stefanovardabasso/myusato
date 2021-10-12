@extends('layouts.admin')

@section('title', App\Models\Admin\Questions_filters_traduction::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Questions_filters_traduction::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Questions_filters_traduction::class,
        'routeNamespace' => 'questions_filters_traductions'
    ])

@stop



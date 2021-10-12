@extends('layouts.admin')

@section('title', App\Models\Admin\Questions_filter::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Questions_filter::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Questions_filter::class,
        'routeNamespace' => 'questions_filters'
    ])

@stop



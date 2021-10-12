@extends('layouts.admin')

@section('title', App\Models\Admin\Fam_select::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => App\Models\Admin\Fam_select::getTitleTrans()])

    @include('partials._alerts')

    @include('admin.datatables._datatable', [
        'dataTableObject' => $dataTableObject,
        'permissionClass' => \App\Models\Admin\Fam_select::class,
        'routeNamespace' => 'fam_selects'
    ])

@stop



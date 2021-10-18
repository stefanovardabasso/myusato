@extends('layouts.admin')

@section('title', App\Models\Admin\Moreinfo::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => __('Piu Info')])

    @include('partials._alerts')


    @include('admin.datatables._datatable', [
         'dataTableObject' => $dataTableObject,
         'permissionClass' => \App\Models\Admin\Moreinfo::class,
         'routeNamespace' => 'moreinfos'
     ])



@stop



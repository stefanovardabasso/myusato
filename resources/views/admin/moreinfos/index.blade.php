@extends('layouts.admin')

@section('title', App\Models\Admin\Moreinfo::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => __('Piu Info')])

    @include('partials._alerts')


    @include('admin.datatables.partials._template', [ 'dataTableObject' => $dataTableObject ])


@stop



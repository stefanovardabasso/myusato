@extends('layouts.admin')

@section('title', __('Mascus'))

@section('content')

    @include('partials._content-heading', ['title' => __('Elenco offerte')])

    @include('partials._alerts')

    <div class="container-fluid">
        <div style="text-align: center">
            <h2>
              <span class="label label-info" style="background-color: rgb(251, 113, 33) !important;">
                <i class="glyphicon glyphicon-globe"></i>
                <span>Mascus</span>
              </span>
            </h2>
        </div>
    </div>

{{--    @include('admin.datatables._datatable', [--}}
{{--        'dataTableObject' => $dataTableObject,--}}
{{--        'permissionClass' => \App\Models\Admin\Macu::class,--}}
{{--        'routeNamespace' => 'macus'--}}
{{--    ])--}}

@stop



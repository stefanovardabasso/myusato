@extends('layouts.admin')

@section('title', $macu::getMsgTrans('view_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $macu::getMsgTrans('view_heading')])

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>{{ $macu::getAttrsTrans('offert_id') }}</th>
                            <td field-key='offert_id'>{{ $macu->offert_id }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.macus.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>

    <div class="clearfix"></div>

    @can('view_all', \App\Models\Admin\Revision::class)
        @include('admin.datatables._datatable-secondary', [
            'dataTableObject' => $revisionsDataTableObject,
            'permissionClass' => \App\Models\Admin\Revision::class,
            'title' => \App\Models\Admin\Revision::getTitleTrans(),
            'disableColumnsSelect' => true
        ])
    @endcan

@stop


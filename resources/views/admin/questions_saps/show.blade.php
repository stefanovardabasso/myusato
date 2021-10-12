@extends('layouts.admin')

@section('title', $questions_sap::getMsgTrans('view_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $questions_sap::getMsgTrans('view_heading')])

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>{{ $questions_sap::getAttrsTrans('code_q') }}</th>
                            <td field-key='code_q'>{{ $questions_sap->code_q }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.questions_saps.index') }}" class="btn btn-primary">@lang('Back')</a>
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


@extends('layouts.admin')

@section('title', $role::getMsgTrans('view_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $role::getMsgTrans('view_heading')])

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>{{ $role::getAttrsTrans('name') }}</th>
                    <td field-key='name'>{{ $role->role_name }}</td>
                </tr>
            </table>
        </div>
    </div>


    <div class="pull-left">
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.roles.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>

    <div class="clearfix"></div>

    @include('admin.datatables._datatable-secondary', [
        'dataTableObject' => $usersDataTableObject,
        'permissionClass' => \App\Models\Admin\User::class,
        'title' => \App\Models\Admin\User::getTitleTrans()
    ])

    @can('view_all', \App\Models\Admin\Revision::class)
        @include('admin.datatables._datatable-secondary', [
            'dataTableObject' => $revisionsDataTableObject,
            'permissionClass' => \App\Models\Admin\Revision::class,
            'title' => \App\Models\Admin\Revision::getTitleTrans(),
            'disableColumnsSelect' => true
        ])
    @endcan

@stop



@extends('layouts.admin')

@section('title', __('Filtri salvati'))

@section('content')
    @include('partials._content-heading', ['title' => __('Filtri salvati')])

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>{{ __('Email') }}</th>
                            <td field-key='id_user'>{{ $user->email }}</td>

                            <th>{{ __('Nome') }}</th>
                            <td field-key='id_user'>{{ $user->name }}</td>

                            <th>{{ __('Cognome') }}</th>
                            <td field-key='id_user'>{{ $user->surname }}</td>

                            <th>{{ __('Famiglia') }}</th>
                            <td field-key='id_user'><span class="label bg-green-active">{{ $savedfilter->name }}</span></td>
                        </tr>
                        <tr>
                            <th>{{ __('Filtri') }}</th>
                        @foreach($lines as $line)
                                <td><span class="label bg-yellow">{{ $line->lavel_it }}</span> : {{ $line->ans }} </td>
                        @endforeach
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.savedfilters.index') }}" class="btn btn-primary">@lang('Back')</a>
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


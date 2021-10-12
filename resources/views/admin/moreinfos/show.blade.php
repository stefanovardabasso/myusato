@extends('layouts.admin')

@section('title', $moreinfo::getMsgTrans('view_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $moreinfo::getMsgTrans('view_heading')])

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>{{ __('Email') }}</th>
                            <td field-key='user_id'>{{ $moreinfo->email }}</td>
                            <th>{{ __('Titolo') }}</th>
                            <td field-key='user_id'>{{ $moreinfo->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Message') }}</th>
                            <td field-key='user_id'>{{ $moreinfo->message }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Offerta') }}</th>
                            @if($check_off->status == 1)
                                @if($check_off->type_off == 'single')
                                    <td field-key='user_id'>  <a target="_blank" href="{{ route('product-detail', ['id_offert' => $moreinfo->offert_id ]) }}" class="button">Vedi</a> </td>
                                @else
                                    <td field-key='user_id'>  <a target="_blank" href="{{ route('product-bun-detail', ['id_offert' => $moreinfo->offert_id ]) }}" class="button">Vedi</a></td>
                                @endif


                            @else
                                <td field-key='user_id'>{{__('Questa offerta e scaduta')}}</td>
                            @endif
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.moreinfos.index') }}" class="btn btn-primary">@lang('Back')</a>
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


@extends('layouts.admin')

@section('title', $quotation::getMsgTrans('view_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $quotation::getMsgTrans('view_heading')])

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>{{ __('Utente email') }}</th>
                            <td field-key='id_user'>{{ $user->email }}</td>
                            <th>{{ __('Utente nome') }}</th>
                            <td field-key='id_user'>{{ $user->name }}</td>
                            <th>{{ __('Utente cognome') }}</th>
                            <td field-key='id_user'>{{ $user->surname }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Titolo') }}</th>
                            <td field-key='id_user'>{{ $user->title }}</td>

                            <th>{{ __('Messaggio') }}</th>
                            <td field-key='id_user'>{{ $user->text }}</td>
                        </tr>
                    </table>

                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>{{ __('Id') }}</th>
                            <th>{{ __('Tipo OF') }}</th>
                            <th>{{ __('Data fine OF') }}</th>
                            <th>{{ __('Prezzo finale') }}</th>
                            <th>{{ __('Link OF') }}</th>
                        </tr>
                        @foreach($lines as $line)
                            <tr>
                            <td>#{{ $line->id }}</td>
                            <td>{{$offerts[$line->id]->type_off}}</td>
                            <td>{{$offerts[$line->id]->date_finish_off}}</td>
                            <td>@if($offerts[$line->id]->target_user == 1) {{$offerts[$line->id]->list_price_uf}} @else {{$offerts[$line->id]->list_price_co}} @endif</td>
                            <td>
                                @if($offerts[$line->id]->type_off == 'single')
                                    <a target="_blank" href="{{ route('product-detail', ['id_offert' => $offerts[$line->id]->id ]) }}" class="button">Vedi</a>
                                @else
                                    <a target="_blank" href="{{ route('product-bun-detail', ['id_offert' => $offerts[$line->id]->id ]) }}" class="button">Vedi</a>

                                @endif
                            </td>
                            </tr>
                        @endforeach
                    </table>


                </div>
            </div>
        </div>
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.quotations.index') }}" class="btn btn-primary">@lang('Back')</a>
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


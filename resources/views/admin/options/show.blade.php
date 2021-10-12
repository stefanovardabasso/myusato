@extends('layouts.admin')

@section('title', $option::getMsgTrans('view_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $option::getMsgTrans('view_heading')])

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>{{ __('Utente') }}</th>
                            <td field-key='user_id'>{{ $user->name }} {{ $user->surname }}</td>
                            <th>{{ __('Email') }}</th>
                            <td field-key='user_id'>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Tipo Of') }}</th>
                            <td field-key='user_id'>{{ $offert->type_off }} </td>
                            <th>{{ __('Target Of') }}</th>
                            <td field-key='user_id'>@if($offert->target_off ==1) Utente finale @else Commerciante @endif</td>
                            <th>{{ __('Prezzo') }}</th>
                            <td field-key='user_id'>@if($offert->target_off ==1) {{$offert->list_price_uf}} @else {{$offert->list_price_co}} @endif</td>
                        </tr>
                            <tr>
                                <th>{{ __('Status') }}</th>
                                <td field-key='user_id'>
                                    @if($option->status == 0)
                                        Attiva
                                    @elseif($option->status == 1)
                                        Scaduta
                                    @elseif($option->status == 3)
                                        Assegnata
                                    @endif </td>
                                @if($option->status == 3)
                                <th>{{ __('Documento') }}</th>
                                <td field-key='user_id'>
                                        @if(file_exists('upload/options/'.$option->id.'.pdf'))
                                        <a href="{{url('upload/options/'.$option->id.'.pdf')}}" download> Download</a>

                                        @elseif(file_exists('upload/options/'.$option->id.'.png'))
                                        <a href="{{url('upload/options/'.$option->id.'.png')}}" download> Download</a>
                                        @elseif(file_exists('upload/options/'.$option->id.'.jpg'))
                                        <a href="{{url('upload/options/'.$option->id.'.jpg')}}" download> Download</a>
                                        @elseif(file_exists('upload/options/'.$option->id.'.jpeg'))
                                        <a href="{{url('upload/options/'.$option->id.'.jpeg')}}" download> Download</a>
                                        @endif
                                   </td>
                                    @endif
                            </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.options.index') }}" class="btn btn-primary">@lang('Back')</a>
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


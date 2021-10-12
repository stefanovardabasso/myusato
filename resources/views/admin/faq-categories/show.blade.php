@extends('layouts.admin')

@section('title', $faqCategory::getMsgTrans('view_heading'))

@section('content')
    @include('partials._content-heading', ['title' => $faqCategory::getMsgTrans('view_heading')])

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>{{ $faqCategory::getAttrsTrans('title') }}</th>
                            <td field-key='title'>{{ $faqCategory->title }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-default">@lang('Back')</a>
        </div>
    </div>

    @include('admin.datatables._datatable-secondary', [
        'dataTableObject' => $faqQuestionsDataTableObject,
        'permissionClass' => \App\Models\Admin\FaqQuestion::class,
        'title' => \App\Models\Admin\FaqQuestion::getTitleTrans()
    ])

    <div class="pull-left">
    </div>

    <div class="pull-right">
        <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-primary">@lang('Back')</a>
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


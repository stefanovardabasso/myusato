
<div class="datatable__view">
    <div class="col-sm-4 col-xs-12">
        <select name="view"
                class="select2-create_tag form-control"
                data-placeholder="@lang('Select...')"
                data-target-table="{{ $targetTable }}"
                id="{{ $selectId }}"
        >
            @if(!empty($defaultViews))
                @foreach($defaultViews as $viewName => $params)
                    <option value="{{ $viewName }}" data-view-params="{{ json_encode($params) }}" data-default="1">{{ $viewName }}</option>
                @endforeach
            @else
                <option value="default" selected="selected" data-default="1">@lang('Default')</option>
            @endif
            @if(isset(Auth::user()->settings['data_tables'][$targetTable])
                && !empty(Auth::user()->settings['data_tables'][$targetTable])
                && is_array(Auth::user()->settings['data_tables'][$targetTable]))
                @foreach(Auth::user()->settings['data_tables'][$targetTable] as $viewName => $params)
                    <option value="{{ $viewName }}" data-view-params="{{ json_encode($params) }}">{{ $viewName }}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="col-sm-1 col-xs-6">
        <button type="button" class="btn btn-success btn-block dt_save-view_btn" title="@lang('Save')"
                data-target-select="{{ $selectId }}"
                data-target-table="{{ $targetTable }}"
                data-save-route="{{ route('admin.datatables.save-user-view') }}">
            <i class="fa fa-check"></i>
        </button>
    </div>
    <div class="col-sm-1 col-xs-6">
        <button type="button" class="btn btn-danger btn-block dt_delete-view_btn" title="@lang('Delete')"
                data-target-select="{{ $selectId }}"
                data-target-table="{{ $targetTable }}"
                data-delete-route="{{ route('admin.datatables.delete-user-view') }}">
            <i class="fa fa-close"></i>
        </button>
    </div>

    <div class="col-sm-6 col-xs-6 datatable__view-info-message" data-target-table="{{ $targetTable }}" style="display: none;">
        @lang('Save to apply changes...')
    </div>
</div>

@section('javascript')
    @parent

@stop

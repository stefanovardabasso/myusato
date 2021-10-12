<div class="modal fade" id="{{ $modalId }}">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('Columns visibility')</h4>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled">
                    @foreach($dataTableColumns as $column)
                        <li>
                            <input
                                    type="checkbox"
                                    name="dt_users_cols_visibility"
                                    value="{{ $column['data'] }}"
                                    class="icheckbox_square dt_col_visibility_filter"
                                    data-table_target="{{ $targetTable }}"
                                    data-column_target=".{{ $column['className'] }}"
                                    checked="checked"
                                    id="{{ $column['className'] }}"
                            >
                            <label for="{{ $column['className'] }}">
                                <strong>{{ $column['label'] }}</strong>
                            </label>
                        </li>

                    @endforeach
                </ul>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

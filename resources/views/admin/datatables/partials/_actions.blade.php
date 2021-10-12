{{--{{Route::current()->getName()}}--}}
@if(Route::current()->getName() != 'admin.datatables.contactforms' && Route::current()->getName() != 'admin.datatables.products' && Route::current()->getName() != 'admin.datatables.offerts')
@can('dt_view', [$row, $viewAllPermission, $viewOwnPermission])
<a href="{{ route($routeKey . '.show', [$row]) }}" class="btn btn-xs btn-info" title="@lang('View')">
    <i class="fa fa-eye"></i>
</a>
@endcan
@endif
@if(Route::current()->getName() != 'admin.datatables.vtus' & Route::current()->getName() != 'admin.datatables.moreinfos')
@can('dt_update', [$row, $updateAllPermission, $updateOwnPermission])
<a href="{{ route($routeKey . '.edit', [$row]) }}" class="btn btn-xs btn-success" title="@lang('Update')">
    <i class="fa fa-pencil"></i>
</a>
@endcan
@endif
@if(isset($createPermission) && $createPermission == true)
    {{ html()->form('POST', route($routeKey . '.duplicate', [$row]))->class('')->attributes(['style' => 'display: inline-block;'])->open() }}
    <button class="btn btn-primary btn-xs data-table-duplicate-single" type="submit"
        data-duplicate_message="@lang('Are you sure you want to duplicate the selected item?')" title="@lang('Duplicate')">
        <i class="fa fa-copy"></i>
    </button>
    {{ html()->form()->close() }}
@endif
@if(Route::current()->getName() != 'admin.datatables.vtus' && Route::current()->getName() != 'admin.datatables.offerts')
@can('dt_delete', [$row, $deleteAllPermission, $deleteOwnPermission])
    {{ html()->form('DELETE', route($routeKey . '.destroy', [$row]))->class('')->attributes(['style' => 'display: inline-block;'])->open() }}
        <button class="btn btn-xs btn-danger data-table-delete-single" type="submit"
            data-delete_message="@lang('Are you sure you want to delete the selected item?')" title="@lang('Delete')">
            <i class="fa fa-remove"></i>
        </button>
    {{ html()->form()->close() }}
@endcan
@endif

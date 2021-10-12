<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\RoleTranslation;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role as BaseRole;
use App\Traits\Revisionable\Admin\RoleRevisionable;
use App\Traits\DataTables\Admin\RoleDataTable;

class Role extends BaseRole
{
    use RoleRevisionable;
    use RoleDataTable;
    use RoleTranslation;

    protected $guard_name = 'web';

    /**
     * @return mixed
     */
    public static function getSelectOptions()
    {
        return self::get()->pluck('role_name', 'id');
    }

    /**
     * @return mixed
     */
    public static function getSelectFilter()
    {
        return self::select(['id', 'role_name'])->get();
    }

    /**
     * @param Collection $roles
     * @return Collection
     */
    public static function transformForSelectsFilters(Collection $roles): Collection
    {
        foreach ($roles as $role) {
            $role->label = $role->role_name;
            $role->value = $role->id;
        }

        return $roles->sortBy("label");
    }
}

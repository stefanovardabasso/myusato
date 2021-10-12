<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\PlaceTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\PlaceRevisionable;
use App\Traits\DataTables\Admin\PlaceDataTable;

class Place extends Model
{
    use PlaceDataTable;
    use PlaceRevisionable;
    use PlaceTranslation;

    protected $guarded = [];

        /**
     * @return mixed
     */
    public static function getSelectOptions()
    {
        return self::get()->pluck('name', 'id');
    }

    // many to many relation with users table via pivot table place_user
    public function users()
    {
        return $this->belongsToMany('App\Models\Admin\User');
    }

}

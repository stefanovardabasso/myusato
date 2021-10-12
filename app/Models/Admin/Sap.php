<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\SapTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\SapRevisionable;
use App\Traits\DataTables\Admin\SapDataTable;

class Sap extends Model
{
    use SapDataTable;
    use SapRevisionable;
    use SapTranslation;

    protected $guarded = [];
}

<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\ComponentTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\ComponentRevisionable;
use App\Traits\DataTables\Admin\ComponentDataTable;

class Component extends Model
{
    use ComponentDataTable;
    use ComponentRevisionable;
    use ComponentTranslation;

    protected $guarded = [];
}

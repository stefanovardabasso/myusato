<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\MacuTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\MacuRevisionable;
use App\Traits\DataTables\Admin\MacuDataTable;

class Macu extends Model
{
    use MacuDataTable;
    use MacuRevisionable;
    use MacuTranslation;

    protected $guarded = [];
}

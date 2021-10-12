<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\Questions_sapTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\Questions_sapRevisionable;
use App\Traits\DataTables\Admin\Questions_sapDataTable;

class Questions_sap extends Model
{
    use Questions_sapDataTable;
    use Questions_sapRevisionable;
    use Questions_sapTranslation;

    protected $guarded = [];
}

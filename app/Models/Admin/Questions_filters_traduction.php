<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\Questions_filters_traductionTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\Questions_filters_traductionRevisionable;
use App\Traits\DataTables\Admin\Questions_filters_traductionDataTable;

class Questions_filters_traduction extends Model
{
    use Questions_filters_traductionDataTable;
    use Questions_filters_traductionRevisionable;
    use Questions_filters_traductionTranslation;

    protected $guarded = [];
}

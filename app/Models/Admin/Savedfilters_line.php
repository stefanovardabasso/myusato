<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\Savedfilters_lineTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\Savedfilters_lineRevisionable;
use App\Traits\DataTables\Admin\Savedfilters_lineDataTable;

class Savedfilters_line extends Model
{
    use Savedfilters_lineDataTable;
    use Savedfilters_lineRevisionable;
    use Savedfilters_lineTranslation;

    protected $guarded = [];
}

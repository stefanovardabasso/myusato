<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\CmsTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\CmsRevisionable;
use App\Traits\DataTables\Admin\CmsDataTable;

class Cms extends Model
{
    use CmsDataTable;
    use CmsRevisionable;
    use CmsTranslation;

    protected $guarded = [];
}

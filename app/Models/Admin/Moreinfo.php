<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\MoreinfoTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\MoreinfoRevisionable;
use App\Traits\DataTables\Admin\MoreinfoDataTable;

class Moreinfo extends Model
{
    use MoreinfoDataTable;
    use MoreinfoRevisionable;
    use MoreinfoTranslation;

    protected $guarded = [];
}

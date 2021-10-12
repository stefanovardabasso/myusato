<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\VtuTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\VtuRevisionable;
use App\Traits\DataTables\Admin\VtuDataTable;

class Vtu extends Model
{
    use VtuDataTable;
    use VtuRevisionable;
    use VtuTranslation;

    protected $guarded = [];
}

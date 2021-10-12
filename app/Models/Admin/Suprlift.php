<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\SuprliftTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\SuprliftRevisionable;
use App\Traits\DataTables\Admin\SuprliftDataTable;

class Suprlift extends Model
{
    use SuprliftDataTable;
    use SuprliftRevisionable;
    use SuprliftTranslation;

    protected $guarded = [];
}

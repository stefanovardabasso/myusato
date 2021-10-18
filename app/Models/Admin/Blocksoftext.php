<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\BlocksoftextTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\BlocksoftextRevisionable;
use App\Traits\DataTables\Admin\BlocksoftextDataTable;

class Blocksoftext extends Model
{
    use BlocksoftextDataTable;
    use BlocksoftextRevisionable;
    use BlocksoftextTranslation;

    protected $guarded = [];
}

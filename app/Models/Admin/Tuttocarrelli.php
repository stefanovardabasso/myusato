<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\TuttocarrelliTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\TuttocarrelliRevisionable;
use App\Traits\DataTables\Admin\TuttocarrelliDataTable;

class Tuttocarrelli extends Model
{
    use TuttocarrelliDataTable;
    use TuttocarrelliRevisionable;
    use TuttocarrelliTranslation;

    protected $guarded = [];
}

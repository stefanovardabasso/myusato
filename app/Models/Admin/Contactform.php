<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\ContactformTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\ContactformRevisionable;
use App\Traits\DataTables\Admin\ContactformDataTable;

class Contactform extends Model
{
    use ContactformDataTable;
    use ContactformRevisionable;
    use ContactformTranslation;

    protected $guarded = [];
}

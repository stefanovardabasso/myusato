<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\ProductlineTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\ProductlineRevisionable;
use App\Traits\DataTables\Admin\ProductlineDataTable;

class Productline extends Model
{
    use ProductlineDataTable;
    use ProductlineRevisionable;
    use ProductlineTranslation;

    protected $guarded = [];
}

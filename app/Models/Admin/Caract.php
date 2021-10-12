<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\CaractTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\CaractRevisionable;
use App\Traits\DataTables\Admin\CaractDataTable;

class Caract extends Model
{
    use CaractDataTable;
    use CaractRevisionable;
    use CaractTranslation;

    protected $guarded = [];

    public function productLines() {
        return $this->hasMany(Products_line::class, 'cc_sap', 'cc');
    }
}

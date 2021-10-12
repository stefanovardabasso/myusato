<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\Quotation_lineTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\Quotation_lineRevisionable;
use App\Traits\DataTables\Admin\Quotation_lineDataTable;

class Quotation_line extends Model
{
    use Quotation_lineDataTable;
    use Quotation_lineRevisionable;
    use Quotation_lineTranslation;

    protected $guarded = [];
}

<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\Quotationvens_lineTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\Quotationvens_lineRevisionable;
use App\Traits\DataTables\Admin\Quotationvens_lineDataTable;

class Quotationvens_line extends Model
{
    use Quotationvens_lineDataTable;
    use Quotationvens_lineRevisionable;
    use Quotationvens_lineTranslation;

    protected $guarded = [];
}

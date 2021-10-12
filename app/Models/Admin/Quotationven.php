<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\QuotationvenTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\QuotationvenRevisionable;
use App\Traits\DataTables\Admin\QuotationvenDataTable;

class Quotationven extends Model
{
    use QuotationvenDataTable;
    use QuotationvenRevisionable;
    use QuotationvenTranslation;

    protected $guarded = [];
}

<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\QuotationTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\QuotationRevisionable;
use App\Traits\DataTables\Admin\QuotationDataTable;

class Quotation extends Model
{
    use QuotationDataTable;
    use QuotationRevisionable;
    use QuotationTranslation;

    protected $guarded = [];
}

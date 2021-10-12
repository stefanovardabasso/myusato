<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\FaqCategoryTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\FaqCategoryRevisionable;
use App\Traits\DataTables\Admin\FaqCategoryDataTable;

class FaqCategory extends Model
{
    use FaqCategoryDataTable;
    use FaqCategoryRevisionable;
    use FaqCategoryTranslation;

    protected $guarded = [];
}

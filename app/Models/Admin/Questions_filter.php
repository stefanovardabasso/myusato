<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\Questions_filterTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\Questions_filterRevisionable;
use App\Traits\DataTables\Admin\Questions_filterDataTable;

class Questions_filter extends Model
{
    use Questions_filterDataTable;
    use Questions_filterRevisionable;
    use Questions_filterTranslation;

    protected $guarded = [];

    public function questionsFiltersTraduction() {
        return $this->hasMany(Questions_filters_traduction::class, 'cod_question', 'cod_question');
    }

    public function caracts() {
        return $this->hasOne(Caract::class, 'cod_question', 'cod_question');
    }
}

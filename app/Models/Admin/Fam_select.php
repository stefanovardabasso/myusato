<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\Fam_selectTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\Fam_selectRevisionable;
use App\Traits\DataTables\Admin\Fam_selectDataTable;

class Fam_select extends Model
{
    use Fam_selectDataTable;
    use Fam_selectRevisionable;
    use Fam_selectTranslation;

    protected $guarded = [];

    public function questionsFilters() {
        return $this->hasMany(Questions_filter::class, 'cod_fam', 'cod_fam');
    }

    public function getFamilyName($familyCode) {
        $select = [
            'fam_selects.option_'.app()->getLocale().' as label',
        ];
        return Fam_select::where('cod_fam', $familyCode)->select($select)->firstOrFail();
    }
}

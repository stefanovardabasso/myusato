<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\Buttons_filterTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\Buttons_filterRevisionable;
use App\Traits\DataTables\Admin\Buttons_filterDataTable;

class Buttons_filter extends Model
{
    use Buttons_filterDataTable;
    use Buttons_filterRevisionable;
    use Buttons_filterTranslation;

    protected $guarded = [];

    public function famSelects() {
        return $this->hasMany(Fam_select::class, 'button_id', 'id');
    }



    public function getButtonFilters() {
        $select = [
            'buttons_filters.id as id',
            'buttons_filters.button_'.app()->getLocale().' as label',
            'fam_selects.cod_fam as fam_code'

        ];

        $buttonFilters = Buttons_filter::select($select)
            ->join('fam_selects', 'buttons_filters.id', '=', 'fam_selects.button_id')->groupby('id')->get();
//             ->leftjoin('items','families.id','=','items.family_id');

        return $buttonFilters;
    }

    public function getFilterInfo($filterId) {
        $filterInfo = Buttons_filter::with('famSelects.questionsFilters.questionsFiltersTraduction')
            ->findOrFail($filterId);

        return $filterInfo;
    }

    public function getFilterLabel($filterId) {
        $select = [
          'button_'.app()->getLocale(). ' as label'
        ];

        return Buttons_filter::select($select)->where('id', $filterId)->firstOrFail();
    }
}

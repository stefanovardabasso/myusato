<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\SavedfilterTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\SavedfilterRevisionable;
use App\Traits\DataTables\Admin\SavedfilterDataTable;

class Savedfilter extends Model
{
    use SavedfilterDataTable;
    use SavedfilterRevisionable;
    use SavedfilterTranslation;

    protected $guarded = [];

    public function lines()
    {
        return $this->hasMany(Savedfilters_line::class, 'saved_id', 'id');
    }

    public function saveFilter($userId, $savedFilterInfo)
    {
        $questionFilters = Questions_filter::query()->with('questionsFiltersTraduction', 'caracts')->get();

        $savedRangeFilterInfo = [];

        foreach ($savedFilterInfo as $index => $filter) {
            if (str_ends_with($index, '_start')) {
                $newIndex = str_replace(['_start', '_end'], '', $index);
                if (!isset($savedRangeFilterInfo[$newIndex])) {
                    $savedRangeFilterInfo[$newIndex] = ['start' => $filter];
                } else {
                    $savedRangeFilterInfo[$newIndex]['start'] = $filter;
                }
            }
            if (str_ends_with($index, '_end')) {
                $newIndex = str_replace(['_start', '_end'], '', $index);
                if (!isset($savedRangeFilterInfo[$newIndex])) {
                    $savedRangeFilterInfo[$newIndex] = ['end' => $filter];
                } else {
                    $savedRangeFilterInfo[$newIndex]['end'] = $filter;
                }
            }
        };
        $forbiddenFilters = [
            'sort',
            'order'
        ];
        $savedFilterInfo = collect($savedFilterInfo)
            ->filter(function ($savedFilter, $cod_question) {
                return !(str_ends_with($cod_question, '_start') || str_ends_with($cod_question, '_end'));
            })
            ->filter(function ($savedFilter, $cod_question) use ($forbiddenFilters) {
                return !in_array($cod_question, $forbiddenFilters);
            })
            ->toArray();

        $famSelects = Fam_select::query()->get();
        $codFam = null;

        // picklist logic
        foreach ($savedFilterInfo as $code => $values) {
            if ($code === 'cod_fam') {
                $saveFilter = new Savedfilter();
                $saveFilter->id_user = $userId;
                $codFam = $values;
                $chosenFamSelect = $famSelects->first(function ($famSelect) use ($values) {
                    return $famSelect->cod_fam === $values;
                });

                if ($chosenFamSelect) {
                    $saveFilter->name = $chosenFamSelect->option_it;
                }

                $saveFilter->save();
            } else if ($code === 'model') {
                $saveFilterLine = new Savedfilters_line();

                $saveFilterLine->saved_id = $saveFilter->id;
                $saveFilterLine->cc = 'MODEL';
                $saveFilterLine->cod_question = 'model';
                $saveFilterLine->lavel_it = 'Model';
                $saveFilterLine->label_en = 'Model';
                $saveFilterLine->ans = $values;
                $saveFilterLine->save();
            } else {
                $questionFilter = $questionFilters->first(function ($questionFilter) use ($code, $values, $codFam) {
                    return $questionFilter->cod_question === $code && $questionFilter->cod_fam === $codFam;
                });

                // Return only italian language?
                $qftItalian = $questionFilter
                    ->questionsFiltersTraduction
                    ->first(function ($qft) {
                        return $qft->lang === 'I';
                    });
                $qftEnglish = $questionFilter
                    ->questionsFiltersTraduction
                    ->first(function ($qft) {
                        return $qft->lang === 'E';
                    });

                // Create the saved filter line
                foreach ($values as $value) {
                    $saveFilterLine = new Savedfilters_line();

                    $saveFilterLine->saved_id = $saveFilter->id;
                    $saveFilterLine->cc = $questionFilter->caracts->cc;
                    $saveFilterLine->cod_question = $code;
                    $saveFilterLine->lavel_it = $qftItalian->label;
                    $saveFilterLine->label_en = $qftEnglish->label;
                    $saveFilterLine->ans = $value;

                    $saveFilterLine->save();
                }
            }
        }

        // range logic
        foreach ($savedRangeFilterInfo as $code => $values) {
            if ($code == 'price') {
                $saveFilterLine = new Savedfilters_line();

                $saveFilterLine->saved_id = $saveFilter->id;
                $saveFilterLine->cc = 'PREZZO';
                $saveFilterLine->cod_question = 'price';
                $saveFilterLine->lavel_it = 'Prezzo';
                $saveFilterLine->label_en = 'Price';
                $saveFilterLine->ans = $values['start'] . ';' . $values['end'];
                $saveFilterLine->save();
            } else {
                $questionFilter = $questionFilters->first(function ($questionFilter) use ($code, $values, $codFam) {
                    $code = str_replace(["_start", "_end"], "", $code);
                    return ($questionFilter->cod_question === $code && $questionFilter->cod_fam === $codFam) && $code !== 'price';
                });

                // Return only italian language?
                $qftItalian = $questionFilter
                    ->questionsFiltersTraduction
                    ->first(function ($qft) {
                        return $qft->lang === 'I';
                    });

                $qftEnglish = $questionFilter
                    ->questionsFiltersTraduction
                    ->first(function ($qft) {
                        return $qft->lang === 'E';
                    });
                // if price

                $saveFilterLine = new Savedfilters_line();

                $saveFilterLine->saved_id = $saveFilter->id;
                $saveFilterLine->cc = $questionFilter->caracts->cc;
                $saveFilterLine->cod_question = $code;
                $saveFilterLine->lavel_it = $qftItalian->label;
                $saveFilterLine->label_en = $qftEnglish->label;
                $saveFilterLine->ans = $values['start'] . ';' . $values['end'];
                $saveFilterLine->save();
            }
        }

        return true;
    }
}

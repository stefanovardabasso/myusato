<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait Questions_filters_traductionTranslation
{
    use AttributeTranslation;

    /**
     * @var array
     */
    protected $translationAttributes = ['name'];

    /**
     * @return array
     */
    private static function getTranslationsConfig()
    {
        return [
            'titles' => [
                'singular'  => __('Questions_filters_traduction'),
                'plural'    => __('Questions_filters_traductions'),
            ],
            'attributes' => [
                'cod_fam' => [
                    'translation'   => __('cod_fam-form-label')
                ],
            ]
        ];
    }
}

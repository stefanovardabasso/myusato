<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait Questions_filterTranslation
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
                'singular'  => __('Questions_filter'),
                'plural'    => __('Questions_filters'),
            ],
            'attributes' => [
                'cod_fam' => [
                    'translation'   => __('cod_fam-form-label')
                ],
            ]
        ];
    }
}

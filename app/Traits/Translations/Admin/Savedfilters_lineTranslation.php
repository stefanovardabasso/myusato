<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait Savedfilters_lineTranslation
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
                'singular'  => __('Savedfilters_line'),
                'plural'    => __('Savedfilters_lines'),
            ],
            'attributes' => [
                'saved_id' => [
                    'translation'   => __('saved_id-form-label')
                ],
            ]
        ];
    }
}

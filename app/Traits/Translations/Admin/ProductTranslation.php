<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait ProductTranslation
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
                'singular'  => __('Product'),
                'plural'    => __('Products'),
            ],
            'attributes' => [
                'family' => [
                    'translation'   => __('family-form-label')
                ],
            ]
        ];
    }
}

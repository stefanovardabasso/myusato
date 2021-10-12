<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait Buttons_filterTranslation
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
                'singular'  => __('Buttons_filter'),
                'plural'    => __('Buttons_filters'),
            ],
            'attributes' => [
                'button_it' => [
                    'translation'   => __('button_it-form-label')
                ],
            ]
        ];
    }
}

<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait OffertTranslation
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
                'singular'  => __('Offert'),
                'plural'    => __('Offerts'),
            ],
            'attributes' => [
                'title' => [
                    'translation'   => __('title-form-label')
                ],
            ]
        ];
    }
}

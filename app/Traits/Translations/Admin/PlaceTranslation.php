<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait PlaceTranslation
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
                'singular'  => __('Place'),
                'plural'    => __('Places'),
            ],
            'attributes' => [
                'name' => [
                    'translation'   => __('name-form-label')
                ],
            ]
        ];
    }
}

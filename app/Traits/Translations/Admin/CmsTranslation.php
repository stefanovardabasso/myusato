<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait CmsTranslation
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
                'singular'  => __('Cms'),
                'plural'    => __('Cmss'),
            ],
            'attributes' => [
                'name' => [
                    'translation'   => __('name-form-label')
                ],
            ]
        ];
    }
}

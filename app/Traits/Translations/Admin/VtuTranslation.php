<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait VtuTranslation
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
                'singular'  => __('Vtu'),
                'plural'    => __('Vtus'),
            ],
            'attributes' => [
                'email' => [
                    'translation'   => __('email-form-label')
                ],
            ]
        ];
    }
}

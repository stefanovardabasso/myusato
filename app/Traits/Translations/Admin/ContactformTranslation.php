<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait ContactformTranslation
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
                'singular'  => __('Contactform'),
                'plural'    => __('Contactforms'),
            ],
            'attributes' => [
                'from_email' => [
                    'translation'   => __('from_email-form-label')
                ],
            ]
        ];
    }
}

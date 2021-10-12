<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait CaractTranslation
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
                'singular'  => __('Caract'),
                'plural'    => __('Caracts'),
            ],
            'attributes' => [
                'cc' => [
                    'translation'   => __('cc-form-label')
                ],
            ]
        ];
    }
}

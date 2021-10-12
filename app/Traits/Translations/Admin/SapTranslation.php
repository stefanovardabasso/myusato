<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait SapTranslation
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
                'singular'  => __('Sap'),
                'plural'    => __('Saps'),
            ],
            'attributes' => [
                'date' => [
                    'translation'   => __('date-form-label')
                ],
            ]
        ];
    }
}

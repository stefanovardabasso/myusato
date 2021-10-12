<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait Questions_sapTranslation
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
                'singular'  => __('Questions_sap'),
                'plural'    => __('Questions_saps'),
            ],
            'attributes' => [
                'code_q' => [
                    'translation'   => __('code_q-form-label')
                ],
            ]
        ];
    }
}

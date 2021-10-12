<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait SuprliftTranslation
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
                'singular'  => __('Suprlift'),
                'plural'    => __('Suprlifts'),
            ],
            'attributes' => [
                'offert_id' => [
                    'translation'   => __('offert_id-form-label')
                ],
            ]
        ];
    }
}

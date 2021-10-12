<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait Products_lineTranslation
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
                'singular'  => __('Products_line'),
                'plural'    => __('Products_lines'),
            ],
            'attributes' => [
                'id_product' => [
                    'translation'   => __('id_product-form-label')
                ],
            ]
        ];
    }
}

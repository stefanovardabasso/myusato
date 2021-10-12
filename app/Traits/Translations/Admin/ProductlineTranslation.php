<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait ProductlineTranslation
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
                'singular'  => __('Productline'),
                'plural'    => __('Productlines'),
            ],
            'attributes' => [
                'id_product' => [
                    'translation'   => __('id_product-form-label')
                ],
            ]
        ];
    }
}

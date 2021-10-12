<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait GalrtcTranslation
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
                'singular'  => __('Galrtc'),
                'plural'    => __('Galrtcs'),
            ],
            'attributes' => [
                'product_id' => [
                    'translation'   => __('product_id-form-label')
                ],
            ]
        ];
    }
}

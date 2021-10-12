<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait GalleryTranslation
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
                'singular'  => __('Gallery'),
                'plural'    => __('Gallerys'),
            ],
            'attributes' => [
                'offert_id' => [
                    'translation'   => __('offert_id-form-label')
                ],
            ]
        ];
    }
}

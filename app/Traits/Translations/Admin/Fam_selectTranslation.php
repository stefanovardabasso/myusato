<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait Fam_selectTranslation
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
                'singular'  => __('Fam_select'),
                'plural'    => __('Fam_selects'),
            ],
            'attributes' => [
                'id_button' => [
                    'translation'   => __('id_button-form-label')
                ],
            ]
        ];
    }
}

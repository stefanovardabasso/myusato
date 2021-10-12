<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait MymachineTranslation
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
                'singular'  => __('Mymachine'),
                'plural'    => __('Mymachines'),
            ],
            'attributes' => [
                'id_offert' => [
                    'translation'   => __('id_offert-form-label')
                ],
            ]
        ];
    }
}

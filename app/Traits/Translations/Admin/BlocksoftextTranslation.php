<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait BlocksoftextTranslation
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
                'singular'  => __('Blocksoftext'),
                'plural'    => __('Blocksoftexts'),
            ],
            'attributes' => [
                'alias' => [
                    'translation'   => __('alias-form-label')
                ],
            ]
        ];
    }
}

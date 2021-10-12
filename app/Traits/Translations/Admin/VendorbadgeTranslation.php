<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait VendorbadgeTranslation
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
                'singular'  => __('Vendorbadge'),
                'plural'    => __('Vendorbadges'),
            ],
            'attributes' => [
                'user_id' => [
                    'translation'   => __('user_id-form-label')
                ],
            ]
        ];
    }
}

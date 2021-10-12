<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait UserTranslation
{
    use AttributeTranslation;

    /**
     * @return array
     */
    private static function getTranslationsConfig()
    {
        return [
            'titles' => [
                'singular'  => __('User'),
                'plural'    => __('Users'),
            ],
            'attributes' => [
                'name' => [
                    'translation'   => __('name-form-label')
                ],
                'surname' => [
                    'translation'   => __('surname-form-label'),
                ],
                'email' => [
                    'translation'   => __('email-form-label')
                ],
                'locale' => [
                    'translation'   => __('locale-form-label'),
                ],
                'active' => [
                    'translation'   => __('active-form-label'),
                    'enum_translations' => [
                        '0'     => __('No'),
                        '1'     => __('Yes')
                    ]
                ],
                'roles' => [
                    'translation'   => __('roles-form-label')
                ],
                'password' => [
                    'translation'   => __('password-form-label')
                ],
                'logged' => [
                    'translation'   => __('Online')
                ],
            ]
        ];
    }
}

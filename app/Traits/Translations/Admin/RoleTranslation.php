<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;
use App\Traits\Translations\ModelTranslation;

trait RoleTranslation
{
    use AttributeTranslation;
    use ModelTranslation;

    /**
     * @var array
     */
    protected $translationAttributes = ['role_name'];

    /**
     * @var string
     */
    protected $translationRelationField = 'role_id';

    /**
     * @return array
     */
    private static function getTranslationsConfig()
    {
        return [
            'titles' => [
                'singular' => __('Role'),
                'plural' => __('Roles'),
            ],
            'attributes' => [
                'name' => [
                    'translation' => __('name-form-label')
                ],
                'role_name' => [
                    'translation' => __('name-form-label')
                ],
            ]
        ];
    }
}

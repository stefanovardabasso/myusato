<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait CRUD_filenameTranslation
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
                'singular'  => __('CRUD_title_singular'),
                'plural'    => __('CRUD_title_plural'),
            ],
            'attributes' => [
                'CRUD_column_name' => [
                    'translation'   => __('CRUD_column_name-form-label')
                ],
            ]
        ];
    }
}

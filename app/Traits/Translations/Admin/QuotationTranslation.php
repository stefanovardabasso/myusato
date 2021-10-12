<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait QuotationTranslation
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
                'singular'  => __('Quotation'),
                'plural'    => __('Quotations'),
            ],
            'attributes' => [
                'id_user' => [
                    'translation'   => __('id_user-form-label')
                ],
            ]
        ];
    }
}

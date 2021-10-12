<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait Quotationvens_lineTranslation
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
                'singular'  => __('Quotationvens_line'),
                'plural'    => __('Quotationvens_lines'),
            ],
            'attributes' => [
                'id_quotationven' => [
                    'translation'   => __('id_quotationven-form-label')
                ],
            ]
        ];
    }
}

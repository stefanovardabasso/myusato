<?php

namespace App\Traits\Translations\Admin;

use App\Traits\Translations\AttributeTranslation;

trait Quotation_lineTranslation
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
                'singular'  => __('Quotation_line'),
                'plural'    => __('Quotation_lines'),
            ],
            'attributes' => [
                'id_quotation' => [
                    'translation'   => __('id_quotation-form-label')
                ],
            ]
        ];
    }
}

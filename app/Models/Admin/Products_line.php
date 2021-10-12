<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\Products_lineTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\Products_lineRevisionable;
use App\Traits\DataTables\Admin\Products_lineDataTable;

class Products_line extends Model
{
    use Products_lineDataTable;
    use Products_lineRevisionable;
    use Products_lineTranslation;

    protected $guarded = [];

    public function product() {
        return $this->belongsTo(Product::class, 'id', 'id_product');
    }

    public function caract() {
        return $this->belongsTo(Caract::class, 'cc_sap', 'cc');
    }

    public function getProductLines($productId) {
        $productLinesSelect = [
            'label_'.app()->getLocale(). ' as label',
            'ans_'.app()->getLocale().' as answer',
        ];

        $productLines = Products_line::select($productLinesSelect)->where('id_product', $productId)->get();

        $productLines = $productLines->filter(function($productLine) {
            if (!isset($productLine->label) || !isset($productLine->answer)) {
                return false;
            }

            return true;
        });

        return $productLines;
    }
}

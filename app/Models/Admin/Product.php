<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\ProductTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\ProductRevisionable;
use App\Traits\DataTables\Admin\ProductDataTable;

class Product extends Model
{
    use ProductDataTable;
    use ProductRevisionable;
    use ProductTranslation;

    protected $guarded = [];

    public function offers() {
        return $this->belongsTo(Offert::class, 'id', 'id_product');
    }

    public function family() {
        return $this->hasOne(Fam_select::class, 'cod_fam', 'family');
    }

    public function lines() {
        return $this->hasMany(Products_line::class, 'id_product', 'id');
    }

    public function bundleProducts() {
        return $this->belongsToMany(Offert::class, 'relation_offert_products','idproduct','idoffert' );
    }
    public function getProductsBy($filters = null) {

       $getProductsByFiltersQuery =  Product::with('offers')->whereHas('offers');

       if ($filters !== null) {
           if (isset($filters['cod_fam'])) {
               $getProductsByFiltersQuery->where('family', $filters['cod_fam']);
           }
           if (isset($filters['Marca_Selezione'])) {
               if (is_array($filters['Marca_Selezione'])) {
                   $getProductsByFiltersQuery->whereIn('brand', $filters['Marca_Selezione']);

               } else {
                   $getProductsByFiltersQuery->where('brand', $filters['Marca_Selezione']);
               }
           }
       }

       return $getProductsByFiltersQuery->get();
    }

    public function getBrandsByFamilyCode($familyCode = null) {
        if ($familyCode === null) {
            throw new \Exception('Family code is null');
        }
        $brandsQuery = Product::select('brand')->leftJoin('fam_selects as fs', 'family','=','fs.cod_fam')->where('fs.cod_fam',$familyCode)->groupBy('brand');

        return  $brandsQuery->get();
    }

    public function getProductsCountByFilterButton($filterId) {

         $fams = Fam_select::query()->where('button_id','=',$filterId)->get();
         $relations = Relation_offert_product::get();
         $num =0;
          foreach ($relations as $re){

             $pro = Product::query()->where('id','=',$re->idproduct)->first();
              if($pro){
             foreach ($fams as $fam){
                 if($pro->family == $fam->cod_fam){
                     $num++;
                     break;
                 }
             }
              }




          }




        return $num;
    }

    public function getProductWithOffersFilters($productsWithOffers) {
       $types = $productsWithOffers->unique('type')->map(function ($product) {
          return $product->type;
        });
        $brands = $productsWithOffers->unique('brand')->map(function ($product) {
            return $product->brand;
        });
        $models = $productsWithOffers->unique('model')->map(function ($product) {
            return $product->model;
        });

        return [
            'types' => $types,
            'models' => $models,
            'brands' => $brands,
        ];
    }
}

<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\OffertTranslation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\OffertRevisionable;
use App\Traits\DataTables\Admin\OffertDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
class Offert extends Model
{
    use OffertDataTable;
    use OffertRevisionable;
    use OffertTranslation;

    protected $guarded = [];

    public function gallery()
    {
        return $this->hasMany(Gallery::class, 'offert_id', 'id')->orderBy('position');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'id_product');
    }

    public function bundleProducts()
    {
        return $this->belongsToMany(Product::class, 'relation_offert_products', 'idoffert', 'idproduct');
    }

    public function options()
    {
        return $this->hasMany(Option::class, 'offer_id', 'id');
    }

    public function getSimilarOffers($offerFamilyCode, $offerId)
    {
        return $this->getOffersWithProduct(['cod_fam' => $offerFamilyCode])
            ->take(4)
            ->filter(function ($similarOffer) use ($offerId) {
                return $similarOffer->id != $offerId;
            });
    }

    public function getOptions($offerId)
    {
        $offer = Offert::with('options.user:id,name,surname')->find($offerId);

        return $offer->options;
    }

    public function addOption($offerId,$cclient)
    {

        if (!auth()->user()) {
            return ['status' => false, 'message' => 'You must be logged in to add options'];
        }

        $userId = auth()->user()->id;

        $hasOption = Option::where('offer_id', $offerId)->where('user_id', $userId)->first();

        if ($hasOption) {
            return ['status' => false, 'message' => 'You already have an option for this item', 'option' => $hasOption];
        }

        $option = new Option;

        $option->offer_id = $offerId;
        $option->user_id = $userId;
        $option->status = 0;
        $option->client = $cclient;
        $option->created_at = Carbon::now();

        $option->save();

        return ['status' => true];
    }

    public function userHasOption($offerId)
    {
        if (!auth()->user()) {
            return false;
        }
        $option = Option::query()->select('offer_id')->where('offer_id', $offerId)->where('user_id', auth()->user()->id)
            ->where('status','=',0)->get();

        if (count($option) === 0) {
            return false;
        }

        return true;
    }

    public function isInCatalogMethod($offerId)
    {
        if (!auth()->user()) {
            return false;
        }
        $catalogOffer = Mymachine::query()->select('id_offert')->where('id_offert', $offerId)->where('id_user', auth()->user()->id)->get();

        if (count($catalogOffer) === 0) {
            return false;
        }

        return true;
    }

    public function getOffersWithProduct($filters = null)
    {
        $price = 'list_price_uf';
        $descript = 'desc_'. app()->getLocale() .'_uf';
        $title_1 = 'title_1_uf';
        $title_2 = 'title_2_uf';
        $title_3 = 'title_3_uf';
        $target = '1';
        $target_two = 'UF';

        if (Auth::check()) {
            $role = auth()->user()->getrole();




            if ($role[0]->id == '2' || $role[0]->id == '3') {
                $price = 'list_price_co';
                $descript = 'desc_' . app()->getLocale() . '_co';
                $title_1 = 'title_1_co';
                $title_2 = 'title_2_co';
                $title_3 = 'title_3_co';
                $target = '2';
                $target_two = 'CO';

            }elseif($role[0]->id == '8' | $role[0]->id == '1' | $role[0]->id == '5'){ // venditore av

                 if(Session::get('list')){

                     if(Session::get('list') == 1){

                         $price = 'list_price_uf';
                         $descript = 'desc_'. app()->getLocale() .'_uf';
                         $title_1 = 'title_1_uf';
                         $title_2 = 'title_2_uf';
                         $title_3 = 'title_3_uf';
                         $target_two = 'UF';

                     }else{
                         $price = 'list_price_co';
                         $descript = 'desc_' . app()->getLocale() . '_co';
                         $title_1 = 'title_1_co';
                         $title_2 = 'title_2_co';
                         $title_3 = 'title_3_co';
                         $target = '2';
                         $target_two = 'CO';
                     }



                 }else{
                     $price = 'list_price_co';
                     $descript = 'desc_' . app()->getLocale() . '_co';
                     $title_1 = 'title_1_co';
                     $title_2 = 'title_2_co';
                     $title_3 = 'title_3_co';
                     $target = '2';
                     $target_two = 'CO';
                 }


            } else {
                $price = 'list_price_uf';
                $descript = 'desc_'. app()->getLocale() .'_uf';
                $title_1 = 'title_1_uf';
                $title_2 = 'title_2_uf';
                $title_3 = 'title_3_uf';
                $target_two = 'UF';
            }
        }

        $select = [
            'offerts.id',
            'id_product',
            'p.family as productsFamily',
            'p.category as productCategory',
            'p.types as productType',
            'p.class as productClass',
            $descript . ' as description',
            'type as productType',
            'model',
            'serialnum',
            'brand',
            $price . ' as price',
            $title_1 . ' as title1',
            $title_2 . ' as title2',
            $title_3 . ' as title3',
            'partita as myUsatoCode',
            'year',
            'location',
            'orelavoro as workingHours',
            'serialnum',
            'type_off as type',
            'fs.option_' . app()->getLocale() . ' as familyLabel',
            'fs.button_id as familygroup',
            'offerts.updated_at as date'
        ];

        $catalog = Mymachine::query()->select('id_offert')->where('id_user', '=',Auth::id())->get()->map(function ($item) {
            return $item->id_offert;
        })->values()->toArray();





          $offers = Offert::select($select)
            ->where('target_user','=',$target)
            ->where('status','=','1')
            ->leftJoin('products as p', 'offerts.id_product', '=', 'p.id')
            ->groupBy('p.id')
            ->leftJoin('fam_selects as fs', 'fs.cod_fam', '=', 'p.family')
            ->with('product.lines.caract')
            ->with('gallery')

            ->get();




        $select[] = 'relation_offert_products.idproduct as bundleProductId';

        $bundles = Offert::select($select)
            ->where('type_off', 'Bundle')
            ->leftJoin('relation_offert_products', 'relation_offert_products.idoffert', '=', 'offerts.id')
            ->leftJoin('products as p', 'p.id', '=', 'relation_offert_products.idproduct')
            ->leftJoin('fam_selects as fs', 'fs.cod_fam', '=', 'p.family')
            ->with('gallery')
            ->with('bundleProducts.lines.caract')
            ->get();

        $offers = $offers->map(function ($offer) use ($bundles, $catalog) {
            if (in_array($offer->id, $catalog)) {
                $offer->isInCatalog = true;
            } else {
                $offer->isInCatalog = false;
            }
            foreach ($bundles as $bundle) {
                if ($bundle->id === $offer->id) {
                    $bundle->isInCatalog = $offer->isInCatalog;
                    return $bundle;
                }
            }
            return $offer;
        });

        $offers = $offers->sortBy(function ($offer) use ($filters) {
            return $offer->date;
        })->reverse();

        $rangeFilters = [];
        foreach ($filters as $index => $filter) {
            if (str_ends_with($index, '_start')) {
                $newIndex = str_replace(['_start', '_end'], '', $index);
                if (!isset($rangeFilters[$newIndex])) {
                    $rangeFilters[$newIndex] = ['start' => $filter];
                } else {
                    $rangeFilters[$newIndex]['start'] = $filter;
                }
            }
            if (str_ends_with($index, '_end')) {
                $newIndex = str_replace(['_start', '_end'], '', $index);
                if (!isset($rangeFilters[$newIndex])) {
                    $rangeFilters[$newIndex] = ['end' => $filter];
                } else {
                    $rangeFilters[$newIndex]['end'] = $filter;
                }
            }
        };
        // filter with range filters

        // Ore filter
        if (isset($rangeFilters['Ore_Lavoro_fino_A_Selezione'])) {

            $offers = $offers->filter(function ($offer) use ($rangeFilters) {
                if ($offer->type === 'single') {
                    $workingHours = intval($offer->product->orelavoro);

                    return $workingHours >= $rangeFilters['Ore_Lavoro_fino_A_Selezione']['start'] &&
                        $workingHours <= $rangeFilters['Ore_Lavoro_fino_A_Selezione']['end'];
                } else if ($offer->type === 'Bundle') {
                    $filteredProducts = $offer->bundleProducts->filter(function ($product) use ($rangeFilters) {
                        $workingHours = intval($product->orelavoro);
                        return $workingHours >= $rangeFilters['Ore_Lavoro_fino_A_Selezione']['start'] &&
                            $workingHours <= $rangeFilters['Ore_Lavoro_fino_A_Selezione']['end'];
                    });

                    if (count($filteredProducts) > 0) {
                        return true;
                    }
                }
                return false;
            });
        }


        // hardcoded filters that don't have CC
        if (isset($filters['Std_Preparazione_Selezione'])) {
            $typeAllestimento = [
                'EASY' => 'Easy',
                'PREMIUM' => 'Premium',
                'PREMIUM PLUS' => 'Premium+',
                'PREPARATO' => 'Preparato',
            ];
            $offers = $this->filterProductColumnByPickList($offers, $filters, 'Std_Preparazione_Selezione', 'typeallestimento', $typeAllestimento, );
        }

        //Stato_Allestimento_Selezione filter
        if (isset($filters['Stato_Allestimento_Selezione'])) {
            $macchinaAllestita = [
                'I' => 'in allestimento',
                'P' => 'Pronto',
                'D' => 'da preparare'
            ];

            $offers = $this->filterProductColumnByPickList($offers, $filters, 'Stato_Allestimento_Selezione', 'macchinallestita', $macchinaAllestita, );

        }

        // TODO: Can return two duplicate offers because fam_selects doesn't have unique cod_fam

        if ($filters !== null && count($filters) > 0) {

            $num_group = Fam_select::query()->where('cod_fam', '=', $filters['cod_fam'])->first();

            $groups = Fam_select::query()->where('button_id', '=', $num_group->button_id)->first();

            if (isset($filters['cod_fam'])) {
                $offers = $offers->filter(function ($offer) use ($groups) {
                    return $offer->familygroup === $groups->button_id;
                });
            }



            if (isset($filters['Famiglia'])) {
                $offers = $offers
                    ->filter(function ($offer) use ($filters) {
                        if (is_array($filters['Famiglia'])) {

                            $check_p = false;
                            foreach ($filters['Famiglia'] as $line){

                                $search = 'option_'.app()->getLocale();
                                $params = Fam_select::query()->where($search, '=',$line)->first();

                                if($params->classe != ''){

                                    if($offer->productClass == $params->classe){
                                        $check_p =  true;
                                    }

                                }else{
                                    if($offer->productType == $params->type){
                                        $check_p =  true;
                                    }
                                }


                            }


                            if($check_p){
                                 return true;
                            }



                        }
                        return $offer->familyLabel === $filters['Famiglia'];
                    });
            }





            if (isset($filters['Marca_Selezione'])) {
                $offers = $offers
                    ->filter(function ($offer) use ($filters) {
                        if (is_array($filters['Marca_Selezione'])) {
                            return in_array($offer->brand, $filters['Marca_Selezione']);
                        }
                        return $offer->brand === $filters['Marca_Selezione'];
                    });
            }

            if (isset($filters['model'])) {
                $offers = $offers
                    ->filter(function ($offer) use ($filters) {
                        if ($offer->type === 'single') {
                            return stripos($offer->model, $filters['model']) !== false;
                        } else if ($offer->type === 'Bundle') {
                            $filteredProducts = $offer->bundleProducts->filter(function ($product) use ($filters) {
                                return stripos($product->model, $filters['model']) !== false;
                            });

                            if (count($filteredProducts) > 0) {
                                return true;
                            }
                        }
                        return false;
                    });
            }

            if (isset($filters['price_start']) && isset($filters['price_end'])) {
                $offers = $offers
                    ->map(function ($offer) {
                        $offer->price = doubleval($offer->price);
                        return $offer;
                    })
                    ->filter(function ($offer) use ($filters) {
                        return $offer->price >= $filters['price_start'] && $offer->price <= $filters['price_end'];
                    });
            }

            // These are hardcoded...
            $forbiddenCaracts = [
                'cod_fam',
                'Famiglia',
                'model',
                'price',
                'Marca_Selezione',
                'Std_Preparazione_Selezione',
                'Stato_Allestimento_Selezione',
                'Ore_Lavoro_fino_A_Selezione',
                'sort',
                'order'
            ];
            // Get array of cod_question => cc
            $caracts = Caract::query()->select('cod_question', 'cc')->get()
                ->filter(function ($caract) use ($forbiddenCaracts) {
                    return !in_array($caract->cod_question, $forbiddenCaracts);
                })
                ->filter(function ($caract) {
                    return isset($caract->cc) && $caract->cc !== '';
                })
                ->flatMap(function ($caract) {
                    return [$caract->cod_question => $caract->cc];
                })
                ->toArray();

            $filtersWithCaracts = collect($filters)
                ->filter(function ($filter, $cod_question) use ($forbiddenCaracts) {
                    return !in_array($cod_question, $forbiddenCaracts);
                })
                ->filter(function ($filter, $cod_question) {
                    return !(str_ends_with($cod_question, '_start') || str_ends_with($cod_question, '_end'));
                });

            foreach ($filtersWithCaracts as $filterCode => $values) {
                $offers = $offers->filter(function ($offer) use ($filterCode, $values, $caracts) {
                    if ($offer->type === 'single') {
                        $productLines = $offer->product->lines;
                        return $this->filterByProductLines($productLines, $caracts, $filterCode, $values);

                    } else if ($offer->type === 'Bundle') {
                        $filteredProducts = $offer->bundleProducts->filter(function ($product) use ($caracts, $filterCode, $values) {
                            $productLines = $product->lines;
                            return $this->filterByProductLines($productLines, $caracts, $filterCode, $values);
                        });

                        if (count($filteredProducts) > 0) {
                            return true;
                        }
                    }
                    return false;
                });
            }

            $rangeFiltersWithCaracts = collect($rangeFilters)
                ->filter(function ($rangeFilter, $cod_question) use ($forbiddenCaracts) {
                    return !in_array($cod_question, $forbiddenCaracts);
                });

            foreach ($rangeFiltersWithCaracts as $rangeFilterCode => $values) {
                $offers = $offers->filter(function ($offer) use ($rangeFilterCode, $values, $caracts) {
                    if ($offer->type === 'single') {
                        $productLines = $offer->product->lines;
                        return $this->filterByProductLines($productLines, $caracts, $rangeFilterCode, $values, 'rangeFilter');
                    } else if ($offer->type === 'Bundle') {
                        $filteredProducts = $offer->bundleProducts->filter(function ($product) use ($caracts, $rangeFilterCode, $values) {
                            $productLines = $product->lines;
                            return $this->filterByProductLines($productLines, $caracts, $rangeFilterCode, $values, 'rangeFilter');
                        });

                        if (count($filteredProducts) > 0) {
                            return true;
                        }
                    }
                    return false;
                });
            }

            if (isset($filters['sort']) && isset($filters['order'])) {
                $offers = $offers->sortBy(function ($offer) use ($filters) {
                    return $offer->{$filters['sort']};
                });
                if ($filters['order'] === 'desc') {
                    $offers = $offers->reverse();
                }
            }

        }
//        die(dd($offers));
    //    $offer = null;



        return $offers;
    }

    private function areEqual($str1, $str2)
    {
        return strtolower(utf8_encode($str1)) == strtolower(utf8_encode($str2));
    }

    public function getOfferWithProduct($offerId)
    {
        $price = 'list_price_uf';
        $descript = 'desc_'. app()->getLocale() .'_uf';
        $title_1 = 'title_1_uf';
        $title_2 = 'title_2_uf';
        $title_3 = 'title_3_uf';

        if (Auth::check()) {
            $role = auth()->user()->getrole();
            if ($role[0]->id == '2' || $role[0]->id == '3') {
                $price = 'list_price_co';
                $descript = 'desc_'. app()->getLocale() .'_co';
                $title_1 = 'title_1_co';
                $title_2 = 'title_2_co';
                $title_3 = 'title_3_co';

            } else {
                $price = 'list_price_uf';
                $descript = 'desc_'. app()->getLocale() .'_uf';
                $title_1 = 'title_1_uf';
                $title_2 = 'title_2_uf';
                $title_3 = 'title_3_uf';
            }
        }

        $select = [
            'id_product',
            $descript . ' as description',
            'type',
            'model',
            'serialnum',
            'brand',
            $price . ' as price',
            $title_1 . ' as title_1',
            $title_2 . ' as title_2',
            $title_3 . ' as title_3',
            'partita as myUsatoCode',
            'year',
            'location',
            'orelavoro as workingHours',
            'serialnum',
            'fs.option_' . app()->getLocale() . ' as familyLabel',
            'p.family as family'
        ];

        return $offer = Offert::select($select)
            ->leftJoin('products as p', 'offerts.id_product', '=', 'p.id')
            ->leftJoin('fam_selects as fs', 'p.family', '=', 'fs.cod_fam')
            ->find($offerId);
    }

    public function getPriceByRole($offerId)
    {


        $price = Offert::query()->where('id', '=', $offerId)->first();
        if (Auth::check()) {
            $role = auth()->user()->getrole();
            if ($role[0]->id == '2' || $role[0]->id == '3') {

                return $price->list_price_co;
            } else {
                return  $price->list_price_uf;
            }
        }else{
            return  $price->list_price_uf;
        }





    }


    /**
     * @param $searchedValue
     * @param $product_line
     * @param $i
     * @return bool
     */
    private function filterOffersByProductLine($searchedValue, $product_line): bool
    {
        if (is_array($searchedValue)) {
            for ($i = 0; $i < count($searchedValue); $i++) {
                return $this->areEqual($product_line->ans_it, $searchedValue[$i]) || $this->areEqual($product_line->ans_en, $searchedValue[$i]);
            }
        }

        return $this->areEqual($product_line->ans_it, $searchedValue) || $this->areEqual($product_line->ans_en, $searchedValue);
    }

    /**
     * @param $offers
     * @param $filters
     * @param array $valuesMap
     * @return mixed
     */
    private function filterProductColumnByPickList($offers, $filters, $filterCode, $filterColumn, array $valuesMap)
    {
        $offers = $offers->filter(function ($offer) use ($filters, $valuesMap, $filterCode, $filterColumn) {
            if ($offer->type === 'single') {
                $typeIndex = trim($offer->product->{$filterColumn});
                if (!is_array($filters[$filterCode])) {
                    $filters[$filterCode] = [$filters[$filterCode]];
                }
                if (isset($valuesMap[$typeIndex]) &&
                    in_array($valuesMap[$typeIndex], $filters[$filterCode])) {
                    return true;
                }

            } else if ($offer->type === 'Bundle') {
                $filteredProducts = $offer->bundleProducts->filter(function ($product) use ($filters, $valuesMap, $filterCode, $filterColumn) {
                    $typeIndex = trim($product->{$filterColumn});
                    if (!is_array($filters[$filterCode])) {
                        $filters[$filterCode] = [$filters[$filterCode]];
                    }
                    if (isset($valuesMap[$typeIndex]) &&
                        in_array($valuesMap[$typeIndex], $filters[$filterCode])) {
                        return true;
                    }
                    return false;
                });
                if (count($filteredProducts) > 0) {
                    return true;
                }
            }
            return false;
        });
        return $offers;
    }

    /**
     * @param $lines
     * @param array $caracts
     * @param string $filterCode
     * @param $values
     * @param string|null $filterType
     * @return bool
     */
    private function filterByProductLines($lines, array $caracts, string $filterCode, $values, $filterType = null): bool
    {
        $filteredProductLines = $lines->filter(function ($product_line) use ($caracts, $filterCode) {
            if (isset($caracts[$filterCode])) {
                return $product_line->cc_sap === $caracts[$filterCode];
            }
            return false;
        });

        if (!count($filteredProductLines) > 0) {
            return false;
        }


        $filteredProductLinesByValues = $filteredProductLines->filter(function ($product_line) use ($values, $filterType) {
            if (!is_array($values)) {
                $values = [$values];
            }
            if ($filterType !== null) {
                $start = intval($values['start']);
                $end = intval($values['end']);
                $answer = app()->getLocale() === 'en' ? intval($product_line->ans_en) : intval($product_line->ans_it);

                return $answer >= $start && $answer <= $end;
            }

            return in_array($product_line->ans_it, $values) || in_array($product_line->ans_en, $values);
        });

        return count($filteredProductLines) === count($filteredProductLinesByValues);
    }
}

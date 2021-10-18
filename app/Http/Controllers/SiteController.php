<?php

namespace App\Http\Controllers;

use App\Models\Admin\Buttons_filter;
use App\Models\Admin\Caract;
use App\Models\Admin\Fam_select;
use App\Models\Admin\Gallery;
use App\Models\Admin\Offert;
use App\Models\Admin\Option;
use App\Models\Admin\Quotation;
use App\Models\Admin\Quotation_line;
use App\Models\Admin\Relation_offert_product;
use App\Models\Admin\Product;
use App\Models\Admin\Products_line;
use App\Models\Admin\Contactform;
use App\Models\Admin\Mymachine;
use App\Models\Admin\Savedfilter;
use App\Models\Admin\Savedfilters_line;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Collection;
use Redirect;
use Session;
use Illuminate\Session\Store;

use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;

class SiteController extends Controller
{
    private $productsLineModel;
    private $offerModel;
    private $galleryModel;
    private $buttonsFilterModel;
    private $productModel;
    private $familySelectModel;
    private $savedFilterModel;

    public function __construct(Products_line $productsLineModel,
                                Offert $offerModel, Gallery $galleryModel,
                                Buttons_filter $buttonsFilterModel,
                                Product $productModel,
                                Fam_select $familySelectModel,
                                Savedfilter $savedFiltersModel)
    {
        $this->productsLineModel = $productsLineModel;
        $this->offerModel = $offerModel;
        $this->galleryModel = $galleryModel;
        $this->buttonsFilterModel = $buttonsFilterModel;
        $this->productModel = $productModel;
        $this->familySelectModel = $familySelectModel;
        $this->savedFilterModel = $savedFiltersModel;
    }

    public function index()
    {

        $filterId = \request('filterId');
        $filterInfo = null;
        $productsCount = 0;
//        if (isset($filterId)) {
//            $filterInfo = $this->buttonsFilterModel->getFilterInfo($filterId);
//            $filterInfo->fam_selects = $filterInfo->famSelects->map(function ($f) {
//                $f->questions_filters = $f->questionsFilters->map(function ($qf) {
//
//                    if ($qf->cod_question === 'Marca_Selezione') {
//
//                        $brands = collect($this->productModel->getBrandsByFamilyCode($qf->cod_fam)->toArray())->flatten()->toArray();
//
//                        $brands = implode(';', $brands);
//
//                        $qf->values = $brands;
//                    }
//
//                    return $qf;
//                });
//            });
//
//            $productsCount = $this->productModel->getProductsCountByFilterButton($filterId);
//        } else {
//            return redirect()->route('filters', ['filterId' => 1]);
//        }

        $filterButtons = $this->buttonsFilterModel->getButtonFilters();

        $type_user_car = 'UF';
        $type_user_id = '1';

        if(Auth::check()){
            $role = auth()->user()->getrole();
            if ($role[0]->id == '2' | $role[0]->id == '3' | $role[0]->id == '1' | $role[0]->id == '8' | $role[0]->id == '5') {
                $type_user_car = 'CO';
                $type_user_id = '2';
        } else {
                $type_user_car = 'UF';
                $type_user_id = '1';
            }
        }


        $images = [];
        $prods = [];
        $catalog = [];
        $bundle_offerts = Offert::query()
            ->where('type_off', '=', 'Bundle')
            ->where('target_user','=',$type_user_id)
            ->LIMIT(4)
            ->OrderBy('id', 'DESC')
            ->get();


        foreach ($bundle_offerts as $of) {
            $images[$of->id] = Gallery::where('offert_id', '=', $of->id)->where('type','=',$type_user_car)->orderBy('position','ASC')->first();
            $relations = Relation_offert_product::where('idoffert', '=', $of->id)->get();
            $a = 0;
            $mycatalog = Mymachine::query()->where('id_offert', '=', $of->id)->where('id_user', '=', Auth::id())->first();
            if (!$mycatalog) {
                $stat = false;
            } else {
                $stat = true;
            }
            $catalog[$of->id] = $stat;
            foreach ($relations as $re) {

                $prods[$of->id][$a] = Product::where('id', '=', $re->idproduct)->first();
                $a++;
            }

        }

       $single_offerts = Offert::query()
           ->where('type_off', '=', 'single')
           ->where('target_user','=',$type_user_id)
           ->where('status','=','1')
           ->LIMIT(4)->OrderBy('id', 'DESC')->get();




        foreach ($single_offerts as $of) {
            $mycatalog = Mymachine::query()->where('id_offert', '=', $of->id)->where('id_user', '=', Auth::id())->first();

            $single_offerts_lines[$of->id] = Products_line::query()
                ->where('id_product','=',$of->id_product)->LIMIT(4)->get();
            if (!$mycatalog) {
                $stat = false;
            } else {
                $stat = true;
            }

            $catalog[$of->id] = $stat;
            $images[$of->id] = Gallery::where('offert_id', '=', $of->id)->where('type','=',$type_user_car)->orderBy('position','ASC')->first();
            $prods[$of->id] = Product::where('id', '=', $of->id_product)->first();

        }


        return view('site.home', [
            'filterButtons' => $filterButtons,
            'filterInfo' => $filterInfo,
            'singleoff' => $single_offerts,
            'single_offerts_lines' => $single_offerts_lines,
            'bunoff' => $bundle_offerts,
            'imgoff' => $images,
            'prods' => $prods,
            'catalog' => $catalog,
            'productsCount' => $productsCount,
            'filterId' => $filterId
        ]);
    }

    public function search()
    {
        $requestFilters = \request()->all();
        $filterButtonId = \request('filterId');


          $filterButtons = $this->buttonsFilterModel->getButtonFilters();
          $offersWithProducts  = $this->offerModel->getOffersWithProduct($requestFilters);

         $family = $this->familySelectModel->getFamilyName($requestFilters['cod_fam']);

         $brands = collect($this->productModel->getBrandsByFamilyCode($requestFilters['cod_fam'])->toArray())->flatten()->toArray();

        $brands = implode(';', $brands);

        $selectedFilterButton = $this->buttonsFilterModel->getFilterLabel($filterButtonId);
        $filterInfo = $this->buttonsFilterModel->getFilterInfo($filterButtonId);

        $filters = $this->productModel->getProductWithOffersFilters($offersWithProducts);

         $selectedFamilyFilters = $filterInfo->famSelects->filter(function ($fam) use ($requestFilters) {
            return $fam->cod_fam == $requestFilters['cod_fam'];
        })->first();

        $selectedFamilyFilters->questionsFilters = $selectedFamilyFilters->questionsFilters
            ->filter(function ($questionFilter) {
                return $questionFilter->values;
            })
            ->sortBy('order_question')
//            ->take(6)
            ->map(function ($questionFilter) use ($requestFilters, $brands) {
                if ($questionFilter->cod_question === 'Marca_Selezione') {
                    $questionFilter->values = $brands;
                }
                $questionFilter->questionsFiltersTraduction = $questionFilter->questionsFiltersTraduction
                    ->filter($this->filterByChosenLanguage())
                    ->first();

                $questionFilter->selectedValues = collect($requestFilters)
                    ->keys()
                    ->filter(function ($key) use ($questionFilter) {
                        return $key === $questionFilter->cod_question;
                    })
                    ->map(function ($key) use ($requestFilters) {
                        return $requestFilters[$key];
                    });
                if (str_contains($questionFilter->values, '(')) {
                    if (app()->getLocale() === 'en') {
                        $questionFilter->values = collect(explode('(', trim($questionFilter->values, ';)')))->values()[1];
                    } else {
                        $questionFilter->values = collect(explode('(', trim($questionFilter->values, ';)')))->values()[0];
                    }
                }
                $questionFilter->values = collect(explode(';', trim($questionFilter->values, ';')))
                    ->map(function ($value) {
                        return trim($value);
                    })
                    ->map(function ($value) use ($questionFilter) {
                        if ($questionFilter->type === 'picklist') {
                            if (!in_array($value, $questionFilter->selectedValues->toArray())) {
                                return ['value' => $value, 'selected' => false];
                            }

                            return ['value' => $value, 'selected' => true];
                        }
                        return $value;
                    })
                    ->toArray();


                return $questionFilter;
            });

        $codFam = $requestFilters['cod_fam'];

           $rangeFilters = $selectedFamilyFilters->get()->map(function ($famFilter) use ($codFam) {
            $questions = $famFilter->questionsFilters->filter(function ($f) use ($codFam) {
                return $f->type === 'range' && $f->cod_fam === $codFam;
            });
            return $questions;
        })->filter(function ($item) {
            return count($item) > 0;
        })->flatten()
            ->map(function ($rangeFilter) {
                return $rangeFilter->cod_question;
            })->toArray();

        $caracts = Caract::query()
            ->select('cc', 'cod_question', 'type')
            ->whereIn('cod_question', $rangeFilters)
            ->get()
            ->filter(function ($item) {
                return $item->cc !== "" && $item->type === 'range';
            });
        $ccs = $caracts->map(function ($item) {
            return $item->cc;
        })->flatten()->toarray();

        $maxValues = [
            'single' => [],
            'Bundle' => []
        ];

       $offersWithProducts->each(function ($offer) use ($ccs, &$maxValues) {
              // die($offer->type);
            if ($offer->type === 'single') {
                $productLines = $offer->product->lines->filter(function ($line) use ($ccs) {
                    return in_array($line->cc_sap, $ccs) && $line->caract->type === 'range';
                });

                foreach ($productLines as $line) {
                    if (isset($line->caract->cod_question)) {
                        $maxValues['single'][$offer->id][$line->caract->cod_question] = $line->ans_it;
                    } else {
                        continue;
                    }
                }
            } else if ($offer->type === 'Bundle') {
                foreach ($offer->bundleProducts as $product) {
                    $productLines = $product->lines->filter(function ($line) use ($ccs) {
                        return in_array($line->cc_sap, $ccs);
                    });
                    foreach ($productLines as $line) {
                        if (isset($line->caract->cod_question)) {
                            $maxValues['Bundle'][$offer->id][$line->caract->cod_question] = floatval($line->ans_it);
                        }
                    }
                }
            }
        });

        $parsedMaxValues = [];

        collect($maxValues)
            ->each(function ($type) use (&$parsedMaxValues) {
                collect($type)->each(function ($rangeFilters) use (&$parsedMaxValues) {
                    collect($rangeFilters)->each(function ($value, $cod_question) use (&$parsedMaxValues) {
                        if (!isset($parsedMaxValues[$cod_question])) {
                            $parsedMaxValues[$cod_question] = $value;
                        } else if ($parsedMaxValues[$cod_question] < $value) {
                            $parsedMaxValues[$cod_question] = $value;
                        }
                    });
                });
            });

        $filterForWorkingHours = [
            'cod_fam' => $codFam,
        ];
        $maxWorkingHours = $this->offerModel->getOffersWithProduct($filterForWorkingHours)->max('workingHours');
        $parsedMaxValues['Ore_Lavoro_fino_A_Selezione'] = $maxWorkingHours;

       $getPrice = $this->offerModel->getOffersWithProduct(['cod_fam' => $requestFilters['cod_fam']]);

        $price = [
            'min' => $getPrice->min('price'),
            'max' => $getPrice->max('price')
        ];

      //return $selectedFamilyFilters;
        return view('site.searchresult', [
            'filterButtons' => $filterButtons,
            'offersWithProduct' => $offersWithProducts,
            'family' => $family,
            'selectedFilterButton' => $selectedFilterButton,
            'filters' => $filters,
            'sideFiltersInfo' => $selectedFamilyFilters,
            'price' => $price,
            'filterId' => $filterButtonId,
            'maxValuesForRanges' => $parsedMaxValues,
        ]);
    }

    public function product()
    {
        $filterButtons = $this->buttonsFilterModel->getButtonFilters();

        return view('site.searchresult', ['filterButtons' => $filterButtons]);
    }

    public function productdetail()
    {
        $offerId = \request('id_offert');


        $type_user_car = 'UF';
        $type_user_id = '1';

        if(Auth::check()){
            $role = auth()->user()->getrole();
            if ($role[0]->id == '2' || $role[0]->id == '3') {
                $type_user_car = 'CO';
                $type_user_id = '2';
            } else {
                $type_user_car = 'UF';
                $type_user_id = '1';
            }
        }


        $off_check = Offert::query()->where('id',$offerId)->first();

//      if($off_check->target_user != $type_user_id || $off_check->status == 0){
//          return Redirect::to('/');
//      }



        $offerWithProduct = $this->offerModel->getOfferWithProduct($offerId);
        $productLines = $this->productsLineModel->getProductLines($offerWithProduct->id_product);
        $num_lines = 0;
        $num_lines = count($productLines)/2;
        $cop_num_lines = $num_lines;
        $gallery = $this->galleryModel->getGallery($offerId);


        $similarOffers = [];//$this->offerModel->getSimilarOffers($offerWithProduct->family, $offerId);

        $mandatoryProductInfo = [
            __('Brand') => $offerWithProduct->brand,
            __('Model') => $offerWithProduct->model,
            __('Year') => $offerWithProduct->year,
            __('Working Hours') => $offerWithProduct->workingHours,
        ];

        $isInCatalog = $this->offerModel->isInCatalogMethod($offerId);
        $userHasOption = $this->offerModel->userHasOption($offerId);

        $hasProductLines = count($productLines) > 0;

        return view(
            'site._scheda-product',
            [
                'type' => 'Single',
                'offerId' => $offerId,
                'offerWithProduct' => $offerWithProduct,
                'gallery' => $gallery,
                'mandatoryProductInfo' => $mandatoryProductInfo,
                'productLines' => $productLines,
                'hasProductLines' => $hasProductLines,
                'similarOffers' => $similarOffers,
                'isInCatalog' => $isInCatalog,
                'userHasOption' => $userHasOption,
                'num_lines' => $num_lines,
                'cop_num_lines' => $cop_num_lines
            ]
        );
    }

    public function productbundetail()
    {
        $type_user_car = 'UF';
        $type_user_id = '1';
        $descript = 'desc_'. app()->getLocale() .'_uf';
        $price = 'list_price_uf';
        $title_1 = 'title_1_uf';
        $title_2 = 'title_2_uf';
        $title_3 = 'title_3_uf';

        if(Auth::check()){
            $role = auth()->user()->getrole();
            if ($role[0]->id == '2' || $role[0]->id == '3') {
                $type_user_car = 'CO';
                $type_user_id = '2';
                $price = 'list_price_co';
                $descript = 'desc_'. app()->getLocale() .'_co';
                $title_1 = 'title_1_co';
                $title_2 = 'title_2_co';
                $title_3 = 'title_3_co';
            } else {
                $type_user_car = 'UF';
                $type_user_id = '1';
                $price = 'list_price_uf';
                $descript = 'desc_'. app()->getLocale() .'_uf';
                $title_1 = 'title_1_uf';
                $title_2 = 'title_2_uf';
                $title_3 = 'title_3_uf';
            }
        }


        $offerId = \request('id_offert');

        $off_check = Offert::query()->where('id',$offerId)->first();

//        if($off_check->target_user != $type_user_id || $off_check->status == 0){
//            return Redirect::to('/');
//        }

        $offerSelect = [
            'id',
            'id_product',
            $descript . ' as description',
            $price . ' as price',
            $title_1 . ' as title_1',
            $title_2 . ' as title_2',
            $title_3 . ' as title_3',
        ];


      //  $offerSelect = [
      //      'offerts.id',
      //      'id_product',
      //      'descrip' . app()->getLocale() . ' as description',
      //      'price_uf',
      //      'title',
      //  ];

        $offert = Offert::query()->select($offerSelect)->where('id', '=', $offerId)->with('product')->first();
        $asoc_prod = Relation_offert_product::where('idoffert', '=', $offert->id)->get();
        $gallery = Gallery::query()->where('offert_id', '=', $offert->id)->get();
        $prod = [];
        $productLines = [];
        $a = 0;

        $productLineSelect = [
            'label_' . app()->getLocale() . ' as label',
            'ans_' . app()->getLocale() . ' as answer',
        ];
        foreach ($asoc_prod as $asc) {
            $prod[$a] = Product::query()->where('id', '=', $asc->idproduct)->first();
            $productLines[$prod[$a]->id] = Products_line::query()->select($productLineSelect)->where('id_product', '=', $prod[$a]->id)->get();
            $a++;
        }

        $similarOffers = [];//$this->offerModel->getSimilarOffers($offert->product->family, $offerId);
        $userHasOption = $this->offerModel->userHasOption($offerId);
        $isInCatalog = $this->offerModel->isInCatalogMethod($offerId);
        $num_lines = 0 ;
        $num_lines = count($productLines);
        return view(
            'site._scheda-bundle',
            [
                'type' => 'Bundle',
                'offerId' => $offert->id,
                'offert' => $offert,
                'gallery' => $gallery,
                'products' => $prod,
                'productlines' => $productLines,
                'similarOffers' => $similarOffers,
                'isInCatalog' => $isInCatalog,
                'userHasOption' => $userHasOption,
                'num_lines' => $num_lines,
            ]
        );
    }

    public function storemessage(Request $request)
    {
        if ($request->input('name') == NULL) {
            $ans = '<div class="alert alert-success" role="alert" style=" color: #ffffff;background-color: #ee1e1e;border-color: #ee1e1e;padding: 15px;margin-bottom: 20px;border: 1px solid transparent; border-top-color: transparent;border-right-color: transparent;border-bottom-color: transparent;border-left-color: transparent;border-radius: 4px;">' . __('Devi scrivere il tuo nome') . '</div>';
            return $ans;
        } elseif ($request->input('surname') == NULL) {
            $ans = '<div class="alert alert-success" role="alert" style=" color: #ffffff;background-color: #ee1e1e;border-color: #ee1e1e; padding: 15px;margin-bottom: 20px;border: 1px solid transparent; border-top-color: transparent;border-right-color: transparent;border-bottom-color: transparent;border-left-color: transparent;border-radius: 4px;">' . __('Devi scrivere il tuo cognome') . '</div>';
            return $ans;
        } elseif ($request->input('company') == NULL) {
            $ans = '<div class="alert alert-success" role="alert" style=" color: #ffffff;background-color: #ee1e1e;border-color: #ee1e1e; padding: 15px;margin-bottom: 20px;border: 1px solid transparent; border-top-color: transparent;border-right-color: transparent;border-bottom-color: transparent;border-left-color: transparent;border-radius: 4px;">' . __('Devi scrivere il nome della tua azienda') . '</div>';
            return $ans;
        } elseif ($request->input('email') == NULL) {
            $ans = '<div class="alert alert-success" role="alert" style=" color: #ffffff;background-color: #ee1e1e;border-color: #ee1e1e; border-color: #d6e9c6;padding: 15px;margin-bottom: 20px;border: 1px solid transparent; border-top-color: transparent;border-right-color: transparent;border-bottom-color: transparent;border-left-color: transparent;border-radius: 4px;">' . __('Devi scrivere la tua email') . '</div>';
            return $ans;
        } elseif (!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
            $ans = '<div class="alert alert-success" role="alert" style=" color: #ffffff;background-color: #ee1e1e;border-color: #ee1e1e; padding: 15px;margin-bottom: 20px;border: 1px solid transparent; border-top-color: transparent;border-right-color: transparent;border-bottom-color: transparent;border-left-color: transparent;border-radius: 4px;">' . __('Devi scrivere un e-mail valida') . '</div>';
            return $ans;
        } elseif ($request->input('phone') == NULL) {
            $ans = '<div class="alert alert-success" role="alert" style=" color: #ffffff;background-color: #ee1e1e;border-color: #ee1e1e; padding: 15px;margin-bottom: 20px;border: 1px solid transparent; border-top-color: transparent;border-right-color: transparent;border-bottom-color: transparent;border-left-color: transparent;border-radius: 4px;">' . __('Devi scrivere il tuo telefono') . '</div>';
            return $ans;
        } elseif ($request->input('message') == NULL) {
            $ans = '<div class="alert alert-success" role="alert" style=" color: #ffffff;background-color: #ee1e1e;border-color: #ee1e1e; padding: 15px;margin-bottom: 20px;border: 1px solid transparent; border-top-color: transparent;border-right-color: transparent;border-bottom-color: transparent;border-left-color: transparent;border-radius: 4px;">' . __('Devi scrivere un messaggio') . '</div>';
            return $ans;
        } elseif ($request->input('privacy') == NULL) {
            $ans = '<div class="alert alert-success" role="alert" style=" color: #ffffff;background-color: #ee1e1e;border-color: #ee1e1e;padding: 15px;margin-bottom: 20px;border: 1px solid transparent; border-top-color: transparent;border-right-color: transparent;border-bottom-color: transparent;border-left-color: transparent;border-radius: 4px;">' . __('Devi accettare le politiche sulla privacy') . '</div>';
            return $ans;
        }

        $record = new Contactform();
        $record->name = $request->input('name');
        $record->surname = $request->input('surname');
        $record->company = $request->input('company');
        $record->from_email = $request->input('email');
        $record->phone = $request->input('phone');
        $record->message = $request->input('message');
        $record->markenting_flag = $request->input('marketing');
        $record->privacy_flag = $request->input('privacy');
        $record->save();

        $ans = '<div class="alert alert-success" role="alert" style=" color: #3c763d;background-color: #5bee1e;border-color: #d6e9c6;padding: 15px;margin-bottom: 20px;border: 1px solid transparent; border-top-color: transparent;border-right-color: transparent;border-bottom-color: transparent;border-left-color: transparent;border-radius: 4px;">' . __('messaggio inviato, ti contatteremo a breve') . '</div>';
        return $ans;
    }

    public function allbundles(Request $request)
    {
        $images = [];
        $prods = [];

        $target = '1';


        $bundle_offerts = Offert::query()->where('type_off', '=', 'Bundle')->OrderBy('id', 'DESC')->get();


        foreach ($bundle_offerts as $of) {
            $images[$of->id] = Gallery::where('offert_id', '=', $of->id)->first();
            $relations = Relation_offert_product::where('idoffert', '=', $of->id)->get();
            $a = 0;
            foreach ($relations as $re) {

                $prods[$of->id][$a] = Product::where('id', '=', $re->idproduct)->first();
                $a++;
            }

        }
        return view('site.allofferts', [
            'bunoff' => $bundle_offerts,
            'imgoff' => $images,
            'prods' => $prods
        ]);
    }

    public function mycatalog(Request $request)
    {
        $user_id = Auth::id();
        $myofferts_sing = Mymachine::query()->where('id_user', '=', $user_id)->where('type', '=', 'Single')->get();
        $myofferts_bun = Mymachine::query()->where('id_user', '=', $user_id)->where('type', '=', 'Bundle')->get();
        $lines_sing = [];
        $offerts_sing = [];
        $offerts_bun = [];
        $offert = [];
        $images = [];
        $prods = [];


        foreach ($myofferts_sing as $off) {
            if($off->target_user == 1){
                 $tar = 'UF';
            }else{
                $tar = 'CO';
            }
            $images[$off->id_offert] = Gallery::query()
                ->where('offert_id', '=', $off->id_offert)
                ->where('type','=',$tar)
                ->where('position','=',1)
                ->first();
            $offert[$off->id_offert] = Offert::query()->where('id', '=', $off->id_offert)->first();
            $prods[$off->id_offert] = Product::where('id', '=', $offert[$off->id_offert]->id_product)->first();
            $lines_sing[$off->id_offert] = Products_line::query()->where('id_product','=',$offert[$off->id_offert]->id_product)
                ->where('filter','=','X')->limit(4)->get();
        }


        foreach ($myofferts_bun as $off) {
            $offert[$off->id_offert] = Offert::query()->where('id', '=', $off->id_offert)->first();
            $images[$off->id_offert] = Gallery::where('offert_id', '=', $off->id_offert) ->where('type','=',$tar)
                ->where('position','=',1)
                ->first();
            $relations = Relation_offert_product::where('idoffert', '=', $off->id_offert)->get();
            $a = 0;
            foreach ($relations as $re) {

                $prods[$off->id_offert][$a] = Product::where('id', '=', $re->idproduct)->first();
                $a++;
            }

        }


        return view('site.mycatalog', [
            'offerts' => $offert,
            'singleoff' => $myofferts_sing,
            'bunoff' => $myofferts_bun,
            'imgoff' => $images,
            'prods' => $prods,
            'lines_sing' => $lines_sing
        ]);
    }

    public function exportOfferBundlePdf(Request $request)
    {
        $offerId = \request('offerId');
        $price = 'price_uf';
        if (Auth::check()) {
            $role = auth()->user()->getrole();
            if ($role[0]->id == '2' || $role[0]->id == '3') {
                $price = 'price_co';
            } else {
                $price = 'price_uf';
            }
        }
        $offerSelect = [
            'offerts.id',
            'id_product',
            'descrip' . app()->getLocale() . ' as description',
            $price . ' as price',
            'title',
        ];

        $offert = Offert::query()->select($offerSelect)->where('id', '=', $offerId)->with('product')->first();
        $asoc_prod = Relation_offert_product::where('idoffert', '=', $offert->id)->get();
        $gallery = Gallery::query()->where('offert_id', '=', $offert->id)->get();
        $prod = [];
        $productLines = [];
        $a = 0;

        $productLineSelect = [
            'label_' . app()->getLocale() . ' as label',
            'ans_' . app()->getLocale() . ' as answer',
        ];
        foreach ($asoc_prod as $asc) {
            $prod[$a] = Product::query()->where('id', '=', $asc->idproduct)->first();
            $productLines[$prod[$a]->id] = Products_line::query()->select($productLineSelect)->where('id_product', '=', $prod[$a]->id)->get();
            $a++;
        }

//        return view('site.export-templates.offer-bun-pdf', [
//            'type' => 'Bundle',
//            'offerId' => $offert->id,
//            'offert' => $offert,
//            'gallery' => $gallery,
//            'products' => $prod,
//            'productLines' => $productLines,
//        ]);

        $pdfView = PDF::loadView('site.export-templates.offer-bun-pdf',
            [
                'type' => 'Bundle',
                'offerId' => $offert->id,
                'offert' => $offert,
                'gallery' => $gallery,
                'products' => $prod,
                'productLines' => $productLines,
            ]);
        return $pdfView->stream('brochure.pdf');
    }

    public function exportOfferPdf(Request $request)
    {
        $offerId = \request('offerId');

        $offerWithProduct = $this->offerModel->getOfferWithProduct($offerId);
        $productLines = $this->productsLineModel->getProductLines($offerWithProduct->id_product);
        $gallery = $this->galleryModel->getGallery($offerId);

        $similarOffers = $this->offerModel->getSimilarOffers($offerWithProduct->family, $offerId);

        $mandatoryProductInfo = [
            __('Brand') => $offerWithProduct->brand,
            __('Model') => $offerWithProduct->model,
            __('Year') => $offerWithProduct->year,
            __('Working Hours') => $offerWithProduct->workingHours,
        ];


        $hasProductLines = count($productLines) > 0;
//        return view('site.export-templates.offer-pdf', [
//            'type' => 'Single',
//            'offerId' => $offerId,
//            'offerWithProduct' => $offerWithProduct,
//            'gallery' => $gallery,
//            'mandatoryProductInfo' => $mandatoryProductInfo,
//            'productLines' => $productLines,
//            'hasProductLines' => $hasProductLines,
//            'similarOffers' => $similarOffers,
//        ]);


        $pdfView = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('site.export-templates.offer-pdf', [
            'type' => 'Single',
            'offerId' => $offerId,
            'offerWithProduct' => $offerWithProduct,
            'gallery' => $gallery,
            'mandatoryProductInfo' => $mandatoryProductInfo,
            'productLines' => $productLines,
            'hasProductLines' => $hasProductLines,
            'similarOffers' => $similarOffers,
        ]);

        return $pdfView->stream('brochure.pdf');
    }

    public function exportCatalog(Request $request)
    {
        $user_id = Auth::id();
        $myofferts_sing = Mymachine::query()->where('id_user', '=', $user_id)->where('type', '=', 'Single')->get();
        $myofferts_bun = Mymachine::query()->where('id_user', '=', $user_id)->where('type', '=', 'Bundle')->get();
        $offerts_sing = [];
        $offerts_bun = [];
        $offert = [];
        $images = [];
        $prods = [];

        foreach ($myofferts_sing as $off) {

            $images[$off->id_offert] = Gallery::query()->where('offert_id', '=', $off->id_offert)->first();
            $offert[$off->id_offert] = Offert::query()->where('id', '=', $off->id_offert)->first();
            $prods[$off->id_offert] = Product::where('id', '=', $offert[$off->id_offert]->id_product)->first();
            $prods_lines[$off->id_offert] = Products_line::where('id', '=', $offert[$off->id_offert]->id_product)->get();
        }

        foreach ($myofferts_bun as $off) {
            $offert[$off->id_offert] = Offert::query()->where('id', '=', $off->id_offert)->first();
            $images[$off->id_offert] = Gallery::where('offert_id', '=', $off->id_offert)->first();
            $relations = Relation_offert_product::where('idoffert', '=', $off->id_offert)->get();
            $a = 0;
            foreach ($relations as $re) {

                $prods[$off->id_offert][$a] = Product::where('id', '=', $re->idproduct)->first();
                $prods_lines[$off->id_offert][$prods[$off->id_offert][$a]->id] = Products_line::where('id', '=', $offert[$off->id_offert]->id_product)->get();
                $a++;
            }

        }

        $pdfView = PDF::loadView('site.export-templates.catalog-pdf', [
            'offerts' => $offert,
            'singleoff' => $myofferts_sing,
            'bunoff' => $myofferts_bun,
            'imgoff' => $images,
            'prods' => $prods,
            'prods_lines' => $prods_lines
        ]);


        return $pdfView->stream('catalog.pdf');
    }

    public function allestimenti()
    {
        return view('site.allestimenti');
    }

    public function register()
    {
        return view('site.register');
    }

    public function contatti()
    {
        return view('site.contatti');
    }

    public function richiesta()
    {

        $quotation = Quotation::query()->where('id_user', '=', Auth::id())->get();

        return view('site.richiesta', ['quotations' => $quotation]);
    }

    public function richiediInfo($offerId)
    {

        $offert = Offert::query()->where('id', '=', $offerId)->first();
        $images = '';
        $prods = [];

        if ($offert->type_off == 'single') {
            $images = Gallery::where('offert_id', '=', $offert->id)->first();
            $prods = Product::where('id', '=', $offert->id_product)->first();
        } else {
            $images = Gallery::where('offert_id', '=', $offert->id)->first();
            $relations = Relation_offert_product::where('idoffert', '=', $offert->id)->get();
            $a = 0;
            foreach ($relations as $re) {

                $prods[$a] = Product::where('id', '=', $re->idproduct)->first();
                $a++;
            }
        }


        return view('site.richiedi-info', [
            'prods' => $prods,
            'imgoff' => $images,
            'offert' => $offert,
            'type' => $offert->type_off
        ]);
    }

    public function productsSearch(Request $request)
    {

        $filters = $request->all();

        $offers = $this->offerModel->getOffersWithProduct($filters)->values();

        return response()->json($offers);
    }

    public function options(Request $request)
    {
        $offerId = $request->get('offerId');
        $options = $this->offerModel->getOptions($offerId);


        return response()->json($options);
    }

    public function addOption(Request $request)
    {
        $offerId = $request->get('offerId');
        $cclient = $request->get('cclient');

        if (!$offerId) {
            return response()->json(['message' => 'No offer id provided'])->setStatusCode(400);
        }

        if (!auth()->user()) {
            return response()->json(['message' => 'You must be logged in!'])->setStatusCode(401);
        }

        $resp = $this->offerModel->addOption($offerId,$cclient);

        if ($resp['status'] === false) {
            return response()->json($resp)->setStatusCode(400);
        }

        $options = $this->offerModel->getOptions($offerId);

        return response()->json($options);
    }

    public function doOption()
    {
        $offerId = \request('offerId');
        $optionId = \request('optionId');

//        $offer = $this->offerModel->getOffersWithProduct()->first(function ($offer) use ($offerId) {
//            return $offer->id == $offerId;
//        });

        $offer = Offert::query()->where('id','=',$offerId)->first();

        return view('site.do-option', [
            'offer' => $offer,
            'optionId' => $optionId
        ]);
    }

    public function doOptionPost()
    {
        $file = \request()->file('option-file');
        $optionId = \request()->get('option_id');

        $option = Option::query()->find($optionId);

        $option->status = 3;
        $option->save();
        $path = base_path('public/upload/options/' . $optionId . '.'.$file->getClientOriginalExtension());

        move_uploaded_file($file->getPathname(), $path);
        return redirect()->back()->with('message', __('Questa opzione ti è stata asegnata'));
    }

    public function saveFilters(Request $request)
    {
        if (!auth()->user()) {
            return new Exception('You must be logged in!');
        }

        $savedFilterInfo = $request->all();

        $this->savedFilterModel->saveFilter(auth()->user()->id, $savedFilterInfo);

//        return Exception('not finished yet');
        return redirect()->back()->with('message', __('Questa ricercha  è stata salvata'));
    }

    /**
     * @return \Closure
     */
    private function filterByChosenLanguage(): \Closure
    {
        return function ($qft) {
            if (app()->getLocale() === 'it') {
                return $qft->lang === "I";
            }

            return $qft->lang === "E";
        };
    }

    public function myfilters()
    {
        $group = [];
        $groups = [];
        $group_lines = [];
        $group = Savedfilter::where('id_user', '=', Auth::id())->get();
        if(count($group) == 0){
            return view('site.myfilters', ['stat' => 0,'group'=>null]);
        }
        $savedFiltersRequest = [];

             $famSelectCodFam = Fam_select::query()->where('option_it', $group->first()->name)->get()->take(1)->toArray();
            $filterId = Buttons_filter::query()->find($famSelectCodFam[0]['button_id'])->id;

            foreach ($group as $g) {
                $groups[$g->id] = $g;
                $group_lines[$g->id] = Savedfilters_line::where('saved_id', '=', $g->id)->get();
            }



            foreach ($group_lines as $index => $group_line) {
                $savedFiltersRequest[$index]['cod_fam'] = $famSelectCodFam[0]['cod_fam'];
                foreach ($group_line as $line) {
                    if (str_contains($line->ans, ';')) {
                        $ansRange = explode(';', $line->ans);
                        $savedFiltersRequest[$index][$line->cod_question . '_start'] = trim($ansRange[0], '[]');
                        $savedFiltersRequest[$index][$line->cod_question . '_end'] = trim($ansRange[1], '[]');
                    } else if ($line->cod_question === 'model') {
                        $savedFiltersRequest[$index][$line->cod_question] = $line->ans;
                    } else {
                        $savedFiltersRequest[$index][$line->cod_question][] = $line->ans;
                    }
                }

                $savedFiltersRequest[$index] = http_build_query($savedFiltersRequest[$index]);
                $savedFiltersRequest[$index] = preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '%5B%5D=', $savedFiltersRequest[$index]);
            }



        return view('site.myfilters', ['stat'=>1,'group' => $groups, 'group_lines' => $group_lines, 'savedFiltersRequest' => $savedFiltersRequest, 'filterId' => $filterId]);
    }

    public function checkquotation()
    {

        $data = Quotation::query()->where('id', '=', \request('quotation_id'))->first();
        $data_lines = Quotation_line::query()->where('id_quotation', '=', $data->id)->get();
        $prods = [];
        $imag = [];
        $offerts = [];
        $rela = [];
        foreach ($data_lines as $line) {
            $offert = Offert::query()->where('id', '=', $line->id_offert)->first();
            $offerts[$line->id] = $offert;
            if ($offert->type == 'Single') {
                $prods[$offert->id] = Product::where('id', '=', $offert->product_id)->first();
                $imag[$offert->id] = Gallery::where('offer_id', '=', $offert->id)->first();
            } else {
                $rela = Relation_offert_product::where('idoffert', '=', $offert->id)->get();
                $a = 0;

                foreach ($rela as $re) {
                    $prods[$offert->id] = Product::where('id', '=', $re->idproduct)->first();
                    $imag[$offert->id] = Gallery::where('offert_id', '=', $offert->id)->first();
                    $a++;
                }
            }

        }

        return view('site.quotation-normal', [
            'lines' => $data_lines,
            'offerts' => $offerts,
            'prods' => $prods,
            'image' => $imag,
            'title' => $data->title,
            'text' => $data->text,

        ]);
    }


    public function changelist()
    {

        if(Session::has('list')){
             $list = Session::get('list');

             if($list == 1){
                 $list = 2;
                 session(['list' => $list]);
                 //Session::put('list', $list);
             }else{
                 $list = 1;
                 session(['list' => $list]);
                 // Session::put('list', $list);
             }

        }else{
            $list = 1;
            session(['list' => $list]);
//            Session::set('list', $list);
        }


        return redirect()->back();

    }

    public function searchclient()
    {
        if(\request('cod_cli') != ''){ $cod_cli = \request('cod_cli'); }else{ $cod_cli = ''; }
        if(\request('rag_cli') != ''){ $rag_cli = \request('rag_cli'); }else{ $rag_cli = ''; }
        if(\request('piva_cli') != ''){ $piva_cli= \request('piva_cli'); }else{ $piva_cli= ''; }

        if(\request('rag_cli') != '*'){
            $config = [ 'ashost' => config('main.sap_host'), 'sysnr'  => config('main.sap_sysnr'), 'client' => config('main.sap_client'), 'user' => config('main.sap_user'), 'passwd' => config('main.sap_pass'), ];

            try {
                $c = new SapConnection($config);
                $badge = '0295';
                $f = $c->getFunction('ZCLS_BEST_PRICE_CLIENTI_RFC');
                $result = $f->invoke([
                    'IV_PIVA'=>"$piva_cli",
                    'IV_CODICE' => "$cod_cli",
                    'IV_RAGSOCIALE' => "$rag_cli",
                ],['rtrim' => true]);

                if(count($result['TT_CLIENTI']) > 0){

                    $data['success'] = 'OK';
                    $data['list'] = $result['TT_CLIENTI'];

//                    $data = [
//                        'success' => 'OK',
//                        'list' => $result['TT_CLIENTI']
//                    ];
                    return $data;
                }else{
                    $data['success'] = 'error';
                    $data['mes'] = 'Not found';


                    return $data;
                }



            } catch(SapException $ex) {

                $data['success'] = 'error';
                $data['mes'] = $ex;



                return $data;
            }
        }else{
            $data['success'] = 'error';
            $data['mes'] = 'Not found';


            return $data;
        }


    }
}

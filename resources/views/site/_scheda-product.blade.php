<!DOCTYPE html>
<html lang="en">
@section('title', __('Product detail'))
@include('site.partiales._pagehead')
<link href="{{ asset('css/tiny-slider/tiny-slider.css') }}" rel="stylesheet">
<body>



@include('site.partiales._header')

<div class="container my-40 px-15 md_px-0">
    <ul class="flex flex-wrap breadcrumb mb-40">
        <li><a href="">Home</a></li>
        <li><a href="">Prodotti per {{$offerWithProduct->familyLabel}}</a></li>
    </ul>

    <div class="flex flex-wrap">
        <div class="md_col-5" style="{{!isset($gallery[0]) ? "min-height: 65px;width: 100%" : ""}}">
            <div class="mb-5 md_mb-20 relative">
                <a href="" class="product-tag absolute top-0 z-10" style="background-color: #1a9910;border: 3px solid #1a9910; color: white">{{$offerWithProduct->title_1}}</a>
                @if($offerWithProduct->title_2 != null || $offerWithProduct->title_2 != "")
                <a href="" class="product-tag absolute top-50 z-10" style="background-color: white;border: 3px solid black;">{{$offerWithProduct->title_2}}</a>
                @endif
                @if($offerWithProduct->title_3 != null || $offerWithProduct->title_3 != "")
                <a href="" class="product-tag absolute top-100 z-10" style="background-color: red; border: 3px solid red; color: white">{{$offerWithProduct->title_3}}</a>
                @endif
                <div id="offer-gallery">
                    @foreach($gallery as $image)
                        <img src="{{ url('upload/' . $image->name) }}" alt="">
                    @endforeach
                </div>
            </div>
            <div class="flex row-5 md_row-15" id="offer-gallery-thumbnails">
                @foreach($gallery as $image)
                    <div class="col-4 px-5 md_px-15">
                    <img style="width: 100px;
height: 100px;" src="{{ url('upload/' . $image->name) }}" alt="">
                    </div>
                @endforeach
            </div>
        </div>
        <div class="md_pl-20 md_col-4 mt-20 md_mt-0">
            <span class="text-secondary weight-500 font-18">{{$offerWithProduct->type}}</span>
            <h2 class="mt-10 font-35 weight-500">{{$offerWithProduct->model}}</h2>
            <ul class="product-info mt-25">
                <li>{{__('MyUsato Code')}}: <span>{{$offerWithProduct->myUsatoCode}}</span></li>
                <li>{{__('Brand')}}: <span>{{$offerWithProduct->brand}}</span></li>
                @if(Auth::check())
                <li>{{__('Price')}}: <span> {{  $offerWithProduct->price }} €</span></li>
                @endif
                <li>{{__('Availability')}}: <span>Pronto</span></li>
            </ul>
            <p class="weight-500 my-25 line-height-1-4">{{$offerWithProduct->description}}</p>
            <br /><br />
            @if(!Auth::check())
            <a href="http://login.cls.it/login?sso={{  config('session.sso_token')  }}" class="button">Vedi prezzo</a>
            @endif
            <br /><br />
            <a style="width: 100%;" target="_blank" href="{{route('export-offer-pdf', ['offerId' => $offerId])}}" class="button w-auto px-25">{{__('Brochure')}}</a>
        </div>
        <div class="md_col-3 md_pl-40 mt-50 md_mt-0">
            @include('site.partiales._buttons_actions_sche')
        </div>
    </div>

    <div class="tech-details pt-40 mt-40">
        <Center><h3 style="display: block; font-size: 241%; font-weight: 500;">{{__('Specifications')}}</h3></Center>
        <div class="flex flex-wrap mt-40">
            <div class="md_col-12 col-12" style="margin-bottom: 2%">
                <h2 class="section-title">
                    @foreach($mandatoryProductInfo as $label => $productInfo)
                   {{$productInfo}}
                    @endforeach
                </h2>
            </div>
            <div class="md_col-6 col-12 mt-30 md_mt-0" style="margin-bottom: 2%">
            @if ($hasProductLines)
                <ul class="mx-auto md_col-10 col-12">
                    @foreach($productLines as $productLine)
                        @if($num_lines <= 0)
                            @php $num_lines = $cop_num_lines; @endphp
                        </ul>
                    </div>
                    <div class="md_col-6 col-12 mt-30 md_mt-0" style="margin-bottom: 2%">
                        <ul class="mx-auto md_col-10 col-12">

                        @endif
                        <li>
                            <div class="label" style="width: 50%">{{$productLine->label}}</div>
                            <span>{{$productLine->answer}}</span>
                        </li>
                            @php $num_lines = $num_lines -1; @endphp
                    @endforeach
                 </ul>
            @endif
            </div>
        </div>
    </div>

{{--    Prodotti simili--}}
    @if(count($similarOffers) > 0)
    <div class="new-ads border-top pt-50 mt-50">
        <h2 class="section-title">{{__('Similar Products')}}</h2>
        <div class="row-15 flex flex-wrap my-40">

            @foreach($similarOffers as $similarOffer)
            <div class="md_col-3 col-12 px-15 mt-40 md_mt-40">
                <div class="ad-box-products">
                    <div class="ad-image">
                        <div class="ad-tags absolute top-10 left-0 z-10">
                            <div class="tag-1">
                                <span>{{$similarOffer->title}}</span>
                            </div>
                        </div>
                        @if ($similarOffer->isInCatalog === true)
                            <a data-offer-id="{{$similarOffer->id}}" data-type="{{$similarOffer->type}}" href="{{ Auth::check() ? route('deletemycatalog', ['idoffert' => $similarOffer->id]) : "http://login.cls.it/login?sso=".config('session.sso_token') }}" class="ad-add absolute top-10 right-10 z-10">
                                <i class="material-icons font-30">{{Auth::check() ? 'delete' : 'lock'}}</i>
                            </a>
                        @else
                            <a data-offer-id="{{$similarOffer->id}}" data-type="{{$similarOffer->type}}" href="{{ Auth::check() ? route('addtomycatalog', ['id_offert' => $similarOffer->id, 'type' => $similarOffer->type]) : "http://login.cls.it/login?sso=".config('session.sso_token') }}" class="ad-add absolute top-10 right-10 z-10">
                                <i class="material-icons font-30">{{Auth::check() ? 'add' : 'lock'}}</i>
                            </a>
                        @endif
                        <img src="{{ asset('site/images/example.jpg') }}" alt="">
                    </div>
                    <div class="ad-titles">
                        @if ($similarOffer->type === 'Bundle')
                            <table class="off-table">
                                <thead>
                                <tr>
                                    <th class="p-15">Marca</th>
                                    <th class="p-15">Modello</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($similarOffer->bundleProducts as $product )

                                    <tr>
                                        <td> {{$product->brand}}</td>
                                        <td> {{$product->model}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            @else
                        <ul class="text-primary bc-secondary p-15">
                            <li class="flex justify-between align-center mb-15">
                                <span class="weight-400">Tipologia:</span>
                                <span class="font-18">{{$similarOffer->productType}}</span>
                            </li>
                            <li class="flex justify-between align-center mb-15">
                                <span class="weight-400">Marca:</span>
                                <span class="font-18">{{$similarOffer->brand}}</span>
                            </li>
                            <li class="flex justify-between align-center">
                                <span class="weight-400">Modello:</span>
                                <span class="font-18">{{$similarOffer->model}}</span>
                            </li>
                        </ul>
                            @endif
                    </div>
                    <div class="ad-info">
                        @if ($similarOffer->type === 'Bundle')
                            <a href="{{ route('product-bun-detail', ['id_offert' => $similarOffer->id]) }}" class="button">Scopri di più</a>
                        @else
                        <ul>
                            <li class="flex justify-between mb-12">
                                <span class="weight-400">Portata:</span>
                                <span>800</span>
                            </li>
                            <li class="flex justify-between mb-12">
                                <span class="weight-400">Montante:</span>
                                <span>2 Stadi NO A.I.</span>
                            </li>
                            <li class="flex justify-between mb-12">
                                <span class="weight-400">Sollevamento:</span>
                                <span>4000</span>
                            </li>
                            <li class="flex justify-between mb-12">
                                <span class="weight-400">Anno:</span>
                                <span>{{$similarOffer->year}}</span>
                            </li>
                            <li class="flex justify-between mb-13">
                                <span class="weight-400">Allestimento:</span>
                                <span class="uppercase">Easy</span>
                            </li>
                            <li class="flex justify-between mb-13">
                                <span class="weight-400">Stato alle:</span>
                                <span class="uppercase">Da preparare</span>
                            </li>
                        </ul>
                        <a href="{{route('product-detail', ['id_offert' => $similarOffer->id])}}" class="button">Scopri di più</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center">
            <a href="" class="button w-auto px-50">Mostra tutti</a>
            <br>
            <i class="material-icons font-50">expand_more</i>
        </div>
    </div>
        @endif
    @include('site.partiales._richiedi-info')

    </div>
@include('site.partiales._contactform')

@include('site.partiales._footer')
<script type="text/javascript" src="{{ asset('js/tiny-slider/tiny-slider.js') }}"></script>
<script>
    var btnMenu = document.getElementById("btnMenu");
    var menuMob = document.getElementById("menuMob");
    var closeMenu = document.getElementById("closeMenu");

    btnMenu.addEventListener("click", function () {
        menuMob.classList.add("menuOpen");
    });

    closeMenu.addEventListener("click", function () {
        menuMob.classList.remove("menuOpen");
    });

    var scrollToTopBtn = document.getElementById("scrollToTopBtn");
    var rootElement = document.documentElement;

    function scrollToTop() {
        rootElement.scrollTo({
            top: 0,
            behavior: "smooth"
        })
    }
    scrollToTopBtn.addEventListener("click", scrollToTop);

    // Slider
    document.addEventListener('DOMContentLoaded', () => {
        const gallerySlider = tns({
            container: "#offer-gallery",
            controls: false,
            items: 1,
            navContainer: "#offer-gallery-thumbnails",
            navAsThumbnails: true,
        });
    });
</script>


</body>

</html>

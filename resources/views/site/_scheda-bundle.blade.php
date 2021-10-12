<!DOCTYPE html>
<html lang="en">
@section('tilte', __('Offer detail'))
@include('site.partiales._pagehead')
<link href="{{ asset('css/tiny-slider/tiny-slider.css') }}" rel="stylesheet">
<body>



@include('site.partiales._header')

<div class="container my-40 px-15 md_px-0">
    <ul class="flex flex-wrap breadcrumb mb-40">
        <li><a href="">Home</a></li>
        <li><a href="">Prodotti per  </a></li>
    </ul>

    <div class="flex flex-wrap">
        <div class="md_col-5" style="{{!isset($gallery[0]) ? "min-height: 65px;width: 100%" : ""}}">
            <div class="mb-5 md_mb-20 relative">
                <a href="" class="product-tag absolute top-20 z-10">{{$offert->title}}</a>
                <div id="offer-gallery">
                    @foreach($gallery as $image)
                        <img src="{{ url('upload/' . $image->name) }}" alt="">
                    @endforeach
                </div>
            </div>
            <div class="flex row-5 md_row-15" id="offer-gallery-thumbnails">
                @foreach($gallery as $image)
                    <div class="col-4 px-5 md_px-15">
                        <img src="{{ url('upload/' . $image->name) }}" alt="">
                    </div>
                @endforeach
            </div>
        </div>
        <div class="md_pl-20 md_col-4 mt-20 md_mt-0">
            <span class="text-secondary weight-500 font-18"> </span>
            <h2 class="mt-10 font-35 weight-500"> {{ $offert->title }}</h2>
            <h2 class="mt-10 font-35 weight-500" style="font-size: 21px;">
                @foreach($products as $product)
                    {{ $product->brand }} {{ $product->model }} <BR>
                @endforeach
            </h2>
            @if(Auth::check())
            <ul class="product-info mt-25">

                <li>{{__('Price')}}: <span>{{  $offert->price }} € </span></li>
            </ul>
            @endif
            <p class="weight-500 my-25 line-height-1-4">{{$offert->description}}</p>
            <br /><br>
            @if(!Auth::check())
                <a href="http://login.cls.it/login?sso={{  config('session.sso_token')  }}" class="button">Vedi prezzo</a>
           @endif
            <BR><BR>
            <!-- href="#route('export-offer-bun-pdf', ['offerId' => $offerId]) " -->
            <a style="width: 100%" target="_blank" class="button w-auto px-25">{{__('Brochure')}}</a>
        </div>
        <div class="md_col-3 md_pl-40 mt-50 md_mt-0">
            @include('site.partiales._buttons_actions_sche')

        </div>

    </div>

    <div class="tech-details pt-40 mt-40">
        <h2 class="section-title">{{__('Technical Specifications')}}  </h2>
        <BR>
        @foreach($products as $product)
            <div class="mt-40"></div>
            <h2 class="section-title" style="font-size: 21px; margin-top: 2%">{{  $product->brand  }} {{  $product->model  }}</h2>
            <BR> <BR>
        <div class="flex flex-wrap mt-20">


            <div class="md_col-6 col-12">
                <ul class="mx-auto md_col-10 col-12">
                    <li>
                        <div class="label"> {{ __('Brand') }} </div><span>{{$product->brand}}</span>
                    </li>
                    <li>
                        <div class="label"> {{ __('Model') }} </div><span>{{$product->model}}</span>
                    </li>
                    <li>
                        <div class="label"> {{ __('Year') }} </div><span>{{$product->year}}</span>
                    </li>
                    <li>
                        <div class="label"> {{ __('Working Hours') }} </div><span>{{$product->orelavoro}}</span>
                    </li>
                </ul>
            </div>

                <div class="md_col-6 col-12" style="margin-top: 2%">
                    <ul class="mx-auto md_col-10 col-12 mt-30 md_mt-0">
                        @foreach($productlines[$product->id] as $line)
                            @if($line != NULL)
                                <li>
                                    <div class="label"> {{ $line->label }} </div><span>{{ $line->answer }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

        </div>
        @endforeach
    </div>


    {{--    Prodotti simili--}}
    @if(count($similarOffers) > 0)
    <div class="new-ads border-top pt-50 mt-50">
        <h2 class="section-title">{{__('Similar Products')}}</h2>
        <div class="row-15 flex flex-wrap my-40">

            @foreach($similarOffers as $similarOffer)
                <div class="md_col-3 col-12 px-15 mt-40 md_mt-0">
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
</div></div>
@include('site.partiales._richiedi-info');

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

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Document</title>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,700&display=swap"
    rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('site/css/main.min.css') }}">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link href="{{ asset('css/tiny-slider/tiny-slider.css') }}" rel="stylesheet">
<style>
    table .label {
        background-color: #ffcb0f;
    }

    table, th, td, tr {
        border: none;
    }

    table td {
        padding: 10px;
        text-align: center;
    }

    table td:nth-child(2n) {
        text-align: left !important;
    }
</style>
<body>
<div class="container my-40 px-15 md_px-0">
    <div class="row">
        <div class="col-md-5" style="{{!isset($gallery[0]) ? "min-height: 65px;width: 100%" : ""}}">
            <div class="mb-5 md_mb-20 relative">
                <div id="offer-gallery">
                    <img src="{{ url('upload/' . $gallery[0]->name) }}" alt="">
                </div>
            </div>
        </div>
        <div class="md_pl-20 col-md-4 mt-20 md_mt-0">
            <span class="text-secondary weight-500 font-18"> </span>
            <h2 class="mt-10 font-35 weight-500"> {{ $offert->title }}</h2>
            <h2 class="mt-10 font-35 weight-500" style="font-size: 21px;">
                @foreach($products as $product)
                    {{ $product->brand }} {{ $product->model }} <BR>
                @endforeach
            </h2>
            <ul class="product-info mt-25">

                <li>{{__('Price')}}: <span>{{$offert->price_uf}} € </span></li>
            </ul>
            <p class="weight-500 my-25 line-height-1-4">{{$offert->description}}</p>
        </div>
    </div>
    <div class="tech-details pt-40 mt-40">
        <h2 class="section-title">{{__('Technical Specifications')}}  </h2>
        <BR>
            @foreach($products as $product)
                <h2 class="section-title"
                    style="font-size: 21px; margin-top: 2%">{{  $product->brand  }} {{  $product->model  }}</h2>
                <BR> <BR>
                        <div class="row">


                            <div class="col-md-6">
                                <table cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="label"> {{ __('Brand') }} </td>
                                        <td>{{$product->brand}}</td>
                                    </tr>
                                    <tr>
                                        <td class="label"> {{ __('Model') }} </td>
                                        <td>{{$product->model}}</td>
                                    </tr>
                                    <tr>
                                        <td class="label"> {{ __('Year') }} </td>
                                        <td>{{$product->year}}</td>
                                    </tr>
                                    <tr>
                                        <td class="label"> {{ __('Working Hours') }} </td>
                                        <td>{{$product->orelavoro}}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6" style="margin-top: 2%">
                                <table cellspacing="0" cellpadding="0">
                                    @foreach($productlines[$product->id] as $line)
                                        @if($line != NULL)
                                            <tr>
                                                <td class="label"> {{ $line->label }} </td>
                                                <td>{{ $line->answer }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </div>

                        </div>
        @endforeach
    </div>
</div>
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

<!DOCTYPE html>
<html lang="en">
@section('title', __('All offers'))
@include('site.partiales._pagehead')

<body>

<!-- Header -->

@include('site.partiales._header')

<div class="cls-allestimenti-banner">
    <img src="https://myusato.cls.it/site/images/bundles.JPG" style="background-color: rgba(0,0,0,0.8); max-width: 100%;filter: brightness(0.4);">
    <h1 style="color: white;font-weight: 500;"> Un'offerta personalizzata per ogni esigenze!</h1>
</div>



<div class="container px-15 md_px-0">


    <div class="offers pt-50">
        <h2 class="section-title">{{ __(' Un\'offerta personalizzata per ogni esigenze!  ')  }}</h2>
        <div class="row-15 flex flex-wrap my-40">
            @foreach($bunoff as $off)
                <div class="md_col-3 col-12 px-15">
                    <div class="off-box">
                        <div class="off-image">
                            <img src="https://myusato.cls.it/upload/{{$imgoff[$off->id]->name}}"  alt="">
                        </div>
                        <div class="off-titles px-15 pt-5">
                            <span class="block font-30 mb-5">{{$off->price_uf}} €</span>
                            <!--  <p class="font-14 weight-500">Prezzo consigliato: <span class="strike">1081,99 €</span> (-28%)</p> -->
                            <!--<div class="off-bar"></div>
                            <p class="mt-5 text-right">Mancano 11:03:10</p> -->
                            <a href="{{ route('product-bun-detail', ['id_offert' => $off->id ]) }}" class="button">Scopri di più</a>
                        </div>
                        <table class="off-table mt-10">
                            <thead>
                            <tr>
                                <th>Marca</th>
                                <th>Modello</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($prods[$off->id] as $prod )

                                <tr>
                                    <td> {{$prod->brand}}</td>
                                    <td> {{$prod->model}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

    </div>







</div>


@include('site.partiales._contactform')
<!-- Altre società del gruppo -->

@include('site.partiales._group')
<!-- Footer -->
@include('site.partiales._footer')

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
</script>
</body>

</html>

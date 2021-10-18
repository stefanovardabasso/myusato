<!DOCTYPE html>
<html lang="en">
@section('title', __('Form quotation'))
@include('site.partiales._pagehead')

<body>

<!-- Header -->

@include('site.partiales._header')


<section>
    <div class="cls-allestimenti-banner">
        <img src="https://via.placeholder.com/1980x1080">
        <h1>{{__('Richiesta di quotazione ')}}</h1>
    </div>
</section>
@if(session()->has('message'))
    <center>
        <div class="alert alert-success" style="color: white;
    background-color: #07ff03;
    border-color: #15ff05;
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-top-color: transparent;
    border-right-color: transparent;
    border-bottom-color: transparent;
    border-left-color: transparent;
    border-radius: 4px;">
            {{ session()->get('message') }}
        </div>
    </center>
@endif

<div class="container px-15 md_px-0" style="margin-bottom: 10%; margin-top: 5%">
    <h2>{{__('Prodotti selezionati')}}</h2>
    @if($singleoff == NULL & $bunoff == NULL)
        <center style="margin-top: 5%; margin-bottom: 25%"><h3
                class="section-title">{{ __('Al momento non hai nessuna macchina a catalogo')  }}</h3></center>
    @endif
    <div class="new-ads mb-30">
        <div class="row-15 flex flex-wrap my-40 justify-center" style="margin-top: 5%; margin-bottom: 5%">
            @foreach($singleoff as $off)

                <div class="md_col-3 col-12 px-15 mb-30">
                    <div class="ad-box-products">
                        <div class="ad-image">
                            <div class="ad-tags absolute top-10 left-0 z-10">
                                <div class="tag-1">
                                    <span>{{$offerts[$off->id_offert]->title}}</span>
                                </div>
                            </div>
                            <a data-offer-id="{{$off->id_offert}}" href="{{ route('deletemycatalog',['idoffert' => $off->id_offert]) }}"
                               class="ad-add absolute top-10 right-10 z-10">
                                <i class="material-icons font-30">delete</i>
                            </a>
                            <img src="https://myusato.cls.it/upload/{{$imgoff[$off->id_offert]->name}}" alt="">
                        </div>

                        <div class="ad-titles">
                            <ul class="text-primary bc-secondary p-15">
                                <!-- <li class="flex justify-between align-center mb-15">
                                     <span class="weight-400">Tipologia:</span>
                                     <span class="font-18">Fontale elettrico</span>
                                 </li> -->
                                <li class="flex justify-between align-center mb-15">
                                    <span class="weight-400">Marca:</span>
                                    <span class="font-18">{{ $prods[ $off->id_offert]->brand }}</span>
                                </li>
                                <li class="flex justify-between align-center">
                                    <span class="weight-400">Modello:</span>
                                    <span class="font-18">{{ $prods[$off->id_offert]->model }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="ad-info">
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
                                    <span>{{ $prods[$off->id_offert]->year }}</span>
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
                            <a href="{{ route('product-detail', ['id_offert' => $off->id_offert ]) }}" class="button">Scopri
                                di più</a>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
    <div class="offers pt-50">
        <div class="row-15 flex flex-wrap my-40 justify-center ">
            @foreach($bunoff as $off)

                <div class="md_col-3 col-12 px-15">
                    <div class="off-box">
                        <div class="off-image">
                            <img src="https://myusato.cls.it/upload/{{$imgoff[$off->id_offert]->name}}" alt="">
                            <a href="{{ route('deletemycatalog',['idoffert' => $off->id_offert]) }}"
                               class="ad-add absolute top-10 right-10 z-10">
                                <i class="material-icons font-30">delete</i>
                            </a>
                        </div>
                        <div class="off-titles px-15 pt-5">
                            <span class="block font-30 mb-5">{{$offerts[$off->id_offert]->price_uf}}  €</span>
                            <!--  <p class="font-14 weight-500">Prezzo consigliato: <span class="strike">1081,99 €</span> (-28%)</p> -->
                            <!--<div class="off-bar"></div>
                            <p class="mt-5 text-right">Mancano 11:03:10</p> -->
                            <a href="{{ route('product-bun-detail', ['id_offert' => $off->id_offert ]) }}"
                               class="button">Scopri di più</a>
                        </div>
                        <table class="off-table mt-10">
                            <thead>
                            <tr>
                                <th>Marca</th>
                                <th>Modello</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($prods[$off->id_offert] as $prod )
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

    <form class="valuta-form" method="POST" action="{{route('addtoquotationven')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <input type="text" name="email" class="input mb-10 weight-500"
               placeholder="{{ __('Email') }}" required="" style="border: 1px solid;">
        <input type="text" name="ragsociale" class="input mb-10 weight-500"
               placeholder="{{ __('Rag sociale') }}" required="" style="border: 1px solid;">
        <input type="text" name="title" class="input mb-10 weight-500"
               placeholder="{{ __('Titolo') }}" required="" style="border: 1px solid;">
        <textarea class="textarea weight-500 mb-10" name="message" id="" cols="30" rows="14"
                  placeholder="{{__('Testo')}}" required=""
                  style="border: 1px solid;"></textarea>
        <div class="flex justify-center mb-15">
            <table style="width: 380px" class="cls-table" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th>{{__('Prodotti')}}</th>
                    <th>{{__('Prezzo')}}</th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <td style="width: 70%">
                        <strong><em>{{__('Totale')}}</em></strong>
                    </td>
                    <td style="width: 50%">
                        <span class="input-euro right"><input style="width: 100px; font-weight: bold; font-style: italic" required class="no-border" name="price_"></span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="flex flex-wrap justify-center align-center">
            <button type="submit" class="btn btn-primary">{{__('Invia')}}</button>
        </div>

    </form>

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
    //
    // $('.cls-table input.price-field').on('input',() => {
    //     console.log('change');
    //    calctotal();
    // });

    scrollToTopBtn.addEventListener("click", scrollToTop);

    function calctotal() {
        let total = 0;

        $('.cls-table input.price-field').each(function(el) {
            if ($(this).val()){
                total+=Number($(this).val());
            }
        });
        console.log(total);
        $('.cls-table input[name="price_total"]').val(total)
    }
</script>
</body>

</html>

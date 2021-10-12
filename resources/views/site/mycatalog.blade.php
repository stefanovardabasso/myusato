<!DOCTYPE html>
<html lang="en">
@section('title', __('My catalog'))
@include('site.partiales._pagehead')

<body>

<!-- Header -->

@include('site.partiales._header')


    <div class="cls-allestimenti-banner">
        <img src="https://myusato.cls.it/site/images/headermycatalog.jpg" style="background-color: rgba(0,0,0,0.8); max-width: 100%;filter: brightness(0.4);">
        <h1 style="color: white;font-weight: 500;"> Un'ampia gamma di soluzioni multimarca.</h1>
    </div>

@if(session()->has('message'))
    <center> <div class="alert alert-success" style="color: white;
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
@if(count($singleoff) == 0 & count($bunoff) == 0)
    <center style="margin-top: 5%; margin-bottom: 25%"><h3 class="section-title">{{ __('Al momento non hai nessuna macchina a catalogo')  }}</h3></center>
@else

    @if(count($singleoff) > 0)
<div class="container px-15 md_px-0">
    <h2 class="section-title">Offerte</h2>


         <div class="new-ads">
         <div class="row-15 flex flex-wrap mt-40">
         @foreach($singleoff as $off)

             <div class="md_col-3 col-12 px-15 mb-30">
                 <div class="ad-box-products">
                     <div class="ad-image">
                         <div class="ad-tags absolute top-10 left-0 z-10">
{{--                             <div class="tag-1">--}}
{{--                                 <span>{{$offerts[$off->id_offert]->title}}</span>--}}
{{--                             </div>--}}
                         </div>
                           <a data-offer-id="{{$off->id_offert}}" href="{{ route('deletemycatalog',['idoffert' => $off->id_offert]) }}" class="ad-add absolute top-10 right-10 z-10">
                               <i class="material-icons font-30">delete</i>
                           </a>
                         <img src={{ url('upload/' . $imgoff[$off->id_offert]->name)}}  alt="">
                     </div>
                     <div class="ad-titles">
                         <ul class="text-primary bc-secondary p-15">
                             <li class="flex justify-between align-center mb-15">
                                 <span class="font-18">{{ $prods[$off->id_offert]->brand }}</span>  - <span class="font-18">{{ $prods[$off->id_offert]->model }}</span> - <span class="font-18">{{ $prods[$off->id_offert]->partita }}</span>
                             </li>
                         </ul>
                     </div>

                     <div class="ad-info">
                         <ul>
                           @foreach($lines_sing[$off->id_offert] as $line)
                             <li class="flex justify-between mb-12">
                                 <span class="weight-400">{{ $line->label_it }}:</span>
                                 <span>{{ $line->ans_it }}</span>
                             </li>
                             @endforeach
                         </ul>
                         <a href="{{ route('product-detail', ['id_offert' => $off->id_offert ]) }}" class="button">Scopri di più</a>
                     </div>
                 </div>
             </div>

         @endforeach
</div>

         </div>
    @endif

    @if(count($bunoff) > 0)
        <div class="container px-15 md_px-0" style="margin-bottom: 10%; margin-top: 5%">
         <div class="offers pt-50" style="border: transparent">

             <h2 class="section-title">Offerte Bundle</h2>
             <div class="row-15 flex flex-wrap my-40 ">
         @foreach($bunoff as $off)

             <div class="md_col-3 col-12 px-15">
                 <div class="off-box">
                     <div class="off-image">
                         <img src="https://myusato.cls.it/upload/{{$imgoff[$off->id_offert]->name}}"  alt="">
                         <a data-offer-id="{{$off->id_offert}}" href="{{ route('deletemycatalog',['idoffert' => $off->id_offert]) }}" class="ad-add absolute top-10 right-10 z-10">
                             <i class="material-icons font-30">delete</i>
                         </a>
                     </div>
                     <div class="off-titles px-15 pt-5">
                         <span class="block font-30 mb-5">{{$off->getPriceByRole($off->id_offert)}}  €</span>
                         <!--  <p class="font-14 weight-500">Prezzo consigliato: <span class="strike">1081,99 €</span> (-28%)</p> -->
                         <!--<div class="off-bar"></div>
                         <p class="mt-5 text-right">Mancano 11:03:10</p> -->
                         <a href="{{ route('product-bun-detail', ['id_offert' => $off->id_offert ]) }}" class="button">Scopri di più</a>
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
@endif
             </div>
         </div>
        </div>
    <div class="container offers" style="border-top: 0px solid rgba(0, 0, 0, 0.15); ">

        <div class="row-15 flex flex-wrap my-40 ">
            <?php

            $role = auth()->user()->getrole();
            if( $role[0]->id == 2){ ?>
            <div class="md_col-3 col-12 px-15">
                <a href="{{route('formquotationven')}}" class="button mb-15"><i class="material-icons mr-5">request_quote</i> {{__('Quotare')}}
                </a>
            </div>
            <?php }else{ ?>
            <div class="md_col-3 col-12 px-15">
                <a href="{{route('formquotation')}}" class="button mb-15"><i
                        class="material-icons mr-5">request_quote</i> {{__('Richiedi quotazione')}}</a>
            </div>
            <?php } ?>
            <div class="md_col-3 col-12 px-15">
                <a href="{{route('export-catalog-pdf')}}" class="button mb-15"><i class="material-icons mr-5">picture_as_pdf</i> {{__('Scarica PDF')}}
                </a>
            </div>
        </div>
    </div>

</div>
@endif


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

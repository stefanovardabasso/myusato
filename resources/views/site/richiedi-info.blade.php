<!DOCTYPE html>
<html lang="en">

@section('title', __('Richiedi info'))
@include('site.partiales._pagehead')

<body>

<!-- Header -->

@include('site.partiales._header')
{{--TODO: Fix names of forms!--}}
<section>
    <div class="cls-allestimenti-banner">
        <img src="https://via.placeholder.com/1980x1080">
        <h1>{{__('RICHIEDI INFO')}}</h1>
    </div>
</section>
<div class="container px-15 md_px-0">

    <section>
        <div class="new-ads mb-30" style="margin-top: 5%">
            <center><h3 class>{{ __('INSERISCI I DETTAGLI')}}</h3></center>
            <div class="row-15 flex flex-wrap my-40">
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
                    @if($type == 'Bundle')
                        <script>setTimeout(function(){ window.location.href = '{{ route('product-bun-detail',['id_offert'=> $offert->id]) }}'; }, 3000);</script>
                    @else
                        <script>setTimeout(function(){ window.location.href = '{{ route('product-detail',['id_offert'=> $offert->id]) }}'; }, 3000);</script>
                    @endif

                @endif

                @if($type == 'Bundle')
                        <div class="offers pt-50">
                        <div class="row-15 flex flex-wrap my-40">
                            <div class="md_col-3 col-12 px-15" style="display: block; margin-left: auto; margin-right: auto;">
                                <div class="off-box">
                                    <div class="off-image">
                                        <img style="width: 1368px" src="http://myusato.cls.it/upload/{{$imgoff->name}}"  alt="">

                                    </div>
                                    <div class="off-titles px-15 pt-5">
                                        <span class="block font-30 mb-5">{{$offert->price_uf}} €</span>
                                        <!--  <p class="font-14 weight-500">Prezzo consigliato: <span class="strike">1081,99 €</span> (-28%)</p> -->
                                        <!--<div class="off-bar"></div>
                                        <p class="mt-5 text-right">Mancano 11:03:10</p> -->
                                    </div>
                                    <table class="off-table mt-10">
                                        <thead>
                                        <tr>
                                            <th>Marca</th>
                                            <th>Modello</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($prods as $prod )

                                            <tr>
                                                <td> {{$prod->brand}}</td>
                                                <td> {{$prod->model}}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else


                                <div class="md_col-3 col-12 px-15" style="display: block; margin-left: auto; margin-right: auto;">
                                    <div class="ad-box-products">
                                        <div class="ad-image">
                                            <div class="ad-tags absolute top-10 left-0 z-10">
                                                <div class="tag-1">
                                                    <span>{{$offert->title}}</span>
                                                </div>
                                            </div>
                                            <!--  <a href="" class="ad-add absolute top-10 right-10 z-10">
                                                  <i class="material-icons font-30">add</i>
                                              </a> -->
                                            @if(isset($imgoff))
                                                <img src="https://myusato.cls.it/upload/{{$imgoff->name}}"  alt="">
                                            @endif


                                        </div>

                                        <div class="ad-titles">
                                            <ul class="text-primary bc-secondary p-15">
                                                <!-- <li class="flex justify-between align-center mb-15">
                                                     <span class="weight-400">Tipologia:</span>
                                                     <span class="font-18">Fontale elettrico</span>
                                                 </li> -->
                                                <li class="flex justify-between align-center mb-15">
                                                    <span class="weight-400">Marca:</span>
                                                    <span class="font-18">{{ $prods->brand }}</span>
                                                </li>
                                                <li class="flex justify-between align-center">
                                                    <span class="weight-400">Modello:</span>
                                                    <span class="font-18">{{ $prods->model }}</span>
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
                                                    <span>{{ $prods->year }}</span>
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

                                        </div>
                                    </div>
                                </div>

                        </div>
                    @endif


                <form class="valuta-form" method="POST" action="{{route('storemoreinfo')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="offert_id" value="{{ $offert->id }}"/>

                    <input type="text" name="title" class="input mb-10 weight-500"
                           placeholder="{{ __('Titolo') }}" required="" style="border: 1px solid;">
                    <textarea class="textarea weight-500 mb-10" name="message" id="" cols="30" rows="14"
                              placeholder="{{__('Testo')}}" required=""
                              style="border: 1px solid;"></textarea>
                    <input type="text" name="email" class="input mb-10 weight-500"
                           placeholder="{{ __('Email cliente') }}" required="" style="border: 1px solid;">


                    <div class="flex flex-wrap justify-center align-center">
                        <button type="submit" id="sendmes" class="btn btn-primary">{{__('Invia')}}</button>
                    </div>

                </form>


            </div>

        </div>
    </section>
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

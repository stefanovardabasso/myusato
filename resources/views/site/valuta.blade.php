<!DOCTYPE html>
<html lang="en">

@section('title', __('Valua il tuo usato'))
@include('site.partiales._pagehead')

<body>

<!-- Header -->

@include('site.partiales._header')

<div class="container px-15 md_px-0">



    <div class="new-ads mb-30" style="margin-top: 5%">
        <center><h3 class="section-title">{{ __('Valuta il tuo usato') }}</h3></center>
        <BR>
            <center><h4>{{ __('Tutti i campi contrassegnnato con * sono obbligatori. ') }}</h4></center>
         <BR>
            <center><h4>{{ __('Per "montante", "sollevamento" e "portata" indicare il valore minimo richiesto.') }}</h4></center>
        <div class="row-15 flex flex-wrap my-40 px-15 md_px-0" style="padding-left: 15% !important; padding-right: 15% !important;">
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
            <form class="valuta-form" method="POST" action="{{ route('storevtu') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="cls-form-wrapper">
                <div class="cls-form-col-1 cls-form-item">
                <input type="text" name="name" class="input mb-10 weight-500" placeholder="{{ __('Nome') }}*" required="" style="border: 1px solid;">
                <input type="text" name="surname" class="input mb-10 weight-500" placeholder="{{ __('Cogome') }}*" required="" style="border: 1px solid;">
                <input type="text" name="company" class="input mb-10 weight-500" placeholder="{{ __('Ragione Sociale') }}*" required="" style="border: 1px solid;">
                <input type="text" name="address" class="input mb-10 weight-500" placeholder="{{ __('Indirizzo') }}*" required="" style="border: 1px solid;">
                <input type="text" name="comune" class="input mb-10 weight-500" placeholder="{{ __('Comune') }}*" required="" style="border: 1px solid;">
                <input type="text" name="province" class="input mb-10 weight-500" placeholder="{{ __('Provincia') }}*" required="" style="border: 1px solid;">
                <input type="text" name="phone" class="input mb-10 weight-500" placeholder="{{ __('Telefono') }}*" required="" style="border: 1px solid;">
                <input type="text" name="email" class="input mb-10 weight-500" placeholder="{{ __('Email') }}*" required="" style="border: 1px solid;">
                <input type="text" name="type" class="input mb-10 weight-500" placeholder="{{ __('Tipo') }}*" required="" style="border: 1px solid;">
                </div>
                <div class="cls-form-col-2 cls-form-item">
                <input type="text" name="brand" class="input mb-10 weight-500" placeholder="{{ __('Marca') }}*"  value="{{$out['brand']}}" required="" style="border: 1px solid;">
                <input type="text" name="model" class="input mb-10 weight-500" placeholder="{{ __('Modello') }}*" value="{{$out['model']}}" required="" style="border: 1px solid;">
                <input type="text" name="year" class="input mb-10 weight-500" placeholder="{{ __('Anno') }}*" value="{{$out['year']}}" required="" style="border: 1px solid;">
                <input type="text" name="mont" class="input mb-10 weight-500" placeholder="{{ __('Montante') }}*" required="" style="border: 1px solid;">
                <input type="text" name="smin" class="input mb-10 weight-500" placeholder="{{ __('Sollevamento MIN') }}*" value="{{$out['smin']}}" required="" style="border: 1px solid;">
                <input type="text" name="smax" class="input mb-10 weight-500" placeholder="{{ __('Sollevamento MAX') }}*" value="{{$out['smax']}}" required="" style="border: 1px solid;">
                <input type="text" name="port" class="input mb-10 weight-500" placeholder="{{ __('Portata') }}*" required="" style="border: 1px solid;">
                <input type="text" name="price" class="input mb-10 weight-500" placeholder="{{ __('Prezzo indicativo') }}*" required="" style="border: 1px solid;">
                <div class="checkbox-group mr-50">
                    <input type="checkbox" name="fornitore" id="1"/>
                    <label for="1" class="weight-500 text-light" style="color: black">{{__('Fornitore')}}</label>
                </div>
                </div>
                </div>
                <textarea class="textarea weight-500 mb-10" name="notes" id="" cols="30" rows="14" placeholder="{{__('Note')}}" required="" style="border: 1px solid;"></textarea>

                <div class="checkbox-group checkbox-form mb-10">
                    <input type="checkbox" id="4" required="" name="privacy">
                    <label for="4" class="line-height-1-3 text-secondary" required="">I tuoi dati personali saranno trattati secondo le modalità espresse all'interno
                        dell'informativa sulla privacy</label>
                </div>
                <div class="flex flex-wrap justify-center align-center">
                    <button name="submit" type="submit" class="btn btn-primary">Invia</button>
                </div>

            </form>


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

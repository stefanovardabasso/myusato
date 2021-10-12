<!DOCTYPE html>
<html lang="en">
@section('title', __('Contatti'))
@include('site.partiales._pagehead')

<body>

<!-- Header -->

@include('site.partiales._header')
{{--TODO: Fix names of forms!--}}
<section>
    <div class="cls-allestimenti-banner">
        <img src="https://via.placeholder.com/1980x1080">
        <h1>CONTATTI</h1>
    </div>
</section>
<div class="container px-15 md_px-0">

    <section class="mt-25 mb-25">
        <center><h3>CLS S.p.A. CGT Logistica Sistemi</h3></center>
        <center><h4>P.I. 02720500962</h4></center>
        <div class="coordinates mt-25">
            <div class="cls-coordinates-item">
                <div><span>Indrizzo:</span> <span>Strada Provinciale 121</span></div>
                <div><span>Città</span> <span>20061 Carugate (MI)</span></div>
            </div>
            <div class="cls-coordinates-item">
                <div><span>Tel:</span> <span>02.925051</span></div>
                <div><span>Fax:</span> <span>02.9250111</span></div>
                <div><span>Email:</span> <span>contact@cls.it</span></div>
            </div>
        </div>
    </section>
    <section>
        <div class="new-ads mb-30 px-15 md_px-0" style="margin-top: 5%">
            <center><h3 class>{{ __('HAI BISOGNO DI UN AIUTO?')}}</h3></center>
            <center><h3 class>{{ __('CONTATTACI') }}</h3></center>
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
                        @endif
                            <form class="valuta-form" method="POST" action="{{route('storemessage')}}" id="myform">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                <div class="cls-form-wrapper">
                                    <div class="cls-form-col-1 cls-form-item">
                                        <input type="text" name="name" class="input mb-10 weight-500"
                                               placeholder="{{ __('Nome') }}" required="" style="border: 1px solid;">
                                        <input type="text" name="company" class="input mb-10 weight-500"
                                               placeholder="{{ __('Ragione Sociale') }}" required=""
                                               style="border: 1px solid;">
                                        <input type="text" name="phone" class="input mb-10 weight-500"
                                               placeholder="{{ __('Telefono') }}*" required="" style="border: 1px solid;">
                                    </div>
                                    <div class="cls-form-col-2 cls-form-item">
                                        <input type="text" name="surname" class="input mb-10 weight-500"
                                               placeholder="{{ __('Cogome') }}" required="" style="border: 1px solid;">
                                        <input type="text" name="email" class="input mb-10 weight-500"
                                               placeholder="{{ __('Email') }}*" required="" style="border: 1px solid;">
                                    </div>
                                </div>



                                <textarea class="textarea weight-500 mb-10" name="message" id="" cols="30" rows="14"
                                          placeholder="{{__('Testo richiesta')}}" required=""
                                          style="border: 1px solid;"></textarea>

                                <div class="checkbox-group checkbox-form mb-10">
                                    <input type="checkbox" id="4" required="" name="marketing">
                                    <label for="4" class="line-height-1-3 text-secondary" required="">Accetto di ricevere da
                                        CLS informazioni di marketing tramite email</label>
                                </div>
                                <div class="checkbox-group checkbox-form mb-25">
                                    <input type="checkbox" id="5" required="" name="privacy">
                                    <label for="5" class="line-height-1-3 text-secondary" required="">I tuoi dati personali
                                        saranno trattati secondo le modalità espresse all'interno
                                        dell'informativa sulla privacy</label>
                                </div>
                                <div class="col-12 px-5 mt-10" id="result">

                                </div>
                                <div class="flex flex-wrap justify-center align-center">
                                    <button type="button" id="sendmes"  class="btn btn-primary">Invia</button>
                                </div>

                            </form>



                    </div>

        </div>
    </section>

    <script type="text/javascript">
        $("#sendmes").click(function() {
            $.post($("#myform").attr("action"), $("#myform :input").serializeArray(),
                function(info){ $("#result").html(info); } );


        });
    </script>
    <section class="mb-25 mt-25">
            <center><h3 class="mb-10">{{__('LE NOSTRI SEDI')}}</h3></center>
        <div class="cls-gmaps">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22344.28196868994!2d9.368069844943612!3d45.56972981253718!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xcc43e0382d0c44b2!2sCGT%20Logistica%20Sistemi%20S.p.A.%20-%20Sede%20Legale!5e0!3m2!1sit!2sit!4v1615906112238!5m2!1sit!2sit" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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

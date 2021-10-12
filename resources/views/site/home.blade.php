<!DOCTYPE html>
<html lang="en">

@section('title', __('Home'))
@include('site.partiales._pagehead')

<body>

<!-- Header -->

@include('site.partiales._header')

<!-- Visore -->
     @include('site.partiales._visor')

<!-- Filtri di ricerca -->
    @include('site.partiales._filters')

<div class="container px-15 md_px-0">
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
    @if(session()->has('alert'))
        <center> <div class="alert alert-success" style="color: white;
    background-color: #ff0505;
    border-color: #15ff05;
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-top-color: transparent;
    border-right-color: transparent;
    border-bottom-color: transparent;
    border-left-color: transparent;
    border-radius: 4px; position: fixed;">
                {{ session()->get('alert') }}
            </div>
        </center>
    @endif
    @include('site.partiales._feature')

    @include('site.partiales._offertsbundle')

</div>
<!-- Valuta il tuo carrello usato-->
  @include('site.partiales._formvaluta')

<!-- Resta in contatto -->

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

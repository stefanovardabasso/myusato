<!DOCTYPE html>
<html lang="en">
@php
  if(Auth::check()){
    $role = auth()->user()->getrole();
    $role = $role[0]->id;
}else{
    $role = 0;
}
@endphp
@section('title', __('Search'))
@include('site.partiales._pagehead')

<body>

<!-- Header -->

@include('site.partiales._header')

<!-- Visore -->
<div class="filters filter-bar bc-secondary pt-30 pb-60 mb-50" style="background: linear-gradient(180deg, #2d2d2d,#2d2d2dad, #fff);">
    <div class="container">

        <div class="flex row-10">
            @foreach($filterButtons as $filterButton)
                <div class="col-2 px-10">
                    <a href="{{route('search', ['filterId' => $filterButton->id])}}?cod_fam={{$filterButton->fam_code}}" class="block type-box bc-primary py-10 cls-filter-button " style="border-radius: 50px;">
                        <span><center>{{$filterButton->label}}</center></span>
                    </a>
                </div>
            @endforeach
        </div>

    </div>
</div>
@if($role == 8 | $role == 1 | $role == 5)


<div class="filters filter-bar bc-secondary pt-30 pb-60 mb-50" style="background-color: white;">
    <div class="container">
        <div class="flex flex-wrap justify-between align-center mt-30 filters-cloud">
        <div class="md_col-5 col-12 mt-15 md_mt-0">
            <h4 class="font-25 text-secondary weight-500 mb-10"> Sei nella lista per  : @if(Session::get('list') == 1)<Strong>Utente finale</Strong>    @else <Strong>Commercianti</Strong>   @endif</h4>
        </div>
        <div class="md_col-3 col-12 mt-15 md_mt-0">
            <a class="button" href="{{route('changelist')}}">Passa alla lista : @if(Session::get('list') == 1) Commercianti   @else Utente finale  @endif  </a>
        </div>
        </div>

    </div>
</div>

    @endif
<div class="container py-40 px-15 md_px-0" style="margin-top: -4%">

    @include('site.partiales._breadcrumb')
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
    <div class="flex flex-wrap md_row-15">

            @include('site.partiales._filtersresult')

            @include('site.partiales._filterresultsearch')

            @include('site.partiales._listsearchresult')

            <!-- @include('site.partiales._pagination') -->

        </div>
    </div>
</div>
@include('site.partiales._contactform')
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

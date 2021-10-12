<!DOCTYPE html>
<html lang="en">
@section('title', __('Quotations'))
@include('site.partiales._pagehead')

<body>

<!-- Header -->

@include('site.partiales._header')



<?php

$role = auth()->user()->getrole();
if ($role[0]->id == 2) {
    $you = 2;
} else {
    $you = 1;
} ?>
<div class="container px-15 md_px-0" style="margin-bottom: 10%">
    <div class="tech-details pt-40 mt-40">
        <h2 class="section-title">{{__('Quotazione inviate')}}</h2>
        <div class="flex flex-wrap mt-40">
            <div class="col-12 overflow-auto">
                <table class="cls-table mx-auto md_col-12 col-12" cellpadding="0" cellspacing="0">

                    <thead>
                    <tr>
                        <th class="label">
                            <center>{{__('Titolo')}}</center>
                        </th>
                        <th class="label">
                            <center>{{__('Data')}}</center>
                        </th>
                        <th class="label">
                            <center>{{__('Status')}}</center>
                        </th>
                        <th class="label">
                            <center>{{__('Azioni')}}</center>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($quotations as $quotation)
                        <tr>
                            <td class="label"
                                style="background-color: transparent;border: 1px solid black;">{{ $quotation->title }} </td>
                            <td class="label"
                                style="background-color: transparent;border: 1px solid black;">{{ date_format($quotation->created_at,"d/m/Y")  }} </td>
                            <td class="label"
                                style="background-color: transparent;border: 1px solid black;"><?php if ($you == 2) {
                                    echo __('Inviata');
                                } else {
                                    echo $quotation->status;
                                } ?></td>
                            <td class="label" style="background-color: transparent;border: 1px solid black;">
                                <center>
                                    <a target="_blank" href="{{url('upload/'.$quotation->id.'.pdf')}}">
                                        <i class="material-icons mr-5">remove_red_eye</i>
                                    </a>
                                </center>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

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

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
<script  src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link href="{{ asset('css/tiny-slider/tiny-slider.css') }}" rel="stylesheet">
<style>
    table .label {
        background-color: #ffcb0f;
    }
    table,th,td,tr {
        border: none;
    }
    table td {
        padding: 10px;
        text-align: center;
    }
    table td:nth-child(2n) {
        text-align: left;
    }
</style>
<body>
<div class="main-bar bc-secondary pt-40">
    <div class="logo no-mobile mx-auto mb-40">
        <a href="http://myusato.cls.it"> <img src="http://myusato.cls.it/site/images/logo-cls.png" alt=""></a>
    </div>
     
</div>
<div class="container my-40 px-15 md_px-0">
    <div class="row">
        <div class="col-md-5" style="{{!isset($gallery[0]) ? "min-height: 65px;width: 100%" : ""}}">
            <div class="mb-5 md_mb-20 relative">
                <center><h1>{{$offerWithProduct->title}}</h1></center>
                <div id="offer-gallery">
                        <img src="{{ url('upload/' . $gallery[0]->name) }}" alt="">
                </div>
            </div>
        </div>
        <div class="md_pl-20 col-md-4 -4 mt-20 md_mt-0">
            <span class="text-secondary weight-500 font-18">{{$offerWithProduct->type}}</span>
            <h2 class="mt-10 font-35 weight-500">{{$offerWithProduct->model}}</h2>
            <ul class="product-info mt-25">
                <li>{{__('MyUsato Code')}}: <span>{{$offerWithProduct->myUsatoCode}}</span></li>
                <li>{{__('Brand')}}: <span>{{$offerWithProduct->brand}}</span></li>
                <li>{{__('Price')}}: <span>{{$offerWithProduct->price}} €</span></li>
                <li>{{__('Availability')}}: <span>Pronto</span></li>
            </ul>
            <p class="weight-500 my-25 line-height-1-4">{{$offerWithProduct->description}}</p>
            <br/>
        </div>
    </div>
    <div class="tech-details pt-40 mt-40">
        <h2 class="section-title">{{__('Technical Specifications')}}</h2>
        <div class="row">
            <div class="col-md-6">
                    <table cellspacing="0" cellpadding="0">
                    @foreach($mandatoryProductInfo as $label => $productInfo)
                        <tr>
                            <td class="label" style="background-color: #ffcb0f">{{$label}}</td>
                            <td>{{$productInfo}}</td>
                        </tr>
                    @endforeach
                    </table>
            </div>
            <div class="col-md-6">
                @if ($hasProductLines)
                    <table cellspacing="0" cellpadding="0">
                        @foreach($productLines as $productLine)
                            <tr>
                                <td class="label" style="background-color: #ffcb0f">{{$productLine->label}}</td>
                                <td>{{$productLine->answer}}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>



</body>

</html>

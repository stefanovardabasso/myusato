{{--<html>--}}
{{--<head>--}}
{{--    <!-- Bootstrap CSS -->--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"--}}
{{--          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">--}}
{{--    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">--}}
{{--    <link rel="preconnect" href="https://fonts.gstatic.com">--}}
{{--    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">--}}
{{--    <style>--}}
{{--        .product-image {--}}
{{--            background-position: center;--}}
{{--            background-size: cover;--}}
{{--            width: 100%;--}}
{{--            height: 400px;--}}
{{--        }--}}

{{--        .page-break {--}}
{{--            page-break-before: always;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body--}}
{{--    style="border: 25px solid #ffcb0f !important;margin:-7%; margin-top:-5%; margin-bottom:-9%; font-family: 'Poppins', sans-serif;">--}}

{{--<div class="container">--}}
{{--    <div class="row">--}}
{{--        <center><img src="https://rtc.cls.it/images/admin-panel/logo.png" width="50%" class="img-responsive"></center>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="container">--}}
{{--    <table class="table">--}}
{{--        <tr style="background-color: #ffcb0f">--}}
{{--            <td>{{__('Prodotti')}}</td>--}}
{{--            <td>{{__('Prezzo')}}</td>--}}
{{--        </tr>--}}
{{--        <?php $pric = 0; ?>--}}
{{--        @foreach($offerts as $off)--}}
{{--<!--            --><?php //$pric = $prices[$off->id] + $pric; ?>--}}
{{--            <tr>--}}
{{--                <td colspan="2">{{$titles[$off->id]}}</td>--}}
{{--                <td>{{$prices[$off->id]}} &euro;</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        <tr>--}}
{{--            <td>{{__('Total')}} </td>--}}
{{--            <td> {{$pric}} &euro;</td>--}}
{{--        </tr>--}}
{{--    </table>--}}
{{--</div>--}}

{{--<hr style="page-break-after: always;">--}}

{{--<div class="container">--}}
{{--    <div class="row">--}}
{{--        @foreach($singleoff as $sin)--}}
{{--            <div class="col-xs-12">--}}
{{--                <CENTER style="border-radius: 0 50px 50px 0;--}}
{{--                    background-color: #ffcb0f;--}}
{{--                    height: 40px;--}}
{{--                    padding: 0 15px;"><strong>{{$offerts[$sin->id_offert]->title}}</strong></CENTER>--}}
{{--                <h5>{{__('Price')}}: {{$offerts[$sin->id_offert]->price_uf}} &euro;</h5>--}}
{{--                <p style="text-align:justify; line-height: 1.4">{{$offerts[$sin->id_offert]->descripit}}</p>--}}
{{--<div class="page-break"></div>--}}
{{--                <div style="padding-top: 100px; margin: 0 -100px;">--}}
{{--                    <div class="product-image" style="background-image: url('{{ url('upload/'.$imgoff[$sin->id_offert]->name) }}');"></div>--}}
{{--                </div>--}}


{{--                <table class="table" style="padding-top: 50px;">--}}
{{--                    <tr style="background-color: #ffcb0f">--}}
{{--                        <td> {{ __('Brand')  }}</td>--}}
{{--                        <td> {{ __('Model')  }}</td>--}}
{{--                        <td> {{ __('Year')  }}</td>--}}
{{--                        <td> {{ __('Ore')  }}</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td> {{  $prods[$sin->id_offert]->brand }}</td>--}}
{{--                        <td> {{  $prods[$sin->id_offert]->model }}</td>--}}
{{--                        <td> {{  $prods[$sin->id_offert]->year }}</td>--}}
{{--                        <td> {{  $prods[$sin->id_offert]->orelavoro }}</td>--}}
{{--                    </tr>--}}
{{--                </table>--}}

{{--                <table class="table">--}}
{{--                    <?php $a = 0; ?>--}}
{{--                    @for($i=0;$i<count($prods_lines[$sin->id_offert]);$i++)--}}
{{--                        {{$prods_lines[$sin->id_offert][$i]->label_it  }}--}}
{{--                        <?php if($a == 0){ ?>--}}
{{--                        <tr style="background-color: #ffcb0f"><?php } ?>--}}
{{--                            <td> {{$prods_lines[$sin->id_offert][$i]->label_it  }}</td>--}}
{{--                            <?php if($a == 4){  ?></tr>--}}
{{--                        <tr><?php $a = 0; } ?>--}}
{{--                            <td> {{  $prods_lines[$sin->id_offert][$i]->ans_it }}</td>--}}
{{--                            <?php if($a == 4){  ?> </tr><?php }  $a++?>--}}
{{--                    @endfor--}}
{{--                </table>--}}
{{--            </div>--}}
{{--            <hr style="page-break-after: always;">--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--</div>--}}


{{--</body>--}}
{{--</html>--}}


<html>
<head>
    <meta name="viewport"  content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
</head>
<style>
    @font-face {
        font-family: 'Roboto';
        src: url('fonts/Roboto-Regular.ttf');
    }
    @font-face {
        font-family: 'Roboto';
        src: url('fonts/Roboto-Bold.ttf');
        font-weight: bold;
    }
    html, body {
        margin:0;
        padding:0;
        font-family: 'Roboto', sans-serif;
        font-size: 22px;
        color:#787575;
    }
    a {
        text-decoration: none;
    }
    a:visited, a:link {
        color:#787575;
    }
    .container {
        height: auto;
        width: 100wh;
        display:flex;
        flex-direction: row;
        flex-wrap: nowrap;
        background-color: white;
        column-gap:10px;
    }
    .left-column {
        order:1;
        flex-basis: 18%;
        background-color: rgb(254, 223, 107);
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .left-column > p {
        font-size: 0.8em;
    }
    .left-column > img {
        margin-top: 3%;
    }
    .right-column {
        order:2;
        flex-basis: 82%;
        background-color: white;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        flex-wrap: wrap;
        padding-left: 2%;
        padding-right: 2%;
    }
    .header {
        display: flex;
        flex-direction: column;
        width: 100%;
        align-items: center;
    }
    .header > img {
        width:200px;
        align-self: flex-end;
        margin-right: 5%;
        margin-top: 3%;
    }
    .header > p {
        width: 380px;
        font-size: 1.2rem;
    }
    .p-big-font {
        font-size: 1.3rem !important;
    }
    #cls-logo {
        width: 100%;
        margin-top: 15%;
        margin-bottom: 10%;
    }
    #hyster-img {
        align-self:center;
        width: 60%;
    }
    .row-div {
        display: flex;
        flex-direction: row;
        gap:3rem;
        width: 100%;
        flex-wrap: wrap;
    }
    div.row-div > :first-child {
        box-sizing: border-box;
        width: 15%;
    }
    h2 {
        color:red;
        font-weight: bold;
    }
    .white-strip1 {
        height: 410px;
        width: 88%;
        background-color: white;
        align-self: flex-end;
    }
    .white-strip2 {
        height: 300px;
        width: 88%;
        background-color: white;
        align-self: flex-end;
        margin-top: auto;
    }

</style>
<body>
<div class="container">
    <div class="left-column">
        <div class="white-strip1"></div>
        <img id="cls-logo" src="{{ asset('templatepdf/img/cls-logo.png') }} ">
        <p style="text-align: center;">Un unico Partner una galassia di soluzioni {{ asset('templatepdf/img/location.png') }}</p>
        <img src="{{ asset('templatepdf/img/location.png') }}" width="52px" height="52px">
        <p style="text-align: center;">Carugate - Direzione</p>
        <img src="img/user.png" width="52px" height="52px">
        <p>Gabriele Resmini</p>
        <img src="img/phone.png" width="52px" height="52px">
        <p>3665898845</p>
        <img src="img/mail.png" width="52px" height="52px">
        <p><a href="mailto:gresmini@cls.it">gresmini@cls.it</a></p>
        <img src="img/website.png" width="52px" height="52px">
        <p style="margin-bottom: 20%;"><a href="www.cls.it">cls.it</a></p>
        <div class="white-strip2"></div>
    </div>
    <div class="right-column">
        <div class="header">
            <img src="img/cls-logo-black.png">
            <p>Spett.le MONDOREVIVE SPA FR</p>
            <p>CASILINA KM 68,00</p>
            <p>Alla cortese attenzione di test</p>
        </div>
        <h2>Carrello Controbilanciato Hyster A1.5XNT SMART</h2>
        <p class="p-big-font"><b>Oggetto: quotazione BY20210029V del 21-09-2021 per la fornitura di: N° 2 Hyster A1.5XNT versione SMART</b></p>
        <p class="p-big-font">Facendo seguito alla Vostra richiesta ed in accordo con le Vostre specifiche, Vi sottoponiamo la soluzione che riteniamo più idonea alla Vostra applicazione.</p>
        <img src="img/hyster.png" id="hyster-img">
        <div class="row-div p-big-font"><p>Montante</p><p>MONTANTE 3 STADI FFT 4600 MM-ING 2080MM COMPLETO</p></div>
        <div class="row-div p-big-font"><p>Batteria</p><p>BATT. MIDAC 24V-1000Ah+RA-A1.5XNT</p></div>
        <div class="row-div p-big-font"><p>Raddrizzatore</p><p>Raddr.24v-160A-3F-380V-N.Elettra</p></div>

    </div>
</div>
</body>
</html>









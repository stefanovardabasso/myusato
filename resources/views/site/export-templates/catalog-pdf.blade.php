<html>
<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        .product-image {
            background-position: center;
            background-size: cover;
            width: 100%;
            height: 400px;
        }

        .page-break {
            page-break-before: always;
        }
        .page-break:last-child {
            page-break-before: unset;
        }
    </style>
</head>
<body
    style="border: 25px solid #ffcb0f !important;margin:-7%; margin-top:-5%; margin-bottom:-9%; font-family: 'Poppins', sans-serif;">

<div class="container">
    <div class="row">
        <center><img src="https://rtc.cls.it/images/admin-panel/logo.png" width="50%" class="img-responsive"></center>
    </div>
</div>


<div class="container">
    <div class="row">
        @foreach($singleoff as $sin)
            <div class="col-xs-12">
                <CENTER style="border-radius: 0 50px 50px 0;
                    background-color: #ffcb0f;
                    height: 40px;
                    padding: 0 15px;"><strong>{{$offerts[$sin->id_offert]->title}}</strong></CENTER>
                <h5>{{__('Price')}}: {{$sin->getPriceByRole($sin->id_offert)}} &euro;</h5>
                <p style="text-align:justify;line-height: 1.4;">{{$offerts[$sin->id_offert]->descripit}}</p>
                <div class="page-break"></div>
                <div style="padding-top: 70px; margin: 0 -100px;">
                    <div class="product-image"
                         style="background-image: url('{{ url('upload/'.$imgoff[$sin->id_offert]->name) }}');"></div>
                </div>


                <table class="table" style="margin-top: 50px;">
                    <tr style="background-color: #ffcb0f">
                        <td> {{ __('Brand')  }}</td>
                        <td> {{ __('Model')  }}</td>
                        <td> {{ __('Year')  }}</td>
                        <td> {{ __('Ore')  }}</td>
                    </tr>
                    <tr>
                        <td> {{  $prods[$sin->id_offert]->brand }}</td>
                        <td> {{  $prods[$sin->id_offert]->model }}</td>
                        <td> {{  $prods[$sin->id_offert]->year }}</td>
                        <td> {{  $prods[$sin->id_offert]->orelavoro }}</td>
                    </tr>
                </table>

                <table class="table">
                    <?php $a = 0; ?>
                    @for($i=0;$i<count($prods_lines[$sin->id_offert]);$i++)
                        {{$prods_lines[$sin->id_offert][$i]->label_it  }}
                        <?php if($a == 0){ ?>
                        <tr style="background-color: #ffcb0f"><?php } ?>
                            <td> {{$prods_lines[$sin->id_offert][$i]->label_it  }}</td>
                            <?php if($a == 4){  ?></tr>
                        <tr><?php $a = 0; } ?>
                            <td> {{  $prods_lines[$sin->id_offert][$i]->ans_it }}</td>
                            <?php if($a == 4){  ?> </tr><?php }  $a++?>
                    @endfor
                </table>
            </div>
        <div class="page-break"></div>
{{--            <hr style="page-break-after: always;">--}}
        @endforeach
        @foreach($bunoff as $bun)
                <div class="col-xs-12">
                    <CENTER style="border-radius: 0 50px 50px 0;
                    background-color: #ffcb0f;
                    height: 40px;
                    padding: 0 15px;"><strong>{{$offerts[$sin->id_offert]->title}}</strong></CENTER>
                    <h5>{{__('Price')}}: {{$sin->getPriceByRole($bun->id_offert)}} &euro;</h5>
                    <p style="text-align:justify;line-height: 1.4;">{{$offerts[$bun->id_offert]->descripit}}</p>
                    <div class="page-break"></div>
                    <div style="padding-top: 70px; margin: 0 -100px;">
                        <div class="product-image"
                             style="background-image: url('{{ url('upload/'.$imgoff[$bun->id_offert]->name) }}');"></div>
                    </div>

                    @foreach($prods[$bun->id_offert] as $prod)
                    <table class="table" style="margin-top: 50px;">
                        <tr style="background-color: #ffcb0f">
                            <td> {{ __('Brand')  }}</td>
                            <td> {{ __('Model')  }}</td>
                            <td> {{ __('Year')  }}</td>
                            <td> {{ __('Ore')  }}</td>
                        </tr>
                        <tr>
                            <td> {{  $prod->brand }}</td>
                            <td> {{  $prod->model }}</td>
                            <td> {{  $prod->year }}</td>
                            <td> {{  $prod->orelavoro }}</td>
                        </tr>
                    </table>

                    <table class="table">
                        <?php $a = 0; ?>
                        @for($i=0;$i<count($prods_lines[$bun->id_offert][$prod->id]);$i++)
                            {{$prods_lines[$bun->id_offert][$prod->id][$i]->label_it  }}
                            <?php if($a == 0){ ?>
                            <tr style="background-color: #ffcb0f"><?php } ?>
                                <td> {{$prods_lines[$bun->id_offert][$prod->id][$i]->label_it  }}</td>
                                <?php if($a == 4){  ?></tr>
                            <tr><?php $a = 0; } ?>
                                <td> {{  $prods_lines[$bun->id_offert][$prod->id][$i]->ans_it }}</td>
                                <?php if($a == 4){  ?> </tr><?php }  $a++?>
                        @endfor
                    </table>
                    @endforeach
                </div>
                <div class="page-break"></div>
                {{--            <hr style="page-break-after: always;">--}}
            @endforeach

    </div>
</div>
</body>
</html>










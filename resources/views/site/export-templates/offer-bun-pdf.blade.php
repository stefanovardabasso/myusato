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
        <div class="col-xs-12">
            <CENTER style="border-radius: 0 50px 50px 0;
                    background-color: #ffcb0f;
                    height: 40px;
                    padding: 0 15px;"><strong>{{$offert->title}}</strong></CENTER>
            <h5>{{__('Price')}}: {{$offert->price}} &euro;</h5>
            <p style="text-align: justify; line-height: 1.4;">{{$offert->description}}</p>
            <div class="page-break"></div>

            <div style="padding-top: 100px; margin: 0 -100px;">
                <div class="product-image"
                     style="background-image: url({{ url('upload/' . $gallery[0]->name) }});"></div>
            </div>
            @foreach($products as $offerWithProduct)
            <table class="table" style="padding-top: 50px;">
                <tr style="background-color: #ffcb0f">
                    <td> {{ __('Brand')  }}</td>
                    <td> {{ __('Model')  }}</td>
                    <td> {{ __('Year')  }}</td>
                    <td> {{ __('Ore')  }}</td>
                </tr>
                <tr>
                    <td> {{  $offerWithProduct->brand }}</td>
                    <td> {{  $offerWithProduct->model }}</td>
                    <td> {{  $offerWithProduct->year }}</td>
                    <td> {{  $offerWithProduct->orelavoro }}</td>
                </tr>
            </table>

            <table class="table">
                <?php $a = 0; ?>
                @for($i=0;$i<count($productLines[$offerWithProduct->id]);$i++)
                    {{$productLines[$offerWithProduct->id][$i]->label  }}
                    <?php if($a == 0){ ?>
                    <tr style="background-color: #ffcb0f"><?php } ?>
                        <td> {{$productLines[$offerWithProduct->id][$i]->label  }}</td>
                        <?php if($a == 4){  ?></tr>
                    <tr><?php $a = 0; } ?>
                        <td> {{  $productLines[$offerWithProduct->id][$i]->answer }}</td>
                        <?php if($a == 4){  ?> </tr><?php }  $a++?>
                @endfor
            </table>
            @endforeach
        </div>
    </div>
</div>
</body>
</html>

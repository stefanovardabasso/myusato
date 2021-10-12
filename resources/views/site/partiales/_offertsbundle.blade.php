
<div class="offers pt-50">
    <h2 class="section-title">Offerte</h2>
    <div class="row-15 flex flex-wrap my-40">
    @foreach($bunoff as $off)
            <div class="md_col-3 col-12 px-15 mb-40 md_mb-0">
            <div class="off-box">
                <div class="off-image">
                    <img src="https://myusato.cls.it/upload/{{$imgoff[$off->id]->name}}"  alt="">
                    @if($catalog[$off->id] == false)
                        <a data-offer-id="{{$off->id}}" data-type="Bundle" href="{{ Auth::check() ? route('addtomycatalog', ['id_offert' => $off->id, 'type' => 'Bundle']) : "http://login.cls.it/login?sso=".config('session.sso_token') }}" class="ad-add absolute top-10 right-10 z-10">
                            <i class="material-icons font-30">{{Auth::check() ? 'add' : 'lock'}}</i>
                        </a>
                    @else
                        <a data-offer-id="{{$off->id}}" data-type="Bundle" href="{{ route('deletemycatalog',['idoffert' => $off->id]) }}" class="ad-add absolute top-10 right-10 z-10">
                            <i class="material-icons font-30">{{Auth::check() ? 'delete' : 'lock'}}</i>
                        </a>
                    @endif
                </div>
                <div class="off-titles px-15 pt-5">
                    @if(Auth::check())
                        <span class="block font-30 mb-5">{{$off->getPriceByRole($off->id)}} €</span>
                    @else

                        <li class="flex justify-between mb-13">
                            <a href="http://login.cls.it/login?sso={{  config('session.sso_token')  }}" class="button">Vedi prezzo</a>
                        </li>
                        @endif


                  <!--  <p class="font-14 weight-500">Prezzo consigliato: <span class="strike">1081,99 €</span> (-28%)</p> -->
                    <!--<div class="off-bar"></div>
                    <p class="mt-5 text-right">Mancano 11:03:10</p> -->
                    <a href="{{ route('product-bun-detail', ['id_offert' => $off->id ]) }}" class="button">Scopri di più</a>
                </div>
                <table class="off-table mt-10">
                    <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Modello</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($prods[$off->id] as $prod )

                    <tr>
                        <td> {{$prod->brand}}</td>
                        <td> {{$prod->model}}</td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center">
        <a href="{{ route('allbundles') }}" class="button w-auto px-50">Mostra tutti</a>
        <br>
    </div>
</div>


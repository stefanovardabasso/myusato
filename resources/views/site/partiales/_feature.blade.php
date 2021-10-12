


<div class="new-ads mb-30">

    <h2 class="section-title">Nuovi annunci</h2>
    <div class="row-15 flex flex-wrap my-40">
        @foreach($singleoff as $off)
        <div class="md_col-3 col-12 px-15 mb-40 md_mb-0">
            <div class="ad-box-products">
                <div class="ad-image">
                    <div class="ad-tags absolute top-10 left-0 z-10">
                        <div class="tag-1" style="background-color: #1a9910; border: 3px solid #1a9910; color: white">
                            <span> @if($off->target_user == '1') {{$off->title_1_uf}}  @else {{$off->title_1_co}} @endif </span>
                        </div>
                        @if($off->target_user == '1')
                        @if($off->title_2_uf != null) <div class="tag-1"  style="background-color: white; border: 3px solid black;" > <span>{{$off->title_2_uf}}</span> </div> @endif
                        @else
                            @if($off->title_2_co != null) <div class="tag-1" style="background-color: white; border: 3px solid black;"> <span>{{$off->title_2_co}}</span> </div> @endif
                        @endif
                        @if($off->target_user == '1')
                            @if($off->title_3_uf != null) <div class="tag-1" style="background-color: red; border: 3px solid red; color: white"> <span>{{$off->title_3_uf}}</span> </div> @endif
                        @else
                            @if($off->title_3_co != null) <div class="tag-1" style="background-color: red; border: 3px solid red; color: white"> <span>{{$off->title_3_co}}</span> </div> @endif
                        @endif
                    </div>
                  <!--  <a href="" class="ad-add absolute top-10 right-10 z-10">
                        <i class="material-icons font-30">add</i>
                    </a> -->
                    @if(isset($imgoff[$off->id]))
                    <img src="https://myusato.cls.it/upload/{{$imgoff[$off->id]->name}}"  alt="">
                    @endif
                    @if($catalog[$off->id] == false)
                    <a data-type="Single" data-offer-id="{{$off->id}}" href="{{ Auth::check() ? route('addtomycatalog', ['id_offert' => $off->id, 'type' => 'Single']) : "http://login.cls.it/login?sso=".config('session.sso_token') }}" class="ad-add absolute top-10 right-10 z-10">
                        <i data-offer-id="{{$off->id}}"class="material-icons font-30">{{Auth::check() ? 'add' : 'lock'}}</i>
                    </a>
                    @else
                        <a data-type="Single" data-offer-id="{{$off->id}}"  href="{{ route('deletemycatalog',['idoffert' => $off->id]) }}" class="ad-add absolute top-10 right-10 z-10">
                            <i data-offer-id="{{$off->id}}" class="material-icons font-30">{{Auth::check() ? 'delete' : 'lock'}}</i>
                        </a>
                    @endif

                </div>

                <div class="ad-titles">
                    <ul class="text-primary bc-secondary p-15">
                       <!-- <li class="flex justify-between align-center mb-15">
                            <span class="weight-400">Tipologia:</span>
                            <span class="font-18">Fontale elettrico</span>
                        </li> -->
                        <li class="flex justify-between align-center mb-15">
                           <span class="font-18">{{ $prods[$off->id]->brand }}</span>  - <span class="font-18">{{ $prods[$off->id]->model }}</span> - <span class="font-18">{{ $prods[$off->id]->partita }}</span>
                        </li>
                    </ul>
                </div>
                <div class="ad-info">
                    <ul>
                        @foreach($single_offerts_lines[$off->id] as $line)
                        <li class="flex justify-between mb-12">
                            <span class="weight-400">{{ $line->label_it }}:</span>
                            <span>{{ $line->ans_it }}</span>
                        </li>
                        @endforeach
                        <li class="flex justify-between mb-12">
                            <span class="weight-400">{{__('Anno')}}:</span>
                            <span>{{ $prods[$off->id]->year }}</span>
                        </li>
                            @if(Auth::check())
                                <li class="flex justify-between mb-13">
                                    <span class="weight-400">{{__('Prezzo')}}:</span>
                                    <span class="uppercase">@if($off->target_user == '1') {{ money_format('%i', $off->list_price_uf) }} €  @else {{money_format('%i', $off->list_price_co) }} € @endif</span>
                                </li>
                            @else
                                <li class="flex justify-between mb-13">
                                    <a href="http://login.cls.it/login?sso={{  config('session.sso_token')  }}" class="button">Vedi prezzo</a>
                                </li>
                            @endif
                    </ul>
                    <a href="{{ route('product-detail', ['id_offert' => $off->id ]) }}" class="button">Scopri di più</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center">
        <a href="1/search?cod_fam=CE" class="button w-auto px-50">Mostra tutti</a>
        <br>

    </div>
</div>


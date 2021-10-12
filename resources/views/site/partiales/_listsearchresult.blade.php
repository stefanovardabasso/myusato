<div class="loader-wrapper"><div class="loader">Loading..</div></div>
<div class="new-ads mt-30" hidden="true">
    <div class="flex md_row-15 flex-wrap cls-ads-wrapper">

        @foreach($offersWithProduct as $offer)
        <div class="md_col-4 col-12 md_px-15 mb-30">
            <div class="ad-box-products" style="display: block !important;">
                <div class="ad-image">
                    <div class="ad-tags absolute top-10 left-0 z-10">
                        <div class="tag-1" style="background-color: #1a9910; border: 3px solid #1a9910; color: white">
                            <span>{{$offer->title1}}</span>
                        </div>
                        @if($offer->title2 != null)
                        <div class="tag-1" style="background-color: white; border: 3px solid black;">
                            <span>{{$offer->title2}}</span>
                        </div>
                        @endif
                        @if($offer->title3 != null)
                            <div class="tag-1" style="background-color: red; border: 3px solid red; color: white">
                                <span>{{$offer->title3}}</span>
                            </div>
                        @endif
                    </div>
                    @if ($offer->isInCatalog === true)
                        <a data-offer-id="{{$offer->id}}" data-type="{{$offer->type}}" href="{{ Auth::check() ? route('deletemycatalog', ['idoffert' => $offer->id]) : "http://login.cls.it/login?sso=".config('session.sso_token') }}" class="ad-add absolute top-10 right-10 z-10">
                            <i class="material-icons font-30">{{Auth::check() ? 'delete' : 'lock'}}</i>
                        </a>
                    @else
                    <a data-offer-id="{{$offer->id}}" data-type="{{$offer->type}}" href="{{ Auth::check() ? route('addtomycatalog', ['id_offert' => $offer->id, 'type' => $offer->type]) : "http://login.cls.it/login?sso=".config('session.sso_token') }}" class="ad-add absolute top-10 right-10 z-10">
                        <i class="material-icons font-30">{{Auth::check() ? 'add' : 'lock'}}</i>
                    </a>
                    @endif
                    <img src="{{ isset($offer->gallery[0]) ? url('upload/' . $offer->gallery[0]->name) : ''}}" alt="Image of offer">
                </div>
                <div class="ad-titles {{($offer->type ==='Bundle') ? 'no-border' : ''}}">
                        @if ($offer->type ==='Bundle')
                        <table class="off-table">
                            <thead>
                            <tr>
                                <th class="p-15">Marca</th>
                                <th class="p-15">Modello</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($offer->bundleProducts as $product )

                                <tr>
                                    <td> {{$product->brand}}</td>
                                    <td> {{$product->model}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        @else
                    <ul class="text-primary bc-secondary p-15">
                        <li class="flex justify-between align-center mb-15">
                            <span class="weight-400"></span>
                            <span class="font-18"><center>{{$offer->brand}} - {{$offer->model}} - {{$offer->myUsatoCode}}</center></span>
                        </li>
                    </ul>
                        @endif
                </div>
                <div class="ad-info">
                    @if ($offer->type === 'Bundle')
                        <a href="{{ route('product-bun-detail', ['id_offert' => $offer->id]) }}" class="button">Scopri di più</a>
                    @else
                    <ul>
                        @php $linecount=0; @endphp
                        @foreach($offer->product->lines as $line)
                            @if($line->filter == 'X')
                            @if($linecount <= 3)
                        <li class="flex justify-between mb-12">
                            <span class="weight-400">{{ $line->label_it }}</span>
                            <span>{{ $line->ans_it }}</span>
                        </li>
                            @endif
                            @php $linecount++; @endphp
                            @endif
                        @endforeach
                        <li class="flex justify-between mb-12">
                            <span class="weight-400">{{__('Anno')}}:</span>
                            <span>{{$offer->year}}</span>
                        </li>
                        @if(Auth::check())
                        <li class="flex justify-between mb-12">
                            <span class="weight-400">{{__('Prezzo')}}:</span>
                            <span>{{ number_format($offer->price, 0, ',', '.')   }}  €</span>
                        </li>
                        @else
                            <li class="flex justify-between mb-12">
                                <a href="http://login.cls.it/login?sso={{  config('session.sso_token')  }}" class="button">Vedi prezzo</a>
                            </li>
                        @endif

                    </ul>
                    <a href="{{ route('product-detail', ['id_offert' => $offer->id]) }}" class="button">Scopri di più</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            showLoader();
        }, 100);
        setTimeout(() => {
            hideLoader();
        }, 100)
    });

    function hideLoader() {
        $('.new-ads').show();
        $('.loader-wrapper').hide();
    }

    function showLoader() {
        $('.new-ads').hide();
        $('.loader-wrapper').show();
    }
</script>

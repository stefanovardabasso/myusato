<div class="no-desktop bc-secondary p-15 flex justify-between align-center">
    <div class="logo-mob">
        <img src="{{ asset('site/images/logo-cls.png') }}" alt="">
    </div>
    <div class="btn-menu" id="btnMenu">
        <i class="material-icons text-light font-50">menu</i>
    </div>
</div>

<header class="header" id="menuMob">
    <div class="close-menu no-desktop absolute top-15 right-15" id="closeMenu">
        <i class="material-icons text-light font-40">close</i>
    </div>
    <div class="top-bar py-13 bc-primary">
        <div class="md_px-20 md_flex md_justify-end md_align-center">
            <ul class="top-menu md_inline-flex align-center text-center font-14 weight-400">
                <li>
                    <a href="https://www.cls.it/" class="flex align-center justify-center">
                        <i class="material-icons font-20">home</i>
                    </a>
                </li>
                <li><a target="_blank" href="https://www.cls.it/gruppo-tesya/">Gruppo Tesya</a></li>
                <li><a target="_blank" href="https://www.cls.it/news/">News</a></li>
                <li><a name="contact" href="{{ route('contatti') }}">Contatti</a></li>
                <li>
                    @if (app()->getLocale() === 'en')
                    <a href="{{route('lang.switch', ['lang' => 'it'])}}" class="mr-5"><img src="{{ asset('site/images/flags/it.png') }}" alt=""></a>
                    @else
                    <a href="{{route('lang.switch', ['lang' => 'en'])}}"><img src="{{ asset('site/images/flags/en.png') }}" alt=""></a>
                    @endif
                </li>

                    @if(!Auth::check())
                    <li>
                        <a href="http://login.cls.it/login?sso={{  config('session.sso_token')  }}" class="flex align-center justify-center">
                            <i class="material-icons mr-5 font-20">account_box</i>
                            Login
                        </a>
                    </li>
                    @elseif(Auth::check())
                    <li>
                        <a   href="{{ route('mycatalog') }}" class="flex align-center justify-center">
                            <i class="material-icons mr-5">find_in_page</i>
                        </a>
                    </li>

                    <li class="cls-header-acc-wrapper">
                        <a target="_blank" href="http://login.cls.it/profile" class="flex align-center justify-center cls-header-acc">
                            <i class="material-icons mr-5">account_box</i>
                            {{ auth()->user()->name }} {{ auth()->user()->surname }}
                        </a>
                        <div class="cls-header-acc-dropdown flex flex-col">
                            <ul>
                                @auth
                                    <li>
                                        <a href="{{ route('myfilters') }}" class="flex align-center justify-center">
                                            <i class="material-icons mr-5">find_replace</i>
                                            {{__('Ricerche')}}
                                        </a>
                                    </li>
                                <?php

                                $role = auth()->user()->getrole();
                                if( $role[0]->id == 2 | $role[0]->id == 1 | $role[0]->id == 5 | $role[0]->id == 8){
                                    ?>
                                    <li>
                                        <a href="{{ route('myquotationsven') }}" class="flex align-center justify-center">
                                            <i class="material-icons mr-5">request_quote</i>
                                            Quotazioni
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('myoptions') }}" class="flex align-center justify-center">
                                            <i class="material-icons mr-5">request_quote</i>
                                            Opzioni
                                        </a>
                                    </li>
                                    <?php }else{ ?>
                                    <li>
                                        <a href="{{ route('richiesta') }}" class="flex align-center justify-center">
                                            <i class="material-icons mr-5">request_quote</i>
                                            Richieste
                                        </a>
                                    </li>
                                   <?php } ?>
                                @endauth


                            </ul>
                            <ul>
                                <li>
                                    {{__('Modifica profilo')}}
                                </li>
                            </ul>
                            <ul>
                                <li><a href="{{route('logout')}}">{{__('Esci dal profilo')}}</a></li>
                            </ul>

                        </div>

                    </li>

                    @endif

            </ul>
        </div>
    </div>
    <div class="main-bar bc-secondary pt-40">
        <div class="logo no-mobile mx-auto mb-40">
            <a href="{{ route('home') }}"> <img src="{{ asset('site/images/logo-usato.png') }}" alt=""></a>
        </div>
        <div class="container">
            <nav class="nav-menu">
                <ul class="font-18 md_flex justify-between pb-20 text-center">
                    <li><a href="{{route('home')}}">Listino prodotti</a></li>
                    <li><a href="{{route('allestimenti')}}">Allestimenti & garanzia</a></li>
                    <li><a href="{{ route('allbundles') }}">{{__('Offers')}}</a></li>
                    <li><a href="{{ route('valuemy') }}">{{ __('Valuta il tuo usato') }}</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>

@include('site.partiales._opziona_prodotto')
<script>
 $(document).ready(() => {
     $('.cls-header-acc-wrapper').hover(function() {
         $(this).addClass('cls-acc-active');
     }, function() {
         $(this).removeClass('cls-acc-active');
     });
 })
</script>

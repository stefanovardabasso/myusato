@extends('layouts.admin')

@section('title', $product::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => 'Modifica il Prodotto'])

    @include('partials._alerts')


    <div class="panel panel-default">
        <div class="panel-body">

            <h3>FAMIGLIA: {{$product->family}}  MARCA: {{$product->brand}} MODELLO: {{$product->model}} N.serie: {{$product->serialnum}} N.OFFERTE: {{$product->noff}} <BR>
                 STATO MACCHINA: {{$product->status}}  DATA RTC: {{$product->date_rtc}} NUMERO RTC: {{ $product->scheda }} RIF.CLS: {{$product->riferimento_cls}}  Stima Rtc: {{$rtc_valu}}</h3><BR>


                    @if(isset($product->noleggiata) && $product->noleggiata == 'X')
                        <div class="alert alert-danger" role="alert">
                            <center> Attenzione questa macchina è noleggiata  </center>
                        </div>
                    @elseif(isset($product->venduta) && $product->venduta == 'X')
                        <div class="alert alert-danger" role="alert">
                            <center>  Attenzione questa macchina è venduta  </center>
                        </div>
                    @elseif(isset($product->opzionata) && $product->opzionata == 'X')
                        <div class="alert alert-danger" role="alert">
                            <center>  Attenzione questa macchina è opzionata  </center>
                        </div>
                    @endif


                        @if($label_false != NULL)
                            <div class="alert alert-danger" role="alert">
                                <center>  Questa scheda non è modificabile in quanto le seguenti caratteristiche commerciali non sono presenti nel nostro DB.<br>
                                    Si consiglia di contattare il servizio tecnico CLS<br>
                                    {{$label_false}}</center>
                            </div>
                        @else


                            <div class="pull-left">
                            <!--    <a class="btn btn-success" href="{{ route('admin.product.importproduct', ['id'=> $product->id]) }}"> IMPORTA SCHEDA PRODOTTO DA RTC/SAP </a> -->
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-success" href="{{ route('admin.products.show', ['product'=> $product->id]) }}"> VEDI SCHEDA / OFFERTE</a>
                            </div>
                    <BR><BR>

                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="tab-default active"><a href="#it" data-toggle="tab"><i class="flag-icon flag-icon-it"></i></a></li>
                                    <li class="tab-default"><a href="#en" data-toggle="tab"><i class="flag-icon flag-icon-gb"></i></a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="it">
                                         @include('admin.products.partials._it')
                                    </div>
                                     <div class="tab-pane" id="en">
                                        @include('admin.products.partials._en')
                                    </div>

                                </div>
                            </div>






        </div>
    </div>


    @endif
    <div class="pull-right">
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">@lang('Back')</a>
    </div>



@stop


@extends('layouts.admin')

@section('title', __('Modifica la offerta'))

@section('content')
    @include('partials._content-heading', ['title' => 'Modifica la offerta'])

    @include('partials._alerts')
    {{ html()->modelForm($offert, 'PUT', route('admin.offerts.update', [$offert]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            @if($offert->type_off == 'single')
            <h3>FAMIGLIA: {{$products[0]->family}}  MARCA: {{$products[0]->brand}} MODELLO: {{$products[0]->model}} N.serie: {{$products[0]->serialnum}} N.OFFERTE: {{$products[0]->noff}} <BR>
                    STATO MACCHINA: {{$products[0]->status}}  DATA RTC: {{$products[0]->date_rtc}} NUMERO RTC: {{ $products[0]->scheda }} RIF.CLS: {{$products[0]->riferimento_cls}} Stima Rtc: {{$offert->price_rtc_co}}</h3><BR>
            @endif

            <div class="row">

                <div class="col-lg-4">
                    <h3>PUBBLICAZIONE OFFERTA @if($offert->type_off == 'Bundle') <b style="background-color: #f5f508;
border-radius: 14%;font-size: 129%;">Bundle</b>  @endif</h3>
                </div>
                <div class="col-lg-8">
                    <div class="pull-right">
                        <?php   $role = auth()->user()->getrole(); ?>
                            @if( $role[0]->id == 1)
                        <strong>STATUS
                            @if($offert->status == 0)
                                <a class="btn btn-success" style="background-color: red" href="{{route('admin.offert.changestatus',['id_offert'=>$offert->id])}}">
                                    <b style="color:white">OFF</b></a>
                            @else
                                <a class="btn btn-success" href="{{route('admin.offert.changestatus',['id_offert'=>$offert->id])}}">
                                    <b style="color:white">ON</b></a>
                            @endif  </strong>
                                @endif
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="row">



                        <div class="col-lg-4">
                            <div class="radio col-md-12 form-group ">
                                <label>
                                    <input type="radio" name="target_user" onchange="setrequf()" id="optionsRadios1" value="1" <?php if($offert->target_user == '1'){ echo 'checked'; } ?>>
                                    <strong>MYUSATO UTENTE FINALE</strong>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="radio col-md-12 form-group ">
                                <label>
                                    <input type="radio" name="target_user" onchange="setreqco()" id="optionsRadios2" value="2" <?php if($offert->target_user == '2'){ echo 'checked'; } ?>>
                                    <strong> MYUSATO COMMERCIANTE</strong>
                                </label>
                            </div>
                        </div>







                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="col-md-12 form-group ">
                                <label for="date_finish_off" class="control-label">Data fine offerta*</label>
                                <input type="date" name="date_finish_off" id="date_finish_off" value="{{$offert->date_finish_off}}" required class="form-control">
                            </div>
                        </div>
                    </div>
                  @if(count($relation_offs) < 2)
                       @if($offert->status == 1 && $offert->type_off == 'single')

                          @include('admin.offerts.partials.apisites')

                       @endif
                  @endif
                   </div>
               </div>

               <div class="row">
                   <div class="col-lg-6" >
                       <h3 style="display: inline">Prodotti associati in questa offerta </h3>

                       <button  style="display: inline" class="btn btn-primary open" type="button" data-toggle="collapse" data-close="collapseExample1" data-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample1" id="opencollapseExample1">
                           <i class="glyphicon glyphicon-plus"></i>
                       </button>
                       <button class="btn btn-primary closegroup" style="display: none"  type="button" id="closecollapseExample1" data-open="collapseExample1">
                           <span class="glyphicon glyphicon-minus"></span>
                       </button>

                   </div>

                   <div class="collapse" id="collapseExample1" >


                   <div class="col-lg-12" style="margin-top:2%">
                       @if($macus == null && $supra == null && $tuttocar == null)

                       <div class="pull-left">
                           <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">AGGIUNGI PRODOTTI A QUESTA OFFERTA</button>
                       </div>
                       <div class="pull-right">
                         <a href="{{ route('admin.offerts.edit',['offert'=>$offert->id]) }}">
                             <button type="button" class="btn btn-info"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Calcolare</button>
                         </a>
                       </div>
                       @endif
                       <BR><BR>
                               <table class="table table-hover table-condensed" id="machasoc" >
                                   <thead>
                                   <tr>
                                       <th>{{ __(' ') }}</th>
                                       <th>{{ __('Famiglia') }}</th>
                                       <th>{{ __('Marca') }}</th>
                                       <th>{{ __('Modello') }}</th>
                                       <th>{{ __('N. Serie') }}</th>
                                       <th>  </th>
                                       <th>{{ __(' ') }} </th>
                                   </tr>
                                   </thead>
                                   <tbody>
                                   <?php  if(isset($products)){ ?>
                                   <?php $a=0;  foreach ($products as $key ) { ?>
                                   <tr id="{{$relation_offs[$key->id]}}">

                                       <td> </td>
                                       <td>{{ $key->family }}</td>
                                       <td>{{ $key->brand }}</td>
                                       <td>{{ $key->model }}</td>
                                       <td>{{ $key->serialnum }}</td>
                                       <td>{{ $key->rifcls }}</td>
                                       <td>
                                          <?php if($a>0){ ?>
                                           <button type="button" data-idrelationbu="{{$relation_offs[$key->id]}}" class="btn btn-danger deleterelation"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                                            <?php } ?>
                                       </td>

                                   </tr>
                                   <?php $a++; } } ?>


                                   </tbody>


                               </table>
                   </div>
                   </div>

               </div>
               <hr style="border: 1px solid;margin-top: 1%;margin-bottom: 1%">

               <div class="row">
                   <div class="col-lg-6" >
                       <h3 style="display: inline">OFFERTA COMMERCIANTE</h3>
                       <button  style="display: inline" class="btn btn-primary open" type="button" data-toggle="collapse" data-close="collapseExample2" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2" id="opencollapseExample2">
                           <i class="glyphicon glyphicon-plus"></i>
                       </button>
                       <button class="btn btn-primary closegroup" style="display: none"  type="button" id="closecollapseExample2" data-open="collapseExample2">
                           <span class="glyphicon glyphicon-minus"></span>
                       </button>

                   </div>

                   <div class="collapse" id="collapseExample2" >

                       <div class="col-lg-12">
                           <div class="row" style="margin-top: 1%">

                               <div class="col-lg-4">
                                   <input type="hidden" value="{{request()->get('idproduct')}}" name="id_product">
                                   <input type="hidden" value=" {{ Auth::user()->email }} " name="createdby">
                                   @include('partials.inputs._text', ['name' => 'title_1_co', 'label' => 'Titolo TAG#1'.'*'])
                               </div>
                               <div class="col-lg-4">
                                   @include('partials.inputs._text', ['name' => 'title_2_co', 'label' => 'Titolo TAG#2'.'*'])
                               </div>
                               <div class="col-lg-4">
                                   @include('partials.inputs._text', ['name' => 'title_3_co', 'label' => 'Titolo TAG#3'.'*'])
                               </div>
                           </div>
                       </div>

                       <div class="row">
                           <div class="col-lg-12" style="margin-top:2%;">
                               <h3 style="margin-left: 1%; display: inline">Gallery offerta</h3>

                               <button  style="display: inline" class="btn btn-primary open" type="button" data-toggle="collapse" data-close="galleryco" data-target="#galleryco" aria-expanded="false" aria-controls="galleryco" id="opengalleryco">
                                   <i class="glyphicon glyphicon-plus"></i>
                               </button>
                               <button class="btn btn-primary closegroup" style="display: none"  type="button" data-open="galleryco" id="closegalleryco">
                                   <span class="glyphicon glyphicon-minus"></span>
                               </button>

                           </div>

                           <div class="collapse" id="galleryco">


                               <div class="col-lg-10">

                               <Center> <a class="btn btn-primary" href="{{route('admin.offert.setordersgal',['offertid'=> $offert->id, 'target' => 2 ])}}">Ordina</a></Center>

                                   <div class="row" id="imgas_co">
{{--                                       <div class="col-lg-2" style="margin-top:2%;margin-left: 2%;">--}}
{{--                                           <a href="#" data-toggle="modal" onclick="functionimg(1)" data-target="#exampleModal"> <img src="https://faculty.iiit.ac.in/~indranil.chakrabarty/images/empty.png" style="width: 150px;--}}
{{--       height: 150px;  border: 3px solid #00a65a;">--}}
{{--                                           </a>--}}
{{--                                       </div>--}}
                                       <div class="col-lg-2" style="margin-top:2%;margin-left: 2%">
                                           <a href="#" data-toggle="modal" onclick="functionimg(2)" data-typeoffert="CO" data-target="#exampleModal"> <img src="https://faculty.iiit.ac.in/~indranil.chakrabarty/images/empty.png" style="width: 150px;
       height: 150px;  border: 3px solid black;">
                                           </a>
                                       </div>
                                       @if(isset($gallery))
                                           @foreach($gallery as $key)
                                               @if($key->type == 'CO')
                                                   @if($key->name != 'empty.png')
                                                       @if($key->position != '1')
                                                           <div class="col-lg-2" style="margin-top:2%" id="img{{$key->id}}">

                                                               <button onclick="deleteimage({{$key->id}})" class="delete-file"   style="background: rgb(255, 4, 4);padding: 0.09rem 0.25em 0px;text-align: center;
                                  border-radius: 50%;z-index: 199;color: rgb(255, 255, 255);"><i class="glyphicon glyphicon-remove"></i></button>

                                                               <img src="<?php echo config('app.url').'/upload/'.$key->name; ?>" alt="" style=" width: 150px;
       height: 150px; border: 3px solid black;">

                                                           </div>
                                                       @else
                                                           <div class="col-lg-2" style="margin-top:2%">

                                                               <img  src="<?php echo config('app.url').'/upload/'.$key->name; ?>" alt="" style=" width: 150px;
       height: 150px; border: 3px solid #00a65a;">

                                                           </div>
                                                       @endif
                                                   @endif
                                               @endif
                                           @endforeach
                                       @endif
                                   </div>
                               </div>
                           </div>

                       </div>

                       <div class="col-lg-12" style="margin-top: 1%">
                           <div class="row">
                               <div class="col-lg-4">
                                   @include('partials.inputs._textarea', ['name' => 'desc_it_co', 'label' => 'Descrizione offerta IT'.'*'])
                               </div>
                               <div class="col-lg-4">
                                   @include('partials.inputs._textarea', ['name' => 'desc_en_co', 'label' => 'Descrizione offerta EN'.'*'])
                               </div>

                           </div>
                       </div>
                       <div class="col-lg-10">
                           <div class="row" style="margin-top: 2%">
                               <div class="col-lg-3">
                                   <div class="col-md-12 form-group ">
                                       <label for="price_rtc_co" class="control-label">Costo trasporto*</label>
                                       <input name="cost_trasp_co" type="number" id="cost_trasp_co" class="form-control" value="{{$offert->cost_trasp_co}}" onchange="myFunction_co()">
                                   </div>
                               </div>
                               <div class="col-lg-3">
                                   @include('partials.inputs._text', ['name' => 'price_rtc_co', 'label' => 'Stima Rtc'.'*', 'readonly' => true])
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-lg-3">
                                   <div class="col-md-12 form-group ">
                                       <label for="ol_prevision_co" class="control-label">Ol previsione</label>
                                       <input name="ol_prevision_co" type="number" id="ol_prevision_co" class="form-control" value="{{$offert->ol_prevision_co}}" onchange="myFunction_co()">
                                   </div>
                               </div>
                               <div class="col-lg-3">
                                   @include('partials.inputs._text', ['name' => 'payed_client_co', 'label' => 'Pagato cliente'.'*', 'readonly' => true])
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-lg-5">
                                   @include('partials.inputs._text', ['name' => 'ol_def_co', 'label' => 'Ol definitivo'.'*', 'readonly' => true])
                               </div>
                               <div class="col-lg-5">
                                   @include('partials.inputs._text', ['name' => 'over_allowance_co', 'label' => 'Overallowance'.'*', 'readonly' => true])
                               </div>
                           </div>

                       </div>
                       <div class="col-lg-12">
                           <div class="row" style="margin: 3%">

                               <div class="col-lg-4">
                                   <h3 style="display: inline">{{ __('Componenti') }}</h3>
                                   <button  style="display: inline" class="btn btn-primary open" type="button" data-toggle="collapse" data-close="componentesco" data-target="#componentesco" aria-expanded="false" aria-controls="collapseExample3" id="opencomponentesco">
                                       <i class="glyphicon glyphicon-plus"></i>
                                   </button>
                                   <button class="btn btn-primary closegroup" style="display: none"  type="button" data-open="componentesco" id="closecomponentesco">
                                       <span class="glyphicon glyphicon-minus"></span>
                                   </button>
                               </div>


                               <div class="collapse" id="componentesco">

                                   <div class="col-lg-12">
                                       <table class="table table-hover table-condensed"  id='filterTable_co'>
                                           <thead>
                                           <tr>
                                               <th>{{ __('Patita') }}</th>
                                               <th>{{ __('Tipo') }}</th>
                                               <th>{{ __('Materiale') }}</th>
                                               <th>{{ __('Valore') }}</th>
                                           </tr>
                                           </thead>
                                           <tbody>
                                           <tr>
                                               <td>
                                                   <input class="form-control" id="partita_co">
                                               </td>
                                               <td>
                                                   <input class="form-control" id="type_co">
                                               </td>
                                               <td>
                                                   <input class="form-control" id="material_co">
                                               </td>
                                               <td>
                                                   <input class="form-control" id="value_co" type="number">
                                               </td>
                                               <td><input type='button' value='Aggiungi' class='btn btn-success addfilter' data-type="CO"></td>
                                           </tr>

                                           </tbody>

                                       </table>
                                       <div class="col-lg-10">
                                           <div class="pull-right">
                                               <div class="row">
                                                   <div class="col-lg-3">
                                                       <h5>TOTALE</h5>
                                                   </div>
                                                   <div class="col-lg-7">
                                                       <input class="form-control" id="total_at_co" readonly>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>


                                   </div>
                               </div>
                           </div>
                       </div>

                       <div class="col-lg-10">
                           <div class="row" style="margin-top: 2%">
                               <div class="col-lg-3">
                                   @include('partials.inputs._text', ['name' => 'value_tt_co', 'label' => 'Valore Totale carrello'.'*', 'readonly' => true])
                               </div>
                               <div class="col-lg-3">
                                   @include('partials.inputs._text', ['name' => 'gp_ob_co', 'label' => 'Gp Obiettivo'.'*' , 'readonly' => true])
                               </div>
                               <div class="col-lg-3">
                                   @include('partials.inputs._text', ['name' => 'disc_ob_co', 'label' => 'Sconto Obiettivo'.'*', 'readonly' => true])
                               </div>
                           </div>


                           <div class="row">
                               <div class="col-lg-4">
                                   @include('partials.inputs._text', ['name' => 'calculated_price_co', 'label' => 'Prezzo Calcolato'.'*', 'readonly' => true])
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-lg-4">

                                   <div class="col-md-12 form-group ">
                                       <label for="min_price_co" class="control-label">Prezzo minimo di vendita*</label>
                                       <input name="min_price_co" type="number" id="min_price_co" class="form-control" value="{{$offert->min_price_co}}" onchange="myFunction_co()">
                                   </div>

                               </div>
                           </div>
                           <div class="row">
                               <div class="col-lg-4">
                                   @include('partials.inputs._text', ['name' => 'gp_effective_co', 'label' => 'Gp effettivo'.'*' , 'readonly' => true])
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-lg-4">
                                   @include('partials.inputs._text', ['name' => 'list_price_co', 'label' => 'Prezzo di listino'.'*' , 'readonly' => true])
                               </div>
                               <div class="col-lg-4">
   {{--                                @include('partials.inputs._text', ['name' => 'new_list_price_co', 'label' => 'Prezzo scontato'.'*'])--}}
                                   <div class="col-md-12 form-group ">
                                       <label for="new_list_price_co" class="control-label">Prezzo scontato*</label>
                                       <input type="number" name="new_list_price_co" id="new_list_price_co" value="" class="form-control">
                                   </div>
                               </div>
                           </div>
                       </div>

                   </div>

               </div>
               <hr style="border: 1px solid;margin-top: 1%;margin-bottom: 1%">

               <div class="row">
                   <div class="col-lg-6" >
                       <h3 style="display: inline">OFFERTA UTENTE FINALE </h3>
                       <button  style="display: inline" class="btn btn-primary open" type="button" data-toggle="collapse" data-close="collapseExample3" data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample3" id="opencollapseExample3">
                           <i class="glyphicon glyphicon-plus"></i>
                       </button>
                       <button class="btn btn-primary closegroup" style="display: none"  type="button" id="closecollapseExample3" data-open="collapseExample3" id="closecollapseExample3">
                           <span class="glyphicon glyphicon-minus"></span>
                       </button>

                   </div>

                   <div class="collapse" id="collapseExample3" >

                       <div class="col-lg-12">
                           <div class="row" style="margin-top: 1%">

                               <div class="col-lg-4">
                                   <input type="hidden" value="{{request()->get('idproduct')}}" name="id_product">
                                   <input type="hidden" value=" {{ Auth::user()->email }} " name="createdby">

                                   @include('partials.inputs._text', ['name' => 'title_1_uf', 'label' => 'Titolo TAG#1'.'*'])
                               </div>
                               <div class="col-lg-4">
                                   @include('partials.inputs._text', ['name' => 'title_2_uf', 'label' => 'Titolo TAG#2'.'*'])
                               </div>
                               <div class="col-lg-4">
                                   @include('partials.inputs._text', ['name' => 'title_3_uf', 'label' => 'Titolo TAG#3'.'*'])
                               </div>
                           </div>
                       </div>

                       <div class="row">
                           <div class="col-lg-12" style="margin-top:2%;">
                               <h3 style="margin-left: 1%; display: inline">Gallery offerta</h3>
                               <button  style="display: inline" class="btn btn-primary open" type="button" data-toggle="collapse" data-close="galleryuf" data-target="#galleryuf" aria-expanded="false" aria-controls="galleryuf" id="opengalleryuf">
                                   <i class="glyphicon glyphicon-plus"></i>
                               </button>
                               <button class="btn btn-primary closegroup" style="display: none"  type="button" data-open="galleryuf" id="closegalleryuf">
                                   <span class="glyphicon glyphicon-minus"></span>
                               </button>
                           </div>

                           <div class="collapse" id="galleryuf">


                                   <div class="col-lg-10">
                                       <Center> <a class="btn btn-primary" href="{{route('admin.offert.setordersgal',['offertid'=> $offert->id, 'target' => 1 ])}}">Ordina</a></Center>
                                       <div class="row" id="imgas_uf">
{{--                                           <div class="col-lg-2" style="margin-top:2%;margin-left: 2%;">--}}
{{--                                               <a href="#" data-toggle="modal" onclick="functionimg(3)"  data-target="#exampleModal"> <img src="https://faculty.iiit.ac.in/~indranil.chakrabarty/images/empty.png" style="width: 150px;--}}
{{--       height: 150px;  border: 3px solid #00a65a;">--}}
{{--                                               </a>--}}
{{--                                           </div>--}}
                                           <div class="col-lg-2" style="margin-top:2%;margin-left: 2%">
                                               <a href="#" data-toggle="modal" onclick="functionimg(4)"  data-target="#exampleModal"> <img src="https://faculty.iiit.ac.in/~indranil.chakrabarty/images/empty.png" style="width: 150px;
       height: 150px;  border: 3px solid black;">
                                               </a>
                                           </div>

                                           @if(isset($gallery))
                                               @foreach($gallery as $key)
                                                   @if($key->type == 'UF')
                                                       @if($key->name != 'empty.png')
                                                           @if($key->position != '1')
                                                           <div class="col-lg-2" style="margin-top:2%" id="img{{$key->id}}">
                                  <button onclick="deleteimage({{$key->id}})" class="delete-file"   style="background: rgb(255, 4, 4);padding: 0.09rem 0.25em 0px;text-align: center;
                                  border-radius: 50%;z-index: 199;color: rgb(255, 255, 255);"><i class="glyphicon glyphicon-remove"></i></button>

                                                               <img src="<?php echo config('app.url').'/upload/'.$key->name; ?>" alt="" style=" width: 150px;
       height: 150px; border: 3px solid black;">
                                                   </div>
                                                           @else
                                                               <div class="col-lg-2" style="margin-top:2%">
                                                                   <img src="<?php echo config('app.url').'/upload/'.$key->name; ?>" alt="" style=" width: 150px;
       height: 150px; border: 3px solid #00a65a;">
                                                               </div>
                                                           @endif
                                                       @endif
                                                   @endif
                                               @endforeach
                                           @endif
                                       </div>
                                   </div>
                               </div>

                       </div>

                       <div class="col-lg-12" style="margin-top: 1%">
                           <div class="row">
                               <div class="col-lg-4">
                                   @include('partials.inputs._textarea', ['name' => 'desc_it_uf', 'label' => 'Descrizione offerta IT'.'*'])
                               </div>
                               <div class="col-lg-4">
                                   @include('partials.inputs._textarea', ['name' => 'desc_en_uf', 'label' => 'Descrizione offerta EN'.'*'])
                               </div>

                           </div>
                       </div>
                       <div class="col-lg-10">
                           <div class="row" style="margin-top: 2%">
                               <div class="col-lg-3">
                                   <div class="col-md-12 form-group ">
                                       <label for="price_rtc_uf" class="control-label">Costo trasporto*</label>
                                       <input name="cost_trasp_uf" type="number" id="cost_trasp_uf" class="form-control" value="{{$offert->cost_trasp_uf}}" onchange="myFunction_uf()">
                                   </div>
                               </div>
                               <div class="col-lg-3">
                                   @include('partials.inputs._text', ['name' => 'price_rtc_uf', 'label' => 'Stima Rtc'.'*', 'readonly' => true])
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-lg-3">
                                   <div class="col-md-12 form-group ">
                                   <label for="ol_prevision_uf" class="control-label">Ol previsione *</label>
                                   <input name="ol_prevision_uf" type="number" id="ol_prevision_uf" class="form-control" value="{{$offert->ol_prevision_uf}}" onchange="myFunction_uf()">
                               </div>
                               </div>
                               <div class="col-lg-3">
                                   @include('partials.inputs._text', ['name' => 'payed_client_uf', 'label' => 'Pagato cliente'.'*', 'readonly' => true])
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-lg-5">
                                   @include('partials.inputs._text', ['name' => 'ol_def_uf', 'label' => 'Ol definitivo'.'*', 'readonly' => true])
                               </div>
                               <div class="col-lg-5">
                                   @include('partials.inputs._text', ['name' => 'over_allowance_uf', 'label' => 'Overallowance'.'*', 'readonly' => true])
                               </div>
                           </div>

                       </div>
                       <div class="col-lg-12">
                          <div class="row" style="margin: 3%">

                               <div class="col-lg-4">
                                   <h3 style="display: inline">{{ __('Componenti') }}</h3>
                                   <button  style="display: inline" class="btn btn-primary open" type="button" data-toggle="collapse" data-close="componentesuf" data-target="#componentesuf" aria-expanded="false" aria-controls="collapseExample3" id="opencomponentesuf">
                                       <i class="glyphicon glyphicon-plus"></i>
                                   </button>
                                   <button class="btn btn-primary closegroup" style="display: none"  type="button" data-open="componentesuf" id="closecomponentesuf">
                                       <span class="glyphicon glyphicon-minus"></span>
                                   </button>
                               </div>


                               <div class="collapse" id="componentesuf">

                                   <div class="col-lg-12">
                                       <table class="table table-hover table-condensed"  id='filterTable_uf'>
                                           <thead>
                                           <tr>
                                               <th>{{ __('Patita') }}</th>
                                               <th>{{ __('Tipo') }}</th>
                                               <th>{{ __('Materiale') }}</th>
                                               <th>{{ __('Valore') }}</th>
                                           </tr>
                                           </thead>
                                           <tbody>
                                           <tr>
                                               <td>
                                                   <input class="form-control" id="partita_uf">
                                               </td>
                                               <td>
                                                   <input class="form-control" id="type_uf">
                                               </td>
                                               <td>
                                                   <input class="form-control" id="material_uf">
                                               </td>
                                               <td>
                                                   <input class="form-control" id="value_uf" type="number">
                                               </td>
                                               <td><input type='button' value='Aggiungi' class='btn btn-success addfilter' data-type="UF"  ></td>
                                           </tr>



                                           </tbody>
                                       </table>
                                       <div class="col-lg-10">
                                           <div class="pull-right">
                                               <div class="row">
                                                   <div class="col-lg-3">
                                                       <h5>TOTALE</h5>
                                                   </div>
                                                   <div class="col-lg-7">
                                                       <input class="form-control" type="number" onchange="myFunction_uf()" id="total_at_uf" value="" readonly>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="col-lg-10">
                           <div class="row" style="margin-top: 2%">
                               <div class="col-lg-3">
                                   @include('partials.inputs._text', ['name' => 'value_tt_uf', 'label' => 'Valore Totale carrello'.'*', 'readonly' => true])
                               </div>
                               <div class="col-lg-3">
                                   @include('partials.inputs._text', ['name' => 'gp_ob_uf', 'label' => 'Gp Obiettivo'.'*' , 'readonly' => true])
                               </div>
                               <div class="col-lg-3">
                                   @include('partials.inputs._text', ['name' => 'disc_ob_uf', 'label' => 'Sconto Obiettivo'.'*', 'readonly' => true])
                               </div>
                           </div>


                           <div class="row">
                               <div class="col-lg-4">
                                   @include('partials.inputs._text', ['name' => 'calculated_price_uf', 'label' => 'Prezzo Calcolato'.'*', 'readonly' => true])
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-lg-4">

                                       <div class="col-md-12 form-group ">
                                           <label for="min_price_uf" class="control-label">Prezzo minimo di vendita*</label>
                                           <input name="min_price_uf" type="number" id="min_price_uf" class="form-control" value="{{$offert->min_price_uf}}" onchange="myFunction_uf()">
                                       </div>

                               </div>
                           </div>
                           <div class="row">
                               <div class="col-lg-4">
                                   @include('partials.inputs._text', ['name' => 'gp_effective_uf', 'label' => 'Gp effettivo'.'*' , 'readonly' => true])
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-lg-4">
                                   @include('partials.inputs._text', ['name' => 'list_price_uf', 'label' => 'Prezzo di listino'.'*' , 'readonly' => true])
                               </div>
                               <div class="col-lg-4">
                                   <div class="col-md-12 form-group ">
                                       <label for="new_list_price_co" class="control-label">Prezzo scontato*</label>
                                       <input type="number" name="new_list_price_co" id="new_list_price_co" value="" class="form-control">
                                   </div>
   {{--                                @include('partials.inputs._text', ['name' => 'new_list_price_uf', 'label' => 'Prezzo scontato'.'*'])--}}
                               </div>
                           </div>
                       </div>

                   </div>



               </div>







           </div>
       </div>

       <div class="pull-left">
           {{ html()->submit(__('Save'))->class('btn btn-success') }}
       </div>

       <div class="pull-right">
           <a href="{{  URL::previous() }}" class="btn btn-primary">@lang('Back')</a>
       </div>
       {{ html()->form()->close() }}







   <div id="myModal" class="modal fade" role="dialog" >
     <div class="modal-dialog" style="width: 90%">

       <!-- Modal content-->
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title"  >Elenco di tutti i prodotti</h4> <BR>  <p>Seleziona le macchine che desideri aggiungere a questa offerta.</p>
         </div>
         <div class="modal-body">
            <table class="table table-hover table-condensed" id="pas">
                                               <thead>
                                               <tr>
                                                   <th> </th>
                                                   <th>{{ __('Famiglia') }}</th>
                                                   <th>{{ __('Marca') }}</th>
                                                   <th>{{ __('Modello') }}</th>
                                                   <th>{{ __('N.serie') }}</th>
                                                   <th>{{ __('Target') }}</th>
                                                   <th>{{ __('UF price') }}</th>
                                                   <th>{{ __('CO price') }}</th>
                                               </tr>
                                               </thead>



                       </table>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>

     </div>
   </div>
       <script type="text/javascript">

           $(document).on("click", ".deleterelation" , function() {
               var delete_id = $(this).data('idrelationbu');
               var el = this;
               $(el).closest( "tr" ).remove();
               $.ajax({
                   url: "{{ url('api/deleterelation') }}?id="+delete_id,
                   type: 'get',
                   success: function(response){
                       $(el).closest( "tr" ).remove();

                   }

               });
           });



           $(document).ready(function() {
               $('.closegroup').click(function(){
                   var target = $(this).data('open');
                   $("#open"+target).show();
                   $(this).hide();
                   $("#"+target).removeClass("in");
               })
               $('.open').click(function(){
                   var target = $(this).data('close');
                   $("#close"+target).show();
                   $(this).hide();
               })
               var table = $('#pas').DataTable( {
                   //"language": { "url": "lang.json" },
                   "processing": true,
                   "serverSide": true,
                   "initComplete": function(settings, json) {
                        $('.macchina').click(function(){
                           var macchina = $(this).data('idmacchina');
                            var famiglia = $(this).data('famiglia');
                            var marca = $(this).data('marca');
                            var model = $(this).data('model');
                            var serialnumber = $(this).data('serialnumber');
                            var target = $(this).data('target');
                           $.ajax({
                               url: "{{ route('admin.offert.addtooffert',['id_offert'=>$offert->id]) }}",
                               type: 'post',
                               data: {macchina: macchina},
                               headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               },
                               success: function(response){

                                   if(response > 0){
                                       var id = response;



                                           var tr_str = "<tr style='background-color: #00e765'>" +
                                               "<td> </td>" +
                                               "<td>" + famiglia + "</td>" +
                                               "<td>" + marca + "</td>" +
                                               "<td>" + model + "</td>" +
                                               "<td>" + serialnumber + "</td>" +
                                               "<td> </td>" +
                                               " <td></td>"+
                                               "</tr>";


                                           $("#machasoc tbody").append(tr_str);


                                           /*-----------------------------------------*/


                                   }else{
                                       alert(response);
                                   }






                               }
                           });
                       });

                   },
                   "ajax": "{{ route('admin.product.datatableoff',['id_offert'=>$offert->id]) }}",

                   "columns": [
                       {data: 'action', name: 'action'},
                       {data: 'family', name: 'family'},
                       {data: 'brand', name: 'brand'},
                       {data: 'model', name: 'model'},
                       {data: 'serialnum', name: 'serialnum'},
                       {data: 'target_user', name: 'target_user'},
                       {data: 'list_price_uf', name: 'list_price_uf'},
                       {data: 'list_price_co', name: 'list_price_co'},

                   ],

                   "order": [[1, 'asc']]
               } );



           } );

       </script>
       <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">

                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">

                       <div class="form-group">
                           <label class="col-md-2 control-label" for="filebutton">{{ __('Immagine') }}</label>
                           <div class="col-md-8">
                               <label>Seleziona un'immagine</label>
                               <input type="file" name="file" id="file" />
                               <input type="hidden" id="lavel" value="">
                               <br />
                               <span id="uploaded_image"></span>
                           </div>
                       </div>


                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                   </div>
               </div>
           </div>
       </div>



       <script>
           function functionimg(pos){
               var position = pos;
               document.getElementById("lavel").value =  pos ;
               //console.log(position);
              // alert(position);
           }


           $(document).ready(function(){
               $(document).on('change', '#file', function(){
                   var position = document.getElementById("lavel").value;
                   var name = document.getElementById("file").files[0].name;
                   var form_data = new FormData();
                   var ext = name.split('.').pop().toLowerCase();
                   if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
                   {
                       alert("Invalid Image File");
                   }
                   var oFReader = new FileReader();
                   oFReader.readAsDataURL(document.getElementById("file").files[0]);
                   var f = document.getElementById("file").files[0];
                   var fsize = f.size||f.fileSize;
                   if(fsize > 2000000)
                   {
                       alert("Image File Size is very big");
                   }
                   else
                   {
                       form_data.append("file", document.getElementById('file').files[0]);
                       form_data.append("position", position);
                       $.ajax({
                            url:"{{ route('admin.offert.uploadimage',['id'=> $offert->id]) }}",
                           method:"POST",
                           data: form_data,
                           contentType: false,
                           cache: false,
                           processData: false,
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           beforeSend:function(){
                               $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
                           },
                           success:function(data)
                           {
                               $('#uploaded_image').html(data);
                               $('#myTest').css('color', '#0037ff');
                             if(position == '1' || position == '2'){
                                 $("#imgas_co").append(data);
                             }else{
                                 $("#imgas_uf").append(data);
                             }

                           }
                       });
                   }
               });
           });
           function deleteimage(id) {
               var idimage = id;
               $("#img"+idimage).remove();
               $.ajax({
                   url: "{{ url('api/deleteimage') }}?id="+idimage,
                   type: 'get',
                   success: function(response){

                   }

               });
           }
       </script>
       <script type='text/javascript'>
           var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

           $(document).ready(function(){

               // Fetch records
               fetchRecordsfilters_co();
               fetchRecordsfilters_uf();

               // Add record
               $('.addfilter').click(function(){

                   var type_off = $(this).data('type');

                   if(type_off == 'CO'){
                       var fill_code = $('#partita_co').val();
                       var fill_type = $('#type_co').val();
                       var fill_material = $('#material_co').val();
                       var fill_value =  $('#value_co').val();
                   }else{
                       var fill_code = $('#partita_uf').val();
                       var fill_type = $('#type_uf').val();
                       var fill_material = $('#material_uf').val();
                       var fill_value =  $('#value_uf').val();
                   }


                  //alert(fill_code+' '+fill_type+' '+fill_material+' '+fill_value);


                   if(fill_code != '' && fill_type != '' && fill_material != '' && fill_value != ''){
                       $.ajax({
                           url: "{{ url('api/addcomponents') }}?offert_id={{$offert->id}}",
                           type: 'post',
                           data: {_token: CSRF_TOKEN,fill_code: fill_code,fill_type: fill_type,fill_material: fill_material,fill_value: fill_value,type_off:type_off},
                           success: function(response){

                               if(response > 0){
                                   var id = response;

                                   if(type_off == 'CO'){
                                      /*-----------------------------------------*/
                                       var findnorecord = $('#filterTable_co tr.norecord').length;

                                       if(findnorecord > 0){
                                           $('#filterTable_co tr.norecord').remove();
                                       }
                                       fetchRecordsfilters_co();
                                       var tr_str = "<tr style='background-color: #00e765'>" +
                                           "<td align='center'><input class='form-control' type='text' value='" + fill_code + "' id='slot_type_"+id+"' disabled></td>" +
                                           "<td align='center'><input class='form-control' type='text' value='" + fill_type + "' id='slot_type_"+id+"' disabled></td>" +
                                           "<td align='center'><input class='form-control' type='text' value='" + fill_material + "' id='slot_type_"+id+"' disabled></td>" +
                                           "<td align='center'><input class='form-control' type='text' value='" + fill_value + "' id='slot_type_"+id+"' disabled></td>" +
                                           " <td align='center'><input type='button' data-typedelete='CO' value='Elimina' class='btn btn-danger deletefilter' data-id='"+id+"' ></td>"+
                                           "</tr>";


                                       $("#filterTable_co tbody").append(tr_str);


                                   /*-----------------------------------------*/
                                   }else{
                                   /*-----------------------------------------*/
                                   var findnorecord = $('#filterTable_uf tr.norecord').length;

                                   if(findnorecord > 0){
                                       $('#filterTable_uf tr.norecord').remove();
                                   }
                                       fetchRecordsfilters_uf();
                                   var tr_str = "<tr style='background-color: #00e765'>" +
                                       "<td align='center'><input class='form-control' type='text' value='" + fill_code + "' id='slot_type_"+id+"' disabled></td>" +
                                       "<td align='center'><input class='form-control' type='text' value='" + fill_type + "' id='slot_type_"+id+"' disabled></td>" +
                                       "<td align='center'><input class='form-control' type='text' value='" + fill_material + "' id='slot_type_"+id+"' disabled></td>" +
                                       "<td align='center'><input class='form-control' type='text' value='" + fill_value + "' id='slot_type_"+id+"' disabled></td>" +
                                       " <td align='center'><input type='button' data-typedelete='UF' value='Elimina' class='btn btn-danger deletefilter' data-id='"+id+"' ></td>"+
                                       "</tr>";


                                   $("#filterTable_uf tbody").append(tr_str);


                               /*-----------------------------------------*/
                                   }
                               }else if(response == 0){
                                   alert('Username already in use.');
                               }else{
                                   alert(response);
                               }


                               if(type_off == 'CO'){
                                   $('#partita_co').val('');
                                    $('#type_co').val('');
                                    $('#material_co').val('');
                                    $('#value_co').val('');
                               }else{
                                    $('#partita_uf').val('');
                                   $('#type_uf').val('');
                                    $('#material_uf').val('');
                                   $('#value_uf').val('');
                               }



                           }
                       });
                   }else{
                       alert('Fill all fields');
                   }
               });

           });




           // Delete record
           $(document).on("click", ".deletefilter" , function() {
               var delete_id = $(this).data('id');
               var deletetype = $(this).data('typedelete');
               var el = this;
               $(el).closest( "tr" ).remove();
               $.ajax({
                   url: "{{ url('api/deletecomponents') }}?id="+delete_id,
                   type: 'get',
                   success: function(response){
                       $(el).closest( "tr" ).remove();
                       //alert(response);
                       if(deletetype == 'CO'){
                           fetchRecordsfilters_co();
                           myFunction_co();
                       }else{
                           fetchRecordsfilters_uf();
                           myFunction_uf();
                       }
                   }

               });
           });

           // Fetch records
           function fetchRecordsfilters_co(){
               $.ajax({
                   url: "{{ url('api/getcomponents') }}?type=CO&offert_id={{$offert->id}}",
                   type: 'get',
                   dataType: 'json',
                   success: function(response){

                       var len = 0;
                       $('#filterTable_co tbody tr:not(:first)').empty(); // Empty <tbody>
                       if(response['data'] != null){
                           len = response['data'].length;
                           var total_at = response['data']['total'];
                           var total_at = response['val'];
                           //alert(total_at);
                           //$("#total_at_co").append(tr_str);
                           document.getElementById("total_at_co").setAttribute('value', total_at);
                           myFunction_co();
                       }

                       if(len > 0){
                           for(var i=0; i<len; i++){

                               var id = response['data'][i].id;
                               var fill_code = response['data'][i].code;
                               var fill_type = response['data'][i].type;
                               var fill_material = response['data'][i].material;
                               var fill_value = response['data'][i].value;

                               var tr_str = "<tr>" +
                                   "<td align='center'><input class='form-control' type='text' value='" + fill_code + "' id='slot_type_"+id+"' disabled></td>" +
                                   "<td align='center'><input class='form-control' type='text' value='" + fill_type + "' id='slot_type_"+id+"' disabled></td>" +
                                   "<td align='center'><input class='form-control' type='text' value='" + fill_material + "' id='slot_type_"+id+"' disabled></td>" +
                                   "<td align='center'><input class='form-control' type='text' value='" + fill_value + "' id='slot_type_"+id+"' disabled></td>" +
                                   " <td align='center'><input type='button' data-typedelete='CO' value='Elimina' class='btn btn-danger deletefilter' data-id='"+id+"' ></td>"+
                                   "</tr>";


                               $("#filterTable_co tbody").append(tr_str);

                           }
                       }else{
                           var tr_str = "<tr class='norecord'>" +
                               "<td align='center' colspan='4'>No record found.</td>" +
                               "</tr>";

                           $("#filterTable_co tbody").append(tr_str);
                       }

                   }
               });
           }
           function fetchRecordsfilters_uf(){
               $.ajax({
                   url: "{{ url('api/getcomponents') }}?type=UF&offert_id={{$offert->id}}",
                   type: 'get',
                   dataType: 'json',
                   success: function(response){

                       var len = 0;
                       $('#filterTable_uf tbody tr:not(:first)').empty(); // Empty <tbody>
                       if(response['data'] != null){
                           len = response['data'].length;
                           var total_at = response['val'];
                            //alert(total_at);
                           //$("#total_at_co").append(tr_str);
                           document.getElementById("total_at_uf").setAttribute('value', total_at);
                           myFunction_uf();
                       }

                       if(len > 0){
                           for(var i=0; i<len; i++){

                               var id = response['data'][i].id;
                               var fill_code = response['data'][i].code;
                               var fill_type = response['data'][i].type;
                               var fill_material = response['data'][i].material;
                               var fill_value = response['data'][i].value;

                               var tr_str = "<tr>" +
                                   "<td align='center'><input class='form-control' type='text' value='" + fill_code + "' id='slot_type_"+id+"' disabled></td>" +
                                   "<td align='center'><input class='form-control' type='text' value='" + fill_type + "' id='slot_type_"+id+"' disabled></td>" +
                                   "<td align='center'><input class='form-control' type='text' value='" + fill_material + "' id='slot_type_"+id+"' disabled></td>" +
                                   "<td align='center'><input class='form-control' type='text' value='" + fill_value + "' id='slot_type_"+id+"' disabled></td>" +
                                   " <td align='center'><input type='button' data-typedelete='UF' value='Elimina' class='btn btn-danger deletefilter' data-id='"+id+"' ></td>"+
                                   "</tr>";


                               $("#filterTable_uf tbody").append(tr_str);

                           }
                       }else{
                           var tr_str = "<tr class='norecord'>" +
                               "<td align='center' colspan='4'>No record found.</td>" +
                               "</tr>";

                           $("#filterTable tbody").append(tr_str);
                       }

                   }
               });
           }

           function myFunction_uf() {
               var total_at_uf = document.getElementById("total_at_uf").value;
               var price_rtc_uf = document.getElementById("price_rtc_uf").value;
               var ol_prevision_uf = document.getElementById("ol_prevision_uf").value;
               var ol_def_uf = document.getElementById("ol_def_uf").value;
               var cost_trasp_uf = document.getElementById("cost_trasp_uf").value;
               var min_price_uf = document.getElementById("min_price_uf").value;
               var gp_ob_uf = document.getElementById("gp_ob_uf").value;
               var disc_ob_uf = document.getElementById("disc_ob_uf").value;
               var val = 0;

               if(Number(ol_def_uf) === 0){
                   val = ol_prevision_uf ;

               }else{
                   val = ol_def_uf;

               }
                /*--------------VALORE TT UF-----------------*/
               var x =0;
               var x = Number(price_rtc_uf)+Number(val)+Number(cost_trasp_uf)+Number(total_at_uf);
               document.getElementById("value_tt_uf").value =   x.toFixed(2);
               /*-------------PREZZO CALCOLATO UTILIZZATORE FINAL-----------------*/
               var calculated_price_uf = 0 ;
               calculated_price_uf = Number(x)/(Number(1)-(Number(gp_ob_uf)/100));
               document.getElementById("calculated_price_uf").value =   calculated_price_uf.toFixed(2);
               /*-------------GP EFFETTIVO UTILIZZATORE FINALE-----------------*/
               var gp_effective_uf = 0 ;
               gp_effective_uf =  100-(((Number(x)*100)/Number(min_price_uf))); //((Number(min_price_uf)-Number(x))/Number(x))*100;
               document.getElementById("gp_effective_uf").value =   gp_effective_uf.toFixed(2);

               if(Number(gp_effective_uf) < Number(gp_ob_uf)){
                   document.getElementById('gp_effective_uf').style.background = 'rgb(245 65 11 / 52%)';
               }else{
                   document.getElementById('gp_effective_uf').style.background = '#00a65aa1';
               }

               /*-------------PREZZO DI LISTINO-----------------*/
               var list_price_uf = 0;
               list_price_uf = Number(min_price_uf)/(1-(Number(disc_ob_uf)/100));
               //alert(list_price_uf);
               document.getElementById("list_price_uf").value =  Math.ceil((list_price_uf/50))*50;

           }

           function myFunction_co() {
               var total_at_co = document.getElementById("total_at_co").value;
               var price_rtc_co = document.getElementById("price_rtc_co").value;
               var ol_prevision_co = document.getElementById("ol_prevision_co").value;
               var ol_def_co = document.getElementById("ol_def_co").value;
               var cost_trasp_co = document.getElementById("cost_trasp_co").value;
               var min_price_co = document.getElementById("min_price_co").value;
               var gp_ob_co = document.getElementById("gp_ob_co").value;
               var disc_ob_co = document.getElementById("disc_ob_co").value;
               var val = 0;


               if(Number(ol_def_co) === 0){
                   val = ol_prevision_co;

               }else{
                   val = ol_def_co;

               }


               /*--------------VALORE TT co-----------------*/
               var x =0;
               var x = Number(price_rtc_co)+Number(val)+Number(cost_trasp_co)+Number(total_at_co);
               document.getElementById("value_tt_co").value =   x.toFixed(2);
               /*-------------PREZZO CALCOLATO UTILIZZATORE FINAL-----------------*/
               var calculated_price_co = 0 ;
               calculated_price_co = Number(x)/(Number(1)-(Number(gp_ob_co)/100));
               document.getElementById("calculated_price_co").value =   calculated_price_co.toFixed(2);
               /*-------------GP EFFETTIVO UTILIZZATORE FINALE-----------------*/
               var gp_effective_co = 0 ;
               gp_effective_co = 100-(((Number(x)*100)/Number(min_price_co)));//((Number(min_price_co)-Number(x))/Number(x))*100;
               document.getElementById("gp_effective_co").value =   gp_effective_co.toFixed(2);

               if(Number(gp_effective_co) < Number(gp_ob_co)){
                   document.getElementById('gp_effective_co').style.background = 'rgb(245 65 11 / 52%)';
               }else{
                   document.getElementById('gp_effective_co').style.background = '#00a65aa1';
               }

               //background-color: rgb(245 65 11 / 52%);

               /*-------------PREZZO DI LISTINO-----------------*/
               var list_price_co = 0;
               list_price_co = Number(min_price_co)/(1-(Number(disc_ob_co)/100));
               //alert(list_price_co);
               document.getElementById("list_price_co").value =  Math.ceil((list_price_co/50))*50;

           }
           function setrequf(){

               document.getElementById("title_1_uf").setAttribute("required", '');
               document.getElementById("desc_it_uf").setAttribute("required", '');
               document.getElementById("desc_en_uf").setAttribute("required", '');
               document.getElementById("cost_trasp_uf").setAttribute("required", '');
               document.getElementById("min_price_uf").setAttribute("required", '');

               document.getElementById("title_1_uf").style.borderColor = "red";
               document.getElementById("desc_it_uf").style.borderColor = "red";
               document.getElementById("desc_en_uf").style.borderColor = "red";
               document.getElementById("cost_trasp_uf").style.borderColor = "red";
               document.getElementById("min_price_uf").style.borderColor = "red";


               document.getElementById("title_1_co").style.borderColor = "#999";
               document.getElementById("desc_it_co").style.borderColor = "#999";
               document.getElementById("desc_en_co").style.borderColor = "#999";
               document.getElementById("cost_trasp_co").style.borderColor = "#999";
               document.getElementById("min_price_co").style.borderColor = "#999";

               document.getElementById("title_1_co").removeAttribute("required");
               document.getElementById("desc_it_co").removeAttribute("required");
               document.getElementById("desc_en_co").removeAttribute("required");
               document.getElementById("cost_trasp_co").removeAttribute("required");
               document.getElementById("min_price_co").removeAttribute("required");
           }

           function setreqco(){
               document.getElementById("title_1_co").setAttribute("required", '');
               document.getElementById("desc_it_co").setAttribute("required", '');
               document.getElementById("desc_en_co").setAttribute("required", '');
               document.getElementById("cost_trasp_co").setAttribute("required", '');
               document.getElementById("min_price_co").setAttribute("required", '');

               document.getElementById("title_1_uf").removeAttribute("required");
               document.getElementById("desc_it_uf").removeAttribute("required");
               document.getElementById("desc_en_uf").removeAttribute("required");
               document.getElementById("cost_trasp_uf").removeAttribute("required");
               document.getElementById("min_price_uf").removeAttribute("required");

               document.getElementById("title_1_uf").style.borderColor = "#999";
               document.getElementById("desc_it_uf").style.borderColor = "#999";
               document.getElementById("desc_en_uf").style.borderColor = "#999";
               document.getElementById("cost_trasp_uf").style.borderColor = "#999";
               document.getElementById("min_price_uf").style.borderColor = "#999";


               document.getElementById("title_1_co").style.borderColor = "red";
               document.getElementById("desc_it_co").style.borderColor = "red";
               document.getElementById("desc_en_co").style.borderColor = "red";
               document.getElementById("cost_trasp_co").style.borderColor = "red";
               document.getElementById("min_price_co").style.borderColor = "red";

           }

           function sitiesteri(target, site) {

               var tar = 0;
               var typeval = 0;
               var pri = 0;

               if(target == 'uf' && site == 'ttcar'){

                   tar = document.getElementById("uf_ttcar").value;
                   typeval = document.querySelector('input[name="uf_ttcar_value"]:checked').value;
                   pri =document.getElementById("uf_ttcar_value_price").value;

               }else if(target == 'co' && site == 'ttcar'){

                   tar = document.getElementById("co_ttcar").value;
                   typeval = document.querySelector('input[name="co_ttcar_value"]:checked').value;
                   pri =document.getElementById("co_ttcar_value_price").value;

               }else if(target == 'uf' && site == 'macus'){

                   tar = document.getElementById("uf_macus").value;
                   typeval = document.querySelector('input[name="uf_macus_value"]:checked').value;
                   pri =document.getElementById("uf_macus_value_price").value;

               }else if(target == 'co' && site == 'macus'){

                   tar = document.getElementById("co_macus").value;
                   typeval = document.querySelector('input[name="co_macus_value"]:checked').value;
                   pri =document.getElementById("co_macus_value_price").value;

               }else if(target == 'uf' && site == 'supra'){

                   tar = document.getElementById("uf_supra").value;
                   typeval = document.querySelector('input[name="uf_supra_value"]:checked').value;
                   pri =document.getElementById("uf_supra_value_price").value;

               }else if(target == 'co' && site == 'supra'){

                   tar = document.getElementById("co_supra").value;
                   typeval = document.querySelector('input[name="co_supra_value"]:checked').value;
                   pri =document.getElementById("co_supra_value_price").value;

               }
               $.ajax({
                   url: "{{ url('admin/offert/storenewapioffert') }}?site="+site+"&tar="+tar+"&typeval="+typeval+"&pri="+pri+"&offert_id={{$offert->id}}",
                   type: 'get',
                   dataType: 'json',
                   success: function(response){
                       if(target == 'uf' && site == 'ttcar'){
                           document.getElementById("button_send_ttcar").style.display= "none";
                           document.getElementById("check_send_ttcar").style.display= "block";
                       }else if(target == 'co' && site == 'ttcar'){
                           document.getElementById("button_send_ttcar").style.display= "none";
                           document.getElementById("check_send_ttcar").style.display= "block";
                       }else if(target == 'uf' && site == 'macus'){
                           document.getElementById("button_send_macus").style.display= "none";
                           document.getElementById("check_send_macus").style.display= "block";
                       }else if(target == 'co' && site == 'macus'){
                           document.getElementById("button_send_macus").style.display= "none";
                           document.getElementById("check_send_macus").style.display= "block";
                       }else if(target == 'uf' && site == 'supra'){
                           document.getElementById("button_send_supra").style.display= "none";
                           document.getElementById("check_send_supra").style.display= "block";
                       }else if(target == 'co' && site == 'supra'){
                           document.getElementById("button_send_supra").style.display= "none";
                           document.getElementById("check_send_supra").style.display= "block";
                       }
                       setTimeout(function () {
                           window.location = " {{Request::url()}}"
                       }, 2000);
                   }



               });
           }

           function setcheckbox(target, site) {

               if(target == 'uf' && site == 'ttcar'){

                   if(document.getElementById("uf_ttcar").checked){
                       document.getElementById("uf_ttcar_value_or").removeAttribute("disabled");
                       document.getElementById("uf_ttcar_value_special").removeAttribute("disabled");
                   }else{
                       document.getElementById("uf_ttcar_value_or").setAttribute("disabled",'');
                       document.getElementById("uf_ttcar_value_special").setAttribute("disabled",'');
                       document.getElementById("button_send_ttcar").style.backgroundColor= "rgba(64, 66, 65, 0.68)";
                       document.getElementById("button_send_ttcar").style.pointerEvents= "none";
                   }

               }else if(target == 'co' && site == 'ttcar'){

                   if(document.getElementById("co_ttcar").checked){
                       document.getElementById("co_ttcar_value_or").removeAttribute("disabled");
                       document.getElementById("co_ttcar_value_special").removeAttribute("disabled");
                   }else{
                       document.getElementById("co_ttcar_value_or").setAttribute("disabled",'');
                       document.getElementById("co_ttcar_value_special").setAttribute("disabled",'');
                       document.getElementById("button_send_ttcar").style.backgroundColor= "rgba(64, 66, 65, 0.68)";
                       document.getElementById("button_send_ttcar").style.pointerEvents= "none";
                   }
               }else  if(target == 'uf' && site == 'macus'){

                   if(document.getElementById("uf_macus").checked){
                       document.getElementById("uf_macus_value_or").removeAttribute("disabled");
                       document.getElementById("uf_macus_value_special").removeAttribute("disabled");
                   }else{
                       document.getElementById("uf_macus_value_or").setAttribute("disabled",'');
                       document.getElementById("uf_macus_value_special").setAttribute("disabled",'');
                       document.getElementById("button_send_macus").style.backgroundColor= "rgba(64, 66, 65, 0.68)";
                       document.getElementById("button_send_macus").style.pointerEvents= "none";
                   }

               }else if(target == 'co' && site == 'macus'){

                   if(document.getElementById("co_macus").checked){
                       document.getElementById("co_macus_value_or").removeAttribute("disabled");
                       document.getElementById("co_macus_value_special").removeAttribute("disabled");
                   }else{
                       document.getElementById("co_macus_value_or").setAttribute("disabled",'');
                       document.getElementById("co_macus_value_special").setAttribute("disabled",'');
                       document.getElementById("button_send_macus").style.backgroundColor= "rgba(64, 66, 65, 0.68)";
                       document.getElementById("button_send_macus").style.pointerEvents= "none";
                   }
               }else  if(target == 'uf' && site == 'supra'){

                   if(document.getElementById("uf_supra").checked){
                       document.getElementById("uf_supra_value_or").removeAttribute("disabled");
                       document.getElementById("uf_supra_value_special").removeAttribute("disabled");
                   }else{
                       document.getElementById("uf_supra_value_or").setAttribute("disabled",'');
                       document.getElementById("uf_supra_value_special").setAttribute("disabled",'');
                       document.getElementById("button_send_supra").style.backgroundColor= "rgba(64, 66, 65, 0.68)";
                       document.getElementById("button_send_supra").style.pointerEvents= "none";
                   }

               }else if(target == 'co' && site == 'supra'){

                   if(document.getElementById("co_supra").checked){
                       document.getElementById("co_supra_value_or").removeAttribute("disabled");
                       document.getElementById("co_supra_value_special").removeAttribute("disabled");
                   }else{
                       document.getElementById("co_supra_value_or").setAttribute("disabled",'');
                       document.getElementById("co_supra_value_special").setAttribute("disabled",'');
                       document.getElementById("button_send_supra").style.backgroundColor= "rgba(64, 66, 65, 0.68)";
                       document.getElementById("button_send_supra").style.pointerEvents= "none";
                   }
               }

           }

           function setotherprice(target, site, type) {

           if(target == 'uf' && site == 'ttcar'){

                 if(type == 1){
                       document.getElementById("uf_ttcar_value_price").removeAttribute("readonly");
                       document.getElementById("button_send_ttcar").style.backgroundColor= "#00a65a";
                       document.getElementById("button_send_ttcar").style.pointerEvents= "all";
                   }else{
                       document.getElementById("uf_ttcar_value_price").setAttribute("readonly",'');
                       document.getElementById("uf_ttcar_value_price").value = document.getElementById("list_price_uf").value;
                       document.getElementById("button_send_ttcar").style.backgroundColor= "#00a65a";
                       document.getElementById("button_send_ttcar").style.pointerEvents= "all";
                   }
               }else if(target == 'co' && site == 'ttcar'){

               if(type == 1){
                   document.getElementById("co_ttcar_value_price").removeAttribute("readonly");
                   document.getElementById("button_send_ttcar").style.backgroundColor= "#00a65a";
                   document.getElementById("button_send_ttcar").style.pointerEvents= "all";
               }else{
                   document.getElementById("co_ttcar_value_price").setAttribute("readonly",'');
                   document.getElementById("co_ttcar_value_price").value = document.getElementById("list_price_co").value;
                   document.getElementById("button_send_ttcar").style.backgroundColor= "#00a65a";
                   document.getElementById("button_send_ttcar").style.pointerEvents= "all";
               }
               }else if(target == 'uf' && site == 'macus'){

               if(type == 1){
                   document.getElementById("uf_macus_value_price").removeAttribute("readonly");
                   document.getElementById("button_send_macus").style.backgroundColor= "#00a65a";
                   document.getElementById("button_send_macus").style.pointerEvents= "all";
               }else{
                   document.getElementById("uf_macus_value_price").setAttribute("readonly",'');
                   document.getElementById("uf_macus_value_price").value = document.getElementById("list_price_uf").value;
                   document.getElementById("button_send_macus").style.backgroundColor= "#00a65a";
                   document.getElementById("button_send_macus").style.pointerEvents= "all";
               }
           }else if(target == 'co' && site == 'macus'){

               if(type == 1){
                   document.getElementById("co_macus_value_price").removeAttribute("readonly");
                   document.getElementById("button_send_macus").style.backgroundColor= "#00a65a";
                   document.getElementById("button_send_macus").style.pointerEvents= "all";
               }else{
                   document.getElementById("co_macus_value_price").setAttribute("readonly",'');
                   document.getElementById("co_macus_value_price").value = document.getElementById("list_price_co").value;
                   document.getElementById("button_send_macus").style.backgroundColor= "#00a65a";
                   document.getElementById("button_send_macus").style.pointerEvents= "all";
               }
           }else if(target == 'uf' && site == 'supra'){

               if(type == 1){
                   document.getElementById("uf_supra_value_price").removeAttribute("readonly");
                   document.getElementById("button_send_supra").style.backgroundColor= "#00a65a";
                   document.getElementById("button_send_supra").style.pointerEvents= "all";
               }else{
                   document.getElementById("uf_supra_value_price").setAttribute("readonly",'');
                   document.getElementById("uf_supra_value_price").value = document.getElementById("list_price_uf").value;
                   document.getElementById("button_send_supra").style.backgroundColor= "#00a65a";
                   document.getElementById("button_send_supra").style.pointerEvents= "all";
               }
           }else if(target == 'co' && site == 'supra'){

               if(type == 1){
                   document.getElementById("co_supra_value_price").removeAttribute("readonly");
                   document.getElementById("button_send_supra").style.backgroundColor= "#00a65a";
                   document.getElementById("button_send_supra").style.pointerEvents= "all";
               }else{
                   document.getElementById("co_supra_value_price").setAttribute("readonly",'');
                   document.getElementById("co_supra_value_price").value = document.getElementById("list_price_co").value;
                   document.getElementById("button_send_supra").style.backgroundColor= "#00a65a";
                   document.getElementById("button_send_supra").style.pointerEvents= "all";
               }
           }
           }
         function removeoffert(off_id, site) {
             $.ajax({
                 url: "{{ url('admin/offert/deleteoffert') }}?id="+off_id+"&site="+site,
                 type: 'get',
                 dataType: 'json',
                 success: function(response){
                     setTimeout(function () {
                          window.location = " {{Request::url()}}"
                     }, 2000);
                 }



             });
         }
       </script>
   @stop


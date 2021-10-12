@extends('layouts.admin')

@section('title', $offert::getMsgTrans('update_heading'))

@section('content')
    @include('partials._content-heading', ['title' => 'Modifica la offerta'])

    @include('partials._alerts')
    {{ html()->modelForm($offert, 'PUT', route('admin.offerts.update', [$offert]))->open() }}

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">

                <div class="col-lg-4">
                    <h3>PUBBLICAZIONE OFFERTA  </h3>
                </div>
                <div class="col-lg-10">
                    <div class="row">



                        <div class="col-lg-4">
                            <div class="radio col-md-12 form-group ">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    <strong>MYUSATO UTENTE FINALE</strong>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="radio col-md-12 form-group ">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                    <strong> MYUSATO COMMERCIANTE</strong>
                                </label>
                            </div>
                        </div>







                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            @include('partials.inputs._date', ['name' => 'titles', 'label' => 'Data fine offerta'.'*'])
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-3">
                            @include('partials.inputs._select', ['name' => 'titles', 'label' => 'FORKLIFT'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._checkbox', ['name' => 'titles', 'label' => 'USA VALORE MACCHINE'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._checkbox', ['name' => 'titles', 'label' => 'IMPOSTA ALTRO PREZZO'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._text', ['name' => 'titles', 'label' => ''])
                        </div>
                    </div>
                <!--     <div class="row">
                        <div class="col-lg-3">
                            @include('partials.inputs._select', ['name' => 'titles', 'label' => 'ALTRO'.'*'])
                    </div>
                    <div class="col-lg-3">
@include('partials.inputs._checkbox', ['name' => 'titles', 'label' => 'USA VALORE MACCHINE'.'*'])
                    </div>
                    <div class="col-lg-3">
@include('partials.inputs._checkbox', ['name' => 'titles', 'label' => 'IMPOSTA ALTRO PREZZO'.'*'])
                    </div>
                    <div class="col-lg-3">
@include('partials.inputs._text', ['name' => 'titles', 'label' => ''])
                    </div>
                </div>-->

                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <h3>Prodotti associati in questa offerta</h3>
                    <BR>
                </div>
                <div class="col-lg-12">
                    <div class="pull-left">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">AGGIUNGI PRODOTTI A QUESTA OFFERTA</button>
                    </div>
                    <div class="pull-right">
                        <button type="button" class="btn btn-info"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
                    </div>
                    <BR><BR>
                            <table class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th>{{ __(' ') }}</th>
                                    <th>{{ __('Famiglia') }}</th>
                                    <th>{{ __('Marca') }}</th>
                                    <th>{{ __('Modello') }}</th>
                                    <th>{{ __('N. Serie') }}</th>
                                    <th>{{ __('Rif. Cls') }} </th>
                                    <th>{{ __(' ') }} </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  if(isset($products)){ ?>
                                <?php  foreach ($products as $key ) { ?>
                                <tr>

                                    <td> </td>
                                    <td>{{ $key->family }}</td>
                                    <td>{{ $key->brand }}</td>
                                    <td>{{ $key->model }}</td>
                                    <td>{{ $key->serialnum }}</td>
                                    <td>{{ $key->rifcls }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                        <button type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                                    </td>

                                </tr>
                                <?php } } ?>


                                </tbody>


                            </table>
                </div>

            </div>
            <hr style="border: 1px solid;">



            <div class="row" style="margin-top: 2%">

                <div class="col-lg-4">
                    <h3>OFFERTA UTENTE FINALE</h3>
                </div>

                <div class="col-lg-12">
                    <div class="row" style="margin-top: 1%">

                        <div class="col-lg-4">
                            <input type="hidden" value="{{request()->get('idproduct')}}" name="id_product">
                            <input type="hidden" value=" {{ Auth::user()->email }} " name="createdby">
                            @include('partials.inputs._text', ['name' => 'title', 'label' => 'Titolo TAG#1'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._text', ['name' => 'titl', 'label' => 'Titolo TAG#2'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._text', ['name' => 'titl', 'label' => 'Titolo TAG#3'.'*'])
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-lg-4">
                            <h3>Gallery offerta</h3>
                        </div>

                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-lg-2" style="margin-top:2%">
                                    <a href="#" data-toggle="modal" data-target="#exampleModal"> <img src="https://faculty.iiit.ac.in/~indranil.chakrabarty/images/empty.png" style="width: 250px;
    height: 250px;  border: 3px solid #00a65a;">
                                    </a>
                                </div>
                                <div class="col-lg-2" style="margin-top:2%">
                                    <a href="#" data-toggle="modal" data-target="#exampleModal"> <img src="https://faculty.iiit.ac.in/~indranil.chakrabarty/images/empty.png" style="width: 250px;
    height: 250px;  border: 3px solid black;">
                                    </a>
                                </div>
                                @if(isset($gallery))
                                    @foreach($gallery as $key)
                                        <div class="col-lg-2" style="margin-top:2%">
                                            <img src="<?php echo config('app.url').'/upload/'.$key->name; ?>" alt="" style=" width: 250px;
    height: 250px; border: 3px solid black;">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12" style="margin-top: 1%">
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._textarea', ['name' => 'descripit', 'label' => 'Descrizione offerta IT'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._textarea', ['name' => 'descripen', 'label' => 'Descrizione offerta EN'.'*'])
                        </div>

                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="row" style="margin-top: 2%">
                        <div class="col-lg-3">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Costo trasporto'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Stima Rtc'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Ol previsione'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Pagato cliente'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Ol definitivo'.'*'])
                        </div>
                        <div class="col-lg-5">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Overallowance'.'*'])
                        </div>
                    </div>

                </div>
                <div class="col-lg-12">
                    <div class="row" style="margin: 3%">
                        <div class="col-lg-4">
                            <h3>{{ __('Componenti') }}</h3>
                        </div>
                        <div class="col-lg-12">
                            <table class="table table-hover table-condensed"  id='filterTable'>
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
                                        <input class="form-control">
                                    </td>
                                    <td>
                                        <input class="form-control">
                                    </td>
                                    <td>
                                        <input class="form-control">
                                    </td>
                                    <td>
                                        <input class="form-control">
                                    </td>
                                    <td><input type='button' value='Aggiungi' class='btn btn-success' id='addfilter'></td>
                                </tr>
                                <tr>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td><button type="button" class="btn btn-danger"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button></td>
                                </tr>
                                <tr>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td><button type="button" class="btn btn-danger"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button></td>
                                </tr>
                                <tr>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td><button type="button" class="btn btn-danger"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button></td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <sTRONG>Total:</sTRONG>
                                    </td>
                                    <td>
                                        <sTRONG>XXXX</sTRONG>
                                    </td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-10">
                    <div class="row" style="margin-top: 2%">
                        <div class="col-lg-3">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Valore Totale carrello'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Gp Obiettivo'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Sconto Obiettivo'.'*'])
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'price_uf', 'label' => 'Prezzo Calcolato'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'price_uf', 'label' => 'Prezzo minimo di vendita'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'price_uf', 'label' => 'Gp effettivo'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'price_uf', 'label' => 'Prezzo di listino'.'*'])
                        </div>
                    </div>
                </div>

            </div>
            <hr style="    border: 1px solid;">
            <div class="row" style="margin-top: 2%">

                <div class="col-lg-4">
                    <h3>OFFERTA COMMERCIANTE</h3>
                </div>

                <div class="col-lg-12">
                    <div class="row" style="margin-top: 1%">

                        <div class="col-lg-4">
                            <input type="hidden" value="{{request()->get('idproduct')}}" name="id_product">
                            <input type="hidden" value=" {{ Auth::user()->email }} " name="createdby">
                            @include('partials.inputs._text', ['name' => 'title', 'label' => 'Titolo TAG#1'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._text', ['name' => 'titl', 'label' => 'Titolo TAG#2'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._text', ['name' => 'titl', 'label' => 'Titolo TAG#3'.'*'])
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-lg-4">
                            <h3>Gallery offerta</h3>
                        </div>

                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-lg-2" style="margin-top:2%">
                                    <a href="#" data-toggle="modal" data-target="#exampleModal"> <img src="https://faculty.iiit.ac.in/~indranil.chakrabarty/images/empty.png" style="width: 250px;
    height: 250px;  border: 3px solid #00a65a;">
                                    </a>
                                </div>
                                <div class="col-lg-2" style="margin-top:2%">
                                    <a href="#" data-toggle="modal" data-target="#exampleModal"> <img src="https://faculty.iiit.ac.in/~indranil.chakrabarty/images/empty.png" style="width: 250px;
    height: 250px;  border: 3px solid black;">
                                    </a>
                                </div>
                                @if(isset($gallery))
                                    @foreach($gallery as $key)
                                        <div class="col-lg-2" style="margin-top:2%">
                                            <img src="<?php echo config('app.url').'/upload/'.$key->name; ?>" alt="" style=" width: 250px;
    height: 250px; border: 3px solid black;">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12" style="margin-top: 1%">
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._textarea', ['name' => 'descripit', 'label' => 'Descrizione offerta IT'.'*'])
                        </div>
                        <div class="col-lg-4">
                            @include('partials.inputs._textarea', ['name' => 'descripen', 'label' => 'Descrizione offerta EN'.'*'])
                        </div>

                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="row" style="margin-top: 2%">
                        <div class="col-lg-3">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Costo trasporto'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Stima Rtc'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Ol previsione'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Pagato cliente'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Ol definitivo'.'*'])
                        </div>
                        <div class="col-lg-5">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Overallowance'.'*'])
                        </div>
                    </div>

                </div>
                <div class="col-lg-12">
                    <div class="row" style="margin: 3%">
                        <div class="col-lg-4">
                            <h3>{{ __('Componenti') }}</h3>
                        </div>
                        <div class="col-lg-12">
                            <table class="table table-hover table-condensed"  id='filterTable'>
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
                                        <input class="form-control">
                                    </td>
                                    <td>
                                        <input class="form-control">
                                    </td>
                                    <td>
                                        <input class="form-control">
                                    </td>
                                    <td>
                                        <input class="form-control">
                                    </td>
                                    <td><input type='button' value='Aggiungi' class='btn btn-success' id='addfilter'></td>
                                </tr>
                                <tr>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td><button type="button" class="btn btn-danger"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button></td>
                                </tr>
                                <tr>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td><button type="button" class="btn btn-danger"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button></td>
                                </tr>
                                <tr>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td>
                                        XXXX
                                    </td>
                                    <td><button type="button" class="btn btn-danger"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button></td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <sTRONG>Total:</sTRONG>
                                    </td>
                                    <td>
                                        <sTRONG>XXXX</sTRONG>
                                    </td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-10">
                    <div class="row" style="margin-top: 2%">
                        <div class="col-lg-3">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Valore Totale carrello'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Gp Obiettivo'.'*'])
                        </div>
                        <div class="col-lg-3">
                            @include('partials.inputs._number', ['name' => 'p', 'label' => 'Sconto Obiettivo'.'*'])
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'price_uf', 'label' => 'Prezzo Calcolato'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'price_uf', 'label' => 'Prezzo minimo di vendita'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'price_uf', 'label' => 'Gp effettivo'.'*'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @include('partials.inputs._number', ['name' => 'price_uf', 'label' => 'Prezzo di listino'.'*'])
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





        $(document).ready(function() {
            var table = $('#pas').DataTable( {
                //"language": { "url": "lang.json" },
                "processing": true,
                "serverSide": true,
                "initComplete": function(settings, json) {
                    $('.macchina').click(function(){
                        var macchina = $(this).data('idmacchina');
                        $.ajax({
                            url: "{{ route('admin.offert.addtooffert',['id_offert'=>$offert->id]) }}",
                            type: 'post',
                            data: {macchina: macchina},
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        });
                    });

                },
                "ajax": "{{ route('admin.product.datatableoff',['id_offert'=>$offert->id]) }}",

                "columns": [
                    {data: 'action', name: 'action'},
                    {data: 'family', name: 'family'},
                    {data: 'brand', name: 'brand'},
                    {data: 'model', name: 'model'},
                    {data: 'serialnum', name: 'serialnum'}
                ],

                "order": [[1, 'asc']]
            } );



        } );
        $(document).ready(function(){



        });
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
        $(document).ready(function(){
            $(document).on('change', '#file', function(){
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
                        }
                    });
                }
            });
        });
    </script>

@stop


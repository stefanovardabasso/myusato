<div class="searchclient-dialog-wrapper richiedi-info-dialog-wrapper" style="display: none; z-index: 100;">
{{--    <a class="btn btn-primary" href="#" id="submit-option">OPZIONA</a>--}}
    <div class="searchclient-close-icon mb-10">
        <i class="material-icons font-35 close-icon">close</i>
    </div>
    <h1 class="text-center mb-10">{{__('Cerca cliente')}}</h1>

      <div id="form_search_client">
          <input type="text" id="cod_cli" class="input mb-10 weight-500"
                 placeholder="{{ __('Codice cliente') }}" required="" style="border: 1px solid;">
          <input type="text" id="rag_cli" class="input mb-10 weight-500"
                 placeholder="{{ __('Rag sociale') }}" required="" style="border: 1px solid;">
          <input type="text" id="piva_cli" class="input mb-10 weight-500"
                 placeholder="{{ __('Piva') }}" required="" style="border: 1px solid;">
          <div class="flex flex-wrap justify-center align-center">
              <button type="submit" onclick="checkclient()" id="checkclient" class="btn btn-primary">{{__('Cerca')}}</button>
          </div>
      </div>
      <div id="result_search_client" style="display: none">

          <table class="table table-hover table-condensed"  id='filterTable'>
              <thead>
              <tr>
                  <th>{{ __('Rag So.') }}</th>
                  <th>{{ __('Codice') }}</th>
                  <th>{{ __('Piva') }}</th>
                  <th> </th>
              </tr>
              </thead>
              <tbody>




              </tbody>
          </table>
{{--          @auth--}}
{{--              <?php--}}
{{--              $role = auth()->user()->getrole();--}}
{{--              if( $role[0]->id == 2 | $role[0]->id == 1 | $role[0]->id == 5 | $role[0]->id == 8){--}}
{{--              ?>--}}
{{--              <a id="choose-product-action" href="a" class="button mb-15 text-center">{{__('Choose Product')}}</a>--}}

{{--              <?php } ?>--}}
{{--          @endauth--}}
      </div>






</div>

<script>
    function checkclient() {
        var cod_cli = document.getElementById('cod_cli').value;
        var rag_cli = document.getElementById('rag_cli').value;
        var piva_cli = document.getElementById('piva_cli').value;

        if(cod_cli == '' & rag_cli == '' & piva_cli == ''){
            document.getElementById('cod_cli').style.border = "1px solid red";
            document.getElementById('rag_cli').style.border = "1px solid red";
            document.getElementById('piva_cli').style.border = "1px solid red";

        }else{
            //alert(cod_cli + ' ' + rag_cli + ' ' + piva_cli)
            document.getElementById('cod_cli').style.border = "1px solid green";
            document.getElementById('rag_cli').style.border = "1px solid green";
            document.getElementById('piva_cli').style.border = "1px solid green";

            $.ajax({
                url: "{{ url('searchclient') }}?cod_cli="+cod_cli+"&rag_cli="+rag_cli+"&piva_cli="+piva_cli,
                type: 'get',
                dataType: 'json',
                success: function(response){

                    if(response['success'] == 'OK'){
                        document.getElementById('cod_cli').value = "";
                        document.getElementById('rag_cli').value = "";
                        document.getElementById('piva_cli').value = "";

                        var len = 0;
                        len = response['list'].length;

                        if(len > 3){
                            alert('Sono stati trovati troppi risultati ('+len+'), devi essere più specifico ')
                            breack;
                        }

                        $('#filterTable tbody tr:not(:first)').empty();
                        for(var i=0; i<len; i++){

                            var id = response['list'][i].CODICE;
                            var fill_code = response['list'][i].RAGSOCIALE;
                            var fill_type = response['list'][i].PIVA;
                            var fill_material = response['list'][i].PIVA;
                            var fill_value = response['list'][i].PIVA;

                            var tr_str = "<tr>" +
                                "<td align='center'>" + fill_code + "</td>" +
                                "<td align='center'>" + fill_type + "</td>" +
                                "<td align='center'>" + fill_material + "</td>" +
                                " </tr><tr><td colspan='3' align='center'> <a onclick='sendoption("+id+")' data-id='"+fill_type+"' class='button mb-15 text-center'>{{__('Choose Product')}} per "+fill_code+"</a></td>"+
                                "</tr>";


                            $("#filterTable tbody").append(tr_str);

                        }
                        document.getElementById('form_search_client').style.display = "none";
                        document.getElementById('result_search_client').style.display = "block";


                    }else{
                        alert(response['mes']);
                    }




                }



            });


        }



    }
</script>


<script>
    $('.searchclient-close-icon i').click(function(ev) {
        $('.searchclient-dialog-wrapper').hide();
    })
</script>


<div class="richiedi-info-dialog-wrapper" style="display: none">

    <div class="richiedi-close-icon mb-10">
        <i class="material-icons font-35 close-icon">close</i>
    </div>
    <h1 class="text-center mb-10">{{__('RICHIEDI INFO')}}</h1>

    <form class="valuta-form richiedi-info-dialog" method="POST" action="{{route('storemoreinfo')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <input type="hidden" name="offert_id" value="{{ $offerId }}"/>

        <input type="text" name="title" class="input mb-10 weight-500"
               placeholder="{{ __('Titolo') }}" required="" style="border: 1px solid;">
        <textarea class="textarea weight-500 mb-10" name="message" id="" cols="30" rows="14"
                  placeholder="{{__('Testo')}}" required=""
                  style="border: 1px solid;"></textarea>
        <input type="text" name="email" class="input mb-10 weight-500"
               placeholder="{{ __('Email dove ricevere la quotazione') }}" required="" value="@if(Auth::check()) {{auth()->user()->email}}  @endif" style="border: 1px solid;">


        <div class="flex flex-wrap justify-center align-center">
            <button type="submit" id="sendmes" onclick="sendoption()" class="btn btn-primary">{{__('Invia')}}</button>
        </div>

    </form>
</div>

<script>
    $('.richiedi-close-icon i').click(function(ev) {
        $('.richiedi-info-dialog-wrapper').hide();
    })
</script>


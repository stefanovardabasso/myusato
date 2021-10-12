<div class="row">
    <div class="col-lg-3">
        <h4><span class="label label-info" style="background-color: red !important;">Tuttocarrellielevatori</span></h4>
    </div>
</div>
@if($products[0]->macchinallestita == 'D' && $tuttocar == null)
    <div class="row">

        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="checkbox" onchange="setcheckbox('co','ttcar')" id="co_ttcar" value="2" class="form-check-input">
                <label for="co_ttcar" class="form-check-label">COMMERCIANTE</label>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="col-md-12 form-group ">
                <input type="radio" name="co_ttcar_value" onchange="setotherprice('co','ttcar',0)" id="co_ttcar_value_or" value="0" class="form-check-input">
                <label for="co_ttcar_value_or" class="form-check-label">VALORE MACCHINE*</label>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="radio" name="co_ttcar_value" onchange="setotherprice('co','ttcar',1)" id="co_ttcar_value_special" value="1" class="form-check-input">
                <label for="co_ttcar_value_special" class="form-check-label">ALTRO PREZZO*</label>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="number" id="co_ttcar_value_price" value="{{$offert->list_price_co}}" readonly class="form-control">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="button" id="button_send_ttcar" onclick="sitiesteri('co','ttcar')" style="pointer-events: none; background-color: #404241ad;border: transparent" class="btn btn-success" value="Invia" >
                <span id="check_send_ttcar" class="glyphicon glyphicon-ok-sign" style="color: green;display: none;font-size: 205%;"></span>
            </div>
        </div>
    </div>
@elseif($products[0]->macchinallestita != 'D' && $tuttocar == null)
    <div class="row">

        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="checkbox" onchange="setcheckbox('uf','ttcar')" id="uf_ttcar" value="1" class="form-check-input">
                <label for="uf_ttcar" class="form-check-label">UTENTE FINALE*</label>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="col-md-12 form-group ">
                <input type="radio" name="uf_ttcar_value" onchange="setotherprice('uf','ttcar',0)" disabled id="uf_ttcar_value_or" value="0" class="form-check-input">
                <label for="uf_ttcar_value_or" class="form-check-label">VALORE MACCHINE*</label>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="radio" name="uf_ttcar_value" onchange="setotherprice('uf','ttcar',1)" disabled id="uf_ttcar_value_special" value="1" class="form-check-input">
                <label for="uf_ttcar_value_special" class="form-check-label">ALTRO PREZZO*</label>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="number" id="uf_ttcar_value_price" value="{{$offert->list_price_uf}}" readonly class="form-control">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                {{--                                        <button id="button_send_ttcar" onclick="sitiesteri('uf','ttcar')" style="pointer-events: none; background-color: #404241ad;border: transparent" class="btn btn-success">Invia</button>--}}
                <input type="button" id="button_send_ttcar" onclick="sitiesteri('uf','ttcar')" style="pointer-events: none; background-color: #404241ad;border: transparent" class="btn btn-success" value="Invia" >
                <span id="check_send_ttcar" class="glyphicon glyphicon-ok-sign" style="color: green;display: none;font-size: 205%;"></span>
            </div>
        </div>
    </div>
@elseif($tuttocar != null)
    <div class="row">

        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <label for="" class="form-check-label">@if($tuttocar->target_user == 1)UTENTE FINALE @else COMMERCIANTE @endif</label>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="col-md-12 form-group ">
                <label for="" class="form-check-label">VALORE MACCHINE:  {{ $tuttocar->price }} Eur</label>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="col-md-12 form-group">
                @if($tuttocar->action == 1)
                    <label for="" class="form-check-label">
                    In via di pubblicazione
                    <span class="glyphicon glyphicon-dashboard" style="color:green;font-size: 168%;"></span>
                    </label>
                @elseif($tuttocar->action == 2)
      <input type="button" onclick="removeoffert({{$tuttocar->id}},'ttcar')" style="background-color: rgba(255, 239, 0, 0.93); color:#535252; border: transparent" class="btn btn-success" value="Rimuovi l'offerta" >
                @elseif($tuttocar->action == 3)
                    <label for="" class="form-check-label">
                        In via di eliminazione
                        <span class="glyphicon glyphicon-dashboard" style="color:red;font-size: 168%;"></span>
                    </label>
                @endif
           </div>
        </div>
    </div>
@endif
<hr>
<div class="row">
    <div class="col-lg-3">
        <h4><span class="label label-info" style="background-color: #fb7121 !important;">Mascus</span></h4>
    </div>
</div>
@if($products[0]->macchinallestita == 'D' && $macus == null)
    <div class="row">

                <div class="col-lg-2">
                    <div class="col-md-12 form-group ">
                        <input type="checkbox" onchange="setcheckbox('co','macus')" id="co_macus" value="2" class="form-check-input">
                        <label for="co_macus" class="form-check-label">COMMERCIANTE</label>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="col-md-12 form-group ">
                        <input type="radio" name="co_macus_value" onchange="setotherprice('co','macus',0)" id="co_macus_value_or" value="1" class="form-check-input">
                        <label for="co_macus_value_or" class="form-check-label">VALORE MACCHINE*</label>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="col-md-12 form-group ">
                        <input type="radio" name="co_macus_value" onchange="setotherprice('co','macus',1)" id="co_macus_value_special" value="1" class="form-check-input">
                        <label for="co_macus_value_special" class="form-check-label">ALTRO PREZZO*</label>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="col-md-12 form-group ">
                        <input type="number" id="co_macus_value_price" value="{{$offert->list_price_co}}" readonly class="form-control">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="col-md-12 form-group ">
                        <input type="button" id="button_send_macus" onclick="sitiesteri('co','macus')" style="pointer-events: none; background-color: #404241ad;border: transparent" class="btn btn-success" value="Invia" >
                        <span id="check_send_macus" class="glyphicon glyphicon-ok-sign" style="color: green;display: none;font-size: 205%;"></span>
                    </div>
                </div>
            </div>
@elseif($products[0]->macchinallestita != 'D' && $macus == null)
    <div class="row">

        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="checkbox" onchange="setcheckbox('uf','macus')" id="uf_macus" value="1" class="form-check-input">
                <label for="uf_macus" class="form-check-label">UTENTE FINALE*</label>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="col-md-12 form-group ">
                <input type="radio" name="uf_macus_value" onchange="setotherprice('uf','macus',0)" disabled id="uf_macus_value_or" value="1" class="form-check-input">
                <label for="uf_macus_value_or" class="form-check-label">VALORE MACCHINE*</label>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="radio" name="uf_macus_value" onchange="setotherprice('uf','macus',1)" disabled id="uf_macus_value_special" value="1" class="form-check-input">
                <label for="uf_macus_value_special" class="form-check-label">ALTRO PREZZO*</label>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="number" id="uf_macus_value_price" value="{{$offert->list_price_uf}}" readonly class="form-control">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="button" id="button_send_macus" onclick="sitiesteri('uf','macus')" style="pointer-events: none; background-color: #404241ad;border: transparent" class="btn btn-success" value="Invia" >
                <span id="check_send_macus" class="glyphicon glyphicon-ok-sign" style="color: green;display: none;font-size: 205%;"></span>
            </div>
        </div>
    </div>
@else
    <div class="row">

        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <label for="" class="form-check-label">@if($macus->target_user == 1)UTENTE FINALE @else COMMERCIANTE @endif</label>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="col-md-12 form-group ">
                <label for="" class="form-check-label">VALORE MACCHINE:  {{ $macus->price }} Eur</label>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="col-md-12 form-group">
                @if($macus->action == 1)
                    <label for="" class="form-check-label">
                        In via di pubblicazione
                        <span class="glyphicon glyphicon-dashboard" style="color:green;font-size: 168%;"></span>
                    </label>
                @elseif($macus->action == 2)
                    <input type="button" onclick="removeoffert({{$macus->id}},'macus')" style="background-color: rgba(255, 239, 0, 0.93); color:#535252; border: transparent" class="btn btn-success" value="Rimuovi l'offerta" >
                @elseif($macus->action == 3)
                    <label for="" class="form-check-label">
                        In via di eliminazione
                        <span class="glyphicon glyphicon-dashboard" style="color:red;font-size: 168%;"></span>
                    </label>
                @endif
            </div>
        </div>

    </div>
@endif
<hr>
<div class="row">
    <div class="col-lg-3">
        <h4><span class="label label-info" style="background-color: #53a9e6 !important;">Supralift</span></h4>
    </div>
</div>

@if($products[0]->macchinallestita == 'D' && $supra == null)
    <div class="row">

        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="checkbox" onchange="setcheckbox('co','supra')" id="co_supra" value="2" class="form-check-input">
                <label for="co_supra" class="form-check-label">COMMERCIANTE</label>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="col-md-12 form-group ">
                <input type="radio" name="co_supra_value" onchange="setotherprice('co','supra',0)" id="co_supra_value_or" value="1" class="form-check-input">
                <label for="co_supra_value_or" class="form-check-label">VALORE MACCHINE*</label>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="radio" name="co_supra_value" onchange="setotherprice('co','supra',1)" id="co_supra_value_special" value="1" class="form-check-input">
                <label for="co_supra_value_special" class="form-check-label">ALTRO PREZZO*</label>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="number" id="co_supra_value_price" value="{{$offert->list_price_co}}" readonly class="form-control">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="button" id="button_send_supra" onclick="sitiesteri('co','supra')" style="pointer-events: none; background-color: #404241ad;border: transparent" class="btn btn-success" value="Invia" >
                <span id="check_send_supra" class="glyphicon glyphicon-ok-sign" style="color: green;display: none;font-size: 205%;"></span>
            </div>
        </div>
    </div>
@elseif($products[0]->macchinallestita != 'D' && $supra == null)
    <div class="row">

        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="checkbox" onchange="setcheckbox('uf','supra')" id="uf_supra" value="1" class="form-check-input">
                <label for="uf_supra" class="form-check-label">UTENTE FINALE*</label>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="col-md-12 form-group ">
                <input type="radio" name="uf_supra_value" onchange="setotherprice('uf','supra',0)" disabled id="uf_supra_value_or" value="1" class="form-check-input">
                <label for="uf_supra_value_or" class="form-check-label">VALORE MACCHINE*</label>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="radio" name="uf_supra_value" onchange="setotherprice('uf','supra',1)" disabled id="uf_supra_value_special" value="1" class="form-check-input">
                <label for="uf_supra_value_special" class="form-check-label">ALTRO PREZZO*</label>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="number" id="uf_supra_value_price" value="{{$offert->list_price_uf}}" readonly class="form-control">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <input type="button" id="button_send_supra" onclick="sitiesteri('uf','supra')" style="pointer-events: none; background-color: #404241ad;border: transparent" class="btn btn-success" value="Invia" >
                <span id="check_send_supra" class="glyphicon glyphicon-ok-sign" style="color: green;display: none;font-size: 205%;"></span>
            </div>
        </div>
    </div>
@else
    <div class="row">

        <div class="col-lg-2">
            <div class="col-md-12 form-group ">
                <label for="" class="form-check-label">@if($supra->target_user == 1)UTENTE FINALE @else COMMERCIANTE @endif</label>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="col-md-12 form-group ">
                <label for="" class="form-check-label">VALORE MACCHINE: {{ $supra->price }} Eur</label>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="col-md-12 form-group">
                @if($supra->action == 1)
                    <label for="" class="form-check-label">
                        In via di pubblicazione
                        <span class="glyphicon glyphicon-dashboard" style="color:green;font-size: 168%;"></span>
                    </label>
                @elseif($supra->action == 2)
                    <input type="button" onclick="removeoffert({{$supra->id}},'supra')" style="background-color: rgba(255, 239, 0, 0.93); color:#535252; border: transparent" class="btn btn-success" value="Rimuovi l'offerta" >
                @elseif($supra->action == 3)
                    <label for="" class="form-check-label">
                        In via di eliminazione
                        <span class="glyphicon glyphicon-dashboard" style="color:red;font-size: 168%;"></span>
                    </label>
                @endif
            </div>
        </div>
    </div>
@endif

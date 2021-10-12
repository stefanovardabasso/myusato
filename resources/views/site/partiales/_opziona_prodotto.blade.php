<div id="opziona-prodotto" class="opziona-prodotto flex flex-col">
    <i class="material-icons font-35 close-icon">close</i>

    <h3 class="text-center item">PRODOTTO OPZIONABILE</h3>

    <div class="opziona-content">
        <p class="text-center item options-count-msg">Ci sono meno di <span id="options-count">0</span> opzioni su
            questo prodotto:</p>
        <div class="no-options-msg mb-20 mt-15">{{__('Non ci sono opzioni al momento')}}</div>
        <table class="item options-table col-12">
            <thead>
            <th>PRIORITÀ</th>
            <th>NOME</th>
            <th>FINO AL</th>
            </thead>
            <tbody>
            </tbody>
        </table>
        @if (isset($userHasOption) && !$userHasOption)
        <div class="btn-wrapper item">
            <a class="btn btn-primary" href="#" id="submit-option">OPZIONA</a>
        </div>
        @endif
    </div>
    <div class="loader-wrapper"><div class="loader">Loading..</div></div>

</div>

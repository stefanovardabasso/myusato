<form id="myformvalue" action="{{ route('valuemy') }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="evaluate-wrap bc-secondary mt-60 py-60">
    <div class="container px-15 md_px-0">
        <h2 class="section-title text-light mb-30">Valuta il tuo carrello usato</h2>
        <div class="flex row-5">
            <div class="md_col-2 col-12 px-5 mb-15 md_mb-0">
                <input class="input weight-500" type="text" name="brand" placeholder="Marca">
            </div>
            <div class="md_col-2 col-12 px-5 mb-15 md_mb-0">
                <input class="input weight-500" type="text" name="model" placeholder="Modello">
            </div>
            <div class="md_col-2 col-12 px-5 mb-15 md_mb-0">
                <input class="input weight-500" type="text" name="year" placeholder="Anno">
            </div>
            <div class="md_col-2 col-12 px-5 mb-15 md_mb-0">
                <input class="input weight-500" type="number" name="smin" placeholder="Sollevamento MIN">
            </div>
            <div class="md_col-2 col-12 px-5 mb-15 md_mb-0">
                <input class="input weight-500" type="number" name="smax" placeholder="Sollevamento MAX">
            </div>
            <div class="md_col-2 col-12 px-5">
                <button  type="submit">Valuta</button>
            </div>

        </div>
    </div>
</div>
</form>


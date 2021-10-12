<form method="POST" action="{{route('storemessage')}}" id="myform">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div id="contact" class="keep-contact-wrap bc-primary pt-80 pb-50">
    <div class="container">
        <div class="flex flex-wrap px-15 md_px-0">
            <div class="md_col-5 mb-30 md_mb-0">
                <h2 class="section-title section-title-dark text-dark">Resta in contatto</h2>
                <p class="font-25 weight-500 mt-50">Iscriviti alla nostra newsletter per<br>ricevere direttamente sulla
                    tua<br>casella e-mail le offerte del mese<br> ed
                    i nuovi prodotti inseriti a listino.</p>
            </div>

            <div class="md_col-7">

                <div class="flex row-5">

                    <div class="md_col-4 col-12 px-5">
                        <input type="text" name="name" class="input mb-10 weight-500" placeholder="Nome *" required>
                        <input type="text" name="surname" class="input mb-10 weight-500" placeholder="Cognome *" required>
                        <input type="text" name="company" class="input mb-10 weight-500" placeholder="Azienda *" required>
                        <input type="text" name="email" class="input mb-10 weight-500" placeholder="Email *" required>
                        <input type="text" name="phone" class="input weight-500" placeholder="Cellulare" required>
                    </div>

                    <div class="md_col-8 md_mt-0 mt-10 col-12 px-5">
              <textarea class="textarea weight-500"  name="message" id="" cols="30" rows="14"
                        placeholder="Messaggio *" required></textarea>
                    </div>

                    <div class="col-12 px-5 mt-10">
                        <div class="checkbox-group checkbox-form">
                            <input type="checkbox" id="3" name="marketing" />
                            <label for="3" class="line-height-1-3 text-secondary">Accetto di ricevere da CLS informazioni di marketing tramite email da asdas </label>
                        </div>
                    </div>

                    <div class="col-12 px-5 mt-10">
                        <div class="checkbox-group checkbox-form">
                            <input type="checkbox" id="4" required  name="privacy"/>
                            <label for="4" class="line-height-1-3 text-secondary" required>I tuoi dati personali saranno trattati secondo le modalità espresse all'interno
                                dell'informativa sulla privacy</label>
                        </div>
                    </div>
                    <div class="col-12 px-5 mt-10" id="result">

                    </div>

                    <div class="col-12 flex justify-end mt-20">
                        <button type="button" id="sendmes" class="button-outline px-50 w-auto">Invia</button>
                    </div>


                </div>

            </div>

        </div>
    </div>
</div>
</form>

<script type="text/javascript">
    $("#sendmes").click(function() {
        $.post($("#myform").attr("action"), $("#myform :input").serializeArray(),
            function(info){ $("#result").html(info); } );


    });
</script>

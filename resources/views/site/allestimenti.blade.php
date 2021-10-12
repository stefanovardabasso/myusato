<!DOCTYPE html>
<html lang="en">

@section('title', 'Allestimenti & garanzia')
@include('site.partiales._pagehead')

<body class="allestimenti-page">

<!-- Header https://via.placeholder.com/1980x1080-->

@include('site.partiales._header')


<div class="cls-allestimenti-banner">
    <img src="https://myusato.cls.it/site/images/alle.JPG" style="background-color: rgba(0,0,0,0.8); max-width: 100%;filter: brightness(0.4);">
    <h1 style="color: white;font-weight: 500;">Cogli l'occasione per costruire un'offerta su misura</h1>
</div>

<div class="container px-15 md_px-0">
    <section class="mt-25 mb-25">
        <p class="mb-25">
            LA NOSTRA OFFERTA, LA TUA SOLUZIONE<br>
            I carrelli My Usato® CLS sono disponibili in 4 diversi allestimenti: EASY, QUALITY, PREMIUM e PREMIUM Plus. Ogni configurazione si distingue per caratteristiche specifiche di revisione, verniciatura, batteria e garanzia. Quello che rimane costante è lo standard adottato nella verifica e nel controllo di tutti i dispositivi di sicurezza… perché sulla sicurezza non facciamo sconti!

        </p>
        <div class="cls-offer-cards-wrapper">
            <div class="cls-offer-card">
                <img src="{{asset('site/images/advEasy.png')}}">
                <div class="cls-offer-card__item">
                    <h3 class="cls-offer-card__header">BENEFICI</h3>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">COMPONENTI DI SICUREZZA</h5>
                    <p class="cls-offer-card__value">pienamente efficaci</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">LIVELLO DI REVISIONE</h5>
                    <p class="cls-offer-card__value">base</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">TAGLIANDO</h5>
                    <p class="cls-offer-card__value">si</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">GARANZIA</h5>
                    <p class="cls-offer-card__value">no</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">VERNICIATURA</h5>
                    <p class="cls-offer-card__value">no</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">GOMME</h5>
                    <p class="cls-offer-card__value">usura entro i limiti di sicurezza</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">BATTERIA DI TRAZIONE*</h5>
                    <p class="cls-offer-card__value">capacità residua maggiore o uguale 40%</p>
                </div>
            </div>
            <div class="cls-offer-card">
                <img src="{{asset('site/images/advQuality.png')}}">
                <div class="cls-offer-card__item">
                    <h3 class="cls-offer-card__header">BENEFICI</h3>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">COMPONENTI DI SICUREZZA</h5>
                    <p class="cls-offer-card__value">pienamente efficaci</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">LIVELLO DI REVISIONE</h5>
                    <p class="cls-offer-card__value">ricondizionato</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">TAGLIANDO</h5>
                    <p class="cls-offer-card__value">si</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">GARANZIA</h5>
                    <p class="cls-offer-card__value">3 mesi / 300 ore</p>
                    <p class="cls-offer-card__value">6 mesi / 600 ore</p>
                    <p class="cls-offer-card__value">con contratto di manutenzione</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">VERNICIATURA</h5>
                    <p class="cls-offer-card__value">riverniciato</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">GOMME</h5>
                    <p class="cls-offer-card__value">almeno il 40% di battistrada residuo</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">BATTERIA DI TRAZIONE*</h5>
                    <p class="cls-offer-card__value">capacità residua maggiore o uguale 50%</p>
                </div>
            </div>
            <div class="cls-offer-card">
                <img src="{{asset('site/images/advPremium.png')}}">
                <div class="cls-offer-card__item">
                    <h3 class="cls-offer-card__header">BENEFICI</h3>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">COMPONENTI DI SICUREZZA</h5>
                    <p class="cls-offer-card__value">pienamente efficaci</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">LIVELLO DI REVISIONE</h5>
                    <p class="cls-offer-card__value">ricondizionato a nuovo</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">TAGLIANDO</h5>
                    <p class="cls-offer-card__value">si</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">GARANZIA</h5>
                    <p class="cls-offer-card__value">3 mesi / 300 ore</p>
                    <p class="cls-offer-card__value">6 mesi / 600 ore</p>
                    <p class="cls-offer-card__value">con contratto di manutenzione</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">VERNICIATURA</h5>
                    <p class="cls-offer-card__value">a nuovo</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">GOMME</h5>
                    <p class="cls-offer-card__value">usura entro i limiti di sicurezza</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">BATTERIA DI TRAZIONE*</h5>
                    <p class="cls-offer-card__value">capacità residua ≥ 40%</p>
                </div>
            </div>
            <div class="cls-offer-card">
                <img src="{{asset('site/images/advPremiumP.png')}}">
                <div class="cls-offer-card__item">
                    <h3 class="cls-offer-card__header">BENEFICI</h3>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">COMPONENTI DI SICUREZZA</h5>
                    <p class="cls-offer-card__value">pienamente efficaci</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">LIVELLO DI REVISIONE</h5>
                    <p class="cls-offer-card__value">ricondizionato</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">MANUTENZIONE PERIODICA</h5>
                    <p class="cls-offer-card__value">si</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">GARANZIA</h5>
                    <p class="cls-offer-card__value">3 mesi / 300 ore</p>
                    <p class="cls-offer-card__value">estesa a 6 mesi / 600 ore</p>
                    <p class="cls-offer-card__value">con contratto di manutenzione</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">VERNICIATURA</h5>
                    <p class="cls-offer-card__value">sì</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">GOMME</h5>
                    <p class="cls-offer-card__value">battistrada residuo ≥ 40%</p>
                </div>
                <div class="cls-offer-card__item">
                    <h5 class="cls-offer-card__label">BATTERIA DI TRAZIONE*</h5>
                    <p class="cls-offer-card__value">capacità residua ≥ 50%</p>
                </div>
            </div>
        </div>
        <p class="font-italic mt-25">*Capacita' residua come da prove di funzionalità indicate nel foglio di lavoro
            rilasciato con il carrello</p>
    </section>
    <section class="mt-25 mb-25">
        <h2 class="text-center mb-25">Perché scegliere i carrelli elevatori MyUsato CLS?</h2>
        <div class="usato-garantito-wrapper">
            <div class="usato-garantito__content">
                <p>Ci sono <strong>almeno 5 buone ragioni </strong>per scegliere il My Usato® CLS: opportunità,
                    convenienza, garanzia, ampia gamma e un'eccezionale offerta a <strong>tasso zero. </strong>  </p>

                <ol>
                    <li>L'<strong>OPPORTUNITA'</strong> di trovare il carrello elevatore che risponde alle proprie
                        specifiche esigenze ed
                        in
                        ottime condizioni.
                    </li>
                    <li>L'<strong>OPPORTUNITA'</strong>di trovare il carrello elevatore che risponde alle tue
                        specifiche esigenze ed in ottime condizioni.</li>
                    <li>La <strong> CONVENIENZA</strong>  di trovare il carrello elevatore che risponde alle tue specifiche esigenze ad un prezzo competitivo</li>
                    <li>La<strong>GARANZIA </strong>  fino a 9 mesi.</li>
                    <li>La<strong>GAMMA</strong> in pronta consegna e personalizzabile.</li>
                    <li>L'<strong>OFFERTA</strong> a tasso zero.</li>
                </ol>
                <p>&nbsp;Quando si sceglie un <strong>carrello elevatore usato</strong> si punta all&#39;<strong>ottimizzazione dei costi</strong>,
                    alla&nbsp;<strong>qualit&agrave;&nbsp;</strong>e alla&nbsp;<strong>sicurezza garantita</strong>. Tutti
                    i carrelli elevatori della proposta My Usato&reg; CLS vengono sottoposti a&nbsp;<strong>minuziose verifiche</strong>&nbsp;da parte
                    di tecnici qualificati. Prima di entrare a far parte della proposta My Usato&reg; CLS ogni carrello deve superare rigidi<strong>&nbsp;controlli
                        di sicurezza&nbsp;e&nbsp;prove complete di funzionalit&agrave;</strong>&nbsp;che solo CLS, con i suoi 70 anni di esperienza nel settore, &egrave; in
                    grado di garantire. Le macchine usate vengono rigorosamente aggiornate secondo le vigenti <strong>normative di sicurezza</strong>&nbsp;per garantirti
                    un usato veramente SICURO. La proposta My Usato&reg; CLS si completa con un&#39;<strong>ampia disponibilit&agrave;</strong>&nbsp;di modelli
                    in&nbsp;<strong>pronta consegna</strong>, la possibilit&agrave; di personalizzazione, le soluzioni di finanziamento e la garanzia da 3 mesi a 9 mesi.
                    Non perdere l&#39;occasione di provare uno dei nostri carrelli My Usato&reg; perch&eacute; &egrave; come se non fosse stato... mai usato.</p>
            </div>
            <div class="usato-garantito__image">
                <div class="usato-garantito__image__box">
                    <img src="{{asset('site/images/usatoGarantito.png')}}">
                    <div>
                        <p class="usato-garantito__image__box__main-text">
                            Compra un <strong>My Usato© CLS</strong> con la formula da 6 minirate + maxi rata finale, a
                            <strong>tasso 0</strong>!
                            Dopo una <strong>prova di 6 mesi</strong> se paghi la maxirata finale puoi <strong>riscattare</strong>
                            la macchina. Oppure
                            puoi decidere di <strong>restituirla</strong> a CLS al prezzo della rata finale.
                        </p>
                        <div class="usato-garantito__image__box__secondary-text">
                            <p class="">
                                <strong>Decisamente un'offerta eccezionale!</strong>
                            </p>
                            <div class="usato-garantito__image__box__star">
                                <img src="{{asset('site/images/coccarda.png')}}">
                                <p class="white-text font-12 text-center p-10">
                                    Se compri un
                                    carrello MyUsato
                                    Quality o Premium
                                    hai in regalo una
                                    MyUsato Box
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mt-25 mb-25">
        <h2 class="text-center mb-25">Carrelli Elevatori - Usato Garantito: i 6 passi per una nuova vita</h2>
        <div class="nostri-wrapper">
            <div class="nostri-wrapper__item">
                <div class="nostri-wrapper__image">
                    <img src="https://myusato.cls.it/site/images/1.JPG" width="250" height="150" style="background-color: rgba(0,0,0,0.8); max-width: 100%;filter: brightness(0.4);">
                    <h3 class="nostri__text__number" style="color: white">01.</h3>
                    <h3 class="nostri__text__heading" style="color: white">CHECK INIZIALE</h3>
                </div>
                <div class="nostri-wrapper__text">
                    <p>Quando una macchina arriva nelle nostre officine viene fatto un controllo
                        generale e tutti i componenti essenziali per la sicurezza vengono sostituiti
                        con ricambi originali.</p>
                </div>
            </div>

            <div class="nostri-wrapper__item">
                <div class="nostri-wrapper__image">
                    <img src="https://myusato.cls.it/site/images/2.JPG" width="250" height="150" style="background-color: rgba(0,0,0,0.8); max-width: 100%;filter: brightness(0.4);">
                    <h3 class="nostri__text__number" style="color: white">02.</h3>
                    <h3 class="nostri__text__heading" style="color: white">LAVAGGIO E PULIZIA</h3>
                </div>
                <div class="nostri-wrapper__text">
                    <p>La macchina viene quindi smontata e tutti i componenti vengono puliti e lavati.
                        I liquidi di esercizio esausti vengono smaltiti nel rispetto delle normative ambientali e vengono sostituiti con liquidi nuovi.
                    </p>
                </div>
            </div>

            <div class="nostri-wrapper__item">
                <div class="nostri-wrapper__image">
                    <img src="https://myusato.cls.it/site/images/3.JPG" width="250" height="150" style="background-color: rgba(0,0,0,0.8); max-width: 100%;filter: brightness(0.4);">
                    <h3 class="nostri__text__number" style="color: white">03.</h3>
                    <h3 class="nostri__text__heading" style="color: white">RICONDIZIONAMENTO</h3>
                </div>
                <div class="nostri-wrapper__text">
                    <p>I componenti usurati vengono riparati laddove possibile o sostituiti con ricambi originali. </p>
                </div>
            </div>

            <div class="nostri-wrapper__item">
                <div class="nostri-wrapper__image">
                    <img src="https://myusato.cls.it/site/images/4.JPG" width="250" height="150" style="background-color: rgba(0,0,0,0.8); max-width: 100%;filter: brightness(0.4);">
                    <h3 class="nostri__text__number" style="color: white">04.</h3>
                    <h3 class="nostri__text__heading" style="color: white">VERNICIATURA</h3>
                </div>
                <div class="nostri-wrapper__text">
                    <p>Anche l’occhio vuole la sua parte: i carrelli vengono stuccati, carteggiati e verniciati.</p>
                </div>
            </div>

            <div class="nostri-wrapper__item">
                <div class="nostri-wrapper__image">
                    <img src="https://myusato.cls.it/site/images/5.JPG" width="250" height="150" style="background-color: rgba(0,0,0,0.8); max-width: 100%;filter: brightness(0.4);">
                    <h3 class="nostri__text__number" style="color: white">05.</h3>
                    <h3 class="nostri__text__heading" style="color: white">CONTROLLO BATTERIA</h3>
                </div>
                <div class="nostri-wrapper__text">
                    <p>Viene eseguito un test per verificare la capacità residua della batteria. Essa viene poi controllata accuratamente
                        per verificarne l’adeguata funzionalità funzionalità e, se necessario, ne vengono sostituiti gli elementi non più efficienti e performanti. </p>
                </div>
            </div>

            <div class="nostri-wrapper__item">
                <div class="nostri-wrapper__image">
                    <img src="https://myusato.cls.it/site/images/6.JPG" width="250" height="150" style="background-color: rgba(0,0,0,0.8); max-width: 100%;filter: brightness(0.4);">
                    <h3 class="nostri__text__number" style="color: white">06.</h3>
                    <h3 class="nostri__text__heading" style="color: white">CHECK FINALE</h3>
                </div>
                <div class="nostri-wrapper__text">
                    <p>Alla fine delle lavorazioni viene effettuato il collaudo per verificare la funzionalità della
                        macchina e di tutti i suoi componenti; prima della consegna vengono effettuate tutte le
                        verifiche in ottemperanza alle vigenti normative sulla sicurezza.
                    </p>
                </div>
            </div>

        </div>
    </section>
    <section class="mb-25 mt-25">
        <p class="text-center">

            La presente garanzia consiste nella riparazione o nella sostituzione, ad insindacabile giudizio della CLS,
            delle parti riconosciute come difettose e si attua presso le officine CLS. La garanzia di cui sopra non si applica
            alle parti soggette per loro natura a normale usura o a sostituzione periodica e non si applica qualora il carrello
            venga utilizzato in modo non conforme alle indicazioni del costruttore, venga modificato, riparato o smontato anche
            in parte in officine non autorizzate da CLS e non sia immediatamente fermato in attesa di riparazione qualora il suo
            funzionamento risultasse difettoso.


        </p>
        <div class="brochure-btn mt-20">
            <a class="btn btn-primary" href="#" style="    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 100%;
    height: 48px;
    cursor: pointer;
    background-color: #ffcb0f;
    border: 1px solid #ffcb0f;
    border-radius: 50px;
    text-transform: uppercase;">SCARICA BROCHURE</a>
        </div>
    </section>

</div>


@include('site.partiales._contactform')
<!-- Altre società del gruppo -->

@include('site.partiales._group')
<!-- Footer -->
@include('site.partiales._footer')

<script>
    var btnMenu = document.getElementById("btnMenu");
    var menuMob = document.getElementById("menuMob");
    var closeMenu = document.getElementById("closeMenu");

    btnMenu.addEventListener("click", function () {
        menuMob.classList.add("menuOpen");
    });

    closeMenu.addEventListener("click", function () {
        menuMob.classList.remove("menuOpen");
    });

    var scrollToTopBtn = document.getElementById("scrollToTopBtn");
    var rootElement = document.documentElement;

    function scrollToTop() {
        rootElement.scrollTo({
            top: 0,
            behavior: "smooth"
        })
    }

    scrollToTopBtn.addEventListener("click", scrollToTop);
</script>
</body>

</html>

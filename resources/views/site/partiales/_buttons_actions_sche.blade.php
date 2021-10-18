@if(session()->has('message'))
    <center>
        <div class="alert alert-success" style="color: white;
    background-color: #07ff03;
    border-color: #15ff05;
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-top-color: transparent;
    border-right-color: transparent;
    border-bottom-color: transparent;
    border-left-color: transparent;
    border-radius: 4px;">
            {{ session()->get('message') }}
        </div>
    </center>
@endif
@if(session()->has('alert'))
    <center>
        <div class="alert alert-success" style="color: white;
    background-color: #ff0505;
    border-color: #15ff05;
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-top-color: transparent;
    border-right-color: transparent;
    border-bottom-color: transparent;
    border-left-color: transparent;
    border-radius: 4px;">
            {{ session()->get('alert') }}
        </div>
    </center>
@endif

<a href="<?php if (Auth::check()) {
    echo route('richiedi-info', ['offerId' => $offerId]);
} else {
    echo "http://login.cls.it/login?sso=" . config('session.sso_token');
} ?>"
   class="button mb-40 text-center richiedi-info">{!! Auth::check() ? '' : '<i class="material-icons font-30">lock</i> ' !!}{{__('Request Info')}}</a>

@auth
    <?php
    $role = auth()->user()->getrole();
    if($role[0]->id == 1 | $role[0]->id == 5 | $role[0]->id == 8){
        $check_op = new \App\Models\Admin\Offert();
    ?>
    @if(!$check_op->userHasOption($offerId))
    <button id="searchclient" class="button mb-40 text-center searchclient">Opziona prodotto</button>
 <!--   <a id="choose-product-action" href="a" class="button mb-15 text-center">{{__('Choose Productsw')}}</a> -->
    @else
        <center>
            <a href="a" id="choose-product-action"> <span style="background-color: #337ab7;display: inline; padding: .2em .6em .3em; font-size: 125%; font-weight: 700; line-height: 1; color: #fff; text-align: center; white-space: nowrap; vertical-align: baseline;border-radius: .25em;" class="label label-primary">
            Macchina opzionata
        </span></a>
        </center>
        <br>
            @endif
    <?php } ?>
@endauth

<a id="add-to-catalog" href="<?php if(Auth::check())
{?>{{$isInCatalog ? route('deletemycatalog',['idoffert' => $offerId]) : route('addtomycatalog', ['type'=> $type, 'id_offert' => $offerId]) }}
<?php
}else {
    echo "http://login.cls.it/login?sso=" . config('session.sso_token');
} ?>"
   class="button mb-15 text-center">{!! Auth::check() ? '' : '<i class="material-icons font-30">lock</i> ' !!}{{$isInCatalog ? __('Rimuovi dal catalogo') : __('Add To Catalog')}}</a>


<script>
    window.type = {!! json_encode($type, JSON_HEX_TAG) !!};
    window.offerId = {!! json_encode($offerId, JSON_HEX_TAG) !!};
    window.isInCatalog = {!! json_encode($isInCatalog, JSON_HEX_TAG) !!};

    $(document).ready(() => {
        options();
        richiediInfo();
        searchclient();

    });

    function options() {
        if (document.getElementById('choose-product-action')) {
            document.getElementById('choose-product-action').addEventListener('click', (ev) => {
                ev.preventDefault();
                const opzionaProdotto = document.getElementById('opziona-prodotto');
                opzionaProdotto.style.display = "flex";
                const closeIcon = document.querySelector('#opziona-prodotto .close-icon').addEventListener('click', () => {
                    opzionaProdotto.style.display = 'none';
                });

                showLoaderOptions();
                $('.opziona-content').hide();
                $.ajax({
                    type: "GET",
                    url: '/api/options',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    data: {
                        offerId
                    },
                    success: successHandler
                })
            });

        }
    }

    function richiediInfo() {
        $('.richiedi-info').on('click', (ev) => {
            ev.preventDefault();
            $('.richiedi-info-dialog-wrapper').show();
            $('.searchclient-dialog-wrapper').hide();

        })
    }

    function searchclient() {
        $('.searchclient').on('click', (ev) => {
            ev.preventDefault();
            $('.richiedi-info-dialog-wrapper').hide();
            $('.searchclient-dialog-wrapper').show();
        })
    }

    function successHandler(options) {
        $('.searchclient-dialog-wrapper').hide();
        showLoaderOptions();
        let counter = 1;
        $('.opziona-content').show();
        $('#opziona-prodotto table tbody').remove();
        const tbody = document.createElement('tbody');

        $('#options-count').text(options.length)
        hideLoaderOptions();
        if (!options.length) {
            $('.no-options-msg').show();
            $('#opziona-prodotto table').hide();
            $('.options-count-msg').hide();
        } else {
            $('.no-options-msg').hide();
            $('#opziona-prodotto table').show();
            $('.options-count-msg').show();
        }
        options.forEach(option => {
            const tableRow = document.createElement('tr');
            const td1 = document.createElement('td');
            const td2 = document.createElement('td');
            const td3 = document.createElement('td');

            td1.textContent = counter++;
            td2.textContent = option.user.name + ' ' + option.user.surname;
            const date = new Date(option.created_at);
            td3.textContent = date.toLocaleDateString('it-IT', {day: '2-digit', month: '2-digit', year: '2-digit'});

            $('#opziona-prodotto table').append(tbody);
            tableRow.append(td1, td2, td3);

            $('#opziona-prodotto table tbody').append(tableRow);
        });
    }

    function sendoption(cclient){


        $.ajax({
            type: "POST",
            url: '/api/options?cclient='+cclient,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            data: {
                offerId
            },
            success:
                setTimeout(function () {

                        window.location.replace("{{Request::url()}}")

                }, 3000),


        });
    }

    $(document).ready(() => {
        window.offerId = {!! json_encode($offerId, JSON_HEX_TAG) !!};
        $('#submit-option').click(function () {
            $.ajax({
                type: "POST",
                url: '/api/options',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                data: {
                    offerId
                },
                success: successHandler
            })
        });
    });

    function hideLoaderOptions() {
        document.querySelector('.loader-wrapper').style.display = 'none';
    }

    function showLoaderOptions() {
        document.querySelector('.loader-wrapper').style.display = 'block';
    }
</script>

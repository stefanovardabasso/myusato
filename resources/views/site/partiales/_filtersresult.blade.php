<div class="md_col-3 col-12 md_px-15">
    <h4 class="font-25 text-secondary weight-500 mb-10">Filtri di ricerca</h4>
    <a href="" class="underline weight-600">Reimposta filtri di ricerca</a>
    <div class="filter-bar mt-10">
        <div class="bc-primary p-10">
            <span class="font-20">Macchina</span>
        </div>
        <div class="bc-secondary p-15 pb-40 filters-container">
            @foreach($sideFiltersInfo->questionsFilters as $sideFilter)
                <span class="text-secondary font-18 filter-type mt-30 filter-label"
                      style="display: {{$sideFilter->cod_question == 'Prezzo_fino_A_Selezione' ? "none" : "block"}};"
                      data-id="{{$sideFilter->id}}">{{$sideFilter->questionsFiltersTraduction->label}}</span>
                @if ($sideFilter->type === 'picklist')
                    @for($i = 0; $i < count($sideFilter->values); $i++)
                        @if ($i > 1)
                            @break
                        @endif
                        <div class="checkbox-group checkbox-filter mt-15">
                            <input {{ $sideFilter->values[$i]['selected'] ? "checked" : ""  }} type="checkbox"
                                   id="{{$sideFilter->id . '_' . $sideFilter->values[$i]['value']}}"
                                   data-label-id="{{$sideFilter->id}}"/>
                            <label for="{{$sideFilter->id. '_'. $sideFilter->values[$i]['value']}}" class="text-light"
                                   data-question-code="{{$sideFilter->cod_question}}"
                                   data-question-value="{{$sideFilter->values[$i]['value']}}">{{$sideFilter->values[$i]['value']}}</label>
                        </div>

                    @endfor
                    @if (count($sideFilter->values) > 2)
                        <div class="more-filters" data-id="{{$sideFilter->id}}">
                            @for($i = 2; $i < count($sideFilter->values); $i++)
                                <div class="checkbox-group checkbox-filter mt-15">
                                    <input {{ $sideFilter->values[$i]['selected'] ? "checked" : ""  }} type="checkbox"
                                           id="{{$sideFilter->id . '_' . $sideFilter->values[$i]['value']}}"
                                           data-label-id="{{$sideFilter->id}}"/>
                                    <label for="{{$sideFilter->id. '_'. $sideFilter->values[$i]['value']}}"
                                           class="text-light" data-question-code="{{$sideFilter->cod_question}}"
                                           data-question-value="{{$sideFilter->values[$i]['value']}}">{{$sideFilter->values[$i]['value']}}</label>
                                </div>
                            @endfor
                        </div>
                        <a href="" id="{{$sideFilter->id}}" class="block mt-20 text-light show-more-filters">+ Mostra
                            tutti</a>
                    @endif

                @elseif ($sideFilter->type === 'range' && $sideFilter->cod_question != 'Prezzo_fino_A_Selezione')
                    <div class="bc-secondary mb-40 pr-5">
                        <div class="filter-price range-filters mt-15"
                             data-values="{{implode(';',$sideFilter->values)}}"
                             data-cod-question="{{$sideFilter->cod_question}}"></div>
                        <input class="range-value {{$sideFilter->cod_question}}" type="hidden"
                               name="{{$sideFilter->cod_question}}_start"
                               data-name="{{$sideFilter->questionsFiltersTraduction->label}}">
                        <input class="range-value {{$sideFilter->cod_question}}" type="hidden"
                               name="{{$sideFilter->cod_question}}_end"
                               data-name="{{$sideFilter->questionsFiltersTraduction->label}}">
                    </div>

            @endif


        @endforeach
        <!-- Modello -->
            <span class="text-secondary font-18 filter-type mt-30">Modello</span>
            <input type="text" class="input mt-10" placeholder="Modello" id="search-by-model">
        </div>


        <div class="bc-secondary p-15 pr-20">
            <!-- Prezzo -->
            <span class="text-secondary font-18 filter-type">{{ __('Prezzo') }}</span>
            <div id="price-filter" class="filter-price mt-15 mb-60"></div>
            <input class="price" type="hidden" name="price_start" data-name="Prezzo">
            <input class="price" type="hidden" name="price_end" data-name="Prezzo">

            <!-- Codice MyUsato -->
{{--            <span class="text-secondary font-18 filter-type mt-30">Codice MyUsato</span>--}}
{{--            <input type="text" class="input mt-10" placeholder="Codice">--}}


        </div>
    </div>
</div>
<script>
    window.maxValuesForRanges = {!! json_encode($maxValuesForRanges, JSON_HEX_TAG) !!};

    function initFiltersSlider(reqParams) {
        const sliders = $('.range-filters');

        sliders.each(function (index, slider) {
            const values = $(this).data('values');
            let parsedValues = values.split(';').map(v => {
                let parsedValue = v.trim();
                parsedValue = v.replace(/\D/g, '');
                parsedValue = Number(parsedValue);
                return parsedValue;
            });

            const cod_question = slider.dataset.codQuestion;

            if (maxValuesForRanges[cod_question]) {
                parsedValues = parsedValues.filter(val => {
                    return val <= Number(maxValuesForRanges[cod_question]);
                })
                parsedValues.push(Number(maxValuesForRanges[cod_question]));
            }
            const range = {};
            range.min = parsedValues[0];
            range.max = parsedValues[parsedValues.length - 1];

            for (let i = 1; i < parsedValues.length - 1; i++) {
                const percent = ((i / parsedValues.length) * 100).toFixed(2) + '%';
                range[percent] = parsedValues[i];
            }

            noUiSlider.create(slider, {
                start: [Math.min(...parsedValues), Math.max(...parsedValues)],
                range: range,
                snap: true,
                tooltips: [wNumb({
                    decimals: 0,
                }), wNumb({
                    decimals: 0,
                }),],
                behaviour: 'drag',
                connect: true,
            })

            // if (maxValuesForRanges[cod_question] && reqParams.has(cod_question + '_end')) {
            //     // slider.noUiSlider.set([null, Number(maxValuesForRanges[cod_question])]);
            //     reqParams.set(cod_question + '_end',maxValuesForRanges[cod_question] );
            //     updateHistoryState(reqParams);
            // }
            if (reqParams.has(cod_question + '_start')) {
                slider.noUiSlider.set([reqParams.get(cod_question + '_start'), null]);
                $(`input[name="${cod_question}_start"]`).val(reqParams.get(cod_question + '_start'));
            } else {
                $(`input[name="${cod_question}_start"]`).val(Math.min(...parsedValues));
            }

            if (reqParams.has(cod_question + '_end')) {
                slider.noUiSlider.set([null, reqParams.get(cod_question + '_end')]);
                $(`input[name="${cod_question}_end"]`).val(reqParams.get(cod_question + '_end'));
            } else {
                $(`input[name="${cod_question}_end"]`).val(Math.max(...parsedValues));
            }

            slider.noUiSlider.on('change', function (values, handle, unencoded, tap, positions, noUiSlider) {
                const id = $(noUiSlider.target).data('cod-question');
                $(`input[name="${id}_start"]`).val(values[0]);
                $(`input[name="${id}_end"]`).val(values[1]);

                $(`.range-value.${id}`).trigger('change');
            });
        });
    }

    function initPriceSlider(reqParams) {

        const priceFilter = document.getElementById('price-filter');
        const priceValues = {
            min: Number({!! json_encode($price['min'], JSON_HEX_TAG ) !!}),
            max: Number({!! json_encode($price['max'], JSON_HEX_TAG ) !!})
        }
        noUiSlider.create(priceFilter, {
            start: [priceValues.min, priceValues.max],
            step: 10,
            behaviour: 'drag',
            connect: true,
            range: priceValues,
            tooltips: [wNumb({
                decimals: 2,
                prefix: '€'
            }), wNumb({
                decimals: 2,
                prefix: '€'
            })],
        });
        if (reqParams.has('price_start')) {
            priceFilter.noUiSlider.set([reqParams.get('price_start'), null]);
            $('input[name="price_start"]').val(reqParams.get('price_start'))
        } else {
            $('input[name="price_start"]').val(priceValues.min);
        }

        if (reqParams.has('price_end')) {
            priceFilter.noUiSlider.set([null, reqParams.get('price_end')]);
            $('input[name="price_end"]').val(reqParams.get('price_end'))
        } else {
            $('input[name="price_end"]').val(priceValues.max);
        }

        priceFilter.noUiSlider.on('change', function (values, handle) {
            if (handle === 0) {
                $('input[name="price_start"]').val(values[handle])
            } else if (handle === 1) {
                $('input[name="price_end"]').val(values[handle])
            }
            $('input.price').trigger('change');
        });
    }


    function sort(reqParams) {
        $('.search-to-button.sort-button').on('click', function (ev) {
            ev.preventDefault();
            if ($(this).hasClass('asc')) {
                $(this).removeClass('asc');
                $(this).addClass('desc');
                $(this).find('i').text('south');
                $(this).attr('data-order', 'desc')
            } else {
                $(this).removeClass('desc');
                $(this).addClass('asc');
                $(this).find('i').text('north');
                $(this).attr('data-order', 'asc')
            }
            const value = $('#sort-select').children("option:selected").val();
            const order = $(this).attr('data-order');

            reqParams.set('sort', value);
            reqParams.set('order', order);

            updateHistoryState(reqParams);

            queryProducts(reqParams);
        });

        $('#sort-select').on('change', function () {
            const value = $(this).children("option:selected").val();
            const order = $('.search-to-button.sort-button').attr('data-order');

            reqParams.set('sort', value);
            reqParams.set('order', order);

            updateHistoryState(reqParams);

            queryProducts(reqParams)
        });
    }

    function addValuesToInputs() {
        $('.range-filters').each(function (ev) {
            const code = $(this).data('cod-question');
            const startValue = $(this).find($('.noUi-handle-lower')).attr('aria-valuenow');
            const endValue = $(this).find($('.noUi-handle-upper')).attr('aria-valuenow');
            $(`input[name="${code}_start"]`).val(startValue);
            $(`input[name="${code}_end"]`).val(endValue);
        });
    }

    function checkedOnLoad(reqParams) {
        const filteredParams = new URLSearchParams();
        reqParams.forEach((value, key) => {
            filteredParams.append(key.replaceAll('[]', ''), value);
        });

        filteredParams.forEach((value, key) => {
            const labelFor = $(`label[data-question-code="${key}"][data-question-value="${value.trim()}"]`).attr('for');
            $(`#${labelFor}`).prop('checked', true);
        });
    }

    function updateHistoryState(reqParams) {
        if (history.pushState) {

            const newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + reqParams.toString();

            $('#saved-filters').attr('href', window.location.protocol + "//" + window.location.host + '/save-filters?' + reqParams.toString());

            window.history.pushState({path: newurl}, '', newurl);
        }
    }

    window.loggedIn = {!! json_encode(Auth::check(), JSON_HEX_TAG) !!};
    window.configToken = {!! json_encode(config('session.sso_token'), JSON_HEX_TAG) !!};
    $(window).on('load', function () {
        addValuesToInputs();
    });
    $(document).ready(() => {
        let reqParams = new URLSearchParams(window.location.search);
        const parsedReqParams = new URLSearchParams();
        reqParams.forEach((val, key) => {
            if (key !== 'cod_fam' &&
                !key.endsWith('[]') &&
                key !== 'sort' && key !== 'order' &&
                !(key.endsWith('_start') || key.endsWith('_end')) &&
                !(key === 'model')) {
                key = key + '[]';
            }
            parsedReqParams.append(key, val);
        });

        reqParams = parsedReqParams;
        updateHistoryState(parsedReqParams);
        checkedOnLoad(reqParams);
        initPriceSlider(reqParams);
        initFiltersSlider(reqParams);
        sort(reqParams);

        if (reqParams.has('model')) {
            $('input#search-by-model').val(reqParams.get('model'));
        }

        Array.from(document.querySelectorAll('.show-more-filters')).forEach(el => el.addEventListener('click', (ev) => {
            ev.preventDefault();
            ev.target.classList.toggle('active');
            const id = ev.target.id;

            if (ev.target.classList.contains('active')) {
                ev.target.text = "- Mostra meno";
            } else {
                ev.target.text = "+ Mostra tutti";
            }

            document.querySelector(`.more-filters[data-id="${id}"]`).classList.toggle('active');
        }));

        $('input.price').on('change', (ev) => {
            if (!reqParams.has(ev.target.name)) {
                reqParams.append(ev.target.name, ev.target.value);
            }
            reqParams.set(ev.target.name, ev.target.value);
            updateHistoryState(reqParams);
            queryProducts(reqParams);
        });

        $('input.range-value').on('change', (ev) => {
            if (!reqParams.has(ev.target.name)) {
                reqParams.append(ev.target.name, ev.target.value);
            }
            reqParams.set(ev.target.name, ev.target.value);
            updateHistoryState(reqParams);
            queryProducts(reqParams);
        })
        document.querySelector('#search-by-model').addEventListener('input', (ev) => {
            if (ev.target.value == '' && reqParams.has('model')) {
                reqParams.delete('model');
            } else {
                reqParams.set('model', ev.target.value);
            }
            updateHistoryState(reqParams);
            queryProducts(reqParams);

        })
        // TODO: Maybe add this later
        // const rangeFiltersObj = new Map();
        // $('.range-value').each(function (el){
        //     const filterName = $(this).data('name');
        //
        //     if (!rangeFiltersObj.has(filterName)) {
        //         rangeFiltersObj.set(filterName, []);
        //     }
        //     rangeFiltersObj.get(filterName).push($(this).val())
        //
        // });
        //
        // rangeFiltersObj.forEach((val, key) => {
        //     console.log(`${val[0]} - ${val[1]}`);
        //    const activeFilter = createActiveFilterElement(`${key}: ${val[0]} - ${val[1]}`);
        //     document.querySelector('.cls-active-filters').appendChild(activeFilter);
        // });

        Array.from(document.querySelectorAll('.checkbox-group input[type="checkbox"]')).forEach(el => {
            if (el.checked) {
                const text = document.querySelector(`.filter-label[data-id="${el.dataset.labelId}"]`).textContent + ": " + document.querySelector(`label[for="${el.id}"]`).textContent;
                const activeFilter = createActiveFilterElement(text, el.id);
                document.querySelector('.cls-active-filters').appendChild(activeFilter);
            }

            el.addEventListener('click', (ev) => {
                const id = ev.target.id;
                const labelId = ev.target.dataset.labelId;
                const questionCode = document.querySelector(`label[for="${id}"]`).dataset.questionCode;
                const questionValue = document.querySelector(`label[for="${id}"]`).dataset.questionValue;

                if (ev.target.checked) {
                    const text = document.querySelector(`.filter-label[data-id="${labelId}"]`).textContent + ": " + document.querySelector(`label[for="${id}"]`).textContent;
                    const activeFilter = createActiveFilterElement(text, id);
                    document.querySelector('.cls-active-filters').appendChild(activeFilter);

                    //make ajax
                  let mquestionValue = questionValue.replace('+', ' ');
                    reqParams.append(questionCode + '[]', mquestionValue);
                    updateHistoryState(reqParams);
                    console.log(reqParams);
                    queryProducts(reqParams);
                } else {
                    if (document.querySelector(`.active-filter__item[data-id="${id}"]`)) {
                        document.querySelector(`.active-filter__item[data-id="${id}"]`).remove();
                    }

                    if (reqParams.has(questionCode + '[]')) {
                        let filteredParams = reqParams.getAll(questionCode + '[]').filter(el => el !== questionValue);
                        reqParams.delete(questionCode + '[]');
                        filteredParams.forEach(p => {
                            p = p.replace('+', ' ');
                            reqParams.append(questionCode + '[]', p);
                        })
                    }

                    updateHistoryState(reqParams);
                    //make ajax
                    console.log(reqParams);
                    queryProducts(reqParams);
                }
            });
        });
    });

    async function queryProducts(req) {

        const url = '/api/products';
        const request = {
            method: 'POST',
            body: req,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }
        showLoader();
        const result = await fetch(url, request);
        if (result.ok) {
            const jsonResponse = await result.json();
            hideLoader();

            if (document.querySelector('.new-ads .cls-ads-wrapper')) {
                document.querySelector('.new-ads .cls-ads-wrapper').remove()
            }

            const productsElements = createProductsElement(jsonResponse);

            document.querySelector('.new-ads').appendChild(productsElements);

            $('.ad-add').each(function (el) {
                $(this).on('click', function (ev) {
                    ev.preventDefault();
                    const offerId = $(this).data('offer-id');
                    const type = $(this).data('type');
                    console.log($(this));
                    const isInCatalog = $(this).find('i').text() === 'delete';
                    const ajaxSettings = {
                        url: $(this).find('i').text() === 'delete' ? '/deletemycatalog' : '/addtomycatalog',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        type: 'GET',
                        success:  () => {
                            if ($(this).find('i').text() === 'add') {
                                $(this).find('i').text('delete');
                            } else {
                                $(this).find('i').text('add');
                            }
                        },
                        error: function () {
                            alert('error');
                        }
                    };
                    if (isInCatalog) {
                        ajaxSettings.data = {
                            idoffert: offerId
                        }
                    } else {
                        ajaxSettings.data = {
                            id_offert: offerId,
                            type: type,
                        };
                    }
                    $.ajax(ajaxSettings);
                });
            });
            $('.offers-count').text(jsonResponse.length + ' annunci in vendita');
            if(jsonResponse.length == 0){
                $('.offers-count').text('Non ci sono annunci in vendita');
            }

        } else {
            console.error(result.statusText);
        }
    }

    function createProductsElement(offers) {
        const clsAdsWrapper = document.createElement('div');
        clsAdsWrapper.classList = 'flex md_row-15 flex-wrap cls-ads-wrapper';

        const offersElements = offers.map(offer => {
            // Create elemnets
            const productElement = document.createElement('div');
            const productImageWrapper = document.createElement('div');
            const productImage = document.createElement('img');
            const productTitleWrapper = document.createElement('div');
            const productTitleWrapper2 = document.createElement('div');
            const productTitleWrapper3 = document.createElement('div');

            const productTitle = document.createElement('div');
            const productTitleSpan = document.createElement('span');



            const addProductLink = document.createElement('a');
            const addProductIcon = document.createElement('i');
            const productTitlesWrapper = document.createElement('div');
            const productTitlesList = document.createElement('ul');
            const productTitlesListItems = [];
            const productTitlesListItemsLabels = [];
            const productTitlesListItemsValues = [];
            for (let i = 0; i < 3; i++) {
                productTitlesListItems.push(document.createElement('li'));
                productTitlesListItemsLabels.push(document.createElement('span'));
                productTitlesListItemsValues.push(document.createElement('span'));
            }
            const productInfoElement = document.createElement('div');
            const productInfoList = document.createElement('ul');
            const productInfoListItems = [];
            const productInfoListItemsLabels = [];
            const productInfoListItemsValues = [];

            for (let i = 0; i < 6; i++) {
                productInfoListItems.push(document.createElement('li'));
                productInfoListItemsLabels.push(document.createElement('span'));
                productInfoListItemsValues.push(document.createElement('span'));
            }
            const viewProductLink = document.createElement('a');
            const bundleTable = document.createElement('table');
            bundleTable.innerHTML = '' +
                '<thead>' +
                '<tr>' +
                '<th class="p-15">Marca</th>' +
                '<th class="p-15">Modello</th>' +
                '</tr>' +
                '</thead>';

            bundleTable.classList = 'off-table';

            // Add classes to elements
            productElement.classList = 'ad-box-products';
            productImageWrapper.classList = 'ad-image';
            productTitleWrapper.classList = 'ad-tags absolute top-10 left-0 z-10';
            productTitle.classList = 'tag-1';
            productTitle.style = 'background-color: #1a9910; border: 3px solid #1a9910; color: white;';
            addProductLink.classList = 'ad-add absolute top-10 right-10 z-10';
            addProductIcon.classList = 'material-icons font-30';
            productTitlesWrapper.classList = 'ad-titles';
            productTitlesList.classList = 'text-primary bc-secondary p-15';
            productTitlesListItems.map(el => {
                el.classList = 'flex justify-between align-center mb-15';
                return el;
            });
            productTitlesListItemsLabels.map(el => {
                el.classList = 'weight-400';
                return el;
            });
            productTitlesListItemsValues.map(el => {
                el.classList = 'font-18';
                return el;
            });
            productInfoElement.classList = 'ad-info';
            productInfoListItems.map(el => {
                el.classList = 'flex justify-between mb-12';
                return el;
            });
            productInfoListItemsLabels.map(el => {
                el.classList = 'weight-400';
                return el;
            });

            viewProductLink.classList = 'button';

            if (loggedIn) {
                addProductLink.href = `/addtomycatalog?id_offert=${offer.id}&type=${offer.type}`;
            } else if (configToken) {
                addProductLink.href = `http://login.cls.it/login?sso=${configToken}`;
            }
            addProductLink.dataset.offerId = offer.id;
            addProductLink.dataset.type = offer.type;

            if (offer.isInCatalog) {
                addProductIcon.textContent = 'delete';
            } else {
                addProductIcon.textContent = 'add';
            }

            productTitleSpan.textContent = offer.title1;
            if (offer.gallery[0]) {
                if(offer.gallery[0].name == 'empty.png'){
                    productImage.src = '/upload/empty.png';
                }else{
                    productImage.src = '/upload/' + offer.gallery[0].name;
                }

                 // productImage.src = '/upload/803.jpg';

            }else{
                productImage.src = '/upload/empty.png';
            }
            productTitlesListItemsValues[1].textContent = offer.brand + '-' + offer.model + '-' + offer.myUsatoCode;

            <?php if(app()->getLocale() == 'it'){ ?>
            productInfoListItemsLabels[0].textContent =  offer.product.lines[0].label_it;
            productInfoListItemsLabels[1].textContent = offer.product.lines[1].label_it;
            productInfoListItemsLabels[2].textContent = offer.product.lines[2].label_it;
            productInfoListItemsLabels[3].textContent = offer.product.lines[3].label_it;
            productInfoListItemsLabels[4].textContent = 'Anno';
           <?php if(Auth::check()){ ?>
            productInfoListItemsLabels[5].textContent = 'Prezzo';
            <?php }else{ ?>
            productInfoListItemsLabels[5].innerHTML  = " <a style='width: 270% !important;' href='http://login.cls.it/login?sso={{  config('session.sso_token')  }}' class='button'>Vide prezzo</a>";
            <?php }?>
            productInfoListItemsValues[0].textContent = offer.product.lines[0].ans_it;
            productInfoListItemsValues[1].textContent = offer.product.lines[1].ans_it;
            productInfoListItemsValues[2].textContent = offer.product.lines[2].ans_it;
            productInfoListItemsValues[3].textContent = offer.product.lines[3].ans_it;
            productInfoListItemsValues[4].textContent = offer.product.year;
            <?php if(Auth::check()){ ?>
                let num_price = offer.price
            productInfoListItemsValues[5].textContent =  formatNumber(num_price);
            <?php } ?>
            <?php }else{ ?>

            productInfoListItemsLabels[0].textContent =  offer.product.lines[0].label_en;
            productInfoListItemsLabels[1].textContent = offer.product.lines[1].label_en;
            productInfoListItemsLabels[2].textContent = offer.product.lines[2].label_en;
            productInfoListItemsLabels[3].textContent = offer.product.lines[3].label_en;
            productInfoListItemsLabels[4].textContent = 'Year';
            productInfoListItemsLabels[5].textContent = 'Price';

            productInfoListItemsValues[0].textContent = offer.product.lines[0].ans_en;
            productInfoListItemsValues[1].textContent = offer.product.lines[1].ans_en;
            productInfoListItemsValues[2].textContent = offer.product.lines[2].ans_en;
            productInfoListItemsValues[3].textContent = offer.product.lines[3].ans_en;
            productInfoListItemsValues[4].textContent = offer.product.year;
            productInfoListItemsValues[5].textContent = formatNumber(offer.price);

            <?php } ?>



            if (offer.type === 'Bundle') {
                viewProductLink.href = '/product-bun-detail/' + offer.id;
            } else {
                viewProductLink.href = '/product-detail/' + offer.id;
            }
            viewProductLink.textContent = 'Scopri di più';

            //Make structure of element
            //Image
            productTitle.appendChild(productTitleSpan);
            if (offer.title2 !== 'undefined') {
                productTitleWrapper2.classList = 'ad-tags absolute top-10 left-0 z-10';
                const productTitle2 = document.createElement('div');
                const productTitleSpan2 = document.createElement('span');
                productTitle2.style = 'background-color: #1a9910; border: 3px solid #1a9910; color: white;';
                productTitleSpan2.textContent = offer.title2;
                productTitle2.appendChild(productTitleSpan2);
            }
            if (offer.title3 !== 'undefined') {
                productTitleWrapper3.classList = 'ad-tags absolute top-10 left-0 z-10';
                const productTitle3 = document.createElement('div');
                const productTitleSpan3 = document.createElement('span');
                productTitle3.style = 'background-color: #1a9910; border: 3px solid #1a9910; color: white;';
                productTitleSpan3.textContent = offer.title3;
                productTitle3.appendChild(productTitleSpan3);
                productTitleWrapper3.appendChild(productTitle3);
            }
            productTitleWrapper.appendChild(productTitle);

            addProductLink.appendChild(addProductIcon)

            productImageWrapper.appendChild(productTitleWrapper);
            productImageWrapper.appendChild(addProductLink);
            productImageWrapper.appendChild(productImage);

            //Titles
            if (offer.type === 'single') {
                const createdProductListItems = productTitlesListItems.map((el, index) => {
                    el.appendChild(productTitlesListItemsLabels[index]);
                    el.appendChild(productTitlesListItemsValues[index]);
                    return el;
                });
                productTitlesList.append(...createdProductListItems);
                productTitlesWrapper.appendChild(productTitlesList)
            } else if (offer.type === 'Bundle') {
                productTitlesWrapper.appendChild(bundleTable);
                const tbody = document.createElement('tbody');
                offer.bundle_products.forEach(p => {
                    const tr = document.createElement('tr');
                    const td1 = document.createElement('td');
                    const td2 = document.createElement('td');
                    td1.textContent = p.brand;
                    td2.textContent = p.model;
                    tr.append(td1, td2);
                    tbody.appendChild(tr);
                });

                bundleTable.appendChild(tbody);
            }
            //productInfo
            const createdProductInfoItems = productInfoListItems.map((el, index) => {
                el.appendChild(productInfoListItemsLabels[index]);
                el.appendChild(productInfoListItemsValues[index]);
                return el;
            });

            if (offer.type === 'single') {
                productInfoList.append(...createdProductInfoItems);
                productInfoElement.appendChild(productInfoList);
            }
            productInfoElement.appendChild(viewProductLink);
            productElement.appendChild(productImageWrapper);
            productElement.appendChild(productTitlesWrapper);
            productElement.appendChild(productInfoElement);

            const flexWrapper = document.createElement('div');
            flexWrapper.classList = 'md_col-4 col-12 md_px-15 mb-30';
            flexWrapper.appendChild(productElement);

            return flexWrapper;
        });


        clsAdsWrapper.append(...offersElements);


        return clsAdsWrapper;
    }

    function createActiveFilterElement(text, id = null) {
        const activeFilter = document.createElement('div');
        const closeIcon = document.createElement('i');
        const label = document.createElement('span');

        activeFilter.classList = 'inline-flex align-center bc-secondary pl-5 pr-12 py-3 mr-10 mt-10 active-filter__item';
        closeIcon.classList = 'material-icons mr-5 text-primary';
        label.classList = 'text-light';

        if (id !== null) {
            activeFilter.dataset.id = id;
        }

        closeIcon.innerText = 'close';
        label.textContent = text;

        activeFilter.appendChild(closeIcon);
        activeFilter.appendChild(label);

        closeIcon.addEventListener('click', (ev) => {
            ev.target.parentNode.remove();
            $(`#${id}`).trigger('click');
        });

        return activeFilter;
    }

    function formatNumber(num) {
        if(num){
            let str2 = '€';
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.').concat(str2);

        }

    }
</script>

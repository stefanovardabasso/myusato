<div class="filters filter-bar bc-secondary pt-30 pb-60 mb-50">
    <div class="container">

        <h2 class="section-title" style="color: #ffcb0f; margin-bottom: 2%">Cosa stai cercando?</h2>
        <div class="flex row-10">

        @foreach($filterButtons as $filterButton)
            <div class="col-2 px-10">
                <a href="{{route('search', ['filterId' => $filterButton->id])}}?cod_fam={{$filterButton->fam_code}}" class="block type-box bc-primary py-10 cls-filter-button " style="border-radius: 50px;">
                    <span><center>{{$filterButton->label}}</center></span>
                </a>
            </div>
        @endforeach
        </div>
{{--        @if(isset($filterInfo))--}}
{{--            <div class="flex flex-wrap justify-between px-15 md_px-0">--}}
{{--                <div class="flex">--}}
{{--                    <!----}}
{{--                    <div class="checkbox-group mr-50">--}}
{{--                        <input type="checkbox" id="1" checked/>--}}
{{--                        <label for="1" class="weight-500 text-light">Disponibile</label>--}}
{{--                    </div>--}}
{{--                    <div class="checkbox-group">--}}
{{--                        <input type="checkbox" id="2" checked/>--}}
{{--                        <label for="2" class="weight-500 text-light">Opzionabile</label>--}}
{{--                    </div>--}}
{{--                    -->--}}
{{--                </div>--}}
{{--                <div class="product-numbers">--}}
{{--                    <p class="text-primary font-30 flex uppercase align-center">--}}
{{--                        <i class="material-icons font-30">grade</i>--}}
{{--                        <span class="font-45 mx-15">{{$productsCount}}</span>prodotti totali--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        <form action="{{route('search',['filterId' => $filterInfo->id])}}" method="get" id="filters-form">--}}
{{--            <div class="md_row-30 flex flex-wrap mt-50" id="filters">--}}
{{--                <div class="md_col-3 col-12 mb-15 md_mb-0 px-15 md_px-30">--}}
{{--                    <select name="cod_fam" id="fam-selects" style="margin-bottom: 3%;">--}}
{{--                        @foreach($filterInfo->famSelects as $famSelect)--}}
{{--                            <option value="{{$famSelect->cod_fam}}">{{ $famSelect->{'option_'.app()->getLocale()} }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--                <div class="md_col-3 col-12 px-15 md_px-30" id="search">--}}
{{--                    <button type="submit" class="uppercase">Mostra tutti</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--        @else--}}
{{--            <h1 style="color: white;">Please, choose a filter</h1>--}}
{{--        @endif--}}
    </div>
</div>
<script>
    window.filtersInfo = {!! json_encode($filterInfo, JSON_HEX_TAG) !!}
    window.lang = {!! json_encode(app()->getLocale(), JSON_HEX_TAG) !!}

    const filtersForm = document.getElementById('filters-form');

    filtersForm.addEventListener('submit', (ev) => {
       const allSelects = document.querySelectorAll('#filters-form select');
       Array.from(allSelects).map(s => {
          if (s.name && !s.value) {
              s.name = "";
          }
       });
    });

    const famSelectsElement = document.getElementById('fam-selects');
    if (famSelectsElement) {
        famSelectsElement.addEventListener('change', (ev) => {
            if (document.getElementsByClassName('questions-filters').length > 0) {
                Array.from(document.getElementsByClassName('questions-filters')).forEach(x => x.remove())
            }

            const famSelectValue = ev.target.value;
            const chosenFamSelect = filtersInfo.fam_selects.find(fs => fs.cod_fam === famSelectValue);

            const MAX_SELECTS = chosenFamSelect.questions_filters.length > 6 ? 6 : chosenFamSelect.questions_filters.length;

            sortByOrderOfQuestion(chosenFamSelect.questions_filters);

            for (let i = 0; i < MAX_SELECTS; i++) {
                const wrapper = document.createElement('div');
                wrapper.classList = 'questions-filters md_col-3 col-12 mb-15 md_mb-0 px-15 md_px-30';

                if (chosenFamSelect.questions_filters[i].type === 'picklist') {
                    const questionsFiltersSelect = document.createElement('select');
                    wrapper.append(questionsFiltersSelect);
                    if (chosenFamSelect.questions_filters[i].values) {
                        let values = chosenFamSelect.questions_filters[i].values.split('(');
                        if (lang === 'en') {
                            if (values[1]) {
                            values = values[1].slice(0,-1).split(';')
                            } else {
                                values = values[0].split(';');
                            }
                        } else if (lang === 'it') {
                         values = values[0].split(';');
                        }

                        const firstOption = document.createElement('option');
                        firstOption.text = chosenFamSelect.questions_filters[i].questions_filters_traduction.find(qfs => (lang === 'en') ? qfs.lang === "E" : qfs.lang === "I").label.trim();
                        firstOption.value = "";
                        questionsFiltersSelect.name = chosenFamSelect.questions_filters[i].cod_question;

                        const options = values.filter(v => v).map(v => {
                            const option = document.createElement('option');

                            option.text = v.trim();
                            option.value = v.trim();

                            return option;
                        });

                        options.unshift(firstOption);
                        options.forEach(o => {
                            questionsFiltersSelect.add(o);
                        })

                        document.getElementById('search').before(wrapper);
                    }
                }
                else if (chosenFamSelect.questions_filters[i].type === 'range') {
                    if (chosenFamSelect.questions_filters[i].values) {
                        const values = chosenFamSelect.questions_filters[i].values.split(';');
                        const label = document.createElement('label');
                        label.textContent = chosenFamSelect.questions_filters[i].questions_filters_traduction.find(qfs => (lang === 'en') ? qfs.lang === "E" : qfs.lang === "I").label.trim();
                        label.classList.add('filter-price-label');
                        label.classList.add('text-center');

                        const questionsFiltersRange = document.createElement(('div'));

                        questionsFiltersRange.classList = 'filter-price range-filters';
                        questionsFiltersRange.dataset.values =  values.join(';');
                        questionsFiltersRange.dataset.codQuestion = chosenFamSelect.questions_filters[i].cod_question;
                        const parsedValues = values.map(v => {
                            let parsedValue = v.trim();
                            parsedValue = v.replace(/\D/g, '');
                            parsedValue = Number(parsedValue);
                            return parsedValue;
                        });

                        const range = {};
                        range.min = parsedValues[0];
                        range.max = parsedValues[parsedValues.length - 1];

                        for (let i = 1; i < parsedValues.length - 1; i++) {
                            const percent = ((i / parsedValues.length) * 100).toFixed(2) + '%';
                            range[percent] = parsedValues[i];
                        }

                        noUiSlider.create(questionsFiltersRange, {
                            start: [Math.min(...parsedValues), Math.max(...parsedValues)],
                            range: range,
                            snap: true,
                            tooltips: [wNumb({
                                decimals: 0,
                            }),wNumb({
                                decimals: 0,
                            }),],
                            behaviour: 'drag',
                            connect: true,
                        });

                        questionsFiltersRange.noUiSlider.on('update', function (values, handle, unencoded, tap, positions, noUiSlider) {
                            const id = $(noUiSlider.target).data('cod-question');
                            $(`input[name="${id}_start"]`).val(values[0]);
                            $(`input[name="${id}_end"]`).val(values[1]);

                            $(`.range-value.${id}`).trigger('change');
                        });

                        const hiddenInputStart = document.createElement('input');
                        hiddenInputStart.type='hidden';
                        hiddenInputStart.classList = 'range-value';
                        hiddenInputStart.name = chosenFamSelect.questions_filters[i].cod_question + '_start';
                        hiddenInputStart.value = parsedValues[0];

                        const hiddenInputEnd = document.createElement('input');
                        hiddenInputEnd.type='hidden';
                        hiddenInputEnd.classList='range-value';
                        hiddenInputEnd.name = chosenFamSelect.questions_filters[i].cod_question + '_end';
                        hiddenInputEnd.value =parsedValues[parsedValues.length - 1];

                        wrapper.append(label);
                        wrapper.append(questionsFiltersRange);
                        wrapper.append(hiddenInputStart);
                        wrapper.append(hiddenInputEnd);
                        wrapper.classList.add('range-type');
                        wrapper.classList.add('h-70');
                        wrapper.classList.add('px-50');
                        document.getElementById('search').before(wrapper)
                    }
                }
            }
        });

        famSelectsElement.dispatchEvent(new Event('change'));
    }

    function sortByOrderOfQuestion(questionsFilters) {
        questionsFilters.sort((a, b) => a.order_question - b.order_question);
    }

</script>

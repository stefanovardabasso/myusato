<!DOCTYPE html>
<html lang="en">
@section('title', __('My options'))
@include('site.partiales._pagehead')

<body>

<!-- Header -->

@include('site.partiales._header')
{{--TODO: Fix names of forms!--}}
{{--<section>--}}
{{--    <div class="cls-allestimenti-banner">--}}
{{--        <img src="https://images.unsplash.com/photo-1532635026-d12867005472?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80">--}}
{{--        <h1>Richiesta Quotazione Venditore</h1>--}}
{{--    </div>--}}
{{--</section>--}}
{{--<section class="cls-tabs mb-50 mt-50">--}}
{{--    <div class="cls-tab" aria-controls="tab1-tab" role="tab" aria-selected="true">{{__('Catalogo')}}</div>--}}
{{--    <div class="cls-tab" aria-controls="tab2-tab" role="tab" aria-selected="false">{{__('Quotazione')}}</div>--}}
{{--</section>--}}
{{--    <div class="container px-15 md_px-0">--}}
{{--        <section id="tab1-tab">--}}
{{--            <center><h1>TAB 1</h1></center>--}}
{{--        </section>--}}
{{--        <section id="tab2-tab">--}}
{{--            <center><h1>TAB 2</h1></center>--}}
{{--        </section>--}}
{{--    </div>--}}
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

<div class="container px-15 md_px-0 mt-50">
    <h2 class="section-title">{{__('Prodotti opzionati')}}</h2>
    <BR>
        <article class="ootb-tabcordion">
            <div class="ootb-tabcordion--tabs" role="tablist" aria-label="TabCordion">
                <button class="tab is-active" role="tab" aria-selected="true" aria-controls="tab1-tab"
                        id="tab1">{{ __('Attivi') }}</button>
                <button class="tab" role="tab" aria-selected="false" aria-controls="tab2-tab" id="tab2"
                        tabindex="-1">{{ __('Scaduti') }}</button>
                <button class="tab" role="tab" aria-selected="false" aria-controls="tab3-tab" id="tab3"
                        tabindex="-1">{{ __('Assegnato') }}</button>
            </div>
            <section id="tab1-tab" class="ootb-tabcordion--entry is-active"
                     data-title="{{ __('Le tue opzioni attive') }}" tabindex="0" role="tabpanel" aria-labelledby="tab1">
                <div class="ootb-tabcordion--entry-container">
                    <div class="ootb-tabcordion--entry-content">
                        <div class="container px-15 md_px-0" style="margin-bottom: 10%">
                            <div class="tech-details pt-40 mt-40" style="border-top: 1px solid transparent;">
                                <div class="flex flex-wrap mt-40">
                                    <div class="md_col-12 col-12 overflow-auto">
                                        <table class="cls-table mx-auto md_col-12 col-12">
                                            @if($cot[0] != NULL)
                                                <thead>
                                                <tr>
                                                    <th class="label">
                                                        <center>{{__('Id product')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Marca')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Modello')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Priorita')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Fino al')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Azioni')}}</center>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($myoptions as $option)
                                                    @if($option->status == 0)
                                                        <?php $data = date_create($offerts[$option->id]->date_fin_of_uf); ?>
                                                        <tr>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{$prods[$option->id]->id}} </td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{$prods[$option->id]->brand}} </td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{$prods[$option->id]->model}} </td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{count($prio[$option->id])+1}}</td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{  date_format($data,"d/m/Y") }} </td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">
                                                                <center>
                                                                    <a target="_blank"
                                                                       href="{{ route('product-detail', ['id_offert' => $offerts[$option->id]->id ]) }}">
                                                                        <i class="material-icons mr-5">remove_red_eye</i>
                                                                    </a>
                                                                    <a href="{{ route('deleteoptions', ['option_id' => $option->id]) }}">
                                                                        <i class="material-icons mr-5">delete_forever</i>
                                                                    </a>
                                                                    @if(count($prio[$option->id])+1 == 1)
                                                                        <a href="{{ route('do-option', [
                                                                                        'offerId' => $offerts[$option->id]->id,
                                                                                        'optionId' => $option->id
                                                                                        ]) }}">
                                                                            <i class="material-icons mr-5">done_all</i>
                                                                        </a>
                                                                    @endif
                                                                </center>
                                                            </td>
                                                        </tr>

                                                    @endif
                                                @endforeach
                                                </tbody>
                                            @else
                                                <center style="margin-top: 5%; margin-bottom: 25%"><h3
                                                        class="section-title">{{ __('Al momento non hai nessuna opzione attiva')  }}</h3>
                                                </center>
                                            @endif
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="tab2-tab" class="ootb-tabcordion--entry" data-title="{{ __('Scaduti') }}" tabindex="-1"
                     role="tabpanel" aria-labelledby="tab2">
                <div class="ootb-tabcordion--entry-container">
                    <div class="ootb-tabcordion--entry-content">
                        <div class="container px-15 md_px-0" style="margin-bottom: 10%">
                            <div class="tech-details pt-40 mt-40" style="border-top: 1px solid transparent;">
                                <div class="flex flex-wrap mt-40">
                                    <div class="md_col-12 col-12 overflow-auto">
                                        <table class="cls-table mx-auto md_col-12 col-12">
                                            @if($cot[1] != NULL)
                                                <thead>
                                                <tr>
                                                    <th class="label">
                                                        <center>{{__('Id product')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Marca')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Modello')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Priorita')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Fino al')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Azioni')}}</center>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($myoptions as $option)
                                                    @if($option->status == 1)
                                                        <?php $data = date_create($offerts[$option->id]->date_fin_of_uf); ?>
                                                        <tr>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{$prods[$option->id]->id}} </td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{$prods[$option->id]->brand}} </td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{$prods[$option->id]->model}} </td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{count($prio[$option->id])+1}}</td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{  date_format($data,"d/m/Y") }} </td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">
                                                                <center>
                                                                    <a target="_blank"
                                                                       href="{{ route('product-detail', ['id_offert' => $offerts[$option->id]->id ]) }}">
                                                                        <i class="material-icons mr-5">remove_red_eye</i>
                                                                    </a>

                                                                </center>
                                                            </td>
                                                        </tr>

                                                    @endif
                                                @endforeach
                                                </tbody>
                                            @else
                                                <center style="margin-top: 5%; margin-bottom: 25%"><h3
                                                        class="section-title">{{ __('Al momento non hai nessuna opzione scaduta')  }}</h3>
                                                </center>
                                            @endif
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="tab3-tab" class="ootb-tabcordion--entry" data-title="{{__('Assegnato')}}" tabindex="-1"
                     role="tabpanel" aria-labelledby="tab3">
                <div class="ootb-tabcordion--entry-container">
                    <div class="ootb-tabcordion--entry-content">
                        <div class="container px-15 md_px-0" style="margin-bottom: 10%">
                            <div class="tech-details pt-40 mt-40" style="border-top: 1px solid transparent;">
                                <div class="flex flex-wrap mt-40">
                                    <div class="md_col-12 col-12 overflow-auto">
                                        <table class="cls-table mx-auto md_col-12 col-12">
                                            @if($cot[2] != NULL)
                                                <thead>
                                                <tr>
                                                    <th class="label">
                                                        <center>{{__('Id product')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Marca')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Modello')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Priorita')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Fino al')}}</center>
                                                    </th>
                                                    <th class="label">
                                                        <center>{{__('Azioni')}}</center>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($myoptions as $option)
                                                    @if($option->status == 3)
                                                        <?php $data = date_create($offerts[$option->id]->date_fin_of_uf); ?>
                                                        <tr>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{$prods[$option->id]->id}} </td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{$prods[$option->id]->brand}} </td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{$prods[$option->id]->model}} </td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{count($prio[$option->id])+1}}</td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">{{  date_format($data,"d/m/Y") }}</td>
                                                            <td class="label"
                                                                style="background-color: transparent;border: 1px solid black;">
                                                                <center>
                                                                    <a target="_blank"
                                                                       href="{{ route('product-detail', ['id_offert' => $offerts[$option->id]->id ]) }}">
                                                                        <i class="material-icons mr-5">remove_red_eye</i>
                                                                    </a>

                                                                </center>
                                                            </td>
                                                        </tr>

                                                    @endif
                                                @endforeach
                                                </tbody>
                                            @else
                                                <center style="margin-top: 5%; margin-bottom: 25%"><h3
                                                        class="section-title">{{ __('Al momento non hai nessuna opzione assegnata')  }}</h3>
                                                </center>
                                            @endif
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </article>
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


    $(document).ready(() => {
        (function () {
            'use strict';

            const keyboardSupport = function (container, hasTabs) {
                const tablist = container.querySelectorAll('[role="tablist"]')[0];
                let tabs;
                let panels;

                const generateArrays = function () {
                    panels = container.querySelectorAll('[role="tabpanel"]');
                    tabs = container.querySelectorAll('[role="tab"]');
                };

                generateArrays();

                // For easy reference
                const keys = {
                    end: 35,
                    home: 36,
                    left: 37,
                    up: 38,
                    right: 39,
                    down: 40,
                    delete: 46,
                    enter: 13,
                    space: 32
                };

                // Add or subtract depending on key pressed
                const direction = {
                    37: -1,
                    38: -1,
                    39: 1,
                    40: 1
                };

                // Deactivate all tabs and tab panels
                const deactivateTabs = function () {
                    for (let t = 0; t < tabs.length; t++) {
                        tabs[t].setAttribute('tabindex', '-1');
                        tabs[t].setAttribute('aria-selected', 'false');
                    }
                };

                // Activates any given tab panel
                const activateTab = function (tab, setFocus) {
                    setFocus = setFocus || true;
                    // Deactivate all other tabs
                    deactivateTabs();

                    // Remove tabindex attribute
                    tab.removeAttribute('tabindex');

                    // Set the tab as selected
                    tab.setAttribute('aria-selected', 'true');

                    // Set focus when required
                    if (setFocus) {
                        tab.focus();
                    }
                };

                const triggerTabClick = function (e) {
                    const clickedId = e.target.getAttribute('id');
                    if (clickedId) {
                        const clickedTab = container.querySelector('[aria-controls="' + clickedId + '"]');
                        clickedTab.click();
                        document.getElementById(clickedId).scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                };

                const accordionClickEventListener = function (event) {
                    triggerTabClick(event);
                };

                // When a tab is clicked, activateTab is fired to activate it
                const clickEventListener = function (event) {
                    const tab = event.target;
                    activateTab(tab, false);
                };

                // Make a guess
                const focusFirstTab = function () {
                    const target = hasTabs ? tabs : panels;
                    target[0].focus();
                };

                // Make a guess
                const focusLastTab = function () {
                    const target = hasTabs ? tabs : panels;
                    target[target.length - 1].focus();
                };

                // Either focus the next, previous, first, or last tab
                // depending on key pressed
                const switchTabOnArrowPress = function (event) {
                    const pressed = event.keyCode;

                    if (direction[pressed]) {
                        const target = event.target;
                        const targetElems = hasTabs ? tabs : panels;
                        if (target.index !== undefined) {
                            if (targetElems[target.index + direction[pressed]]) {
                                targetElems[target.index + direction[pressed]].focus();
                            } else if (pressed === keys.left || pressed === keys.up) {
                                focusLastTab();
                            } else if (pressed === keys.right || pressed == keys.down) {
                                focusFirstTab();
                            }
                        }
                    }
                };

                // When a tablist's aria-orientation is set to vertical,
                // only up and down arrow should function.
                // In all other cases only left and right arrow function.
                const determineOrientation = function (event) {
                    const key = event.keyCode;
                    const vertical = tablist ? tablist.getAttribute('aria-orientation') === 'vertical' : null;
                    let proceed = false;

                    if (vertical || !hasTabs) {
                        if (key === keys.up || key === keys.down) {
                            event.preventDefault();
                            proceed = true;
                        }
                    } else {
                        if (key === keys.left || key === keys.right) {
                            proceed = true;
                        }
                    }

                    if (proceed) {
                        switchTabOnArrowPress(event);
                    }
                };

                // Handle keydown on tabs
                const keydownEventListener = function (event) {
                    const key = event.keyCode;
                    switch (key) {
                        case keys.end:
                            event.preventDefault();
                            // Activate last tab
                            focusLastTab();
                            break;
                        case keys.home:
                            event.preventDefault();
                            // Activate first tab
                            focusFirstTab();
                            break;

                        // Up and down are in keydown
                        // because we need to prevent page scroll >:)
                        case keys.up:
                        case keys.down:
                            determineOrientation(event);
                            break;
                    }
                };

                // Handle keyup on tabs
                const keyupEventListener = function (event) {
                    const key = event.keyCode;
                    switch (key) {
                        case keys.left:
                        case keys.right:
                            determineOrientation(event);
                            break;
                        case keys.enter:
                        case keys.space:
                            if (hasTabs) {
                                activateTab(event.target);
                            } else {
                                triggerTabClick(event);
                            }
                            break;
                    }
                };

                const addListeners = function (index) {
                    const target = hasTabs ? tabs[index] : panels[index];
                    tabs[index].addEventListener('click', clickEventListener);
                    if (target) {
                        if (!hasTabs) {
                            target.addEventListener('click', accordionClickEventListener);
                        }
                        target.addEventListener('keydown', keydownEventListener);
                        target.addEventListener('keyup', keyupEventListener);
                        // Build an array with all tabs (<button>s) in it
                        target.index = index;
                    }
                };

                // Bind listeners
                for (let i = 0; i < tabs.length; ++i) {
                    addListeners(i);
                }

                // Accordion mode
                if (!hasTabs) {
                    for (const panel of panels) {
                        panel.onclick = function (e) {
                            triggerTabClick(e);
                        };
                    }
                }
            };

            const toggleClass = function (otherElems, thisELem, className = 'is-active') {
                for (const otherElem of otherElems) {
                    otherElem.classList.remove(className);
                }
                thisELem.classList.add(className);
            };

            const toggleVerticalTabs = function (tabContainer, tabs, items, item) {
                item.onclick = function (e) {
                    const currId = item.getAttribute('id');
                    const tab = tabContainer.querySelector('.ootb-tabcordion--tabs [aria-controls="' + currId + '"]');
                    toggleClass(tabs, tab);
                    toggleClass(items, item);
                };
            };

            const toggleTabs = function (tabContainer) {
                const tabs = tabContainer.querySelectorAll('.ootb-tabcordion--tabs .tab');
                const items = tabContainer.querySelectorAll('.ootb-tabcordion--entry');
                for (const tab of tabs) {
                    tab.onclick = function () {
                        const target = tab.getAttribute('aria-controls');
                        const content = document.getElementById(target);
                        toggleClass(tabs, tab);
                        toggleClass(items, content);
                    };
                }
                for (const item of items) {
                    toggleVerticalTabs(tabContainer, tabs, items, item);
                }
            };

            const hasTabs = function (container) {
                return container.classList.contains('has-tabs');
            };

            const modeSwitcher = function (tabContainer, containerWidth) {
                const tabs = tabContainer.querySelectorAll('.tab');
                const container = tabs[0].closest('.ootb-tabcordion');
                let totalW = 0;
                for (const tab of tabs) {
                    totalW += tab.offsetWidth;
                }
                console.log(totalW, containerWidth);
                if (totalW >= containerWidth) {
                    container.classList.remove('has-tabs');
                } else {
                    container.classList.add('has-tabs');
                }
                keyboardSupport(tabContainer, hasTabs(container));
            };

            const resizeObserver = new ResizeObserver(entries => {
                for (let entry of entries) {
                    modeSwitcher(entry.target, entry.contentRect.width);
                }
            });

            const tabContainers = document.querySelectorAll('.ootb-tabcordion');
            for (const tabContainer of tabContainers) {
                const tabList = tabContainer.querySelector('.ootb-tabcordion--tabs');
                resizeObserver.observe(tabList);
                toggleTabs(tabContainer);
                keyboardSupport(tabContainer, hasTabs(tabContainer));
            }
        })();
    })
</script>
</body>

</html>

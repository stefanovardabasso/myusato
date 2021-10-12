<!DOCTYPE html>
<html lang="en">

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

<div class="container px-15 md_px-0 mt-50">
    <h2 class="section-title">{{__('Le tue ricerche')}}</h2>
    <BR>
        <article class="ootb-tabcordion">
            <div class="ootb-tabcordion--tabs" role="tablist" aria-label="TabCordion">
                <button class="tab is-active" role="tab" aria-selected="true" aria-controls="tab1-tab"
                        id="tab1">{{ __('Tutte le tue ricerche') }}</button>
                <button class="tab" role="tab" aria-selected="true" aria-controls="tab2-tab"
                        id="tab2">{{ __('Recenti') }}</button>
            </div>
            <section id="tab1-tab" class="ootb-tabcordion--entry is-active"
                     data-title="{{ __('Tutte le tue ricerche') }}" tabindex="0" role="tabpanel" aria-labelledby="tab1">
                <div class="ootb-tabcordion--entry-container">
                    <div class="ootb-tabcordion--entry-content">
                        @if($stat == 0)

                        @else
                        @if($group!= NULL)
                            @foreach($group as $g)

                                <div class="my-filters-wrapper"
                                     style="margin: 3%; border: 1px solid black; min-height: 150px">
                                    <img src="https://via.placeholder.com/1980x1080">
                                    <div class="my-filters">
                                        <div class="col-12 cls-active-filters" style="height: 100%;">
                                            <div class="filters">
                                                <div
                                                    class="inline-flex align-center bc-secondary pl-5 pr-12 py-3 mr-10 mt-10 active-filter__item"
                                                    style="background-color: #ffcb0f;">
                                                    <span class="text-light" style=" color:black!important;">{{$g->name}}</span>
                                                </div>
                                                @foreach($group_lines[$g->id] as $gl)
                                                    <div class="inline-flex align-center bc-secondary pl-5 pr-12 py-3 mr-10 mt-10 active-filter__item">
                                                        <span
                                                            class="text-light">{{$gl->lavel_it}}: {{ $gl->ans }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="cls-data">
                                                <div>
                                                    <p style="margin: 2%">{{__('Ricerca salvata: ')}} {{  date_format($g->created_at,"d/m/Y") }} </p>
                                                </div>
                                                <div class="cls-actions">
                                                    <div class="item">
                                                        <a href="{{url('filters/'. $filterId . '/search?' .$savedFiltersRequest[$g->id]) }}" class="btn btn-primary" style=" border-radius: 11px!important;">Avvia</a>
                                                    </div>
                                                    <div class="item">
                                                        <i class="material-icons mr-5">delete_forever</i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        @else
                            <center style="margin-top: 5%; margin-bottom: 25%"><h3
                                    class="section-title">{{ __('Al momento non hai nessuna ricerca salvata')  }}</h3>
                            </center>
                            @endif
                        @endif
                    </div>
                </div>
            </section>
            <section id="tab2-tab" class="ootb-tabcordion--entry" data-title="{{ __('Recenti') }}" tabindex="0"
                     role="tabpanel" aria-labelledby="tab2">
                <div class="ootb-tabcordion--entry-container">
                    <div class="ootb-tabcordion--entry-content">
                        @if($stat == 0)

                        @else
                        @if($group!= NULL)

                            <div class="my-filters-wrapper"
                                 style="margin: 3%; border: 1px solid black; min-height: 150px">
                                <img src="https://via.placeholder.com/1980x1080">
                                <div class="my-filters">
                                    <div class="col-12 cls-active-filters" style="height: 100%;">
                                        <div class="filters">
                                            <div
                                                class="inline-flex align-center bc-secondary pl-5 pr-12 py-3 mr-10 mt-10 active-filter__item" style="background-color: #ffcb0f">
                                                <span class="text-light" style=" color:black!important;">{{end($group)->name}}</span>
                                            </div>
                                            @foreach($group_lines[end($group)->id] as $gl)
                                                <div   class="inline-flex align-center bc-secondary pl-5 pr-12 py-3 mr-10 mt-10 active-filter__item">
                                                        <span
                                                            class="text-light">{{$gl->lavel_it}}: {{ $gl->ans }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="cls-data">
                                            <div>
                                                <p style="margin: 2%">{{__('Ricerca salvata: ')}} {{  date_format(end($group)->created_at,"d/m/Y") }}  </p>
                                            </div>
                                            <div class="cls-actions">
                                                <div class="item">
                                                    <button style=" border-radius: 11px!important;">Avvia</button>
                                                </div>
                                                <div class="item">
                                                    <i class="material-icons mr-5">delete_forever</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>





                        @else
                            <center style="margin-top: 5%; margin-bottom: 25%"><h3
                                    class="section-title">{{ __('Al momento non hai nessuna ricerca salvata')  }}</h3>
                            </center>
                            @endif
                        @endif
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

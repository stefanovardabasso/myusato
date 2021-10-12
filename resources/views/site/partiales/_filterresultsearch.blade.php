<div class="md_col-9 col-12 md_px-15 mt-30 md_mt-0">
    <div class="flex flex-wrap justify-between align-center">
        <div class="md_col-8 col-12">
            <h3 class="uppercase weight-500 font-30">Prodotti per {{$selectedFilterButton->label}}</h3>
            <h5 class="uppercase weight-500 font-20 mt-10 offers-count">{{count($offersWithProduct)}} annunci in vendita</h5>
        </div>
        <div class="flex align-center md_col-4 col-12 mt-20 md_mt-0">
            <select name="sort" id="sort-select" class="search-select">
                <option value="date">{{__('Per data di inserimento')}}</option>
                <option value="price">{{__('Per prezzo')}}</option>
                <option value="title">{{__('Per Titolo')}}</option>
            </select>
            <a href="" class="ml-10 bc-primary inline-flex justify-center align-center search-to-button sort-button desc" data-order="desc">
                <i class="material-icons font-30 text-dark">south</i>
            </a>
        </div>
    </div>
    <div class="flex flex-wrap justify-between align-center mt-30 filters-cloud">
        <div class="md_col-9 col-12 cls-active-filters">
            <div class="inline-flex align-center bc-secondary pl-5 pr-12 py-3 mr-10 mt-10 active-filter__item">
                <i class="material-icons mr-5 text-primary">close</i>
                <span class="text-light">{{$selectedFilterButton->label}}</span>
            </div>
{{--            <div class="inline-flex align-center bc-secondary pl-5 pr-12 py-3 mr-10 mt-10 active-filter__item">--}}
{{--                <i class="material-icons mr-5 text-primary">close</i>--}}
{{--                <span class="text-light">{{$family->label}}</span>--}}
{{--            </div>--}}
{{--            <div class="inline-flex align-center bc-secondary pl-5 pr-12 py-3 mr-10 mt-10 md_mt-0">--}}
{{--                <i class="material-icons mr-5 text-primary">close</i>--}}
{{--                <span class="text-light">Pronto</span>--}}
{{--            </div>--}}
        </div>
        <div class="md_col-3 col-12 mt-15 md_mt-0">
           @if(Auth::check())
            <a href="#" class="button" id="saved-filters">{{__('Salva ricerca')}}</a>
            @else
            <a href="http://login.cls.it/login?sso={{config('session.sso_token')}}" class="button">{!! Auth::check() ? '' : '<i class="material-icons font-30">lock</i> ' !!}{{__('Salva ricerca')}}</a>
            @endif
        </div>
    </div>

{{--Inline for now--}}
<script>
    const filterCloudButtons = document.querySelectorAll('.filters-cloud i');

    document.addEventListener('DOMContentLoaded', () => {
        Array.from(filterCloudButtons).forEach(closeBtn => {
            closeBtn.addEventListener('click',(ev) => {
                ev.target.parentNode.remove();
            });
        });
    });
</script>

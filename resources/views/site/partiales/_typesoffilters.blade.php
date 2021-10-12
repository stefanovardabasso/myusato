<div class="absolute bottom-0 col-12 no-mobile">
    <div class="container">
        <div class="flex row-10">
            @foreach($filterButtons as $filterButton)
            <div class="col-2 px-10">
                <a href="{{route('filters', ['filterId' => $filterButton->id])}}" class="block type-box bc-primary py-10 cls-filter-button {{$filterId == $filterButton->id ? 'active' : ''}}">
                    <span>{{$filterButton->label}}</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

@switch($label)
    @case('locale')
        @switch($value[0])
            @case('en')
                <li>
                    <b>@lang('locale-form-label'):</b> <i class="flag-icon flag-icon-gb"></i><span class="title">@lang('English')</span>
                </li>
            @break

            @case('it')
                <li>
                    <b>@lang('locale-form-label'):</b> <i class="flag-icon flag-icon-gb"></i><span class="title">@lang('Italian')</span>
                </li>
            @break

            @case('bg')
                <li>
                    <b>@lang('locale-form-label'):</b> <i class="flag-icon flag-icon-gb"></i><span class="title">@lang('Bulgarian')</span>
                </li>
            @break
        @endswitch
    @break
@endswitch

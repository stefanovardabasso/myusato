@if($item->getRoute() == 'admin.musers.amministratori')

    <li class="{{ $item->isActive() ? 'active menu-open' : '' }}">
        <a href="{{ route($item->getRoute(),['type' => '1']) }}">
            <i class="fa {{ $item->getIcon() }}"></i>
            <span>{{ $item->getTitle() }}</span>
            {!! $item->getAppendHtml() !!}
        </a>
    </li>
@elseif($item->getRoute() == 'admin.musers.amministratorib')

    <li class="{{ $item->isActive() ? 'active menu-open' : '' }}">
        <a href="{{ route($item->getRoute(),['type' => '5']) }}">
            <i class="fa {{ $item->getIcon() }}"></i>
            <span>{{ $item->getTitle() }}</span>
            {!! $item->getAppendHtml() !!}
        </a>
    </li>
    </li>
@elseif($item->getRoute() == 'admin.musers.venditori')

    <li class="{{ $item->isActive() ? 'active menu-open' : '' }}">
        <a href="{{ route($item->getRoute(),['type' => '2']) }}">
            <i class="fa {{ $item->getIcon() }}"></i>
            <span>{{ $item->getTitle() }}</span>
            {!! $item->getAppendHtml() !!}
        </a>
    </li>
    </li>
@elseif($item->getRoute() == 'admin.musers.venditoriav')

    <li class="{{ $item->isActive() ? 'active menu-open' : '' }}">
        <a href="{{ route($item->getRoute(),['type' => '8']) }}">
            <i class="fa {{ $item->getIcon() }}"></i>
            <span>{{ $item->getTitle() }}</span>
            {!! $item->getAppendHtml() !!}
        </a>
    </li>
@elseif($item->getRoute() == 'admin.musers.commercianti')

    <li class="{{ $item->isActive() ? 'active menu-open' : '' }}">
        <a href="{{ route($item->getRoute(),['type' => '3']) }}">
            <i class="fa {{ $item->getIcon() }}"></i>
            <span>{{ $item->getTitle() }}</span>
            {!! $item->getAppendHtml() !!}
        </a>
    </li>

@elseif($item->getRoute() == 'admin.musers.clientif')

    <li class="{{ $item->isActive() ? 'active menu-open' : '' }}">
        <a href="{{ route($item->getRoute(),['type' => '4']) }}">
            <i class="fa {{ $item->getIcon() }}"></i>
            <span>{{ $item->getTitle() }}</span>
            {!! $item->getAppendHtml() !!}
        </a>
    </li>
      @elseif($item->getRoute() == 'admin.tuttocarrellis.index')
            <li class="{{ $item->isActive() ? 'active menu-open' : '' }}">
                <a href="{{ route($item->getRoute()) }}">
                    <span class="label label-info" style="background-color: red !important;">
                    <i class="fa {{ $item->getIcon() }}"></i>
                    <span>{{ $item->getTitle() }}</span>
                    </span>
                    {!! $item->getAppendHtml() !!}
                </a>
            </li>
        @elseif($item->getRoute() == 'admin.suprlifts.index')
            <li class="{{ $item->isActive() ? 'active menu-open' : '' }}">
                <a href="{{ route($item->getRoute()) }}">
                    <span class="label label-info" style="background-color: rgb(83, 169, 230) !important;">
                    <i class="fa {{ $item->getIcon() }}"></i>
                    <span>{{ $item->getTitle() }}</span>
                    </span>
                    {!! $item->getAppendHtml() !!}
                </a>
            </li>
        @elseif($item->getRoute() == 'admin.macus.index')
            <li class="{{ $item->isActive() ? 'active menu-open' : '' }}">
                <a href="{{ route($item->getRoute()) }}">
        <span class="label label-info" style="background-color: rgb(251, 113, 33) !important;">
                    <i class="fa {{ $item->getIcon() }}"></i>
                    <span>{{ $item->getTitle() }}</span>
        </span>
                    {!! $item->getAppendHtml() !!}
                </a>
            </li>
          @else

<li class="{{ $item->isActive() ? 'active menu-open' : '' }}">
    <a href="{{ route($item->getRoute()) }}">
        <i class="fa {{ $item->getIcon() }}"></i>
        <span>{{ $item->getTitle() }}</span>
        {!! $item->getAppendHtml() !!}
    </a>
</li>
    @endif


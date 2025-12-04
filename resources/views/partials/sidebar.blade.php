<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}">Inventaris</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('home') }}">SI</a>
    </div>

    <ul class="sidebar-menu">
        @if(empty($sidebarMenu))
            <li class="menu-header">Dashboard</li>
            <li><a class="nav-link" href="{{ route('home') }}"><i class="fa fa-fire"></i> <span>Dashboard</span></a></li>
        @else
            @foreach($sidebarMenu as $block)
                @if(!empty($block['header']))
                    <li class="menu-header">{{ $block['header'] }}</li>
                @endif

                @foreach($block['items'] as $item)
                    @php
                        $url = (isset($item['route']) && \Route::has($item['route'])) 
                                ? route($item['route']) 
                                : (isset($item['url']) ? url($item['url']) : '#');

                        $isActive = false;
                        if (isset($item['route']) && \Route::currentRouteName() === $item['route']) {
                            $isActive = true;
                        } elseif ($url !== '#' && Str::startsWith(request()->path(), trim(parse_url($url, PHP_URL_PATH), '/'))) {
                            $isActive = true;
                        }

                        // Icon fallback
                        $icon = $item['icon'] ?? 'fa fa-circle';
                    @endphp

                    <li class="{{ $isActive ? 'active' : '' }}">
                        <a class="nav-link" href="{{ $url }}">
                            <i class="{{ $icon }}"></i> <span>{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            @endforeach
        @endif
    </ul>
</aside>

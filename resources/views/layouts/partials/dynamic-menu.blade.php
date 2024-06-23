@if($menu->menuItems)
<ul class="side-nav">
@foreach ($menu->menuItems as $menuItem)
    @if($menuItem->type == App\Enums\MenuItemType::ROUTE_NAME->type())
    <li class="side-nav-item">
        <a href="{{ route($menuItem->route) }}" class="side-nav-link">
            <i class="mdi {{ $menuItem->icon }}"></i>
            <span>{{ $menuItem->name }}</span>
        </a>

    @elseif($menuItem->type == App\Enums\MenuItemType::LABEL->type())
        @if ($menuItem->icon)
        <li class="side-nav-item">
            <a
                href="#{{ strtolower($menuItem->name) }}"
                data-bs-toggle="collapse"
                aria-expanded="false"
                aria-controls="{{ strtolower($menuItem->name) }}"
                class="side-nav-link"
            >
                <i class="mdi {{ $menuItem->icon }}"></i>
                <span>{{ $menuItem->name }}</span>
                <span class="menu-arrow"></span>
            </a>
        @else
        <li class="side-nav-title">{{ $menuItem->name }}
        @endif
    @else
    <li class="side-nav-title">{{ $menuItem->name }}
    @endif
        @include('layouts.partials.dynamic-submenu', ['submenus' => $menuItem->children, 'menuParent' => $menuItem->name])
    </li>
@endforeach
</ul>
@endif

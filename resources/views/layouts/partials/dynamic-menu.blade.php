@isset($menu->menuItems)
<ul class="side-nav">
@foreach ($menu->menuItems as $menuItem)
    @if($menuItem->type == App\Enums\MenuItemType::ROUTE_NAME->type() && SettingsHelper::checkPermission($menuItem->permissions()->pluck('id')))
    <li class="side-nav-item">        
        <a href="{{ route($menuItem->route) }}" class="side-nav-link">
            <i class="mdi {{ $menuItem->icon }}"></i>
            <span>{{ $menuItem->name }}</span>
        </a>

    @elseif($menuItem->type == App\Enums\MenuItemType::LABEL->type() && SettingsHelper::checkPermission($menuItem->permissions()->pluck('id')))
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
    @elseif(SettingsHelper::checkPermission($menuItem->permissions()->pluck('id')))
    <li class="side-nav-title">{{ $menuItem->name }}
    @endif
        @include('layouts.partials.dynamic-submenu', ['submenus' => $menuItem->children, 'menuParent' => $menuItem->name])
    </li>
@endforeach
</ul>
@else
<ul class="side-nav">
    <li class="side-nav-title">Management</li>
    <li class="side-nav-item">
        <a href="{{ route('admin.dashboard') }}" class="side-nav-link">  
            <i class="mdi mdi-account-group"></i>          
            <span>{{ __('Dashboard') }}</span>
        </a>
    </li>
</ul>
@endif

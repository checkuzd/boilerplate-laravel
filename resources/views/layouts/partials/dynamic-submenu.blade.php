@if($submenus->count())
<div class="collapse" id="{{ strtolower($menuParent) }}">
    <ul class="side-nav-second-level">
        @foreach ($submenus as $submenu)
            @if($submenu->route && SettingsHelper::checkPermission($submenu->permissions()->pluck('id')))
            <li>
                <a href="{{ route($submenu->route) }}">{{ $submenu->name }}</a>
            </li>
            @endif
        @endforeach
    </ul>
</div>
@endif

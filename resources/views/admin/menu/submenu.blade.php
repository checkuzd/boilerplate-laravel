@if($submenus->count())
<ul>
    @foreach ($submenus as $submenu)
    <li id="menu-{{ $submenu->id }}"
        data-id="{{ $submenu->id }}"
    >
        <div class="menu-content">
            <div class="menu-head d-flex justify-content-between">
                <span>
                {{ $submenu->name }}
                </span>
                <div>
                    <span data-id="{{ $submenu->id }}" data-action="{{ route('admin.menu-items.edit', $submenu->id) }}" class="open-menu-item menu-item-clickable cursor-pointer">
                        Edit
                    </span> |
                    <span data-id="{{ $submenu->id }}" data-action="{{ route('admin.menu-items.destroy', $submenu->id) }}" class="delete-menu-item menu-item-clickable cursor-pointer">
                        Delete
                    </span>
                </div>
            </div>
        </div>
        @include('admin.menu.submenu', ['submenus' => $submenu->children])
    </li>
    @endforeach
</ul>
@endif

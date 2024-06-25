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
                <div class="menu-options">
                    <span data-id="{{ $submenu->id }}" data-action="{{ route('admin.menu-items.edit', $submenu->id) }}" class="open-menu-item menu-item-clickable btn btn-sm btn-primary">
                        Edit
                    </span>
                    <span data-id="{{ $submenu->id }}" data-action="{{ route('admin.menu-items.destroy', $submenu->id) }}" class="delete-menu-item menu-item-clickable btn btn-sm btn-danger">
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

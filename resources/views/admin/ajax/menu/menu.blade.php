<li id="menu-{{ $menuItem->id }}" data-id="{{ $menuItem->id }}">
    <div class="menu-content">
        <div class="menu-head d-flex justify-content-between">
            <span>
            {{ $menuItem->name }}
            </span>
            <div class="menu-options">
                <span data-id="{{ $menuItem->id }}" data-action="{{ route('admin.menu-items.edit', $menuItem->id) }}" class="open-menu-item menu-item-clickable btn btn-sm btn-primary">
                    Edit
                </span>
                <span data-id="{{ $menuItem->id }}" data-action="{{ route('admin.menu-items.destroy', $menuItem->id) }}" class="delete-menu-item menu-item-clickable btn btn-sm btn-danger">
                    Delete
                </span>
            </div>
        </div>
    </div>
</li>

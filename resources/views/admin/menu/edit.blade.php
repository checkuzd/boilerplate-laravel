<x-admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Menus</li>
                    </ol>
                </div>
                <h4 class="page-title">Menus</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <h4>Add menu items</h4>
            <div class="accordion" id="add-mi-accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header accordion-button"
                        data-bs-toggle="collapse"
                        data-bs-target="#add-mi-{{ \App\Enums\MenuItemType::ROUTE_NAME->type() }}"
                    >
                            {{ \App\Enums\MenuItemType::ROUTE_NAME->displayType() }}
                        </button>
                    </h2>
                    <div id="add-mi-{{ \App\Enums\MenuItemType::ROUTE_NAME->type() }}"
                        class="accordion-collapse collapse show"
                        data-bs-parent="#add-mi-accordion"
                    >
                        <div class="accordion-body">
                            <form class="add-menu-item d-flex flex-column gap-2" action="{{ route('admin.menu-items.store') }}" method="POST" class="mb-3">
                                @csrf
                                <label class="d-flex justify-content-between align-items-center">
                                    <span>Link Text</span>
                                    <input name="name" class="input-name" type="text">
                                </label>
                                <label class="d-flex justify-content-between align-items-center">
                                    <span>Icon Class</span>
                                    <input name="icon" class="input-icon" type="text" />
                                </label>
                                <label class="d-flex justify-content-between align-items-center">
                                    <span>Route</span>
                                    <div class="select-wrapper">
                                        <select name="route" class="form-control select2 input-route" data-toggle="select2">
                                            <option value="">Select</option>
                                            @foreach ($routes as $route)
                                                @if($route['name'])
                                                <option value="{{ $route['name'] }}">{{ $route['name'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </label>
                                <label class="d-flex justify-content-between align-items-center">
                                    <div>Permissions</div>
                                    <div class="select-wrapper">
                                        <select name="route" data-placeholder="Choose ..." class="form-control select2 input-permissions select2-multiple" multiple data-toggle="select2">
                                            @foreach ($permissions as $parentPermission)
                                                <optgroup label="{{ $parentPermission->name }}">
                                                    @foreach ($parentPermission->children as $permission)
                                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </label>
                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                <input type="hidden" name="type" value="{{ \App\Enums\MenuItemType::ROUTE_NAME->type() }}">
                                <button class="btn btn-sm btn-primary">Add to Menu</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h3 class="accordion-header accordion-button collapsed"
                        data-bs-toggle="collapse"
                        data-bs-target="#add-mi-{{ \App\Enums\MenuItemType::CUSTOM_LINKS->type() }}"
                    >
                            {{ \App\Enums\MenuItemType::CUSTOM_LINKS->displayType() }}
                    </h3>
                    <div id="add-mi-{{ \App\Enums\MenuItemType::CUSTOM_LINKS->type() }}"
                        class="accordion-collapse collapse"
                        data-bs-parent="#add-mi-accordion"
                    >
                        <div class="accordion-body">
                            <form class="add-menu-item d-flex flex-column gap-2" action="{{ route('admin.menu-items.store') }}" method="POST" class="mb-3">
                                @csrf
                                <label class="d-flex justify-content-between align-items-center">
                                    <span>Link Text</span>
                                    <input name="name" class="input-name" type="text" required />
                                </label>
                                <label class="d-flex justify-content-between align-items-center">
                                    <span>Icon Class</span>
                                    <input name="icon" class="input-icon" type="text" />
                                </label>
                                <label class="d-flex justify-content-between align-items-center">
                                    <span>URL</span>
                                    <input name="route" class="input-route" type="url" required />
                                </label>
                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                <input type="hidden" name="type" value="{{ \App\Enums\MenuItemType::CUSTOM_LINKS->type() }}">
                                <button class="btn btn-sm btn-primary">Add to Menu</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header accordion-button collapsed"
                        data-bs-toggle="collapse"
                        data-bs-target="#add-mi-{{ \App\Enums\MenuItemType::LABEL->type() }}"
                    >
                            {{ \App\Enums\MenuItemType::LABEL->displayType() }}
                        </button>
                    </h2>
                    <div id="add-mi-{{ \App\Enums\MenuItemType::LABEL->type() }}"
                        class="accordion-collapse collapse"
                        data-bs-parent="#add-mi-accordion"
                    >
                        <div class="accordion-body">
                            <form class="add-menu-item d-flex flex-column gap-2" action="{{ route('admin.menu-items.store') }}" method="POST" class="mb-3">
                                @csrf
                                <label class="d-flex justify-content-between align-items-center">
                                    <span>Label</span>
                                    <input name="name" class="input-name" type="text" required>
                                </label>
                                <label class="d-flex justify-content-between align-items-center">
                                    <span>Icon Class</span>
                                    <input name="icon" class="input-icon" type="text" />
                                </label>
                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                <input type="hidden" name="type" value="{{ \App\Enums\MenuItemType::LABEL->type() }}">
                                <button class="btn btn-sm btn-primary">Add to Menu</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="mt-4">Menu Settings</h4>
            <div class="accordion" id="menu-settings">
                <div class="accordion-item">
                    <h2 class="accordion-header accordion-button"
                        data-bs-toggle="collapse"
                        data-bs-target="#menu-settings-location"
                    >
                            Menu Location
                        </button>
                    </h2>
                    <div id="menu-settings-location"
                        class="accordion-collapse collapse show"
                        data-bs-parent="menu-settings"
                    >
                        <div class="accordion-body">
                            <livewire:admin.update-menu-location :menu_id="$menu->id" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h4>Menu Structure</h4>
            <div class="card menu-structure">
                <livewire:admin.update-menu-name :id="$menu->id" :name="$menu->name" />
                <div class="menu-body">
                    <div class="menu-builder-wrapper">
                        <ul id="menu-builder" class="sortableLists">
                            @if($menu->menuItems)
                            @foreach ($menu->menuItems as $menuItem)
                                <li id="menu-{{ $menuItem->id }}"
                                    data-id="{{ $menuItem->id }}"
                                >
                                    <div class="menu-content">
                                        <div class="menu-head d-flex justify-content-between">
                                            <span>
                                            {{ $menuItem->name }}
                                            </span>
                                            <div class="menu-options">
                                                <span data-id="{{ $menu->id }}" data-action="{{ route('admin.menu-items.edit', $menuItem->id) }}" class="open-menu-item menu-item-clickable btn btn-sm btn-primary">
                                                    Edit
                                                </span>
                                                <span data-id="{{ $menu->id }}" data-action="{{ route('admin.menu-items.destroy', $menuItem->id) }}" class="delete-menu-item menu-item-clickable btn btn-sm btn-danger">
                                                    Delete
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @include('admin.menu.submenu', ['submenus' => $menuItem->children])
                                </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="menu-footer">
                    <button id="saveOrder" class="btn btn-sm btn-primary float-end" data-action="{{ route('admin.menus.update', $menu->id) }}">Save Order</button>
                </div>
            </div>
        </div>
    </div>

    @include('admin.menu.modal.edit-menu-item')

</x-admin-layout>

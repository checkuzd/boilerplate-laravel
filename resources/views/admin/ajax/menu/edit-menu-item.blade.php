<form data-menu-id="{{ $menuItem->id }}" action="{{ route('admin.menu-items.update', $menuItem->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="modal-header">
        <h4 class="modal-title" id="standard-modalLabel">Edit Menu Item</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <x-admin.input-label for="name" :value="__('Link Text')" />
                    <x-admin.text-input id="name" class="form-control" type="text" name="name" :value="old('name', $menuItem->name)" />
                    <div class="validation-error text-white error-name"></div>
                </div>
                <div class="mb-3">
                    <x-admin.input-label for="icon" :value="__('Icon Class')" />
                    <x-admin.text-input id="icon" class="form-control" type="text" name="icon" :value="old('icon', $menuItem->icon)" />
                    <div class="validation-error text-white error-icon"></div>
                </div>
                <div class="mb-3">
                    <x-admin.input-label for="route" :value="__('Route')" />
                    <select name="route" id="route" class="form-control">
                        <option value="">Select</option>
                        @foreach ($routes as $route)
                            <option value="{{ $route['name'] }}" 
                            {{ ($route['name'] == $menuItem->route) ? 'selected' : '' }}
                            >
                                {{ $route['name'] }}
                            </option>
                        @endforeach
                    </select>                    
                    <div class="validation-error text-white error-route"></div>
                </div>

                <div class="mb-3">
                    <x-admin.input-label for="permissions" :value="__('Permissions')" />
                    <select name="permissions[]" id="permissions" data-placeholder="Choose ..." class="form-control select2 select-permissions select2-multiple" multiple data-toggle="select2">
                        <option value="">Select</option>
                        @foreach ($permissions as $parentPermission)
                            <optgroup label="{{ $parentPermission->name }}">
                                @foreach ($parentPermission->children as $permission)
                                    <option value="{{ $permission->id }}"
                                        {{ ($menuItem->permissions->find($permission->id)) ? 'selected' : ''  }}
                                    >
                                        {{ $permission->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>                    
                    <div class="validation-error text-white error-permissions"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>

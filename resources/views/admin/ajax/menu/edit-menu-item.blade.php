<form action="{{ route('admin.menu-items.update', $menuItem->id) }}" method="POST">
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
                    <x-admin.text-input id="route" class="form-control" type="text" name="route" :value="old('route', $menuItem->route)" />
                    <div class="validation-error text-white error-route"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>

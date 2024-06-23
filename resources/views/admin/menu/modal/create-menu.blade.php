<div id="create-menu" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.menus.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Create Menu</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <x-admin.input-label for="name" :value="__('Menu Name')" />
                                <x-admin.text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required />
                                <x-admin.input-error :messages="$errors->get('name')" />
                            </div>
                            <div>
                                <x-admin.input-label for="location" :value="__('Menu Location')" />

                                <select name="location" class="form-control" id="location">
                                    <option value="">Select</option>
                                    <option value="{{ \App\Enums\MenuLocation::ADMIN->location() }}">{{ \App\Enums\MenuLocation::ADMIN->displayLocation() }}</option>
                                    <option value="{{ \App\Enums\MenuLocation::FRONT_END->location() }}">{{ \App\Enums\MenuLocation::FRONT_END->displayLocation() }}</option>
                                </select>
                                <x-admin.input-error :messages="$errors->get('location')" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="edit-menu" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

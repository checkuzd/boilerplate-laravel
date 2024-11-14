<x-admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Role</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PATCH')
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">

                                <div class="mb-3">
                                    <x-admin.input-label for="name" :value="__('Role Name')" />
                                    <x-admin.text-input id="name" class="form-control" type="text" name="name" :value="old('name',$role->name)" required autocomplete="name" />
                                    <x-admin.input-error :messages="$errors->get('name')" />
                                </div>

                            </div> <!-- end col-->
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="mb-3">Permissions</h4>
                                @foreach ($permissions as $permission)
                                    @if (!$permission->permission_id && count($permission->children) > 0)
                                        <h5 class="d-flex gap-2">
                                            <span>{{ $permission->name }}</span>
                                            <span class="ml-3 badge bg-success cursor-pointer">Approve all</span>
                                            <span class="ml-3 badge bg-danger cursor-pointer">Deny all</span>
                                        </h5>
                                        <div class="mb-3">
                                            @foreach ($permission->children as $childPermission)
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox"
                                                    name="permissions[]"
                                                    value="{{ $childPermission->name }}"
                                                    class="form-check-input"
                                                    id="{{ $childPermission->name }}"
                                                    {{ ($role->hasPermissionTo($childPermission->name)) ? 'checked' : '' }}
                                                    @unlessrole(\App\Enums\RoleEnum::SUPER_ADMIN)
                                                    {{ ($restrictedPermissions->contains($childPermission->id)) ? 'disabled' : '' }}
                                                    @endunlessrole
                                                />
                                                <label class="form-check-label" for="{{ $childPermission->name }}">{{ $childPermission->name }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach

                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <h4>Can Manage</h4>
                                <div class="can-manage">
                                    @foreach ($roles->access_to as $role)
                                        <div class="form-check">
                                            <input type="checkbox"
                                                name="roles[]"
                                                value="{{ $role->id }}"
                                                class="form-check-input"
                                                id="{{ $role->name }}"
                                                {{ $abilities->contains($role->id) ? 'checked' : '' }}
                                            />
                                            <label class="form-check-label" for="{{ $role->name }}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <button type="submit" class="btn btn-primary mb-3">Update Role</button>
            </form>
        </div>
    </div>
</x-admin-layout>

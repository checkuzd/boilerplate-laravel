<x-admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
                <h4 class="page-title">Create User</h4>
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

            <form action="{{ route('admin.users.store') }}" method="POST" class="mb-3" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-xl-6">

                                <div class="mb-3">
                                    <x-admin.input-label for="username" :value="__('Username')" />
                                    <x-admin.text-input id="username" class="form-control" type="text" name="username" :value="old('username')" />
                                    <x-admin.input-error :messages="$errors->get('username')" />
                                </div>

                                <div class="mb-3">
                                    <x-admin.input-label for="first_name" :value="__('First Name')" />
                                    <x-admin.text-input id="first_name" class="form-control" type="text" name="first_name" :value="old('first_name')" />
                                    <x-admin.input-error :messages="$errors->get('first_name')" />
                                </div>

                                <div class="mb-3">
                                    <x-admin.input-label for="last_name" :value="__('Last Name')" />
                                    <x-admin.text-input id="last_name" class="form-control" type="text" name="last_name" :value="old('last_name')" />
                                    <x-admin.input-error :messages="$errors->get('last_name')" />
                                </div>

                                <div class="mb-3">
                                    <x-admin.input-label for="email" :value="__('Email')" />
                                    <x-admin.text-input id="email" class="form-control" type="email" name="email" :value="old('email')" />
                                    <x-admin.input-error :messages="$errors->get('email')" />
                                </div>

                                <div class="mb-3">
                                    <x-admin.input-label for="password" :value="__('Password')" />
                                    <x-admin.text-input id="password" name="password" type="password" class="form-control" />
                                    <x-admin.input-error :messages="$errors->get('password')" />
                                </div>

                            </div> <!-- end col-->

                            <div class="col-xl-6">
                                <div class="mb-3 mt-3 mt-xl-0">
                                    <label for="projectname" class="mb-0">Avatar</label>
                                    <p class="text-muted font-14">Recommended thumbnail size 400x400 (px).</p>

                                    <div
                                        x-data
                                        x-init="
                                            FilePond.registerPlugin(FilePondPluginImagePreview);
                                            FilePond.create($refs.filepond)
                                            FilePond.setOptions({
                                                storeAsFile: true,
                                                credits: false
                                            });
                                        "
                                    >
                                        <input name="avatar" type="file" x-ref="filepond" />
                                    </div>
                                    <!-- end file preview template -->
                                </div>

                                <div class="mb-3">
                                    <x-admin.input-label for="role" :value="__('User Role')" />
                                    <select class="form-select mb-3" id="role" name="role">
                                        <option>Select</option>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ ($role->id==old('role')) ? 'selected' : '' }}>{{ $role->title }}</option>
                                        @endforeach
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('role')" />
                                </div>

                            </div> <!-- end col-->
                        </div>

                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <button type="submit" class="btn btn-primary mb-3">Create User</button>
            </form>
        </div>
    </div>
</x-admin-layout>

<x-admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit User</h4>
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

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="mb-3" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-xl-6">

                                <div class="mb-3">
                                    <x-admin.input-label for="username" :value="__('Username')" />
                                    <x-admin.text-input id="username" class="form-control" type="text" name="username" :value="old('username', $user->username)" />
                                    <x-admin.input-error :messages="$errors->get('username')" />
                                </div>

                                <div class="mb-3">
                                    <x-admin.input-label for="first_name" :value="__('First Name')" />
                                    <x-admin.text-input id="first_name" class="form-control" type="text" name="first_name" :value="old('first_name', $user->first_name)" />
                                    <x-admin.input-error :messages="$errors->get('first_name')" />
                                </div>

                                <div class="mb-3">
                                    <x-admin.input-label for="last_name" :value="__('Last Name')" />
                                    <x-admin.text-input id="last_name" class="form-control" type="text" name="last_name" :value="old('last_name', $user->last_name)" />
                                    <x-admin.input-error :messages="$errors->get('last_name')" />
                                </div>

                                <div class="mb-3">
                                    <x-admin.input-label for="email" :value="__('Email')" />
                                    <x-admin.text-input id="email" class="form-control" type="email" name="email" :value="old('email', $user->email)" />
                                    <x-admin.input-error :messages="$errors->get('email')" />
                                </div>

                                <div class="mb-3">
                                    <x-admin.input-label for="password" :value="__('New Password')" />
                                    <x-admin.text-input id="password" name="password" type="password" class="form-control" />
                                    <x-admin.input-error :messages="$errors->get('password')" />
                                </div>

                            </div> <!-- end col-->

                            <div class="col-xl-6">
                                <div class="mb-3 mt-3 mt-xl-0">
                                    <label for="projectname" class="mb-0">Avatar</label>
                                    <p class="text-muted font-14">Recommended thumbnail size 400x400 (px).</p>

                                    @if(auth()->user()->getFirstMediaUrl('avatar', 'thumb'))
                                    <div class="avatar-lg">
                                        <span class="avatar-title bg-#666-lighten rounded-circle text-uppercase">
                                            <img src="{{ $user->getFirstMediaUrl('avatar', 'thumb') }}" alt="SA">
                                        </span>
                                    </div>
                                    @endif
                                    <x-admin.image-upload-preview :fieldName="'avatar'" />
                                    <!-- end file preview template -->
                                </div>

                                <div class="mb-3">
                                    <h4>User Role</h4>
                                    <select class="form-select mb-3" name="role">
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ ($user->getRoleId() == $role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('role')" />
                                </div>

                            </div> <!-- end col-->
                        </div>

                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <button type="submit" class="btn btn-primary mb-3">Update User</button>
            </form>
        </div>
    </div>
    @section('scripts')
        {{ Vite::useBuildDirectory('backend') }}
        @vite('resources/backend/js/filepond.js')
    @endsection
</x-admin-layout>

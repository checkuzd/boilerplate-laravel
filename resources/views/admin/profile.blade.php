<x-admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
                <h4 class="page-title">Profile</h4>
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

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="mb-3">
                @csrf
                @method('PATCH')
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-xl-6">

                                <div class="mb-3">
                                    <x-admin.input-label for="first_name" :value="__('First Name')" />
                                    <x-admin.text-input id="first_name" class="form-control" type="text" name="first_name" :value="old('first_name', auth()->user()->first_name)" required autofocus autocomplete="first_name" />
                                    <x-admin.input-error :messages="$errors->get('first_name')" />
                                </div>

                                <div class="mb-3">
                                    <x-admin.input-label for="last_name" :value="__('Last Name')" />
                                    <x-admin.text-input id="last_name" class="form-control" type="text" name="last_name" :value="old('last_name', auth()->user()->last_name)" autofocus autocomplete="last_name" />
                                    <x-admin.input-error :messages="$errors->get('last_name')" />
                                </div>

                                <div class="mb-3">
                                    <x-admin.input-label for="email" :value="__('Email')" />
                                    <x-admin.text-input id="email" class="form-control" type="email" name="email" :value="old('email', auth()->user()->email)"  autofocus autocomplete="email" />
                                    <x-admin.input-error :messages="$errors->get('email')" />
                                </div>

                                <div class="mb-3">
                                    <x-admin.input-label for="current_password" :value="__('Current Password')" />
                                    <x-admin.text-input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
                                    <x-admin.input-error :messages="$errors->get('current_password')" />
                                </div>

                                <div class="mb-3">
                                    <x-admin.input-label for="password" :value="__('New Password')" />
                                    <x-admin.text-input id="password" name="password" type="password" class="form-control" autocomplete="new-password" />
                                    <x-admin.input-error :messages="$errors->get('password')" />
                                </div>

                                <div class="mb-3">
                                    <x-admin.input-label for="password_confirmation" :value="__('Confirm Password')" />
                                    <x-admin.text-input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
                                    <x-admin.input-error :messages="$errors->get('password_confirmation')" />
                                </div>

                            </div> <!-- end col-->

                            <div class="col-xl-6">
                                <div class="mb-3 mt-3 mt-xl-0">
                                    <label for="projectname" class="mb-0">Avatar</label>
                                    <p class="text-muted font-14">Recommended thumbnail size 400x400 (px).</p>
                                    @if(auth()->user()->getFirstMediaUrl('avatar', 'thumb'))
                                    <div class="avatar-lg">
                                        <span class="avatar-title bg-#666-lighten rounded-circle text-uppercase">
                                            <img src="{{ auth()->user()->getFirstMediaUrl('avatar', 'thumb') }}" alt="SA">
                                        </span>
                                    </div>
                                    @endif
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

                            </div> <!-- end col-->
                        </div>
                        <!-- end form -->

                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <button type="submit" class="btn btn-primary mb-3">Update</button>
            </form>
        </div>
    </div>
</x-admin-layout>

<x-admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
                <h4 class="page-title">Settings</h4>
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

            <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="mb-3 needs-validation" novalidate >
                @csrf
                @method('PATCH')

                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <ul class="nav nav-tabs nav-bordered mb-3">
                                <li class="nav-item">
                                    <a href="#general" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                        <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                        <span class="d-none d-md-block">General</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#social" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Social</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#email" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                        <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Mail</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane show active" id="general">

                                    <div class="col-xl-12">
                                        <div class="mb-3">
                                            <livewire:admin.logo-upload-and-preview :logoType="'big'" />
                                        </div>
                                        <div class="mb-3">
                                            <livewire:admin.logo-upload-and-preview :logoType="'small'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-admin.input-label for="website_name" :value="__('Website Name')" />
                                            <x-admin.text-input id="website_name" class="form-control" type="text" name="website_name" :value="old('website_name')" value="{{ SettingsHelper::get('website_name') }}" autocomplete="website_name" />
                                            <x-admin.input-error :messages="$errors->get('website_name')" />
                                        </div>
                                        <div class="mb-3">
                                            <x-admin.input-label for="footer_text" :value="__('Footer Text')" />
                                            <x-admin.text-input id="footer_text" class="form-control" type="text" name="footer_text" :value="old('footer_text')" value="{{ SettingsHelper::get('footer_text') }}" autocomplete="footer_text" />
                                            <x-admin.input-error :messages="$errors->get('footer_text')" />
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="social">

                                    <div class="col-xl-12">
                                        <div class="mb-3">
                                            <x-admin.input-label for="social_twitter" :value="__('Twitter')" />
                                            <x-admin.text-input id="social_twitter" class="form-control" type="text" name="social_twitter" :value="old('social_twitter')" value="{{ SettingsHelper::get('social_twitter') }}" autocomplete="social_twitter" required />
                                            <x-admin.input-error :messages="$errors->get('social_twitter')" />
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="email">
                                    <div class="col-md-12">
                                        <div class="col-xl-12">
                                            <div class="mb-3">
                                                <x-admin.input-label for="email_address" :value="__('Email Address')" />
                                                <x-admin.text-input id="email_address" class="form-control" type="email" name="email_address" :value="old('email_address')" value="{{ SettingsHelper::get('email_address') }}" data-required="1" required autocomplete="email_address" />
                                                <x-admin.input-error :messages="$errors->get('email_address')" />
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Host</label>
                                            <input value="{{ config('mail.mailers.smtp.host') }}" type="text" class="form-control" disabled="">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Port</label>
                                            <input value="{{ config('mail.mailers.smtp.port') }}" type="text" class="form-control" disabled="">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input value="{{ config('mail.mailers.smtp.username') }}" type="text" class="form-control" disabled="">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="input-group input-group-merge">
                                                <input value="{{ config('mail.mailers.smtp.password') }}" disabled="" type="password" class="form-control">
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mailer</label>
                                            <input value="{{ config('mail.mailers.smtp.transport') }}" type="text" class="form-control" disabled="">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Encryption</label>
                                            <input value="{{ config('mail.mailers.smtp.encryption') }}" type="text" class="form-control" disabled="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mb-3">Update</button>
            </form>
        </div>
    </div>
</x-admin-layout>

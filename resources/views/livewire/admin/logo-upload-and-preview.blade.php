<div>
    <x-admin.input-label for="logo" :value="__('Logo')" />
    <div class="logo-preview">
        <img src="{{ SettingsHelper::logo() }}?t={{ SettingsHelper::getTimeNow() }}" class="w-25" >
    </div>
    <div
        wire:ignore
        x-data
        x-init="
            FilePond.create($refs.filepond)
            FilePond.setOptions({
                credits: false,
                server: {
                    process: (fieldName, file, metadata, load, error, progress) => {
                        @this.upload('logo', file, load)
                    }
                }
            });
        "
    >
        <input x-ref="filepond" />
    </div>
    @error('logo') <span class="error">{{ $message }}</span> @enderror
</div>

@props(['fieldName'])

<div>
    <div class="logo-preview">
        <img src="{{ SettingsHelper::logo($fieldName) }}?t={{ SettingsHelper::getTimeNow() }}" class="w-auto" >
    </div>
    <div>
        <input type="file" name="{{ $fieldName }}" class="filepond">
    </div>
</div>

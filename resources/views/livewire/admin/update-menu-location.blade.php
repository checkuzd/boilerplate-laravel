<form wire:submit="updateLocation" class="d-flex flex-column gap-1">
    @foreach (\App\Enums\MenuLocation::cases() as $menuLocation)
    <div class="form-check">
        <input type="checkbox" class="form-check-input" wire:model="location" value="{{ $menuLocation }}" id="{{ $menuLocation }}">
        <label class="form-check-label" for="{{ $menuLocation }}">
            {{ $menuLocation->displayLocation() }}
        </label>
    </div>
    @endforeach

    <button type="submit" class="mt-1 btn btn-sm btn-primary">Update Location</button>
</form>

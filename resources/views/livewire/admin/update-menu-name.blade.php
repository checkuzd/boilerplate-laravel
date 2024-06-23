<div class="menu-name-form">
    @error('name') <span class="error mt-0">{{ $message }}</span> @enderror
    <div class="d-flex gap-3 align-items-center">
        <label class="d-flex gap-3 align-items-center">
            <span>Menu Name</span>
            <input type="text"  wire:model="name">
        </label>
        <button class="btn btn-sm btn-primary" wire:click="update">Update Menu Name</button>
    </div>
</div>

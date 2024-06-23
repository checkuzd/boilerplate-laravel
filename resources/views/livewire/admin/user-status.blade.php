<div>
    <input type="checkbox"
        id="switch{{ $user_id }}"
        wire:click="updateStatus" {{ ($status) ? 'checked' : '' }} data-switch="success"
    />
    <label
        for="switch{{ $user_id }}"
        data-on-label="Yes"
        data-off-label="No"
        class="mb-0 d-block"
    >
    </label>
</div>

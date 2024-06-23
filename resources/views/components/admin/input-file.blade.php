@props(['ilabel','iname'])
<div>
    <label class="form-label">
        {{ $ilabel }}
    </label>
    <div
        x-data
        x-init="
            FilePond.setOptions({
                server: {
                    process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                        load({{ $iname }});
                    }
                }
            });
            FilePond.create($refs.input);
        "
    >
        <input type="file" id="{{ $iname }}" name="{{ $iname }}" wire:model.live="{{ $iname }}" x-ref="input" />
    </div>
</div>

@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'validation-error']) }}>
        @foreach ((array) $messages as $message)
            <span>{{ $message }}</span>
        @endforeach
    </div>
@endif

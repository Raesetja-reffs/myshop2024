@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback']) }}>
        @foreach ((array) $messages as $message)
            <div>{{ $message }}</div>
        @endforeach
    </div>
@endif

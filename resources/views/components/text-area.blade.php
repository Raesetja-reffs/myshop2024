@props(['value', 'disabled' => false, 'messages' => null])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => !empty($messages) ? 'is-invalid' : '']) !!}>{{ $value }}</textarea>

@if ($messages)
    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
        @foreach ((array) $messages as $message)
            <div>{{ $message }}</div>
        @endforeach
    </div>
@endif

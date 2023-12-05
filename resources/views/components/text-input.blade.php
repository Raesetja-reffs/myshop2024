@props(['disabled' => false, 'messages' => null, 'checkboxValue' => ''])

<input
    {{ $checkboxValue == 1 ? 'checked' : '' }}
    {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => !empty($messages) ? 'is-invalid' : '']) !!}>

@if ($messages)
    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
        @foreach ((array) $messages as $message)
            <div>{{ $message }}</div>
        @endforeach
    </div>
@endif

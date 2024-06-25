@props(['value', 'options', 'disabled' => false, 'messages' => null])

<select data-control="select2" data-placeholder="Select an option"
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => !empty($messages) ? 'form-select is-invalid' : 'form-select']) !!}
>
    <option></option>
    @foreach ($options as $optionKey => $option)
        @if (is_string($option))
            @php $option = ['id' => $optionKey, 'name' => $option]; @endphp
        @endif
        @php $isSelect = false; @endphp
        @if (is_array($value))
            @if (in_array($option['id'], $value))
                @php $isSelect = true; @endphp
            @endif
        @else
            @if ($option['id'] == $value)
                @php $isSelect = true; @endphp
            @endif
        @endif
        <option value="{{ $option['id'] }}" {{ $isSelect ? 'selected': '' }}>{{ $option['name'] }}</option>
    @endforeach
</select>

@if ($messages)
    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
        @foreach ((array) $messages as $message)
            <div>{{ $message }}</div>
        @endforeach
    </div>
@endif

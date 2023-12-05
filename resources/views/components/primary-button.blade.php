<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary']) }}>
    <span class="indicator-label">
        {{ $slot }}
    </span>
    <span class="indicator-progress">
        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
    </span>
</button>

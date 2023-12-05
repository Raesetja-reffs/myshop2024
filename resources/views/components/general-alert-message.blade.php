@props(['type', 'message'])

<div class="alert alert-{{ $type }} d-flex align-items-center p-1 mt-5 mb-0">
    <i class="ki-outline ki-shield-tick fs-2hx text-{{ $type }} me-2"></i>
    <div class="d-flex flex-column">
        <h4 class="mb-1 text-{{ $type }}">{{ $message }}</h4>
    </div>
    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert" fdprocessedid="g4ghrt">
        <i class="ki-outline ki-cross fs-2x text-{{ $type }}"></i>
    </button>
</div>
<script>
    setTimeout(({{ $type }}) => {
        if ($("#kt_content_container").find('div.alert.alert-' + {{ $type }}).length > 0) {
            $("#kt_content_container").find('div.alert.alert-' + {{ $type }}).remove();
        }
    }, 5000, '{{ $type }}');
</script>

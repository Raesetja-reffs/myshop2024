<x-iframe-pdf-layout>
    <div class="d-flex justify-content-end mb-2 print-button-container m-2">
        <button class="btn btn-primary print-button">
            Print
        </button>
        <button class="btn btn-primary print-button-loader disabled" style="display: none;">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="sr-only">Loading...</span>
        </button>
    </div>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        $(document).ready(function() {
            $(document).on('click', '.print-button', function() {
                var curobj = $(this);
                curobj.hide();
                $('.print-button-loader').show();
                $.ajax({
                    url: '{!!url("/invoicedoc")!!}',
                    type: "POST",
                    data: {
                        OrderId : {{ $ID }},
                    },
                    success: function (data) {
                        console.log(data);
                    },
                    complete: function() {
                        curobj.show();
                        $('.print-button-loader').hide();
                    }
                });
            });
        });
    </script>
    <iframe src="{{ $reportViewerUrl }}" title="Order"></iframe>
</x-iframe-pdf-layout>

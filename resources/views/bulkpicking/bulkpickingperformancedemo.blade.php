<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="40">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />

    <style>
        .rag-red {
            background-color: lightcoral;
        }
        .rag-green {
            background-color: lightgreen;
        }
        .rag-amber {
            background-color: lightsalmon;
        }

        .rag-red-outer .rag-element {
            background-color: lightcoral;
        }

        .rag-green-outer .rag-element {
            background-color: lightgreen;
        }

        .rag-amber-outer .rag-element {
            background-color: lightsalmon;
        }

    </style>
</head>
<body>
@if (!empty($performance) && count($performance) > 0)
    @foreach($performance as $val)
       {!! $val !!}
    @endforeach
@else
    <p>No data available.</p>
@endif
<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {
        $('#livepickingtable').on('dblclick', 'tbody tr', function () {


            var $this = $(this);
            var row = $this.closest("tr");
            var ordertype = row.find('td:eq(0)').text();
            var route = row.find('td:eq(1)').text();
            var del = row.find('td:eq(2)').text();

            window.open('{!!url("/designPickingInformationPerTeam")!!}/'+del+"/"+route+"/"+ordertype, 'onewinbulk', "location=1,status=1,scrollbars=1, width=1200,height=850");

        });
    });
</script>
</body>
</html>
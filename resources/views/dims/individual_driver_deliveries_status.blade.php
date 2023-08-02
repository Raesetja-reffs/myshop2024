<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="20">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css" />

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
<div class="col-md-12" style="background: black;color:white;">
    <a href='{!!url("/officemap")!!}' onclick="window.open(this.href, 'massc',
'left=20,top=20,width=1000,height=1000,toolbar=1,resizable=0'); return false;" >MAP</a>
    <br>
<h4>This Information Relay On The User Device Coverage </h4>
    <table class="table" id="livepickingtable">
        <thead>
        <th>STOP NAME</th>
        <th>FINISHED TIME</th>
        </thead>
        <tbody style="font-size: 25px;font-family: sans-serif;font-weight: 900;">
        @foreach($stops as $val)
            @if( $val->offloaded =="0")
                <tr style="background: white;color: black">@endif
            @if( $val->offloaded =="1")
                <tr style="background: #fd00ff8a;color: black" >
            @endif
                    <td>{{$val->StoreName}}   </td>
                    <td>{{$val->dteOffloadedTime}}</td>
                </tr>

                @endforeach
        </tbody>
    </table>

</div>

<script type="text/javascript" charset="utf-8">

</script>
</body>
</html>

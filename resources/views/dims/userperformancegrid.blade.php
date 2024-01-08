<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="300">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
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
<div class="col-md-12" style="background: black;color:white;height: 1500px;">
    <div style="background: white;">
    <a href='{!!url("/userpickingloadingperformancereport")!!}' onclick="window.open(this.href, 'massc',
'left=20,top=20,width=1000,height=1000,toolbar=1,resizable=0'); return false;" style="    margin-left: 31px;">Advance</a>

    <a href='{!!url("/bulkPickingPerUserView")!!}' onclick="window.open(this.href, 'bulkperUser',
'left=20,top=20,width=1000,height=1000,toolbar=1,resizable=0'); return false;" style="    margin-left: 31px;">Bulk Picking User</a>
    <a href='{!!url("/liveBulkPicking")!!}' onclick="window.open(this.href, 'bulkperUser',
'left=20,top=20,width=1500,height=1000,toolbar=1,resizable=0'); return false;" style="margin-left: 31px;">Live Picking Status</a></div>
    <table class="table">
        <thead>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">User</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Items</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">KG Picked/Loaded</th>
        </thead>
        <tbody style="font-size: 25px;font-family: sans-serif;font-weight: 900;">
            @foreach($performance as $val)
                <tr>
                    <td>{{$val->UserName}}</td>
                    <td>{{$val->TotalLines}}</td>
                    <td>{{$val->TotalMass}}</td>
                </tr>

            @endforeach
            </tbody>
    </table>

</div>
</body>
</html>

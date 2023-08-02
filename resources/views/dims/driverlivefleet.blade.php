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
<div class="col-md-12" style="background: black;color:white;height: 1500px;">
    <a href='{!!url("/officemap")!!}' onclick="window.open(this.href, 'massc',
'left=20,top=20,width=1000,height=1000,toolbar=1,resizable=0'); return false;" >MAP</a>
<br>
    <input id="deliverydate" value="{{$delDate}}" style="color:black;font-weight: 900;">
    <table class="table" id="livepickingtable">
        <thead>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Route No</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Area</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">DriverName</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Assistant</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">No Of Invoices</th>

        </thead>
        <tbody style="font-size: 25px;font-family: sans-serif;font-weight: 900;">
        @foreach($performance as $val)
            @if( $val->delstatus =="NOTSTARTED")
                <tr style="background: red;color: black">@endif
            @if( $val->delstatus =="PROG")
                <tr style="background: yellow;color: black" >
            @endif
            @if( $val->delstatus =="DONE")
                <tr style="background: green;color: black" >
                    @endif
                    <td>{{$val->OrderType}}   </td>
                    <td>{{$val->Route}}</td>
                    <td>{{$val->DriverName}}</td>
                    <td>{{$val->vanAssistant}}</td>
                    <td>{{$val->stopsDelv}}</td>



                </tr>

                @endforeach
        </tbody>
    </table>

</div>

<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {
        $('#livepickingtable').on('dblclick', 'tbody tr', function () {


            var $this = $(this);
            var row = $this.closest("tr");
            var ordertype = row.find('td:eq(0)').text();
            var route = row.find('td:eq(1)').text();
            var del = $('#deliverydate').val();

            window.open('{!!url("/driverFleetInfo")!!}/'+del+"/"+route+"/"+ordertype, 'onewinbulk', "location=1,status=1,scrollbars=1, width=1200,height=850");

        });
    });
</script>
</body>
</html>

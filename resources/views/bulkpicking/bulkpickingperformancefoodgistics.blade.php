<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="20">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <script src="{{ asset('js/ag_grid.js') }}"></script>

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
    <a href='{!!url("/userpickingloadingperformancereport")!!}' onclick="window.open(this.href, 'massc',
'left=20,top=20,width=1000,height=1000,toolbar=1,resizable=0'); return false;" >Advance</a>
    <table class="table" id="livepickingtable" style="width: 100%">
        <thead>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Type</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Route</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Delivery Date</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;">Chilled</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;">Dry 1</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;">Dry 2</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;">Dry 3</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;">Frozen</th>


        </thead>
        <tbody style="font-size: 25px;font-family: sans-serif;font-weight: 900;">
        @foreach($performance as $val)
            @if( $val->blnAttended =="NOT STARTED")
                <tr style="background: red;color: black">@endif
            @if( $val->blnAttended =="PROGRESS")
                <tr style="background: yellow;color: black" >
            @endif
            @if( $val->blnAttended =="DONE")
                <tr style="background: green;color: black" >
                    @endif
                    <td>{{$val->OrderType}}   </td>
                    <td>{{$val->Route}}</td>
                    <td>{{$val->dDelDate}}</td>
                    <td>{{$val->Chilled}}</td>
                    <td>{{$val->Dry1}}</td>
                    <td>{{$val->Dry2}}</td>
                    <td>{{$val->Dry3}}</td>
                    <td>{{$val->Frozen}}</td>


                </tr>

                @endforeach
        </tbody>
    </table>

</div>

<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
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

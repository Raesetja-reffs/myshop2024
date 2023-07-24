<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

    </style>
</head>
<body>
<div class="col-md-12" >
    <div class="col-md-3">
        <h5>{{$ot}}</h5>
        <h5>{{$route}}</h5>
        <label>Driver Name</label><br>
        <select id="driverid" >
            @foreach($routinginfo as $valr)
                <option value="{{$valr->DriverId}}">{{$valr->DriverName}}</option>
            @endforeach
            @foreach($drivers as $val)
                <option value="{{$val->DriverId}}">{{$val->DriverName}}</option>
            @endforeach
        </select><br>
        <label>Van Assistant</label><br>
        <select id="assistantid" >
            @foreach($routinginfo as $valr)
                <option value="{{$valr->assId}}">{{$valr->AssitName}}</option>
            @endforeach
            @foreach($drivers as $val)
                <option value="{{$val->DriverId}}">{{$val->DriverName}}</option>
            @endforeach
        </select><br>
        <label>Truck Name</label><br>
        <select id="truckid" >
            @foreach($routinginfo as $valr)
                <option value="{{$valr->TruckId}}">{{$valr->RegNo}}</option>
            @endforeach
            @foreach($trucks as $val)
                <option value="{{$val->TruckId}}">{{$val->RegNo}}</option>
            @endforeach
        </select><br>
        <label>Dispatch Area</label><br>
        <select id="dispatchid" >
            @foreach($dispatch as $val)
                <option value="{{$val->intAutodispatchlocations}}">{{$val->strDoorName}}</option>
            @endforeach
        </select><br>
        <button id="finish" class="btn-success btn-md" value="{{$routingId}}">SUBMIT</button>
    </div>
    <div class="col-md-3">
        @foreach($routinginfo as $val)
            <table>
                <tr>
                    <td>Driver signed for stock</td>
                    <td>{{$val->strdrivername}}</td>
                </tr>
                <tr>
                    <td>KM OUT</td>
                    <td>{{$val->mnykmoutt}}</td>
                </tr>
                <tr>
                    <td>KM IN</td>
                    <td>{{$val->mnykmdone}}</td>
                </tr>
                <tr>
                    <td>Time Ended The Trip</td>
                    <td>{{$val->dtm}}</td>
                </tr>
            </table>
        @endforeach

    </div>
    <div class="col-md-6">
        <h5>ROUTE INFORMATION</h5>
        @foreach($routinginfo as $val)
            <input type="text" name="routename" id="routename" value="{{$val->Route}}">
            <input type="text" name="ordertype" id="ordertype" value="{{$val->OrderType}}">
            <input type="text" name="deliverytype" id="deliverytype" value="{{$val->DeliveryDate}}">
        @endforeach

        <table id="infotable">
            <thead>
            <th>STOP NAME</th>
            <th>OFFLOADED TIME</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<div class="col-md-12" >
    <div id="myGrid" style="height: 700px;width:95%;" class="ag-theme-balham"></div>
</div>

<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {


        $('#finish').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{!!url("/updatelogisticsinformation")!!}',
                type: "GET",
                data: {
                    routingid: $('#finish').val(),
                    driverid: $('#driverid').val(),
                    assistantid: $('#assistantid').val(),
                    truckid: $('#truckid').val(),
                    dispatchid: $('#dispatchid').val()
                },
                success: function (data) {
                    alert("Please don't forget to click SUBMIT button to refresh data");
                    close();

                    /* console.debug(data.length);
                     if(data.length > 0)
                     {
                         alert("Deleted");
                         close();
                     }
                     console.debug(data[0].Result);*/
                    //
                    //location.reload(true);

                }
            });
        });

        routeInfo($('#routename').val(),$('#ordertype').val(),$('#deliverytype').val());
    });

    function routeInfo(route,ordertype,deldate)
    {
//infotable
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{!! url("/getLiveDriversInfo") !!}',
            type: "POST",
            data: {

                route: route,
                ordertype: ordertype,
                deldate: deldate

            },success: function (data) {
                var trHTML = '';
                $('#infotable tbody').empty();

                $.each(data, function (key, value) {
                    var classes = 'onDrag';

                    if (value.offloaded ==1)
                    {
                        classes = 'onDrag backgroudcolorOffloaded';
                    }
                    trHTML += '<tr class="'+classes+'" style="font-size: 15px;color:black"><td>' +
                        value.StoreName + '</td><td>' +
                        value.dteOffloadedTime + '</td>' +
                        '</tr>';

                });
                $('#infotable tbody').append(trHTML);
            }
        });
    }
    var columnDefs = [
        {headerName: "OrderId", field: "OrderId",width: 90},
        {headerName: "Item Code", field: "PastelCode",width: 180},
        {headerName: "Description", field: "PastelDescription",width: 200},
        {headerName: "Reason", field: "strCustomerReason",width: 100},
        {headerName: "Return Qty", field: "returnQty",width: 90},
        {headerName: "Qty", field: "Qty",width: 90},
        {headerName: "Qty Picked", field: "fltQtyPicked",width: 90},
        {headerName: "StoreName", field: "StoreName",width: 90},
        {headerName: "Customer Code", field: "CustomerPastelCode",width: 150},
        {headerName: "Route(Area)", field: "Route",width: 150},
        {headerName: "Type", field: "OrderType",width: 150},
        {headerName: "Reg No", field: "RegNo",width: 150},
        {headerName: "Driver Name", field: "DriverName",width: 150},
        {headerName: "Order Offloaded Time", field: "dteOffloadedTime",width: 100},
        {headerName: "Requisition server time", field: "dteLineRequisition",width: 100},
    ];

    // let the grid know which columns and what data to use
    var gridOptions = {
        columnDefs: columnDefs,
        floatingFilter: true,
        enableSorting: true,
        enableFilter: true,
        enableColResize: true
    };
    var Odate = new Date();
    var newODate = $.datepicker.formatDate('dd-mm-yy', new Date(Odate));
    var eGridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(eGridDiv, gridOptions);
    var routingid = $('#finish').val();

    fetch('{!!url("/driverreq_perrouteJson")!!}/' + routingid).then(function (response) {
        return response.json();
    }).then(function (data) {
        gridOptions.api.setRowData(data);
    });

</script>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css" />
    <style>
        .rag-red {
            background-color: #f00f0c;
        }
        .rag-green {
            background-color: lightgreen;
        }
        .rag-amber {
            background-color: lightsalmon;
        }
        .rag-yellow {
            background-color: #f6ff23;
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


        #notdone {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #notdone td, #notdone th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #notdone tr:nth-child(even){background-color: #f2f2f2;}

        #notdone tr:hover {background-color: #ddd;}

        #notdone th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #bb1523;
            color: white;
        }

        #tblorderlines {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #tblorderlines td, #tblorderlines th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #tblorderlines tr:nth-child(even){background-color: #f2f2f2;}

        #tblorderlines tr:hover {background-color: #ddd;}

        #tblorderlines th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #bb1523;
            color: white;
        }
    </style>
</head>
<body style="font-family: Sans-serif">
<div style="display:flex ">
    <div class="notdone"  style="width: 30%">
        <h4>Not Transfered yet</h4>
        <table id="notdone">
            <tr>
                <th>Transfer No</th>
                <th>Credit By</th>
                <th>Date Created</th>
                <th>Delivery Date</th>

            </tr>

            <tbody  >
            @foreach($Transfers as $value)
                <tr>
                    <td>{{$value->OrderId}}</td>
                    <td>{{$value->UserName}}</td>
                    <td>{{$value->OrderDate}}</td>
                    <td>{{$value->DeliveryDate}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="today"  style="width: 30%">
        <h4>Transfers by date</h4>
        <input id="statustoday"> <button id="btntoday">Get</button><br>
        <div id="transbydate" style="height: 700px;width:95%;" class="ag-theme-balham"></div>

    </div>
    <div class="credits" style="width: 40%">
       <h4>Overs and Unders</h4>
        FROM<input id="statuscredits">
        TO <input id="statuscreditsdateTo">

        <button id="btncredits">Get</button><br>
        <div id="oversandunders" style="height: 500px;width:100%;" class="ag-theme-balham"></div>
        <hr style="border: 5px solid black;">
        <div id="orderlines">
            <table id="tblorderlines">
                <thead>
                <tr>
                    <th>OrderId</th>
                    <th>Product</th>
                    <th>Original Transfer Qty</th>
                    <th>Scanned Qty Total</th>
                    <th>Dispatched Qty Total</th>
                    <th>Merged Reason</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>
</div>





<script type="text/javascript" charset="utf-8">
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#statustoday").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });
        $("#statuscredits").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });
        $("#statuscreditsdateTo").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });

        var columnDefscred = [
            {headerName: "OrderId", field: "Orderids",width: 100},
            {headerName: "Product Name", field: "PastelDescription",width: 100},
            {headerName: "Product Code", field: "PastelCode",width: 75},
            {headerName: "DeliveryDate", field: "DeliveryDate",width: 75},
            {headerName: "Reason", field: "Reason",width: 100},
            {headerName: "Dispatched", field: "QtyDespatched",width: 75},
            {headerName: "Scanned", field: "QtyScanned",width: 75 },
            {headerName: "Action", field: "checked",width: 75,

                cellRenderer: function(params) {
                    var input = document.createElement('button');
                    //console.debug(input);
                    input.type="button";
                    input.innerHTML="Browse";

                    if(params.value != 0)
                    {
                        input.checked=params.value;
                    }

                    input.addEventListener('click', function (event) {

                  /*      if(input.checked)
                        {*/
                            console.debug("it is true"+params.node.data.Orderids);
                            console.debug("it is true"+params.node.data.PastelCode);
                            openOrderDetails(params.node.data.Orderids,params.node.data.PastelCode,params.node.data.Reason,params.node.data.QtyScanned,params.node.data.QtyDespatched);
                            //updateCheckedOrNot(1,params.node.data.OrderDetailId);
                       /* }else{
                            console.debug("it is false"+params.node.data.Orderids);
                            console.debug("it is true"+params.node.data.PastelCode);
                            openOrderDetails(params.node.data.Orderids,params.node.data.PastelCode);
                            //updateCheckedOrNot(0,params.node.data.OrderDetailId);
                        }*/
                        //params.node.data.OrderDetailId = params.value;
                    });
                    return input;
                }
            }

        ];
        var columnDefsTrans = [
            {headerName: "OrderId", field: "OrderId",width: 100},
            {headerName: "Transfer", field: "InvoiceNo",width: 100},
            {headerName: "OrderDate", field: "OrderDate",width: 75},
            {headerName: "DeliveryDate", field: "DeliveryDate",width: 75},
            {headerName: "Signed By", field: "strCustomerSignedBy",width: 100},
            {headerName: "Loaded By", field: "strLoadedBy",width: 100},
            {headerName: "Checked", field: "CheckedOversAndUnders",width: 100 ,

                cellRenderer: function(params) {
                    var input = document.createElement('input');
                    input.type="checkbox";
                    if(params.value != 0)
                    {
                        input.checked=params.value;
                    }

                    input.addEventListener('click', function (event) {

                        if(input.checked)
                        {
                            console.debug("it is true"+params.node.data.OrderId);
                            checkUnCheckTransfers(1,params.node.data.OrderId);
                        }else{
                            console.debug("it is false"+params.node.data.OrderId);
                            checkUnCheckTransfers(0,params.node.data.OrderId);
                        }
                        //params.node.data.OrderDetailId = params.value;
                    });
                    return input;
                }
            }

        ];

        // let the grid know which columns and what data to use
        var gridOptionsCred = {
            columnDefs: columnDefscred,
            floatingFilter: true,
            enableSorting: true,
            enableFilter: true,
            enableColResize: true,
            defaultColDef: {
                /* editable: true,*/
                resizable: true,

            },
            suppressRowClickSelection: true,
            rowSelection: 'multiple',
            onRowDoubleClicked: doSomething

        };

        gridOptionsCred.rowStyle = {background: 'white'};
        gridOptionsCred.getRowStyle = function(params) {

            if (params.node.data.statusId=="Fully") {
                return { background: 'green' }
            }
            if (params.node.data.statusId=="Partially") {
                return { background: 'yellow' }
            }
            /*if (params.node.data.statusId=="Not") {
                return { background: 'green' }
            }*/

        }
        var gridOptionsTransfer = {
            columnDefs: columnDefsTrans,
            floatingFilter: true,
            enableSorting: true,
            enableFilter: true,
            enableColResize: true,
            defaultColDef: {
                /* editable: true,*/
                resizable: true,

            },
            suppressRowClickSelection: true,
            rowSelection: 'multiple',
            onRowDoubleClicked: doSomething

        };
        $('#btncredits').click(function(){
            $( "#oversandunders" ).empty();
            $('#oversandunders').show();
            var eGridDiv = document.querySelector('#oversandunders');
            new agGrid.Grid(eGridDiv, gridOptionsCred);
            var statuscredits = $('#statuscredits').val();
            var statuscreditsdateTo = $('#statuscreditsdateTo').val();
            fetch('{!!url("/getTransfersJson")!!}/'+statuscredits+'/'+statuscreditsdateTo).then(function (response) {
                return response.json();
            }).then(function (data) {

                gridOptionsCred.api.setRowData(data);
            });
        });
        $('#btntoday').click(function(){
            $( "#transbydate" ).empty();
            $('#transbydate').show();
            var eGridDiv = document.querySelector('#transbydate');
            new agGrid.Grid(eGridDiv, gridOptionsTransfer);
            var statustoday = $('#statustoday').val();
            fetch('{!!url("/getTransfersJsonbydate")!!}/'+statustoday).then(function (response) {
                return response.json();
            }).then(function (data) {
                gridOptionsTransfer.api.setRowData(data);
            });
        });


        $('#notdone tbody').on('dblclick', 'tr', function () {
            var OrderId = $(this).closest('tr').find('td:eq(0)').text();
            window.open ('{!!url("/productontheminiorderform")!!}/'+OrderId, OrderId,'left=20,top=20,width=1800,height=1250,toolbar=1,resizable=0');
        });

        function doSomething(row){
            var OrderId = row.data.OrderId;
            window.open ('{!!url("/productontheminiorderform")!!}/'+OrderId, OrderId,'left=20,top=20,width=1800,height=1250,toolbar=1,resizable=0');

        }

        function updateCheckedOrNot(checked,orderdetailId)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                url: '{!!url("/updateCheckedOrNotTrasfers")!!}',
                type: "POST",
                data: {
                    status: checked,
                    orderdetailId: orderdetailId

                },
                success: function (data) {


                }
            });
        }
        function openOrderDetails(Orderids,productCode,reasons,scanned,QtyDespatched)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                url: '{!!url("/openorderdetailsformergedtransfers")!!}',
                type: "POST",
                data: {

                    Orderids: Orderids,
                    productCode: productCode

                },
                success: function (data) {

                    $('#tblorderlines tbody').empty();
                    var trHTML = '';
                    $('#additionalcost tbody').empty();
                    var typeChecked =
                    $.each(data, function (key, value) {
                        //very tired to debug, it has 31 hours not sleeping

                        console.debug(value.CheckedOversAndUnders);
                        if(value.CheckedOversAndUnders ==1)
                        {
                            trHTML += '<tr style="font-size: 16px;color:black"><td><a href={!!url("/productontheminiorderform")!!}/'+ value.OrderId+'>'+value.OrderId+'</a></td><td>'+
                                value.PastelDescription + '</td><td>' +
                                parseFloat(value.Qty).toFixed(3)  + '</td><td>' +
                                parseFloat(scanned).toFixed(3)  + '</td><td>' +
                                parseFloat(QtyDespatched).toFixed(3)  + '</td><td>' +
                                reasons + '</td>' +
                                "<td><input type='checkbox' onclick=handleClick('"+value.OrderDetailId+"') name='orderdetail' value='"+ value.OrderDetailId+"' checked>" +

                                '</td></tr>';
                        }else{
                            trHTML += '<tr style="font-size: 16px;color:black"><td><a href={!!url("/productontheminiorderform")!!}/'+ value.OrderId+'>'+value.OrderId+'</a></td><td>'+
                                value.PastelDescription + '</td><td>' +
                                parseFloat(value.Qty).toFixed(3)  + '</td><td>' +
                                parseFloat(scanned).toFixed(3)  + '</td><td>' +
                                parseFloat(QtyDespatched).toFixed(3)  + '</td><td>' +
                                reasons + '</td>' +
                                "<td><input type='checkbox' onclick=handleClick('"+value.OrderDetailId+"') name='orderdetail' value='"+ value.OrderDetailId+"'>" +

                                '</td></tr>';
                        }

                    });

                    $('#tblorderlines tbody').append(trHTML);
                    console.debug(data);

                }
            });
        }

        function checkUnCheckTransfers(checked,orderdetailId)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                url: '{!!url("/checkUnCheckTransfers")!!}',
                type: "POST",
                data: {
                    status: checked,
                    orderdetailId: orderdetailId

                },
                success: function (data) {


                }
            });
        }
    });
    function handleClick(val)
    {
        console.debug(val);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
            url: '{!!url("/updateCheckedOrNotTrasfers")!!}',
            type: "POST",
            data: {

                orderdetailId: val

            },
            success: function (data) {


            }
        });

    }


</script>
</body>
</html>

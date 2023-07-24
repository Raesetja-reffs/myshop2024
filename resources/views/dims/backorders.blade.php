<!doctype html>
<html lang="en">
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
		<title>Orders</title>
		<link rel="icon" href="{{asset('images/1024.png')}}" type="image/icon type">
		<!-- CSS only -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
        <!-- DevExtreme theme -->
        {{-- <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.3/css/dx.light.css"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.carmine.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.contrast.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkmoon.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkviolet.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.greenmist.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.dark.css" rel="stylesheet"> --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.light.css" rel="stylesheet">
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.softblue.css" rel="stylesheet"> --}}

        <style>
            .dx-datagrid-rowsview .dx-selection.dx-row:not(.dx-row-focused):not(.dx-row-removed) > td {
                background-color: rgb(248, 243, 155);
                color: unset;
            }

            p {
                margin-top: 0 !important;
                margin-bottom: 0.5rem !important;
            }
        </style>


	</head>
	<body>
    <div class="container-fluid" style="padding: 0;">
        <header class="navbar navbar-light sticky-top bg-light shadow">
            <h1 id="stats" class="mb-0">ORDERS</h1>
            <div class="ml-auto">
                <button class="btn btn-primary mx-2" id="refresh">REFRESH ORDER</button>
                <button class="btn btn-success mx-2" id="commit">COMMIT ORDER</button>
            </div>
        </header>

        <div class="row">
            <div class="col-md-10 p-1">
                <div id="orderheader" class="w-100" style="height: 50vh;"></div>


                <div class="mb-0" style="height: 5vh; padding: 9px;"><h5 id="customer"></h5> </div>

                <div id="orderlines" class="w-100" style="height: 40vh;"></div>
            </div>

            <div class="col-md-2 p-0">
                <div class="border border-secondary p-3 h-100 bg-light">
                    <h3>LOGS:</h3>
                    <div id="logs"></div>
                </div>
            </div>
        </div>
    </div>


    </body>
</html>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="{{asset('js/main.js')}}"></script>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('focus', ':input', function() {
        $(this).attr('autocomplete', 'off');
    });

    $(document).ready(function() {
        $('#orderlinesheader').hide();

        ordersFunction();

        getcommitedLogs();

        $('#commit').click(function() {
            var headergrid = $("#orderheader").dxDataGrid("instance");
            var header = headergrid.getSelectedRowsData();

            var lines = $("#orderlines").dxDataGrid("getDataSource").items();
            // var lines = linesgrid.getSelectedRowKeys();

            console.log(header);
            console.log(lines);

            $.each(header, function(index, item) {
                // Modify the properties
                item.CustomerCode = escapeHtml(item.CustomerCode);
                item.DeliveryAddressID = escapeHtml(item.DeliveryAddressID);
                item.DeliveryDate = escapeHtml(item.DeliveryDate);
                item.ID = escapeHtml(item.ID);
                item.Notes = escapeHtml(item.Notes);
                item.OrderNumber = escapeHtml(item.OrderNumber);
                item.OrigOrderID =  item.OrigOrderID;
                item.Route = escapeHtml(item.Route);
                item.StoreName = escapeHtml(item.StoreName);
                item.UserName = escapeHtml(item.UserName);
                item.bitBackOrder = escapeHtml(item.bitBackOrder);
            });

            $.each(lines, function(index, item) {
                // Modify the properties
                item.ID = item.ID;
                item.LineTotal = item.LineTotal;
                item.OrigQty = item.OrigQty;
                item.PastelDescription = escapeHtml(item.PastelDescription);
                item.Price = item.Price;
                item.Quantity =  item.Quantity;
                item.Vat =  item.Vat;
                item.VatPrice = item.VatPrice;
                item.strComment = escapeHtml(item.strComment);
                item.strPartNumber = escapeHtml(item.strPartNumber);
            });

            $.ajax({
                url: '{!!url("/commitBackOrdersToDims")!!}',
                type: "POST",
                data: {
                    headerxml: header,
                    linesxml: lines,
                },
                success: function (data) {
                    var neworderid = data[0].orderid;
                    if(data[0].Result == "Success"){
                        if(data[0].awaitingstock == 1){


                            //var result = confirm("You are about to mark this order as awaiting stock, press OK if you are sure or Cancel to exit?");

                            var dialog = document.createElement('dialog');
                            dialog.innerHTML = '<div>You are about to mark this order as awaiting stock, are sure?</div><button id="confirmButton" style="float: right;">YES</button><button id="cancelButton"  style="background: darkred;color:white">NO</button>';

                            document.body.appendChild(dialog);
                            dialog.showModal();

                            var confirmButton = document.getElementById('confirmButton');
                            var cancelButton = document.getElementById('cancelButton');

                            confirmButton.addEventListener('click', function() {
                                // User clicked OK, perform desired action
                                // ...
                                dialog.close();
                                $.ajax({
                                    url: '{!!url("/markbackordertobeawaitingstock")!!}',
                                    type: "GET",
                                    data: {
                                        orderId:neworderid
                                    }, success: function (data) {

                                        $('#orderlinesheader').empty();
                                        $('#orderlinesheader').show();
                                        $('#orderlinesheader').hide();
                                        alert("Order Posted");

                                        ordersFunction();
                                        getcommitedLogs();
                                    }
                                });

                            });

                            cancelButton.addEventListener('click', function() {
                                // User clicked Cancel, perform desired action
                                // ...
                                dialog.close();
                                $('#orderlinesheader').empty();
                                $('#orderlinesheader').show();
                                alert("Order Posted");
                                $('#orderlinesheader').hide();
                                ordersFunction();
                                getcommitedLogs();
                            });


                        }else{
                            alert("Order Posted");
                            $('#orderlinesheader').empty();
                            $('#orderlinesheader').show();
                            $('#orderlinesheader').hide();
                            ordersFunction();
                            getcommitedLogs();
                        }


                    }else{
                        alert(data[0].Result);
                    }

                    //location.reload();
                }
            });

        });
        $('#refresh').click(function() {
            ordersFunction();
        });

	});
    function getcommitedLogs() {
        $.ajax({
            url: '{!!url("/getcommitedlogs")!!}',
            type: "GET",
            data: {}, success: function (data) {
                $('#logs').empty();
                $.each(data, function (keyDetails, valueDetails) {
                    $('#logs').append(valueDetails.intOrderId+" - "+valueDetails.strMessage  +"<br>")
                });
            }
        });
    }
    function customizeConfirmDialog() {
        var dialog = document.createElement('dialog');
        dialog.innerHTML = '<div>You are about to mark this order as awaiting stock, are sure?</div><button id="confirmButton">OK</button><button id="cancelButton">Cancel</button>';

        document.body.appendChild(dialog);
        dialog.showModal();

        var confirmButton = document.getElementById('confirmButton');
        var cancelButton = document.getElementById('cancelButton');

        confirmButton.addEventListener('click', function() {
            // User clicked OK, perform desired action
            // ...

            dialog.close();
        });

        cancelButton.addEventListener('click', function() {
            // User clicked Cancel, perform desired action
            // ...

            dialog.close();
        });
    }



    function ordersFunction(){
        $.ajax({
            url: '{!!url("/getBriefcaseBackorderHeaders")!!}',
            type: "GET",
            data: {
            },
            success: function (data) {
                $("#orderheader").dxDataGrid({
                    dataSource:data, //as json
                    showBorders: true,
                    hoverStateEnabled: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    noDataText: 'Orders have not been placed between the date range specified',
                    scrolling: {
                        mode: 'infinite',
                    },
                    paging:{
                        pageSize: 5,
                    },
                    selection: {
                        mode: 'single',
                    },

                    columns: [
                        {
                            dataField: "ID",
                            caption: "ID",
                            visible:false
                        },
                        {
                            dataField: "CustomerCode",
                            caption: "Customer Code",
                        },
                        {
                            dataField: "StoreName",
                            caption: "Store Name",
                        },
                        {
                            dataField: "DeliveryDate",
                            caption: "Delivery Date",
                            dataType: "date",
                            format: 'dd-MM-yyyy',
                        },
                        {
                            dataField: "OrderNumber",
                            caption: "Order Number",
                        },
                        {
                            dataField: "UserName",
                            caption: "User Name",
                        },
                        {
                            dataField: "Notes",
                            caption: "Notes",
                        },
                        {
                            dataField: "DeliveryAddressID",
                            caption: "Delivery Address ID",
                        },
                        {
                            dataField: "Route",
                            caption: "Route",
                        },
                        {
                            dataField: "OrigOrderID",
                            caption: "Original Order ID",
                        },
                        {
                            dataField: "bitBackOrder",
                            caption: "is Back Order",
                        },
                    ],

                    onRowClick:function(e){
                        $('#orderlinesheader').empty();
                        $('#orderlinesheader').show();
                        var headerID = e.data.ID;
                        $('#customer').empty();

                        $('#customer').append(e.data.StoreName+" : "+e.data.OrderNumber);

                        $.ajax({
                            url: '{!!url("/getBriefcaseBackorderLines")!!}',
                            type: "GET",
                            data: {
                                ID : headerID,
                            },
                            success: function (data) {
                                //console.debug(data);

                                const orderlines = $("#orderlines").dxDataGrid({
                                    dataSource:data, //as json
                                    showBorders: true,
                                    hoverStateEnabled: true,
                                    filterRow: { visible: true },
                                    filterPanel: { visible: true },
                                    headerFilter: { visible: true },
                                    allowColumnResizing: true,
                                    columnAutoWidth: true,
                                    scrolling: {
                                        mode: 'infinite',
                                    },
                                    paging:{
                                        pageSize: 20,
                                    },
                                    selection: {
                                        mode: 'single',
                                    },

                                    columns: [
                                        {
                                            dataField: "strPartNumber",
                                            caption: "Part Number",
                                        },
                                        {
                                            dataField: "PastelDescription",
                                            caption: "Description",
                                        },
                                        {
                                            dataField: "OrigQty",
                                            caption: "Original Quantity",
                                        },
                                        {
                                            dataField: "Quantity",
                                            caption: "Qty",
                                        },
                                        {
                                            dataField: "Price",
                                            caption: "Price",
                                        },
                                        {
                                            dataField: "Vat",
                                            caption: "Vat",
                                        },
                                        {
                                            dataField: "VatPrice",
                                            caption: "Vat Price",
                                        },
                                        {
                                            dataField: "LineTotal",
                                            caption: "Total",
                                        },
                                        {
                                            dataField: "strComment",
                                            caption: "Comments",
                                        },
                                    ],
                                });
                            }
                        });
                    },
                    onRowPrepared: function(e) {
                        if (e.rowType === "data") {
                            if (e.data.UserName !== "FoodSupplyNetwork") {
                            e.rowElement.css("backgroundColor", "rgb(155, 236, 248)");
                            }
                        }
                    },
                });
            }
        });
    };

    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
</script>

<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }
</script>


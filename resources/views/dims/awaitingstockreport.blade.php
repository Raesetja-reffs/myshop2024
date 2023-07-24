
<!DOCTYPE html>

<html>
<head>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ... -->
    <!-- DevExtreme themes -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>


    <style>
        .dx-datagrid{
            font:10px verdana;
        }

    </style>
</head>
<body style="font-family: Sans-serif">
<h3>Awaiting Stock Items</h3>

<div class="dx-field" style="display: none;">
    <div class="dx-field-label">DropDownBox with embedded DataGrid</div>
    <div class="dx-field-value">
        <div id="gridBox"></div>
    </div>
</div>
<button id="refresh">Get/Refresh Data</button>
<div style="display: flex;">
    <div id="gridContainer" style="height: 800px;width: 55% !important;"></div>
<div id="gridorders" style="height: 800px;width: 45% !important;background: #f1aba5;margin-left: 10%;"></div>
</div>
<script>

    $( document ).on( 'focus', ':input', function(){

        $( this ).attr( 'autocomplete', 'off' );
    });

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#refresh").click(function () {
            location.reload();

        });

            $.ajax({
                url: '{!!url("/jsonawaitingstock")!!}',
                type: "GET",
                data: {

                },
                success: function (data) {
                    //localStorage.routeplanner = JSON.stringify({name: "John",routeId: $('#rouTabletLoadingtesonPlanning').val(),deliveryDate: $('#deliveryDatesonPlanning').val()});

                    $("#gridContainer").dxDataGrid({
                        dataSource:data,
                        showBorders: true,

                        filterRow: { visible: true },
                        filterPanel: { visible: true },
                        headerFilter: { visible: true },
                        paging: {
                            enabled: false
                        }
                        ,
                        editing: {
                            mode: "cell",
                            allowUpdating: true,
                            selectTextOnEditStart: true,
                            startEditAction: 'click',
                            allowDeleting: false,
                            confirmDelete: false
                        }
                        ,columnWidth:200,
                        columnAutoWidth:true,        allowColumnResizing: true,       columnResizingMode: "nextColumn",
                        columns: [
                            {
                                width: 10,
                                dataField: "productId",
                                caption: "ID",
                                headerFilter: {
                                    allowSearch: false,
                                }

                            },
                            {
                                width: 150,
                                dataField: "PastelCode",
                                caption: "Item Code",

                            },
                            {
                                width: 350,
                                dataField: "Description",
                                caption: "Item Description",
                                headerFilter: {
                                    allowSearch: false,
                                }

                            },
                            {
                                width: 100,
                                dataField: "UnBookedStock",
                                caption: "UnBookedStock",
                                headerFilter: {
                                    allowSearch: true,
                                }

                            },
                            {
                                width:95,
                                dataField: "Ordered",
                                caption: "Qty Ordered",
                                headerFilter: {
                                    allowSearch: true,
                                },
                                format: {
                                    type: "fixedPoint",
                                    precision: 3
                                }

                            }
                        ] ,
                        onRowClick: function (e) {

                            console.debug("Rather beeeeeeeeeeeeeeeeeeeee onClick");
                            console.debug(e);
                        },
                        onCellClick: function (e) {
                            console.debug("cell beeeeeeeeeeeeeeeeeeeee onCellClick ");
                            console.debug(e.data);
                            getordersmappedtoproduct(e.data.productId)
                            // Handles the "cellClick" event
                        },

                        onInitNewRow: function(e) {
                            console.debug("InitNewRow");
                        },
                        onRowInserting: function(e) {
                            console.debug("RowInserting");
                        },
                        onRowInserted: function(e) {
                            console.debug("RowInserted");
                        },
                        onRowUpdating: function(e) {
                            console.debug("RowUpdating");
                        }
                    });

                }
            });


    });
    function getordersmappedtoproduct(productId){

        $.ajax({
            url: '{!!url("/jsonawaitingstockorders")!!}',
            type: "GET",
            data: {
                productId:productId
            },
            success: function (data) {
                //localStorage.routeplanner = JSON.stringify({name: "John",routeId: $('#rouTabletLoadingtesonPlanning').val(),deliveryDate: $('#deliveryDatesonPlanning').val()});

                $("#gridorders").dxDataGrid({
                    dataSource:data,
                    showBorders: true,

                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    paging: {
                        enabled: false
                    }
                    ,columnWidth:200,
                    columnAutoWidth:true,        allowColumnResizing: true,       columnResizingMode: "nextColumn",
                    columns: [
                        {
                            width: 90,
                            dataField: "orderid",
                            caption: "orderid",
                            headerFilter: {
                                allowSearch: false,
                            }

                        },
                        {
                            width: 100,
                            dataField: "deliverydate",
                            caption: "Delivery Date",

                        },
                        {
                            width: 150,
                            dataField: "CustomerPastelCode",
                            caption: "Customer Code",
                            headerFilter: {
                                allowSearch: false,
                            }

                        },
                        {
                            width: 500,
                            dataField: "StoreName",
                            caption: "StoreName",
                            headerFilter: {
                                allowSearch: true,
                            }

                        },
                        {
                            width:85,
                            dataField: "Qty",
                            caption: "Qty",
                            headerFilter: {
                                allowSearch: true,
                            },
                            format: {
                                type: "fixedPoint",
                                precision: 3
                            }

                        }
                    ] ,
                    onRowClick: function (e) {

                        console.debug("Rather beeeeeeeeeeeeeeeeeeeee onClick");
                        console.debug(e);
                       // getordersmappedtoproduct(e.data.orderid)
                        window.open('{!!url("/viewordersonawaiting")!!}/'+e.data.orderid, "Awaiting Stock", "location=1,status=1,scrollbars=1, width=1200,height=850");
                    },
                    onCellClick: function (e) {
                        console.debug("cell beeeeeeeeeeeeeeeeeeeee double click ");
                        console.debug(e.data);
                        // Handles the "cellClick" event
                    },

                    onInitNewRow: function(e) {
                        console.debug("InitNewRow");
                    },
                    onRowInserting: function(e) {
                        console.debug("RowInserting");
                    },
                    onRowInserted: function(e) {
                        console.debug("RowInserted");
                    },
                    onRowUpdating: function(e) {
                        console.debug("RowUpdating");
                    }
                });

            }
        });
    }
</script>
</div>
</body>
</html>

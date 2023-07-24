
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
<h3>Short Loaded</h3>

<div class="dx-field" style="display: none;">
    <div class="dx-field-label">DropDownBox with embedded DataGrid</div>
    <div class="dx-field-value">
        <div id="gridBox"></div>
    </div>
</div>

From<input type="date" id="from"> - To<input type="date" id="to"> <button class="" id="getdata">Submit</button>
<div id="gridContainer" style="height: 800px;width: 100% !important;"/>

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
        $('#getdata').click(function(){
            $.ajax({
                url: '{!!url("/jsonshortloadedreport")!!}',
                type: "GET",
                data: {
                    datefrom: $('#from').val(),
                    dateto: $('#to').val()
                },
                success: function (data) {
                    //localStorage.routeplanner = JSON.stringify({name: "John",routeId: $('#rouTabletLoadingtesonPlanning').val(),deliveryDate: $('#deliveryDatesonPlanning').val()});

                    $("#gridContainer").dxDataGrid({
                        dataSource:data,
                        showBorders: true,
                        selection: {
                            mode: 'multiple',
                        },
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
                                width: 90,
                                dataField: "CustomerPastelCode",
                                caption: "Account Code",
                                headerFilter: {
                                    allowSearch: true,
                                }

                            },
                            {
                                width: 300,
                                dataField: "StoreName",
                                caption: "StoreName",
                                visible:false

                            },
                            {
                                width: 1,
                                dataField: "PastelCode",
                                caption: "Item Code",
                                visible:false

                            },
                            {
                                width: 300,
                                dataField: "PastelDescription",
                                caption: "Description",
                                headerFilter: {
                                    allowSearch: true,
                                }

                            },
                            {
                                width:85,
                                dataField: "QtyOrdered",
                                caption: "Qty Ordered",
                                headerFilter: {
                                    allowSearch: true,
                                },
                                format: {
                                    type: "fixedPoint",
                                    precision: 3
                                }

                            },
                            {
                                width:85,
                                dataField: "Qty",
                                caption: "Qty Dispatched",
                                headerFilter: {
                                    allowSearch: true,
                                },
                                format: {
                                    type: "fixedPoint",
                                    precision: 3
                                }

                            },
                            {
                                width:100,
                                dataField: "UserName",
                                caption: "UserName",
                                headerFilter: {
                                    allowSearch: true,
                                }

                            },

                            {
                                width: 200,
                                dataField: "Route",
                                caption: "Route",
                                headerFilter: {
                                    allowSearch: true,
                                }

                            }, {
                                dataField: "OrderId",
                                caption: "Order Id", width: 80,

                            }
                            ,{
                                width: 100,
                                dataField: "InvoiceNo",
                                caption: "Invoice No"

                            }
                            ,
                            {
                                width:300,
                                dataField: "strLoadedBy",
                                caption: "Loaded By",


                            }

                        ] ,
                        onRowClick: function (e) {



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
    });

</script>
</div>
</body>
</html>

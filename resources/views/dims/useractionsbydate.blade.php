
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

    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>


    <style>
        .dx-datagrid{
            font:10px verdana;
        }

    </style>
</head>
<body style="font-family: Sans-serif">
<h3>User Actions</h3>

<div class="dx-field" style="display: none;">
    <div class="dx-field-label">DropDownBox with embedded DataGrid</div>
    <div class="dx-field-value">
        <div id="gridBox"></div>
    </div>
</div>
From<input type="date" id="from"> - To<input type="date" id="to"> <button class="" id="getdata">Submit</button><br>


    <div id="gridContainer" style="height: 800px;width: 100% !important;"></div>


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
        $("#getdata").click(function () {




        $.ajax({
            url: '{!!url("/jsonuseractionsbydate")!!}',
            type: "GET",
            data: {
                from:$('#from').val(),
                to:$('#to').val()
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
                        enabled: true
                    },
                    export: {
                        enabled: true,

                    },
                    onExporting(e) {

                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('useractions');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }),'useractions.xlsx');
                            });
                        });
                        e.cancel = true;
                    }
                    ,
                    columnAutoWidth:true,        allowColumnResizing: true,       columnResizingMode: "nextColumn",
                    columns: [
                        {
                            width: 10,
                            dataField: "MessageId",
                            caption: "ID",
                            headerFilter: {
                                allowSearch: false,
                            }

                        },
                        {
                            width: 150,
                            dataField: "LoggedBy",
                            caption: "Logged By",
                            headerFilter: {
                                allowSearch: false,
                            }

                        },

                        {
                            width: 600,
                            dataField: "Message",
                            caption: "Message",
                            headerFilter: {
                                allowSearch: true,
                            }

                        },
                        {
                            width:95,
                            dataField: "OrderId",
                            caption: "OrderId",
                            headerFilter: {
                                allowSearch: true,
                            }
                        },
                        {
                            width:200,
                            dataField: "StoreName",
                            caption: "Customer Name",
                            headerFilter: {
                                allowSearch: true,
                            }
                        },
                        {
                            width:95,
                            dataField: "PastelDescription",
                            caption: "Description",
                            headerFilter: {
                                allowSearch: true,
                            }
                        }
                        ,
                        {
                            width: 100,
                            dataField: "ReferenceNo",
                            caption: "ReferenceNo",
                            headerFilter: {
                                allowSearch: true,
                            }

                        }
                        ,
                        {
                            width: 100,
                            dataField: "DocNumber",
                            caption: "DocNumber",
                            headerFilter: {
                                allowSearch: true,
                            }

                        },
                        {
                            width: 100,
                            dataField: "dtm",
                            caption: "Timestamp",
                            headerFilter: {
                                allowSearch: true,
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


    });

</script>
</div>
</body>
</html>

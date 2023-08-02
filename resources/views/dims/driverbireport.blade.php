
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


    <style>
        .dx-datagrid{
            font:10px verdana;
        }

    </style>
</head>
<body style="font-family: Sans-serif">
<h3>Detailed Driver Report</h3>

<div class="dx-field" style="display: none;">
    <div class="dx-field-label">DropDownBox with embedded DataGrid</div>
    <div class="dx-field-value">
        <div id="gridBox"></div>
    </div>
</div>

From<input type="date" id="date"> <button class="" id="getdata">Submit</button>
<div id="gridContainer" style="height: 800px;width: 100% !important;"/>


<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
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
                url: '{!!url("/driverbireportget")!!}',
                type: "GET",
                data: {
                    date: $('#date').val(),
                },
                success: function (data) {
                    console.log(data);
                    $("#gridContainer").dxDataGrid({
                        dataSource:data,
                        showBorders: true,
                        filterRow: { visible: true },
                        filterPanel: { visible: true },
                        headerFilter: { visible: true },
                        paging: {
                            enabled: false
                        }
                        ,columnWidth:200,
                        columnAutoWidth:true,
                        export: {
                        enabled: true
                        },
                        onExporting(e) {
                            const workbook = new ExcelJS.Workbook();
                            const worksheet = workbook.addWorksheet('bireport');

                            DevExpress.excelExporter.exportDataGrid({
                                component: e.component,
                                worksheet,
                                autoFilterEnabled: true,
                            }).then(() => {
                                workbook.xlsx.writeBuffer().then((buffer) => {
                                    saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'bireport.xlsx');
                                });
                            });
                            e.cancel = true;
                        },
                        allowColumnResizing: true,
                        columnResizingMode: "nextColumn",
                        columns: [
                            {
                                width: 90,
                                dataField: "Routing",
                                caption: "Routing"

                            },
                            {
                                width: 200,
                                dataField: "Route Name",
                                caption: "Route Name"

                            },
                            {
                                width: 100,
                                dataField: "Route Number",
                                caption: "Route No."

                            },
                            {
                                width: 100,
                                dataField: "Driver Name",
                                caption: "Driver Name"

                            },
                            {
                                width:150,
                                dataField: "Driver Assistant Name",
                                caption: "Driver Assistant Name"

                            },
                            {
                                width:120,
                                dataField: "Truck Name",
                                caption: "Truck Name"

                            },
                            {
                                width:130,
                                dataField: "Trip Sheet Printed Time",
                                caption: "Trip Sheet Printed Time"

                            },

                            {
                                width: 100,
                                dataField: "Phase",
                                caption: "Phase"

                            },
                            {
                                width: 100,
                                dataField: "Number Of Stops",
                                caption: "Number Of Stops"
                            }
                            ,{
                                width: 130,
                                dataField: "Time Spent Driving",
                                caption: "Time Spent Driving"

                            }
                            ,
                            {
                                width:180,
                                dataField: "First Stop Time",
                                caption: "First Stop Time",


                            },
                            {
                                width:180,
                                dataField: "Last Stop Time",
                                caption: "Last Stop Time",


                            },
                            {
                                width:180,
                                dataField: "Start Trip Time",
                                caption: "Start Trip Time",


                            },
                            {
                                width:180,
                                dataField: "End Trip Time",
                                caption: "End Trip Time",


                            },
                            {
                                width:180,
                                dataField: "Final Order Added",
                                caption: "Final Order Added",


                            },
                            {
                                width:100,
                                dataField: "Rand Value INCL",
                                caption: "Rand Value INCL",


                            },
                            {
                                width:100,
                                dataField: "Rand Value EXCL",
                                caption: "Rand Value EXCL",


                            },
                            {
                                width:100,
                                dataField: "Weight",
                                caption: "Weight",


                            },
                            {
                                width:180,
                                dataField: "Final Staging Time",
                                caption: "Final Staging Time",


                            },
                            {
                                width:180,
                                dataField: "Final Picked Time",
                                caption: "Final Picked Time",


                            },
                            {
                                width:180,
                                dataField: "Loading Starts",
                                caption: "Loading Starts",


                            },
                            {
                                width:180,
                                dataField: "Loading Ends",
                                caption: "Loading Ends",


                            },
                            {
                                width:150,
                                dataField: "Route Length",
                                caption: "Route Length",


                            },
                            {
                                width:300,
                                dataField: "Loaders",
                                caption: "Loaders",


                            }

                        ]
                    });

                }
            });

        });
    });

</script>
</div>
</body>
</html>

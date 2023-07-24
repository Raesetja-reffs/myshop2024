<!DOCTYPE html>
<html>
<head>
    <!-- ... -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>     <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
    <!-- DevExtreme themes -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/3.3.1/exceljs.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>    <script src="https://cdn3.devexpress.com/jslib/20.1.8/js/dx.all.js"></script>



    <style>
        .dx-datagrid{
            font:10px verdana;
        }

    </style>
</head>
<body class="dx-viewport" style="font-family: Sans-serif">

    <div id="gridContainer" style="width: 50%">

    </div>

<div class="row">
    <script type="text/javascript" charset="utf-8">
        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'off' );
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        var clickTimer, lastRowClickedId;


            $('#refreshdateinfo').click(function(){
                pointswebstore($('#userid').val(),$('#dates').val());;
            });
            $(function(){
                $("#gridContainer").dxDataGrid({
                    dataSource:'{!!url("/getCartsGrid")!!}',

                    showBorders: true,
                    allowDeleting: false,
                    filterRow: { visible: true },
                    allowColumnResizing: true,

                    columns: [
                        {
                            dataField: "intCustomerId",
                            caption: "User ID",
                            width: 120

                        },
                        {
                            dataField: "strCustomerCode",
                            caption: "Customer Code",
                            width: 100
                        },
                        {
                            dataField: "strCardUid",
                            caption: "Card Number",
                            width: 100
                        }
                    ] ,
                    export: {
                        enabled: true,
                        allowExportSelectedData: true
                    },
                    onExporting: function(e) {
                        var workbook = new ExcelJS.Workbook();
                        var worksheet = workbook.addWorksheet('cardlist');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet: worksheet,
                            autoFilterEnabled: true
                        }).then(function() {
                            // https://github.com/exceljs/exceljs#writing-xlsx
                            workbook.xlsx.writeBuffer().then(function(buffer) {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'cardlist.xlsx');
                            });
                        });
                        e.cancel = true;
                    },
                    onRowClick: function (e) {

                        //OBTAIN YOUR GRID DATA HERE
                        //var data = e.selectedRowsData;

                        //alert(e.key.strCardUid);
                        var dialog = $('<p><strong style="color:black">ARE YOU SURE YOU WANT TO DELETE CARD NUMBER'+e.key.strCardUid+'</strong></p>').dialog({
                            height: 200, width: 700, modal: true, containment: false,
                            buttons: {
                                "Okay": function () {
                                    $.ajax({

                                        url: '{!!url("/deletecard")!!}',
                                        type: "POST",
                                        data: {

                                            cardnumber: e.key.strCardUid,
                                            userid: e.key.intCustomerId
                                        },
                                        success: function (data) {
                                            alert("DELETED");
                                            dialog.dialog('close');
                                            location.reload();
                                        }
                                    });

                                },
                                "CANCEL": function () {

                                    dialog.dialog('close');
                                }
                            }
                        });


                    },
                    onEditingStart: function(e) {
                        console.debug("EditingStart");
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
                    },
                    onRowUpdated: function(e) {
                        console.debug("RowUpdated");
                    },
                    onRowRemoving: function(e) {
                        console.debug("RowRemoving");
                    },
                    onRowRemoved: function(e) {
                        console.debug("RowRemoved");
                    }
                });
            });





    </script>
</div>
</body>
</html>

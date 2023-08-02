
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
<h3>Item And Locations</h3>
<a href='{!!url("/getbininfo")!!}' onclick="window.open(this.href, 'binlocationinfo',
'left=20,top=20,width=1000,height=1000,toolbar=1,resizable=0'); return false;" style="background: red;padding:10px;color: black;font-weight: 900" >View Bin Location Info</a>
<div class="dx-field" style="display: none;">
    <div class="dx-field-label">DropDownBox with embedded DataGrid</div>
    <div class="dx-field-value">
        <div id="gridBox"></div>
    </div>
</div>

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
        $.ajax({
            url: '{!!url("/jsonWarehouseGrid")!!}',
            type: "GET",
            data: {
                routeId: 1
            },
            success: function (data) {
            $("#gridContainer").dxDataGrid({
            dataSource:data,
            showBorders: true,
            filterRow: { visible: true },
            filterPanel: { visible: true },
            headerFilter: { visible: true },
            paging: {
                enabled: true
            }
            ,
            editing: {
                mode: "cell",
                allowUpdating: false,
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
                    dataField: "strLoactionName",
                    caption: "Location",
                    headerFilter: {
                        allowSearch: true,
                    }


                },
                {
                    width: 90,
                    dataField: "PastelCode",
                    caption: "Item Code",
                    headerFilter: {
                        allowSearch: true,
                    }

                },
                {
                    width:300,
                    dataField: "PastelDescription",
                    caption: "Item Description",
                    headerFilter: {
                        allowSearch: true,
                    }
                },
                {
                    width:100,
                    dataField: "BarCode",
                    caption: "BarCode",
                    headerFilter: {
                        allowSearch: true,
                    }

                },

                {
                    width: 80,
                    dataField: "mnyQty",
                    caption: "Qty",dataType:"number",
                    headerFilter: {
                        allowSearch: true,
                    }

                }
                ,{
                    width: 80,
                    dataField: "strTransactionType",
                    caption: "Type",
                    headerFilter: {
                        allowSearch: true,
                    }

                }
                ,
                {
                    width:100,
                    dataField: "dtemoved",
                    caption: "Date",
                    headerFilter: {
                        allowSearch: true,
                    }

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

</script>
</div>
</body>
</html>

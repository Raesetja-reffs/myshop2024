
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
<h3>Stock Sheet</h3>

<div class="dx-field" style="display: none;">
    <div class="dx-field-label">DropDownBox with embedded DataGrid</div>
    <div class="dx-field-value">
        <div id="gridBox"></div>
    </div>
</div>
Stock Take Name<input type="text" id="stocksheetname" ><br>
<button id="submit" >Save</button>

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
$('#submit').click(function(){
    var allGridItems =  $("#gridContainer").dxDataGrid("getDataSource").items();
 //   var dataGrid = $("#dataGridContainer").dxDataGrid("instance");
   // calculateStatistics();
   // var selectedRowsData = allGridItems.getSelectedRowsData();
    var checkedLines = new Array();
 //   let selectedKeys = allGridItems.option("selectedItemKeys");
   console.log( allGridItems);
//    allGridItems.forEach((element, index, array) => {
    allGridItems.forEach((element, index, array) => {

        console.log( element.PastelCode);
        checkedLines.push({
            'PastelCode': element.PastelCode,
            'PickingTeam': element.PickingTeam
        });
    });

    //});

    $.ajax({
        url: '{!!url("/stocksheetforstocktakexml")!!}',
        type: "POST",
        data: {
            lines: checkedLines,stocktake: $('#stocksheetname').val()
        },
        success: function (data) {
          //  location.reload();
            location.reload();
        }
    });
});



            $.ajax({
                url: '{!!url("/stocksheetforstocktakejson")!!}',
                type: "GET",
                data: {

                },
                success: function (data) {
                    //localStorage.routeplanner = JSON.stringify({name: "John",routeId: $('#rouTabletLoadingtesonPlanning').val(),deliveryDate: $('#deliveryDatesonPlanning').val()});
// PastelCode,PastelDescription,PickingTeam,UnitSize,'Master' as LocationName,1 LocationId
                    $("#gridContainer").dxDataGrid({
                        dataSource:data,
                        showBorders: true,
                            selection: {
                                mode: 'multiple'
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
                           , onInitialized(e) {
                                dataGrid = e.component;
                                //calculateStatistics();
                            }
                        ,columnWidth:200,
                        columnAutoWidth:true,        allowColumnResizing: true,       columnResizingMode: "nextColumn",
                        columns: [
                            {
                                width: 90,
                                dataField: "PastelCode",
                                caption: "Item Code",
                                headerFilter: {
                                    allowSearch: true,
                                }

                            },
                            {
                                width: 300,
                                dataField: "PastelDescription",
                                caption: "Item Description",
                                visible:true,
                                headerFilter: {
                                    allowSearch: true,
                                }

                            },
                            {
                                width: 100,
                                dataField: "UnitSize",
                                caption: "Unit Size",
                                headerFilter: {
                                    allowSearch: true,
                                }

                            },
                            {
                                width:100,
                                dataField: "LocationName",
                                caption: "Location",
                                headerFilter: {
                                    allowSearch: true,
                                }
                            },
                            {
                                width:150,
                                dataField: "PickingTeam",
                                caption: "Picking Team",
                                headerFilter: {
                                    allowSearch: true,
                                }

                            },
                            {
                                width:150,
                                dataField: "strCategory",
                                caption: "Main Categories",
                                headerFilter: {
                                    allowSearch: true,
                                }

                            },
                            {
                                width:150,
                                dataField: "filtersecond",
                                caption: "Second Filter",
                                headerFilter: {
                                    allowSearch: true,
                                }

                            },
                            {
                                width:150,
                                dataField: "filterthird",
                                caption: "Third Filter",
                                headerFilter: {
                                    allowSearch: true,
                                }

                            },
                            {
                                width:90,
                                dataField: "LocationId",
                                caption: "LocationId",
                                visible:false

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
    function calculateStatistics() {
        dataGrid.getSelectedRowsData().then((rowData) => {
            let commonDuration = 0;

            for (let i = 0; i < rowData.length; i += 1) {
                //commonDuration += rowData[i].Task_Due_Date - rowData[i].Task_Start_Date;
                console.debug(rowData[i]);
            }

        });
    }
</script>
</div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

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
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.dark.css" rel="stylesheet"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.softblue.css" rel="stylesheet"> --}}

</head>

<div class="col-lg-12"  style="background: white;">

    <div class="col-lg-12" >
        <div class="col-lg-12" >
            <h3 style="flex-grow: 1; padding-left: 15px;">Products</h3>
            <!-- Button trigger modal -->
            <div id="gridContainer" style=""></div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newarea" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newuserLabel">Create New Area</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="areaname"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Area Name</label>
                    <input  type="text" class="form-control input-sm col-xs-1" id="areaname">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="savesareaname" class="btn btn-success" >Save</button>
            </div>
        </div>
    </div>
</div>


<style>

    .dx-datagrid-table{
        font-size:15px;
    }

    .dx-datagrid .dx-link {
        color: #df2413;
    }

    .dx-datagrid {
        height: calc(100vh - 63px);
    }
</style>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.dialogextend.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).ready(function() {


       /* $('#savesareaname').click(function(){

            $.ajax({

                url: '{!!url("/savesareaname")!!}',
                type: "POST",
                data: {
                    areaname: $('#areaname').val()

                },
                success: function (data) {
                    location.reload();
                }

            });

        });*/



        $.ajax({

            url: '{!!url("/getProductgriddata")!!}',
            type: "GET",
            data: {

            },
            success: function (data) {
                console.debug(data);
                var pickingTeams = ({!! json_encode($pickingTeams) !!});
                console.debug(pickingTeams);

                $("#gridContainer").dxDataGrid({

                    dataSource:data, //as json
                    hoverStateEnabled: true,
                    showBorders: true,
                    filterRow: { visible: true },
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    keyExpr: 'ProductId',
                    // height: ((window.screen.height)-50),
                    scrolling: {
                        mode: 'infinite',
                    },
                    // paging:{
                    //     pageSize: 10,
                    // },
                    export: {
                        enabled: true
                    },
                    editing: {
                        mode: 'batch',
                        allowUpdating: true
                    },
                    selection: {
                        mode: 'single',
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('products');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'products.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "ProductId",
                            caption: "ProductID",
                            allowEditing: false,
                            visible: false
                        },{
                            dataField: "PastelCode",
                            caption: "Item Code",
                            allowEditing: false,
                        },{
                            dataField: "PastelDescription",
                            caption: "Item Description",
                            allowEditing: false,
                        },
                        // {
                        //     dataField: "PickingTeam",
                        //     caption: "PickingTeam",
                        //     defaultCellValue:"PickingTeam",
                        //     lookup: {
                        //         dataSource: pickingTeams,
                        //         valueExpr: "PickingTeamId",
                        //         displayExpr: "PickingTeam",
                        //     },
                        // },
                        {
                            dataField: "PickingTeamId",
                            caption: "Picking Team",
                            value: "PickingTeam",
                            lookup: {
                                dataSource: pickingTeams,
                                valueExpr: "PickingTeamId",
                                displayExpr: "PickingTeam",
                            }
                        }
                        ,{
                            dataField: "strBulkUnit",
                            caption: "Bulk Unit",
                            allowEditing: false,
                        },{
                            dataField: "UnitWeight",
                            caption: "Unit Weight",
                            allowEditing: false,
                        },{
                            dataField: "MultiLineItem",
                            caption: "Multi Line Item",
                            allowEditing: false,
                        },{
                            dataField: "SoldByWeight",
                            caption: "Sold by Weight",
                            allowEditing: false,
                        },{
                            dataField: "Mass",
                            caption: "Mass",
                            allowEditing: false,
                        },{
                            dataField: "ProductMargin",
                            caption: "Product Margin",
                            allowEditing: false,
                        },{
                            dataField: "Status",
                            caption: "Status",
                            allowEditing: false,
                        },{
                            dataField: "Binnumber",
                            caption: "Bin Number",
                            allowEditing: false,
                        },

                    ],

                    onRowUpdating: function(e){
                        // console.debug(e);
                        var ProductID = e.oldData.ProductId;
                        var PickingTeamId = e.newData.PickingTeamId;

                        $.ajax({
                            url: '{!!url("/postProductInfo")!!}',
                            type: "POST",
                            data: {
                                ProductID:ProductID,
                                PickingTeamId:PickingTeamId,
                            },
                            success: function (data) {
                                location.reload();
                            }
                        });
                    }

                });
            }
        });






    });


    function showDialog(tag,width,height)
    {
        $( tag ).dialog({height: height, modal: false,
            width: width,containment: false}).dialogExtend({
            "closable" : true, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class

                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });
    }
</script>

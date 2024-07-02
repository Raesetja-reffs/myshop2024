<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <!-- CSS only -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}"/>

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
    <link href="{{ asset('css/dx.material.orange.light.css') }}" rel="stylesheet">
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
    <div class="col-lg-12 d-flex justify-content-center" >
        <x-general-loader />
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
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="{{ asset('js/feather.min.js') }}"></script>
<script src="{{ asset('js/Chart.min.js') }}"></script>

<!-- JavaScript Bundle with Popper -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<!-- DevExtreme library -->
<script src="{{ asset('js/dx.all.js') }}"></script>


<script src="{{ asset('js/exceljs.min.js') }}"></script>
<script src="{{ asset('js/FileSaver.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
<script src="{{ asset('js/commonScript.js?v=' . config('app.js_version')) }}"></script>
<script src="{{ asset('js/app.js?v=' . config('app.js_version')) }}"></script>
<script>
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
            data: {},
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
                     paging:{
                         pageSize: 500,
                     },
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
                            allowEditing: true,
                        },{
                            dataField: "UnitWeight",
                            caption: "Unit Weight",
                            allowEditing: true,
                        },{
                            dataField: "MultiLineItem",
                            caption: "Multi Line Item",
                            allowEditing: false,
                        },{
                            dataField: "SoldByWeight",
                            caption: "Sold by Weight",
                            allowEditing: true,
                        },{
                            dataField: "Mass",
                            caption: "Mass",
                            allowEditing: true,
                        },{
                            dataField: "ProductMargin",
                            caption: "Product Margin",
                            allowEditing: true,
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
                       // var PickingTeamId = e.newData.PickingTeamId;
                        if (typeof e.newData.PickingTeamId !== 'undefined') {
                            var PickingTeamId = e.newData.PickingTeamId;
                            console.debug("______ new " + PickingTeamId);
                        } else {
                            var PickingTeamId = e.oldData.PickingTeamId;
                            console.debug("______ old " + PickingTeamId);
                        }
                        if (typeof e.newData.strBulkUnit !== 'undefined') {
                            var strBulkUnit = e.newData.strBulkUnit;
                            console.debug("______ new " + strBulkUnit);
                        } else {
                            var strBulkUnit = e.oldData.strBulkUnit;
                            console.debug("______ old " + strBulkUnit);
                        }
                        if (typeof e.newData.UnitWeight !== 'undefined') {
                            var UnitWeight = e.newData.UnitWeight;
                            console.debug("______ new " + UnitWeight);
                        } else {
                            var UnitWeight = e.oldData.UnitWeight;
                            console.debug("______ old " + UnitWeight);
                        }

                        if (typeof e.newData.SoldByWeight !== 'undefined') {
                            var SoldByWeight = e.newData.SoldByWeight;
                            console.debug("______ new " + SoldByWeight);
                        } else {
                            var SoldByWeight = e.oldData.SoldByWeight;
                            console.debug("______ old " + SoldByWeight);
                        }
                        if (typeof e.newData.ProductMargin !== 'undefined') {
                            var ProductMargin = e.newData.ProductMargin;
                            console.debug("______ new " + ProductMargin);
                        } else {
                            var ProductMargin = e.oldData.ProductMargin;
                            console.debug("______ old " + ProductMargin);
                        }
                        //var ProductMargin = e.newData.ProductMargin;
                        $.ajax({
                            url: '{!!url("/postProductInfo")!!}',
                            type: "POST",
                            data: {
                                ProductID:ProductID,
                                PickingTeamId:PickingTeamId,
                                strBulkUnit:strBulkUnit,
                                UnitWeight:UnitWeight,
                                SoldByWeight:SoldByWeight,
                                ProductMargin:ProductMargin
                            },
                            success: function (data) {
                              //  location.reload();
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

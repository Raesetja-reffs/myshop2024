<!DOCTYPE html>
<html>
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">


    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <style>
        .vertical-menu {
            width: 200px;
        }

        .vertical-menu a {
            background-color: #eee;
            color: black;
            display: block;
            padding: 12px;
            text-decoration: none;
        }

        .vertical-menu a:hover {
            background-color: #ccc;
        }

        .vertical-menu a.active {
            background-color: #04AA6D;
            color: white;
        }
    </style>


</head>
<div class="col-lg-12"  style="background: white;">
    <div class="col-lg-2"  style="background: white;border-right: 2px solid black;">

        <div class="vertical-menu">
            <a href='{!!url("/createPalletConfig")!!}'>Pallets Configurations</a>
            <a href='{!!url("/mapitemstopallet")!!}'  class="active">Map Pallet To Items</a>
            <a href="#">Departments</a>
            <a href="#">Machines</a>
            <a href="#">Create Jobs</a>
            <a href="#">In Progress Jobs</a>
            <a href="#">Jobs Data</a>
        </div>
    </div>
    <div class="col-lg-10" >
        <div class="col-lg-12" >
            <div class="col-lg-4"  style="background: white;">
                <h4>Create Mapping</h4>
                <fieldset class="well">
                    <form>
                        Map Items To Pallet
                        <div class="form-group">
                            <label class="control-label" for="pallettypedesc"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Pallet Type </label>
                            <select  class="form-control input-sm col-xs-1" id="pallettypedesc" required>
                                <option></option>
                                @foreach($pallets as $val)
                                    <option value="{{$val->intPalletId}}">{{$val->strPalletTypeDescription}}</option>
                                @endforeach

                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="control-label" for="productcode"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Item</label>
                            <input  type="text" class="form-control input-sm col-xs-1" id="productcode" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;"><br>
                            <input  type="text" class="form-control input-sm col-xs-1" id="productdesc" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;" readonly>
                        </div>
                        <br>
                        <button type="button" id="savespallets" class="btn-lg btn-success" >Save</button>
                        <br>


                    </form>
                </fieldset>
            </div>
            <div class="col-lg-8"  style="background: white;">
                <h4>Data Grid</h4>


                <div class="col-lg-12" id="afterFilter">
                    <div id="gridContainer">
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>


<style>

    .dx-datagrid-table{
        font-size:15px;
    }
</style>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    var jArray = JSON.stringify({!! json_encode($products) !!});
    $(document).ready(function() {

        var finalData =$.map(JSON.parse(jArray), function(item) {

            return {
                PastelCode:item.PastelCode,
                PastelDescription:item.PastelDescription

            }

        });
        var inputProductcode = $('#productcode').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            focusFirstResult: true,
            searchContain:true,
            visibleProperties: ["PastelCode","PastelDescription"],
            searchIn: 'PastelDescription',
            data: finalData
        });
        inputProductcode.on('select:flexdatalist', function (event, data) {

            $('#productcode').val(data.PastelCode);
            $('#productdesc').val(data.PastelDescription);
        });
        $('#savespallets').click(function(){

            $.ajax({

                url: '{!!url("/savespalletstoitems")!!}',
                type: "POST",
                data: {
                    pallettypedesc: $('#pallettypedesc').val(),
                    productcode: $('#productcode').val()
                },
                success: function (data) {
                    location.reload();
                }

            });

        });


        $.ajax({

            url: '{!!url("/getMappedItemstoPalletJson")!!}',
            type: "GET",
            data: {
                datefrom: $('#datefrom').val(),
                dateto: $('#dateto').val()
            },
            success: function (data) {

                $("#gridContainer").dxDataGrid({

                    dataSource:data, //as json

                    showBorders: true,
                    filterRow: { visible: true },
                    allowColumnResizing: true,
                    paging:{
                        pageSize: 50,
                    },
                    export: {
                        enabled: true
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('MappedItemsToPallets');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'MappedItemsToPallets.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "intMappingId",
                            caption: "ID",
                            width: 50,

                        }, {
                            dataField: "strItemCode",
                            caption: "Item Code",
                            width: 300,

                        }, {
                            dataField: "PastelDescription",
                            caption: "Item Name",
                            width: 190,

                        },
                        {
                            dataField: "strPalletTypeDescription",
                            caption: "Pallet Type",
                            width: 125,

                        },
                        {
                            dataField: "intPalletConf",
                            caption: "Pallet Conf",
                            width: 125,

                        }
                    ],
                    onRowDblClick:function(e){

                        // console.debug(e.row,cells[e.columnIndex]);
                        console.log(e.data.intMappingId);
                        var palletid =  e.data.intMappingId;
                                var dialog = $('<p>Un Mapped</p>').dialog({
                                    height: 300, width: 700,modal: true,containment: false,
                                    buttons: {
                                        "Update": function () {

                                            // console.log($('#statusselect').val());
                                            $.ajax({

                                                url: '{!!url("/removemapping")!!}',
                                                type: "POST",
                                                data: {
                                                    mappingId:palletid
                                                },
                                                success: function (data) {
                                                        location.reload();
                                                },

                                            });

                                        }
                                    }
                                });

                    },
                    onRowClick:function(e){

                    },
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

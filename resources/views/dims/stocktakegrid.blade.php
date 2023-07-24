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
  <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    




</head>
    <div class="col-lg-12"  style="background: white;">
        <div class="col-lg-4"  style="background: white;">
        <fieldset class="well">
            <form>
                Create New Stock Take

                <div class="form-group">
                                       <label class="control-label" for="stocktakename"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Stock Take Name</label>
                                       <input  type="text" class="form-control input-sm col-xs-1" id="stocktakename" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                </div>
<br>
               <button type="button" id="savestocktake" class="btn-lg btn-success" >Save</button>
               <br>


            </form>
        </fieldset>
        </div>
            <div class="col-lg-8"  style="background: white;border-left: 2px solid black;">
        <div class="form-group">
                <label class="control-label" for="datefrom"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">FROM</label>
                <input type="text" class="form-control input-sm "  id="datefrom" >

                <label class="control-label" for="dateto"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">TO</label>
                <input type="text" class="form-control input-sm "  id="dateto" >
            </div>


            <button type="button" id="getstocktake" class="btn-lg btn-primary" >Get Stock Takes</button>
                <hr style="border: 1px solid black;">

        <div class="col-lg-12" id="afterFilter">
            <div id="gridContainer">
            </div>
            <div id="gridContainerLines">
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
    $(document).ready(function() {

        $('#orderListing').hide();
        $('#pricing').hide();
        $('#pricingOnCustomer').hide();
        $('#callList').hide();
        $('#tabletLoadingApp').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#salesInvoiced').hide();
        $('#posCashUp').hide();
        $('#popUpdateLine').hide();
        $('#updatedspecials').hide();
        $('#extend').hide();
        $('#extedingspecial').hide();

        $("#datefrom").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });
        $("#dateto").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });
        $('#savestocktake').click(function(){

$.ajax({

       url: '{!!url("/saveStockTakeName")!!}',
       type: "POST",
       data: {
           stocktakename: $('#stocktakename').val()
       },
       success: function (data) {
        location.reload();
       }

});

});
$('#getstocktake').click(function(){

$.ajax({

       url: '{!!url("/getStockTakeName")!!}',
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


       columns: [
        {
               dataField: "intAutoId",
               caption: "ID",
               width: 50,

            }, {
               dataField: "strStockTakeName",
               caption: "Stock Take Name",
               width: 300,

            }, {
               dataField: "dtmCreated",
               caption: "Date Created",
               width: 190,

            }, {
                dataField: "activeornot",
               caption: "Is Active",
               width: 125,

            },
                ],
                onRowDblClick:function(e){

                                        // console.debug(e.row,cells[e.columnIndex]);
                                        console.log(e.data.strStockTakeName);
                                        $.ajax({

                                            url: '{!!url("/selectStockTake")!!}',
                                            type: "GET",
                                            data: {
                                                strStockTakeName: e.data.strStockTakeName
                                            },
                                            success: function (data) {
                                                //data[0].sendto
                                                var dialog = $('<p> Selected Stock Take Name<br> Stock Take Name: '+data[0].strStockTakeName+' <br> ID: '+data[0].intAutoId+'<br>Status<select id="statusselect"><option value="'+data[0].blnIsOpened+'"selected disabled>'+data[0].activeornot+'</option><option value="0">Expires</option><option value="1">Active</option></select></p>').dialog({
                                                height: 300, width: 700,modal: true,containment: false,
                                                buttons: {
                                                    "Update": function () {
                                                        dialog.dialog('close');
                                                       // console.log($('#statusselect').val());
                                                        $.ajax({

                                                            url: '{!!url("/updateStockTakeOnSelector")!!}',
                                                            type: "POST",
                                                            data: {
                                                                status: $('#statusselect').val(),
                                                                stocktakeid:data[0].intAutoId
                                                            },
                                                            success: function (data) {

                                                            },

                                                        });

                                                    }
                                                }
                                            });
                                    },
                                });


                        },
            onRowClick:function(e){
                console.log("***************************"+e.data.strStockTakeName);
                    $.ajax({

                        url: '{!!url("/getStockTakeNameLines")!!}',
                        type: "GET",
                        data: {
                            stocktakename: e.data.strStockTakeName
                        },
                        success: function (datalines) {

                            $("#gridContainerLines").dxDataGrid({

dataSource:datalines, //as json

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
      const worksheet = workbook.addWorksheet('Stocktakelines');

      DevExpress.excelExporter.exportDataGrid({
        component: e.component,
        worksheet,
        autoFilterEnabled: true,
      }).then(() => {
        workbook.xlsx.writeBuffer().then((buffer) => {
          saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Stocktakelines.xlsx');
        });
      });
      e.cancel = true;
    },


columns: [
 {
        dataField: "intAutoCountId",
        caption: "ID",
        width: 50,

     }, {
        dataField: "strItemCode",
        caption: "Item Code",
        width: 300,

     }, {
        dataField: "intUserId",
        caption: "User ID",
        width: 100,

     }, {
         dataField: "dteDeviceTime",
        caption: "Device Time",
        width: 200,

     }, {
         dataField: "strTransactionType",
        caption: "Transaction Type",
        width: 200,

     }, {
         dataField: "strSubScriber",
        caption: "Subscriber",
        width: 250,

     }, {
         dataField: "mnyQty",
        caption: "Quantity",
        width: 100,

     }, {
         dataField: "strBinLocation",
        caption: "Bin Location",
        width: 200,

     }, {
         dataField: "dteTimeSaved",
        caption: "Time Saved",
        width: 200,

     }, {
         dataField: "strStockTakeName",
        caption: "Stock Take Name",
        width: 250,

     }, {
         dataField: "mnyCarton",
        caption: "Cartons",
        width: 80,

     }, {
         dataField: "PastelDescription",
        caption: "Item Description",
        width: 250,

     },
         ],
        

});

                        }
                    });
                },
       });

}

});

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

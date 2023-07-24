@extends('layouts.app')

@section('content')
<html>
<head>
<link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
    
</head>
 
    <div class="col-lg-12" id="afterFilter">
<div class = "col-md-3">
    Purchase Orders
    <div id="gridContainer">
    

    </div>
</div>
<div class = "col-md-5">
    Purchase Order Details
<br>
    Supplier Name:<label id = "suppliername" value =""></label>
<br>
    PO Number:<label id = "ponumber" value =""></label>
    <button type="button" id="postgrv" class="btn-xs btn-primary"style ="float:right">Post GRV</button>
    <div id="gridContainerItems">
    

    </div>
</div>
</div>
    
@endsection
<style>
    
       .dx-datagrid-table{
           font-size:10px;
       }
</style>
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
     var jArray = JSON.stringify({!! json_encode($grvs) !!});

var GRVS = $.map(JSON.parse(jArray), function (item) {
    return {
        strOrdPDocID: item.strOrdPDocID, 
        strVendName: item.strVendName, 
        strVendDesc:item.strVendDesc
    }

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

        
      
                 
                    $("#gridContainer").dxDataGrid({
       
       dataSource:GRVS, //as json
                    
       showBorders: true,
       filterRow: { visible: true },
       allowColumnResizing: true,
      paging:{
        pageSize: 50,
            },
           /* export: {
      enabled: true,
      allowExportSelectedData: true,
    },   selection: {
      mode: 'multiple',
    }*/

       columns: [
        {
               dataField: "strOrdPDocID",
               caption: "PO Number",
               width: 125,

            }, {
               dataField: "strVendName",
               caption: "Vendor Code",
               width: 125,

            }, {
               dataField: "strVendDesc",
               caption: "Vendor Name",
               width: 125,

            }, 
            ],
            onRowClick: function (e) {

                $('#suppliername').text(e.key.strVendDesc);
                $('#ponumber').text(e.key.strOrdPDocID);
                var poDoc =  e.key.strOrdPDocID;
                $.ajax({
                        
                        url: '{!!url("/getPoLineGrid")!!}',
                        type: "post",
                        data: {
                            PODOC:poDoc
                        },
                        success: function (data) {
                            $("#gridContainerItems").dxDataGrid({
       
                                dataSource:data, //as json
                                editing: {
                                    mode: "row",
                                    refreshMode: "reshape",
                                    allowUpdating: true
                                    },  
                                showBorders: true,
                                filterRow: { visible: true },
                                allowColumnResizing: true,
                                paging:{
                                    pageSize: 50,
                                        },
           

                                        columns: [
                                                    {
                                                allowEditing:false,
                                                dataField: "strPartNumber",
                                                caption: "Item Code",
                                                width: 125,

                                                }, {
                                                allowEditing:false,
                                                dataField: "strPartDesc",
                                                caption: "Item Description",
                                                width: 125,

                                                }, {
                                                allowEditing:false,
                                                dataField: "decBuyQtyRemain",
                                                caption: "Quantity Ordered",
                                                width: 125,

                                                }, {
                                                allowEditing:false,
                                                dataField: "decBuyQtyScanned",
                                                caption: "Quantity Received",
                                                width: 125,

                                                }, {
                                                dataField: "variance",
                                                caption: "Variance",
                                                width: 75,

                                             }, 
                                    ],
                                                
                                        


                                });
                        }
                    });

                },
       


        });
               
    });


   

  

</script>
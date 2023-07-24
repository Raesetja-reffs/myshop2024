@extends('layouts.app')

@section('content')
<html>
<head>
<link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
    
</head>
    <div class="col-lg-12"  style="background: white;">
        <fieldset class="well">
            <legend class="well-legend">Filters</legend>
            <form>
               
               
             

               <!-- <button type="button" id="getorderlockbutton" class="btn-xs btn-primary" style="margin-left: 450px;">Get Order Lock Details</button>
                <button type="button" id="clearorderlockbutton" class="btn-xs btn-primary" style="margin-left: 450px;">Clear Order Lock for User</button>-->


            </form>
        </fieldset>
    </div>
    <div class="col-lg-12" id="afterFilter">
    <div id="gridContainer">
    

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
     var jArray = JSON.stringify({!! json_encode($stocks) !!});

var Stocks = $.map(JSON.parse(jArray), function (item) {
    return {
        strItemCode: item.strItemCode, 
        PastelDescription: item.PastelDescription, 
        mnyQty:item.mnyQty,
        UserName:item.UserName,
        Instock:item.Instock,
        strStockTakeName:item.strStockTakeName,
        dteTimeSaved:item.dteTimeSaved
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
       
       dataSource:Stocks, //as json
                    
       showBorders: true,
       filterRow: { visible: true },
       allowColumnResizing: true,
      paging:{
        pageSize: 50,
            },
            export: {
      enabled: true,
      allowExportSelectedData: true,
    },   selection: {
      mode: 'multiple',
    },

       columns: [
        {
               dataField: "strItemCode",
               caption: "Item Code",
               width: 125,

            }, {
               dataField: "PastelDescription",
               caption: "Item Description",
               width: 125,

            }, {
               dataField: "mnyQty",
               caption: "Item Counts",
               width: 125,

            }, {
                dataField: "UserName",
               caption: "Counted By",
               width: 125,

            }, {
                dataField: "Instock",
               caption: "In Stock",
               width: 125,

            },{
                dataField: "strStockTakeName",
               caption: "Stock Take Name",
               width: 125,

            },{
                dataField: "dteTimeSaved",
               caption: "Date",
               width: 125,

            },
                ] 
       

                        });
               
    });


   

  

</script>
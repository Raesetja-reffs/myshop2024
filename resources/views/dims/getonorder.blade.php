@extends('layouts.app')

@section('content')

    <div class="col-lg-12" id="prodOnOrder" title="Products on Sales Order" style="background: darkgoldenrod">
        <button class="btn-lg btn-success" id="refresh">Refresh Page</button>
        <form>
            <fieldset class="well" style="    background: #e8e8e8;">
                <legend class="well-legend">Search</legend>
                <div class="col-md-12">
                    <div class="form-group col-md-4">
                        <label class="control-label" for="productCodeOnOrder"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Product Code</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="productCodeOnOrder" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label" for="productDescOnOrder"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Product Desc</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="productDescOnOrder" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group col-md-4">
                        <label class="control-label" for="custCodeOnOrder"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Code</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="custCodeOnOrder" style="height:22px;font-size: 16px;font-family: sans-serif;font-weight: 900;color: black;">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label" for="custDescOnOrder"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Desc</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="custDescOnOrder" style="height:22px;font-size: 16px;font-family: sans-serif;font-weight: 900;color: black">
                    </div>
                    <div class="form-group col-md-4">
                        <button type="button" id="callSpOnOrder" class="btn-xs btn-success">GO</button>
                    </div>
                </div>

            </fieldset>
        </form>
        <table class="table  search-table" id="tblOnsalesOrder" style=" color: black;overflow-y: scroll; width: 100%;font-family: sans-serif; font-weight: 700;font-size: 36px;" tabindex=0>
            <thead>

            <tr style="font-size: 17px;">
                <th class="col-sm-1">Order Id</th>
                <th class="col-sm-1">Order Date</th>
                <th class="col-sm-1">Delivery Date</th>
                <th >Cust Code</th>
                <th class="col-md-3">Store Name</th>
                <th >Awaiting Stock</th>
                <th>Qty</th>
                <th>In Stock</th>
                <th>Prod Code</th>
                <th class="col-md-4">Prod Description</th>
                <th>Comment</th>
                <th>Nett</th>
                <th>Back Order</th>
            </tr>
            </thead>
        </table>
    </div>

@endsection
<style>
    #custDescOnOrder-flexdatalist{
        color:black;
    }
    #custCodeOnOrder-flexdatalist{
        color:black;
    }
</style>
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>

    $( document ).on( 'focus', ':input', function(){

        $( this ).attr( 'autocomplete', 'off' );
    });
    $( document ).on( 'focus', ':input', function(){

        $( this ).attr( 'autocomplete', 'this-is-it' );
    });


    window.onstorage = event => { // same as window.addEventListener('storage', event => {
        if (event.key == 'openorder') {
            console.debug(event.key + ':' + event.newValue + " at " + event.url);
            let products = JSON.parse(event.newValue);
            console.debug(products);
         
            /*if(products.passedorderid !=null ){

                if( $('#orderId').val().length < 3){
                    $('#orderId').val(products.passedorderid );
                    $("#checkOrders").click();
                }else{
                    localStorage.removeItem('openorder');
                    localStorage.setItem('openorder', JSON.stringify({openorderid:  $('#orderId').val() }));
                }



            }*/


        }
        //console.debug(event.key + ':' + event.newValue + " at " + event.url);
    };

    $(document).keydown(function(e) {
        if (e.keyCode == 27) return false;
    });


    var finalDataProduct = '';
    var finalDataProductTest = '';
    $(document).ready(function() {


        $('#refresh').click(function(){
            location.reload();
        });
        $('#orderListing').hide();
        $('#addinCurrentPrices').hide();
        //  $('#addinHistory').hide();
        $('#pricing').hide();
        $('#pricingOnCustomer').hide();
        $('#callList').hide();
        $('#tabletLoadingApp').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#salesInvoiced').hide();
        $('#posCashUp').hide();
        $('#duplicatespecials').hide();
        $('#dialogcopycontracts').hide();
        $('#exportexcel').hide();
        $('#uploaddocument').hide();
        $('#subbuttonmian').hide();
        $('#idlines').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
        var jArray = JSON.stringify({!! json_encode($products) !!});
        finalDataProductTest = $.map(JSON.parse(jArray), function (item) {
            return {
                value: item.PastelDescription,
                PastelCode: item.PastelCode,
                PastelDescription: item.PastelDescription,
                UnitSize: item.UnitSize,
                Tax: item.Tax,
                Cost: item.Cost,
                QtyInStock: item.QtyInStock,
                Margin: item.Margin,
                Alcohol: item.Alcohol,
                UnitWeight: item.UnitWeight,
                SoldByWeight: item.SoldByWeight,
                strBulkUnit: item.strBulkUnit,
                Available: parseFloat(item.Available).toFixed(2),
                ProductId:item.ProductId
            }

        });
        finalDataProduct = $.map(JSON.parse(jArray), function (item) {
            return {
                value: item.PastelCode,
                PastelCode: item.PastelCode,
                PastelDescription: item.PastelDescription,
                UnitSize: item.UnitSize,
                Tax: item.Tax,
                Cost: item.Cost,
                QtyInStock: item.QtyInStock,
                Margin: item.Margin,
                Alcohol: item.Alcohol,
                UnitWeight: item.UnitWeight,
                SoldByWeight: item.SoldByWeight,
                strBulkUnit: item.strBulkUnit,
                Available: parseFloat(item.Available).toFixed(2),
                ProductId:item.ProductId
            }

        });
        var finalData =$.map(JSON.parse(jArrayCustomer), function(item) {

            return {
                BalanceDue:item.BalanceDue,
                CustomerPastelCode:item.CustomerPastelCode,
                StoreName:item.StoreName,
                UserField5:item.UserField5,
                CustomerId:item.CustomerId,
                CreditLimit:item.CreditLimit,
                Email:item.Email,
                Routeid:item.Routeid,
                Discount:item.Discount,
                OtherImportantNotes:item.OtherImportantNotes,
                Routeid:item.Routeid,
                strRoute:item.strRoute,
                mnyCustomerGp:item.mnyCustomerGp,
                Warehouse:item.Warehouse,
                ID:item.ID,
                CustomerOnHold:item.CustomerOnHold,
                termsAndList:item.termsAndList
            }

        });

        var custCodeOnOrder = $('#custCodeOnOrder').flexdatalist({
        minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'CustomerPastelCode',
            data: finalData
    });
    custCodeOnOrder.on('select:flexdatalist', function (event, data) {

        $('#custCodeOnOrder').val(data.CustomerPastelCode);
        $('#custDescOnOrder').val(data.StoreName);

    });
    var custCodePl = $('#custCodePl').flexdatalist({
        minLength: 1,
        valueProperty: '*',
        selectionRequired: true,
        searchContain:true,
        focusFirstResult: true,
        visibleProperties: ["CustomerPastelCode","StoreName"],
        searchIn: 'CustomerPastelCode',
        data: finalData
    });
    custCodePl.on('select:flexdatalist', function (event, data) {

        $('#custCodePl').val(data.CustomerPastelCode);
        $('#custDescPl').val(data.StoreName);
        $('#custId').val(data.CustomerId);

    });
    var custDescOnOrder = $('#custDescOnOrder').flexdatalist({
        minLength: 1,
        valueProperty: '*',
        selectionRequired: true,
        searchContain:true,
        focusFirstResult: true,
        visibleProperties: ["CustomerPastelCode","StoreName"],
        searchIn: 'StoreName',
        data: finalData
    });
    custDescOnOrder.on('select:flexdatalist', function (event, data) {

        $('#custCodeOnOrder').val(data.CustomerPastelCode);
        $('#custDescOnOrder').val(data.StoreName);

    });

    var custDescPl = $('#custDescPl').flexdatalist({
        minLength: 1,
        valueProperty: '*',
        selectionRequired: true,
        searchContain:true,
        focusFirstResult: true,
        visibleProperties: ["CustomerPastelCode","StoreName"],
        searchIn: 'StoreName',
        data: finalData
    });
    custDescPl.on('select:flexdatalist', function (event, data) {

        $('#custCodePl').val(data.CustomerPastelCode);
        $('#custDescPl').val(data.StoreName);
        $('#custId').val(data.CustomerId);

    });

    $("#productCodeOnOrder").mcautocomplete({
        source: finalDataProduct,
        columns: columnsC,
        minlength: 1,
        autoFocus: true,
        delay: 0,
        select: function (e, ui) {
            $('#productDescOnOrder').val(ui.item.PastelDescription);
            $('#productCodeOnOrder').val(ui.item.PastelCode);
        }
    });



    var columnsC = [{name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'},
        {name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
        {name: 'Available', minWidth:'20px',valueField: 'Available'}];
    $("#productCodeOnOrder").mcautocomplete({
        source: finalDataProduct,
        columns: columnsC,
        minlength: 1,
        autoFocus: true,
        delay: 0,
        appendTo: "#prodOnOrder",
        select: function (e, ui) {
            $('#productDescOnOrder').val(ui.item.PastelDescription);
            $('#productCodeOnOrder').val(ui.item.PastelCode);
        }
    });

        var columnsD = [{name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
            {name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'}
            ,{name: 'Available', minWidth:'20px',valueField: 'Available'}];
        $("#productDescOnOrder").mcautocomplete({
            source: finalDataProductTest,
            columns: columnsD,
            autoFocus: true,
            minlength: 3,
            delay: 0,
            multiple: true,
            multipleSeparator: " ",
            appendTo: "#prodOnOrder",
            select: function (e, ui) {
                $('#productDescOnOrder').val(ui.item.PastelDescription);
                $('#productCodeOnOrder').val(ui.item.PastelCode);
            }
        });


        $('#callSpOnOrder').click(function(){
            productsOnOrder();
        });

        productsOnOrder();

        function productsOnOrder()
        {

            $('#tblOnsalesOrder').DataTable({
                "ajax": {
                    url: '{!!url("/productsOnOrder")!!}', "type": "post", data: function (data) {
                        data.productCode = $('#productCodeOnOrder').val();
                        data.customerCode = $('#custCodeOnOrder').val();
                    }
                },
                "columns": [
                    {"data": "OrderId", "class": "small", "bSortable": true},
                    {"data": "OrderDate", "class": "small"},
                    {"data": "DeliveryDate", "class": "small"},
                    {"data": "CustomerPastelCode", "class": "small"},
                    {"data": "StoreName", "class": "small"},
                    {"data": "AwaitingStock", "class": "small"},
                    {"data": "Qty", "class": "small",
                        render:function(data, type, row, meta) {
                            // check to see if this is JSON
                            try {
                                var jsn = JSON.parse(data);
                                //console.log(" parsing json" + jsn);
                            } catch (e) {

                                return jsn.data;
                            }
                            return parseFloat(jsn).toFixed(2);

                        } ,"bSortable": true },
                    {"data": "InStock", "class": "small"},
                    {"data": "PastelCode", "class": "small"},
                    {"data": "PastelDescription", "class": "small"},
                    {"data": "Comment", "class": "small"},
                    {"data": "NettPrice", "class": "small",
                        render:function(data, type, row, meta) {
                            // check to see if this is JSON
                            try {
                                var jsn = JSON.parse(data);
                                //console.log(" parsing json" + jsn);
                            } catch (e) {

                                return jsn.data;
                            }
                            return parseFloat(jsn).toFixed(2);

                        } ,"bSortable": true },
                    {"data": "Backorder", "class": "small"}

                ],
                "deferRender": true,
                "scrollY": "300px",
                "scrollCollapse": true,
                searching: true,
                bPaginate: false,
                bFilter: false,
                "LengthChange": false,
                "info": false,
                "destroy": true
            });

            $('#tblOnsalesOrder tbody').on('click', 'tr', function (e){
                $("#tblOnsalesOrder tbody tr").removeClass('row_selected');
                $(this).addClass('row_selected');

            });
            $('#tblOnsalesOrder tbody').on('dblclick', 'tr', function (e){
                var rowOnOrder =  $(this).closest("tr");
                var orderIDrowOnOrder = rowOnOrder.find('td:eq(0)').text();
                console.debug("mmmmm orderIDrowOnOrder"+orderIDrowOnOrder);

                localStorage.removeItem('onorders');
                localStorage.setItem('onorders', JSON.stringify({passedorderid: orderIDrowOnOrder }));

            });
        }

    });

</script>

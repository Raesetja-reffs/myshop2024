@extends('layouts.app')

@section('content')
    <div class="container" style="width: 100%;">
        <div class="row">
            <div class="col-lg-12 text-center">

            </div>
            <div class="col-lg-12  visible-md visible-lg">
                <div class="col-lg-4">
                    <ul>
                         <li><button id="salesHeaderStatus" class="btn-primary btn-xs">Sales Order Header Status</button></li>
                    </ul>
                </div>

            </div>

        </div>
    </div>
    <div id="orderListingNotOnRouteSheetDialog" title="Order Listing Not On Route Sheet" class="col-lg-12" style="overflow: unset;">
        <div class="col-lg-12">
            <div class="col-lg-3">
                <form>
                    <fieldset class="well">
                        <legend class="well-legend">Invoiced Status</legend>
                        <div class="form-group">
                            <select id="invocedStatus">
                                <option value="1">Invoiced</option>
                                <option value="0">Not Invoiced</option>
                                <option value="'1,0'">All Orders</option>
                            </select>
                        </div>

                    </fieldset>
                </form>
            </div>
            <div class="col-lg-3">
                <form>
                    <fieldset class="well">
                        <legend class="well-legend">Awaiting Stock</legend>
                        <div class="form-group">
                            <select id="awaitingStockDropDown">
                                <option value="1,0">Both</option>
                                <option value="0">False</option>
                                <option value="1">True</option>
                            </select>

                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="col-lg-3">
                <form>
                    <fieldset class="well">
                        <legend class="well-legend">Extras</legend>

                        <input type="text" name="dateFrom" class="form-control input-sm col-xs-1" id="dateFrom" style="height:26px;font-size: 10px;"placeholder="Date From"><br>
                        <input type="text" name="dateTo" class="form-control input-sm col-xs-1" id="dateTo" style="height:26px;font-size: 10px;" placeholder="Date To"><br>
                        <select  name="routes[]"  multiple="multiple" id="routes" ></select>

                    </fieldset>
                </form>
            </div>
            <div class="col-lg-2">
                <button id="fetchData" class="btn-success btn-lg" style="margin-top: 36%;">FETCH DATA </button>
            </div>
            <div class="col-lg-1" style="display:none;">

                <label class="control-label" for="inputOrderId"  style="margin-top: 36%;margin-bottom: 0px;color:black ; font-size: 11px;">Totals</label>
                <label class="control-label" id="totals"  style="margin-top: 36%;margin-bottom: 0px;font-weight: 700;font-size: 11px;color:blue">Totals</label>


            </div>

        </div>
        <div class="col-lg-12">
            <div >
                <table class="table  search-table" id="fetchdataTable" style=" color: black;overflow-y: scroll; width: 100%;font-family: sans-serif;height: 70%">
                    <thead>

                    <tr >
                        <th class="col-md-4">Store Name</th>
                        <th>Order ID</th>
                        <th>Invoice No</th>
                        <th>Order Date</th>
                        <th>Delivery Date</th>
                        <th>Route</th>
                        <th>Awaiting Stock</th>
                        <th>Order Value</th>
                        <th>CustCode</th>

                    </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>

    <div id="dispatchQuantityForm" title="Dispatch Form">
        <div class="col-lg-12">
            <div class="col-lg-7">
                <fieldset class="well">
                    <legend class="well-legend">Customer Information</legend>
                    <div>
                        <form>
                            <div class="form-group  col-md-2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="inputCustAcc"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Account</label>
                                <input type="text" name="custCode" class="form-control input-sm col-xs-1" id="inputCustAcc" style="height:22px;font-size: 8px;">
                            </div>
                            <div class="form-group col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="inputCustName"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Name</label>
                                <input type="text" name="custDescription" class="form-control input-sm col-xs-1" id="inputCustName" style="height:22px;font-size: 8px;">
                                <input type="hidden" name="customerEmail" class="form-control input-sm col-xs-1" id="customerEmail" >
                            </div>
                        </form>
                    </div>
                    <div>
                        <form>
                            <div class="form-group  col-md-2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="orderIds"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order</label>
                                <input type="text" name="orderIds" class="form-control input-sm col-xs-1" id="orderIds" style="height:22px;font-size: 8px;">
                                <input type="hidden" name="invNo" class="form-control input-sm col-xs-1" id="invNo" style="height:22px;font-size: 8px;">
                            </div>

                        </form>
                    </div>
                    <div>
                        <form>
                            <div class="form-group  col-md-2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="custCreditLimit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Crd Lmt</label>
                                <input type="text" name="custCreditLimit" class="form-control input-sm col-xs-1" id="custCreditLimit" style="height:22px;font-size: 8px;">
                            </div>
                            <div class="form-group col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="DeliveryDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                                <input type="text" name="DeliveryDate" class="form-control input-sm col-xs-1" id="DeliveryDate" style="height:22px;font-size: 8px;">
                                <input type="hidden" name="customerEmail" class="form-control input-sm col-xs-1" id="customerEmail" >
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>
            <div class="col-lg-5">
                <fieldset class="well">
                    <legend class="well-legend">Filters</legend>
                    <form>
                        <div class="form-group col-md-4"  style="display:none;margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                            <label class="control-label" for="pickingTeam"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Search by OrderId</label>
                            <input id="serchByOrderId" class="form-control input-sm col-xs-1" style="height:22px;font-size: 10px;">
                            <select name="pickingTeam" class="form-control input-sm col-xs-1" id="pickingTeam" style="display:none;height:22px;font-size: 8px;"></select>
                        </div>
                        <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                            <label class="control-label" for="inputCustCustomers"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customers</label>
                            <input type="text" name="inputCustCustomers" class="form-control input-sm col-xs-1" id="inputCustCustomers" style="height:22px;font-size: 10px;">
                        </div>
                        <div class="form-group col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                            <label class="control-label" for="custDescriptionListOfOrder"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order IDs</label>
                            <select name="custDescriptionListOfOrder" class="form-control input-sm col-xs-1" id="custDescriptionListOfOrder" style="font-size: 9px;"></select>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
        <div class="col-lg-12" style="overflow-y: scroll;height:60%">
            <table id="table" class="table table-bordered table-condensed" style="font-family: sans-serif;color:black;">
                <thead>
                <tr>
                    <th>Code</th>
                    <th class="col-md-3">Description</th>
                    <th class="col-md-1">Dispatch</th>
                    <th style="display: none;" class="col-md-1">Bulk</th>
                    <th class="col-md-1">Price</th>
                    <th style="display: none;" class="col-md-1">Disc %</th>
                    <th style="display: none;" class="col-md-1">Unit Size</th>
                    <th class="col-md-1">In Stock</th>
                    <th class="col-md-3">Comment</th>
                    <th class="col-md-1 table-header">Actions</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="col-lg-12" style="background: #ececec">
            <div class="col-lg-3" >
                <table class="table" style="font-size: 10px;">
                    <tr>
                        <td>Contact Cell</td>
                        <td><input id="contactCellOnDispatch" class="form-control input-sm col-xs-1"></td>
                    </tr>
                    <tr>
                        <td>Contact Person</td>
                        <td><input id="contactPersonOnDispatch" class="form-control input-sm col-xs-1"></td>
                    </tr>
                    <tr>
                        <td>Tel</td>
                        <td><input id="telOnDispatch" class="form-control input-sm col-xs-1"></td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-3">
                <div class="form-group ">
                    <label class="control-label" for="dispatchMessage"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Message</label>
                    <textarea id="dispatchMessage" class="form-control input-sm col-xs-1"></textarea>

                </div>
                <div class="form-group ">
                    <label class="control-label" for="orderNumberOnDispatch"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Number</label>
                    <input id="orderNumberOnDispatch" class="form-control input-sm col-xs-1" maxlength="18"><span id="characters"></span>/18

                </div>

            </div>
            <div class="col-lg-3">
                <div class="form-group ">
                    <label class="control-label" for="dispatchMessage"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Awaiting Stock</label>
                    <input type="checkbox" id="awaitingStockOnDispatchOrPickingForm" >
                </div>
                <div class="form-group ">
                    <p id="creditLimitWarningMessage" style="color:red;font-family: monospace;    font-size: 12px;"></div>
            </div>
            <div class="col-lg-2">
                <div class="form-group ">
                    <label>Inclusive</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="totalInc" style="height:22px;font-size: 8px;">
                    <hr>
                    <label>Excusive</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="totalEx" style="height:22px;font-size: 8px;">

                </div>
            </div>
            <button id="finishedDispatching" class="btn-success btn-md pull-right">Finished</button>
        </div>
    </div>
    <div id="backOrderDialog" title="Back Order" class="col-lg-12" style="font-size:11px;">
        <div class="col-lg-12">
            <fieldset class="well">
                <legend class="well-legend">Customer Details</legend>
                <div class="col-lg-12">
                    <label class="col-lg-4" id="orderIdlbl"></label>
                    <label class="col-lg-4" id="orderNolbl"></label>
                    <label class="col-lg-4" id="deliveryDatelbl"></label>
                </div>
                <div class="col-lg-6">
                    <label class="col-lg-5" id="custAcclbl"></label>
                    <label class="col-lg-7" id="custDesclbl"></label>
                </div>
            </fieldset>
        </div>
        <div class="col-lg-12" style="height:55%;overflow-y: scroll;">
            <table id="tableDispatch" class="table table-bordered table-condensed" style="font-family: sans-serif;color:black">
                <thead>
                <tr>
                    <th>Code</th>
                    <th class="col-md-3">Description</th>
                    <th class="col-md-1">Qty</th>
                    <th style="display: none;" class="col-md-1">Bulk</th>
                    <th class="col-md-1">Price</th>
                    <th style="display: none;" class="col-md-1">Disc %</th>
                    <th style="display: none;" class="col-md-1">Unit Size</th>
                    <th class="col-md-1">In Stock</th>
                    <th class="col-md-3">Comment</th>
                    <th class="col-md-1 table-header">Actions</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="col-lg-12">
            <div class="col-lg-4 pull-right">
                <button id="createAbackOrder">Create Back Order</button>
                <button id="cancelAbackOrder" class="btn-warning btn-md">Cancel</button>
            </div>
        </div>
    </div>
    <div class="col-lg-12" id="salesHeaderForm" title="Sales Invoice Header Status">
        <table id="tablePalladiumDimsStatus" class="table table-bordered table-condensed" style="font-family: sans-serif;color:black;">
            <thead>
            <tr>
                <th>Document Number</th>
                <th >Doc Date</th>
                <th>Customer Number</th>
                <th class="col-md-3">Ship To</th>
                <th class="col-md-3">Sold To</th>
                <th>Inv Value</th>
                <th class="col-md-3">Error Message</th>
                <th class="col-md-3">Supplier Message</th>

                <th class="col-md-1">Status</th>

            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div  class="col-lg-12" id="changeStatus" title="Change the Status">
        <p id="messageOnStatusPopUp"></p>
        <fieldset class="well">
            <legend class="well-legend">Filters</legend>
            <form>
                <div class="form-group " style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="inputOrderId"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Change Status </label>
                    <select class="form-control input-sm " id="inFlag" name="inFlag" style="height:26px;font-size: 10px;">
                        <option value="">------------</option>
                        <option value="0">Status Type 0</option>
                        <option value="1">Status Type 1</option>
                        <option value="2">Status Type 2</option>
                        <option value="3">Status Type 3</option>
                    </select>
                    <input type="hidden" id="invoiceNumberOnStatus">
                </div>
            </form>
        </fieldset>
    </div>

@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    var jArraydelivRoutes = JSON.stringify({!! json_encode($routesNames) !!});
    var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
    var jArray = JSON.stringify({!! json_encode($products) !!});
    var jArraypickingTeams= JSON.stringify({!! json_encode($pickingTeams) !!});
    var finalDataProduct = '';
    var finalDataProductTest = '';
    var InvoiceTotalPriceInc = 0;
    var InvoiceTotalPriceExcl = 0;

    var otable = '';

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#tabletLoadingApp').hide();
        $('#salesQuotebtn').hide();
        $('#routePlanning').hide();
        $('#backOrderDialog').hide();
        $('#salesHeaderForm').hide();
        $('#changeStatus').hide();
        $('#pricingOnCustomer').hide();
        $('#salesOnOrder').hide();
        $('#salesInvoiced').hide();
        $('#posCashUp').hide();
        var toAppendRoutes = '';
        $.each(JSON.parse(jArraydelivRoutes),function(i,o){
            toAppendRoutes += '<option value="'+o.Routeid+'">'+o.Route+'</option>';
        });
        $('#routes').append(toAppendRoutes);
        var toAppendPickingTeas = '';
        $.each(JSON.parse(jArraypickingTeams),function(i,o){
            toAppendPickingTeas += '<option value="'+o.PickingTeamId+'">'+o.PickingTeam+'</option>';
        });
        $('#pickingTeam').append(toAppendPickingTeas);
        //routes
        $("#dateFrom").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true,
            dateFormat: 'dd-mm-yy' });
        $("#dateTo").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true,
            dateFormat: 'dd-mm-yy' });
        var currentdate = new Date();
        $("#dateFrom").val($.datepicker.formatDate('dd-mm-yy', currentdate));
        $("#dateTo").val($.datepicker.formatDate('dd-mm-yy', currentdate));
        $('#orderNumberOnDispatch').keyup(updateCount);

        finalDataProduct =$.map(JSON.parse(jArray), function(item) {
            return {
                value:item.PastelCode,
                PastelCode:item.PastelCode,
                PastelDescription:item.PastelDescription,
                UnitSize:item.UnitSize,
                Tax:item.Tax,
                Cost:item.Cost,
                QtyInStock:item.QtyInStock,
                Margin:item.Margin,
                Alcohol:item.Alcohol,
                Available:item.Available
            }
        });
        finalDataProductTest =$.map(JSON.parse(jArray), function(item) {
            return {
                value:item.PastelDescription,
                PastelCode:item.PastelCode,
                PastelDescription:item.PastelDescription,
                UnitSize:item.UnitSize,
                Tax:item.Tax,
                Cost:item.Cost,
                QtyInStock:item.QtyInStock,
                Margin:item.Margin,
                Alcohol:item.Alcohol,
                Available:item.Available
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
                Email:item.Email
            }

        });
        var inputCustNames = $('#inputCustCustomers').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            focusFirstResult: true,
            searchContain:true,

            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: ["CustomerPastelCode","StoreName"],
            data: finalData
        });
        inputCustNames.on('select:flexdatalist', function (event, data) {

            $('.fast_remove').remove();
            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#custCreditLimit').val(data.CreditLimit);
            $('#orderIds').val('');
            $('#DeliveryDate').val('');
            //$('#balDue').val(parseFloat(data.BalanceDue).toFixed(2));
            //$('#boozeLisence').val(data.UserField5);
            $('#customerEmail').val(data.Email);
            $.ajax({
                url: '{!!url("/topOrdersOfACustomer")!!}',
                type: "POST",
                data:{custCode:data.CustomerPastelCode},
                success: function(data2){
                    console.debug(data.CustomerPastelCode);
                    $('#custDescriptionListOfOrder').empty();
                    var toAppend = '<option value=""></option>';

                    $.each(data2,function(i,o){
                        toAppend += '<option value="'+o.OrderId+'"><strong>'+o.OrderId+'</strong>   '+o.StoreName+'   '+o.OrderDate+'   '+'   '+o.DeliveryDate+'   <strong>'+o.Backorder+'</strong></option>';
                    });
                    $('#custDescriptionListOfOrder').append(toAppend);
                }
            });

        });
        $("#custDescriptionListOfOrder").on("change", function() {
            var orderidChange = this.value;
            var dialog = $('<p>This Order has not been printed yet,someone could still be working on it, do you want to proceed? </p>').dialog({
                height: 200, width: 700, modal: true, containment: false,
                buttons: {
                    Yes: function () {
                        orderLock('{!!url("/restFullOrderLock")!!}',orderidChange);
                        orderUnLock('{!!url("/clearAllLocksRestFull")!!}');
                        $('#inputCustName').val('');
                        $('#inputCustAcc').val('');
                        $('#awaitingStockOnDispatchOrPickingForm').val('');
                        $('#orderIds').val(orderidChange);
                        $('#DeliveryDate').val('');
                        $('#totalEx').val('');
                        $('#totalInc').val('');
                        makeLines(orderidChange);
                        dialog.dialog('close');
                    },
                    No: function () {
                        dialog.dialog('close');
                    }
                }
            });
        });
        $('#orderListingNotOnRouteSheetDialog').hide();
        $('#dispatchQuantityForm').hide();
        $('#orderListingNotOnTruckSheet').click(function(){
            $('#orderListingNotOnRouteSheetDialog').show();
            showDialog('#orderListingNotOnRouteSheetDialog','80%',640);
        });
        initMultiSelect();
        // oTable();
        $('#fetchData').on('click',function(){
            $('#routes').multiselect('refresh');
            initMultiSelect();
            oTable();
            //$('#routes').multiselect('destroy');

        });

        $('#fetchdataTable').on('dblclick', 'tbody tr', function () {
            var totals = otable.column( 7 ).data().sum();
            console.debug("totals***="+totals);
            var $this = $(this);
            var row = $this.closest("tr");
            var orderID = row.find('td:eq(1)').text();
            var data = $('#fetchdataTable').dataTable().fnGetData(row);
            console.debug(data);
            $('#inputCustName').val(data.StoreName);
            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#invNo').val(data.InvoiceNo);
            $('#awaitingStockOnDispatchOrPickingForm').val(data.AwaitingStock);
            $('#orderIds').val(orderID);
            $('#DeliveryDate').val(row.find('td:eq(4)').text());
            $('#dispatchQuantityForm').show();
            showDialog('#dispatchQuantityForm','90%',610);

            orderLock('{!!url("/restFullOrderLock")!!}',orderID);
            makeLines(orderID);

            $.ajax({
                url: '{!!url("/top30Orders")!!}',
                type: "GET",
                success: function(data){
                    var toAppend = '<option value=""></option>';
                    $.each(data,function(i,o){
                        toAppend += '<option value="'+o.OrderId+'"><strong>'+o.OrderId+'</strong>   '+o.StoreName+'   '+o.OrderDate+'   '+'   '+o.DeliveryDate+'   <strong>'+o.Backorder+'</strong></option>';
                    });
                    $('#custDescriptionListOfOrder').append(toAppend);
                }
            });


        });
        $('#finishedDispatching').click(function(){
            var productsLinesOnPicking = new Array();
            $('#table > tbody  > tr').each(function() {
                var data = $(this);
                var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                console.debug($(this).closest('tr').find('.theProductCode_').val());
                productsLinesOnPicking.push({'productCode': $(this).closest('tr').find('.theProductCode_').val(),'desc':  $(this).closest('tr').find('.prodDescription_').val(),
                    'qty':$(this).closest('tr').find('.prodQty_').val(),'price':$(this).closest('tr').find('.prodPrice_').val(),'comment':$(this).closest('tr').find('.prodComment_').val(),
                    'orderDetailID':orderDetailID,'customerCode':$('#inputCustAcc').val()});
            });
            var dialog = $('<p>Do you want to Print this Invoice?</p>').dialog({
                height: 200, width: 700, modal: true, containment: false,
                buttons: {
                    Yes: function () {

                        $.ajax({
                            url: '{!!url("/printAdjustmentDispatch")!!}',
                            type: "POST",
                            data: {
                                orderId: $('#orderIds').val(),
                                message: $('#dispatchMessage').val(),
                                prodLines: productsLinesOnPicking,
                                orderNo:$('#orderNumberOnDispatch').val(),
                                awaiting:$('#awaitingStockOnDispatchOrPickingForm').val()
                            },
                            success: function (dataDetails) {

                                if (!$.isEmptyObject(dataDetails)){
                                    $('#backOrderDialog').show();
                                    showDialog('#backOrderDialog', '60%', 350);

                                    $('.fast_remove_backOrder').remove();
                                    var props = ''
                                    if (($('#invNo').val()).length > 1) {
                                        props = "disabled";
                                    }
                                    $.each(dataDetails, function (keyDetails, valueDetails) {
                                        var tokenId = Math.floor(Math.pow(10, 9 - 1) + Math.random() * 9 * Math.pow(10, 9 - 1));
                                        var $row = $('<tr id="new_row_ajax' + tokenId + '" class="fast_remove_backOrder">' +
                                            '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_' + tokenId + '" class="theProductCode_ set_autocomplete" value="' + valueDetails.PastelCode + '" ' + props + ' ></td>' +
                                            '<td contenteditable="false" class="col-md-3"><input name="prodDescription_" id ="prodDescription_' + tokenId + '" class="prodDescription_ set_autocomplete" value="' + valueDetails.PastelDescription + '" ' + props + ' ></td>' +
                                            '<td  contenteditable="false" class="col-md-1"><input type="text" name="prodQty_" id ="prodQty_' + tokenId + '"   onkeypress="return isFloatNumber(this,event)"  class="prodQty_ resize-input-inside" value="' + (parseFloat(valueDetails.Qty)).toFixed(2) + '" ' + props + '></td>' +
                                            '<td  style="display: none;" contenteditable="false" class="col-md-1"><input type="text" name="prodBulk_"  id ="prodBulk_' + tokenId + '" class="prodBulk_ resize-input-inside" ' + props + '></td>' +
                                            '<td  contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside" value="' + (parseFloat(valueDetails.Price)).toFixed(2) + '" ' + props + '></td>' +
                                            '<td  style="display: none;"  contenteditable="false"  class="col-md-1"><input type="text" name="prodDisc_" id ="prodDisc_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside" value="' + valueDetails.LineDisc + '" ' + props + ' ></td>' +
                                            '<td style="display: none;" contenteditable="false"  class="col-md-1"><input  type="text" name="prodUnitSize_" id ="prodUnitSize_' + tokenId + '" class="prodUnitSize_ resize-input-inside" value="' + valueDetails.UnitSize + '" ' + props + ' ></td>' +
                                            '<td contenteditable="false"  class="col-md-1"><input type="text" name="instockReadOnly" id ="instockReadOnly_' + tokenId + '" value="' + valueDetails.QtyInStock + '"  class="instockReadOnly_ resize-input-inside inputs" style="font-weight: 800;width: 80%;color:blue">' +
                                            '<td  contenteditable="false" class="col-md-3"><input type="text" name="prodComment_" id ="prodComment_' + tokenId + '" class="prodComment_ resize-input-inside last inputs" value="' + valueDetails.Comment + '" ' + props + ' ></td>' +
                                            '<td><input type="hidden" id="title_' + tokenId + '" class="title" value="" /><input type="hidden" id="theOrdersDetailsId" value="' + valueDetails.OrderDetailId + '" /><input type="hidden" id ="taxCode' + tokenId + '" value="' + valueDetails.Tax + '" class="taxCodes" />' +
                                            '<input type="hidden" id ="cost_' + tokenId + '" value="' + valueDetails.Cost + '" class="costs" /><input type="hidden" id ="inStock_' + tokenId + '" value="' + valueDetails.QtyInStock + '" class="inStock" /><input type="hidden" value ="' + tokenId + '" class="hiddenToken" />' +
                                            '<input type="hidden" id ="alcohol_' + tokenId + '" value="" class="alcohol" /><input type="hidden" id ="margin_' + tokenId + '" value="" class="margin" />' +
                                            '</td></tr>');
                                        $('#tableDispatch tbody').append($row);
                                    });
                                }
                            }
                        });
                        dialog.dialog('close');
                    },
                    No: function () {
                        //Change the dispatch qty
                        adjustQuantingOnPickingForm($('#orderIds').val(),$('#dispatchMessage').val(),'{!!url("/adjustDispatch")!!}',$('#inputCustAcc').val());
                        $('.fast_remove').remove();

                        $('#orderIds').val('');
                        if (($('#orderIds').val()).length < 1){
                            dialog.dialog('close');
                        }
                        clearance();
                    }
                }
            });
            $('#orderIdlbl').append($('#orderIds').val());
            $('#orderNolbl').append($('#orderIds').val());
            $('#deliveryDatelbl').append($('#DeliveryDate').val());
            $('#custAcclbl').append($('#inputCustAcc').val());
            $('#custDesclbl').append($('#inputCustName').val());


        });

        $('#cancelThis').click(function () {
            alert("ice");
            $(this).closest('tr').remove();
        });

        var columnsD = [{name: 'CustomerPastelCode', minWidth:'50px',valueField: 'CustomerPastelCode'},
            {name: 'StoreName', minWidth: '70px',valueField: 'StoreName'}
            ,{name: 'CreditLimit', minWidth:'50px',valueField: 'CreditLimit'}];

        $("#inputCustAcc").mcautocomplete({
            source: finalData,
            columns:columnsD,
            autoFocus: true,
            minlength: 2,
            delay: 0,
            multiple: true,
            multipleSeparator: "",
            select:function (e, ui) {
                /*  $('#inputCustAcc').val(ui.item.CustomerPastelCode);
                 $('#StoreName').val(ui.item.StoreName);
                 $('#CreditLimit').val(ui.item.CreditLimit);
                 $('#Email').val(ui.item.Email);*/
            }
        });
        $('#createAbackOrder').click(function(){
            $.ajax({
                url: '{!!url("/createAbackOrder")!!}' ,
                type: "POST",
                data:{orderId:$('#orderIds').val()},
                success: function(data){
                    var dialog = $('<p>Back Order <strong>'+data[0].ID+'</strong> Create</p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": function () {
                                $('#backOrderDialog').dialog('close');
                                dialog.dialog('close');
                            }
                        }
                    });
                }
            });
            $('.fast_remove').remove();
            $('#orderIds').val('');
            clearance();
        });
        $('#cancelAbackOrder').click(function(){
            $('#backOrderDialog').dialog('close');
            $('.fast_remove').remove();
            $('#orderIds').val('');
            clearance();
        });
        $('#salesHeaderStatus').click(function(){
            $('#salesHeaderForm').show();
            showDialog('#salesHeaderForm','90%',610);
            $.ajax({
                url: '{!!url("/salesHeaderExported")!!}',
                type: "GET",
                success: function (data) {
                    var trHTML = '';
                    var count = 0;
                    $('.fast_remove_pall').remove();
                    $.each(data, function (key, value) {
                        trHTML += '<tr class="fast_remove_pall" style="font-size: 9px;color:black"><td>' +
                            value.DocNumber + '</td><td>' +
                            value.DocDate + '</td><td>' +
                            value.CustomerNumber + '</td><td>' +
                            value.ShipTo + '</td><td>' +
                            value.SoldTo + '</td><td>' +
                            parseFloat(value.Total).toFixed(5) + '</td><td>' +
                            value.ErrorMessage + '</td><td>' +
                            value.SupplierErrorMessage + '</td><td>' +
                            value.intFlag + '</td></tr>';
                        count++;
                    });
                    $('#tablePalladiumDimsStatus').append(trHTML);

                }
            });
        });

        $('#tablePalladiumDimsStatus').on('dblclick', 'tbody tr', function () {

            var rowInvNum =  $(this).closest("tr");
            var invNumber = rowInvNum.find('td:eq(0)').text();
            $('#changeStatus').show();
            $('#messageOnStatusPopUp').empty();
            $('#invoiceNumberOnStatus').val('');
            $('#messageOnStatusPopUp').append('Changing the Status of '+invNumber);
            $('#invoiceNumberOnStatus').val(invNumber);
            showDialog('#changeStatus','20%',240);
        });
        $('#tablePalladiumDimsStatus').on('click', 'tbody tr', function () {
            $("#tablePalladiumDimsStatus tbody tr").removeClass('row_selected');
            $(this).addClass('row_selected');
        });
        $("#inFlag").on("change", function () {

            $.ajax({
                url: '{!!url("/updateSalesHeaderExportedStatus")!!}',
                type: "POST",
                data: {headerStatus: this.value,DocNumber:$('#invoiceNumberOnStatus').val()},
                success: function (data) {
                    var dialog = $('<p><strong style="color:red">'+$('#invoiceNumberOnStatus').val()+' '+data+'</strong></p>').dialog({
                        height: 200, width: 700,modal: true,containment: false,
                        buttons: {
                            "Okay": function () {
                                dialog.dialog('close');
                                $.ajax({
                                    url: '{!!url("/salesHeaderExported")!!}',
                                    type: "GET",
                                    success: function (data) {
                                        var trHTML = '';
                                        var count = 0;
                                        $('.fast_remove_pall').remove();
                                        $.each(data, function (key, value) {
                                            trHTML += '<tr class="fast_remove_pall" style="font-size: 9px;color:black"><td>' +
                                                value.DocNumber + '</td><td>' +
                                                value.DocDate + '</td><td>' +
                                                value.CustomerNumber + '</td><td>' +
                                                value.ShipTo + '</td><td>' +
                                                value.SoldTo + '</td><td>' +
                                                parseFloat(value.Total).toFixed(5) + '</td><td>' +
                                                value.ErrorMessage + '</td><td>' +
                                                value.SupplierErrorMessage + '</td><td>' +
                                                value.intFlag + '</td></tr>';
                                            count++;
                                        });
                                        $('#tablePalladiumDimsStatus').append(trHTML);

                                    }
                                });
                                $('#changeStatus').dialog('close');
                            }
                        }
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
                "close" : "ui-icon-circle-close",
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

    function clearance()
    {
        $('#contactCellOnDispatch').val('');
        $('#contactPersonOnDispatch').val('');
        $('#telOnDispatch').val('');
        $('#inputCustName').val('');
        $('#DeliveryDate').val('');
        $('#inputCustAcc').val('');
        $('#custCreditLimit').val('');
        $('#dispatchMessage').val('');
        $('#awaitingStockOnDispatchOrPickingForm').val('0');
        $( "#awaitingStockOnDispatchOrPickingForm").prop('checked', false);
        $('#totalEx').val('');
        $('#totalInc').val('');
        $('#orderNumberOnDispatch').val('');
    }
    function makeLines(orderID)
    {
        var isAwaitingStock = '';
        var messageINV = '';
        var orderNumber = '';
        $.ajax({
            url: '{!!url("/onCheckOrderHeaderDetails")!!}',
            type: "POST",
            data: {orderId: $.trim(orderID)},
            success: function (dataDetails) {
                InvoiceTotalPriceInc = 0;
                InvoiceTotalPriceExcl = 0;
                $('.fast_remove').remove();
                $.each(dataDetails, function (keyDetails, valueDetails) {
                    var tokenId = Math.floor(Math.pow(10, 9 - 1) + Math.random() * 9 * Math.pow(10, 9 - 1));
                    var props = '';
                    if (($('#invNo').val()).length > 1) {
                        props = "disabled";
                    }
                    var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove">' +
                        '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_' + tokenId + '" class="theProductCode_ set_autocomplete" value="' + valueDetails.PastelCode + '" ' + props + ' ></td>' +
                        '<td contenteditable="false" class="col-md-3"><input name="prodDescription_" id ="prodDescription_' + tokenId + '" class="prodDescription_ set_autocomplete" value="' + valueDetails.PastelDescription + '" ' + props + ' ></td>' +
                        '<td  contenteditable="false" class="col-md-1"><input type="text" name="prodQty_" id ="prodQty_' + tokenId + '"   onkeypress="return isFloatNumber(this,event)"  class="prodQty_ resize-input-inside" value="' + (parseFloat(valueDetails.Qty)).toFixed(2) + '" ' + props + '></td>' +
                        '<td  style="display: none;" contenteditable="false" class="col-md-1"><input type="text" name="prodBulk_"  id ="prodBulk_' + tokenId + '" class="prodBulk_ resize-input-inside" ' + props + '></td>' +
                        '<td  contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside" value="' + (parseFloat(valueDetails.Price)).toFixed(2) + '" ' + props + '></td>' +
                        '<td  style="display: none;"  contenteditable="false"  class="col-md-1"><input type="text" name="prodDisc_" id ="prodDisc_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside" value="' + valueDetails.LineDisc + '" ' + props + ' ></td>' +
                        '<td style="display: none;" contenteditable="false"  class="col-md-1"><input  type="text" name="prodUnitSize_" id ="prodUnitSize_' + tokenId + '" class="prodUnitSize_ resize-input-inside" value="' + valueDetails.UnitSize + '" ' + props + ' ></td>' +
                        '<td contenteditable="false"  class="col-md-1"><input type="text" name="instockReadOnly" id ="instockReadOnly_' + tokenId + '" value="' + (parseFloat(valueDetails.QtyInStock)).toFixed(2) + '"  class="instockReadOnly_ resize-input-inside inputs" style="font-weight: 800;width: 80%;color:blue">' +
                        '<td  contenteditable="false" class="col-md-3"><input type="text" name="prodComment_" id ="prodComment_' + tokenId + '" class="prodComment_ resize-input-inside last inputs" value="' + valueDetails.Comment + '" ' + props + ' ></td>' +
                        '<td><input type="hidden" id="title_' + tokenId + '" class="title" value="" /><input type="hidden" id="theOrdersDetailsId" value="' + valueDetails.OrderDetailId + '" /><input type="hidden" id ="taxCode' + tokenId + '" value="' + valueDetails.Tax + '" class="taxCodes" />' +
                        '<input type="hidden" id ="cost_' + tokenId + '" value="' + valueDetails.Cost + '" class="costs" /><input type="hidden" id ="inStock_' + tokenId + '" value="' + valueDetails.QtyInStock + '" class="inStock" /><input type="hidden" value ="' + tokenId + '" class="hiddenToken" />' +
                        '<input type="hidden" id ="alcohol_' + tokenId + '" value="" class="alcohol" /><input type="hidden" id ="margin_' + tokenId + '" value="" class="margin" />' +
                        '</td></tr>');
                    $('#table tbody').append($row);
                    if (valueDetails.Price == null || valueDetails.IncPrice == null) {
                        InvoiceTotalPriceExcl = (parseFloat(InvoiceTotalPriceExcl) + (0 * parseFloat(valueDetails.Qty))).toFixed(2);
                        InvoiceTotalPriceInc = (parseFloat(InvoiceTotalPriceInc) + (0 * parseFloat(valueDetails.Qty))).toFixed(2);
                    } else {
                        InvoiceTotalPriceExcl = (parseFloat(InvoiceTotalPriceExcl) + (parseFloat(valueDetails.Price) * parseFloat(valueDetails.Qty))).toFixed(2);
                        InvoiceTotalPriceInc = (parseFloat(InvoiceTotalPriceInc) + (parseFloat(valueDetails.IncPrice) * parseFloat(valueDetails.Qty))).toFixed(2);

                    }
                    isAwaitingStock = valueDetails.AwaitingStock;
                    orderNumber = valueDetails.OrderNo;
                    messageINV = valueDetails.MESSAGESINV;

                });
                if(($('#invNo').val()).length < 1 ){
                    generateALine();
                }
                $('#awaitingStockOnDispatchOrPickingForm').val(isAwaitingStock)
                if(($('#awaitingStockOnDispatchOrPickingForm').val(isAwaitingStock)) == '1')
                {
                    $( "#awaitingStockOnDispatchOrPickingForm").prop('checked', true);
                }
                else
                {
                    $( "#awaitingStockOnDispatchOrPickingForm").prop('checked', false);
                }

                $('#totalEx').val(InvoiceTotalPriceExcl);
                $('#totalInc').val(InvoiceTotalPriceInc);
                $('#dispatchMessage').val(messageINV);
                $('#orderNumberOnDispatch').val(orderNumber);

            }

        });
        $.ajax({
            url: '{!!url("/contactDetailsOnOrder")!!}',
            type: "POST",
            data:{OrderID:orderID},
            success: function(data){
                $('#contactCellOnDispatch').val(data[0].CellPhone);
                $('#contactPersonOnDispatch').val(data[0].ContactPerson);
                $('#telOnDispatch').val(data[0].ContactTel);
            }
        });
    }
    function oTable()
    {
        otable = $('#fetchdataTable').DataTable({
            "ajax": {
                url: '{!!url("/fetchData")!!}', "type": "post", data: function (data) {
                    data.dateFrom = $('#dateFrom').val();
                    data.dateTo = $('#dateTo').val();
                    data.routeId = $('#routes').val();
                    data.invoiced =$('#invocedStatus').val();
                    data.awaiting = $('#awaitingStockDropDown').val();

                }
            },
            "columns": [
                {"data": "StoreName", "class": "small", "bSortable": true},
                {"data": "OrderId", "class": "small"},
                {"data": "InvoiceNo", "class": "small"},
                {"data": "OrderDate", "class": "small"},
                {"data": "DeliveryDate", "class": "small"},
                {"data": "Route", "class": "small"},
                {"data": "AwaitingStock", "class": "small"},
                {"data": "OrderValue", "class": "small",
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
                {"data": "CustomerPastelCode", "class": "small"}

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
        //otable.column(8).visible(false);
    }
    function generateALine() {
        calculator();
        var tokenId = Math.floor(Math.pow(10, 9 - 1) + Math.random() * 9 * Math.pow(10, 9 - 1));
        var $row = $('<tr id="new_row_ajax' + tokenId + '" class="fast_remove">' +
            '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_' + tokenId + '" class="theProductCode_ set_autocomplete inputs"></td>' +
            '<td contenteditable="false" class="col-md-3"><input name="prodDescription_" id ="prodDescription_' + tokenId + '" class="prodDescription_ set_autocomplete inputs"></td>' +
            '<td  contenteditable="false" class="col-md-1"><input type="text" name="prodQty_" id ="prodQty_' + tokenId + '"   onkeypress="return isFloatNumber(this,event)" title="in stock" class="prodQty_ resize-input-inside inputs"></td>' +
            '<td style="display: none;"  contenteditable="false" class="col-md-1"><input type="text" name="prodBulk_"  id ="prodBulk_' + tokenId + '" class="prodBulk_ resize-input-inside"></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" style="font-weight: 800;width: 80%;" >' +
            '<div style="display: initial;" data-value="' + tokenId + '"><i class="fa fa-suitcase" id="pricelistLookUpOnForm" aria-hidden="true" data-value="' + tokenId + '"></i></div></td>' +
            '<td style="display: none;" contenteditable="false"  class="col-md-1"><input type="text" name="prodDisc_" id ="prodDisc_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside"></td>' +
            '<td style="display: none;" contenteditable="false"  class="col-md-1"><input  type="text" name="prodUnitSize_" id ="prodUnitSize_' + tokenId + '" class="prodUnitSize_ resize-input-inside" ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="instockReadOnly" id ="instockReadOnly_' + tokenId + '" class="instockReadOnly_ resize-input-inside inputs" style="color:blue"></td>' +
            '<td  contenteditable="false" class="col-md-3"><input type="text" name="prodComment_" id ="prodComment_' + tokenId + '" class="prodComment_ resize-input-inside inputs lst"></td>' +
            '<td><input type="hidden" id="title_' + tokenId + '" class="title" value="authorised" /><input type="hidden" id="theOrdersDetailsId" value="" /><input type="hidden" id ="taxCode' + tokenId + '" value="" class="taxCodes" />' +
            '<input type="hidden" id ="cost_' + tokenId + '" value="" class="costs" /><input type="hidden" id ="inStock_' + tokenId + '" value="" class="inStock" /><input type="hidden" value ="' + tokenId + '" class="hiddenToken" />' +
            '<input type="hidden" id ="alcohol_' + tokenId + '" value="" class="alcohol" /><input type="hidden" id ="margin_' + tokenId + '" value="" class="margin" />' +
            '<button type="button" id="cancelThis" class="btn-danger btn-xs cancel" style="height: 16px;padding: 0px 5px;font-size: 9px;">Cancel</button></td></tr>');
        $('#table tbody').append($row);

        $('input').on('click keyup', function () {
            var ID = $(this).attr('id');
            var jID = '#' + ID;
            console.debug(jID);

            var x = ID.indexOf("_");
            var get_token_number = ID.substring(x + 1, ID.length);

            if ($(this).hasClass("prodDescription_") && $(this).hasClass("set_autocomplete")) {
                var columnsD = [{name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                    {name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'}
                    ,{name: 'Available', minWidth:'20px',valueField: 'Available'}];
                $(""+jID+"").mcautocomplete({
                    source: finalDataProductTest,
                    columns:columnsD,
                    autoFocus: true,
                    minlength: 2,
                    delay: 0,
                    multiple: true,
                    multipleSeparator: " ",
                    select:function (e, ui) {
                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                        //checkIfOrderHasMultipleProducts(ui.item.extra,token_number);
                        $('#prodQty_' + token_number).val("");
                        $('#prodQty_' + token_number).focus();
                        $('#inStock_' + token_number).val(ui.item.QtyInStock);
                        $('#table').find('#prodQty_' + token_number).focus();
                        $('#prodUnitSize_' + token_number).val(ui.item.unitSize);
                        $('#instockReadOnly_' + token_number).val(ui.item.QtyInStock);
                        $('#taxCode' + token_number).val(ui.item.Tax);
                        $('#cost_' + token_number).val(ui.item.Cost);
                        $('#prodQty_' + token_number).attr('title', 'In Stock ' + parseFloat(ui.item.QtyInStock).toFixed(3));
                        GLOBALPRODCODE = ui.item.extra;
                        GLOBALPRODUCTDESCRIPTION = ui.item.value;
                        GLOBALQUANTITY = $('#prodQty_' + token_number).val();
                        GLOBALDISC = $('#prodDisc_' + token_number).val();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '{!!url("/getCutomerPriceOnOrderForm")!!}',
                            type: "POST",
                            data: {
                                customerID: $('#inputCustAcc').val(),
                                deliveryDate: $('#inputDeliveryDate').val(),
                                productCode: $('#prodCode_' + token_number).val()
                            },
                            success: function (data) {
                                console.debug("data price" + data)
                                if ($.isEmptyObject(data)) {
                                    $('#prodPrice_' + token_number).val('');
                                    //GLOBALPRICE = 0;
                                } else {
                                    $('#prodPrice_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                                    //GLOBALPRICE = parseFloat(data[0].Price).toFixed(2);
                                }

                            }
                        });
                    }
                });

            }
            if ($(this).hasClass("theProductCode_") && $(this).hasClass("set_autocomplete")) {
                var columnsC = [{name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'},
                    {name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                    {name: 'Available', minWidth:'20px',valueField: 'Available'}];

                $("" + jID + "").mcautocomplete({
                    source: finalDataProduct,
                    columns:columnsC,
                    minlength: 1,
                    autoFocus: true,
                    delay: 0,
                    select:function (e, ui) {
                        //arrayProds

                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        //putInArray(ui.item.value);
                        //  alert("tagfggggggggggg"+ui.item.Tax);
                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                        //checkIfOrderHasMultipleProducts(ui.item.extra,token_number);
                        $('#prodQty_' + token_number).val("");
                        $('#prodQty_' + token_number).focus();
                        $('#inStock_' + token_number).val(ui.item.QtyInStock);
                        $('#table').find('#prodQty_' + token_number).focus();
                        $('#prodUnitSize_' + token_number).val(ui.item.unitSize);
                        $('#instockReadOnly_' + token_number).val(ui.item.QtyInStock);
                        $('#taxCode' + token_number).val(ui.item.Tax);
                        $('#cost_' + token_number).val(ui.item.Cost);
                        $('#prodQty_' + token_number).attr('title', 'In Stock ' + parseFloat(ui.item.QtyInStock).toFixed(3));

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '{!!url("/getCutomerPriceOnOrderForm")!!}',
                            type: "POST",
                            data: {
                                customerID: $('#inputCustAcc').val(),
                                deliveryDate: $('#DeliveryDate').val(),
                                productCode: $('#prodCode_' + token_number).val()
                            },
                            success: function (data) {

                                if ($.isEmptyObject(data)) {
                                    $('#prodPrice_' + token_number).val('');
                                    //GLOBALPRICE= ;
                                } else {
                                    $('#prodPrice_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                                    //GLOBALPRICE = parseFloat(data[0].Price).toFixed(2);
                                }

                                // $(editableObj).css("background","#FDFDFD");
                            }
                        });
                        //}


                    }

                });
            }

        });

    }
    $(document).on('keyup', '.lst', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13 || code == 9) {
            console.debug("sales");
            var myRow = $('#table').find("tr").last();
            var prod = myRow.find(".theProductCode_").val();
            var prodDesc = myRow.find(".prodDescription_").val();
            var prodQty_ = myRow.find(".prodQty_").val();
            var prodPrice_ = myRow.find(".prodPrice_").val();
            var myRowId = $('#table').find("tr").last().attr("id");

            if (prod.length < 1 || prodDesc.length < 1 || prodQty_.length < 1 || prodPrice_.length < 1)
            {
                // $("#"+myRowId).remove();
                // generateALine2();
                var index = $('.inputs').index(this);
                myRow.find(".theProductCode_").focus();
            }else
            {
                $('.lst').eq(index).focus();
                if(($('#invNo').val()).length < 1 ){
                    generateALine();
                }

            }


        }
    });

    $(document).on('keydown', '.inputs', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        var testLst = $(this).closest('tr');
        if ((code == 13 || code==39) ) {
            var index = $('.inputs').index(this) + 1;
            $('.inputs').eq(index).focus();
        }
        if(code==37)
        {
            var index = $('.inputs').index(this) - 1;
            $('.inputs').eq(index).focus();
        }
        var closesttr =  $(this).closest('tr');
        var prodClosest = closesttr.find(".theProductCode_").val();
        var prodDescClosest = closesttr.find(".prodDescription_").val();
        var prodQtyClosest = closesttr.find(".prodQty_").val();
        var prodPriceClosest = closesttr.find(".prodPrice_").val();
        if ( code == 34 && $.trim(prodClosest.length) > 0 && prodDescClosest.length > 0 && prodQtyClosest.length > 0 && prodPriceClosest.length > 0) {
            console.debug("sales");
            var myRow = $('#table').find("tr").last();
            var prod = myRow.find(".theProductCode_").val();
            var prodDesc = myRow.find(".prodDescription_").val();
            var prodQty_ = myRow.find(".prodQty_").val();
            var prodPrice_ = myRow.find(".prodPrice_").val();
            var myRowId = $('#table').find("tr").last().attr("id");

            if (prod.length < 1 && prodDesc.length < 1 && prodQty_.length < 1 && prodPrice_.length < 1)
            {
                // $("#"+myRowId).remove();
                // generateALine2();
                var index = $('.inputs').index(this);
                myRow.find(".theProductCode_").focus();
            }else
            {
                if(($('#invNo').val()).length < 1 ){
                    generateALine();
                }
                var myRow2 = $('#table').find("tr").last();
                var prod2 = myRow.find(".theProductCode_").val();
                var myRowId2= $('#table').find("tr").last().attr("id");
                myRow2.find(".theProductCode_").focus();
                // $('.lst').eq(index).focus();
            }

        }

    });

    $(document).on('keydown', '.theProductCode_', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            var index = $('.inputs').index(this) + 1;
            $('.inputs').eq(index).focus();
        }
    });
    $(document).on('keydown', '.prodPrice_', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        var $isAuth = $(this).closest("tr").find(".title").attr("id");
        //var $cellsId = $(this).attr("id");
        console.debug("i am heree");
        if ((key > 45 && key < 57) || (key > 95 && key < 106) ||  key == 8) {
            $('#'+$isAuth).val('authorised');
            calculator();
        }
    });
    $(document).on('keydown', '.prodQty_', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);

        if ((key > 45 && key < 57) || (key > 95 && key < 106) ||  key == 8) {
            calculator();
        }
    });
    //
    $(document).on('keydown', '#inputDeliveryDate', function(e) {

        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            //alert("alert ....");
            if($('#submitFilters').is(':visible')) {
                $('#submitFilters').focus();
            }

        }

    });
    $(document).on('click', '.prodQty_', function(e) {
        $(this).select();
    });

    $(document).on('keydown', '.prodQty_', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            var index = $('.inputs').index(this) + 1;
            $('.inputs').eq(index).focus();
            calculator();
        }
    });
    function orderLinesOnOrder()
    {

    }
    function initMultiSelect(){
        $('#routes').multiselect({
            columns: 1,
            placeholder: 'Select Routes',
            includeSelectAllOption: true,
            selectAll: true
        });
    }
</script>
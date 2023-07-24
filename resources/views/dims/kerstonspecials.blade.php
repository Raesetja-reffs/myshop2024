@extends('layouts.app')

@section('content')
    <div class="col-lg-12"  style="background: white;">
        <button class="btn-md btn-success" id="pleaseAddNewCust" >Please Add New Customer Special</button>
        <fieldset class="well">
            <legend class="well-legend">Filters</legend>
            <form>
                <div class="form-group  col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="inputCustAcc"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Account</label>
                    <input type="text" name="custCode" class="form-control input-sm col-xs-1" id="inputCustAcc" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
                    <input type="hidden" name="customerId" class="form-control input-sm col-xs-1" id="customerId" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
                    <input type="hidden" name="specialId" class="form-control input-sm col-xs-1" id="specialId" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
                </div>

                <div class="form-group col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="inputCustName"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Name</label>
                    <input type="text" name="custDescription" class="form-control input-sm col-xs-1" id="inputCustName" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
                   </div>
                   <div class="form-group col-md-3 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="dateFrom"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Contract Date From</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="dateFrom" style="font-weight: 900;    color: black;font-size: 13px;">
                </div>
                
                <div class="form-group col-md-3 "  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                     <label class="control-label" for="dateTo"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Contract Date To</label>
                     <input type="text" class="form-control input-sm col-xs-1" id="dateTo" style="font-weight: 900;    color: black;font-size: 13px;"><br>
                </div>


                <button type="button" id="submitFiltersOnCustSpecial" class="btn-xs btn-primary" style="margin-left: 450px;">Submit</button>
                
                <button type="button" id="postPriceList1" class="btn-xs btn-primary" style="margin-left: 450px;">Pricelist 1 Convert</button>
                <button type="button" id="postPricelist2" class="btn-xs btn-primary" >Pricelist 2 Convert</button>
                <button type="button" id="exportexcel" class="btn-xs btn-primary" >Export Excel</button>
                <div class="form-group col-md-3 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="custheadid"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Contract ID</label>
                    <select  class="form-control input-sm col-xs-1" id="custheadid" style="font-weight: 900;    color: black;font-size: 13px;">
</select>
                </div>


            </form>
        
        </fieldset>
    </div>
    
    <div class="col-lg-12" id="afterFilter">
        <h5 id="specialslink"></h5>
        <h4>Current Specials<button type="button" id="extend" class="btn-xs btn-primary" style="float: right;">Extend</button> <button class="btn-md btn-success" id="bulkediting" style="    float: right;">Bulk Editing</button></h4>

        <div class="col-lg-12" style="overflow: scroll;height:650px;">
            <table id ="tblCreatedCustomerSpecials" class="table table-bordered table-condensed" style="font-family: sans-serif;" tabindex=0>
                <thead>
                <tr style="font-size: 12px;">
                    <td>ID</td>
                    <td>Ref</td>
                    <td>Code</td>
                    <td>Description</td>
                    <td>Date From</td>
                    <td>Date To</td>
                    <td>Price</td>
                    <td>Cost</td>
                    <td>Current GP</td>
                    <td style="display: none;">Cost Created</td>
                    <td>Available</td>
                    <td>Instock</td>
                    <td>Cost Used</td>
                    <td>Less 10%</td>
                    <td>Pricelist 1</td>
                    <td>Pricelist 2</td>
                    <td>Pricelist 3</td>
                    <td>Pricelist 4</td>
                    <td>Pricelist 5</td>
                    <td>Pricelist 6</td>
                    <td>Actions</td>

                </tr>
                </thead>
                <tbody></tbody>

            </table>
        </div>
     
        <input type="button" id="deleteSelected" class="btn-xs btn-danger" value="Delete Selected">
        <input type="button" id="checkall" class="btn-xs btn-danger" value="Check All" style="float:right;">

    </div>
    <div id="popUpdateLine" title="Please Update">
        <div class="col-lg-12" >
            <label class="control-label" for="specialIdUpdate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Special Id</label><br>
        <input type="text"  class="form-control input-sm col-xs-1" id="specialIdUpdate" style="font-weight: 900;    color: black;font-size: 13px;" readonly><br>
            <input type="hidden"  class="form-control input-sm col-xs-1" id="hiddenSpecaialFrom" >
            <input type="hidden"  class="form-control input-sm col-xs-1" id="hiddenSpecaialTo" >
            <label class="control-label" for="itemCode"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Code</label><br>
        <input type="text"  class="form-control input-sm col-xs-1" id="itemCode" style="font-weight: 900;    color: black;font-size: 13px;" readonly><br>
            <label class="control-label" for="itemDescription"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Description</label><br>
        <input type="text"  class="form-control input-sm col-xs-1" id="itemDescription" style="font-weight: 900;    color: black;font-size: 13px;" readonly><br>
            <label class="control-label" for="specialFrom"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date From</label><br>
        <input type="text"  class="form-control input-sm col-xs-1" id="specialFrom" style="font-weight: 900;    color: black;font-size: 13px;" ><br>
            <label class="control-label" for="specialTo"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date To</label><br>
        <input type="text"  class="form-control input-sm col-xs-1" id="specialTo" style="font-weight: 900;    color: black;font-size: 13px;"><br>
            <label class="control-label" for="specialPrice"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Special Price</label><br>
        <input type="text"  class="form-control input-sm col-xs-1" id="specialPrice" style="font-weight: 900;    color: black;font-size: 13px;" ><br>
            <label class="control-label" for="specialCost"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Special Cost</label><br>
        <input type="text"  class="form-control input-sm col-xs-1" id="specialCost" style="font-weight: 900;    color: black;font-size: 13px;" readonly><br>
            <label class="control-label" for="specialGp"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">GP</label><br>
        <input type="text"  class="form-control input-sm col-xs-1" id="specialGp" style="font-weight: 900;    color: black;font-size: 13px;" readonly><br>
        </div>
        <div class="col-lg-12" >
            <button id="updateTheSpecuial" class="btn-md btn-success">Update the Specials</button>
        </div>

    </div>
    <div id="updatedspecials" title="Specials Updated" >
        <button id="btnspecialUpdated" class="btn-md btn-success">OKAY</button>
    </div>
    <div id="extedingspecial" title="Specials Extension">
        <h5>Please make sure you have selected line(s),before updating the dates</h5>
        <label class="control-label" for="specialFrom"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date</label><br>
        <input type="text"  class="form-control input-sm col-xs-1" id="specialdateext" style="font-weight: 900;    color: black;font-size: 13px;" ><br>
        <label class="control-label" for="specialTo"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date To</label><br>
        <input type="text"  class="form-control input-sm col-xs-1" id="specialdateextTo" style="font-weight: 900;    color: black;font-size: 13px;" ><br>
        <button id="doneext" class="btn-md btn-success">Done Extending</button>
    </div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    var jArray = JSON.stringify({!! json_encode($products) !!});
    var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    var finalDataProduct = $.map(JSON.parse(jArray), function (item) {
        return {
            value: item.PastelCode,
            PastelCode: item.PastelCode,
            PastelDescription: item.PastelDescription,
            UnitSize: item.UnitSize,
            Tax: item.Tax,
            Cost: parseFloat(item.Cost).toFixed(2),
            QtyInStock: item.QtyInStock,
            Margin: item.Margin,
            Alcohol: item.Alcohol,
            Available: parseFloat(item.Available).toFixed(2)
        }

    });
    var finalDataProductDescription = $.map(JSON.parse(jArray), function (item) {
        return {
            value: item.PastelDescription,
            PastelCode: item.PastelCode,
            PastelDescription: item.PastelDescription,
            UnitSize: item.UnitSize,
            Tax: item.Tax,
            Cost: parseFloat(item.Cost).toFixed(2),
            QtyInStock: item.QtyInStock,
            Margin: item.Margin,
            Alcohol: item.Alcohol,
            Available: parseFloat(item.Available).toFixed(2)
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
            strRoute:item.strRoute
        }
    });

    $(document).ready(function() {
        $('#dateFrom').prop('disabled', true);
        $('#dateTo').prop('disabled', true);
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#pricingOnCustomer').hide();
        $('#callList').hide();
        $('#tabletLoadingApp').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#salesInvoiced').hide();
        $('#posCashUp').hide();
        $('#afterFilter').hide();
        $('#popUpdateLine').hide();
        $('#updatedspecials').hide();
        $('#extend').hide();
        $('#extedingspecial').hide();
        $('#deleteSelected').hide();
        $('#deleteSelected').hide();


        var inputCustAccount = $('#inputCustAcc').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'CustomerPastelCode',
            data: finalData
        });
        inputCustAccount.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#customerId').val(data.CustomerId);

        });
        var inputCustNumber = $('#inputCustAcc').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'CustomerPastelCode',
            data: finalData
        });
        var inputCustName = $('#inputCustName').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'StoreName',
            data: finalData
        });
        inputCustNumber.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#customerId').val(data.CustomerId);        
            $('#dateFrom').prop('disabled', false);
            $('#dateTo').prop('disabled', false);
            $("#custheadid").empty();
            $.ajax({
                url: '{!!url("/getContractsPerCustomerID")!!}',
                type: "POST",
                data: {
                    customerid: $('#customerId').val()
                },
                success: function (data) {
                    var trHTML = "";
                    $.each(data, function (key, value) {

                        trHTML += 
                        '<option value="'+value.SpecialHeaderId+'">'+value.SpecialHeaderId+'</option>';

                    });
                    $("#custheadid").append(trHTML);
                }
            });
        });
        inputCustName.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#customerId').val(data.CustomerId);
            $('#dateFrom').prop('disabled', false);
            $('#dateTo').prop('disabled', false);
            $("#custheadid").empty();
            $.ajax({
                url: '{!!url("/getContractsPerCustomerID")!!}',
                type: "POST",
                data: {
                    customerid: $('#customerId').val()
                },
                success: function (data) {
                    var trHTML = "";
                    $.each(data, function (key, value) {

                        trHTML += 
                        '<option value="'+value.SpecialHeaderId+'">'+value.SpecialHeaderId+'</option>';

                    });
                    $("#custheadid").append(trHTML);
                }
            });
        });

        $('#addLine').click(function(){

            generateALine2();
        });
        generateALine2();

        $(".dateTo").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $("#specialdateextTo,#specialdateext").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });
        $("#dateFrom,#dateTo,#specialFrom,#specialTo,#specialdateext").datepicker({
            
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy',
            onSelect: function(dateString,txtDate) {
                    console.log("bring it");
                    refreshcontractsviadate();
                }
        });
        $('#tblCreateNewSpecial').on('click', 'button', function (e) {
            var $this = $(this);
            $this.closest('tr').remove();
        });

        $('#exportexcel').click(function()
        {
            window.location = '{!!url("/export")!!}/'+$('#custheadid').val(); 
        });
        $('#postPricelist2').click(function()
        {
            var dialog = $('<p>This will convert the current contract ID to the selected Pricelist price. Press cancel if this was a mis-click!</p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": function () {
                                $.ajax({
                                    url: '{!!url("/convertContractPriceBulk")!!}',
                                    type: "POST",
                                    data: {
                                        contractId: $('#custheadid').val(),
                                        pricelist: 'PRICE LIST 2'
                                    },
                                    success: function (data) {
                                        dialog.dialog('close');
                                        location.reload(true);
                                    }
                                });

                            },
                            "CANCEL": function () {
                               dialog.dialog('close');

                            }
                        }
                    });

        });
        $('#postPricelist1').click(function()
        {
            var dialog = $('<p>This will convert the current contract ID to the selected Pricelist price. Press cancel if this was a mis-click!</p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": function () {
                                $.ajax({
                                    url: '{!!url("/convertContractPriceBulk")!!}',
                                    type: "POST",
                                    data: {
                                        contractId: $('#custheadid').val(),
                                        pricelist: 'PRICE LIST 1'
                                    },
                                    success: function (data) {
                                        dialog.dialog('close');
                                        location.reload(true);
                                    }
                                });

                            },
                            "CANCEL": function () {
                               dialog.dialog('close');

                            }
                        }
                    });

        });
        $('#doneCreating').click(function()
        {
            var productsLinesOnPicking = new Array();
            $('#tblCreateNewSpecial > tbody  > tr').each(function() {
               // var data = $(this);
               // var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();

                if (($(this).closest('tr').find('.theProductCode_').val()).length > 0 && ($(this).closest('tr').find('.prodDescription_').val()).length > 0 ) {
                    productsLinesOnPicking.push({
                        'productCode': $(this).closest('tr').find('.theProductCode_').val(),
                        'desc': $(this).closest('tr').find('.prodDescription_').val(),
                        'price': $(this).closest('tr').find('.prodPrice_').val(),
                        'dateFrom': $(this).closest('tr').find('.dateFrom').val(),
                        'dateTo': $(this).closest('tr').find('.dateTo').val(),
                        'cost_': $(this).closest('tr').find('.cost_').val(),
                        'gp_': $(this).closest('tr').find('.gp_').val(),
                        'costCreated_': $(this).closest('tr').find('.costCreated_').val()
                    });
                }
            });
            $.ajax({
                url: '{!!url("/createCustomerSpecials")!!}',
                type: "POST",
                data: {
                    customerCode: $('#inputCustAcc').val(),
                    customerId: $('#customerId').val(),
                    orderDetails: productsLinesOnPicking,
                    contractDateFrom:$('#dateFrom').val(),
                    contractDateTo:$('#dateTo').val()
                },
                success: function (data) {
                    var dialog = $('<p>Done</p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": function () {
                                dialog.dialog('close');
                                $('#submitFiltersOnCustSpecial').click();

                            }
                        }
                    });
                }
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
//showDialog('#tempDeliveryAddressOnTheFly','50%',250);
        $('#extend').click(function(){
            //extedingspecial
            $('#extedingspecial').show();
            showDialog('#extedingspecial','50%',250);
            $('#doneext').click(function(){
                var valuesProd = new Array();
                var customerId = $('#customerId').val();
                $.each($("input[name='checkproduct[]']:checked"),
                    function () {

                        var data = $(this).parents('tr:eq(0)');
                        var codeID = data.find('td:eq(0)').text();
                        var datefrom = $('#specialdateext').val();
                        var dateto = $('#specialdateextTo').val();
                        console.debug("Date from **************************************"+datefrom);
                        valuesProd.push({  'customerId': customerId,'lineid':codeID,'datefrom':datefrom,'dateto':dateto});

                    });

                $.ajax({
                    url: '{!!url("/doneextending")!!}',
                    type: "POST",
                    data: {
                        customerId: $('#customerId').val(),
                        dates: $('#specialdateext').val(),
                        griddetails: valuesProd
                    },
                    success: function (data) {
                        location.reload(true);
                    }
                });
            });
        });
        $('#bulkediting').click(function(){

               var inputCustAcc = $('#inputCustAcc').val();
               var  dateFrom = $('#dateFrom').val();
               var  dateTo = $('#dateTo').val();
                    window.open('{!!url("/getbulkeditingLandingage")!!}/'+inputCustAcc+"/"+dateFrom+"/"+dateTo, inputCustAcc, "location=1,status=1,scrollbars=1, width=1200,height=850");

        });
        $('#submitFiltersOnCustSpecial').click(function(){
       


            $('#afterFilter').show();
                $('#extend').show();
                $('#deleteSelected').empty();
                $('#deleteSelected').show();
                var acc = $('#inputCustAcc').val();
                $('#specialslink').empty();
                var date = $('#dateFrom').val();
                var dateTo = $('#dateTo').val();
            //Select * between this date for this customer  '{!!url("/masscusterspecialdatefilter")!!}/'+$('#dateFromFilter').val()
                $('#specialslink').append("<a href={!!url('/specialnsJasper')!!}/"+acc+"/"+date+"/"+dateTo+" target=blank style= background: red;color: white;font-weight: 900;padding: 3px;>Print Result</a>");

            $.ajax({
                url: '{!!url("/customerByDateOrContractSpecKF")!!}',
                type: "POST",
                data: {
                    contractId: $('#custheadid').val()
                },
                success: function (data) {
                    var trHTML ="";
                    $('.remthisLine').remove();

                    $.each(data, function (key,value) {
                        trHTML += '<tr  class="remthisLine" style="font-size: 11px;color:black;background:'+value.colors+'"><td>' +
                            value.CustomerSpecial + '</td><td>' +
                            value.SpecialHeaderId + '</td><td>' +
                            value.PastelCode + '</td><td>' +
                            value.PastelDescription+ '</td><td>' +
                            value.Date+'</td><td>' +
                            value.DateTo + '</td><td>'+
                            parseFloat(value.Price).toFixed(2) + '</td><td>'+
                            parseFloat(value.Cost).toFixed(2) + '</td><td>'+
                            parseFloat(value.GP).toFixed(2) + '</td><td  style="display: none;">'+
                            parseFloat(value.CostPrice).toFixed(2) + '</td><td>'+
                            parseFloat(value.Available).toFixed(2) + '</td><td>'+
                            parseFloat(value.Instock).toFixed(2) + '</td><td>'+
                            parseFloat(value.costCreated).toFixed(2) + '</td><td>'+
                            (parseFloat(value.Price).toFixed(2)*0.9).toFixed(2) + '</td><td>'+
                            parseFloat(value.PL1).toFixed(2) + '</td><td>'+
                            parseFloat(value.PL2).toFixed(2) + '</td><td>'+
                            parseFloat(value.PL3).toFixed(2) + '</td><td>'+
                            parseFloat(value.PL4).toFixed(2) + '</td><td>'+
                            parseFloat(value.PL5).toFixed(2) + '</td><td>'+
                            parseFloat(value.PL6).toFixed(2) + '</td>'+
                            '<td><button class="btn-sx" value="' +value.CustomerSpecial +'">Delete</button>' +
                            '<input type="checkbox" name="checkproduct[]" value ="'+value.PastelCode+'" style="height:18px !important;width:30px"></td></tr>';
                        $('#specialId').val( value.SpecialHeaderId);
                    });
                    $('#tblCreatedCustomerSpecials').append(trHTML);
                }
            });
            
            $('#checkall').on('click',function(){
                $($("input[name='checkproduct[]']")).each(function(){
                    $(this).prop('checked',true);
                });
            });
        });

        $('#tblCreatedCustomerSpecials').on('click', 'button', function (e) {
            var $this = $(this);
            var $thisVal = $(this).val();
            $.ajax({
                url: '{!!url("/removeCustomerSpecial")!!}',
                type: "POST",
                data: {
                    removeSpecial: $thisVal
                },
                success: function (data) {

                    var dialog = $('<p>Special Removed</p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": function () {
                                $this.closest('tr').remove();
                                dialog.dialog('close');
                            }
                        }
                    });
                }
            });
        });

        //DELETE SELECTED
        $('#deleteSelected').click(function(){
            var valuesProd = new Array();
            var customerId = $('#customerId').val();
            $.each($("input[name='checkproduct[]']:checked"),
                function () {
                    var data = $(this).parents('tr:eq(0)');

                    var codeID = data.find('td:eq(0)').text();
                    var datefrom = data.find('td:eq(4)').text();
                    var dateto = data.find('td:eq(5)').text();

                    valuesProd.push({'customerId': customerId,'lineid':codeID});
                });
            $.ajax({
                url: '{!!url("/deleteselectedcustomerspeciallines")!!}',
                type: "POST",
                data: {
                    griddetails: valuesProd,
                    customerId: customerId
                },
                success: function (data) {

                    var dialog = $('<p>Done</p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": function () {
                                location.reload(true);

                            }
                        }
                    });

                }
            });
        });

        $('#pleaseAddNewCust').click(function(){
            window.open('{!!url("/andNewSpecialKF")!!}', "newSpecial", "width=1600, height=800, scrollbars=yes");
        });
        $('#tblCreatedCustomerSpecials tbody').on('click', 'tr', function (e) {
            $("#tblCreatedCustomerSpecials tbody tr").removeClass('row_selected');
            $(this).addClass('row_selected');
        });
        $('#tblCreatedCustomerSpecials tbody').on('dblclick', 'tr', function (e){
            $("#tblCreatedCustomerSpecials tbody tr").removeClass('row_selected');
            $(this).addClass('row_selected');
            $('#popUpdateLine').show();
            showDialog('#popUpdateLine','60%',450);
            var rowOnOrder =  $(this).closest("tr");

            $('#specialIdUpdate').val(rowOnOrder.find('td:eq(0)').text());
            $('#itemCode').val(rowOnOrder.find('td:eq(2)').text());
            $('#itemDescription').val(rowOnOrder.find('td:eq(3)').text());
            $('#specialFrom').val(rowOnOrder.find('td:eq(4)').text());
            $('#hiddenSpecaialFrom').val(rowOnOrder.find('td:eq(4)').text());
            $('#specialTo').val(rowOnOrder.find('td:eq(5)').text());
            $('#hiddenSpecaialTo').val(rowOnOrder.find('td:eq(5)').text());
            $('#specialPrice').val(rowOnOrder.find('td:eq(6)').text());
            $('#specialCost').val(rowOnOrder.find('td:eq(7)').text());
            $('#specialGp').val(rowOnOrder.find('td:eq(8)').text());
            $('#updateTheSpecuial').click(function(){
                $.ajax({
                    url: '{!!url("/updatespeciialLine")!!}',
                    type: "POST",
                    data: {
                        itemCode: $('#itemCode').val(),
                        specialIdUpdate: $('#specialIdUpdate').val(),
                        itemDescription: $('#itemDescription').val(),
                        specialFrom: $('#specialFrom').val(),
                        specialTo: $('#specialTo').val(),
                        specialPrice: $('#specialPrice').val(),
                        specialCost: $('#specialCost').val(),
                        specialGp: $('#specialGp').val()
                    },
                    success: function (data) {
                        $('#updatedspecials').show();
                        showDialog('#updatedspecials',380,100);
                        $('#btnspecialUpdated').click(function(){
                            $('#popUpdateLine').dialog('close');
                            $('#updatedspecials').dialog('close');
                            $('#submitFiltersOnCustSpecial').click();
                        });
                    }
                });
            });
        });
    });
    function generateALine2()
    {

        // $( "#table" ).colResizable({ disable : true });

        //calculator();
        var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));
        var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
            '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_'+tokenId+'" class="theProductCode_ set_autocomplete inputs"></td>' +
            '<td contenteditable="false" class="col-md-4"><input name="prodDescription_" id ="prodDescription_'+tokenId+'" class="prodDescription_ set_autocomplete inputs" tabindex="-1"></td>' +
            '<td  contenteditable="false" class="col-md-2"><input type="text" name="dateFrom" id ="dateFrom'+tokenId+'"    title="in stock" class="dateFrom resize-input-inside inputs"></td>' +
            '<td contenteditable="false" class="col-md-2"><input type="text" name="dateTo"  id ="dateTo'+tokenId+'"  class="dateTo resize-input-inside"></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs lst" style="font-weight: 800;width: 100%;" ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="cost_" id ="cost_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="cost_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" readonly ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="gp_" id ="gp_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="gp_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" readonly></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="costCreated_" id ="costCreated_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="costCreated_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" readonly></td>'+
            '<td><button type="button" id="cancelThis" class="btn-danger btn-xs cancel" style="height: 16px;padding: 0px 5px;font-size: 9px;">Cancel</button></td></tr>');
        $('#tblCreateNewSpecial tbody')
            .append( $row )
            .trigger('addRows', [ $row, false ]);
        if(!$('.lst').is(":focus"))
        {
            $('#prodCode_' + tokenId).focus();

            if ($('#checkboxDescription').is(':checked')) {
                $('#prodDescription_' + tokenId).focus();
            }
        }

        $('input').on('click keyup' ,function(){
            // $('input').click(function(){
            var ID = $(this).attr('id');
            var jID = '#'+ID;
            var x = ID.indexOf("_");
            var get_token_number = ID.substring(x+1,ID.length);

            if ($(this).hasClass("prodDescription_") && $(this).hasClass("set_autocomplete")) {
                var columnsD = [{name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                    {name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'}
                    ,{name: 'Available', minWidth:'20px',valueField: 'Available'}];
                /*var columnsD = [{name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                    {name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'}
                    ,{name: 'Available', minWidth:'20px',valueField: 'Available'}];*/
                $(""+jID+"").mcautocomplete({
                    source: function(req, response) {
                        var re = $.ui.autocomplete.escapeRegex(req.term);
                        var matcher = new RegExp("^" + re, "i");
                        response($.grep(finalDataProductDescription, function(item) {
                            return matcher.test(item.value);
                        }));
                    },
                    columns:columnsD,
                    autoFocus: true,
                    minlength: 2,
                    delay: 0,
                    multiple: true,
                    multipleSeparator: ",",
                    select:function (e, ui) {
                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);

                        /*if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                        {
                            $('#prodQty_'+token_number).val('0');
                            $('#prodPrice_'+token_number).val('0');
                        }*/

                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);;
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);

                        $('#taxCode' + token_number).val(ui.item.Tax);
                        $('#cost_' + token_number).val(ui.item.Cost);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                    }
                });

            }

            if ($(this).hasClass("theProductCode_") && $(this).hasClass("set_autocomplete")) {
                var columnsC = [{name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'},
                    {name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'}
                    ,
                    {name: 'Available', minWidth:'20px',valueField: 'Available'}];
                $("" + jID + "").mcautocomplete({
                    //source: finalDataProduct,
                    source: function(req, response) {
                        var re = $.ui.autocomplete.escapeRegex(req.term);
                        var matcher = new RegExp("^" + re, "i");
                        response($.grep(finalDataProduct, function(item) {
                            return matcher.test(item.value);
                        }));
                    },
                    columns:columnsC,
                    minlength: 1,
                    autoFocus: true,
                    delay: 0,
                    select:function (e, ui) {

                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        /*if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                        {
                            $('#prodQty_'+token_number).val('0');
                            $('#prodPrice_'+token_number).val('0');
                        }*/
                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                        console.debug("I am inside this");
                        console.debug($('#prodDescription_' + token_number).val());
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                        //checkIfOrderHasMultipleProducts(ui.item.extra,token_number);
                        //$('#inStock_' + token_number).val(ui.item.QtyInStock);
                        $('#taxCode' + token_number).val(ui.item.Tax);
                        $('#cost_' + token_number).val(ui.item.Cost);
                        // $('#prodQty_' + token_number).attr('title', 'In Stock ' + parseFloat(ui.item.QtyInStock).toFixed(3));

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                    }

                });
            }

            //calculator();
        });
        $(".dateTo,.dateFrom").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $('#tblCreateNewSpecial').on('click', 'button', function (e) {
            var $this = $(this);
            var $thisVal = $(this).val();
            $this.closest('tr').remove();


        });

    }

    $(document).on('keydown', '.inputs', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        var testLst = $(this).closest('tr');
        if ((code == 13 || code == 39)) {
            var index = $('.inputs').index(this) + 1;
            $('.inputs').eq(index).focus();
        }
        if (code == 37) {
            var index = $('.inputs').index(this) - 1;
            $('.inputs').eq(index).focus();
        }
        var closesttr =  $(this).closest('tr');
        var prodClosest = closesttr.find(".theProductCode_").val();
        var prodDescClosest = closesttr.find(".prodDescription_").val();
        var prodPriceClosest = closesttr.find(".prodPrice_").val();
        if ( (code == 34 || code == 13 || code == 39 ) && $.trim(prodClosest.length) > 0 && prodDescClosest.length > 0 &&  prodPriceClosest.length > 0) {
            generateALine2();

        }
    });
    $(document).on('keyup', '.lst', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13 || code == 9) {
            var index = $('.inputs').index(this);

            $('.lst').eq(index).focus();
            generateALine2();

        }
    });
    function marginCalculator(cost,onCellVal)
    {
        return ((cost/onCellVal))*100;
    }
    $(document).on('keyup', '#specialPrice', function(e) {
        $('#specialGp').val(parseFloat( marginCalculator($('#specialCost').val(),$('#specialPrice').val())).toFixed(2));
    });
    $(document).on('keydown', '#tblCreateNewSpecial', function(e) {
        var $table = $(this);

        var $active = $('input:focus,select:focus,li:focus',$table);
        var $next = null;
        var focusableQuery = 'input:visible,select:visible,textarea:visible,li:visible';
        var position = parseInt( $active.closest('td').index()) + 1;
        var $celltheProductCode_ = $active.closest('td').find(".theProductCode_").val();

        switch(e.keyCode){
            case 37: // <Left>
                $next = $active.parent('td').prev().find(focusableQuery);
                break;
            case 33: // <Up>
                c
                if ($celltheProductCode_.length < 1) {
                    $next = $active
                        .closest('tr')
                        .prev()
                        .find('td:nth-child(' + position + ')')
                        .find(focusableQuery)
                    ;
                }

                break;
            case 38: // <Up>
                if ($celltheProductCode_.length < 1) {
                    $next = $active
                        .closest('tr')
                        .prev()
                        .find('td:nth-child(' + position + ')')
                        .find(focusableQuery)
                    ;
                }
                break;
            case 34: // <Right>
                $next = $active.closest('td').next().find(focusableQuery);
                break;
            case 40: // <Down>
                if ($celltheProductCode_.length < 1) {
                    $next = $active
                        .closest('tr')
                        .next()
                        .find('td:nth-child(' + position + ')')
                        .find(focusableQuery)
                    ;
                }
                console.debug('$celltheProductCode_******** DOWN'+$celltheProductCode_);
                break;

        }
        if($next && $next.length)
        {
            $next.focus();
        }
    });

    $(document).on('keypress', '.prodPrice_', function(e) {
      /*  var key = (e.keyCode ? e.keyCode : e.which);
        var $isAuth = $(this).closest("tr").find(".title").attr("id");
        var $priceToken = $(this).closest("tr").find(".prodPrice_").attr("id");*/

        var costing = $(this).closest("tr").find(".cost_").val();
        var prodPriceVal =  $(this).closest("tr").find(".prodPrice_").val();
       $(this).closest("tr").find(".gp_").val( parseFloat( marginCalculator(costing,prodPriceVal)).toFixed(2));


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
    function refreshcontractsviadate()
    {
        if($("#dateFrom").val() == undefined || $("#dateTo").val() == undefined) {
       
            }
            else{
            $("#custheadid").empty();
                $.ajax({
                url: '{!!url("/getContractsPerCustomerIDWithDates")!!}',
                type: "POST",
                data: {
                    customerid: $('#customerId').val(),
                    datefrom:$("#dateFrom").val(),
                    dateto:$("#dateTo").val()
                },
                success: function (data) {
                    var trHTML ="";
                    $.each(data, function (key, value) {

                        trHTML += 
                        '<option value="'+value.SpecialHeaderId+'">'+value.SpecialHeaderId+'</option>';

                     $("#custheadid").empty();
                    });
                    $("#custheadid").append(trHTML);
                }
            });
            }
    }

</script>
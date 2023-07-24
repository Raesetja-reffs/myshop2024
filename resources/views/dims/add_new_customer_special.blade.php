@extends('layouts.app')

@section('content')
    <div class="col-lg-12"  style="background: white;">
<h3 style="text-align: center;">Add New Customer Special</h3>
        <fieldset class="well">
            <legend class="well-legend">Add Filters</legend>
            <form>
                <div class="form-group  col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="inputCustAcc"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Account</label>
                    <input type="text" name="custCode" class="form-control input-sm col-xs-1" id="inputCustAcc" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
                    <input type="hidden" name="customerId" class="form-control input-sm col-xs-1" id="customerId" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
                </div>

                <div class="form-group col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="inputCustName"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Name</label>
                    <input type="text" name="custDescription" class="form-control input-sm col-xs-1" id="inputCustName" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
                </div>
                <div class="form-group col-md-3 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="dateFrom"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Contract- Date From</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="dateFrom" style="font-weight: 900;    color: black;font-size: 13px;">
                </div>
                <div class="form-group col-md-3 "  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="dateTo"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Contract- Date To</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="dateTo" style="font-weight: 900;    color: black;font-size: 13px;">

                </div>

                <button type="button" id="submitFiltersOnCreatingCustSpecial" class="btn-xs btn-primary">Submit</button>
            </form>
        </fieldset>
    </div>
    <div class="col-lg-12" id="afterFilter">
            <div class="col-lg-12" style="background: white;height: 60%;overflow-y: scroll">

                <button class="btn-success btn-xs" id="addLine">Add Line</button>
                <table id ="tblCreateNewSpecial" class="table table-bordered table-condensed">
                    <thead>
                    <tr style="font-size: 12px;">
                        <td>Code</td>
                        <td>Description</td>
                        <td>DtFrom</td>
                        <td>DtTo</td>
                        <td>Price</td>
                        <td>Cost</td>
                        <td>Current GP</td>
                        <td>Cost Created</td>
                        <td>C.S Price</td>
                        <td>Actions</td>
                    </tr>
                    </thead>
                    <tbody></tbody>

                </table>

            </div>
            <div class="col-lg-12" style="background: white;">
                <button id="doneCreating" class="btn-xs btn-success">Done</button>
            </div>


    </div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy  + '-' +mm  + '-' +dd ;
    console.debug(today);
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    var jArray = JSON.stringify({!! json_encode($products) !!});
    var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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

        });
        inputCustName.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#customerId').val(data.CustomerId);

        });
        $('#addLine').click(function(){

            generateALine2();
        });
        $("#dateFrom,#dateTo").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $('#submitFiltersOnCreatingCustSpecial').click(function(){
            $('#afterFilter').show();
            generateALine2();
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
                        'price': $(this).closest('tr').find('.prodPrice_').val(),
                        'dateFrom':  dateReturn($(this).closest('tr').find('.dateFrom').val()) ,
                        'dateTo': dateReturn( $(this).closest('tr').find('.dateTo').val()),
                        'cost_': $(this).closest('tr').find('.cost_').val(),
                        'gp_': $(this).closest('tr').find('.gp_').val(),
                        'costCreated_': $(this).closest('tr').find('.costCreated_').val(),
                        'customerid': $('#customerId').val(),
                    });
                }
            });
            $.ajax({
                url: '{!!url("/XmlCreateCustomerSpecials")!!}', // createCustomerSpecials
                type: "POST",
                data: {
                    customerCode: $('#inputCustAcc').val(),
                    customerId: $('#customerId').val(),
                    contractDateFrom: $('#dateFrom').val(),
                    contractDateTo: $('#dateTo').val(),
                    orderDetails: productsLinesOnPicking
                },
                success: function (data) {

                    if (data.result !="SUCCESS")
                    {
                        var dialog = $('<p>'+data.result+'</p>').dialog({
                            height: 200, width: 700, modal: true, containment: false,
                            buttons: {
                                "OKAY": function () {
                                    dialog.dialog('close');
                                }
                            }
                        });
                    }else{
                        var dialog = $('<p>Special Create</p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": function () {
                                location.reload(true);
                                dialog.dialog('close');
                            }
                        }
                    });

                    }



                }
            });
        });
    });
    function generateALine2()
    {
        var contractFrom = $('#dateFrom').val();
        var contractTo = $('#dateTo').val();
        var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));
        var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
            '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_'+tokenId+'" class="theProductCode_ set_autocomplete inputs"></td>' +
            '<td contenteditable="false" class="col-md-3"><input name="prodDescription_" id ="prodDescription_'+tokenId+'" class="prodDescription_ set_autocomplete inputs" tabindex="-1"></td>' +
            '<td  contenteditable="false" class="col-md-2"><input type="text" name="dateFrom" id ="dateFrom'+tokenId+'" value= "'+contractFrom+'"  title="in stock" class="dateFrom resize-input-inside inputs"></td>' +
            '<td contenteditable="false" class="col-md-2"><input type="text" name="dateTo"  id ="dateTo'+tokenId+'" value= "'+contractTo+'" class="dateTo resize-input-inside"></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="cost_" id ="cost_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="cost_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="gp_" id ="gp_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="gp_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="costCreated_" id ="costCreated_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="costCreated_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodPriceB_" id ="prodPriceB_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodPriceB_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
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
                $(""+jID+"").mcautocomplete({
                    source: finalDataProductDescription,
                    columns:columnsD,
                    autoFocus: true,
                    minlength: 2,
                    delay: 0,
                    multiple: true,
                    multipleSeparator: ",",
                    select:function (e, ui) {
                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);

                        if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                        {
                            $('#prodQty_'+token_number).val('0');
                            $('#prodPrice_'+token_number).val('0');
                        }
                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);

                        $('#taxCode' + token_number).val(ui.item.Tax);
                        $('#cost_' + token_number).val(ui.item.Cost);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        productPrice(token_number);


                    }
                });

            }

            if ($(this).hasClass("theProductCode_") && $(this).hasClass("set_autocomplete")) {
                var columnsC = [{name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'},
                    {name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'}
                    ,
                    {name: 'Available', minWidth:'20px',valueField: 'Available'}];
                $("" + jID + "").mcautocomplete({
                    source: finalDataProduct,
                  /*  source: function(req, response) {
                        var re = $.ui.autocomplete.escapeRegex(req.term);
                        var matcher = new RegExp("^" + re, "i");
                        response($.grep(finalDataProduct, function(item) {
                            return matcher.test(item.value);
                        }));
                    },*/
                    columns:columnsC,
                    minlength: 1,
                    autoFocus: true,
                    delay: 0,
                    select:function (e, ui) {

                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                        {
                            $('#prodQty_'+token_number).val('0');
                            $('#prodPrice_'+token_number).val('0');
                        }
                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
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

                        productPrice(token_number);

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
            $this.closest('tr').remove();
        });

    }

    function marginCalculator(cost,onCellVal)
    {
        return ((cost/onCellVal))*100;
    }
    function productPrice(token_number)
    {
        $.ajax({
            url: '{!!url("/getCutomerPriceOnOrderForm")!!}',
            type: "POST",
            data: {
                customerID: $('#inputCustAcc').val(),
                deliveryDate:today,
                productCode: $('#prodCode_' + token_number).val(),
                warehouseid:1
            },
            success: function (data) {
                    $('#prodPriceB_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
            }
        });
    }
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
    $(document).on('keyup', '.prodPrice_', function(e) {
        /*  var key = (e.keyCode ? e.keyCode : e.which);
         var $isAuth = $(this).closest("tr").find(".title").attr("id");
         var $priceToken = $(this).closest("tr").find(".prodPrice_").attr("id");*/

        var costing = $(this).closest("tr").find(".cost_").val();
        var prodPriceVal =  $(this).closest("tr").find(".prodPrice_").val();
        $(this).closest("tr").find(".gp_").val( parseFloat( marginCalculator(costing,prodPriceVal)).toFixed(2));


    });
    function dateReturn(dates)
    {
        //27-02-2019
        var datearray = dates.split("-");
        if (datearray[0].length > 2){
            var newdateDelivDate = dates;
        }
        else {
            var newdateDelivDate = datearray[2] + '-' + datearray[1] + '-' + datearray[0];
        }


        return newdateDelivDate
    }

</script>

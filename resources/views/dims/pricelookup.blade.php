@extends('layouts.app')

@section('content')

        <div id="dialog2" title="Price Check" style="font-weight: 900;color: black;">
            <div class="col-lg-12">
                <form>
                    <fieldset class="well">
                        <legend class="well-legend">Search</legend>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="productCodeSearchPrice"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Code</label>
                        <input type="text" class="form-control input-sm " id="productCodeSearchPrice" style="font-size: 10px;">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="productDescriptionSearchPrice"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Description</label>
                        <input type="text" class="form-control input-sm " id="productDescriptionSearchPrice" style="font-size: 10px;">
                    </div>
                    </fieldset>

                </form>
            </div>
                <div class="col-lg-12">
                    <div class="col-md-6" style="background: goldenrod;padding: 10px;">
                          <input id="selling_price" class="form-control input-sm " type="text" placeholder="Type In your Deal Price">
                        <table class="table" id="cost_margin" style="width:100%">
                            <thead>
                            <tr>
                                <th>Cost</th><th>Margin %</th></tr>
                            </thead>
                        <tbody>
                        <tr>
                            <td><input id="costs" ><input id="avgCost" type="text" readonly></td>
                            <td><input id="margin" ></td>
                        </tr>
                        </tbody>

                        </table>
                     </div>
                    <div class="col-md-6" style="height:400px;background:white">
                        <table class="table2 table-bordered " id="priceCheckingOnCall" style="width:100%;overflow-y: scroll;font-weight: 900;">
                            <thead>
                            <tr>
                                <th>Price List</th><th>Price</th><th>Price Inc</th></tr>
                            </thead>

                        </table>

                    </div>
                    <hr>

                    <div style="width: 50%;float: right;background: darkseagreen; height: 174px;">
                        <table class="table" id="appendQtyOnHand" style="display: none">

                        </table>

                        <table class="table" id="appendOnPurchasesAnsSalesOrders">

                        </table>
                    </div>
                </div>
            </div>




@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    $(document).on('click', '#productCodeSearchPrice', function(e) {
        $('#productCodeSearchPrice').select();
    });
    $(document).on('click', '#productDescriptionSearchPrice', function(e) {
        $('#productDescriptionSearchPrice').select();
    });
    $(document).ready(function() {
        $('#routePlanningPopUp').hide();
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#tabletLoadingApp').hide();
        $('#salesQuotebtn').hide();
        $('#afterFiltering').hide();
        $('#doneSorting').hide();
        $('#updateSorting').hide();
        $('#popUpForNewTruckControlSheetHeader').hide();
        $('#messageNB').hide();
        $('#straightForwardPrintThtTruckControlId').hide();
        $('#instantPrint').hide();
        $('#pricingOnCustomer').hide();
        $('#salesOnOrder').hide();
        $('#posCashUp').hide();
        var jArray = JSON.stringify({!! json_encode($products) !!});
        var accounting = "<?php echo config('app.Accounting') ?>";
        var finalDataProduct = $.map(JSON.parse(jArray), function (item) {
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
                Available: parseFloat(item.Available).toFixed(2),
                PurchOrder: item.PurchOrder,
                AvgCost: item.AvgCost
            }

        });
        var finalDataProductTest = $.map(JSON.parse(jArray), function (item) {
            return {
                value: item.PastelDescription,
                PastelCode: item.PastelCode,
                PastelDescription: item.PastelDescription,
                UnitSize: item.UnitSize,
                Tax: item.Tax,
                Cost: item.Cost,
                QtyInStock: parseFloat(item.QtyInStock).toFixed(2),
                Margin: item.Margin,
                Alcohol: item.Alcohol,
                Available: parseFloat(item.Available).toFixed(2),
                PurchOrder: item.PurchOrder,
                AvgCost: item.AvgCost
            }

        });


        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var columnsC = [{name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'},
                {name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                {name: 'Available', minWidth:'20px',valueField: 'Available'}];

            $("#productCodeSearchPrice").mcautocomplete({

                source: function(req, response) {
                    var re = $.ui.autocomplete.escapeRegex(req.term);
                    var matcher = new RegExp("^" + re, "i");
                    response($.grep(finalDataProduct, function(item) {
                        return matcher.test(item.value);
                    }));

                },
                columns: columnsC,
                minlength: 1,
                autoFocus: true,
                delay: 0,

                select: function (e, ui) {

                    $('#productDescriptionSearchPrice').val($.trim(ui.item.PastelDescription));
                    $('#productCodeSearchPrice').val(ui.item.PastelCode);

                    $('#priceCheckingOnCall').empty();
                    $.ajax({
                        url: '{!!url("/generalPriceChecking")!!}',
                        type: "POST",
                        data: {productCode:ui.item.PastelCode},
                        success: function (data) {

                            var trHTML = '';
                            $('.rebuild_price_check_list').empty();

                            $.each(data, function (key, value) {
                                trHTML += '<tr  class="rebuild_price_check_list" style="font-size: 10px;color:black"><td>' +
                                    value.PriceList + '</td><td><strong>' +
                                    value.Price + '</strong></td><td>' +
                                    value.PriceInc + '</td><td>' +
                                    '</td></tr>';
                            });
                            $('#priceCheckingOnCall').append(trHTML);
                            $.ajax({
                                url: '{!!url("/getProductStockOnHand")!!}',
                                type: "POST",
                                data: {
                                    productCode: ui.item.PastelCode
                                },
                                success: function (data2) {
                                    var trHTML = '';
                                    $('.rebuild_price_check').empty();
                                    $('#costs').val((parseFloat(data2[0].Cost)).toFixed(2));
                                    $('#avgCost').val((parseFloat(data2[0].AvgCost)).toFixed(2));
                                    //$.each(data, function (key,value) {
                                    $.ajax({
                                        url: '{!!url("/countOnSalesOrder")!!}',
                                        type: "POST",
                                        data: {
                                            prodCode:ui.item.PastelCode
                                        },
                                        success: function (data3) {

                                            trHTML += '<tr  class="rebuild_price_check" style="font-size: 13px;color:black"><td>' +
                                                'Sales Orders</td><td><strong>' +
                                                data3+ '</strong>' +
                                                '</td></tr>';
                                            trHTML += '<tr  class="rebuild_price_check" style="font-size: 13px;color:black"><td>' +
                                                'Purchase</td><td><strong>' +
                                                ui.item.PurchOrder+ '</strong>' +
                                                '</td></tr>';

                                            $('#appendOnPurchasesAnsSalesOrders').append(trHTML);
                                        }
                                    });
                                    switch(accounting)
                                    {
                                        case 'Pastel':
                                            $.ajax({
                                                url: '{!!url("/stockApi")!!}',
                                                type: "POST",
                                                data: {
                                                    ItemCode:ui.item.PastelCode
                                                },
                                                success: function (data3) {

                                                    trHTML += '<tr  class="rebuild_price_check" style="font-size: 13px;color:black"><td>' +
                                                        'Available</td><td><strong>' +
                                                        data3+ '</strong>' +
                                                        '</td></tr>';
                                                    trHTML += '<tr  class="rebuild_price_check" style="font-size: 13px;color:black"><td>' +
                                                        'Cost Price</td><td><strong>' +
                                                        (parseFloat(data2[0].Cost)).toFixed(2) + '</strong>' +
                                                        '</td></tr>';
                                                    $('#appendQtyOnHand').append(trHTML);
                                                }
                                            });
                                            break;
                                        case 'Other':
                                            trHTML += '<tr  class="rebuild_price_check" style="font-size: 13px;color:black"><td>' +
                                                'Available</td><td><strong>' +
                                                data2[0].Remaining + '</strong>' +
                                                '</td></tr>';
                                            trHTML += '<tr  class="rebuild_price_check" style="font-size: 13px;color:black"><td>' +
                                                'Cost Price</td><td><strong>' +
                                                (parseFloat(data2[0].Cost)).toFixed(2) + '</strong>' +
                                                '</td></tr>';
                                            $('#appendQtyOnHand').append(trHTML);
                                            break;

                                    }

                                    //});

                                    //appendQtyOnHand
                                }
                            });



                        }
                    });//End of get price
                }
            });
            var columnsD = [{name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                {name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'}
                ,{name: 'Available', minWidth:'20px',valueField: 'Available'}];
            $("#productDescriptionSearchPrice").mcautocomplete({
                source:finalDataProductTest,
                columns: columnsD,
                autoFocus: true,
                minlength: 3,
                delay: 0,
                multiple: true,
                multipleSeparator: " ",

                select: function (e, ui) {
                    $('#productDescriptionSearchPrice').val($.trim(ui.item.PastelDescription));
                    $('#productCodeSearchPrice').val($.trim(ui.item.PastelCode));
                    $('#priceCheckingOnCall').empty();
                    $('#costs').val(ui.item.Cost);
                    $('#avgCost').val(ui.item.AvgCost);
                    $.ajax({
                        url: '{!!url("/generalPriceChecking")!!}',
                        type: "POST",
                        data: {productCode:ui.item.PastelCode},
                        success: function (data) {

                            var trHTML = '';
                            $('.rebuild_price_list').empty();

                            $.each(data, function (key, value) {
                                trHTML += '<tr  class="rebuild_price_list" style="font-size: 10px;color:black"><td>' +
                                    value.PriceList + '</td><td><strong>' +
                                    value.Price + '</strong></td><td>' +
                                    value.PriceInc + '</td><td>' +
                                    '</td></tr>';
                            });
                            $('#priceCheckingOnCall').append(trHTML);

                            $.ajax({
                                url: '{!!url("/getProductStockOnHand")!!}',
                                type: "POST",
                                data: {
                                    productCode: ui.item.PastelCode
                                },
                                success: function (data2) {
                                    var trHTML = '';
                                    $('.rebuild_price_check').empty();
                                    $('#costs').val((parseFloat(data2[0].Cost)).toFixed(2));
                                    $('#avgCost').val((parseFloat(data2[0].AvgCost)).toFixed(2));
                                    //$.each(data, function (key,value) {
                                    switch(accounting)
                                    {
                                        case 'Pastel':
                                            $.ajax({
                                                url: '{!!url("/stockApi")!!}',
                                                type: "POST",
                                                data: {
                                                    ItemCode:ui.item.PastelCode
                                                },
                                                success: function (data3) {

                                                    trHTML += '<tr  class="rebuild_price_check" style="font-size: 10px;color:black"><td>' +
                                                        'Available</td><td><strong>' +
                                                        data3+ '</strong>' +
                                                        '</td></tr>';
                                                    trHTML += '<tr  class="rebuild_price_check" style="font-size: 10px;color:black"><td>' +
                                                        'Cost Price</td><td><strong>' +
                                                        (parseFloat(data2[0].Cost)).toFixed(2) + '</strong>' +
                                                        '</td></tr>';
                                                    $('#appendQtyOnHand').append(trHTML);

                                                    $.ajax({
                                                        url: '{!!url("/countOnSalesOrder")!!}',
                                                        type: "POST",
                                                        data: {
                                                            prodCode:ui.item.PastelCode
                                                        },
                                                        success: function (data3) {

                                                            trHTML += '<tr  class="rebuild_price_check" style="font-size: 13px;color:black"><td>' +
                                                                'Sales Orders</td><td><strong>' +
                                                                data3+ '</strong>' +
                                                                '</td></tr>';
                                                            trHTML += '<tr  class="rebuild_price_check" style="font-size: 13px;color:black"><td>' +
                                                                'Purchase</td><td><strong>' +
                                                                ui.item.PurchOrder+ '</strong>' +
                                                                '</td></tr>';

                                                            $('#appendOnPurchasesAnsSalesOrders').append(trHTML);
                                                        }
                                                    });
                                                }
                                            });
                                            break;
                                        case 'Other':
                                            trHTML += '<tr  class="rebuild_price_check" style="font-size: 10px;color:black"><td>' +
                                                'Available</td><td><strong>' +
                                                data2[0].Remaining + '</strong>' +
                                                '</td></tr>';
                                            trHTML += '<tr  class="rebuild_price_check" style="font-size: 10px;color:black"><td>' +
                                                'Cost Price</td><td><strong>' +
                                                (parseFloat(data2[0].Cost)).toFixed(2) + '</strong>' +
                                                '</td></tr>';
                                            $('#appendQtyOnHand').append(trHTML);

                                            $.ajax({
                                                url: '{!!url("/countOnSalesOrder")!!}',
                                                type: "POST",
                                                data: {
                                                    prodCode:ui.item.PastelCode
                                                },
                                                success: function (data3) {

                                                    trHTML += '<tr  class="rebuild_price_check" style="font-size: 13px;color:black"><td>' +
                                                        'Sales Orders</td><td><strong>' +
                                                        data3+ '</strong>' +
                                                        '</td></tr>';
                                                    trHTML += '<tr  class="rebuild_price_check" style="font-size: 13px;color:black"><td>' +
                                                        'Purchase</td><td><strong>' +
                                                        ui.item.PurchOrder+ '</strong>' +
                                                        '</td></tr>';

                                                    $('#appendOnPurchasesAnsSalesOrders').append(trHTML);
                                                }
                                            });
                                            break;

                                    }

                                    //appendQtyOnHand
                                }
                            });

                        }
                    });//End of get price
                }
            });

        $('#selling_price').on('keyup', function(ev) {
            //margin
            console.debug( $('#costs').val() +'-----'+$('#selling_price').val());
            $('#margin').val(parseFloat(marginCalculator($('#costs').val(),$('#selling_price').val())).toFixed(2));
        });

        function marginCalculator(cost,onCellVal)
        {
            return (1-(cost/onCellVal))*100;
        }

        $(document).on('keyup keypress', '#margin', function(e) {
            var margin = $(this).closest("tr").find("#margin").val();
            console.debug("Types margin***********************"+margin);
            var cost = $(this).closest("tr").find("#costs").val();
           $("#selling_price").val(  parseFloat(marginToPrice(cost,margin)).toFixed(2)) ;
        });
        function marginToPrice(cost,margin)
        {
            return (cost/(1-(margin/100)));
        }

        ///
    });


    </script>
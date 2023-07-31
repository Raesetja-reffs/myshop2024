<x-app-layout>
    <x-slot name="header">
        {{ __('Price Check') }}
    </x-slot>
    <x-slot name="breadcrum">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <!--end::Item-->

        <!--begin::Item-->
        <li class="breadcrumb-item text-dark">
            Price Check </li>
        <!--end::Item-->
    </x-slot>

    <div id="dialog2" title="Price Check">
        <div class="card mb-3">
            <div class="card-body">
                <form>
                    <div class="row">
                        <h5>Search</h5>
                        <div class="col-md-6">
                            <label for="productCodeSearchPrice">Code</label>
                            <input type="text" class="form-control" id="productCodeSearchPrice">
                        </div>
                        <div class="col-md-6">
                            <label for="productDescriptionSearchPrice">Description</label>
                            <input type="text" class="form-control " id="productDescriptionSearchPrice">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12 mb-3">
                            <input id="selling_price" class="form-control" type="text" placeholder="Type In your Deal Price">
                        </div>
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover" id="cost_margin" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Cost</th>
                                        <th>Margin %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input id="costs" class="form-control mb-3">
                                            <input id="avgCost" type="text" class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input id="margin" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <table class="table2 table table-bordered table-hover" id="priceCheckingOnCall" style="width:100%;overflow-y: scroll;">
                            <thead>
                                <tr>
                                    <th>Price List</th>
                                    <th>Price</th>
                                    <th>Price Inc</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-hover" id="appendQtyOnHand" style="display: none">
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-hover" id="appendOnPurchasesAnsSalesOrders">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
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
        var accounting = "<?php echo config('app.Accounting'); ?>";
        var finalDataProduct = $.map(JSON.parse(jArray), function(item) {
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
        var finalDataProductTest = $.map(JSON.parse(jArray), function(item) {
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

        var columnsC = [{
                name: 'PastelCode',
                minWidth: '90px',
                valueField: 'PastelCode'
            },
            {
                name: 'PastelDescription',
                minWidth: '230px',
                valueField: 'PastelDescription'
            },
            {
                name: 'Available',
                minWidth: '20px',
                valueField: 'Available'
            }
        ];

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

            select: function(e, ui) {

                $('#productDescriptionSearchPrice').val($.trim(ui.item.PastelDescription));
                $('#productCodeSearchPrice').val(ui.item.PastelCode);

                $('#priceCheckingOnCall').empty();
                $.ajax({
                    url: '{!! url('/generalPriceChecking') !!}',
                    type: "POST",
                    data: {
                        productCode: ui.item.PastelCode
                    },
                    success: function(data) {

                        var trHTML = '';
                        $('.rebuild_price_check_list').empty();

                        $.each(data, function(key, value) {
                            trHTML +=
                                '<tr  class="rebuild_price_check_list"><td>' +
                                value.PriceList + '</td><td><strong>' +
                                value.Price + '</strong></td><td>' +
                                value.PriceInc + '</td><td>' +
                                '</td></tr>';
                        });
                        $('#priceCheckingOnCall').append(trHTML);
                        $.ajax({
                            url: '{!! url('/getProductStockOnHand') !!}',
                            type: "POST",
                            data: {
                                productCode: ui.item.PastelCode
                            },
                            success: function(data2) {
                                var trHTML = '';
                                $('.rebuild_price_check').empty();
                                $('#costs').val((parseFloat(data2[0].Cost))
                                    .toFixed(2));
                                $('#avgCost').val((parseFloat(data2[0]
                                    .AvgCost)).toFixed(2));
                                //$.each(data, function (key,value) {
                                $.ajax({
                                    url: '{!! url('/countOnSalesOrder') !!}',
                                    type: "POST",
                                    data: {
                                        prodCode: ui.item.PastelCode
                                    },
                                    success: function(data3) {

                                        trHTML +=
                                            '<tr  class="rebuild_price_check"><td>' +
                                            'Sales Orders</td><td><strong>' +
                                            data3 +
                                            '</strong>' +
                                            '</td></tr>';
                                        trHTML +=
                                            '<tr  class="rebuild_price_check"><td>' +
                                            'Purchase</td><td><strong>' +
                                            ui.item.PurchOrder +
                                            '</strong>' +
                                            '</td></tr>';

                                        $('#appendOnPurchasesAnsSalesOrders')
                                            .append(trHTML);
                                    }
                                });
                                switch (accounting) {
                                    case 'Pastel':
                                        $.ajax({
                                            url: '{!! url('/stockApi') !!}',
                                            type: "POST",
                                            data: {
                                                ItemCode: ui.item
                                                    .PastelCode
                                            },
                                            success: function(
                                                data3) {

                                                trHTML +=
                                                    '<tr  class="rebuild_price_check"><td>' +
                                                    'Available</td><td><strong>' +
                                                    data3 +
                                                    '</strong>' +
                                                    '</td></tr>';
                                                trHTML +=
                                                    '<tr  class="rebuild_price_check"><td>' +
                                                    'Cost Price</td><td><strong>' +
                                                    (parseFloat(
                                                        data2[
                                                            0
                                                        ]
                                                        .Cost
                                                    ))
                                                    .toFixed(
                                                        2) +
                                                    '</strong>' +
                                                    '</td></tr>';
                                                $('#appendQtyOnHand')
                                                    .append(
                                                        trHTML);
                                            }
                                        });
                                        break;
                                    case 'Other':
                                        trHTML +=
                                            '<tr  class="rebuild_price_check"><td>' +
                                            'Available</td><td><strong>' +
                                            data2[0].Remaining +
                                            '</strong>' +
                                            '</td></tr>';
                                        trHTML +=
                                            '<tr  class="rebuild_price_check"><td>' +
                                            'Cost Price</td><td><strong>' +
                                            (parseFloat(data2[0].Cost))
                                            .toFixed(2) + '</strong>' +
                                            '</td></tr>';
                                        $('#appendQtyOnHand').append(
                                            trHTML);
                                        break;

                                }

                                //});

                                //appendQtyOnHand
                            }
                        });



                    }
                }); //End of get price
            }
        });
        var columnsD = [{
                name: 'PastelDescription',
                minWidth: '230px',
                valueField: 'PastelDescription'
            },
            {
                name: 'PastelCode',
                minWidth: '90px',
                valueField: 'PastelCode'
            }, {
                name: 'Available',
                minWidth: '20px',
                valueField: 'Available'
            }
        ];
        $("#productDescriptionSearchPrice").mcautocomplete({
            source: finalDataProductTest,
            columns: columnsD,
            autoFocus: true,
            minlength: 3,
            delay: 0,
            multiple: true,
            multipleSeparator: " ",

            select: function(e, ui) {
                $('#productDescriptionSearchPrice').val($.trim(ui.item.PastelDescription));
                $('#productCodeSearchPrice').val($.trim(ui.item.PastelCode));
                $('#priceCheckingOnCall').empty();
                $('#costs').val(ui.item.Cost);
                $('#avgCost').val(ui.item.AvgCost);
                $.ajax({
                    url: '{!! url('/generalPriceChecking') !!}',
                    type: "POST",
                    data: {
                        productCode: ui.item.PastelCode
                    },
                    success: function(data) {

                        var trHTML = '';
                        $('.rebuild_price_list').empty();

                        $.each(data, function(key, value) {
                            trHTML +=
                                '<tr  class="rebuild_price_list"><td>' +
                                value.PriceList + '</td><td><strong>' +
                                value.Price + '</strong></td><td>' +
                                value.PriceInc + '</td><td>' +
                                '</td></tr>';
                        });
                        $('#priceCheckingOnCall').append(trHTML);

                        $.ajax({
                            url: '{!! url('/getProductStockOnHand') !!}',
                            type: "POST",
                            data: {
                                productCode: ui.item.PastelCode
                            },
                            success: function(data2) {
                                var trHTML = '';
                                $('.rebuild_price_check').empty();
                                $('#costs').val((parseFloat(data2[0].Cost))
                                    .toFixed(2));
                                $('#avgCost').val((parseFloat(data2[0]
                                    .AvgCost)).toFixed(2));
                                //$.each(data, function (key,value) {
                                switch (accounting) {
                                    case 'Pastel':
                                        $.ajax({
                                            url: '{!! url('/stockApi') !!}',
                                            type: "POST",
                                            data: {
                                                ItemCode: ui.item
                                                    .PastelCode
                                            },
                                            success: function(
                                                data3) {

                                                trHTML +=
                                                    '<tr  class="rebuild_price_check"><td>' +
                                                    'Available</td><td><strong>' +
                                                    data3 +
                                                    '</strong>' +
                                                    '</td></tr>';
                                                trHTML +=
                                                    '<tr  class="rebuild_price_check"><td>' +
                                                    'Cost Price</td><td><strong>' +
                                                    (parseFloat(
                                                        data2[
                                                            0
                                                        ]
                                                        .Cost
                                                    ))
                                                    .toFixed(
                                                        2) +
                                                    '</strong>' +
                                                    '</td></tr>';
                                                $('#appendQtyOnHand')
                                                    .append(
                                                        trHTML);

                                                $.ajax({
                                                    url: '{!! url('/countOnSalesOrder') !!}',
                                                    type: "POST",
                                                    data: {
                                                        prodCode: ui
                                                            .item
                                                            .PastelCode
                                                    },
                                                    success: function(
                                                        data3
                                                    ) {

                                                        trHTML
                                                            +=
                                                            '<tr  class="rebuild_price_check"><td>' +
                                                            'Sales Orders</td><td><strong>' +
                                                            data3 +
                                                            '</strong>' +
                                                            '</td></tr>';
                                                        trHTML
                                                            +=
                                                            '<tr  class="rebuild_price_check"><td>' +
                                                            'Purchase</td><td><strong>' +
                                                            ui
                                                            .item
                                                            .PurchOrder +
                                                            '</strong>' +
                                                            '</td></tr>';

                                                        $('#appendOnPurchasesAnsSalesOrders')
                                                            .append(
                                                                trHTML
                                                            );
                                                    }
                                                });
                                            }
                                        });
                                        break;
                                    case 'Other':
                                        trHTML +=
                                            '<tr  class="rebuild_price_check"><td>' +
                                            'Available</td><td><strong>' +
                                            data2[0].Remaining +
                                            '</strong>' +
                                            '</td></tr>';
                                        trHTML +=
                                            '<tr  class="rebuild_price_check"><td>' +
                                            'Cost Price</td><td><strong>' +
                                            (parseFloat(data2[0].Cost))
                                            .toFixed(2) + '</strong>' +
                                            '</td></tr>';
                                        $('#appendQtyOnHand').append(
                                            trHTML);

                                        $.ajax({
                                            url: '{!! url('/countOnSalesOrder') !!}',
                                            type: "POST",
                                            data: {
                                                prodCode: ui.item
                                                    .PastelCode
                                            },
                                            success: function(
                                                data3) {

                                                trHTML +=
                                                    '<tr  class="rebuild_price_check"><td>' +
                                                    'Sales Orders</td><td><strong>' +
                                                    data3 +
                                                    '</strong>' +
                                                    '</td></tr>';
                                                trHTML +=
                                                    '<tr  class="rebuild_price_check"><td>' +
                                                    'Purchase</td><td><strong>' +
                                                    ui.item
                                                    .PurchOrder +
                                                    '</strong>' +
                                                    '</td></tr>';

                                                $('#appendOnPurchasesAnsSalesOrders')
                                                    .append(
                                                        trHTML);
                                            }
                                        });
                                        break;

                                }

                                //appendQtyOnHand
                            }
                        });

                    }
                }); //End of get price
            }
        });

        $('#selling_price').on('keyup', function(ev) {
            //margin
            console.debug($('#costs').val() + '-----' + $('#selling_price').val());
            $('#margin').val(parseFloat(marginCalculator($('#costs').val(), $('#selling_price').val()))
                .toFixed(2));
        });

        function marginCalculator(cost, onCellVal) {
            return (1 - (cost / onCellVal)) * 100;
        }

        $(document).on('keyup keypress', '#margin', function(e) {
            var margin = $(this).closest("tr").find("#margin").val();
            console.debug("Types margin***********************" + margin);
            var cost = $(this).closest("tr").find("#costs").val();
            $("#selling_price").val(parseFloat(marginToPrice(cost, margin)).toFixed(2));
        });

        function marginToPrice(cost, margin) {
            return (cost / (1 - (margin / 100)));
        }

        ///
    });
</script>

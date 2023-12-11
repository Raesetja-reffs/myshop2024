<div class="row mt-3" id="afterFilter">
    <div class="col-lg-12">
        <div class="card smaller-card">
            <div class="card-header p-5">
                <h3 class="card-title">Product Lines</h3>
                <div class="card-toolbar">
                    <button id="addLine" class="btn btn-primary btn-sm mb-1 mb-sm-0 me-1">Add Line</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive scroll h-400px">
                    <table id ="tblCreateNewSpecial" class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Description</th>
                                <th>DtFrom</th>
                                <th>DtTo</th>
                                <th>Price</th>
                                <th>Cost</th>
                                <th>Current GP</th>
                                <th>Cost Created</th>
                                <th>Available</th>
                                <th>Instock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button id="doneCreating" class="btn btn-success btn-sm me-3">Done</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        generateALine2();
        $('#addLine').click(function() {
            generateALine2();
        });
        $(document).on('click', '.delete_table_row', function(e) {
            $(this).closest('tr').remove();
        });
        $(document).on('click keyup', 'input.prodDescription_, input.theProductCode_', function(e) {
            // $('input').click(function(){
            var ID = $(this).attr('id');
            var jID = '#' + ID;
            var x = ID.indexOf("_");
            var get_token_number = ID.substring(x + 1, ID.length);

            if ($(this).hasClass("prodDescription_") && $(this).hasClass("set_autocomplete")) {
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
                $("" + jID + "").mcautocomplete({
                    source: function(req, response) {
                        var re = $.ui.autocomplete.escapeRegex(req.term);
                        var matcher = new RegExp("^" + re, "i");
                        response($.grep(finalDataProductDescription, function(item) {
                            return matcher.test(item.value);
                        }));
                    },
                    columns: columnsD,
                    autoFocus: true,
                    minlength: 2,
                    delay: 0,
                    multiple: true,
                    multipleSeparator: ",",
                    select: function(e, ui) {
                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);

                        if (ui.item.PastelCode == "MISC2" || ui.item.PastelDescription ==
                            "MISC - NOTE" || ui.item.PastelDescription == "MISC" || ui.item
                            .PastelCode == "misc") {
                            $('#prodQty_' + token_number).val('0');
                            $('#prodPrice_' + token_number).val('0');
                        }
                        $('#prodDescription_' + token_number).val(ui.item
                            .PastelDescription);
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);

                        $('#taxCode' + token_number).val(ui.item.Tax);
                        $('#cost_' + token_number).val(ui.item.Cost);
                        $('#instock' + token_number).val(ui.item.QtyInStock);
                        $('#available' + token_number).val(ui.item.Available);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });

                    }
                });

            }

            if ($(this).hasClass("theProductCode_") && $(this).hasClass("set_autocomplete")) {
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
                $("" + jID + "").mcautocomplete({
                    //source: finalDataProduct,
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

                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        if (ui.item.PastelCode == "MISC2" || ui.item.PastelDescription ==
                            "MISC - NOTE" || ui.item.PastelDescription == "MISC" || ui.item
                            .PastelCode == "misc") {
                            $('#prodQty_' + token_number).val('0');
                            $('#prodPrice_' + token_number).val('0');
                        }
                        $('#prodDescription_' + token_number).val(ui.item
                            .PastelDescription);
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                        //checkIfOrderHasMultipleProducts(ui.item.extra,token_number);
                        //$('#inStock_' + token_number).val(ui.item.QtyInStock);
                        $('#taxCode' + token_number).val(ui.item.Tax);
                        $('#cost_' + token_number).val(ui.item.Cost);

                        $('#instock' + token_number).val(ui.item.QtyInStock);
                        $('#available' + token_number).val(ui.item.Available);
                        // $('#prodQty_' + token_number).attr('title', 'In Stock ' + parseFloat(ui.item.QtyInStock).toFixed(3));

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });

                    }

                });
            }
            //calculator();
        });

        $(document).on('click', '#doneCreating', function(e) {
            $(".general-loader").show();
            var productsLinesOnPicking = new Array();
            $('#tblCreateNewSpecial > tbody  > tr').each(function() {
                // var data = $(this);
                // var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                if (($(this).closest('tr').find('.theProductCode_').val()).length > 0 && ($(
                        this).closest('tr').find('.prodDescription_').val()).length > 0) {
                    productsLinesOnPicking.push({
                        'productCode': $(this).closest('tr').find('.theProductCode_')
                            .val(),
                        'desc': $(this).closest('tr').find('.prodDescription_').val(),
                        'price': $(this).closest('tr').find('.prodPrice_').val(),
                        'dateFrom': $(this).closest('tr').find('.dateFrom').val(),
                        'dateTo': $(this).closest('tr').find('.dateTo').val(),
                        'cost_': $(this).closest('tr').find('.cost_').val(),
                        'gp_': $(this).closest('tr').find('.gp_').val(),
                        'costCreated_': $(this).closest('tr').find('.costCreated_')
                            .val()
                    });
                }
            });
            $.ajax({
                url: '{!! url('/createGroupSpecials') !!}',
                type: "POST",
                data: {
                    customerCode: $('#inputCustAcc').val(),
                    orderDetails: productsLinesOnPicking,
                    contractDateFrom: $('#dateFrom').val(),
                    contractDateTo: $('#dateTo').val()
                },
                success: function(data) {
                    var dialog = $('<p>Done</p>').dialog({
                        height: 200,
                        width: 700,
                        modal: true,
                        containment: false,
                        buttons: {
                            "OKAY": {
                                text: "OKAY",
                                class: "btn btn-success btn-sm",
                                click: function() {
                                    dialog.dialog('close');
                                    location.reload(true);
                                    // $('#submitFiltersOnCustSpecial').click();
                                }
                            }
                        }
                    });
                }
            })
            .always(function() {
                $(".general-loader").hide();
            });
        });
    });
</script>

<div class="row mt-3" id="afterFilter">
    <div class="col-lg-12">
        <div class="card smaller-card">
            <div class="card-header p-5">
                <h3 class="card-title">Overall Specials</h3>
                <div class="card-toolbar d-flex align-items-center">
                    <div id="specialslink"></div>
                    <select id="specialType" class="form-control form-select me-1" style="width: 150px;">
                        @foreach($overallspecialtypes as $val)
                            <option value="{{$val->intOverallSpecialTypeId}}">
                                {{$val->strOverallSpecialType}}
                            </option>
                        @endforeach
                    </select>
                    <select id="locations" class="form-control form-select me-1" style="width: 80px;">
                        @foreach($locations as $val)
                            <option value="{{$val->ID}}">
                                {{$val->Warehouse}}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-success btn-sm mb-1 mb-sm-0 me-1" id="addLine">Add Line</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive scroll h-200px">
                    <table id ="tblCreateNewSpecial" class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Description</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Price</th>
                                <th>Cost</th>
                                <th>Curr GP</th>
                                <th>Cost Created</th>
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
    <div class="col-lg-12">
        <div class="card smaller-card">
            <div class="card-header p-5">
                <h3 class="card-title">Current Specials</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive scroll h-200px">
                    <table id ="tblCreatedCustomerSpecials" class="table table-bordered table-condensed">
                        <thead>
                            <tr>
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
                                <td>Special Type</td>
                                <td>Location</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#addLine').click(function(){
            generateALine2();
        });
        $(document).on('click', '.delete_table_row', function(e) {
            $(this).closest('tr').remove();
        });
        $(document).on('click keyup', 'input.prodDescription_, input.theProductCode_', function(e) {
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
                /*  source: function(req, response) {
                        var re = $.ui.autocomplete.escapeRegex(req.term);
                        var matcher = new RegExp("^" + re, "i");
                        response($.grep(finalDataProductDescription, function(item) {
                            return matcher.test(item.value);
                        }));
                    },*/
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
                    /*source: function(req, response) {
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

                    }

                });
            }
            //calculator();
        });
        $(document).on('click', '#doneCreating', function(e) {
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
                        'costCreated_': $(this).closest('tr').find('.costCreated_').val(),
                        'specialType': $('#specialType').val(),
                        'locations': $('#locations').val()
                    });
                }
            });
            $.ajax({
                url: '{!!url("/createOverallSpecials")!!}',
                type: "POST",
                data: {
                    customerCode: 99,
                    orderDetails: productsLinesOnPicking,
                    contractDateFrom:$('#dateFrom').val(),
                    contractDateTo:$('#dateTo').val()
                },
                success: function (data) {
                    var dialog = $('<p>Done</p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": {
                                text: "OKAY",
                                class: "btn btn-success btn-sm",
                                click: function() {
                                    dialog.dialog('close');
                                    $('#submitFiltersOnCustSpecial').click();
                                }
                            }
                        }
                    });
                }
            });
        });
    });
</script>

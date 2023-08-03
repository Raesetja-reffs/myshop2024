<div id="copyOrdersMenu" title="Copy Order" style="background-color: #F1F1F2;">

    <div id="orderinfoAddress">
        <div class="card mb-3">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="custDescToCopyFrom">Cust Desc</label>
                            <input type="text" class="form-control auto-complete-off" name="custDescToCopyFrom" id="custDescToCopyFrom">
                        </div>
                        <div class="col-md-2">
                            <label for="custCodeToCopyFrom">Cust Code</label>
                            <input type="text" name="custCodeToCopyFrom" class="form-control auto-complete-off" id="custCodeToCopyFrom">
                        </div>
                        <div class="col-md-3">
                            <label for="orderIdToCopy">Order Id</label>
                            <select class="form-control form-select" id="orderIdToCopy">
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="orderDateToCopy">Order Date</label>
                            <input type="text" name="orderDateToCopy" class="form-control" id="orderDateToCopy">
                        </div>
                        <div class="col-md-2">
                            <label for="delvDateToCopy">Delv Date</label>
                            <input type="text" name="delvDateToCopy" class="form-control" id="delvDateToCopy">
                        </div>
                        <div class="col-md-1">
                            <!--<button type="button" id="doAuthcrLimit" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;display:none">Go</button>-->
                            <button type="button" id="doAuthcrLimit2" class="btn btn-success btn-sm mt-md-6" style="display:none">Go</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="tableOrdersDetailsToCopy">
                            <thead>
                                <th>Item Code</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Comment</th>
                                <th>Select</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button id="doneDetailsToCopy" class="btn btn-success btn-sm">Done Selecting</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3" id="orderinfo">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 d-flex mb-3">
                    <h4>Select customer to copy orders to</h4>
                    <button class="btn btn-warning btn-sm ms-3" id="addCustomer">Add New Line</button>
                </div>
                <div class="col-md-12" style="height:300px;overflow-y: auto">
                    <table class="table table-bordered table-condensed table-hover" id="customerToPick">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Customer Name</th>
                                <th>Delivery Address</th>
                                <th>Order Types</th>
                                <th>Order Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-success btn-sm" id="startCopying">Start Copying</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#copyOrdersBtn').hide();
        //copy the order
        $(document).on('click', '#copyOrdersBtn', function(e) {
            var valuesObject = new Array();
            var today = new Date();
            var dt_to = $.datepicker.formatDate('dd-mm-yy', new Date());
            $("#orderDateToCopy").val(dt_to);
            $("#delvDateToCopy").val(dt_to);
            $("#orderDateToCopy").datepicker({
                changeMonth: true, //this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: "dd-mm-yy"

            });
            $("#delvDateToCopy").datepicker({
                changeMonth: true, //this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: "dd-mm-yy"

            });
            appenOderIds('#orderIdToCopy', '{!! url('/getAllOrderIDs') !!}');
            setTimeout(() => {
                $('#orderIdToCopy').val($("#orderIdToCopy").val()).trigger('change');
            }, 2000);

            $('#copyOrdersMenu').show();
            $("#copyOrdersMenu").dialog({
                height: 700,
                modal: true,
                width: '90%',
                containment: false
            }).dialogExtend({
                "closable": true, // enable/disable close button
                "maximizable": false, // enable/disable maximize button
                "minimizable": true, // enable/disable minimize button
                "collapsable": true, // enable/disable collapse button
                "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                "titlebar": false, // false, 'none', 'transparent'
                "minimizeLocation": "right", // sets alignment of minimized dialogues
                "icons": { // jQuery UI icon class
                    "close": "ui-icon-circle-close",
                    "maximize": "ui-icon-circle-plus",
                    "minimize": "ui-icon-circle-minus",
                    "collapse": "ui-icon-triangle-1-s",
                    "restore": "ui-icon-bullet"
                },
                "load": function(evt, dlg) {}, // event
                "beforeCollapse": function(evt, dlg) {}, // event
                "beforeMaximize": function(evt, dlg) {}, // event
                "beforeMinimize": function(evt, dlg) {}, // event
                "beforeRestore": function(evt, dlg) {}, // event
                "collapse": function(evt, dlg) {}, // event
                "maximize": function(evt, dlg) {}, // event
                "minimize": function(evt, dlg) {}, // event
                "restore": function(evt, dlg) {} // event
            });
            //autoCompleteOnCustomerToCopyOrderTo();
            //CustomerLineGenerator();
            $('#addCustomer').on('click', function() {
                CustomerLineGenerator();
                autoCompleteOnCustomerToCopyOrderTo();

            });

            //
            $("#custCodeToCopyFrom").autocomplete({
                source: '{!! url('/custCode') !!}',
                minlength: 2,
                autoFocus: true,
                select: function(e, ui) {
                    if (!ui.item) {
                        $(event.target).val("");
                    } else {
                        $('#custCodeToCopyFrom').val(ui.item.value);
                        $('#custDescToCopyFrom').val(ui.item.extra);
                        appenOderIdsOfCustomer('#orderIdToCopy', '{!! url('/getCustomerOrderId') !!}', ui.item.value)
                    }
                },
                focus: function(event, ui) {
                    return false;
                }
            }).data("ui-autocomplete")._renderItem = function(ul, item) {
                var table =
                    '<table class="table2" ><tr style="font-size: 12px;color:black"><td style="background: green;width:25px;color:white">' +
                    item.value + '</td><td>' +
                    item.extra + '</td></tr></table>';
                return $("<li>")
                    .data("ui-autocomplete-item", item)
                    .append("<a>" + table + "</a>")
                    .appendTo(ul);
            };

            $("#custDescToCopyFrom").autocomplete({
                source: '{!! url('/custDescription') !!}',
                minlength: 2,
                autoFocus: true,
                select: function(e, ui) {
                    if (!ui.item) {
                        $(event.target).val("");
                    } else {
                        $('#custCodeToCopyFrom').val(ui.item.extra);
                        $('#custDescToCopyFrom').val(ui.item.value);
                        appenOderIdsOfCustomer('#orderIdToCopy', '{!! url('/getCustomerOrderId') !!}', ui.item
                            .extra)

                    }

                },
                focus: function(event, ui) {
                    return false;
                }
            }).data("ui-autocomplete")._renderItem = function(ul, item) {
                var table =
                    '<table class="table2"><tr style="font-size: 12px;color:black"><td style="background: green;width:25px;color:white">' +
                    item.extra + '</td><td>' +
                    item.value + '</td></tr></table>';
                return $("<li>")
                    .data("ui-autocomplete-item", item)
                    .append("<a>" + table + "</a>")
                    .appendTo(ul);
            };
            $('#startCopying').hide();
            $("#orderIdToCopy").on("change", function() {
                $.ajax({
                    url: '{!! url('/onCheckOrderHeaderDetails') !!}',
                    type: "POST",
                    data: {
                        orderId: this.value
                    },
                    success: function(data) {
                        var trHTML = "";
                        $('.remthisLine').remove();

                        $.each(data, function(key, value) {
                            trHTML += `
                                <tr class="remthisLine">
                                    <td>${value.PastelCode}</td>
                                    <td>${value.PastelDescription}</td>
                                    <td style="text-align: center;background: blue;color: white;" contenteditable="true">
                                        ${parseFloat(value.Qty).toFixed(2)}
                                    </td>
                                    <td>${parseFloat(value.Price).toFixed(2)}</td>
                                    <td contenteditable="true"></td>
                                    <td>
                                        <input type="checkbox" class="checkedOrderLine custom-checkbox-sm" name="case[]">
                                    </td>
                                </tr>
                            `;
                        });
                        $('#tableOrdersDetailsToCopy tbody').append(trHTML);


                        $('#doneDetailsToCopy').on('click', function() {
                            $('#startCopying').show();
                            var values = new Array();
                            $.each($("input[name='case[]']:checked"),
                                function() {
                                    var data = $(this).parents('tr:eq(0)');
                                    values.push({
                                        'desc': $(data).find('td:eq(1)')
                                            .text(),
                                        'code': $(data).find('td:eq(0)')
                                            .text(),
                                        'qty': $(data).find('td:eq(2)')
                                            .text(),
                                        'price': $(data).find('td:eq(3)')
                                            .text(),
                                        'priceInc': $(data).find('td:eq(4)')
                                            .text(),
                                        'comment': $(data).find('td:eq(5)')
                                            .text()
                                    });
                                });
                            console.debug(values);
                            valuesObject = values;
                            //console.debug(valuesObject);

                        });
                    }
                });

            });
            $('#startCopying').click(function() {
                arrayOfCustomerToCopyTo(valuesObject, $('#orderDateToCopy').val(), $('#delvDateToCopy').val());
            });

        });
    });
    function CustomerLineGenerator() {
        var tokenId = new Date().valueOf();
        var $row = $(`
            <tr id="new_row_ajax${tokenId}" class="fast_remove">
                <td contenteditable="false">
                    <input name="theCustCode" id="theCustCode_${tokenId}" class="theCustCode_ set_autocomplete form-control">
                </td>
                <td contenteditable="false">
                    <input name="theCustDescription_" id="theCustDescription_${tokenId}" class="theCustDescription_ set_autocomplete form-control">
                </td>
                <td contenteditable="false" class="col-md-3">
                    <select name="delAddress_" id ="delAddress_${tokenId}" class="delAddress_ resize-input-inside form-control form-select">
                    </select>
                </td>
                <td contenteditable="false" class="col-md-3">
                    <select name="delType_" id ="delType_${tokenId}" class="delType_ resize-input-inside form-control form-select">
                    </select>
                </td>
                <td contenteditable="false">
                    <input type="text" name="orderNumber_" id ="orderNumber_${tokenId}" class="orderNumber_ resize-input-inside form-control lst">
                </td>
                <td>
                    <button type="button" id="cancelThisCustomer" class="btn btn-danger btn-sm cancel">
                        Cancel
                    </button>
                </td>
            </tr>
        `);
        $('#customerToPick tbody').append($row);
        getOrderTypes('#delType_' + tokenId, '{!! url('/deliveryTypes') !!}');
        $('#delvDate_' + tokenId).datepicker({
            changeMonth: true, //this option for allowing user to select month
            changeYear: true //this option for allowing user to select from year range
        });
    }
    function autoCompleteOnCustomerToCopyOrderTo() {
        $('input').on('click keyup', function() {
            var ID = $(this).attr('id');
            var jID = '#' + ID;
            console.debug(jID);

            var x = ID.indexOf("_");
            var get_token_number = ID.substring(x + 1, ID.length);
            if ($(this).hasClass("delvDate_")) {
                //alert("i am here");
                /* $("" + jID + "").datepicker({
         changeMonth: true,//this option for allowing user to select month
         changeYear: true //this option for allowing user to select from year range
         });*/
            }
            if ($(this).hasClass("theCustCode_") && $(this).hasClass("set_autocomplete")) {
                $("" + jID + "").autocomplete({
                    source: function(request, response) {
                        $.getJSON("{!! url('/custCode') !!}", {
                                term: request.term
                            },
                            response);
                    },
                    minlength: 2,
                    autoFocus: true,
                    select: function(e, ui) {
                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        $('#theCustCode_' + token_number).val(ui.item.value);
                        $('#theCustDescription_' + token_number).val(ui.item.extra);
                        getCustomerAddress('#delAddress_' + token_number,
                            '{!! url('/selectCustomerMultiAddress') !!}', ui.item.value);

                    }
                });

            }
            if ($(this).hasClass("theCustDescription_") && $(this).hasClass("set_autocomplete")) {
                $("" + jID + "").autocomplete({
                    source: function(request, response) {
                        $.getJSON("{!! url('/custDescription') !!}", {
                                term: request.term
                            },
                            response);
                    },
                    minlength: 2,
                    autoFocus: true,
                    select: function(e, ui) {
                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        $('#theCustCode_' + token_number).val(ui.item.extra);
                        $('#theCustDescription_' + token_number).val(ui.item.value);
                        getCustomerAddress('#delAddress_' + token_number,
                            '{!! url('/selectCustomerMultiAddress') !!}', ui.item.extra);
                    }
                });
            }
        });
    }
    function getCustomerAddress(tag, url, CustomerCode) {
        $.ajax({
            url: url,
            type: "Post",
            data: {
                customerCode: CustomerCode
            },
            success: function(data) {
                var toAppend = '';
                toAppend += '<option value=""></option>';
                $.each(data, function(i, o) {

                    toAppend += '<option value="' + o.DeliveryAddressId +
                        '"><table><tr><td style="background: green">' + o.DeliveryAddressId +
                        ' </td>|' + o.DAddress1 + "|" + o.DAddress2 + "|" + o.DAddress3 + "|" + o
                        .DAddress4 + "|" + o.DAddress5 + '</tr></table></option>';
                });
                $(tag).append(toAppend);
            }
        });
    }
    function arrayOfCustomerToCopyTo(productsObject, orderDate, DelvDate) {
        var theCustCode_ = [];
        var theCustDescription_ = [];
        var delvDate_ = [];
        var delAddress_ = [];
        var delAddressText_ = [];
        var orderNumber_ = [];
        var delType_ = [];
        var objectTable = [];
        var i = 0;
        $('#customerToPick tr').each(function() {

            var theCustCode_v = [];
            var theCustDescription_v = [];
            var delvDate_v = [];
            var delAddress_v = [];
            var delAddressText_v = [];
            var orderNumber_v = [];
            var delType_v = [];
            var valueobjectTable = [];

            $(this).find(".theCustCode_").each(function() {
                theCustCode_v.push($(this).val());
                valueobjectTable["theCustCode_"] = $(this).val();
            });
            $(this).find(".theCustDescription_").each(function() {
                theCustDescription_v.push($(this).val());
                valueobjectTable["theCustDescription_"] = $(this).val();
            });

            $(this).find(".delAddress_").each(function() {
                delAddress_v.push($(this).val());
                delAddressText_v.push($(this).text());
                valueobjectTable["delAddress_"] = $(this).val();
                valueobjectTable["delAddressText_"] = $(this).text();
            });
            $(this).find(".orderNumber_").each(function() {
                orderNumber_v.push($(this).val());
                valueobjectTable["orderNumber_"] = $(this).val();
            });
            $(this).find(".delType_").each(function() {
                delType_v.push($(this).val());
                valueobjectTable["delType_"] = $(this).val();
            });

            theCustCode_.push(theCustCode_v);
            theCustDescription_.push(theCustDescription_v);
            delvDate_.push(delvDate_v);
            delAddress_.push(delAddress_v);
            delAddressText_.push(delAddressText_v);
            orderNumber_.push(orderNumber_v);
            delType_.push(delType_v);

            if ((theCustCode_v[0]) != 0 && (theCustDescription_v[0]) != 0) {
                objectTable[i] = valueobjectTable;
                i = i + 1;
            } else {

            }

        });
        $('#copyingOrderProgress').show();
        showDialog('#copyingOrderProgress', '35%', 400);
        for (var i = 0; i < objectTable.length; i++) {
            $.ajax({
                url: '{!! url('/copyOrdersToCustomers') !!}',
                type: "POST",
                data: {
                    theCustCode_: objectTable[i]['theCustCode_'],
                    delvDate_: DelvDate,
                    orderDate: orderDate,
                    delAddress_: objectTable[i]['delAddress_'],
                    delAddressText_: objectTable[i]['delAddressText_'],
                    orderNumber_: objectTable[i]['orderNumber_'],
                    delType_: objectTable[i]['delType_'],
                    productsObject: productsObject
                },
                success: function(data) {

                    $('#copyingOrderProgress').append(data.custCode + " - " + data.orderId + '<br>');

                }
            });

        }
    }
</script>

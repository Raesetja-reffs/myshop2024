<script>
    var jArray = JSON.stringify({!! json_encode($products) !!});
    var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('focus', ':input', function() {
        $(this).attr('autocomplete', 'off');
    });
    var finalDataProduct = $.map(JSON.parse(jArray), function(item) {
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
    var finalDataProductDescription = $.map(JSON.parse(jArray), function(item) {
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
    var finalData = $.map(JSON.parse(jArrayCustomer), function(item) {

        return {
            GroupName: item.GroupName,
            GroupId: item.GroupId,
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

        var inputGroupAccount = $('#inputCustName').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain: true,
            focusFirstResult: true,
            visibleProperties: ["GroupId", "GroupName"],
            searchIn: 'GroupName',
            data: finalData
        });
        inputGroupAccount.on('select:flexdatalist', function(event, data) {

            $('#inputCustAcc').val(data.GroupId);
            $('#inputCustName').val(data.GroupName);
        });

        $('#bulkediting').click(function() {

            var inputCustAcc = $('#inputCustAcc').val();
            var dateFrom = $('#dateFrom').val();
            var dateTo = $('#dateTo').val();
            window.open('{!! url('/getgroupspecialbulkeditingLandingage') !!}/' + inputCustAcc + "/" + dateFrom + "/" + dateTo,
                inputCustAcc, "location=1,status=1,scrollbars=1, width=1200,height=850");

        });
        $('#addLine').click(function() {

            generateALine2();
        });
        generateALine2();

        $(".dateTo").datepicker({
            changeMonth: true, //this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $("#specialdateext,#specialdateextTo").datepicker({
            changeMonth: true, //this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });
        $("#dateFrom,#dateTo,#specialFrom,#specialTo").datepicker({
            changeMonth: true, //this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $('#tblCreateNewSpecial').on('click', 'button', function(e) {
            var $this = $(this);
            $this.closest('tr').remove();
        });

        $('#doneCreating').click(function() {
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
                            "OKAY": function() {
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

        $('#pleaseAddNewCust').click(function() {
            window.open('{!! url('/addNewGroupSpecial') !!}', "newGroupSpecial",
                "width=1500, height=800, scrollbars=yes");
        });
    });

    function generateALine2() {
        var tokenId = Math.floor(Math.pow(10, 9 - 1) + Math.random() * 9 * Math.pow(10, 9 - 1));
        var $row = $('<tr id="new_row_ajax' + tokenId +
            '" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
            '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_' + tokenId +
            '" class="theProductCode_ set_autocomplete inputs"></td>' +
            '<td contenteditable="false" class="col-md-4"><input name="prodDescription_" id ="prodDescription_' +
            tokenId + '" class="prodDescription_ set_autocomplete inputs" tabindex="-1"></td>' +
            '<td  contenteditable="false" class="col-md-2"><input type="text" name="dateFrom" id ="dateFrom' +
            tokenId + '"   title="in stock" class="dateFrom resize-input-inside inputs"></td>' +
            '<td contenteditable="false" class="col-md-2"><input type="text" name="dateTo"  id ="dateTo' + tokenId +
            '" class="dateTo resize-input-inside"></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_' +
            tokenId +
            '" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="cost_" id ="cost_' + tokenId +
            '" onkeypress="return isFloatNumber(this,event)" class="cost_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" readonly ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="gp_" id ="gp_' + tokenId +
            '" onkeypress="return isFloatNumber(this,event)" class="gp_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" readonly></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="costCreated_" id ="costCreated_' +
            tokenId +
            '" onkeypress="return isFloatNumber(this,event)" class="costCreated_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" readonly></td>' +
            '<td><button type="button" id="cancelThis" class="btn-danger btn-xs cancel" style="height: 16px;padding: 0px 5px;font-size: 9px;">Cancel</button></td></tr>'
        );
        $('#tblCreateNewSpecial tbody')
            .append($row)
            .trigger('addRows', [$row, false]);
        if (!$('.lst').is(":focus")) {
            $('#prodCode_' + tokenId).focus();

            if ($('#checkboxDescription').is(':checked')) {
                $('#prodDescription_' + tokenId).focus();
            }
        }


        $('input').on('click keyup', function() {
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
        $(".dateTo,.dateFrom").datepicker({
            changeMonth: true, //this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $('#tblCreateNewSpecial').on('click', 'button', function(e) {
            var $this = $(this);
            var $thisVal = $(this).val();
            $this.closest('tr').remove();


        });

    }

    function marginCalculator(cost, onCellVal) {
        return ((cost / onCellVal)) * 100;
    }
    $(document).on('keyup', '#specialPrice', function(e) {
        $('#specialGp').val(parseFloat(marginCalculator($('#specialCost').val(), $('#specialPrice').val()))
            .toFixed(2));
    });
    $(document).on('keydown', '#tblCreateNewSpecial', function(e) {
        var $table = $(this);

        var $active = $('input:focus,select:focus,li:focus', $table);
        var $next = null;
        var focusableQuery = 'input:visible,select:visible,textarea:visible,li:visible';
        var position = parseInt($active.closest('td').index()) + 1;
        var $celltheProductCode_ = $active.closest('td').find(".theProductCode_").val();

        switch (e.keyCode) {
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
                        .find(focusableQuery);
                }

                break;
            case 38: // <Up>
                if ($celltheProductCode_.length < 1) {
                    $next = $active
                        .closest('tr')
                        .prev()
                        .find('td:nth-child(' + position + ')')
                        .find(focusableQuery);
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
                        .find(focusableQuery);
                }
                console.debug('$celltheProductCode_******** DOWN' + $celltheProductCode_);
                break;

        }
        if ($next && $next.length) {
            $next.focus();
        }
    });

    $(document).on('keyup', '.prodPrice_', function(e) {
        /*  var key = (e.keyCode ? e.keyCode : e.which);
        var $isAuth = $(this).closest("tr").find(".title").attr("id");
        var $priceToken = $(this).closest("tr").find(".prodPrice_").attr("id");*/

        var costing = $(this).closest("tr").find(".cost_").val();
        var prodPriceVal = $(this).closest("tr").find(".prodPrice_").val();
        $(this).closest("tr").find(".gp_").val(parseFloat(marginCalculator(costing, prodPriceVal)).toFixed(2));


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
        var closesttr = $(this).closest('tr');
        var prodClosest = closesttr.find(".theProductCode_").val();
        var prodDescClosest = closesttr.find(".prodDescription_").val();
        var prodPriceClosest = closesttr.find(".prodPrice_").val();
        if ((code == 34 || code == 13 || code == 39) && $.trim(prodClosest.length) > 0 && prodDescClosest
            .length > 0 && prodPriceClosest.length > 0) {
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

    function showDialog(tag, width, height) {
        $(tag).dialog({
            height: height,
            modal: false,
            width: width,
            containment: false,
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
    }

    function dateReturn(dates) {
        //27-02-2019
        var datearray = dates.split("-");
        if (datearray[0].length > 2) {
            var newdateDelivDate = dates;
        } else {
            var newdateDelivDate = datearray[2] + '-' + datearray[1] + '-' + datearray[0];
        }


        return newdateDelivDate
    }
</script>

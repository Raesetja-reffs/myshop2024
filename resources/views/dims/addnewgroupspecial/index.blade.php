<x-app-layout>

    <x-slot name="header">
        {{ __('Adding New Group Specials') }}
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
            Group Special </li>
        <!--end::Item-->
    </x-slot>

    @include('dims.addnewgroupspecial.partials.searchbar')

    @include('dims.addnewgroupspecial.partials.listing')

    <script>
        var jArray = JSON.stringify({!! json_encode($products) !!});
        var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(xhr) {
                $(".general-loader").show();
            },
            complete: function(xhr, status) {
                $(".general-loader").hide();
            },
            error: function(xhr, status, error) {
                message = error;
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showAlert('danger', message, 10000);
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

            $(".dateTo").datepicker({
                changeMonth: true, //this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: 'dd-mm-yy'
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function(xhr) {
                    $(".general-loader").show();
                },
                complete: function(xhr, status) {
                    $(".general-loader").hide();
                },
                error: function(xhr, status, error) {
                    message = error;
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showAlert('danger', message, 10000);
                }
            });
            //showDialog('#tempDeliveryAddressOnTheFly','50%',250);

            $('#tblCreatedCustomerSpecials').on('click', 'button', function(e) {
                var $this = $(this);
                var $thisVal = $(this).val();
                $.ajax({
                    url: '{!! url('/removeCustomerSpecial') !!}',
                    type: "POST",
                    data: {
                        removeSpecial: $thisVal
                    },
                    success: function(data) {
                        var dialog = $('<p>Special Removed</p>').dialog({
                            height: 200,
                            width: 700,
                            modal: true,
                            containment: false,
                            buttons: {
                                "OKAY": function() {
                                    $this.closest('tr').remove();
                                    dialog.dialog('close');
                                }
                            }
                        });
                    }
                });
            });

            $('#pleaseAddNewCust').click(function() {
                window.open('{!! url('/andNewSpecial') !!}', "newSpecial",
                    "width=800, height=800, scrollbars=yes");
            });
            $('#tblCreatedCustomerSpecials tbody').on('click', 'tr', function(e) {
                $("#tblCreatedCustomerSpecials tbody tr").removeClass('row_selected');
                $(this).addClass('row_selected');
            });
            $('#tblCreatedCustomerSpecials tbody').on('dblclick', 'tr', function(e) {
                $("#tblCreatedCustomerSpecials tbody tr").removeClass('row_selected');
                $(this).addClass('row_selected');
                $('#popUpdateLine').show();
                showDialog('#popUpdateLine', '60%', 450);
                var rowOnOrder = $(this).closest("tr");

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
                $('#updateTheSpecuial').click(function() {
                    $.ajax({
                        url: '{!! url('/updatespeciialLine') !!}',
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
                        success: function(data) {
                            var dialog = $('<p>Updated</p>').dialog({
                                height: 200,
                                width: 700,
                                modal: true,
                                containment: false,
                                buttons: {
                                    "OKAY": function() {
                                        dialog.dialog('close');
                                        $('#popUpdateLine').dialog('close');
                                    }
                                }
                            });
                        }
                    });
                });
            });
        });

        function marginCalculator(cost, onCellVal) {
            return (1 - (cost / onCellVal)) * 100;
        }
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

        function showDialog(tag, width, height) {
            $(tag).dialog({
                height: height,
                modal: false,
                width: width,
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

        function generateALine2() {
            // $( "#table" ).colResizable({ disable : true });
            //calculator();
            var contractFrom = $('#dateFrom').val();
            var contractTo = $('#dateTo').val();
            var tokenId = Math.floor(Math.pow(10, 9 - 1) + Math.random() * 9 * Math.pow(10, 9 - 1));
            var $row = $(`
                <tr id="new_row_ajax${tokenId}" class="fast_remove">
                    <td contenteditable="false">
                        <input name="theProductCode" id ="prodCode_${tokenId}" class="theProductCode_ set_autocomplete inputs form-control" style="width: 100px;">
                    </td>
                    <td contenteditable="false">
                        <input name="prodDescription_" id ="prodDescription_${tokenId}" class="prodDescription_ set_autocomplete inputs form-control" style="width: 300px;">
                    </td>
                    <td contenteditable="false">
                        <input type="text" name="dateFrom" id ="dateFrom${tokenId}" value="${contractFrom}" class="dateFrom resize-input-inside inputs form-control">
                    </td>
                    <td contenteditable="false">
                        <input type="text" name="dateTo" id ="dateTo${tokenId}" value= "${contractTo}" class="dateTo resize-input-inside form-control">
                    </td>
                    <td contenteditable="false">
                        <input type="text" name="prodPrice_" id ="prodPrice_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs form-control" style="font-weight: 800;">
                    </td>
                    <td contenteditable="false">
                        <input type="text" name="cost_" id ="cost_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="cost_ resize-input-inside inputs form-control" style="font-weight: 800;" readonly>
                    </td>
                    <td contenteditable="false">
                        <input type="text" name="gp_" id ="gp_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="gp_ resize-input-inside inputs form-control" style="font-weight: 800;" readonly>
                    </td>
                    <td contenteditable="false">
                        <input type="text" name="costCreated_" id ="costCreated_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="costCreated_ resize-input-inside inputs form-control" style="font-weight: 800;" readonly>
                    </td>
                    <td contenteditable="false">
                        <input type="text" name="available" id ="available${tokenId}" onkeypress="return isFloatNumber(this,event)" class="available resize-input-inside inputs form-control" style="font-weight: 800;" readonly>
                    </td>
                    <td contenteditable="false">
                        <input type="text" name="instock" id ="instock${tokenId}" onkeypress="return isFloatNumber(this,event)" class="instock resize-input-inside inputs form-control" style="font-weight: 800;" readonly>
                    </td>
                    <td class="text-center">
                        <button type="button" id="cancelThis" class="btn btn-icon btn-danger btn-sm btn-sm-icon cancel delete_table_row">
                            <i class="bi bi-trash3-fill fs-4"></i>
                        </button>
                    </td>
                </tr>
            `);

            $('#tblCreateNewSpecial tbody').append($row).trigger('addRows', [$row, false]);
            if (!$('.lst').is(":focus")) {
                $('#prodCode_' + tokenId).focus().click();

                if ($('#checkboxDescription').is(':checked')) {
                    $('#prodDescription_' + tokenId).focus().click();
                }
            }

            $(".dateTo,.dateFrom").datepicker({
                changeMonth: true, //this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: 'dd-mm-yy'
            });
        }
    </script>
</x-app-layout>

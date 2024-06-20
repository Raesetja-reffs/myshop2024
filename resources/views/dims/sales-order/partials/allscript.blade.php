<script>
    $(document).on('focus', ':input', function() {

        $(this).attr('autocomplete', 'off');
    });
    $(document).on('focus', ':input', function() {

        $(this).attr('autocomplete', 'this-is-it');
    });

    $(document).keydown(function(e) {
        if (e.keyCode == 27) return false;
    });

    window.onstorage = event => { // same as window.addEventListener('storage', event => {
        if (event.key == 'onorders') {
            console.debug(event.key + ':' + event.newValue + " at " + event.url);
            let products = JSON.parse(event.newValue);
            console.debug(products);
            if (products.passedorderid != null) {

                if ($('#orderId').val().length < 3) {
                    $('#orderId').val(products.passedorderid);
                    $("#checkOrders").click();
                } else {
                    localStorage.removeItem('openorder');
                    localStorage.setItem('openorder', JSON.stringify({
                        openorderid: $('#orderId').val()
                    }));
                }



            }


        }
        //console.debug(event.key + ':' + event.newValue + " at " + event.url);
    };
    //var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);

    //alert("isChrome"+isChrome);
    //element.autocomplete = isChrome ? 'disabled' :  'off';
    var ismulti = false;
    var reportmarginControl = 'marginType1';
    var booze = '';
    var spool = 0;
    var productSetting = '';
    var finalDataProduct = '';
    var finalDataProductTest = '';
    var wareautocomplete = '';
    var arrayProdCodesCheck = [];
    var arrayProds = [];
    var globalOrderIdToBePushed = [];
    var arrayOfCustomerInfo = [];
    var accounting = "<?php echo config('app.Accounting'); ?>";
    var donotshowAvailable = "<?php echo config('app.donotshowAvailable'); ?>";
    var CompanyMarginApp = "<?php echo config('app.Margin'); ?>";
    var CompanyMargin = "<?php echo config('app.Margin'); ?>";
    var isAllowedToChangeInv = "<?php echo Auth::user() ? Auth::user()->authInvoices : ''; ?>";
    var isAuthMyLine = "<?php echo env('APP_AUTHLINE'); ?>";
    var isAuthPrice = "<?php echo env('APP_AUTH_PRICE'); ?>";
    var hassplitorder = "<?php echo env('SPLITORDER'); ?>";
    var authzerocost = "<?php echo env('AUTHZEROCOST'); ?>";
    var isBlockRouteChanges = "<?php echo env('APP_ROUTECHANGES'); ?>";
    var searchstring = "<?php echo env('STRING_LENGTH'); ?>";
    var isBlockDeliveryTypeChanges = "<?php echo env('APP_DELIVERYTYPE'); ?>";
    var hasBasketAuth = "<?php echo env('APP_BASKET_MARGIN'); ?>";
    var multiLines = "<?php echo Auth::user() ? Auth::user()->intAllowMultiLines : ''; ?>";
    var linediscount = "<?php echo $discountProperty; ?>";
    // console.debug("isAuthMyLine*******"+isAuthMyLine);
    // console.debug("isBlockRouteChanges*******"+isBlockRouteChanges);
    //

    reportmarginControl = JSON.stringify({!! json_encode($margin) !!});
    reportmarginControl = JSON.parse(reportmarginControl);
    // console.debug(reportmarginControl);
    var jArray = JSON.stringify({!! json_encode($products) !!});
    var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
    var jArrayCustomerAll = JSON.stringify({!! json_encode($customersDontcareStatus) !!});
    var jArrayOrderTypes = JSON.stringify({!! json_encode($orderTypes) !!});
    var jArrayLastInserted = JSON.stringify({!! json_encode($LastInserted) !!});
    var jArraydelivDates = JSON.stringify({!! json_encode($delivDates) !!});
    var jArraydelivRoutes = JSON.stringify({!! json_encode($routesNames) !!});
    var jArraytrueOrFalse = JSON.stringify({!! json_encode($trueOrFalse) !!});
    var warehouses = JSON.stringify({!! json_encode($warehouses) !!});
    var ajaxRequests = [];

    // console.debug(jArrayCustomer);
    // var computerName = '<?php echo gethostname(); ?>';
    var computerName = '<?php echo php_uname('n'); ?>';
    var byWho = '<?php echo Auth::user() ? Auth::user()->UserName : ''; ?>';
    $(function() {
        $(document).keydown(function(e) {
            booze = $('#boozeLisence').val();
        });
    });
    $(function() {
        if (($.trim($('#invoiceNo').val())).length > 1) {
            $('#changeDeliveryAddressOnNotInvoiced').hide();
        }

        if (($('#invoiceNo').val()).length < 1 && ($('#orderId').val()).length < 1) {
            $('#changeDeliveryAddressOnNotInvoiced').hide();
        }
    });

    //anonymus function to assign margin report control


    //Dialog = Order Listing Dialog
    function refresh_dialog() {
        $('#dialog').dialog();
    }
    var GlobalcustomerId = '';
    var GlobalRouteId = '';
    var GlobalOrderType = '';
    var datatableOrderPattern = '';
    var datatableGroupSpecials = '';
    var datatableUserActions = '';

    function updateCount() {
        var cs = $(this).val().length;
        $('#characters').text(cs);
    }

    var dataMenuOnRightClick = [
        [{
            text: "Open In New Tab",
            action: function() {
                window.open('{!! url('/callist') !!}');
            }
        }, {
            text: "Open In New Tab",
            action: function() {
                window.open('{!! url('/callist') !!}');
            }
        }]
    ];
    var dataMenuOnRightClickOnOrder = [
        [{
            text: "Choose Option",
            action: function() {

            }
        }, {
            text: "Open In New Tab",
            action: function() {
                window.open('{!! url('/getOnOrder') !!}');
            }
        }, {
            text: "Open In Dialog Mode",
            action: function() {
                window.open('{!! url('/getOnOrder') !!}', "getOnOrder-Dialog",
                    "location=1,status=1,scrollbars=1, width=1200,height=850");

            }
        }]
    ];
    $(document).ready(function() {

        $(document).on('click', '#orederNumber', function(e) {
            e.preventDefault();
            $("#orederNumber").prop("disabled", false);
            $("#orederNumber").removeAttr('disabled');
        });
        $('#orederNumber').click(function() {


            $("#orederNumber").removeAttr('readonly');
        });

        $(function() {
            var pressed = false;
            var start = undefined;
            var startX, startWidth;

            $("table th").mousedown(function(e) {
                start = $(this);
                pressed = true;
                startX = e.pageX;
                startWidth = $(this).width();
                $(start).addClass("resizing");
            });

            $(document).mousemove(function(e) {
                if (pressed) {
                    $(start).width(startWidth + (e.pageX - startX));
                }
            });

            $(document).mouseup(function() {
                if (pressed) {
                    $(start).removeClass("resizing");
                    pressed = false;
                }
            });
        });
        $('#posPayMentTypeCash').select();
        $('#posPayMentTypeCreditCard').select();
        $('#posPayMentTypeAccount').select();
        $('#posPayMentTypeCheque').select();
        $('#treatAsQuote').change(function() {
            if ($('#treatAsQuote').is(':checked')) {
                treatAsQuote(1);
            } else {
                alert("NOT A QUOTATION ANYMORE");
                treatAsQuote(0);
            }
        });

        $.each(JSON.parse(jArraytrueOrFalse), function(i, o) {
            switch (o.ReportType) {
                case "Allow Duplicate Products On Ordering":
                    productSetting = o.ReportName;
                    break;
            }
        });
        $.each(JSON.parse(jArrayLastInserted), function(i, o) {
            var Odate = new Date(o.OrderDate);

            var newODate = $.datepicker.formatDate('dd-mm-yy', new Date(Odate));
            var Ddate = new Date(o.DeliveryDate);
            var newDDate = $.datepicker.formatDate('dd-mm-yy', new Date(Ddate));
            $('#inputOrderDate').val(newODate);
            $('#inputDeliveryDate').val(newDDate);
            $('#submitFilters').prop('disabled', false);
        });
        var toAppendOrderTypes = '';
        // var toAppendOrderTypes = '';
        $.each(JSON.parse(jArrayOrderTypes), function(i, o) {
            toAppendOrderTypes += '<option value="' + o.OrderTypeId + '">' + o.OrderType + '</option>';
        });
        $('#orderType').append(toAppendOrderTypes);
        $('#orderTypesTabletLoading').append(toAppendOrderTypes);
        var toAppenddelvdates = '';
        $.each(JSON.parse(jArraydelivDates), function(i, o) {
            toAppenddelvdates += '<option value="' + o.DeliveryDate + '">' + o.DeliveryDate +
                '</option>';
        });
        $('#deliveryDates').append(toAppenddelvdates);
        var toAppendRoutes = '';
        $.each(JSON.parse(jArraydelivRoutes), function(i, o) {
            toAppendRoutes += '<option value="' + o.Routeid + '">' + o.Route + '</option>';
        });
        $('#generalRouteForNewDeliveryAddress').append(toAppendRoutes);
        //  $('#routeToFilterWith').append(toAppendRoutes);
        $('#rouTabletLoadingtes').append(toAppendRoutes);
        $('#AddressAddSelect').append(toAppendRoutes);
        $('#assignRouteOnTheFlyDropDown').append(toAppendRoutes);
        //,'PurchOrder','UnitWeight','SoldByWeight','strBulkUnit'
        finalDataProduct = $.map(JSON.parse(jArray), function(item) {
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
                UnitWeight: item.UnitWeight,
                SoldByWeight: item.SoldByWeight,
                strBulkUnit: item.strBulkUnit,
                Available: parseFloat(item.Available).toFixed(2),
                ProductId: item.ProductId
            }

        });
        wareautocomplete = $.map(JSON.parse(warehouses), function(item) {
            return {
                ID: item.ID,
                Warehouse: item.Warehouse

            }

        });

        finalDataProductTest = $.map(JSON.parse(jArray), function(item) {
            return {
                value: item.PastelDescription,
                PastelCode: item.PastelCode,
                PastelDescription: item.PastelDescription,
                UnitSize: item.UnitSize,
                Tax: item.Tax,
                Cost: item.Cost,
                QtyInStock: item.QtyInStock,
                Margin: item.Margin,
                Alcohol: item.Alcohol,
                UnitWeight: item.UnitWeight,
                SoldByWeight: item.SoldByWeight,
                strBulkUnit: item.strBulkUnit,
                Available: parseFloat(item.Available).toFixed(2),
                ProductId: item.ProductId
            }

        });

        var finalData = $.map(JSON.parse(jArrayCustomer), function(item) {

            return {
                BalanceDue: item.BalanceDue,
                CustomerPastelCode: item.CustomerPastelCode,
                StoreName: item.StoreName,
                UserField5: item.UserField5,
                CustomerId: item.CustomerId,
                CreditLimit: item.CreditLimit,
                Email: item.Email,
                Routeid: item.Routeid,
                Discount: item.Discount,
                OtherImportantNotes: item.OtherImportantNotes,
                Routeid: item.Routeid,
                strRoute: item.strRoute,
                mnyCustomerGp: item.mnyCustomerGp,
                Warehouse: item.Warehouse,
                ID: item.ID,
                CustomerOnHold: item.CustomerOnHold,
                termsAndList: item.termsAndList
            }

        });
        var finalDataAll = $.map(JSON.parse(jArrayCustomerAll), function(item) {

            return {
                BalanceDue: item.BalanceDue,
                CustomerPastelCode: item.CustomerPastelCode,
                StoreName: item.StoreName,
                UserField5: item.UserField5,
                CustomerId: item.CustomerId,
                CreditLimit: item.CreditLimit,
                Email: item.Email,
                Routeid: item.Routeid,
                Discount: item.Discount,
                OtherImportantNotes: item.OtherImportantNotes,
                Routeid: item.Routeid,
                strRoute: item.strRoute,
                mnyCustomerGp: item.mnyCustomerGp,
                Warehouse: item.Warehouse,
                ID: item.ID,
                CustomerOnHold: item.CustomerOnHold,
                termsAndList: item.termsAndList
            }

        });

        //console.debug(getCustomers);
        $('body').tipPop({
            type: 'all' // listen on focus and hover events, it's default value
        });
        /* $('#table').sortable({
            containerSelector: 'table',
            itemPath: '> tbody',
            itemSelector: 'tr',
            placeholder: '<tr class="placeholder"/>'
        });*/

        $('input,textarea').attr('autocomplete', 'off');

        $('#orederNumber').keyup(updateCount);
        $('#orederNumber').keydown(updateCount);
        $('#creditLimitApproved').val('');
        $('#authorisations').hide();
        //getTheLastInsertedDeliveryDate();
        $('#dialog').hide(); //Dialog
        $('#dialog2').hide(); //Dialog
        $('#listOfDelivAdress').hide(); //Dialog
        $('#customDeliveeryAddress').hide(); //Dialog
        $('#tabletLoading').hide();
        $('#tabletLoadingDocDetails').hide();
        $('#changeDeliveryAddress').hide();
        $('#copyOrderDialog').hide();
        $('#copyOrderDialogComfirmation').hide();
        $('#custLookUp').hide();
        $('#extrasononrder').hide();
        $('#reprintAuth').hide();
        $('#copyOrdersMenu').hide();
        $('#multipleDeliveriesOnTheSameDate').hide();
        $('#copyingOrderProgress').hide();
        $('#reprintInvoice').hide();
        $('#prodOnOrder').hide();
        $('#prodonInvoice').hide();
        $('#dispatchQuantityForm').hide();
        $('#priceLookPriceWithCustomer').hide();
        $('#pointOfSaleDialog').hide();
        $('#posCashUp').hide();
        $('#authDropDowns').hide();
        $('#prohibitedProductAuth').hide();
        $('#authDiscount').hide();
        $('#theCustomerNotes').hide();
        $('#assignRouteOnTheFly').hide();
        $('#popTransaction').hide();
        $('#popLessStock').hide();
        $('#popZeroStock').hide();
        //$('#edit_row').hide();
        $('#authDropDownsClosedRoutePass').hide(); //authFinishOrder
        $('#createOrderOnCallList').hide();
        $('#copyOrdersBtn').hide();
        $('#emailDoc').hide();
        $('#splitOrder').hide();
        $('#exceeded').hide();
        $('#qtyzero').hide();
        $('#MarginProblems').hide();
        $('#processingpos').hide();
        $('#generaldialog').hide();
        $('#deleteAllLines').hide();
        $('#checkdeliverydate').hide();
        $('#ZeroPrice').hide();
        $('#authonholdaccount').hide();
        $('#addcostdialog').hide();
        $('#authItemsWithzerocosts').hide();
        $('#itemoutofstock').hide();
        $('#itemseithzeropricing').hide();


        if (isBlockDeliveryTypeChanges.length > 4) {
            $("#orderType").prop('disabled', 'disabled');
        }




        var otable = ''; // Order Listing Table
        var productsOnOrders = ''; // products On Order

        var callListTable2 = ''; //Call List Table
        //test

        $('#salesQuotebtn').click(function() {
            window.open('{!! url('/salesquote') !!}');
        });
        $('#copythisorder').click(function() {
            window.open('{!! url('/copyorder') !!}/' + $('#orderId').val(), "copyorder",
                "location=1,status=1,scrollbars=1, width=1200,height=850");

        });

        $('#returns').click(function() {
            window.open('{!! url('/salesquote') !!}');
        });
        $('#reports').click(function() {
            window.open('{!! url('/reports') !!}');
        });
        $('#routePlanning').click(function() {
            window.open('{!! url('/routeplanner') !!}');
        });

        //
        $("#callList").contextMenu(dataMenuOnRightClick);
        $("#salesOnOrder").contextMenu(dataMenuOnRightClickOnOrder);
        $('#dicPercHeader').click(function() {
            //changeDeliveryAddress();
            var oldDiscPercent = $('#dicPercHeader').val();
            $('#authDiscount').show();
            showDialog('#authDiscount', 500, 400);
            $('#newDiscountPercentage').val($('#dicPercHeader').val());
            $('#newDiscountPercentage').select();
            //authNewDiscountPerc(message);
            $('#doAuthDiscounts').click(function() {
                $.ajax({
                    url: '{!! url('/verifyAuth') !!}',
                    type: "POST",
                    data: {
                        userName: $('#userAuthDisc').val(),
                        userPassword: $('#userAuthPassWordDisc').val()
                    },
                    success: function(data) {
                        //console.debug("bunch"+data);
                        if ($.isEmptyObject(data)) {
                            alert("Wrong Credentials Please Try Again!");
                        } else {
                            $('#userAuthDisc').val('');
                            $('#userAuthPassWordDisc').val('');
                            $('#dicPercHeader').val($('#newDiscountPercentage')
                            .val());
                            consoleManagement('{!! url('/logMessageAjax') !!}', 12, 1,
                                'Discount Changed from ' + oldDiscPercent +
                                ' To ' + $('#dicPercHeader').val() + ' by ' +
                                data[0].UserName, 0, $('#orderId').val(), 0, 0,
                                0, 0, 0, 0, $('#orderId').val(), 0,
                                computerName, $('#orderId').val(), 0);
                            //updateDiscount

                            $.ajax({
                                url: '{!! url('/updateDiscount') !!}',
                                type: "POST",
                                data: {
                                    OrderId: $('#orderId').val(),
                                    Disc: $('#dicPercHeader').val()
                                },
                                success: function(data) {
                                    $('#authDiscount').dialog('close');
                                }
                            });
                            $('#authDiscount').dialog('close');
                            calculator();

                        }
                    }
                });
            });
        });

        /**
         * CALL LIST
         * */


        /**
         * TABLET LOADING APP
         * */
        $('#tabletLoadingApp').click(function() {
            //url,ConsoleTypeId,Importance,Message,Reviewed,OrderId,productid,
            // CustomerId,OldQty,NewQty,OldPrice,NewPrice,ReviewedUserId,ReferenceNo,DocType,DocNumber,machine,ReturnId
            consoleManagement('{!! url('/logMessageAjax') !!}', 300, 2, 'Dims Tablet Loading button Clicked',
                0, 0, 0, 0, 0, 0, 0, 0, 'NULL', 0, computerName, 0, 0);


            $('#tabletLoadingGo').click(function() {
                reprintList();
            });

            $('#tabletLoading').show();
            $("#tabletLoading").dialog({
                height: 600,
                width: 900,
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
        });

        /**
         * List Top 1000 orders and order them  by date in desc
         * */
        $('#orderListing').click(function() {
            otable = $('#createdOrders').DataTable({
                "ajax": {
                    url: '{!! url('/getOrderListing') !!}',
                    "type": "POST",
                    data: function(data) {
                        data.OrderId = $('#orderIdOrderListing').val();
                        data.InvNo = $('#invoiceNoOrderListing').val();
                        data.CustCode = $('#customerCodeOrderListing').val();
                        data.delDate = $('#deliveryDateOrderListing').val();
                    }
                },
                "processing": false,
                "serverSide": false,
                "stateSave": false,
                "columns": [{
                        "data": "OrderId",
                        "bSortable": true
                    },
                    {
                        "data": "InvoiceNo",
                    },
                    {
                        "data": "CustomerPastelCode",
                    },
                    {
                        "data": "StoreName",
                    },
                    {
                        "data": "LateOrder",
                    },
                    {
                        "data": "Route",
                    },
                    {
                        "data": "DeliveryDate",
                    },
                    {
                        "data": "OrderDate",
                    },
                    {
                        "data": "OrderNo",
                    },
                    {
                        "data": "UserName",
                    },
                    {
                        "data": "inclusives",
                    },
                    {
                        "data": "Terms",
                    },
                    {
                        "data": "BalanceDue",
                    },
                    {
                        "data": "GPperc",
                        render: function(data, type, row, meta) {
                            // check to see if this is JSON
                            try {
                                var jsn = JSON.parse(data);
                                //console.log(" parsing json" + jsn);
                            } catch (e) {

                                return jsn.data;
                            }
                            return parseFloat(jsn).toFixed(2);

                        }
                    }

                ],
                "order": [
                    [0, "desc"]
                ],
                "deferRender": true,
                "scrollY": "370px",
                "scrollCollapse": true,
                searching: true,
                bPaginate: false,
                bFilter: false,
                "LengthChange": true,
                "info": false,
                "ordering": true,
                "initComplete": function() {
                    this.api().columns().every(function() {
                        var column = this;
                        var select = $(
                                '<select class="form-control form-select"><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true,
                                        false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d + '">' + d +
                                '</option>')
                        });
                    });
                },
                "bDestroy": true,
                scrollX: true,
            });

            $('#createdOrders tbody').on('dblclick', 'tr', function() {
                var data = otable.row(this).data();
                $("#evil").dialog("close");
                console.debug(data.StoreName);
                if ($('#orderId').val().length > 0) {
                    alert('There is Currently an order Opened Please Close it !');
                } else {

                    $('<div id="evil" style="z-index: 60000 !important;"></div>')
                        .html('<div ><h6><a href={!! url('/pdforder') !!}/' + data.OrderId +
                            ' target="blank">View PDF (' + data.StoreName + ' - ' + data
                            .OrderId + ' )</a><br><a href={!! url('/PDFDelDate') !!}/' + data
                            .OrderId +
                            ' target="blank" style="background: #43bbc8;text-decoration: underline;">DELIVERY NOTE (' +
                            data.StoreName + ' - ' + data.OrderId +
                            ' )</a><br><a href={!! url('/exportorder') !!}/' + data.OrderId +
                            '  style="text-decoration: underline;">EXCEL Order(' + data
                            .StoreName + ' - ' + data.OrderId + ' )</a><br></h6></div>')
                        .dialog({

                            modal: true,
                            title: 'Do you want to view this order?',
                            autoOpen: true,
                            width: '66%',
                            resizable: false,

                            buttons: {
                                Yes: {
                                    text: "Yes",
                                    class: "btn btn-success btn-sm",
                                    click: function() {
                                        $(this).dialog("close");
                                        if ($('#orderId').val().length < 3) {
                                            $('#orderId').val(data.OrderId);
                                            $("#checkOrders").click();
                                        }
                                        $("#dialog").dialogExtend("minimize");
                                        $(this).prop("disable", true);
                                    }
                                },
                                No: {
                                    text: "No",
                                    class: "btn btn-primary btn-sm",
                                    click: function() {
                                        $(this).dialog("close");
                                    }
                                }
                            },
                            close: function(event, ui) {
                                $(this).remove();
                            }
                        });

                    $("body").on("click", ".ui-widget-overlay", function() {
                        $('#evil').dialog("close");
                    });


                }
                //document.location.href = '/operator/'+data['slug'];
            });
            $('#createdOrders tbody').on('click', 'tr', function(e) {
                $("#createdOrders tbody tr").removeClass('row_selectedYellowish');
                $(this).addClass('row_selectedYellowish');
            });
            $('#passFiltersOnOrderListing').on('click change', function(event) {
                // otable.draw();
                otable = $('#createdOrders').DataTable({
                    "ajax": {
                        url: '{!! url('/getOrderListing') !!}',
                        "type": "POST",
                        data: function(data) {
                            data.OrderId = $('#orderIdOrderListing').val();
                            data.InvNo = $('#invoiceNoOrderListing').val();
                            data.CustCode = $('#customerCodeOrderListing').val();
                            data.delDate = $('#deliveryDateOrderListing').val();
                        }
                    },
                    "processing": false,
                    "serverSide": false,
                    "stateSave": false,
                    "columns": [{
                            "data": "OrderId",
                            "class": "small"
                        },
                        {
                            "data": "InvoiceNo",
                            "class": "small"
                        },
                        {
                            "data": "CustomerPastelCode",
                            "class": "small"
                        },
                        {
                            "data": "StoreName",
                            "class": "small"
                        },
                        {
                            "data": "LateOrder",
                            "class": "small"
                        },
                        {
                            "data": "Route",
                            "class": "small"
                        },
                        {
                            "data": "DeliveryDate",
                            "class": "small",
                            "bSortable": true
                        },
                        {
                            "data": "OrderDate",
                            "class": "small"
                        },
                        {
                            "data": "OrderNo",
                            "class": "small"
                        },
                        {
                            "data": "UserName",
                            "class": "small"
                        },
                        {
                            "data": "inclusives",
                            "class": "small"
                        },
                        {
                            "data": "Terms",
                            "class": "small"
                        },
                        {
                            "data": "BalanceDue",
                            "class": "small"
                        },
                        {
                            "data": "GPperc",
                            "class": "small",
                            render: function(data, type, row, meta) {
                                // check to see if this is JSON
                                try {
                                    var jsn = JSON.parse(data);
                                    //console.log(" parsing json" + jsn);
                                } catch (e) {

                                    return jsn.data;
                                }
                                return parseFloat(jsn).toFixed(2);

                            }
                        }

                    ],
                    "order": [
                        [6, "desc"]
                    ],
                    "deferRender": true,
                    "scrollY": "389px",
                    "scrollCollapse": true,
                    searching: true,
                    bPaginate: false,
                    bFilter: false,
                    "LengthChange": false,
                    "info": false,
                    "ordering": true,
                    "bDestroy": true
                });
            });
            $('#refreshOrderListing').on('click change', function(event) {
                // otable.draw();
                $('#orderIdOrderListing').val('');
                $('#invoiceNoOrderListing').val('');
                $('#customerCodeOrderListing').val('');
                $('#deliveryDateOrderListing').val('');
                otable = $('#createdOrders').DataTable({
                    "ajax": {
                        url: '{!! url('/getOrderListing') !!}',
                        "type": "POST",
                        data: function(data) {
                            data.OrderId = $('#orderIdOrderListing').val();
                            data.InvNo = $('#invoiceNoOrderListing').val();
                            data.CustCode = $('#customerCodeOrderListing').val();
                            data.delDate = $('#deliveryDateOrderListing').val();
                        }
                    },
                    "order": [
                        [6, "desc"]
                    ],
                    "processing": false,
                    "serverSide": false,
                    "stateSave": false,
                    "columns": [{
                            "data": "OrderId",
                            "class": "small"
                        },
                        {
                            "data": "InvoiceNo",
                            "class": "small"
                        },
                        {
                            "data": "CustomerPastelCode",
                            "class": "small"
                        },
                        {
                            "data": "StoreName",
                            "class": "small"
                        },
                        {
                            "data": "LateOrder",
                            "class": "small"
                        },
                        {
                            "data": "Route",
                            "class": "small"
                        },
                        {
                            "data": "DeliveryDate",
                            "class": "small",
                            "bSortable": true
                        },
                        {
                            "data": "OrderDate",
                            "class": "small"
                        },
                        {
                            "data": "OrderNo",
                            "class": "small"
                        },
                        {
                            "data": "UserName",
                            "class": "small"
                        },
                        {
                            "data": "inclusives",
                            "class": "small"
                        },
                        {
                            "data": "Terms",
                            "class": "small"
                        },
                        {
                            "data": "BalanceDue",
                            "class": "small"
                        },
                        {
                            "data": "GPperc",
                            "class": "small",
                            render: function(data, type, row, meta) {
                                // check to see if this is JSON
                                try {
                                    var jsn = JSON.parse(data);
                                    //console.log(" parsing json" + jsn);
                                } catch (e) {

                                    return jsn.data;
                                }
                                return parseFloat(jsn).toFixed(2);

                            }
                        }


                    ],

                    "deferRender": true,
                    "scrollY": "389px",
                    "scrollCollapse": true,
                    searching: true,
                    bPaginate: false,
                    bFilter: false,
                    "LengthChange": false,
                    "info": false,
                    "ordering": true,
                    "bDestroy": true
                });
            });
            $('#dialog').show();
            $("#dialog").dialog({
                height: 700,
                width: 1350,
                containment: false
            }).dialogExtend({
                "closable": true, // enable/disable close button
                "maximizable": false, // enable/disable maximize button
                "minimizable": true, // enable/disable minimize button
                "collapsable": true, // enable/disable collapse button
                "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                "titlebar": "transparent", // false, 'none', 'transparent'
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
        });
        /**
         * General Plrice check for any customer on a product
         * */
        $('#pricing').click(function() {
            window.open('{!! url('/pl') !!}', "PriceLook",
                "location=1,status=1,scrollbars=1, width=1200,height=850");

        });
        //$("#two-columns").zoomTarget();
        $('.hidebody').hide();
        var GLOBALPRODCODE = '';
        var GLOBALPRODUCTDESCRIPTION = '';
        var GLOBALPRICE = '';
        var GLOBALQUANTITY = '';
        var GLOBALBULK = '';
        var GLOBALCOMMENT = '';
        var GLOBALDISC = '';
        var GLOBALUNITSIZE = '';
        var TotalExc = 0;
        var TotalInc = 0;
        $('#awaitingStock').on('change',
    function() { // this change function seems fine, it logs messages, it changes the checkbox
            if ($('#awaitingStock').is(
                ':checked')) { // status and it runs a simple update, this would be the cause as CLICKING isnt the issue
                isAwaitingStock(1); // its the lack thereof clicking.
                $('#awaitingStock').val("1");
            } else {
                alert("NOT WAITING FOR STOCK");
                isAwaitingStock(0);
                $('#awaitingStock').val("0");
            }

        });
        /**
         * Clicking the Finish button
         * */
        $('#finishOrder').click(function() {

            var zeropricingdoublecheck = new Array();
            $('#table > tbody  > tr').each(function() {
                var data = $(this);

                var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                var comment = $(this).closest('tr').find('.prodComment_').val();
                //comment = comment.replace("'","");
                console.debug($(this).closest('tr').find('.col2').val());
                if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                    zeropricingdoublecheck.push({
                        'productCode': escapeHtml($(this).closest('tr').find(
                            '.theProductCode_').val()),
                        'qty': $(this).closest('tr').find('.prodQty_').val(),
                        'price': $(this).closest('tr').find('.prodPrice_').val(),
                        'comment': escapeHtml(comment),
                        'orderDetailID': orderDetailID,
                        'customerCode': escapeHtml($('#inputCustAcc').val()),
                        'prodDisc': $(this).closest('tr').find('.prodDisc_').val(),
                        'OrderId': $('#orderId').val(),
                        'hiddenToken': $(this).closest('tr').find('.hiddenToken').val(),
                        'prodBulk': $(this).closest('tr').find('.prodBulk_').val(),
                        'warehouse': $(this).closest('tr').find('.col2').val()
                    });


                }

            });

            calculator();
            // if (parseFloat((parseFloat($('#totalmargin').val()).toFixed(2)) < parseFloat(parseFloat($('#hiddencustomerGp').val()).toFixed(2) )) && ($('#margin_auth').val() != 1) )
            if (Math.round($('#totalmargin').val()) < Math.round($('#hiddencustomerGp').val()) && ($(
                    '#margin_auth').val() != 1) && ($('#invoiceNo').val()).length < 3 && $(
                    '#marginandpriceauthbycustomer').val().lenght > 1) {
                $('#MarginProblems').show();
                showDialogWithoutClose('#MarginProblems', 400, 400);
                $('#MarginProblems').keydown(function(event) {
                    if (event.keyCode == 27) {
                        return false;
                    }
                });
                $('#doAuthCredits').off().click(function() {

                    $.ajax({
                        url: '{!! url('/verifyAuthOnAdmin') !!}',
                        type: "POST",
                        data: {
                            userName: $('#userAuthProhibitedCred_marg').val(),
                            userPassword: $('#userAuthPassWordCredit_marg').val(),
                            orderId: $('#orderId').val()
                        },
                        success: function(data) {
                            if ($.isEmptyObject(data)) {
                                alert(
                                    "Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                            } else {
                                $('#margin_auth').val(1);
                                consoleManagementAuths('{!! url('/logMessageAuthMargin') !!}',
                                    12, 1, 'Authorized Order Margin by ' + data[
                                        0].UserName + '( ' + $('#totalmargin')
                                    .val() + ' )',
                                    0, $('#orderId').val(), '', $(
                                        '#inputCustAcc').val(), 0, 0, 0, $(
                                        '#userAuthProhibitedCred_marg').val(),
                                    $('#orderId').val(), 0, computerName, $(
                                        '#orderId').val(), 0, data[0].UserID,
                                    data[0].UserName);
                                $("#MarginProblems").dialog('close');
                                finishThis();


                                //calculator();
                            }
                        }
                    });

                });
                $('#doCancelAuthCredits').off().click(function() {
                    $('#MarginProblems').dialog('close');
                });
                //
            } else {

                $.ajax({
                    url: '{!! url('/isClosedRoute') !!}',
                    type: "POST",
                    data: {
                        delDate: $('#inputDeliveryDate').val(),
                        orderType: $('#orderType').val(),
                        routeId: $('#routeName').val(),
                        inputCustAcc: $('#inputCustAcc').val()


                    },
                    success: function(data) {
                        //console.debug('I am Zero');

                        if (data.isClosed == '0') {
                            console.debug('I am Zero');
                            if ($.trim(data.routeId) == $.trim(data.routeOnOrder)) {
                                finishThis();
                            } else {
                                var dialog = $(
                                    '<p>Sorry <strong style="color:red"> THIS IS NOT THE DEFAULT ROUTE FOR THIS CUSTOMER !</strong></p>'
                                    ).dialog({
                                    height: 200,
                                    width: 700,
                                    buttons: {
                                        "FIX": {
                                            text: "FIX",
                                            class: "btn btn-success btn-sm",
                                            click: function() {
                                                dialog.dialog('close');
                                                consoleManagement(
                                                    '{!! url('/logMessageAjax') !!}',
                                                    325, 2, 'User Pressed FIX',
                                                    0, 0, 0, 0, 0, 0, 0, 0, $(
                                                        '#orederNumber').val(),
                                                    0, computerName, $(
                                                        '#orderId').val(), 0);
                                            }
                                        },
                                        "CONTINUE ANYWAY": {
                                            text: "CONTINUE ANYWAY",
                                            class: "btn btn-primary btn-sm",
                                            click: function() {
                                                finishThis();
                                                dialog.dialog('close');
                                                consoleManagement(
                                                    '{!! url('/logMessageAjax') !!}',
                                                    325, 2, 'User Pressed FIX',
                                                    0, 0, 0, 0, 0, 0, 0, 0, $(
                                                        '#orederNumber').val(),
                                                    0, computerName, $(
                                                        '#orderId').val(), 0);
                                            }
                                        }
                                    }
                                });

                            }


                        } else {

                            if (($('#invoiceNo').val()).length < 5) {
                                authFinishOrder();
                            }

                        }
                        // }
                    }
                });
            }
        });
        /**
         * Send the request to the server and get order headers and details
         *
         * */

        $('#checkOrders').click(function() {

            var account = '';
            var Description = '';
            var DeliveryDate = '';
            var OrderDate = '';
            var InvoiceTotalPriceInc = 0;
            var InvoiceTotalPriceIncLineDisc = 0;
            var InvoiceTotalPriceExcl = 0;
            $(".fast_remove").empty();
            $('.hidebody').show();
            $('#deleteAllLines').show();
            $('#orderType').prop("disabled", false);

            $('#two-columns').css({
                display: "block"
            });
            $('#submitFilters').hide();
            $('#changeDelvDate').hide();
            $('#deprecated_cangeDate').hide();
            //Pass the Ids

            //Order Header
            $.ajax({
                url: '{!! url('/onCheckOrderHeader') !!}',
                type: "POST",
                data: {
                    invoiceNo: $('#invoiceNo').val(),
                    orderId: $('#orderId').val()
                },
                success: function(data) {
                    console.debug("************ check" + data.returns);
                    if (data.returns != "inserted") {
                        $('#orderId').val("");
                        $('#deleteAllLines').hide();
                        var dialog = $('<p>Sorry <strong style="color:red">' + data.data[0]
                            .orderID + '</strong></p>').dialog({
                            height: 200,
                            width: 700,
                            modal: true,
                            buttons: [
                                {
                                    text: "Okay",
                                    class: "btn btn-primary btn-sm",
                                    click: function() {
                                        dialog.dialog('close');
                                        location.reload(true);
                                    }
                                }
                            ]
                        });
                    } else {
                        console.debug(data.data);
                        var trHTML = '';
                        var Address = '';
                        $.each(data.data, function(key, value) {
                            $("#inputCustAcc").val(value.CustomerPastelCode);
                            $("#inputCustName").val(value.StoreName);
                            $("#inputDeliveryDate").val(value.DeliveryDate);
                            $("#inputOrderDate").val(value.OrderDate);
                            $('#invoiceNo').val(value.InvoiceNo);
                            $('#invoiceNoKeeper').val(value.InvoiceNo);
                            $('#orederNumber').val(value.OrderNo);
                            $('#creditLimit').val(value.CreditLimit);
                            $('#hiddenCustDiscount').val(value.Discount);
                            $('#dicPercHeader').val(value.Discount);
                            $('#hiddenCustomerNotes').val(value
                            .OtherImportantNotes);
                            $('#hiddenRouteId').val(value.Routeid);
                            $('#routeonabutton').val(value.Route);
                            $('#hiddencustomerGp').val(value.mnyCustomerGp);
                            $('#CustomerId').val(value.CustomerId);
                            $('#balDue').val(parseFloat(value.BalanceDue).toFixed(
                                2));
                            $('#margin_auth').val(value.Authorised);
                            $('#customerpricelist').val(value.termsAndList);
                            $('#notification').prepend('<option value="' + value
                                .intNotification + '" selected="selected">' +
                                value.specificNotification + '</option>');

                            console.debug(
                                '************************************* ttreat as ' +
                                value.TreatAsQuotation);
                            if (value.TreatAsQuotation == '1') {
                                $('#treatAsQuote').prop('checked', true);
                            } else {
                                $('#treatAsQuote').prop('checked', false);
                            }

                            if (value.AwaitingStock == '1') {
                                $('#awaitingStock').prop('checked', true);

                                $('#awaitingStock').val("1");
                            } else {
                                $('#awaitingStock').prop('checked', false);

                                $('#awaitingStock').val("0");
                            }

                            $('#orderType').prepend('<option value="' + value
                                .LateOrder + '" selected="selected">' + value
                                .OrderType + '</option>');

                            //
                            // $('#hiddenDeliveryAddressId').val(value.DeliveryAddressID);
                            $('#messagebox').val(value.MESSAGESINV);
                            account = value.CustomerPastelCode;
                            Description = value.StoreName;
                            DeliveryDate = value.DeliveryDate;
                            OrderDate = value.OrderDate;
                            console.debug("del address**" + value
                            .DeliveryAddressID);
                            console.debug("value.DeliveryAddressID" + value
                                .DeliveryAddressID);
                            Address += $.trim(value.DeliveryAddress1) + ' , ' + $
                                .trim(value.DeliveryAddress2) + ' , ' + $.trim(value
                                    .DeliveryAddress3) + ' , ' + $.trim(value
                                    .DeliveryAddress4) + ' , ' + $.trim(value
                                    .DeliveryAddress5);
                            Address = Address.replace("null", "");
                            $('#customerSelectedDelDate').val(Address);
                            $('#address1hidden').val(value.DeliveryAddress1);
                            $('#address2hidden').val(value.DeliveryAddress2);
                            $('#address3hidden').val(value.DeliveryAddress3);
                            $('#address4hidden').val(value.DeliveryAddress4);
                            $('#address5hidden').val(value.DeliveryAddress5);

                            if (value.DeliveryAddressID == 'Null') {
                                $('#hiddenDeliveryAddressId').val('');
                                $('#tempDelivAddressClosethis').hide();
                                orderPattern(0);
                                backorderandawaiting(0);

                            } else {
                                $('#hiddenDeliveryAddressId').val(value
                                    .DeliveryAddressID);
                                orderPattern(value.DeliveryAddressID);
                                backorderandawaiting(value.DeliveryAddressID)
                                $('#orderPatternIdTable_filter input').val('');
                            }

                            customerAndGroupSpecials();
                            $("#routeName").empty();
                            $('#routeName').prepend('<option value="' + value
                                .RouteId + '" selected="selected">' + value
                                .Route + '</option>');

                            previousRouteVal = $("#routeName").val();
                            previousTextRoute = $("#routeName").find(
                                "option:selected").text();
                            $("#routeName").data('pre', previousTextRoute);
                            $("#routeName").on('change', function() {
                                if (($('#orderId').val()).length > 1) {
                                    var toRoute = $(this).find(
                                        "option:selected").text();
                                    var jqThis = $(this).data('pre');

                                    $('#authDropDowns').show();
                                    showDialogWithoutClose('#authDropDowns',
                                        '65%', 320);

                                    $('#doAuthDropDown').click(function() {
                                        authChangeOfOrderType(
                                            toRoute,
                                            'Authorised Route From ' +
                                            jqThis + ' To ');
                                        $("#routeName").data('pre',
                                            toRoute);
                                        //$('#authDropDowns').dialog('close');
                                        // authChangeOfOrderType(previousTextRoute,'Authorised Route To ');
                                    });
                                    $('#doCancelAuthDropDown').click(
                                        function() {
                                            $("#routeName").prepend(
                                                '<option value="' +
                                                previousRouteVal +
                                                '" selected="selected">' +
                                                previousTextRoute +
                                                '</option>');
                                            $('#authDropDowns').dialog(
                                                'close');
                                        });
                                }
                            });

                            //Assign the Routes

                            $("#inputOrderDate").prop("disabled", true);
                            // $("#inputDeliveryDate").prop("disabled", true);
                            $("#inputDeliveryDate").prop("disabled", false);
                            $("#inputCustName").prop("disabled", true);
                            $("#inputCustAcc").prop("disabled", true);
                            $.each(wareautocomplete, function(i, item) {
                                $("#headerWh").append("<option value='" +
                                    item.ID + "'>" + item.Warehouse +
                                    "</option>");
                            });
                            //ORDER DETAILS
                            $.ajax({
                                url: '{!! url('/onCheckOrderHeaderDetails') !!}',
                                type: "POST",
                                data: {
                                    orderId: $('#orderId').val()
                                },
                                success: function(dataDetails) {
                                    InvoiceTotalPriceExcl = 0;
                                    InvoiceTotalPriceInc = 0;
                                    $.each(dataDetails, function(
                                        keyDetails, valueDetails
                                        ) {
                                        var tokenId = new Date()
                                            .valueOf();
                                        var props = '';
                                        console.debug(
                                            "------------------------------------------------------" +
                                            isAllowedToChangeInv
                                            );
                                        if (($('#invoiceNo')
                                                .val()).length >
                                            2 &&
                                            isAllowedToChangeInv !=
                                            1) {
                                            props = "disabled";

                                        }
                                        console.debug(
                                            "************************************ AUTMUTLIWAREHOUSE" +
                                            multiLines);
                                        if (($('#invoiceNo')
                                                .val()).length >
                                            2) {
                                            $("#inputDeliveryDate")
                                                .prop(
                                                    "disabled",
                                                    true);
                                            $("#inputOrderDate")
                                                .prop(
                                                    "disabled",
                                                    true);
                                        }
                                        if (multiLines == 1) {
                                            var classAnonymouscols =
                                                "anonymouscols";
                                        } else {
                                            var classAnonymouscols =
                                                "anonymouscolsOff";
                                        }
                                        var bulkitemcolor = "";
                                        if (valueDetails.SoldByWeight != 0) {
                                            bulkitemcolor = "bulkitemcolor";
                                        }
                                        var $row = $(`
                                            <tr id="new_row_ajax${tokenId}" class="fast_remove">
                                                <td class="text-center">
                                                    <input type="hidden" id="title_${tokenId}" class="title" value="" />
                                                    <input type="hidden" id="theOrdersDetailsId" value="${valueDetails.OrderDetailId}" />
                                                    <input type="hidden" id ="taxCode${tokenId}" value="${valueDetails.Tax}" class="taxCodes" />
                                                    <input type="hidden" id ="cost_${tokenId}" value="${valueDetails.Cost}" class="costs" />
                                                    <input type="hidden" id ="inStock_${tokenId}" value="${valueDetails.QtyInStock}" class="inStock" style="color:blue !important" />
                                                    <input type="hidden" value ="${tokenId}" class="hiddenToken" />
                                                    <input type="hidden" id ="priceholder_${tokenId}" value="${(parseFloat(valueDetails.Price)).toFixed(2)}" class="priceholder" />
                                                    <input type="hidden" id ="alcohol_${tokenId}" value="" class="alcohol" />
                                                    <input type="hidden" id ="margin_${tokenId}" value="" class="margin" />
                                                    <input type="hidden" id ="soldByWieght${tokenId}" value="" class="soldByWieght" />
                                                    <input type="hidden" id ="unitWeight${tokenId}" value="" class="unitWeight" />
                                                    <input type="hidden" id ="strBulkUnit${tokenId}" value="" class="strBulkUnit" />
                                                    <input type="hidden" id ="prohibited_${tokenId}" value="" class="prohibited" />
                                                    <input type="hidden" id ="productmarginauth${tokenId}" value="1" class="productmarginauth" />
                                                    <button type="button" id="deleteaLine" value="${valueDetails.OrderDetailId}" class="getOrderDetailLine btn btn-icon btn-danger btn-sm btn-sm-icon">
                                                        <i class="bi bi-trash3-fill fs-4"></i>
                                                    </button>
                                                </td>
                                                <td contenteditable="false">
                                                    <input style="width: 100px;" name="theProductCode" id ="prodCode_${tokenId}" class="theProductCode_ set_autocomplete inputs form-control" value="${valueDetails.PastelCode}" ${props}>
                                                    <input name="col1" id ="col1${tokenId}" class="col1 ${classAnonymouscols}" readonly>
                                                </td>
                                                <td contenteditable="false">
                                                    <input style="width: 250px;" name="prodDescription_" id ="prodDescription_${tokenId}" class="prodDescription_ set_autocomplete inputs form-control" value="${valueDetails.PastelDescription}" ${props}>
                                                    <input name="col8" id ="col8${tokenId}" class="col8 ${classAnonymouscols}" readonly>
                                                </td>
                                                <td contenteditable="false">
                                                    <input style="width: 65px;" type="text" name="prodBulk_"  id ="prodBulk_${tokenId}" class="prodBulk_ resize-input-inside ${bulkitemcolor} form-control"  value="${valueDetails.UnitCount}" ${props} readonly>
                                                    <input name="col3" id ="col3${tokenId}" class="col3 ${classAnonymouscols}" readonly>
                                                </td>
                                                <td contenteditable="false">
                                                    <input style="width: 65px;" type="text" name="prodQty_" id ="prodQty_${tokenId}"   onkeypress="return isFloatNumber(this,event)"  class="prodQty_ resize-input-inside inputs form-control" value="${(parseFloat(valueDetails.Qty)).toFixed(3)}" ${props}>
                                                    <input name="col4" id ="col4${tokenId}" class="col4 ${classAnonymouscols}" readonly>
                                                </td>
                                                <td contenteditable="false">
                                                    <input style="width: 100px;" type="text" name="prodPrice_" id ="prodPrice_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs form-control" value="${(parseFloat(valueDetails.Price)).toFixed(2)}" ${props}>
                                                    <input name="col1" id ="col1${tokenId}" class="col1 ${classAnonymouscols}" readonly>
                                                </td>
                                                <td  contenteditable="false">
                                                    <input style="width: 80px;" type="text" name="prodDisc_" id ="prodDisc_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside inputs form-control" value="${valueDetails.LineDisc}" ${props} {{ $discountProperty }}>
                                                    <input name="col6" id ="col6${tokenId}" class="col6 ${classAnonymouscols}" style="color: brown;" readonly>
                                                </td>
                                                <td contenteditable="false">
                                                    <input style="width: 75px;" type="text" name="prodUnitSize_" id ="prodUnitSize_${tokenId}" class="prodUnitSize_ resize-input-inside inputs form-control" value="${valueDetails.UnitSize}" ${props}>
                                                </td>
                                                <td contenteditable="false" style="display:flex;">
                                                    <input style="width: 100px; color: blue;" type="text" name="instockReadOnly" id ="instockReadOnly_${tokenId}" value="${valueDetails.QtyInStock}"  class="instockReadOnly_ resize-input-inside inputs form-control me-2">
                                                    <input style="width: 100px; color: red;" type="text" name="shelf" id ="shelf_${tokenId}" class="shelf_ resize-input-inside form-control" value="${valueDetails.shelf}">
                                                    <select name="col2" id ="col2${tokenId}" class="col2 ${classAnonymouscols}">
                                                        <option value="${valueDetails.ID}" >"${valueDetails.Warehouse}"</option>
                                                    </select>
                                                </td>
                                                <td contenteditable="false">
                                                    <input style="width: 100px; color:blue;" type="text" name="instockReadOnly" id ="clcstock_${tokenId}" value="${valueDetails.QtyInStock}"  class="clcstock_ resize-input-inside inputs form-control">
                                                </td>
                                                <td contenteditable="false">
                                                    <input style="width: 100px; color:blue;" type="text" name="additionalcost_" id ="additionalcost_${tokenId}" value ="" class="additionalcost_ resize-input-inside inputs form-control">
                                                </td>
                                                <td contenteditable="false">
                                                    <input style="width: 200px;" type="text" name="prodComment_" id ="prodComment_${tokenId}" class="prodComment_ resize-input-inside last inputs form-control" title="${valueDetails.Comment}"  value="${valueDetails.Comment}" ${props}>
                                                    <input name="col9" id ="col9${tokenId}" class="col9 ${classAnonymouscols}" readonly>
                                                </td>
                                            </tr>
                                        `);
                                        $('#table tbody')
                                            .append($row);

                                        if (valueDetails
                                            .Price == null ||
                                            valueDetails
                                            .IncPrice == null) {
                                            InvoiceTotalPriceExcl
                                                = (parseFloat(
                                                    InvoiceTotalPriceExcl
                                                    ) + (0 *
                                                    parseFloat(
                                                        valueDetails
                                                        .Qty
                                                        )))
                                                .toFixed(2);
                                            InvoiceTotalPriceInc
                                                = (parseFloat(
                                                    InvoiceTotalPriceInc
                                                    ) + (0 *
                                                    parseFloat(
                                                        valueDetails
                                                        .Qty
                                                        )))
                                                .toFixed(2);
                                        } else {
                                            InvoiceTotalPriceExcl
                                                = (parseFloat(
                                                    InvoiceTotalPriceExcl
                                                    ) + (
                                                    parseFloat(
                                                        valueDetails
                                                        .Price
                                                        ) *
                                                    parseFloat(
                                                        valueDetails
                                                        .Qty
                                                        )))
                                                .toFixed(2);
                                            InvoiceTotalPriceInc
                                                = (parseFloat(
                                                    InvoiceTotalPriceInc
                                                    ) + (
                                                    parseFloat(
                                                        valueDetails
                                                        .IncPrice
                                                        ) *
                                                    parseFloat(
                                                        valueDetails
                                                        .Qty
                                                        )))
                                                .toFixed(2);
                                            InvoiceTotalPriceIncLineDisc
                                                = (parseFloat(
                                                    InvoiceTotalPriceIncLineDisc
                                                    ) + ((
                                                        parseFloat(
                                                            valueDetails
                                                            .IncPrice
                                                            ) *
                                                        ((100 - valueDetails
                                                                .LineDisc
                                                                ) /
                                                            100
                                                            )
                                                        ) *
                                                    parseFloat(
                                                        valueDetails
                                                        .Qty
                                                        )))
                                                .toFixed(2);

                                        }
                                        focusoutcaladditionalcost
                                            (valueDetails
                                                .PastelCode, (
                                                    parseFloat(
                                                        valueDetails
                                                        .Qty))
                                                .toFixed(3),
                                                'additionalcost_' +
                                                tokenId);
                                        var txt = valueDetails
                                            .Warehouse; //$("#headerWh option:selected").text();
                                        var val = valueDetails
                                            .ID;
                                        $("#col2" + tokenId)
                                            .append(
                                                "<option value='" +
                                                val + "'>" +
                                                txt +
                                                "</option>");
                                        $.each(wareautocomplete,
                                            function(i,
                                                item) {
                                                $("#col2" +
                                                        tokenId
                                                        )
                                                    .append(
                                                        "<option value='" +
                                                        item
                                                        .ID +
                                                        "'>" +
                                                        item
                                                        .Warehouse +
                                                        "</option>"
                                                        );
                                            });
                                        var Ltot = valueDetails
                                            .Qty * valueDetails
                                            .Price;
                                        $("#col6" + tokenId)
                                            .val(Ltot.toFixed(
                                                2));

                                    });
                                    if ($('#invoiceNo').val().length <
                                        3) {
                                        $('#changeDeliveryAddressOnNotInvoiced')
                                            .show();
                                        generateALine2();
                                    } else {
                                        if (isAllowedToChangeInv != 1) {
                                            $(".getOrderDetailLine ")
                                                .css("display", "none");
                                            $("#deleteAllLines").hide();
                                            $('#changeDeliveryAddressOnNotInvoiced')
                                                .hide();

                                        }

                                    }

                                    $('#totalEx').val(
                                        InvoiceTotalPriceExcl);
                                    $('#totalInc').val(
                                        InvoiceTotalPriceInc);
                                    $('#totalInOrder').val(
                                        InvoiceTotalPriceIncLineDisc
                                        );
                                    calculator();
                                }

                            });

                            $("#invoiceNo").prop("disabled", true);
                            $("#orderId").prop("disabled", true);
                            $("#inputCustAcc").flexdatalist('disabled', true);
                            $("#inputCustName").flexdatalist('disabled', true);
                            if (($("#invoiceNoKeeper").val()).length > 1 &&
                                isAllowedToChangeInv != 1) {
                                $("#orederNumber").prop("disabled", true);
                                $("#totalEx").prop("disabled", true);
                                $("#totalInc").prop("disabled", true);
                                $("#button_row").prop("disabled", true);
                                $("#routeonabutton").prop("disabled", true);

                                $("#invoiceNow").hide();
                                $("#reprintInvoice").show();

                                // $('#edit_row').show()
                            }


                        });
                    }

                    //$("#two-columns").find("input").attr("disabled", "disabled");

                }
            });
            //End of Order Header

        });
        $('#totaddidtionalcst').click(function() {
            calcAdditionalCost();
        });
        /**
         * Main form filters to generate the order
         * */
        $('#submitFilters').click(function() {
            //Check if there is an order
            //checkIfOrderExistsWithOrderType
            // alert(computerName);
            $("#deprecated_cangeDate").hide();
            $('#copyThisOrder').hide();
            $('#printDocument').hide();
            $('#checkOrders').hide();
            $('#orderType').prop("disabled", false);





            $("#inputCustAcc").flexdatalist('disabled', true);
            $("#inputCustName").flexdatalist('disabled', true);
            //
            console.debug($('#hiddenRouteId').val());
            if ($('#hiddenRouteId').val() === '0') {
                $('#assignRouteOnTheFly').show();
                showDialog('#assignRouteOnTheFly', 520, 300);
                $("#assignRouteOnTheFlyDropDown").on("change", function() {

                    $('#routeName').prepend('<option value="' + this.value +
                        '" selected="selected">' + $(
                            "#assignRouteOnTheFlyDropDown option:selected").text() +
                        '</option>');

                });
                $('#doneAssigningRoutes').click(function() {
                    $.ajax({
                        url: '{!! url('/assignRouteToTheCustomer') !!}',
                        type: "POST",
                        data: {
                            custCode: $('#inputCustAcc').val(),
                            routeId: $('#assignRouteOnTheFlyDropDown').val(),
                        },
                        success: function(data) {
                            $('#assignRouteOnTheFly').dialog('close');
                        }
                    });
                });
                //assignRouteOnTheFlyDropDown
            }

            $('body').pleaseWait();
            $.ajax({
                url: '{!! url('/checkIfOrderExistsWithOrderType') !!}',
                type: "POST",
                data: {
                    customerCode: $('#inputCustAcc').val(),
                    deliveryDate: $('#inputDeliveryDate').val(),
                    orderDate: $('#inputOrderDate').val(),
                    routeId: $('#Routeid').val(),
                    OrderType: $('#orderType').val(),
                    orderNo: '',
                    statement: 'Check'
                },
                success: function(data) {
                    console.debug(data);

                    if (data.length > 0) {
                        //e.preventDefault();
                        var dialog = $(
                            '<p>Sorry there is already an order for that delivery date,please click <strong style="color:#356a1b">YES</strong> to add another , <strong style="color:red">NO</strong> to view the existing order or <strong style="color:blue">CANCEL</strong> to restart the process</p>'
                            ).dialog({
                            height: 200,
                            width: "auto",
                            maxWidth: 700,
                            buttons: {
                                "Yes": {
                                    text: "Yes",
                                    class: "btn btn-success btn-sm",
                                    click: function() {
                                        anonymus();
                                        dialog.dialog('close');
                                    }
                                },
                                "No": {
                                    text: "No",
                                    class: "btn btn-danger btn-sm",
                                    click: function() {
                                        multipleDeliveriesOnTheSameDateShowPopUp(data, dialog);
                                    }
                                },
                                "Cancel": {
                                    text: "Cancel",
                                    class: "btn btn-primary btn-sm",
                                    click: function() {
                                        alert('you chose cancel');
                                        dialog.dialog('close');
                                    }
                                }
                            }
                        });

                    } else {
                        anonymus()
                    }
                }
            });

            function anonymus() {

                $.ajax({
                    url: '{!! url('/insertOrderHeader') !!}',
                    type: "POST",
                    data: {
                        customerCode: $('#inputCustAcc').val(),
                        deliveryDate: $('#inputDeliveryDate').val(),
                        orderDate: $('#inputOrderDate').val(),
                        routeId: $('#Routeid').val(),
                        OrderType: $('#orderType').val(),
                        orderNo: '',
                        statement: 'Insert',
                        discount: $('#hiddenCustDiscount').val()
                    },
                    success: function(data) {

                        $('#orderId').val(data.orderId);
                        consoleManagement('{!! url('/logMessageAjax') !!}', 300, 1,
                            'New Order Created For ' + $('#inputCustAcc').val() +
                            ' - ' + data.orderId, 0, 0, 0, 0, 0, 0, 0, 0, +data.orderId,
                            0, computerName, +data.orderId, 0);

                        customerAndGroupSpecials();
                        if (data.counter.CustomerId == "1") {
                            //$('.container').pleaseWait();
                            orderPattern('0');
                            backorderandawaiting(0);
                            $('#orderPatternIdTable_filter input').val('');
                            var Address = '';
                            //countomerSingleAddress ---before
                            Address += $.trim(data.singleAddress.DAddress1) + ' , ' + $
                                .trim(data.singleAddress.DAddress2) + ' , ' + $.trim(data
                                    .singleAddress.DAddress3) + ' , ' + $.trim(data
                                    .singleAddress.DAddress4) + ' , ' + $.trim(data
                                    .singleAddress.DAddress5);
                            Address = Address.replace("null", "");
                            $('#customerSelectedDelDate').val(Address);
                            $('#address1hidden').val(data.singleAddress.DAddress1);
                            $('#address2hidden').val(data.singleAddress.DAddress2);
                            $('#address3hidden').val(data.singleAddress.DAddress3);
                            $('#address4hidden').val(data.singleAddress.DAddress4);
                            $('#address5hidden').val(data.singleAddress.DAddress5);
                            $('#hiddenDeliveryAddressId').val(data.singleAddress
                                .DeliveryAddressID);

                            if (data.singleAddress.CustomerOnHold != "0") {
                                $('#customeronhold').val("ACCOUNT ON HOLD");
                            }

                            console.debug(data.singleAddress.DeliveryAddressID);

                            $('#changeDeliveryAddress').hide();
                            $('#loadingmessage').hide();


                        } else {

                            $.ajax({
                                url: '{!! url('/selectCustomerMultiAddress') !!}',
                                type: "POST",
                                data: {
                                    customerCode: $("#inputCustAcc").val()
                                },
                                success: function(data) {
                                    var toAppend = '';
                                    $.each(data, function(i, o) {
                                        toAppend += '<li value="' + o
                                            .DeliveryAddressID +
                                            '" style="border-bottom: 4px solid black;">' +
                                            o.DAddress1 + ' ' + o
                                            .DAddress2 + ' ' + o
                                            .DAddress3 + '<br>' + o
                                            .DAddress4 + '<br>' + o
                                            .DAddress5 + '</li>';
                                    });
                                    $('#listaddresses').append(toAppend);
                                    $('#changeDeliveryAddress').show();

                                    getDimsUsers('#salesPerson',
                                        '{!! url('/getDimsUsers') !!}');
                                    getDimsUsers('#salesPersonOnDynamic',
                                        '{!! url('/getDimsUsers') !!}');
                                    //$('body').pleaseWait('stop');
                                    // $('#doneCustomAddress').hide();

                                    onClickingDeliveryAddress();
                                    $('#generateDynamicAddress').on('click',
                                        'tr',
                                        function() {
                                            $('#address1').val('');
                                            $('#address2').val('');
                                            $('#address3').val('');
                                            $('#address4').val('');
                                            $('#address5').val('');
                                            //$('#doneCustomAddress').show();
                                            console.debug($(this).closest(
                                                'tr').find('td').eq(
                                                1).text());
                                            $('#address1').val($(this)
                                                .closest('tr').find(
                                                    'td').eq(2).text());
                                            console.debug($('#address1')
                                                .val());
                                            $('#address2').val($(this)
                                                .closest('tr').find(
                                                    'td').eq(3).text());
                                            $('#address3').val($(this)
                                                .closest('tr').find(
                                                    'td').eq(4).text());
                                            $('#address4').val($(this)
                                                .closest('tr').find(
                                                    'td').eq(5).text());
                                            $('#address5').val($(this)
                                                .closest('tr').find(
                                                    'td').eq(6).text());
                                            $('#generalRouteForNewDeliveryAddress')
                                                .prepend('<option value="' +
                                                    $(this).closest('tr')
                                                    .find('#hiddenRouteId')
                                                    .val() +
                                                    '" selected="selected">' +
                                                    $(this).closest('tr')
                                                    .find('td').eq(1)
                                                .text() + '</option>');
                                            $('#deliveryAddressIdOnPopUp')
                                                .val($(this).closest('tr')
                                                    .find(
                                                        '#hiddenDeliveryAddressIdAfterSaved'
                                                        ).val());
                                        });
                                    $('#doneCustomAddress').click(function() {

                                        if ($(
                                                '#generalRouteForNewDeliveryAddress')
                                            .val() === 'null') {
                                            alert(
                                                'The RouteID/Route Name is not correct,Please Choose the Route Or Speak to the manager.');

                                        } else {
                                            orderPattern($(
                                                "#deliveryAddressIdOnPopUp"
                                                ).val());
                                            backorderandawaiting($(
                                                "#deliveryAddressIdOnPopUp"
                                                ).val());
                                            $('#orderPatternIdTable_filter input')
                                                .val('');
                                            $.ajax({
                                                url: '{!! url('/changerouteonorder') !!}',
                                                type: "POST",
                                                data: {
                                                    routeId: $(
                                                            '#generalRouteForNewDeliveryAddress'
                                                            )
                                                        .val(),
                                                    OrderId: $(
                                                            '#orderId'
                                                            )
                                                        .val(),

                                                },
                                                success: function(
                                                    data) {
                                                    //console.debug(data);
                                                    var textAddress =
                                                        $(
                                                            '#address1')
                                                        .val() +
                                                        ' ' +
                                                        $(
                                                            '#address2')
                                                        .val() +
                                                        ' ' +
                                                        $(
                                                            '#address3')
                                                        .val() +
                                                        ' ' +
                                                        $(
                                                            '#address4')
                                                        .val() +
                                                        ' ' +
                                                        $(
                                                            '#address5')
                                                        .val();
                                                    $("#customerSelectedDelDate")
                                                        .val(
                                                            textAddress
                                                            );
                                                    $('#address1hidden')
                                                        .val(
                                                            $(
                                                                '#address1')
                                                            .val()
                                                            );
                                                    $('#address2hidden')
                                                        .val(
                                                            $(
                                                                '#address2')
                                                            .val()
                                                            );
                                                    $('#address3hidden')
                                                        .val(
                                                            $(
                                                                '#address3')
                                                            .val()
                                                            );
                                                    $('#address4hidden')
                                                        .val(
                                                            $(
                                                                '#address4')
                                                            .val()
                                                            );
                                                    $('#address5hidden')
                                                        .val(
                                                            $(
                                                                '#address5')
                                                            .val()
                                                            );
                                                    $('#routeonabutton')
                                                        .val(
                                                            $(
                                                                '#generalRouteForNewDeliveryAddress option:selected')
                                                            .text()
                                                            );
                                                    //$("#hiddenDeliveryAddressId").val($("#deliveryAddressIdOnPopUp").val());
                                                    $("#hiddenDeliveryAddressId")
                                                        .val(
                                                            $(
                                                                "#deliveryAddressIdOnPopUp")
                                                            .val()
                                                            );
                                                    $('#routeName')
                                                        .prepend(
                                                            '<option value="' +
                                                            $(
                                                                '#generalRouteForNewDeliveryAddress')
                                                            .val() +
                                                            '" selected="selected">' +
                                                            $(
                                                                '#generalRouteForNewDeliveryAddress option:selected')
                                                            .text() +
                                                            '</option>'
                                                            );
                                                    $("#listOfDelivAdress")
                                                        .dialog(
                                                            "close"
                                                            );

                                                }
                                            });


                                        }


                                    });

                                }
                            });
                            $('#AddressAddMakeNew').click(function() {
                                $.ajax({
                                    url: '{!! url('/createNewCustomDelvDate') !!}',
                                    type: "POST",
                                    data: {
                                        customerCode: $('#inputCustAcc')
                                            .val(),
                                        address1: $('#Address1Add').val(),
                                        address2: $('#Address2Add').val(),
                                        address3: $('#Address3Add').val(),
                                        address4: $('#Address4Add').val(),
                                        address5: $('#Address5Add').val(),
                                        routeId: $("#AddressAddSelect")
                                        .val(),
                                        SalesPerson: $(
                                                "#salesPersonOnDynamic")
                                            .val(),
                                        SalesPersonName: $(
                                            "#salesPersonOnDynamic option:selected"
                                            ).text(),
                                        routeName: $(
                                            "#AddressAddSelect option:selected"
                                            ).text()
                                    },
                                    success: function(data) {
                                        var toAppend = '';
                                        toAppend +=
                                            '<tr><td><button type="button" id="selectThisAddressOnTable">Select</button></td><td>' +
                                            data.routeName +
                                            '</td><td>' +
                                            data.address1 +
                                            '</td><td>' +
                                            data.address2 +
                                            '</td><td>' +
                                            data.address3 +
                                            '</td><td>' +
                                            data.address4 +
                                            '</td><td>' +
                                            data.address5 +
                                            '</td><td>' +
                                            data.salesName +
                                            '</td><td>' +
                                            '<input type="hidden"  id="hiddenDeliveryAddressIdAfterSaved" value="' +
                                            data.ID +
                                            '"> <input type="hidden"  id="hiddenRouteId" value="' +
                                            $("#AddressAddSelect")
                                        .val() + '"> ' + '</td></tr>';
                                        $('#generateDynamicAddress')
                                            .append(toAppend);
                                    }
                                });

                            });

                            $('#loadingmessage').hide();
                        }
                        $('#orderId').prop('disabled', true);
                        $('#deleteAllLines').show();
                    }
                });
                if (($('#hiddenCustomerNotes').val()).length > 0) {
                    $('#theCustomerNotes').show();
                    showDialog('#theCustomerNotes', 400, 250);
                    $('#putTheCustomerNoteHere').empty();
                    $('#nbNotes').empty();
                    $('#putTheCustomerNoteHere').append($('#hiddenCustomerNotes').val());
                    $('#nbNotes').append($('#hiddenCustomerNotes').val());
                }

                var counts = 0;
                //it used to be countAddress
                /* $.ajax({
         url: countAddress,
         type: "POST",
         data: {customerCode: $("#inputCustAcc").val()},
         success: function (data) {

         counts = data[0].CustomerId;
         console.debug("counts" + counts);

         }
         });*/

                //use the customer route name comming with customer on search


                previousRouteVal = $("#routeName").val();
                previousTextRoute = $("#routeName").find("option:selected").text();
                $("#routeName").data('pre', previousTextRoute);

                $("#routeName").on('change', function() {
                    if (($('#orderId').val()).length > 1) {

                        var toRoute = $(this).find("option:selected").text();
                        var jqThis = $(this).data('pre');

                        $('#authDropDowns').show();
                        showDialogWithoutClose('#authDropDowns', '65%', 320);

                        $('#doAuthDropDown').click(function() {
                            authChangeOfOrderType(toRoute, 'Authorised Route From ' +
                                jqThis + ' To ');
                            $("#routeName").data('pre', toRoute);
                        });
                        $('#doCancelAuthDropDown').click(function() {
                            $("#routeName").prepend('<option value="' +
                                previousRouteVal + '" >' + previousTextRoute +
                                '</option>');
                            $('#authDropDowns').dialog('close');
                        });
                    }
                });

                GlobalOrderType = $("#orderType").val();
                $('#changeDelvDate').val($("#inputDeliveryDate").val());
                GlobalRouteId = $("#routeName").val();
                console.debug("route id" + $("#routeName").val());
                $('.hidebody').show();
                $('.itCanHide').hide();
                // generateALine();

                $.each(wareautocomplete, function(i, item) {
                    $("#headerWh").append("<option value='" + item.ID + "'>" + item.Warehouse +
                        "</option>");
                });
                generateALine2();
                // $("#inputDeliveryDate").prop("disabled", true);
                $("#changeDelvDate").prop("disabled", true);
                $("#inputCustName").prop("disabled", true);
                $("#inputCustAcc").prop("disabled", true);

                //$('#abilityToEmailOrder').show();


                $('#two-columns').css({
                    display: "block"
                });
                $('#submitFilters').hide();




                //getTheCustomerId();


                //PRICES
                $("#codeSearch").autocomplete({
                    source: '{!! url('/prodCode') !!}',
                    minlength: 1,
                    autoFocus: true,
                    select: function(e, ui) {
                        $('#codeSearch').val(ui.item.value);
                        $('#descriptionSearch').val(ui.item.extra);

                        /*GET PRICE *********************************************************/
                        $.ajax({
                            url: '{!! url('/priceSearch') !!}',
                            type: "POST",
                            data: {
                                customerCode: $('#inputCustAcc').val(),
                                deliveryDate: $('#inputDeliveryDate').val(),
                                prodCode: ui.item.value
                            },
                            success: function(data) {

                                var trHTML = '';

                                $.each(data, function(key, value) {
                                    trHTML +=
                                        '<tr  style="font-size: 9px;color:black"><td>' +
                                        ui.item.extra + '</td><td>' +
                                        parseFloat(value.Price).toFixed(
                                            2) + '</td><td>' +
                                        '</tr>';


                                });
                                $('#priceLookUpResult').append(trHTML);

                            }
                        }); //End of get price

                    }
                });
                $("#descriptionSearch").autocomplete({
                    source: '{!! url('/prodDesciption') !!}',
                    minlength: 1,
                    autoFocus: true,
                    select: function(e, ui) {
                        $('#descriptionSearch').val(ui.item.value);
                        $('#codeSearch').val(ui.item.extra);

                        /*GET PRICE *********************************************************/
                        $.ajax({
                            url: '{!! url('/priceSearch') !!}',
                            type: "POST",
                            data: {
                                customerCode: $('#inputCustAcc').val(),
                                deliveryDate: $('#inputDeliveryDate').val(),
                                prodCode: ui.item.extra
                            },
                            success: function(data) {
                                $('#priceLookUpResult').empty();
                                var trHTML = '';

                                $.each(data, function(key, value) {
                                    trHTML +=
                                        '<tr class="fast_remove" style="font-size: 9px;color:black"><td>' +
                                        ui.item.value + '</td><td>' +
                                        parseFloat(value.Price).toFixed(
                                            2) + '</td><td>' +
                                        '</tr>';


                                });
                                $('#priceLookUpResult').append(trHTML);

                            }
                        }); //End of get price

                    }
                });
            }

            if (($('#invoiceNo').val()).length > 1) {
                $('#changeDeliveryAddressOnNotInvoiced').hide();
            } else {
                $('#changeDeliveryAddressOnNotInvoiced').show();
            }

            $('body').pleaseWait('stop');
            // $('#checkdeliverydate').show();
            // showDialog('#checkdeliverydate',700,200);
            $('#delvokay').click(function() {
                $('#checkdeliverydate').dialog('close');

                /* $.ajax({
            url: ,
            type: "POST",
            data: {
                customerCode: $('#inputCustAcc').val(),
                delvDate: $('#inputDeliveryDate').val(),
                OrderId: $('#orderId').val(),

            },
            success: function (data) {

            }
        });*/


            });
        }); //END OF SUBMITFILTER

        $("#pdfexportorder").click(function() {

            {

                if (($('#invoiceNo').val()).length > 3) {
                    window.open('{!! url('/pdforder') !!}/' + $('#orderId').val(), "PDF",
                        "location=1,status=1,scrollbars=1, width=1200,height=850");
                    //View PDF
                } else {
                    window.open('{!! url('/pdforder') !!}/' + $('#orderId').val(), "PDF",
                        "location=1,status=1,scrollbars=1, width=1200,height=850");
                }

            }
            saveorderswithoutExtrasPDF();
        });

        $('#excelexportorder').click(function() {
            saveorderswithoutExtras();
        });
        $('#copyThisOrder').click(function() {
            getOrderTypes('#CopyorderType', '{!! url('/deliveryTypes') !!}');
            $('#copyOrderDialog').show();
            $("#copyOrderDialog").dialog({
                height: 400,
                width: 700,
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
            $('#copyCustCode').val($('#inputCustAcc').val());
            $('#copyRouteID').val($('#routeName').val());

            $('#submitCopyOrder').click(function() {

                $.ajax({
                    url: '{!! url('/copyInvoice') !!}',
                    type: "POST",
                    data: {
                        customerCode: $('#copyCustCode').val(),
                        delvDate: $('#copyDeliveryDate').val(),
                        orderType: $('#CopyorderType').val(),
                        delvAddress: $('#hiddenDeliveryAddressId').val(),
                        routeId: $('#copyRouteID').val(),
                        orderNo: $('#orederNumber').val(),
                        OrderId: $('#orderId').val(),

                    },
                    success: function(data) {
                        $('#copyOrderDialogComfirmation').show();
                        $('#copyOrderDialogComfirmation').dialog({
                            height: 200,
                            width: 900,
                            containment: false
                        }).dialogExtend({
                            "closable": true, // enable/disable close button
                            "maximizable": false, // enable/disable maximize button
                            "minimizable": false, // enable/disable minimize button
                            "collapsable": false, // enable/disable collapse button
                            "dblclick": false, // set action on double click. false, 'maximize', 'minimize', 'collapse'
                            "titlebar": false, // false, 'none', 'transparent'
                            "minimizeLocation": "right", // sets alignment of minimized dialogues
                            "icons": { // jQuery UI icon class
                                "close": "ui-icon-circle-close",
                            },
                            "load": function(evt, dlg) {}, // event
                            "beforeMaximize": function(evt,
                            dlg) {}, // event
                            "beforeMinimize": function(evt,
                            dlg) {}, // event
                            "beforeRestore": function(evt, dlg) {}, // event
                        });
                        $('.newOrderId').empty();
                        $('.newOrderId').append(data[0].OrderId);
                        $("#copyOrderDialog").dialog("close");
                    }
                });
            });
        });
        $('#printPDFPickIndOrder').click(function() {

            var productsLinesOnPickingOneOrder = new Array();
            $('#table > tbody  > tr').each(function() {
                var data = $(this);
                var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                console.debug($(this).closest('tr').find('.theProductCode_').val());
                if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                    productsLinesOnPickingOneOrder.push({
                        'productCode': $(this).closest('tr').find('.theProductCode_')
                            .val(),
                        'desc': $(this).closest('tr').find('.prodDescription_').val(),
                        'qty': $(this).closest('tr').find('.prodQty_').val(),
                        'price': $(this).closest('tr').find('.prodPrice_').val(),
                        'comment': $(this).closest('tr').find('.prodComment_').val(),
                        'orderDetailID': orderDetailID,
                        'customerCode': $('#inputCustAcc').val(),
                        'prodDisc': $(this).closest('tr').find('.prodDisc_').val()
                    });
                }

            });
            //printPickingSlipPerOrder


            $.ajax({
                url: '{!! url('/printPickingSlipPerOrder') !!}',
                type: "POST",
                data: {
                    OrderId: $('#orderId').val(),
                    orderDetails: productsLinesOnPickingOneOrder,
                },
                success: function(data) {
                    console.debug(data);
                    // upDateOrderHeaderAndPOS();
                }
            });
        });

        $('#changeDeliveryAddress').click(function() {
            $('#listOfDelivAdress').show();
            $("#listOfDelivAdress").dialog({
                height: 700,
                width: 1100,
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
            });;
            $('#listaddresses li').on('click', function() {
                var $this = $(this);
                var selKeyVal = $this.attr("value");
                $("#deliveryAddressIdOnPopUp").val(selKeyVal);
                $("#hiddenDeliveryAddressId").val(selKeyVal);
            });

        });
        /*  $('#orderPatternIdTable').on('dblclick', 'tr', function() {
 $(this).closest("tr").hide();
 });*/

        $('.inputs').keydown(function(event) {
            if (!$(this).hasClass("last")) {
                if (event.which == 13) {
                    event.preventDefault();

                    // generateALine();
                }
            }
        });
        /**
         * ON Double Click pattern row add this to the busket
         * */
        $('#orderPatternIdTable').on('dblclick', 'tbody tr', function() {

            if (($('#invoiceNoKeeper').val()).length < 2) {

                var $this = $(this);
                var row = $this.closest("tr");
                var producutDescr = row.find('td:eq(0)').text();
                var cost = row.find('td:eq(4)').text();
                var inStock = row.find('td:eq(3)').text();
                //var productCode = row.find('td:eq(6)').text(); when you hide it
                var productCode = row.find('td:eq(7)').text();

                var tax = row.find('td:eq(9)').text();
                var unitSizes = row.find('td:eq(10)').text();
                var UnitWeight = row.find('td:eq(11)').text();
                var SoldByWeight = row.find('td:eq(12)').text();
                var strBulkUnit = row.find('td:eq(13)').text();
                var ProductMargin = row.find('td:eq(14)').text();
                var isCheckedOrderPatternAuth = true;

                if (inStock < 1) {
                    isCheckedOrderPatternAuth = false;
                    $('#appendErrormsg').empty();
                    $('#appendErrormsg').append("It appears that you don't have enough in stock");
                    showDialogWithoutClose("#authorisations", 500, 400);
                    //if (e.keyCode == 27) return false;
                    $('#noThanksRedo').off().click(function() {

                        calculator();

                        $("#authorisations").dialog('close');
                    });
                    $('#doAuth').off().click(function() {
                        // $('#userAuthName').val();
                        console.debug($('#userAuthPassWord').val());
                        $('#userAuthPassWord').val();
                        $.ajax({
                            url: '{!! url('/verifyAuthMario') !!}',
                            type: "POST",
                            data: {
                                userName: $('#userAuthName').val(),
                                userPassword: $('#userAuthPassWord').val()
                            },
                            success: function(data) {
                                //console.debug("bunch"+data);
                                if ($.isEmptyObject(data)) {
                                    alert(
                                        "Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                                } else {
                                    $('#userAuthName').val('');
                                    $('#userAuthPassWord').val('');
                                    isCheckedOrderPatternAuth = true;
                                    consoleManagementAuths(
                                        '{!! url('/logMessageAuth') !!}', 12, 1,
                                        'Authorized out os Stock by ' + data[0]
                                        .UserName,
                                        0, $('#orderId').val(), '', $(
                                            '#inputCustAcc').val(), 0, 0, 0, $(
                                            '#userNewVariable').val(), $(
                                            '#orderId').val(), 0, computerName,
                                        $('#orderId').val(), 0, data[0].UserID,
                                        data[0].UserName);
                                    $("#authorisations").dialog('close');
                                    calculator();


                                }
                            }
                        });

                    });

                }

                //var tax = '14.0';
                //console.debug("unitSizes on double click"+unitSizes);
                $('#availableOnTheFly').empty();

                //console.debug("************************ProductMargin ------"+ProductMargin);
                if (isCheckedOrderPatternAuth) {

                    productPriceOnReadyMadeLine(productCode, producutDescr, tax, cost, isAuthMyLine,
                        inStock, unitSizes, UnitWeight, SoldByWeight, strBulkUnit, ProductMargin,
                        multiLines);
                    // console.debug("*************"+ $(this).find(".prodPrice_").val(12));
                    row.remove();
                }
            }

        });
        $('#orderPatternIdTable').on('click', 'tbody tr', function() {

            // if (($('#invoiceNoKeeper').val()).length < 2) {
            var $this = $(this);
            var row = $this.closest("tr");
            var productCode = row.find('td:eq(6)').text();
            switch (donotshowAvailable) {
                case 'FALSE':
                    qtyAvailableOnClick(productCode);
                    break;
            }


            //}

        });
        $('#customerSpecials tbody').on('dblclick', 'tr', function() {
            //Disable double click  orderPatternIdTable
            if (($('#invoiceNoKeeper').val()).length < 2) {

                var $this = $(this);
                var row = $this.closest("tr");
                var producutDescr = row.find('td:eq(0)').text();
                var productCode = row.find('td:eq(1)').text();
                var uom = row.find('td:eq(5)').text();
                var Prodcost = $(this).find('#Prodcost').val();
                var ProdQnt = $(this).find('#ProdQnt').val();
                var titles = isAuthMyLine; //$(this).find('#titles').val();
                var tax = $(this).find('#taxCode').val();
                var SoldByWeight = $(this).find('#soldByWieght').val();
                var strBulkUnit = $(this).find('#strBulkUnit').val();
                var UnitWeight = $(this).find('#UnitWeight').val();
                var ProductMargin = $(this).find('#ProductMargin').val();
                var price = '';
                console.debug("ke nna" + SoldByWeight);
                //tag,prodDesc,prodCodes,prodQty,price,cost,instock,titles
                // console.debug("*************"+ $(this).find(".prodPrice_").val(12));
                productPriceOnReadyMadeLine(productCode, producutDescr, tax, Prodcost, titles, ProdQnt,
                    uom, UnitWeight, SoldByWeight, strBulkUnit, ProductMargin, multiLines);

            }
        });
        $('#groupSpecials tbody').on('dblclick', 'tr', function() {
            if (($('#invoiceNoKeeper').val()).length < 2) {

                var $this = $(this);
                var row = $this.closest("tr");
                var producutDescr = row.find('td:eq(0)').text();
                var productCode = row.find('td:eq(1)').text();
                var uom = row.find('td:eq(5)').text();
                var Prodcost = $(this).find('#Prodcost').val();
                var ProdQnt = $(this).find('#ProdQnt').val();
                var titles = isAuthMyLine; //$(this).find('#titles').val();
                var tax = $(this).find('#taxCode').val();
                var SoldByWeight = $(this).find('#SoldByWeight').val();
                var strBulkUnit = $(this).find('#strBulkUnit').val();
                var UnitWeight = $(this).find('#UnitWeight').val();
                var ProductMargin = $(this).find('#ProductMargin').val();
                var price = '';


                productPriceOnReadyMadeLine(productCode, producutDescr, tax, Prodcost, titles, ProdQnt,
                    uom, UnitWeight, SoldByWeight, strBulkUnit, ProductMargin, multiLines);

            }

        });
        /**
         * ON Double click the past invoice product add  it to the busket
         * */
        $('#pastInvoices tbody').on('dblclick', 'tr', function() {
            //Disable the double click if it is already invoiced
            if (($('#invoiceNoKeeper').val()).length < 2) {

                if ($(this).find(".dontTakeme").val().length > 1) {} else {
                    var productCode = $(this).find(".foo").val();
                    var $this = $(this);
                    var row = $this.closest("tr");
                    var producutDescr = row.find('td:eq(0)').text();
                    var Prodcost = $(this).find('#Prodcost').val();
                    var ProdQnt = $(this).find('#ProdQnt').val();
                    var titles = isAuthMyLine; //$(this).find('#titles').val();
                    var tax = $(this).find('#taxCode').val();
                    var UnitSizes = $(this).find('#UnitSizes').val();
                    var SoldByWeight = $(this).find('#SoldByWeight').val();
                    var strBulkUnit = $(this).find('#strBulkUnit').val();
                    var UnitWeight = $(this).find('#UnitWeight').val();
                    var ProductMargin = $(this).find('#ProductMargin').val();
                    console.debug(" on PastInvoice" + UnitSizes);
                    var priceReturned = getPriceForProductDependingOnCustAndDeliveryDate(
                        '{!! url('/getCutomerPriceOnOrderForm') !!}', $('#inputCustAcc').val(), $(
                            '#inputDeliveryDate').val(), productCode, $('#headerWh').val());
                    console.debug('priceReturned' + priceReturned);

                    $.ajax({
                        url: '{!! url('/getCutomerPriceOnOrderForm') !!}',
                        type: "POST",
                        data: {
                            customerID: $('#inputCustAcc').val(),
                            deliveryDate: $('#inputDeliveryDate').val(),
                            productCode: productCode,
                            warehouseid: $('#headerWh').val()
                        },
                        success: function(data) {
                            //console.debug('sluuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuut');
                            var weneedauth = 0;
                            if (data[0].theMg == "NEEDAUTH") {
                                weneedauth = 1;

                            }
                            console.debug(data);
                            var price = '';
                            if ($.isEmptyObject(data)) {
                                price = '';
                                linetotal(1, 0, tax, marginCalculator(0, 0));
                                readyMadeLineOrderLine('#table tbody', producutDescr,
                                    productCode, '', price, Prodcost, ProdQnt, titles,
                                    tax, UnitSizes, '0', UnitWeight, SoldByWeight,
                                    strBulkUnit, ProductMargin, multiLines, data[0]
                                    .LineDisc, linediscount, weneedauth);
                            } else {
                                price = parseFloat(data[0].Price).toFixed(2);
                                console.debug('something' + data[0].LineDisc);
                                linetotal(1, price, tax, marginCalculator(data[0].Cost,
                                    price));
                                if (reportmarginControl === 'marginType5') {
                                    console.debug('margin 5' + data[0].LineDisc);
                                    console.debug('linediscount# ' + linediscount);
                                    readyMadeLineOrderLine('#table tbody', producutDescr,
                                        productCode, '', price, Prodcost, ProdQnt,
                                        titles, tax, UnitSizes, data[0].Prohibited,
                                        UnitWeight, SoldByWeight, strBulkUnit,
                                        ProductMargin, multiLines, data[0].LineDisc,
                                        linediscount, weneedauth);

                                } else {
                                    console.debug('margin not 5' + data[0].LineDisc);
                                    console.debug('linediscount not# ' + linediscount);
                                    readyMadeLineOrderLine('#table tbody', producutDescr,
                                        productCode, '', price, Prodcost, ProdQnt,
                                        titles, tax, UnitSizes, data[0].Prohibited,
                                        UnitWeight, SoldByWeight, strBulkUnit,
                                        multiLines, data[0].LineDisc, linediscount,
                                        weneedauth);
                                }
                            }

                        }
                    });

                    row.remove();
                }
            }
        });


        //On click show available
        $('#table tbody').on('click', 'tr', function() {

            var $this = $(this);
            var row_closestTrColumns = $this.closest('tr');
            var prodCode1 = row_closestTrColumns.find('.theProductCode_').val();
            if (prodCode1.length > 0) {
                qtyAvailableOnClick(prodCode1);
            } else {
                console.debug('product code length*******' + prodCode1.length);
            }


        });

        datePicker();
        validate();
        $('#inputCustAcc, #inputCustName, #inputDeliveryDate,#routeName').change(validate);
        $("#routeName").on("change", function() {
            GlobalRouteId = this.value;
        });

        /* $("#orderType").on("change", function () {

        // alert('Please change this');
        //GlobalOrderType = this.value;
        });*/
        var previous;
        var previousText;
        var previousRouteVal;
        var previousTextRoute;


        var lastValue;
        $("#orderType").bind("click", function(e) {
            lastValue = $(this).val();
        }).bind("change", function(e) {
            changeConfirmation = confirm("Are you sure?");
            if (changeConfirmation) {
                if (($('#orderId').val()).length > 1) {

                    consoleManagement('{!! url('/logMessageAjax') !!}', 12, 1, 'OrderType Changed To ' + $(
                            "#orderType").find("option:selected").text() + ' by ' + byWho, 0, $(
                            '#orderId').val(), 0, 0, 0, 0, 0, 0, $('#orderId').val(), 0,
                        computerName, $('#orderId').val(), 0);
                }
            } else {
                $(this).val(lastValue);
            }
        });

        /* $("#orderType").on('change', function () {
            if( ($('#orderId').val()).length > 1 ) {

            }
        });*/

        /* ON BUTTON TO CREATE NEW LINE*/
        $('#button_row').click(function() {
            var tr = $('#table tr:last');
            GLOBALPRODCODE = $(tr).find("td").find('input.theProductCode_').val();
            GLOBALPRODUCTDESCRIPTION = $(tr).find("td").find('input.prodDescription_').val();
            GLOBALPRICE = $(tr).find("td").find('input.prodPrice_').val();
            GLOBALQUANTITY = $(tr).find("td").find('input.prodQty_').val();
            GLOBALBULK = $(tr).find("td").find('input.prodBulk_').val();
            GLOBALCOMMENT = $(tr).find("td").find('input.prodComment_').val();
            GLOBALDISC = $(tr).find("td").find('input.prodDisc_').val();

            if (GLOBALQUANTITY.length > 0 &&
                GLOBALPRODCODE.length > 0 &&
                GLOBALPRICE.length > 0 &&
                GLOBALPRODUCTDESCRIPTION.length > 0) {

                TotalExc = TotalExc + (parseFloat(GLOBALPRICE) * parseFloat(GLOBALQUANTITY)).toFixed(2);
                //generateALine();
                generateALine2();
            } else {
                $("<div title='Fill in required fields'>Please make sure all required fields such as: <br>Product code and Description<br>Quantity<br> Price<br> Discount <br>Contains Data Before saving </div>")
                    .dialog({
                        modal: true,
                        width: 360
                    });

            }

        });
        /* $('#cancelThis').on('click', function () {
            //test
            $(this).closest('tr').remove();
            calculator();
        });*/

        /* END OF -----ON BUTTON TO CREATE NEW LINE*/
        var inputCustNames = $('#inputCustName').flexdatalist({
            minLength: getMinimumLengthOnSearch(),
            valueProperty: '*',
            selectionRequired: true,
            focusFirstResult: true,
            searchContain: true,
            visibleProperties: ["StoreName", "CustomerPastelCode"],
            searchIn: 'StoreName',
            //data: finalData
            url: "{{  route('sales-order.get-sales-order-customers') }}",
        });
        inputCustNames.on('select:flexdatalist', function(event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#inputDeliveryDate').focus();
            $('#creditLimit').val(data.CreditLimit);
            $('#balDue').val(parseFloat(data.BalanceDue).toFixed(2));
            $('#boozeLisence').val(data.UserField5);
            $("#submitFilters").prop("disabled", false);
            $('#customerEmail').val(data.Email);
            $('#Routeid').val(data.Routeid);
            $('#hiddenCustDiscount').val(data.Discount);
            $('#dicPercHeader').val(data.Discount);
            $('#hiddenCustomerNotes').val(data.OtherImportantNotes);
            $('#hiddenRouteId').val(data.Routeid);
            $('#hiddenRouteName').val(data.strRoute);
            $('#routeonabutton').val(data.strRoute);
            $('#hiddencustomerGp').val(data.mnyCustomerGp);
            $('#CustomerId').val(data.CustomerId);
            $('#customerpricelist').val(data.termsAndList);

            $("#headerWh").prepend("<option value='" + data.ID + "'>" + data.Warehouse + "</option>");
            GlobalcustomerId = data.CustomerId;
            console.debug("onhold" + data.CustomerOnHold);

            if (data.CustomerOnHold != 0) {
                var dialog = $('<p><strong style="color:red">Account on Hold</strong></p>').dialog({
                    height: 200,
                    width: 700,
                    modal: true,
                    containment: false,
                    buttons: {
                        "Ignore": {
                            text: "Ignore",
                            class: "btn btn-success btn-sm",
                            click: function() {
                                dialog.dialog('close');
                            }
                        },
                        "CANCEL": {
                            text: "CANCEL",
                            class: "btn btn-primary btn-sm",
                            click: function() {
                                $('#inputCustAcc').val('');
                                $('#inputCustName').val('');
                                dialog.dialog('close');
                            }
                        }
                    }
                });
            }
        });


        //////////////////////////////////////////////////

        var custAcc = $('#customerCodeOrderListing').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain: true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode", "StoreName"],
            searchIn: 'CustomerPastelCode',
            data: finalDataAll
        });

        var custDescriptionOrderListing = $('#customerDescriptionOrderListing').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain: true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode", "StoreName"],
            searchIn: 'StoreName',
            data: finalDataAll
        });
        custDescriptionOrderListing.on('select:flexdatalist', function(event, data) {

            $('#customerCodeOrderListing').val(data.CustomerPastelCode);
            $('#customerDescriptionOrderListing').val(data.StoreName);

        });
        custAcc.on('select:flexdatalist', function(event, data) {

            $('#customerCodeOrderListing').val(data.CustomerPastelCode);
            $('#customerDescriptionOrderListing').val(data.StoreName);

        });

        ///////////////////

        var inputCustAccount = $('#inputCustAcc').flexdatalist({
            minLength: getMinimumLengthOnSearch(),
            valueProperty: '*',
            selectionRequired: true,
            searchContain: true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode", "StoreName"],
            searchIn: 'CustomerPastelCode',
            //data: finalData
            url: "{{  route('sales-order.get-sales-order-customers') }}",
        });
        inputCustAccount.on('select:flexdatalist', function(event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#inputDeliveryDate').focus();
            $('#creditLimit').val(data.CreditLimit);
            $('#balDue').val(parseFloat(data.BalanceDue).toFixed(2));
            $('#boozeLisence').val(data.UserField5);
            $("#submitFilters").prop("disabled", false);
            $('#customerEmail').val(data.Email);
            $('#Routeid').val(data.Routeid);
            $('#hiddenCustDiscount').val(data.Discount);
            $('#dicPercHeader').val(data.Discount);
            $('#hiddenCustomerNotes').val(data.OtherImportantNotes);
            $('#hiddenRouteId').val(data.Routeid);
            $('#hiddenRouteName').val(data.strRoute);
            $('#routeonabutton').val(data.strRoute);
            $('#hiddencustomerGp').val(data.mnyCustomerGp);
            $('#CustomerId').val(data.CustomerId);
            $('#customerpricelist').val(data.termsAndList);
            $("#headerWh").prepend("<option value='" + data.ID + "'>" + data.Warehouse + "</option>");
            GlobalcustomerId = data.CustomerId;
            console.debug("onhold" + data.CustomerOnHold);
            if (data.CustomerOnHold != 0) {
                var dialog = $('<p><strong style="color:red">Account on Hold</strong></p>').dialog({
                    height: 200,
                    width: 700,
                    modal: true,
                    containment: false,
                    buttons: {
                        "Ignore": {
                            text: "Ignore",
                            class: "btn btn-success btn-sm",
                            click: function() {
                                dialog.dialog('close');
                            }
                        },
                        "CANCEL": {
                            text: "CANCEL",
                            class: "btn btn-primary btn-sm",
                            click: function() {
                                $('#inputCustAcc').val('');
                                $('#inputCustName').val('');
                                dialog.dialog('close');
                            }
                        }
                    }
                });
            }

        });
        var custCodeOnOrder = $('#custCodeOnOrder').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain: true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode", "StoreName"],
            searchIn: 'CustomerPastelCode',
            data: finalData
        });
        custCodeOnOrder.on('select:flexdatalist', function(event, data) {

            $('#custCodeOnOrder').val(data.CustomerPastelCode);
            $('#custDescOnOrder').val(data.StoreName);

        });
        var custCodePl = $('#custCodePl').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain: true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode", "StoreName"],
            searchIn: 'CustomerPastelCode',
            data: finalData
        });
        custCodePl.on('select:flexdatalist', function(event, data) {

            $('#custCodePl').val(data.CustomerPastelCode);
            $('#custDescPl').val(data.StoreName);
            $('#custId').val(data.CustomerId);

        });
        var custDescOnOrder = $('#custDescOnOrder').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain: true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode", "StoreName"],
            searchIn: 'StoreName',
            data: finalData
        });
        custDescOnOrder.on('select:flexdatalist', function(event, data) {

            $('#custCodeOnOrder').val(data.CustomerPastelCode);
            $('#custDescOnOrder').val(data.StoreName);

        });

        var custDescPl = $('#custDescPl').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain: true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode", "StoreName"],
            searchIn: 'StoreName',
            data: finalData
        });
        custDescPl.on('select:flexdatalist', function(event, data) {

            $('#custCodePl').val(data.CustomerPastelCode);
            $('#custDescPl').val(data.StoreName);
            $('#custId').val(data.CustomerId);

        });

        $("#productCodeOnOrder").mcautocomplete({
            //source: finalDataProduct,
            source: function(req, response) {
                $.ajax({
                    url: "{{ route('sales-order.get-sales-order-products') }}",
                    dataType: "json",
                    data: {
                        term: req.term
                    },
                    success: function(data) {
                        console.log(data);
                        response(data);
                    }
                });
            },
            columns: columnsC,
            minLength: getMinimumLengthOnSearch(),
            autoFocus: true,
            delay: 0,
            select: function(e, ui) {
                $('#productDescOnOrder').val(ui.item.PastelDescription);
                $('#productCodeOnOrder').val(ui.item.PastelCode);
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
        $("#productCodeOnOrder").mcautocomplete({
            //source: finalDataProduct,
            source: function(req, response) {
                $.ajax({
                    url: "{{ route('sales-order.get-sales-order-products') }}",
                    dataType: "json",
                    data: {
                        term: req.term
                    },
                    success: function(data) {
                        console.log(data);
                        response(data);
                    }
                });
            },
            columns: columnsC,
            minLength: getMinimumLengthOnSearch(),
            autoFocus: true,
            delay: 0,
            appendTo: "#prodOnOrder",
            select: function(e, ui) {
                $('#productDescOnOrder').val(ui.item.PastelDescription);
                $('#productCodeOnOrder').val(ui.item.PastelCode);
            }
        });
        $("#productCodeOnInvoice").mcautocomplete({
            //source: finalDataProduct,
            source: function(req, response) {
                $.ajax({
                    url: "{{ route('sales-order.get-sales-order-products') }}",
                    dataType: "json",
                    data: {
                        term: req.term
                    },
                    success: function(data) {
                        console.log(data);
                        response(data);
                    }
                });
            },
            columns: columnsC,
            minLength: getMinimumLengthOnSearch(),
            autoFocus: true,
            delay: 0,
            appendTo: "#prodonInvoice",
            select: function(e, ui) {
                $('#productDescOnInvoiced').val(ui.item.PastelDescription);
                $('#productCodeOnInvoice').val(ui.item.PastelCode);
            }
        });

        $("#productCodePl").mcautocomplete({
            //source: finalDataProduct,
            source: function(req, response) {
                $.ajax({
                    url: "{{ route('sales-order.get-sales-order-products') }}",
                    dataType: "json",
                    data: {
                        term: req.term
                    },
                    success: function(data) {
                        console.log(data);
                        response(data);
                    }
                });
            },
            columns: columnsC,
            minLength: getMinimumLengthOnSearch(),
            autoFocus: true,
            delay: 0,
            appendTo: "#priceLookPriceWithCustomer",
            select: function(e, ui) {
                $('#productDescPl').val(ui.item.PastelDescription);
                $('#productCodePl').val(ui.item.PastelCode);
                $('#unitOfSale').empty();
                $('#unitOfSale').append(ui.item.UnitSize);
                $('#prodId').val(ui.item.ProductId);

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
        $("#productDescOnOrder").mcautocomplete({
            //source: finalDataProductTest,
            source: function(req, response) {
                $.ajax({
                    url: "{{ route('sales-order.get-sales-order-products') }}",
                    dataType: "json",
                    data: {
                        term: req.term
                    },
                    success: function(data) {
                        console.log(data);
                        response(data);
                    }
                });
            },
            columns: columnsD,
            autoFocus: true,
            minLength: getMinimumLengthOnSearch(),
            delay: 0,
            multiple: true,
            multipleSeparator: " ",
            appendTo: "#prodOnOrder",
            select: function(e, ui) {
                $('#productDescOnOrder').val(ui.item.PastelDescription);
                $('#productCodeOnOrder').val(ui.item.PastelCode);
            }
        });
        $("#productDescOnInvoiced").mcautocomplete({
            //source: finalDataProductTest,
            source: function(req, response) {
                $.ajax({
                    url: "{{ route('sales-order.get-sales-order-products') }}",
                    dataType: "json",
                    data: {
                        term: req.term
                    },
                    success: function(data) {
                        console.log(data);
                        response(data);
                    }
                });
            },
            columns: columnsD,
            autoFocus: true,
            minLength: getMinimumLengthOnSearch(),
            delay: 0,
            multiple: true,
            multipleSeparator: " ",
            appendTo: "#prodonInvoice",
            select: function(e, ui) {
                $('#productDescOnInvoiced').val(ui.item.PastelDescription);
                $('#productCodeOnInvoice').val(ui.item.PastelCode);
            }
        });
        $("#productDescPl").mcautocomplete({
            //source: finalDataProductTest,
            source: function(req, response) {
                $.ajax({
                    url: "{{ route('sales-order.get-sales-order-products') }}",
                    dataType: "json",
                    data: {
                        term: req.term
                    },
                    success: function(data) {
                        console.log(data);
                        response(data);
                    }
                });
            },
            columns: columnsD,
            autoFocus: true,
            minLength: getMinimumLengthOnSearch(),
            delay: 0,
            multiple: true,
            multipleSeparator: " ",
            appendTo: "#priceLookPriceWithCustomer",
            select: function(e, ui) {
                $('#productDescPl').val(ui.item.PastelDescription);
                $('#productCodePl').val(ui.item.PastelCode);
                $('#unitOfSale').empty();
                $('#unitOfSale').append(ui.item.UnitSize);
                $('#prodId').val(ui.item.ProductId);
            }
        });



        $("#invoiceNo").autocomplete({
            source: '{!! url('/invoiceLookUp') !!}',
            minLength: getMinimumLengthOnSearch(),
            autoFocus: true,
            select: function(e, ui) {
                $('#invoiceNo').val(ui.item.value);
                $('#orderId').val(ui.item.id);
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            if (item.value) {
                var table = `
                    <table class="table2">
                        <tr style="font-size: 12px;color:black">
                            <td style="background: green;width:25px;color:white;white-space: nowrap;" colspan="4">
                                ${item.value}
                            </td>
                        </tr>
                    </table>
                `;
                if (item.id)
                {
                    var table =
                        '<table class="table2"><tr style="font-size: 12px;color:black"><td style="background: green;width:25px;color:white">' +
                        item.value + '</td><td>' +
                        item.id + '</td><td style="background: green;width:25px;color:white">' +
                        item.CustomerPastelCode + '</td><td>' +
                        item.StoreName + '</td>' +
                        '</tr></table>';
                }
                return $("<li>")
                    .data("ui-autocomplete-item", item)
                    .append("<a>" + table + "</a>")
                    .appendTo(ul);
            }

            return $("<li>")
                .append("<a></a>")
                .appendTo(ul);
        };

        $('#theProductCode').autocomplete({
            source: '{!! url('/prodCode') !!}',
            minlength: 1,
            autoFocus: true,
            select: function(e, ui) {
                $('#theProductCode').val(ui.item.value);
                $('#theProductDescription').val(ui.item.extra);
                //generateALine();
                generateALine2();
                $.ajax({
                    url: '{!! url('/getCutomerPriceOnOrderForm') !!}',
                    type: "POST",
                    data: {
                        customerID: $('#inputCustAcc').val(),
                        deliveryDate: $('#inputDeliveryDate').val(),
                        productCode: $('#theProductCode').val(),
                        warehouseid: $('#headerWh').val()
                    },
                    success: function(data) {
                        console.debug("********************" + data[0].AvailableToSell);

                        console.debug("the price" + parseFloat(data[0].Price).toFixed(
                            2));
                        $('#thePrice').val(parseFloat(data[0].Price).toFixed(2));

                    }
                });
            }
        });

        $('#theProductDescription').autocomplete({
            source: '{!! url('/prodDesciption') !!}',
            minlength: 2,
            autoFocus: true,
            select: function(e, ui) {
                $('#theProductDescription').val(ui.item.value);
                $('#theProductCode').val(ui.item.extra);
                //generateALine();
                generateALine2();
                $('#theQuantity').val("0.00");
                $('#theDisc').val("0.00");
                $('#theUnitSize').val(ui.item.unitSize);

                $.ajax({
                    url: '{!! url('/getCutomerPriceOnOrderForm') !!}',
                    type: "POST",
                    data: {
                        customerID: $('#inputCustAcc').val(),
                        deliveryDate: $('#inputDeliveryDate').val(),
                        productCode: $('#theProductCode').val(),
                        warehouseid: $('#headerWh').val()
                    },
                    success: function(data) {
                        console.debug("the price" + parseFloat(data[0].Price).toFixed(
                            2));
                        $('#thePrice').val(parseFloat(data[0].Price).toFixed(2));

                    }
                });
            }
        });
        $('#invoiceNow').on('click', function() {
            $('<div></div>').appendTo('body')
                .html('<div><h6>Yes or No?</h6></div>')
                .dialog({
                    modal: true,
                    title: 'Click Yes to invoice this Order or No to save',
                    zIndex: 10000,
                    autoOpen: true,
                    width: '50%',
                    resizable: false,
                    buttons: {
                        DelUser: {
                            text: 'Point Of Sale ',
                            class: 'leftButton btn btn-primary btn-sm',
                            click: function() {
                                allInoneDocumentsave("POS");
                            }
                        },
                        Yes: {
                            text: "Yes",
                            class: "btn btn-success btn-sm",
                            click: function() {
                                //Update the tblOrders and tblOrdersDetails here
                                calculator();
                                allInoneDocumentsave("INVOICEIT");
                                $(this).dialog("close");
                            }
                        },
                        No: {
                            text: "No",
                            class: "btn btn-warning btn-sm",
                            click: function() {
                                $(this).dialog("close");
                            }
                        }
                    },
                    close: function(event, ui) {
                        $(this).remove();
                    }
                });
        });
        $('#updatecontactsontheorder').on('click', function() {

            $.ajax({
                url: '{!! url('/updateCContactsOnOrder') !!}',
                type: "POST",
                data: {
                    CustomerPastelCode: $('#inputCustAcc').val(),
                    contactCellOnDispatch: $('#contactCellOnDispatch').val(),
                    telOnDispatch: $('#telOnDispatch').val(),
                    contactPersonOnDispatch: $('#contactPersonOnDispatch').val()
                },
                success: function(data) {
                    if (data == 1) {
                        var dialog = $(
                            '<p><strong style="color:red">Contact Info updated successfully</strong></p>'
                            ).dialog({
                            height: 200,
                            width: 700,
                            modal: true,
                            containment: false,
                            buttons: {
                                "Okay": {
                                    text: "Okay",
                                    class: "btn btn-primary btn-sm",
                                    click: function() {
                                        dialog.dialog('close');
                                    }
                                }
                            }
                        });
                    } else {
                        alert("Something went Wrong");
                    }

                }
            });
        });
        $('#reprintInvoice').on('click', function() {
            var dialog = $('<p><strong style="color:black">Click Yes to Reprint</strong></p>').dialog({
                height: 200,
                width: 700,
                modal: true,
                containment: false,
                buttons: {
                    Yes: {
                        text: "Yes",
                        class: "btn btn-success btn-sm",
                        click: function() {
                            $('#reprintAuth').show();
                            showDialog('#reprintAuth', '65%', 300);
                            $(this).dialog("close");
                            $('#doAuthReprint').click(function() {
                                authReprints();
                            });
                        }
                    },
                    No: {
                        text: "No",
                        class: "btn btn-primary btn-sm",
                        click: function() {
                            $(this).dialog("close");
                            disableOnFinish();
                        }
                    }
                }
            });

        });
        //reprint the Invoice
        $('#reprintInvoiceOnTablet').on('click', function() {
            var dialog = $('<p><strong style="color:black">Click Yes to Reprint</strong></p>').dialog({
                height: 200,
                width: 700,
                modal: true,
                containment: false,
                buttons: {
                    Yes: {
                        text: "Yes",
                        class: "btn btn-success btn-sm",
                        click: function() {
                            $('#reprintAuth').show();
                            showDialog('#reprintAuth', '65%', 300);
                            $(this).dialog("close");
                            $('#doAuthReprint').click(function() {
                                authReprintsOnTabletLoading();
                            });
                        }
                    },
                    No: {
                        text: "No",
                        class: "btn btn-primary btn-sm",
                        click: function() {
                            $(this).dialog("close");
                            $("#tabletLoadingDocDetails").dialog('close');
                            //disableOnFinish();
                        }
                    }
                }
            });

        });
        $('#deleteAllLines').click(function() {

            var dialog = $(
                '<p><strong style="color:red">This will delete all the lines mapped to this order</strong></p>'
                ).dialog({
                height: 200,
                width: 700,
                modal: true,
                containment: false,
                buttons: {
                    "Finish": {
                        text: "Finish",
                        class: "btn btn-primary btn-sm",
                        click: function() {
                            $.ajax({
                                url: '{!! url('/deleteallLinesOnOrder') !!}',
                                type: "POST",
                                data: {
                                    orderId: $('#orderId').val(),
                                    customerCode: $('#inputCustAcc').val(),
                                    delivdate: $('#inputDeliveryDate').val()
                                },
                                success: function(dataDetails) {
                                    if (dataDetails[0].Result ==
                                        'THIS ORDER HAS ALREADY BEEN PARTIALLY PICKED OR LOADED'
                                        ) {
                                        console.log("PICKED OR LOADED!");

                                        dialog.dialog('close');
                                        var dialogalreadydone = $(
                                            '<p><strong style="color:red">This order has already been partially picked or loaded. Delete failed.</strong></p>'
                                            ).dialog({
                                            height: 200,
                                            width: 700,
                                            modal: true,
                                            containment: false,
                                            buttons: {
                                                "Okay": {
                                                    text: "Okay",
                                                    class: "btn btn-success btn-sm",
                                                    click: function() {
                                                        dialogalreadydone.dialog('close');
                                                    }
                                                }
                                            }
                                        });
                                    } else {
                                        $("#table > tbody:last").children().remove();
                                        dialog.dialog('close');
                                        generateALine2();
                                    }
                                }
                            });
                        }
                    }
                }
            });


        });
        //DELETE A LINE
        $('#table').on('click', 'button', function(e) {
            var $this = $(this);
            var row_index = $this.closest('tr').index();
            var row_closestTrColumns = $this.closest('tr');
            var orderLineID = $this.attr("value");

            var prodCode1 = row_closestTrColumns.find('.theProductCode_').val();
            var hiddenToken = row_closestTrColumns.find('.hiddenToken').val();

            if (orderLineID === "undefined" || orderLineID === undefined) {
                if (($('#invoiceNo').val()).length < 1) {
                    $this.closest('tr').remove();
                    var prodCode2 = row_closestTrColumns.find('.theProductCode_').val();

                    if (prodCode2 === prodCode1) {
                        //console.debug('they are equal - AFTER------------**************** '+prodCode2);
                        $this.closest('tr').remove();
                    }
                    //   generateALine2();
                    calculator();
                    $.ajax({
                        url: '{!! url('/deleteByHiddenToken') !!}',
                        type: "POST",
                        data: {
                            orderId: $('#orderId').val(),
                            hiddenToken: hiddenToken
                        },
                        success: function(data) {

                            console.debug(
                                "////////////////////////////////////////////////////////////" +
                                data.result);
                            if (data.result != "SUCCESS" && data.result != "Success") {
                                var dialog = $('<p><strong style="color:black">' + data
                                    .result + '</strong></p>').dialog({
                                    height: 200,
                                    width: 700,
                                    modal: true,
                                    containment: false,
                                    buttons: {
                                        "Okay": {
                                            text: "Okay",
                                            class: "btn btn-success btn-sm",
                                            click: function() {
                                                dialog.dialog('close');
                                            }
                                        },
                                    }
                                });
                            }


                        }
                    });
                }
                if (row_index < 1 && ($('#invoiceNo').val()).length < 1) {
                    //generateALine();
                    calculator();
                    generateALine2();
                }

            } else {
                $.ajax({
                    url: '{!! url('/deleteOrderDetails') !!}',
                    type: "POST",
                    data: {
                        OrderId: $('#orderId').val(),
                        OrderDetailId: orderLineID
                    },
                    success: function(data) {

                        if (data.deletedId != 'FAILED') {
                            if (($('#invoiceNo').val()).length < 1 ||
                                isAllowedToChangeInv == 1) {
                                $this.closest('tr').remove();
                                calculator();
                                generateALine2();
                            }
                        } else {
                            // $('#table').on('click', 'button', function (e) {
                            var dialog = $(
                                '<p><strong style="color:red">Sorry something went wrong when deleting a line ,please try again</strong></p>'
                                ).dialog({
                                height: 200,
                                width: 700,
                                modal: true,
                                containment: false,
                                buttons: {
                                    "Okay": {
                                        text: "Okay",
                                        class: "btn btn-success btn-sm",
                                        click: function() {
                                            dialog.dialog('close');
                                        }
                                    }
                                }
                            });
                        }
                        calculator();

                    }
                });

                if (row_index < 1 && ($('#invoiceNo').val()).length < 1) {
                    //generateALine();
                    generateALine2();
                }
            }

            calculator();
        });




        function datePicker() {
            var today = new Date();
            $("#inputDeliveryDate").datepicker({
                changeMonth: true, //this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: 'dd-mm-yy'
            });
            $("#changeDelvDate").datepicker({
                changeMonth: true, //this option for allowing user to select month
                changeYear: true //this option for allowing user to select from year range
                //minDate: today
            });
            $("#inputOrderDate").datepicker({
                changeMonth: true, //this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: 'dd-mm-yy'
            });
            $("#deliveryDateOrderListing").datepicker({
                changeMonth: true, //this option for allowing user to select month
                changeYear: true //this option for allowing user to select from year range
            });

            var currentdate = new Date();
            $("#callListOrderDate").val($.datepicker.formatDate('dd-mm-yy', currentdate));
            // $("#callListDeliveryDate").val();
            $("#callListDeliveryDate").datepicker({
                changeMonth: true, //this option for allowing user to select month
                changeYear: true,
                dateFormat: "dd-mm-yy" //this option for allowing user to select from year range
            });
            $("#callListOrderDate").datepicker({
                changeMonth: true, //this option for allowing user to select month
                changeYear: true //this option for allowing user to select from year range
            });
            $("#copyDeliveryDate").datepicker({
                changeMonth: true, //this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: "dd-mm-yyyy"
            });
            //getDataFromTblManagement()
        }
        /**
         * ON SALES ORDER
         * */
        $('#salesOnOrder').click(function() {
            $('#prodOnOrder').show();
            showDialog('#prodOnOrder', '80%', 680);
            productsOnOrder();
            $('#tblOnsalesOrder tbody').on('click', 'tr', function(e) {
                $("#tblOnsalesOrder tbody tr").removeClass('row_selected');
                $(this).addClass('row_selected');
                globalOrderIdToBePushed = [];
                arrayOfCustomerInfo = [];
                $('#orderIds').val('');
                var rowOnOrder = $(this).closest("tr");
                var orderIDrowOnOrder = rowOnOrder.find('td:eq(0)').text();
                globalOrderIdToBePushed.push(orderIDrowOnOrder);
                arrayOfCustomerInfo.push(rowOnOrder.find('td:eq(1)').text());
                arrayOfCustomerInfo.push(rowOnOrder.find('td:eq(2)').text());
                arrayOfCustomerInfo.push(rowOnOrder.find('td:eq(3)').text());
            });
            $('#callSpOnOrder').click(function() {
                productsOnOrder();
            });

        });
        //Search method

        quickSearchOnCustomerPrioritisePastelCode(finalData, '#inputCustCustomers');
        onChangeCustomerOnDispatchForm("#custDescriptionListOfOrder");
        $('#finishedDispatching').click(function() {
            var productsLinesOnPicking = new Array();
            $('#tableDispatch > tbody  > tr').each(function() {
                var data = $(this);
                var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                console.debug($(this).closest('tr').find('.theProductCode_').val());
                productsLinesOnPicking.push({
                    'productCode': $(this).closest('tr').find('.theProductCode_').val(),
                    'desc': $(this).closest('tr').find('.prodDescription_').val(),
                    'qty': $(this).closest('tr').find('.prodQty_').val(),
                    'price': $(this).closest('tr').find('.prodPrice_').val(),
                    'comment': $(this).closest('tr').find('.prodComment_').val(),
                    'orderDetailID': orderDetailID,
                    'customerCode': $('#inputCustAcc').val()
                });
            });
            var dialog = $('<p>Do you want to Print this Invoice?</p>').dialog({
                height: 200,
                width: 700,
                modal: true,
                containment: false,
                buttons: {
                    Yes: {
                        text: "Yes",
                        class: "btn btn-success btn-sm",
                        click: function() {
                            $.ajax({
                                url: '{!! url('/printAdjustmentDispatch') !!}',
                                type: "POST",
                                data: {
                                    orderId: $('#orderIds').val(),
                                    message: $('#dispatchMessage').val(),
                                    prodLines: productsLinesOnPicking,
                                    orderNo: $('#orderNumberOnDispatch').val(),
                                    awaiting: $('#awaitingStockOnDispatchOrPickingForm')
                                        .val()
                                },
                                success: function(dataDetails) {

                                    if (!$.isEmptyObject(dataDetails)) {


                                        $('.fast_remove_backOrder').remove();
                                        dialog.dialog('close');
                                        $('#dispatchQuantityForm').dialog('close');
                                    }
                                }
                            });
                        }
                    },
                    No: {
                        text: "No",
                        class: "btn btn-primary btn-sm",
                        click: function() {
                            //Change the dispatch qty
                            adjustQuantingOnPickingForm($('#orderIds').val(), $(
                                    '#dispatchMessage').val(), '{!! url('/adjustDispatch') !!}',
                                $('#inputCustAcc').val());
                            $('.fast_remove').remove();

                            $('#orderIds').val('');
                            if (($('#orderIds').val()).length < 1) {
                                dialog.dialog('close');
                            }
                            $('#dispatchQuantityForm').dialog('close');
                        }
                    }
                }
            });
            $('#orderIdlbl').append($('#orderIds').val());
            $('#orderNolbl').append($('#orderIds').val());
            $('#deliveryDatelbl').append($('#DeliveryDate').val());
            $('#custAcclbl').append($('#inputCustAcc').val());
            $('#custDesclbl').append($('#inputCustName').val());

        });
        //$("#table").colResizable({liveDrag:true});
    });

    function validate() {
        if ($('#inputCustAcc').val().length > 0 &&
            $('#inputCustName').val().length > 0 &&
            $('#inputDeliveryDate').val().length > 0) {
            $("#submitFilters").prop("disabled", false);
            // getTheCustomerId();
            getCustomerRoutesPriority('#routeName', '{!! url('/getCustomerRoutes') !!}', $('#inputCustAcc').val());

            //
        } else {
            $("#submitFilters").prop("disabled", true);
            $("#inputDeliveryDate").prop("disabled", false);
            $("#inputCustName").prop("disabled", false);
            $("#inputCustAcc").prop("disabled", false);
        }
    }
    /**
     * This function also includes the past ten invoices of a customer
     */
    function customerAndGroupSpecials() {
        //CUSTOMER SPECIALS
        $.ajax({
            url: '{!! url('/combinedSpecials') !!}',
            type: "POST",
            data: {
                customerCode: $('#inputCustAcc').val(),
                deliveryDate: $('#inputDeliveryDate').val()
            },
            success: function(data) {

                var trHTML = '';
                console.debug("combined special" + data);

                $.each(data.customerSpecials, function(key, value) {
                    trHTML += `
                        <tr class="fast_remove">
                            <td class="text-nowrap">${value.PastelDescription}</td>
                            <td class="text-nowrap">${value.PastelCode}</td>
                            <td>${parseFloat(value.Price).toFixed(2)}</td>
                            <td class="text-nowrap">${value.DateFrom}</td>
                            <td class="text-nowrap">
                                ${value.DateTo}
                                <input type="hidden" id="${value.PastelCode}" value="${value.PastelCode}" style="width:1px" class="foo">
                                <input type="hidden" id="Prodcost" value="${parseFloat(value.Cost).toFixed(2)}" style="width:1px">
                                <input type="hidden" id="ProdQnt" value="${parseFloat(value.QtyInStock).toFixed(2)}" style="width:1px">
                                <input type="hidden" id="titles" value="authorised" style="width:1px">
                                <input type="hidden" id="taxCode" class="taxCodes" value="${value.Tax}" style="width:1px" >
                            </td>
                            <td>${value.UnitSize}</td>
                            <td>
                                <input type="hidden" id ="soldByWieght" class="soldByWieght" value="${value.SoldByWeight}" />
                                <input type="hidden" id ="unitWeight"  class="unitWeight" value="${value.UnitWeight}" />
                                <input type="hidden" id ="strBulkUnit"  class="strBulkUnit" value="${value.strBulkUnit}" />
                                <input type="hidden" id ="ProductMargin"  class="ProductMargin" value="${value.ProductMargin}" />
                            </td>
                        </tr>
                    `;

                });
                $('#customerSpecials tbody').append(trHTML);
                var trHTML = '';

                $.each(data.GroupSpecials, function(key, value) {
                    trHTML += `
                        <tr class="fast_remove">
                            <td class="text-nowrap">${value.PastelDescription}</td>
                            <td class="text-nowrap">${value.PastelCode}</td>
                            <td>${parseFloat(value.Price).toFixed(2)}</td>
                            <td class="text-nowrap">${value.DateFrom}</td>
                            <td class="text-nowrap">
                                ${value.DateTo}
                                <input type="hidden" id="${value.PastelCode}" value="${value.PastelCode}" style="width:1px" class="foo">
                                <input type="hidden" id="Prodcost" value="${parseFloat(value.Cost).toFixed(2)}" style="width:1px">
                                <input type="hidden" id="ProdQnt" value="${parseFloat(value.QtyInStock).toFixed(2)}" style="width:1px">
                                <input type="hidden" id="titles" value="authorised" style="width:1px">
                                <input type="hidden" id="taxCode" class="taxCodes" value="${value.Tax}" style="width:1px">
                            </td>
                            <td>${value.UnitSize}</td>
                            <td>
                                <input type="hidden" id ="soldByWieght" class="soldByWieght" value="${value.SoldByWeight}"/>
                                <input type="hidden" id ="unitWeight"  class="unitWeight" value="${value.UnitWeight}"/>
                                <input type="hidden" id ="strBulkUnit"  class="strBulkUnit" value="${value.strBulkUnit}"/>
                                <input type="hidden" id ="ProductMargin"  class="ProductMargin" value="${value.ProductMargin}"/>
                            </td>
                        </tr>
                    `;
                });
                $('#groupSpecials tbody').append(trHTML);
                var trHTML = '';
                var inv = 'id';
                var counter = 0;
                var dimsPlusIcon = '<i class="ki-outline ki-plus text-primary cursor-pointer pe-1"></i>';
                $.each(data.pastInvoices, function(key, value) {
                    if (inv != value.InvoiceNo) {
                        var k = parseInt(counter) + parseInt(1);
                        trHTML += `
                            <tr ondblclick="/*this.style.display = none*/" class="fast_remove" onclick="show_hide_row(this, 'hidden_row1${k}');">
                                <td class="dims_invoice_no text-nowrap">${dimsPlusIcon} ${value.InvoiceNo}</td>
                                <td class="text-nowrap">${value.OrderDate}</td>
                                <td class="text-nowrap">${value.DeliveryDate}</td>
                                <td>
                                    ${value.OrderNo}
                                    <input type="hidden" class="dontTakeme" value="thisIsIt">
                                </td>
                                <td></td>
                            </tr>
                        `;
                        counter++;
                    }

                    trHTML += `
                        <tr class="hidden_row1${counter} hidden_row" style="display:none;">
                            <input type="hidden" id="${value.PastelCode}" value="${value.PastelCode}" style="width:1px" class="foo">
                            <input type="hidden" id="Prodcost" value="${parseFloat(value.Cost).toFixed(2)}" style="width:1px">
                            <input type="hidden" id="ProdQnt" value="${parseFloat(value.QtyInStock).toFixed(2)}" style="width:1px">
                            <input type="hidden" id="titles" value="authorised" style="width:1px">
                            <input type="hidden" class="dontTakeme" value="">
                            <input type="hidden" id="UnitSizes" value="${value.UnitSize}" style="width:1px">
                            <input type="hidden" id ="soldByWieght" class="soldByWieght" value="${value.SoldByWeight}" />
                            <input type="hidden" id ="unitWeight"  class="unitWeight" value="${value.UnitWeight}" />
                            <input type="hidden" id ="strBulkUnit"  class="strBulkUnit" value="${value.strBulkUnit}" />
                            <input type="hidden" id ="strBulkUnit"  class="strBulkUnit" value="${value.strBulkUnit}" />
                            <input type="hidden" id ="ProductMargin"  class="ProductMargin" value="${value.ProductMargin}" />
                            <input type="hidden" id ="taxCode"  class="taxCode" value="${value.Tax}" />
                            <td colspan="3" class="ps-8">${value.PastelDescription}</td>
                            <td>${parseFloat(value.Qty).toFixed(2)}</td>
                        </tr>
                    `;
                    inv = value.InvoiceNo

                });
                $('#pastInvoices tbody').append(trHTML);

                //data.contacts[0].
                $.each(data.contacts, function(key, value) {
                    $('#contactCellOnDispatch').val(value.CellPhone);
                    $('#contactPersonOnDispatch').val(value.BuyerContact);
                    $('#telOnDispatch').val(value.BuyerTelephone);
                });

            },
            error: function(xhr, textStatus, errorThrown) {
                if (textStatus == 'timeout') {
                    this.tryCount++;
                    if (this.tryCount <= this.retryLimit) {
                        //try again
                        $.ajax(this);
                        return;
                    }
                    return;
                }
                if (xhr.status == 500) {
                    //handle error
                } else {
                    //handle error
                }
            }
        });

    }

    function finishThis() {
        var orderlinesValidations = [];

        $('#table > tbody  > tr').each(function() {
            var data = $(this);

            var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
            var comment = $(this).closest('tr').find('.prodComment_').val();
            //comment = comment.replace("'","");

            console.debug($(this).closest('tr').find('.col2').val());
            if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                orderlinesValidations.push({
                    'productCode': escapeHtml($(this).closest('tr').find('.theProductCode_').val()),
                    'qty': $(this).closest('tr').find('.prodQty_').val(),
                    'price': $(this).closest('tr').find('.prodPrice_').val()
                });
            }
        });

        $.ajax({
            url: '{!! url('/checkZeroCostOnOrder') !!}',
            type: "POST",
            data: {
                OrderId: $('#orderId').val(),
                orderlines: orderlinesValidations
            },
            success: function(data) {
                if (data.result != "Nothing") {
                    authorZeroCostOnSaving(data.data);
                } else {


                    $('<div></div>').appendTo('body')
                        .html('<div><h6>Yes or No?</h6></div>')
                        .dialog({
                            modal: true,
                            title: 'Click Yes to Print the Sales Order Or No to exit.',
                            zIndex: 10000,
                            autoOpen: true,
                            width: '65%',
                            resizable: false,
                            buttons: {
                                DelUser: {
                                    class: 'leftButton btn btn-primary btn-sm',
                                    text: 'Point Of Sale',
                                    click: function() {
                                        allInoneDocumentsave("POS");
                                    }
                                },
                                Yes: {
                                    class: 'btn btn-success btn-sm',
                                    text: 'Yes',
                                    click: function() {
                                        allInoneDocumentsave("YES");
                                    }
                                },
                                No: {
                                    class: 'btn btn-warning btn-sm',
                                    text: 'No',
                                    click:  function() {
                                        allInoneDocumentsave("NO");
                                    }
                                },
                                PDF: {
                                    class: 'btn btn-primary btn-sm',
                                    text: 'PDF',
                                    click:  function() {
                                        var dialog = $(
                                            '<p><strong style="color:black"> Please wait...</strong></p>'
                                            ).dialog({
                                            height: 200,
                                            width: 700,
                                            modal: true,
                                            containment: false,
                                            buttons: {
                                                "Okay": {
                                                    text: "Okay",
                                                    class: "btn btn-success btn-sm",
                                                    click: function() {
                                                        dialog.dialog('close');
                                                    }
                                                }
                                            }
                                        });
                                        if (($('#invoiceNo').val()).length > 3) {
                                            window.open('{!! url('/pdforder') !!}/' + $('#orderId')
                                                .val(), "PDF",
                                                "location=1,status=1,scrollbars=1, width=1200,height=850"
                                                );
                                            //View PDF
                                            disableOnFinish();
                                            $(this).dialog("close");
                                            $('#finishOrder').hide();
                                        } else {
                                            //finishArray2 -- use to be
                                            allInoneDocumentsave("PDF");
                                        }

                                        $(this).dialog("close");
                                    }
                                }
                            },
                            close: function(event, ui) {
                                $(this).remove();
                            }
                        });
                }


            }
        });


    }

    function PosDialog() {
        console.debug("I am inside POS");
        $('#pointOfSaleDialog').show();
        showDialog('#pointOfSaleDialog', 910, 400);
        calculator();
        var discount = (parseFloat($('#totalInc').val() * ($('#hiddenCustDiscount').val() / 100)).toFixed(2));
        console.debug("*****************" + discount);

        var totalToBeInvoiced = (parseFloat($('#totalInc').val()) - parseFloat(discount)).toFixed(2);
        $('#posOrdernumber').val($('#orderId').val());
        $('#posInvTotal').val($('#totalInc').val());
        $('#confirmOnPosDialog').click(function() {

            if (parseFloat($('#posChange').val()).toFixed(2) < 0) {

                var dialog = $(
                    '<p><strong style="color:black">sorry the invoice will not print,Please check your change</strong></p>'
                    ).dialog({
                    height: 200,
                    width: 700,
                    modal: true,
                    containment: false,
                    buttons: {
                        "Okay": {
                            text: "Okay",
                            class: "btn btn-success btn-sm",
                            click: function() {
                                dialog.dialog('close');
                            }
                        },
                        "Cancel": {
                            text: "Cancel",
                            class: "btn btn-primary btn-sm",
                            click: function() {
                                dialog.dialog('close');
                            }
                        }
                    }
                });
            } else { //$('#orderId').val()
                consoleManagement('{!! url('/logMessageAjax') !!}', 600, 3, 'POS Confirm Btn ,TotTendered: ' + $(
                        '#posTotalTendered').val() + ' Inv: ' + $('#totalInc').val(), 0, 0, 0, 0, 0, 0, 0,
                    0, $('#orederNumber').val(), 0, computerName, $('#orderId').val(), 0);

                //waitingInvoice();
                //( waitingInvoice , 8000 );
            }

        });
    }

    function productsOnOrder() {
        $.ajax({
            url: '{!! url('/productsOnOrder') !!}',
            type: "POST",
            data: {
                productCode: $('#productCodeOnOrder').val(),
                customerCode: $('#custCodeOnOrder').val(),
            },
            success: function(data) {
                console.log(data);
                getGrid(data);
            }
        });


        // productsOnOrders = $('#tblOnsalesOrder').DataTable({
        //     "ajax": {
        //         url: '{!! url('/productsOnOrder') !!}', "type": "post", data: function (data) {
        //             data.productCode = $('#productCodeOnOrder').val();
        //             data.customerCode = $('#custCodeOnOrder').val();
        //         }
        //     },
        //     "columns": [
        //         {"data": "OrderId", "class": "small", "bSortable": true},
        //         {"data": "OrderDate", "class": "small"},
        //         {"data": "DeliveryDate", "class": "small"},
        //         {"data": "CustomerPastelCode", "class": "small"},
        //         {"data": "StoreName", "class": "small"},
        //         {"data": "AwaitingStock", "class": "small"},
        //         {"data": "Qty", "class": "small",
        //             render:function(data, type, row, meta) {
        //                 // check to see if this is JSON
        //                 try {
        //                     var jsn = JSON.parse(data);
        //                     //console.log(" parsing json" + jsn);
        //                 } catch (e) {

        //                     return jsn.data;
        //                 }
        //                 return parseFloat(jsn).toFixed(2);

        //             } ,"bSortable": true },

        //         {"data": "InStock", "class": "small"},
        //         {"data": "PastelCode", "class": "small"},
        //         {"data": "PastelDescription", "class": "small"},
        //         {"data": "Comment", "class": "small"},
        //         {"data": "NettPrice", "class": "small",
        //             render:function(data, type, row, meta) {
        //                 // check to see if this is JSON
        //                 try {
        //                     var jsn = JSON.parse(data);
        //                     //console.log(" parsing json" + jsn);
        //                 } catch (e) {

        //                     return jsn.data;
        //                 }
        //                 return parseFloat(jsn).toFixed(2);

        //             } ,"bSortable": true },
        //         {"data": "Backorder", "class": "small"}

        //     ],
        //     "deferRender": true,
        //     "scrollY": "300px",
        //     "scrollCollapse": true,
        //     searching: true,
        //     bPaginate: false,
        //     bFilter: false,
        //     "LengthChange": false,
        //     "info": false,
        //     "destroy": true
        // });
    }

    function getGrid(data) {
        $("#gridContainer").dxDataGrid({

            dataSource: data, //as json
            hoverStateEnabled: true,
            showBorders: true,
            filterRow: {
                visible: true
            },
            allowColumnResizing: true,
            columnAutoWidth: true,
            width: "100%",
            scrolling: {
                showScrollbar: 'always',
                useNative: false,
                scrollByThumb: true
            },
            paging: {
                enabled: false
            },
            export: {
                enabled: true
            },
            editing: {
                mode: 'single',
                // allowUpdating: true,
                allowDeleting: true,
            },
            selection: {
                mode: 'batch',
            },
            onExporting(e) {
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('On_Order');

                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet,
                    autoFilterEnabled: true,
                }).then(() => {
                    workbook.xlsx.writeBuffer().then((buffer) => {
                        saveAs(new Blob([buffer], {
                            type: 'application/octet-stream'
                        }), 'On_Order.xlsx');
                    });
                });
                e.cancel = true;
            },

            columns: [{
                dataField: "OrderId",
                caption: "Order Id",
                width: 100

            }, {
                dataField: "OrderDetailId",
                caption: "Order Detail Id",
                visible: false,
            }, {
                dataField: "OrderDate",
                caption: "Order Date",
                cellTemplate: function(cellElement, cellInfo) {
                    cellElement.addClass('custom-font');
                    cellElement.text(cellInfo.text);
                },
                width: 80
            }, {
                dataField: "DeliveryDate",
                caption: "Delivery Date",
                width: 80,
                cellTemplate: function(cellElement, cellInfo) {
                    cellElement.addClass('custom-font');
                    cellElement.text(cellInfo.text);
                }
            }, {
                dataField: "CustomerPastelCode",
                caption: "Cust Code",
                width: 100,
                cellTemplate: function(cellElement, cellInfo) {
                    cellElement.addClass('custom-font');
                    cellElement.text(cellInfo.text);
                }
            }, {
                dataField: "StoreName",
                caption: "Store Name",
                width: 380,
                cellTemplate: function(cellElement, cellInfo) {
                    cellElement.addClass('custom-font');
                    cellElement.text(cellInfo.text);
                }
            }, {
                dataField: "AwaitingStock",
                caption: "Awaiting Stock",
                width: 60,
                cellTemplate: function(cellElement, cellInfo) {
                    cellElement.addClass('custom-font');
                    cellElement.text(cellInfo.text);
                }
            }, {
                dataField: "Qty",
                caption: "Qty",
                width: 80,
                cellTemplate: function(cellElement, cellInfo) {
                    cellElement.addClass('custom-font');
                    cellElement.text(cellInfo.text);
                }
            }, {
                dataField: "InStock",
                caption: "In Stock",
                width: 80,
                format: {
                    type: "fixedPoint",
                    precision: 3
                },
                customizeText: function(cellInfo) {
                    return Number(cellInfo.value).toFixed(3);
                }
            }, {
                dataField: "PastelCode",
                caption: "Prod Code",
                width: 100,
                cellTemplate: function(cellElement, cellInfo) {
                    cellElement.addClass('custom-font');
                    cellElement.text(cellInfo.text);
                }
            }, {
                dataField: "PastelDescription",
                caption: "Prod Description",
                width: 280,
                cellTemplate: function(cellElement, cellInfo) {
                    cellElement.addClass('custom-font');
                    cellElement.text(cellInfo.text);
                }
            }, {
                dataField: "Comment",
                caption: "Comment",
                width: 100,
                cellTemplate: function(cellElement, cellInfo) {
                    cellElement.addClass('custom-font');
                    cellElement.text(cellInfo.text);
                }
            }, {
                dataField: "NettPrice",
                caption: "Nett",
                width: 100,
                format: {
                    type: "fixedPoint",
                    precision: 2
                },
                customizeText: function(cellInfo) {
                    return Number(cellInfo.value).toFixed(2);
                }
            }, {
                dataField: "Backorder",
                caption: "Back Order",
                width: 100,
                cellTemplate: function(cellElement, cellInfo) {
                    cellElement.addClass('custom-font');
                    cellElement.text(cellInfo.text);
                }
            }, ],
            onRowDblClick: function(e) {
                var invNum = e.data.OrderId
                $('#invoiceNo').val(invNum);
                $('#orderIds').val(invNum);
                $('#orderId').val(invNum);
                $('#checkOrders').click();
                $('#prodOnOrder').dialog('close');
            },
            onRowPrepared(e) {
                if (e.rowType == 'data' && e.data.dataField == "1") {
                    e.rowElement.css('background', 'rgb(155, 236, 248)');
                }
            },

            onRowRemoving: function(e) {
                var OrderDetailId = e.data.OrderDetailId;
                if (e.rowType == 'data' && e.data.AwaitingStock == "1") {
                    console.debug("orderdetail Id ____________" + OrderDetailId);
                    $.ajax({
                        url: '{!! url('/deleteOrderLinedetails') !!}',
                        type: "POST",
                        data: {
                            OrderId: OrderDetailId,
                        },
                        success: function(data) {
                            alert(data[0]['Result']);
                        }
                    });
                } else {
                    alert(
                        "Sorry, you cannot delete the line because it is not a stock item that is Awaiting Stock.");
                }
            },
            paging: {
                pageSize: 7,
            },
        });
    }

    function show_hide_row(obj, row) {
        $("." + row).toggle();
        $("." + row).css('display', $("." + row).is(':visible') ? 'revert' : 'none');
        $(obj).find(".dims_invoice_no i").toggleClass("ki-plus");
        $(obj).find(".dims_invoice_no i").toggleClass("text-primary");
        $(obj).find(".dims_invoice_no i").toggleClass("ki-minus");
        $(obj).find(".dims_invoice_no i").toggleClass("text-danger");

    }
    $(document).on("dblclick", "#callListTable tbody tr", function() {
        // alert('Row dblclicked');
        //$('#callListTable tbody').on('dblclick', 'tr', function () {
        // var productCode = $(this).find(".foo").val();
        var $this = $(this);
        var row = $this.closest("tr");
        var custDescr = row.find('td:eq(1)').text();
        var custCode = row.find('td:eq(0)').text();
        var Disc = row.find('td:eq(9)').text();
        var custRouteId = row.find('td:eq(10)').text();
        var custRouteName = row.find('td:eq(6)').text();
        var notes = row.find(".notes").val(); //
        var custids = row.find(".custids").val(); //

        if ($('#orderId').val().length > 3) {
            alert('There is Currently an order Opened Please Close it !');
        } else {
            $('#createOrderOnCallList').show();
            showDialog('#createOrderOnCallList', 900, 200);
            $('#yesOnCreatingOrderFromCallList').click(function() {

                $('#inputCustAcc').val(custCode);
                $('#inputCustName').val(custDescr);
                $('#hiddenCustDiscount').val(Disc);
                $('#inputDeliveryDate').val($('#callListDeliveryDate').val());
                $('#inputOrderDate').val($('#callListOrderDate').val());
                $('#routeonabutton').val(custRouteName);
                $('#Routeid').val(custRouteId);
                $('#CustomerId').val(custids);

                /* if(submitAttemt < 2)
             {

             submitAttemt++
             }*/
                $("#submitFilters").click();

                $('#callListDialog').dialog("close");
                $('#createOrderOnCallList').dialog("close");
                called('{!! url('/isCalled') !!}', $('#callListDeliveryDate').val(), custCode, '0',
                    notes);
                row.hide();
            });
            $('#noOnCreatingOrderFromCallList').click(function() {
                $('#createOrderOnCallList').dialog("close");
            });

        }

        // });
    });

    function confirmmultideliveryaddressonfinish() {
        console.debug("******************************* Routing ID " + $('#hiddenDeliveryAddressIdAfterSaved').val());


        $.ajax({
            url: '{!! url('/selectCustomerMultiAddressconfirm') !!}',
            type: "POST",
            data: {
                customerCode: $("#inputCustAcc").val(),
                OrderId: $('#orderId').val()
            },
            success: function(data) {
                var toAppend = '';
                var routnamereturn = "";
                var routeidreturn = "";
                $('#listaddresses').empty();
                $(".generalRouteForNewDeliveryAddress").empty();
                $.each(data.addresses, function(i, o) {
                    toAppend += '<li value="' + o.DeliveryAddressID +
                        '" style="border-bottom: 4px solid black;">' + o.DAddress1 + ' ' + o
                        .DAddress2 + ' ' + o.DAddress3 + '<br>' + o.DAddress4 + '<br>' + o
                        .DAddress5 + '</li>';
                });
                $('#listaddresses').append(toAppend);
                $('#changeDeliveryAddress').show();
                $('#dynamicaddress').empty();
                $('#doneCustomAddress').empty();
                $.each(data.selectedaddress, function(i, o) {
                    routnamereturn = o.Route;
                    routeidreturn = o.Routeid;
                    $('#address1').val(o.DAddress1);
                    $('#address2').val(o.DAddress2);
                    $('#address3').val(o.DAddress3);
                    $('#address4').val(o.DAddress4);
                    $('#address5').val(o.DAddress5);
                });
                $('.generalRouteForNewDeliveryAddress').prepend('<option value="' + routeidreturn +
                    '"  selected="selected">' + routnamereturn + '</option>');

                var toAppendr = '';
                $.each(data.routes, function(i, o) {
                    toAppendr += '<option value="' + o.Routeid + '">' + o.Route + '</option>';
                });

                $('.generalRouteForNewDeliveryAddress').append(toAppendr);

                getDimsUsers('#salesPerson', '{!! url('/getDimsUsers') !!}');
                getDimsUsers('#salesPersonOnDynamic', '{!! url('/getDimsUsers') !!}');
                //$('body').pleaseWait('stop');
                // $('#doneCustomAddress').hide();

                onClickingDeliveryAddress();
                $('#generateDynamicAddress').on('click', 'tr', function() {
                    $('#address1').val('');
                    $('#address2').val('');
                    $('#address3').val('');
                    $('#address4').val('');
                    $('#address5').val('');
                    //$('#doneCustomAddress').show();
                    console.debug($(this).closest('tr').find('td').eq(1).text());
                    $('#address1').val($(this).closest('tr').find('td').eq(2).text());
                    console.debug($('#address1').val());
                    $('#address2').val($(this).closest('tr').find('td').eq(3).text());
                    $('#address3').val($(this).closest('tr').find('td').eq(4).text());
                    $('#address4').val($(this).closest('tr').find('td').eq(5).text());
                    $('#address5').val($(this).closest('tr').find('td').eq(6).text());
                    $('.generalRouteForNewDeliveryAddress').prepend('<option value="' + $(this)
                        .closest('tr').find('#hiddenRouteId').val() + '" selected="selected">' +
                        $(this).closest('tr').find('td').eq(1).text() + '</option>');
                    $('#deliveryAddressIdOnPopUp').val($(this).closest('tr').find(
                        '#hiddenDeliveryAddressIdAfterSaved').val());
                });

                var $input = $(
                    '<button type="button" id="updateaddresses">UPDATE</button> <button type="button" style="float:right;" id="ignoresave">IGNORE</button>'
                    );
                $input.appendTo($("#dynamicaddress"));
                $('#updateaddresses').click(function() {
                    var routeidselect = $('#generalRouteForNewDeliveryAddress').val();

                    if ($('#generalRouteForNewDeliveryAddress').val() === 'null' || routeidselect
                        .length < 1) {
                        alert(
                            'The RouteID/Route Name is not correct,Please Choose the Route Or Speak to the manager.');

                    } else {
                        var selectedAddress = new Array();
                        selectedAddress.push({
                            'orderId': $('#orderId').val(),
                            'DeliveryAddressID': $('#hiddenDeliveryAddressId').val(),
                            'routeid': $('.generalRouteForNewDeliveryAddress').val(),
                            'address1': (escapeHtml($('#address1').val())),
                            'address2': (escapeHtml($('#address2').val())),
                            'address3': (escapeHtml($('#address3').val())),
                            'address4': (escapeHtml($('#address4').val())),
                            'address5': (escapeHtml($('#address5').val()))

                        });

                        $.ajax({
                            url: '{!! url('/submitchangeddeliveryaddress') !!}',
                            type: "POST",
                            data: {

                                OrderId: $('#orderId').val(),
                                delvdata: selectedAddress

                            },
                            success: function(data) {
                                console.debug(data[0]);
                                if (data[0].results == "SUCCESS") {
                                    var dialog = $(
                                        '<p><strong style="color:black">Updated To Address ID #' +
                                        $('#hiddenDeliveryAddressId').val() +
                                        ' </strong></p>').dialog({
                                        height: 200,
                                        width: 700,
                                        modal: true,
                                        containment: false,
                                        buttons: {
                                            "Okay": {
                                                text: "Okay",
                                                class: "btn btn-success btn-sm",
                                                click: function() {
                                                    dialog.dialog('close');
                                                }
                                            }
                                        }
                                    });
                                    if (hassplitorder == "LTRUE") {
                                        splitorder();
                                    } else {
                                        disableOnFinish();
                                    }

                                }

                                //console.debug(data);

                            }
                        });


                    }


                });

                $('#ignoresave').click(function() {
                    if (hassplitorder == "LTRUE") {
                        splitorder();
                    } else {
                        $.ajax({
                            url: '{!! url('/clearorderlocksperorder') !!}',
                            type: "POST",
                            data: {
                                OrderId: $('#orderId').val()
                            },
                            success: function(data) {
                                empties();
                                location.reload();

                            }
                        });
                    }
                });


            }
        });

    }

    function reprintList() {
        $('#tabletLoading').pleaseWait();
        $.ajax({
            url: '{!! url('/getRouteData') !!}',
            type: "POST",
            data: {
                routeId: $('#rouTabletLoadingtes').val(),
                deliveryDate: $('#deliveryDates').val(),
                OrderType: $('#orderTypesTabletLoading').val()
            },
            success: function(data) {
                var trHTML = '';
                $('.invoiceslistedHeader').empty();
                $.each(data, function(key, value) {
                    trHTML +=
                        '<tr role="row" class="invoiceslistedHeader"  style="font-size: 9px;color:black"><td>' +
                        value.DeliveryDate + '</td><td>' +
                        value.OrderType + '</td><td>' +
                        value.Route + '</td><td>' +
                        value.StoreName + '</td><td>' +
                        value.InvoiceNo + '</td><td>' +
                        value.OrderId + '</td><td>' +
                        value.CustomerPastelCode +
                        '<input type="hidden"  name="orderId" style="width:18px;height:18px" value="' +
                        value.OrderId +
                        '" class="orderID" ><input type="hidden"  name="invoiceNo" style="width:18px;height:18px" value="' +
                        value.InvoiceNo + '" class="invoiceNo" ></td><td>' +
                        '</tr>';
                });
                $('#tabletLoadingAppTable').append(trHTML);
                $('#tabletLoading').pleaseWait('stop');
                $('#tabletLoadingAppTable tbody').on('dblclick', 'tr', function() {
                    $("#orderinfo").empty();
                    $("#orderinfoAddress").empty();
                    $(".invoiceslisted").remove();
                    var $this = $(this);
                    var row = $this.closest("tr");
                    var orderID = row.find('.orderID').val();
                    var invoiceNo = row.find('.invoiceNo').val();
                    var orderType = row.find('td:eq(1)').text();
                    var route = row.find('td:eq(2)').text();
                    var Customer = row.find('td:eq(3)').text();
                    var code = row.find('td:eq(4)').text();
                    var right = Customer + ' <br> ' + orderID + '<br>' + invoiceNo + ' <br> ' +
                        orderType + '<br>' + route;
                    $('#tabletLoadingDocDetails').pleaseWait();
                    $('#reprintOrderIdFromTablet').val(orderID);
                    $('#reprintInvoiceFromTablet').val(invoiceNo);
                    orderDetailsWithDeliveryAddress('{!! url('/orderDetailsWithDeliveryAddress') !!}', orderID,
                        '#orderinfoAddress');
                    orderDetailsWithDeliveryAddressOnOrder('{!! url('/orderDetailsWithDeliveryAddressOnOrder') !!}', orderID,
                        '#tabletLoadingAppTableDocDetails');
                    $('#tabletLoadingDocDetails').pleaseWait('stop');
                    $('#reprintInvoice').click(function() {
                        printDoc('{!! url('/intoTblPrintedDoc') !!}', 1, orderID, 0, $('#invoiceNo')
                            .val());
                        consoleManagement('{!! url('/logMessageAjax') !!}', 300, 2,
                            'Tablet loading web button clicked', 0, 0, 0, 0, 0, 0, 0, 0,
                            invoiceNo, 0, computerName, orderID, 0);
                    });

                    $("#orderinfo").append(right);
                    $('#tabletLoadingDocDetails').show();
                    $("#tabletLoadingDocDetails").dialog({
                        height: 600,
                        width: 900,
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
                    console.debug(orderID);
                });
            }
        });
    }

    function getTheCustomerId() {
        $.ajax({
            url: '{!! url('/custID') !!}',
            type: "POST",
            data: {
                customerCode: $('#inputCustAcc').val()
            },
            success: function(data) {
                GlobalcustomerId = data[0].CustomerId;
                console.debug("GlobalcustomerId" + GlobalcustomerId);
            }
        });

        return GlobalcustomerId;
    }

    function cancelAdd() {
        //$("#add-more").show();
        //Find ID
        $("#new_row_ajax").remove();
    }

    function deleteOrderLine(url, orderDetailLineId, orderId) {
        $.ajax({
            url: url,
            type: "POST",
            data: {
                OrderId: orderId,
                OrderDetailId: orderDetailLineId
            },
            success: function(data) {
                console.debug('deleted msg' + data.deletedId);

            }
        });
    }

    function SelectallColorsForStyle(e, val, note) {
        console.debug("e.value//////" + e.value);
        console.debug("val***+-//////" + note);
        $.ajax({
            url: '{!! url('/isCalled') !!}',
            type: "POST",
            data: {
                CustomerCode: e.value,
                DeivDate: $('#callListDeliveryDate').val(),
                Show: "0",
                DeliveryAddressId: "0",
                notes: $('#' + note).val()
            },
            success: function(data) {
                console.debug("data saved");
            }
        });
    }

    function isFloatNumber(item, evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
            var regex = new RegExp(/\./g)
            var count = $(item).val().match(regex).length;
            if (count > 1) {
                return false;
            }
        }
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function getCustomerRoutesPriority(tag, url, param) {
        $.ajax({
            url: url,
            type: "POST",
            data: {
                customerCode: param
            },
            success: function(data) {
                var toAppend = '';
                $.each(data, function(i, o) {
                    toAppend += '<option value="' + o.Routeid + '">' + o.Route + '</option>';
                });

                $(tag).append(toAppend);

            }
        });
        //
    }

    function filter(element) {
        var value = $(element).val().toLowerCase();
        $("#listaddresses li").each(function() {
            if ($(this).text().toLowerCase().search(value) > -1) {
                $(this).show();
                $(this).prevAll('.header').first().show();
            } else {
                $(this).hide();
            }
        });
    }

    function generateALine2() {
        $("#toAutoScroll").animate({
            scrollTop: $(this).height()
        }, "slow");
        // $( "#table" ).colResizable({ disable : true });
        // var styleAnony = ""
        calculator();

        if (multiLines == 1) {
            var classAnonymouscols = "anonymouscols";
        } else {
            var classAnonymouscols = "anonymouscolsOff";
        }


        var tokenId = new Date().valueOf();
        var $row = $(`
            <tr id="new_row_ajax${tokenId}" class="fast_remove">
                <td class="text-center">
                    <input type="hidden" id="title_${tokenId}" class="title" value="${isAuthMyLine}" />
                    <input type="hidden" id="theOrdersDetailsId" value="" />
                    <input type="hidden" id ="taxCode${tokenId}" value="" class="taxCodes" />
                    <input type="hidden" id ="cost_${tokenId}" value="" class="costs" />
                    <input type="hidden" id ="inStock_${tokenId}" value="" class="inStock" />
                    <input type="hidden" value ="${tokenId}" class="hiddenToken" />
                    <input type="hidden" id ="priceholder_${tokenId }" value="" class="priceholder" />
                    <input type="hidden" id ="alcohol_${tokenId }" value="" class="alcohol" />
                    <input type="hidden" id ="margin_${tokenId }" value="" class="margin" />
                    <input type="hidden" id ="prohibited_${tokenId }" value="" class="prohibited" />
                    <input type="hidden" id ="soldByWieght${tokenId }" value="" class="soldByWieght" />
                    <input type="hidden" id ="unitWeight${tokenId }" value="" class="unitWeight" />
                    <input type="hidden" id ="strBulkUnit${tokenId }" value="" class="strBulkUnit" />
                    <input type="hidden" id ="productmarginauth${tokenId }" value="0" class="productmarginauth" />
                    <input type="hidden" id ="stockmanagement${tokenId }" value="0" class="stockmanagement" />
                    <button type="button" id="cancelThis" class="btn btn-icon btn-danger btn-sm btn-sm-icon cancel">
                        <i class="bi bi-trash3-fill fs-4"></i>
                    </button>
                </td>
                <td contenteditable="false">
                    <input style="width: 100px;" name="theProductCode" id ="prodCode_${tokenId}" class="theProductCode_ set_autocomplete inputs form-control">
                    <input name="col1" id ="col1${tokenId}" class="col1 ${classAnonymouscols}"  readonly>
                </td>
                <td contenteditable="false">
                    <input style="width: 250px;" name="prodDescription_" id ="prodDescription_${tokenId}" class="prodDescription_ set_autocomplete inputs form-control" tabindex="-1">
                    <input name="col8" id ="col8${tokenId}" class="col8 ${classAnonymouscols}" readonly>
                </td>
                <td contenteditable="false">
                    <input style="width: 65px;" type="text" name="prodBulk_"  id="prodBulk_${tokenId}" class="prodBulk_ resize-input-inside form-control" onkeypress="return isFloatNumber(this,event)">
                    <input name="col3" id ="col3${tokenId}" class="col3 ${classAnonymouscols}"  readonly>
                </td>
                <td contenteditable="false">
                    <input style="width: 65px;" type="text" name="prodQty_" id ="prodQty_${tokenId}" onkeypress="return isFloatNumber(this,event)" title="in stock" class="prodQty_ resize-input-inside inputs form-control">
                    <input name="col4" id ="col4${tokenId}" class="col4 ${classAnonymouscols}"  readonly>
                </td>
                <td contenteditable="false">
                    <input style="width: 100px;" type="text" name="prodPrice_" id ="prodPrice_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs form-control">
                    <div style="display: initial;" data-value="${tokenId}">
                    </div>
                </td>
                <td contenteditable="false">
                    <input style="width: 80px;" type="text" name="prodDisc_" id ="prodDisc_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside inputs form-control" {{ $discountProperty }}>
                    <input name="col6" id ="col6${tokenId}" class="col6 ${classAnonymouscols}"  style="color: brown;" readonly>
                </td>
                <td contenteditable="false">
                    <input style="width: 75px;" type="text" name="prodUnitSize_" id ="prodUnitSize_${tokenId}" class="prodUnitSize_ resize-input-inside form-control">
                    <input name="col7" id ="col7${tokenId}" class="col7 ${classAnonymouscols}" readonly>
                </td>
                <td contenteditable="false" style="display: flex;">
                    <input style="width: 100px; color: blue;" type="text" name="instockReadOnly" id ="instockReadOnly_${tokenId}" class="instockReadOnly_ resize-input-inside inputs form-control me-2">
                    <input style="width: 100px; color: red;" type="text" name="shelf" id ="shelf_${tokenId}" class="shelf_ resize-input-inside form-control">
                    <select name="col2" id ="col2${tokenId}" class="col2 ${classAnonymouscols}" ></select>
                </td>
                <td contenteditable="false">
                    <input style="width: 100px; color:blue;" type="text" name="clcstock" id ="clcstock_${tokenId}" class="clcstock_ resize-input-inside inputs form-control">
                </td>
                <td contenteditable="false">
                    <input style="width: 100px; color:blue;" type="text" name="additionalcost" id ="additionalcost_${tokenId}" class="additionalcost_ resize-input-inside inputs form-control">
                </td>
                <td contenteditable="false">
                    <input style="width: 200px;" type="text" name="prodComment_" id ="prodComment_${tokenId}" class="prodComment_ resize-input-inside lst inputs form-control">
                    <input name="col9" id ="col9${tokenId}" class="col9 ${classAnonymouscols}" readonly>
                </td>
            </tr>
        `);
        $('#table tbody')
            .append($row)
            .trigger('addRows', [$row, false]);

        var txt = $("#headerWh option:selected").text();
        var val = $("#headerWh option:selected").val();
        $("#col2" + tokenId).append("<option value='" + val + "'>" + txt + "</option>");
        $.each(wareautocomplete, function(i, item) {
            $("#col2" + tokenId).append("<option value='" + item.ID + "'>" + item.Warehouse + "</option>");
        });

        if (!$('.lst').is(":focus")) {
            $('#prodDescription_' + tokenId).click();
            $('#prodCode_' + tokenId).focus().click();

            // if ($('#checkboxDescription').is(':checked')) {
            //     $('#prodDescription_' + tokenId).focus();
            // }
        }

        /* $('.col2 ').on('click keyup' ,function(){
        var warehCols =  [{name: 'ID', minWidth:'230px',valueField: 'value'},
            ,{name: 'Warehouse', minWidth:'20px',valueField: 'Warehouse'}];
        $(""+jID+"").mcautocomplete({
                source: finalDataProductTest,
                columns:columnsD,
                autoFocus: true,
                minlength: 2,
                delay: 0,
                multiple: true,
                multipleSeparator: ",",
                select:function (e, ui) {

                }
            });
        });*/

        $('input').on('click keyup', function() {
            // $('input').click(function(){
            console.debug($(this));
            var ID = $(this).attr('id');
            var jID = '#' + ID;
            console.debug("ID---------------------------------" + ID);
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
                    //source: finalDataProductTest,
                    source: function(req, response) {
                        // Cancel previous AJAX request for this index
                        requestName = 'prodDescription_';
                        if (ajaxRequests[requestName]) {
                            ajaxRequests[requestName].abort();
                        }
                        ajaxRequests[requestName] = $.ajax({
                            url: "{{ route('sales-order.get-sales-order-products') }}",
                            dataType: "json",
                            data: {
                                term: req.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    columns: columnsD,
                    autoFocus: true,
                    minLength: getMinimumLengthOnSearch(),
                    delay: 500,
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
                        $('#prodDescription_' + token_number).prop('title', ui.item
                            .PastelDescription);
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                        //checkIfOrderHasMultipleProducts(ui.item.extra,token_number);
                        $('#prodQty_' + token_number).val('');

                        $('#table').find('#prodQty_' + token_number).focus();
                        $('#prodUnitSize_' + token_number).val(ui.item.UnitSize);
                        //   $('#instockReadOnly_' + token_number).val(ui.item.QtyInStock);
                        $('#taxCode' + token_number).val(ui.item.Tax);
                        $('#cost_' + token_number).val(ui.item.Cost);
                        $('#inStock_' + token_number).val(ui.item.Available);
                        $('#shelf_' + token_number).val(ui.item.Available);
                        $('#soldByWieght' + token_number).val(ui.item.SoldByWeight);
                        $('#unitWeight' + token_number).val(ui.item.UnitWeight);
                        $('#strBulkUnit' + token_number).val(ui.item.strBulkUnit);
                        $('#margin_' + token_number).val(ui.item.Margin);


                        if ($.trim(ui.item.SoldByWeight) == "1") {
                            $('#table').find('#prodBulk_' + token_number).focus();
                            $('#prodBulk_' + token_number).addClass('inputs');
                            $('#prodBulk_' + token_number).addClass('addgreen');

                        } else {
                            $('#prodBulk_' + token_number).prop('readonly', true);
                            $('#prodBulk_' + token_number).val(0);
                        }
                        GLOBALPRODCODE = ui.item.extra;
                        GLOBALPRODUCTDESCRIPTION = ui.item.value;
                        GLOBALQUANTITY = $('#prodQty_' + token_number).val();
                        GLOBALDISC = $('#prodDisc_' + token_number).val();

                        productPrice(token_number);


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
                        // Cancel previous AJAX request for this index
                        requestName = 'theProductCode_';
                        if (ajaxRequests[requestName]) {
                            ajaxRequests[requestName].abort();
                        }
                        ajaxRequests[requestName] = $.ajax({
                            url: "{{ route('sales-order.get-sales-order-products') }}",
                            dataType: "json",
                            data: {
                                term: req.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    columns: columnsC,
                    minLength: getMinimumLengthOnSearch(),
                    autoFocus: true,
                    delay: 500,
                    select: function(e, ui) {

                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);

                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                        $('#prodDescription_' + token_number).prop('title', ui.item
                            .PastelDescription);
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                        //checkIfOrderHasMultipleProducts(ui.item.extra,token_number);
                        $('#prodQty_' + token_number).val('');
                        $('#prodQty_' + token_number).focus();
                        //$('#inStock_' + token_number).val(ui.item.QtyInStock);
                        $('#table').find('#prodQty_' + token_number).focus();
                        $('#prodUnitSize_' + token_number).val(ui.item.UnitSize);
                        //$('#instockReadOnly_' + token_number).val(ui.item.QtyInStock);
                        $('#taxCode' + token_number).val(ui.item.Tax);
                        $('#cost_' + token_number).val(ui.item.Cost);
                        $('#inStock_' + token_number).val(ui.item.Available);
                        $('#shelf_' + token_number).val(ui.item.Available);
                        $('#soldByWieght' + token_number).val(ui.item.SoldByWeight);
                        $('#unitWeight' + token_number).val(ui.item.UnitWeight);
                        $('#strBulkUnit' + token_number).val(ui.item.strBulkUnit);
                        $('#margin_' + token_number).val(ui.item.Margin);
                        if ($.trim(ui.item.SoldByWeight) == "1") {
                            $('#table').find('#prodBulk_' + token_number).focus();
                            $('#prodBulk_' + token_number).addClass('inputs');
                            $('#prodBulk_' + token_number).addClass('addgreen');
                        } else {
                            $('#prodBulk_' + token_number).prop('readonly', true);
                            $('#prodBulk_' + token_number).val(0);
                        }
                        // $('#prodQty_' + token_number).attr('title', 'In Stock ' + parseFloat(ui.item.QtyInStock).toFixed(3));

                        productPrice(token_number);

                    }

                });
            }
            calculator();
        });

    }


    function calcAdditionalCost() {

        console.log("I am logging this things");
        $('#table tbody tr').each(function() {
            //

            $(this).find(".theProductCode_").each(function() {
                var totalAddCst = 0;
                var $this = $(this).closest('tr');
                var mQty = $this.find('.prodQty_').val();
                var productCode = $this.find('.theProductCode_').val();


                if ($.trim((productCode)).length > 1 && parseFloat(mQty) > 0) {
                    $.ajax({
                        url: '{!! url('/associatedItem') !!}',
                        type: "POST",
                        data: {
                            productCode: productCode,
                            customerCode: $('#inputCustAcc').val(),
                            delDate: $('#inputDeliveryDate').val(),
                        },
                        success: function(data) {


                            if (!$.trim(data)) {

                                $this.find(".additionalcost_").val(parseFloat(0));
                                totalAddCst = totalAddCst + parseFloat(0);
                                // $('#totaddidtionalcst').val(totalAddCst);
                            } else {
                                console.debug('tot ' + mQty * data[0].Price);
                                $this.find(".additionalcost_").val(parseFloat(mQty * data[0]
                                    .Price));
                                totalAddCst = totalAddCst + parseFloat(mQty * data[0]
                                .Price);
                                //   $('#totaddidtionalcst').val(totalAddCst);
                            }
                        }
                    });

                }
            });

        });

    }

    function focusoutcaladditionalcost(productCode, mQty, $this) {

        //  var totalAddCst = 0;
        // var $this =$(this).closest('tr');
        //  var mQty = $this.find('.prodQty_').val();
        // var productCode = $this.find('.theProductCode_').val();


        if ($.trim((productCode)).length > 1 && parseFloat(mQty) > 0) {
            $.ajax({
                url: '{!! url('/associatedItem') !!}',
                type: "POST",
                data: {
                    productCode: productCode,
                    customerCode: $('#inputCustAcc').val(),
                    delDate: $('#inputDeliveryDate').val(),
                },
                success: function(data) {
                    if (!$.trim(data)) {

                        $('#' + $this).val(parseFloat(0));
                    } else {
                        console.debug('tot ' + mQty * data[0].Price);
                        $('#' + $this).val(parseFloat(mQty * data[0].Price));
                    }
                    // totalAddCst = totalAddCst + parseFloat(mQty*data[0].Price);
                    //$('#totaddidtionalcst').val(totalAddCst);
                }
            });

        }

    }

    function calculator() {

        var arrayPrice = [];
        var arrayPrice = [];
        var arrayQty = [];
        var arrayDisc = [];
        var arrayPriceInc = [];
        var arrayProductsCode = [];
        var cost = [];
        var sumTotalCost = 0.00;
        var totalPrice = 0.00;
        var totalPriceDisc = 0;
        $('#table tbody tr').each(function() {

            var valuesPrice = [];
            var valuesQty = [];
            var valuesDisc = [];
            var valuesPriceInc = [];
            var valuesProdCodes = [];
            var valuesCost = [];


            $(this).find(".prodPrice_").each(function() {
                valuesPrice.push($(this).val());
                var mQty = $(this).closest('tr').find('.prodQty_').val();
                var myTDisc = $(this).closest('tr').find('.prodPrice_').val();

                if ($.trim($(this).val()) != '') {
                    totalPriceDisc = (parseFloat($(this).val()) * parseFloat(mQty)) * ((100 - myTDisc) /
                        100);
                    totalPrice = parseFloat(totalPrice) + totalPriceDisc;
                    console.debug('Total Price *****************' + totalPrice);
                    console.debug(
                        'Total Price *****************totalPriceDisctotalPriceDisctotalPriceDisctotalPriceDisc' +
                        totalPriceDisc);
                    //valuesProdCodes.push($(this).val());
                }
            });
            $(this).find(".prodQty_").each(function() {
                valuesQty.push($(this).val());
            });
            $(this).find(".prodDisc_").each(function() {
                if ($.trim(($(this).val())).length < 1) {
                    valuesDisc.push(0);
                } else {
                    valuesDisc.push($(this).val());
                }

            });
            $(this).find(".taxCodes").each(function() {
                valuesPriceInc.push($(this).val());
            });
            $(this).find(".theProductCode_").each(function() {

                if ($.trim($(this).val()) != '') {

                    arrayProductsCode.push($(this).val());
                }

            });
            $(this).find(".costs").each(function() {
                var mQty = $(this).closest('tr').find('.prodQty_').val();
                if ($.trim($(this).val()) != '') {
                    sumTotalCost = parseFloat(sumTotalCost) + (parseFloat($(this).val()) * parseFloat(
                        mQty));
                }
                //valuesCost.push($(this).val());
            });

            arrayPrice.push(valuesPrice);
            arrayQty.push(valuesQty);
            arrayDisc.push(valuesDisc);
            arrayPriceInc.push(valuesPriceInc);
            //cost.push(valuesCost);

        });
        var ar3 = [];
        for (var i = 0; i < arrayPrice.length; i++) {
            var valu = arrayPrice[i] * arrayQty[i];
            ar3[i] = valu;
        }

        var arPriceInclusive = [];
        for (var i = 0; i < arrayPrice.length; i++) {
            var valu = (arrayPrice[i] * arrayQty[i]) * (arrayPriceInc[i] / 100) + (arrayPrice[i] * arrayQty[i]);
            console.debug(valu);
            arPriceInclusive[i] = valu;
        }
        var arPriceInclusiveDisc = [];
        for (var i = 0; i < arrayPrice.length; i++) {
            var valu = ((arrayPrice[i] * ((100 - arrayDisc[i]) / 100)) * arrayQty[i]) * (arrayPriceInc[i] / 100) + ((
                arrayPrice[i] * ((100 - arrayDisc[i]) / 100)) * arrayQty[i]);
            // console.debug("valu***************************valu"+valu);
            arPriceInclusiveDisc[i] = valu;
        }
        var totalCost = sumTotalCost;

        var totalMargin = marginCalculator(totalCost, totalPrice);

        var sumarray = eval((ar3).join("+"));
        var sumPriceInc = eval((arPriceInclusive).join("+"));
        var sumPriceIncDisc = eval((arPriceInclusiveDisc).join("+"));
        var sumarrayOnInclusiveForDiscount = (sumPriceInc - parseFloat((parseFloat($('#dicPercHeader').val()) / 100) *
            sumPriceInc)).toFixed(2);
        var sumarrayOnInclusiveForDiscountAndLineDisc = (sumPriceIncDisc - parseFloat((parseFloat($('#dicPercHeader')
            .val()) / 100) * sumPriceIncDisc)).toFixed(2);
        var sumarrayOnExclusiveForDiscount = (sumarray - parseFloat((parseFloat($('#dicPercHeader').val()) / 100) *
            sumarray)).toFixed(2);

        $('#numberOfLines').empty();

        $('#numberOfLines').append(arrayProductsCode.length + " Line Item(s)");
        $('#totalEx').val(parseFloat(sumarrayOnExclusiveForDiscount).toFixed(2));
        $('#totalInc').val(parseFloat(sumarrayOnInclusiveForDiscount).toFixed(2));
        $('#totalInOrder').val(parseFloat(sumarrayOnInclusiveForDiscountAndLineDisc).toFixed(2));
        $('#totalmargin').val(totalMargin.toFixed(2));
        // calcAdditionalCost();

        // console.debug("array sum" + sumarray.toFixed(2));
        //console.debug("array sum" + sumPriceInc.toFixed(2));
        var crLimit = parseFloat($('#totalInc').val()) + parseFloat($('#balDue').val());
        $('#creditLimitWarningMessage').empty();
        if (crLimit > $('#creditLimit').val()) {
            var difference = crLimit - $('#creditLimit').val();
            $('#creditLimitWarningMessage').append('CREDIT LIMIT REACHED : ' + difference.toFixed(2));
            // console.debug('CREDIT LIMIT REACHED : '+difference.toFixed(2));
        }

    }

    function printDoc(url, docType, docID, isDeliveryNote, invoiceNumber) {
        $.ajax({
            url: url,
            type: "POST",
            data: {
                DocType: docType,
                DocId: docID,
                PrintDeliveryNote: isDeliveryNote,
                invoiceNumber: invoiceNumber
            },
            success: function(data) {
                if (data == 'Process failed') {
                    alert('Process failed');
                }
            }
        });
    }

    function orderPattern(addressId) {
        //
        datatableOrderPattern = $('#orderPatternIdTable').DataTable({
            "ajax": {
                url: '{!! url('/getOrderPattern') !!}',
                "type": "POST",
                data: function(data) {
                    data.CustomerCode = $('#inputCustAcc').val();
                    data.CustomerId = $('#CustomerId').val();
                    data.orderID = $('#orderId').val();
                    data.DeliveryAddressIId = addressId;
                }
            },
            "columns": [{
                    "data": "PastelDescription",
                    "class": "text-nowrap",
                },
                {
                    "data": "twoWeeks",
                    render: function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    }
                },
                {
                    "data": "Avg",
                    render: function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    }
                },
                {
                    "data": "Remaining",
                },
                {
                    "data": "Cost",
                    render: function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            if (jsn === "undefined") {
                                jsn = 0;
                            }
                            if (jsn === ".000") {
                                jsn = 0;
                            }
                            //console.log(" parsing json" + jsn);
                        } catch (e) {
                            jsn = 0;

                            return jsn;
                        }
                        return parseFloat(jsn).toFixed(2);

                    }

                },
                {
                    "data": "TrendingId",
                    render: function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {
                            //console.log("error parsing json - " + e.toString());
                            return jsn.data;
                        }
                        var icon = '<i class="fa fa-circle" ></i>';

                        switch (jsn) {
                            case 1:
                                icon = '<i class="fa fa-arrow-up" ></i>';
                                break;
                            case 2:
                                icon = '<i class="fa fa-arrow-down" ></i>';
                                break;
                            case 3:
                                icon = '<i class="fa fa-circle" ></i>';
                                break;
                            case 4:
                                icon = '<i class="fa fa-stop" ></i>';
                                break;
                            default:
                                icon = '<i class="fa fa-circle" ></i>';
                                break;
                        }
                        return icon;

                    }

                },
                {
                    "data": "authorised",
                },
                {
                    "data": "PastelCode",
                    "class": "text-nowrap",
                },
                {
                    "data": "PushProduct",
                },
                {
                    "data": "Tax",
                },
                {
                    "data": "UnitSize",
                },
                {
                    "data": "UnitWeight",
                },
                {
                    "data": "SoldByWeight",
                },
                {
                    "data": "strBulkUnit",
                },
                {
                    "data": "ProductMargin",
                }

            ],
            "createdRow": function(row, data, dataIndex) {

                if (data.PushProduct == "1") {
                    $(row).addClass('green');
                }
                if (data.TrendingId == "1") {
                    $(row).addClass('up');
                }
                if (data.TrendingId == "2") {
                    $(row).addClass('down');
                }
                if (data.TrendingId == "3") {
                    $(row).addClass('circle');
                }
                if (data.TrendingId == "4") {
                    $(row).addClass('stopped');
                }
            },
            "columnDefs": [{
                "width": "44%",
                "targets": 0
            }, {
                "width": "0%",
                "targets": 7
            }, {
                "width": "0%",
                "targets": 8
            }],
            "deferRender": true,
            "scrollY": "400px",
            "scrollCollapse": true,
            searching: true,
            bPaginate: false,
            bFilter: false,
            "LengthChange": false,
            "info": false,
            "ordering": false,
            "bDestroy": true,
            initComplete: function() {
                $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr(
                    'autocomplete', 'this-is');
            },
            autoFill: false,
            scrollX: true,
            // fixedColumns:   {
            //     left: 1
            // },
            dom:
                "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"

        });
        //  datatableOrderPattern.columns([6]).visible(false);
        $('#orderPatternIdTable_filter input').attr('autocomplete', 'this-is');
        // var formid=$(this).parents('td').prev().text().match(/[a-zA-Z]{,4}/);
        $('#orderPatternIdTable_filter input').attr("id", "thiswwwwwwwwwwwwwwwwww");
        $('#orderPatternIdTable_filter input').prop('readonly', true);

        $("#thiswwwwwwwwwwwwwwwwww").click(function(e) {
            e.preventDefault();
            $('#thiswwwwwwwwwwwwwwwwww').removeAttr('readonly');
            console.debug("this is it*********************______");
        });
        $('#orderPatternIdTable_filter input').removeClass('form-control-sm form-control-solid');


    }

    function fetchDeliveyAddressFronSelect(addressId) {
        $.ajax({
            url: '{!! url('/selectAddressFromMultiAddressDeliveruyAddressId') !!}',
            type: "POST",
            data: {
                CustomerCode: $('#inputCustAcc').val(),
                DeliveryAddressIId: addressId
            },
            success: function(data) {
                $('#address1').val(data[0].DAddress1);
                $('#address2').val(data[0].DAddress2);
                $('#address3').val(data[0].DAddress3);
                $('#address4').val(data[0].DAddress4);
                $('#address5').val(data[0].DAddress5);
                //$('#deliveryAddressIdOnPopUp').val(data[0].DeliveryAddressIId);
                $('#generalRouteForNewDeliveryAddress').empty();
                getRoutes('#generalRouteForNewDeliveryAddress', '{!! url('/getCommonRoutes') !!}');
                $("#generalRouteForNewDeliveryAddress").prepend('<option value="' + data[0].Routeid +
                    '" selected="selected">' + data[0].Route + '</option>');

            }
        });
    }

    function onClickingDeliveryAddress() {
        $('#listOfDelivAdress').show();
        $("#listOfDelivAdress").dialog({
            height: 600,
            width: 950,
            containment: false
        }).dialogExtend({
            "closable": false, // enable/disable close button
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
        $('#listaddresses li').click(function() {
            var $this = $(this);
            var selKeyVal = $this.attr("value");
            // alert('Text ' + $this.text() + 'value ' + selKeyVal);

            $("#hiddenDeliveryAddressId").val(selKeyVal);
            $("#customerSelectedDelDate").val($this.text());
            $("#deliveryAddressIdOnPopUp").val(selKeyVal);
            //$('#doneCustomAddress').show();
            //pass this to fetch address
            console.debug("just assigned this now*******" + selKeyVal);
            fetchDeliveyAddressFronSelect(selKeyVal);

            // $("#listOfDelivAdress" ).dialog("close");
        });
    }

    function putInArray(productCode) {
        var productCodes = [];
        $('#table tr').each(function() {
            $(this).find(".theProductCode_").each(function() {
                productCodes.push($(this).val());
                if ($.inArray(productCode, productCodes) == -1) {
                    // the element is not in the array
                    productCodes.push(productCode);
                } else {
                    alert("it already added");
                }
            });
        });

    }

    function productPrice(token_number) {
        $.ajax({
            url: '{!! url('/getCutomerPriceOnOrderForm') !!}',
            type: "POST",
            data: {
                customerID: $('#inputCustAcc').val(),
                deliveryDate: $('#inputDeliveryDate').val(),
                productCode: $('#prodCode_' + token_number).val(),
                warehouseid: $('#headerWh').val()
            },
            success: function(data) {


                if (data.length > 0) {
                    console.debug("Price Here" + data[0].Price);
                    if (parseFloat(data[0].Price).toFixed(2) > 0) {

                        if ($('#prodQty_' + token_number).val() == '0') {
                            $('#prodQty_' + token_number).val('');
                        }
                        if ($.isEmptyObject(data)) {
                            // $('#prodPrice_' + token_number).val('');
                            $('#cost_' + token_number).val('');

                        } else {
                            //AvailOnly

                            if (data[0].AvailOnly <= 0 && data[0].mustAuthLine != 0) {
                                $('#title_' + token_number).val('preauthorised');
                                $('#appendErrormsg').empty();
                                $('#appendErrormsg').append(
                                    "It appears that you don't have enough in stock");
                                showDialogWithoutClose("#authorisations", 500, 400);
                                //if (e.keyCode == 27) return false;
                                $('#noThanksRedo').off().click(function() {
                                    $('#new_row_ajax' + token_number).remove();
                                    calculator();
                                    generateALine2();
                                    $("#authorisations").dialog('close');
                                });
                                $('#doAuth').off().click(function() {
                                    // $('#userAuthName').val();
                                    console.debug($('#userAuthPassWord').val());
                                    $('#userAuthPassWord').val();
                                    $.ajax({
                                        url: '{!! url('/verifyAuthOnAdmin') !!}',
                                        type: "POST",
                                        data: {
                                            userName: $('#userAuthName').val(),
                                            userPassword: $('#userAuthPassWord').val(),
                                            orderId: $('#orderId').val()
                                        },
                                        success: function(data) {
                                            //console.debug("bunch"+data);
                                            if ($.isEmptyObject(data)) {
                                                alert(
                                                    "Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                                            } else {
                                                $('#userAuthName').val('');
                                                $('#userAuthPassWord').val('');
                                                $('#title_' + token_number).val(
                                                    'preauthorised');
                                                console.debug('///////////////////' + $(
                                                        '#title_' + token_number)
                                                    .val());

                                                consoleManagementAuths(
                                                    '{!! url('/logMessageAuth') !!}', 12,
                                                    1,
                                                    'Authorized out os Stock by ' +
                                                    data[0].UserName,
                                                    0, $('#orderId').val(), '', $(
                                                        '#inputCustAcc').val(), 0,
                                                    0, 0, $('#userNewVariable')
                                                    .val(), $('#orderId').val(), 0,
                                                    computerName, $('#orderId')
                                                    .val(), 0, data[0].UserID, data[
                                                        0].UserName);
                                                $("#authorisations").dialog('close');
                                                calculator();


                                            }
                                        }
                                    });

                                });

                                //isCorrectCredentials
                            }
                            $('#prodPrice_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                            $('#marginandpriceauthbycustomer').val(data[0].authPrices);
                            $('#prohibited_' + token_number).val(parseFloat(data[0].Prohibited).toFixed(2));
                            $('#instockReadOnly_' + token_number).val(data[0].AvailableToSell);
                            $('#prodDisc_' + token_number).val(parseFloat(data[0].LineDisc).toFixed(2));
                            $('#stockmanagement' + token_number).val(data[0].StockManagement);

                            if (data[0].theMg == "NEEDAUTH") {
                                linetotal(1, data[0].Price, data[0].Tax, marginCalculator(data[0].Cost,
                                    data[0].Price));
                                $('#prodPrice_' + token_number).focus();
                                /* var dialog = $('<p><strong style="color:red">Authorization Needed</strong></p>').dialog({
                                     height: 200, width: 700,modal: true,containment: false,
                                     buttons: {
                                         "Okay": function () {
                                             dialog.dialog('close');
                                         }
                                     }
                                 });*/
                            }
                            if (data[0].intAssociated != "0") {
                                $('#' + token_number).css('background', '#FF0000');
                            }


                            //   console.debug("allow discount *************************************"+data[0].allowedDiscount);
                            /* if(data[0].allowedDiscount != 0)
                    {
                        console.debug("allow discount *************************************"+data[0].allowedDiscount);
                      //  $('#prodPrice_' + token_number).prop('readonly', true);
                    }*/
                            if (reportmarginControl === 'marginType5') {
                                $('#priceholder_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                            }


                        }
                    } else {
                        if (data[0].theMg == "NEEDAUTH") {
                            $('#prodPrice_' + token_number).focus();
                            /* var dialog = $('<p><strong style="color:red">Authorization Needed</strong></p>').dialog({
                                 height: 200, width: 700,modal: true,containment: false,
                                 buttons: {
                                     "Okay": function () {
                                         dialog.dialog('close');
                                     }
                                 }
                             });*/
                        }
                        //theOrdersDetailsId
                        $('#prodPrice_' + token_number).val('0');
                        if ($('#marginandpriceauthbycustomer').val().length > 1) {
                            $('#prodPrice_' + token_number).val('0');
                            $('#ZeroPrice').show();
                            showDialogWithoutClose('#ZeroPrice', '40%', 300);
                            $('#ZeroPrice').keydown(function(event) {
                                if (event.keyCode == 27) {
                                    return false;
                                }
                            });
                            //   $( "#authorisations" ).dialog('close');
                            // $( "#MarginProblems" ).dialog('close');
                            authZeroPricing(token_number, $('#theOrdersDetailsId' + token_number).val(), $(
                                '#prodCode_' + token_number).val());
                        }
                    }
                } else {
                    if (data[0].theMg == "NEEDAUTH") {
                        $('#prodPrice_' + token_number).focus();
                        /* var dialog = $('<p><strong style="color:red">Authorization Needed</strong></p>').dialog({
                             height: 200, width: 700,modal: true,containment: false,
                             buttons: {
                                 "Okay": function () {
                                     dialog.dialog('close');
                                 }
                             }
                         });*/
                    }

                    if ($('#marginandpriceauthbycustomer').val().length > 1) {
                        $('#prodPrice_' + token_number).val('0');
                        $('#ZeroPrice').show();
                        showDialogWithoutClose('#ZeroPrice', '40%', 300);
                        $('#ZeroPrice').keydown(function(event) {
                            if (event.keyCode == 27) {
                                return false;
                            }
                        });

                        // $( "#MarginProblems" ).dialog('close');
                        authZeroPricing(token_number, $('#theOrdersDetailsId' + token_number).val(), $(
                            '#prodCode_' + token_number).val());
                        $("#authorisations").dialog('close');
                    }
                }


            }
        });
    }

    function qtyInStock(token_number) {
        $.ajax({
            url: '{!! url('/stockApi') !!}',
            type: "POST",
            data: {
                ItemCode: $('#prodCode_' + token_number).val()
            },
            success: function(data) {

                $('#instockGlobal').val('');

                $('#instockGlobal').val(data);
                $('#instockReadOnly_' + token_number).val(data);

                $('#clcstock_' + token_number).val(ParseFloat(data) - 1);
            }
        });
    }

    function isCorrectCredentials(username, password) {
        var answer = 'match';
        $.ajax({
            url: '{!! url('/credentialsmatch') !!}',
            type: "POST",
            data: {
                ItemCode: 1
            },
            success: function(data) {
                answer = data;
            }
        });
        return answer
    }

    function qtyAvailableOnClick(productCode) {
        //On click show available
        $.ajax({
            url: '{!! url('/stockApi') !!}',
            type: "POST",
            data: {
                ItemCode: productCode
            },
            success: function(data) {
                $('#availableOnTheFly').empty();
                $('#instockGlobal').val('');
                $('#instockGlobal').val(data);


            }
        });
    }

    function qtyInStockOnPriceCheck(productCode) {
        var instock;
        instock = $.ajax({
            url: '{!! url('/stockApi') !!}',
            type: "POST",
            data: {
                ItemCode: productCode
            },
            success: function(data) {
                console.debug('*********************' + data);
                instock = data;
            }
        });
        return instock;
    }

    function productPriceOnReadyMadeLine(productCode, producutDescr, tax, cost, title, inStock, unitSizes, UnitWeight,
        SoldByWeight, strBulkUnit, ProductMargin, multiLines) {

        calculator();
        $.ajax({
            url: '{!! url('/getCutomerPriceOnOrderForm') !!}',
            type: "POST",
            data: {
                customerID: $('#inputCustAcc').val(),
                deliveryDate: $('#inputDeliveryDate').val(),
                productCode: productCode,
                warehouseid: $('#headerWh').val()
            },
            success: function(data) {
                console.debug(data);
                var price = '';

                var weneedauth = 0;
                if (data[0].theMg == "NEEDAUTH") {
                    weneedauth = 1;

                }
                console.debug("********************" + data[0].shelf);

                if ($.isEmptyObject(data)) {
                    price = '';
                    console.debug("UnitWeight ====" + UnitWeight);
                    console.debug("SoldByWeight ====" + SoldByWeight);
                    console.debug("strBulkUnit ====" + strBulkUnit);
                    readyMadeLineOrderLine('#table tbody', producutDescr, productCode, ' ', price, 0,
                        inStock, title, tax, unitSizes, 0, UnitWeight, SoldByWeight, strBulkUnit,
                        ProductMargin, multiLines, data[0].LineDisc, linediscount, weneedauth, data[0]
                        .shelf);
                } else {
                    price = parseFloat(data[0].Price).toFixed(2);

                    if (reportmarginControl === 'marginType5') {
                        //cost = price;
                        cost = cost;
                    }
                    readyMadeLineOrderLine('#table tbody', producutDescr, productCode, '', price, cost,
                        inStock, title, tax, unitSizes, data[0].Prohibited, UnitWeight, SoldByWeight,
                        strBulkUnit, ProductMargin, multiLines, data[0].LineDisc, linediscount,
                        weneedauth, data[0].shelf);
                    // }

                }

            }
        });
    }
    //Plus key is Pressed
    $(function() {
        $('#tblOnsalesOrder,#tblOnInvoiced').on('keydown', function(ev) {

            if ((ev.keyCode === 107 || ev.keyCode === 17) && ($('#orderId').val()).length < 1) {
                if ((globalOrderIdToBePushed[0]).length > 1) {
                    $('#orderId').val(globalOrderIdToBePushed[0]);
                    $('#checkOrders').click();
                    $('#prodOnOrder').dialogExtend("minimize");
                    $('#prodonInvoice').dialogExtend("minimize");
                }

            } else if (($('#orderId').val()).length > 3) {
                alert('You have opened already ,Please finish the current');
            }


        });
        $('#tblOnsalesOrder').focus();
    });
    $(function() {
        $('#tblOnsalesOrder').on('keydown', function(ev) {

            if (ev.keyCode === 109 && ($('#orderIds').val()).length < 1) {
                if ((globalOrderIdToBePushed[0]).length > 1) {
                    //dispatchQuantityForm
                    $('#dispatchQuantityForm').show();
                    showDialog('#dispatchQuantityForm', '80%', 640);
                    console.debug("********" + globalOrderIdToBePushed[0]);
                    makeALineWithOrderID(globalOrderIdToBePushed[0], '#tableDispatch tbody',
                        '{!! url('/onCheckOrderHeaderDetails') !!}', '{!! url('/contactDetailsOnOrder') !!}',
                        arrayOfCustomerInfo)
                }
            } else if (($('#orderIds').val()).length > 3) {
                alert('You have opened already ,Please finish the current');
            }

        });
        $('#tblOnsalesOrder').focus();
    });
    $(document).ready(function() {
        $('#table,#tableDispatch tbody').on('focusout', 'tr', function() {
            //alert("focusing out tests");

            calculator();
            var $cells = $(this).find(".prodPrice_");
            var $cellsId = $(this).find(".prodPrice_").attr("id");
            var $cellProdCode = $(this).find(".theProductCode_");
            var $cellProdCodeID = $(this).find(".theProductCode_").attr("id");

            //productSetting

            if ($.inArray($('#' + $cellProdCodeID).val(), arrayProdCodesCheck) !== -1) {

            } else {
                arrayProdCodesCheck.push($('#' + $cellProdCodeID).val());
                console.debug(arrayProdCodesCheck);
                //alert("new born");
            }
            var $cellProdDescription = $(this).find(".prodDescription_");
            var $Description = $(this).find(".prodDescription_").val();
            var $cellProdDescriptionID = $(this).find(".prodDescription_").attr("id");
            var additionalcostcolumn = $(this).find(".additionalcost_").attr("id");
            var $cellProdQuant = $(this).find(".prodQty_").attr("id");
            //var $cellProdQuantOld = $(this).find(".prodQty_").data('val');
            var $isAuth = $(this).find(".title");
            var $isAuthAtrr = $(this).find(".title").attr("id");
            var $iTHasMargin = $(this).find(".margin").attr("id");
            var productmargin = $(this).find(".margin").val();
            var $alcohol = $(this).find(".alcohol").attr("id");
            var $deleteaLine = $(this).find("#deleteaLine").val();
            var productmarginauth = $(this).find(".productmarginauth").val();

            var $cost = $(this).find(".priceholder").val();
            var theProductCode_ = $(this).find(".theProductCode_").val();
            var $costFromTheDatabase = $(this).find(".costs").val();
            var $hiddenToken = $(this).find(".hiddenToken").val();
            var $inStock = $(this).find(".inStock").val();
            var authString = $(this).find(".title").val();
            var prohited = $(this).find(".prohibited").val();
            var fieldQuantity = $(this).find(".prodQty_").val();
            var theOrdersDetailsId = $(this).find("#theOrdersDetailsId").val();
            var prodCell = $('#' + $cellsId).val();
            focusoutcaladditionalcost(theProductCode_, fieldQuantity, additionalcostcolumn);
            var margin = marginCalculator($costFromTheDatabase, prodCell);
            var companyMargin = ($('#' + $iTHasMargin).val() / 100); //this a field

            if (prodCell != $cost)

                if (($('#' + $cellsId).val()).length < 1 && ($('#' + $cellProdCodeID).val()).length >
                    0) {
                    $('#' + $cellsId).val('');
                }

            if (parseInt(prohited) === 1) {
                //alert("good");
                authProhited($hiddenToken);
            }

            //{
            switch (reportmarginControl) {
                case 'marginType1':
                    if ($inStock.length > 0 && prodCell.length > 0) {
                        if (margin < companyMargin) {
                            if (authString.length > 0 && ($('#' + $cellProdCodeID).val()).length > 0) {
                                authPopup("Price", $('#' + $cellsId).val(), 0, $('#' + $cellProdCodeID)
                                    .val(), 'Price below margin ' + $cellProdCode.val() + '(' +
                                    $cellProdDescription.val() + ')', $isAuthAtrr, $hiddenToken, $
                                    .trim(theOrdersDetailsId));
                            }
                        }

                        if (booze.length < 1 && $('#' + $alcohol).val() == 1 && $('#boozeChecked').val()
                            .length < 1) {

                            var dialog = $(
                                '<p><strong style="color:red">You are aware that this customer does not have liquore license and you cannot sell alcohol to them</strong></p>'
                                ).dialog({
                                height: 200,
                                width: 700,
                                modal: true,
                                containment: false,
                                buttons: {
                                    "Okay": {
                                        text: "Okay",
                                        class: "btn btn-success btn-sm",
                                        click: function() {
                                            $('#boozeChecked').val('true');
                                            $('#'.$cellProdQuant).focus();
                                            dialog.dialog('close');
                                        }
                                    }
                                }
                            });
                        }
                    }
                    break;
                case 'marginType5':

                    if (($.trim(prodCell)).length > 0 && prodCell != $costFromTheDatabase) {
                        if (authString.length > 0 && ($('#' + $cellProdCodeID).val()).length > 0) {
                            console.debug('margin vs CompanyMargin ' + margin + ' vs ' + CompanyMargin +
                                'prodCell ' + prodCell + ' $cost ' + $cost +
                                'auth string **********' + authString.length);
                            if (margin < CompanyMargin && prodCell != $cost && isAuthPrice !=
                                "LFALSE") {
                                console.debug("I need auth+++++++++++++++++++++++++++++++" + $('#' +
                                    $cellProdCodeID).val());
                                console.debug("I need auth isAuthPrice+++++++++++++++++++++++++++++++" +
                                    isAuthPrice);
                                authPopup("Price", $('#' + $cellsId).val(), theProductCode_, $('#' +
                                        $cellProdCodeID).val(), 'Changed Price ' + $cellProdCode
                                    .val() + '(' + $cellProdDescription.val() + ')', $isAuthAtrr,
                                    $hiddenToken, $.trim(theOrdersDetailsId));
                            }
                        }
                    }


                    break;
            }

            var global = parseFloat($('#instockGlobal').val()).toFixed(2);
            var prodQuantity = parseFloat($('#' + $cellProdQuant).val()).toFixed(2);
            var inQuant = parseFloat($inStock).toFixed(2);


            if (($('#' + $cellProdQuant).val()).length < 1 && ($('#' + $cellProdCodeID).val()).length >
                0) {
                $('#' + $cellProdQuant).val(1);
                $('#' + $cellProdQuant).select();
                //$('#' + $cellsId).select();
            }



            if ($.trim($iTHasMargin) > 0 && ($.trim($('#' + $cellsId).val())).length > 0) {
                if (margin < companyMargin) {

                    if (authString.length > 0 && ($('#' + $cellProdCodeID).val()).length > 0) {
                        authPopup("Price", $('#' + $cellsId).val(), theProductCode_, $('#' +
                                $cellProdCodeID).val(), 'Price below margin ' + $cellProdCode
                        .val() + '(' + $cellProdDescription.val() + ')', $isAuthAtrr, $hiddenToken,
                            $.trim(theOrdersDetailsId));
                    }
                }
            }


            if (isAuthPrice === 'LTRUE' && authString === 'PRICECHANGED') {
                authPopup("Price", $('#' + $cellsId).val(), theProductCode_, $('#' + $cellProdCodeID)
                    .val(), 'Price Changed ' + $cellProdCode.val() + '(' + $cellProdDescription
                    .val() + ')', $isAuthAtrr, $hiddenToken, $.trim(theOrdersDetailsId));

            }

            //productmargin    $costFromTheDatabase  margin


            if (fieldQuantity < 0.0000005 && ($('#' + $cellProdQuant).val()).length > 0 &&
                theProductCode_.length > 0 && fieldQuantity.length > 0) {
                $('#qtyzero').show();
                showDialogWithoutClose('#qtyzero', 400, 200);
                $('#yestozeroqty').click(function() {
                    $('#qtyzero').dialog('close');
                });
            }

            ///var margin = marginCalculator(cost, price);
            if ((productmargin > margin) && isAuthPrice !== 'LTRUE' && authString === 'PRICECHANGED') {
                console.debug("Morning vibe=================================================" + $.trim(
                    prodCell).length);
                if ($.trim(prodCell).length > 0) {

                    $('#MarginProblems').show();
                    $('#userAuthProhibitedCred_marg').val('');
                    $('#userAuthPassWordCredit_marg').val('');
                    showDialogWithoutClose('#MarginProblems', 400, 400);
                    var $this = $(this);
                    $('#MarginProblems').keydown(function(event) {
                        if (event.keyCode == 27) {
                            return false;
                        }
                    });

                    $('#doAuthCredits').off().click(function() {

                        $.ajax({
                            url: '{!! url('/verifyAuthGroupLeaders') !!}',
                            type: "POST",
                            data: {
                                userName: $('#userAuthProhibitedCred_marg').val(),
                                userPassword: $('#userAuthPassWordCredit_marg').val(),
                                orderId: $('#orderId').val()
                            },
                            success: function(data) {
                                if ($.isEmptyObject(data)) {
                                    alert(
                                        "Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                                } else {
                                    $('#margin_auth').val(1);
                                    consoleManagementAuths(
                                        '{!! url('/logMessageAuthMargin') !!}', 12, 1,
                                        'Authorized Product (' +
                                        theProductCode + ') Margin ( LM :' +
                                        margin + ' PM ' + productmargin +
                                        ')  by ' + data[0].UserName,
                                        0, $('#orderId').val(), '', $(
                                            '#inputCustAcc').val(), 0, 0, 0, $(
                                            '#userAuthProhibitedCred_marg')
                                        .val(), $('#orderId').val(), 0,
                                        computerName, $('#orderId').val(), 0,
                                        data[0].UserID, data[0].UserName);
                                    $("#MarginProblems").dialog('close');
                                    $this.closest('tr').find('.title').val('');



                                    //calculator();
                                }
                            }
                        });

                    });
                    $('#doCancelAuthCredits').off().click(function() {
                        $this.closest('tr').find('.prodPrice_').val('');
                        $this.closest('tr').find('.prodPrice_').select();
                        $this.closest('tr').find('.prodPrice_').focus();
                        $('#MarginProblems').dialog('close');
                    });
                }

            }

        });
        //prodDescription_
        /*    $(document).on("focusout",".prodDescription_",function(){
                 var auth = $(this).closest('tr').find('.title').val();
                 var cost = $(this).closest('tr').find('.costs').val();
                 var price = $(this).closest('tr').find('.prodPrice_').val();
                 var theProductCode = $(this).closest('tr').find('.theProductCode_').val();
                 var margin = $(this).closest('tr').find('.margin').val();
                 var prodQty = $(this).closest('tr').find('.prodQty_').val();
                 var hiddenToken = $(this).closest('tr').find('.hiddenToken').val();
                 var $cellsId = $(this).find(".prodPrice_").attr("id");

                 if(theProductCode.length > 0 && auth.length > 4){
                     somemainAuth(theProductCode,price,prodQty,cost,margin,hiddenToken)
                 }
                //alert("product name "+auth);
             });
             $(document).on("focusout",".theProductCode_",function(){
                 var auth = $(this).closest('tr').find('.title').val();
                 var cost = $(this).closest('tr').find('.costs').val();
                 var price = $(this).closest('tr').find('.prodPrice_').val();
                 var theProductCode = $(this).closest('tr').find('.theProductCode_').val();
                 var margin = $(this).closest('tr').find('.margin').val();
                 var prodQty = $(this).closest('tr').find('.prodQty_').val();
                 var hiddenToken = $(this).closest('tr').find('.hiddenToken').val();
                 var $cellsId = $(this).find(".prodPrice_").attr("id");

                 if(theProductCode.length > 0 && auth.length > 4){
                     somemainAuth(theProductCode,price,prodQty,cost,margin,hiddenToken)
                 }
                // alert("product code "+auth );
             });
             $(document).on("focusout",".prodBulk_",function(){
                 var auth = $(this).closest('tr').find('.title').val();
                 var cost = $(this).closest('tr').find('.costs').val();
                 var price = $(this).closest('tr').find('.prodPrice_').val();
                 var theProductCode = $(this).closest('tr').find('.theProductCode_').val();
                 var margin = $(this).closest('tr').find('.margin').val();
                 var prodQty = $(this).closest('tr').find('.prodQty_').val();
                 var hiddenToken = $(this).closest('tr').find('.hiddenToken').val();
                 var $cellsId = $(this).find(".prodPrice_").attr("id");

                 if(theProductCode.length > 0 && auth.length > 4){
                     somemainAuth(theProductCode,price,prodQty,cost,margin,hiddenToken)
                 }
                // alert("product Bulk "+auth);
             });
             $(document).on("focusout",".prodQty_",function(){
                 var auth = $(this).closest('tr').find('.title').val();
                 var cost = $(this).closest('tr').find('.costs').val();
                 var price = $(this).closest('tr').find('.prodPrice_').val();
                 var theProductCode = $(this).closest('tr').find('.theProductCode_').val();
                 var margin = $(this).closest('tr').find('.margin').val();
                 var prodQty = $(this).closest('tr').find('.prodQty_').val();
                 var hiddenToken = $(this).closest('tr').find('.hiddenToken').val();
                 var $cellsId = $(this).find(".prodPrice_").attr("id");

                 if(theProductCode.length > 0 && auth.length > 4){
                     somemainAuth(theProductCode,price,prodQty,cost,margin,hiddenToken)
                 }
               //  alert("product qty "+auth);
             });
             $(document).on("focusout",".prodComment_",function(){
                 var auth = $(this).closest('tr').find('.title').val();
                 var cost = $(this).closest('tr').find('.costs').val();
                 var price = $(this).closest('tr').find('.prodPrice_').val();
                 var theProductCode = $(this).closest('tr').find('.theProductCode_').val();
                 var margin = $(this).closest('tr').find('.margin').val();
                 var prodQty = $(this).closest('tr').find('.prodQty_').val();
                 var hiddenToken = $(this).closest('tr').find('.hiddenToken').val();
                 var $cellsId = $(this).find(".prodPrice_").attr("id");

                 if(theProductCode.length > 0 && auth.length > 4){
                     somemainAuth(theProductCode,price,prodQty,cost,margin,hiddenToken)
                 }
                // somemainAuth(productCode,price,qty,cost,itemMargin,token_number)
                 //alert("product comment "+auth);
             });*/
        function somemainAuth(productCode, price, qty, cost, itemMargin, token_number) {
            price = parseFloat(price);
            qty = parseFloat(qty);
            cost = parseFloat(cost);
            itemMargin = parseFloat(itemMargin);
            console.debug("token_number**********************" + token_number);
            //  var n = token_number.indexOf("_");
            var token_numbernew = token_number;
            console.debug("token_numbernew****" + token_numbernew);
            console.debug("itemMargin****" + itemMargin);
            console.debug("cost****" + cost);
            console.debug("price****" + price);

            if (marginCalculator(cost, price) < itemMargin && productCode.length > 0 && itemMargin.length > 0) {
                $('#MarginProblems').show();
                $('#userAuthProhibitedCred_marg').val('');
                $('#userAuthPassWordCredit_marg').val('');
                showDialogWithoutClose('#MarginProblems', 400, 400);
                $('#MarginProblems').keydown(function(event) {
                    if (event.keyCode == 27) {
                        return false;
                    }
                });
                $('#MarginProblems').keyup(function(event) {
                    if (event.keyCode == 27) {
                        return false;
                    }
                });

                $('#doAuthCredits').off().click(function() {
                    //$('#MarginProblems').dialog('close');
                    $.ajax({
                        url: '{!! url('/verifyAuthGroupLeaders') !!}',
                        type: "POST",
                        data: {
                            userName: $('#userAuthProhibitedCred_marg').val(),
                            userPassword: $('#userAuthPassWordCredit_marg').val(),
                            orderId: $('#orderId').val()
                        },
                        success: function(datainner) {
                            console.debug(datainner);
                            if ($.isEmptyObject(datainner)) {
                                $('#new_row_ajax' + token_numbernew).remove();
                                calculator();
                                generateALine2();
                                alert(
                                    "Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");

                            } else {
                                //console.debug("title "+title);
                                $('#margin_auth').val(1);
                                consoleManagementAuths('{!! url('/logMessageAuthMargin') !!}', 12, 1,
                                    'Authorized Product (' + $('#prodCode_' +
                                        token_numbernew).val() + ')  by ' + datainner[0]
                                    .UserName,
                                    0, $('#orderId').val(), '', $('#inputCustAcc')
                                .val(), 0, 0, 0, $('#userAuthProhibitedCred_marg')
                                .val(), $('#orderId').val(), 0, computerName, $(
                                        '#orderId').val(), 0, datainner[0].UserID, data[
                                        0].UserName);
                                $("#MarginProblems").dialog('close');

                                $('#title_' + token_numbernew).val('');
                                $('#MarginProblems').dialog('close');


                            }
                            //calculator();
                        }

                    });

                });
                $('#doCancelAuthCredits').off().click(function() {
                    console.debug("Function has occured as margin problem cancel click");
                    $('#MarginProblems').dialog('close');

                    $('#new_row_ajax' + token_numbernew).remove();
                    calculator();
                    generateALine2();

                });

            }

        }
        $(document).on("focusout", ".prodPrice_", function() {

            var $this = $(this);
            var price = $(this).closest('tr').find('.prodPrice_').val();
            if (price.length < 1) {
                price = 0;
            }
            var cost = $(this).closest('tr').find('.costs').val();
            //  var price = $(this).closest('tr').find('.prodPrice_').val();
            var theProductCode = $(this).closest('tr').find('.theProductCode_').val();
            var Productmargin = $(this).closest('tr').find('.margin').val();
            var auth = $(this).closest('tr').find('.title').val();


            var margin = marginCalculator(cost, price);

            // if((parseFloat(Productmargin)  > parseFloat(margin).toFixed(2)) && auth.length>4  )
            if (price == 7125) {
                $('#MarginProblems').show();
                $('#userAuthProhibitedCred_marg').val('');
                $('#userAuthPassWordCredit_marg').val('');
                showDialogWithoutClose('#MarginProblems', 400, 400);
                $('#MarginProblems').keydown(function(event) {
                    if (event.keyCode == 27) {
                        return false;
                    }
                });
                $('#MarginProblems').keyup(function(event) {
                    if (event.keyCode == 27) {
                        return false;
                    }
                });
                $('#doAuthCredits').off().click(function() {

                    $.ajax({
                        url: '{!! url('/verifyAuthGroupLeaders') !!}',
                        type: "POST",
                        data: {
                            userName: $('#userAuthProhibitedCred_marg').val(),
                            userPassword: $('#userAuthPassWordCredit_marg').val(),
                            orderId: $('#orderId').val()
                        },
                        success: function(data) {
                            if ($.isEmptyObject(data)) {
                                alert(
                                    "Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                            } else {
                                $('#margin_auth').val(1);
                                consoleManagementAuths('{!! url('/logMessageAuthMargin') !!}',
                                    12, 1, 'Authorized Product (' +
                                    theProductCode + ') Margin ( LM :' +
                                    margin + ' PM ' + Productmargin + ')  by ' +
                                    data[0].UserName,
                                    0, $('#orderId').val(), '', $(
                                        '#inputCustAcc').val(), 0, 0, 0, $(
                                        '#userAuthProhibitedCred_marg').val(),
                                    $('#orderId').val(), 0, computerName, $(
                                        '#orderId').val(), 0, data[0].UserID,
                                    data[0].UserName);
                                $("#MarginProblems").dialog('close');
                                $this.closest('tr').find('.title').val('');



                                //calculator();
                            }
                        }
                    });

                });
                $('#doCancelAuthCredits').off().click(function() {
                    $this.closest('tr').find('.prodPrice_').val('');
                    $this.closest('tr').find('.prodPrice_').select();
                    $this.closest('tr').find('.prodPrice_').focus();
                    $('#MarginProblems').dialog('close');
                });
            }


        });
        //Split form
        $('#tblSplitOrder tbody').on('focusout', 'tr', function() {
            var $this = $(this);
            var backorderqty = $this.find(".back").val();
            var orderedqty = $this.find(".ordered").val();
            var origingback = $this.find(".origingback").val();

            if (backorderqty > orderedqty) {
                var dialog = $(
                    '<p><strong style="color:red">You cannot put value greater than ordered quantity</strong></p>'
                    ).dialog({
                    height: 200,
                    width: 700,
                    modal: true,
                    containment: true,
                    buttons: {
                        "Okay": {
                            text: "Okay",
                            class: "btn btn-success btn-sm",
                            click: function() {
                                $this.find(".back").val(origingback);
                                dialog.dialog('close');
                            }
                        }
                    }
                });
            }

        });


    });
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

            if (prod.length < 1 || prodDesc.length < 1 || prodQty_.length < 1 || prodPrice_.length < 1) {
                // $("#"+myRowId).remove();
                // generateALine2();
                var index = $('.inputs').index(this);
                myRow.find(".theProductCode_").focus();
            } else {
                $('.lst').eq(index).focus();
                generateALine2();


            }


        }
    });
    //
    $(document).on('keydown', '.onPosAmount', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        var testLst = $(this).closest('tr');
        if ((code == 13 || code == 39)) {
            var index = $('.onPosAmount').index(this) + 1;
            $('.onPosAmount').eq(index).focus();
        }
    });


    $(document).on('click', '#dosplit', function(e) {
        //alert("I am clicked");

        var productsLines = new Array();
        $('input:checkbox:checked').each(function() {
            productsLines.push({
                'back': parseFloat($(this).closest('tr').find('.back').val()).toFixed(2),
                'code': $(this).closest('tr').find('.theProductCode').val(),
                'ordered': parseFloat($(this).closest('tr').find('.ordered').val()).toFixed(2),
                'orderdetailid': $(this).closest('tr').find('.orderdetailid').val()
            });

            //ajax

        });

        $.ajax({
            url: '{!! url('/createbackorderonsplit') !!}',
            type: "POST",
            data: {
                productsLines: productsLines,
                orderid: $('#orderId').val()
            },
            success: function(data) {
                location.reload();
            }
        });
    });
    //cancelsplit
    $(document).on('click', '#cancelsplit', function(e) {
        $('#splitOrder').dialog('close');
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
        var prodQtyClosest = closesttr.find(".prodQty_").val();
        var prodPriceClosest = closesttr.find(".prodPrice_").val();
        if (code == 34 && $.trim(prodClosest.length) > 0 && prodDescClosest.length > 0 && prodQtyClosest
            .length > 0 && prodPriceClosest.length > 0) {
            console.debug("sales");
            var myRow = $('#table').find("tr").last();
            var prod = myRow.find(".theProductCode_").val();
            var prodDesc = myRow.find(".prodDescription_").val();
            var prodQty_ = myRow.find(".prodQty_").val();
            var prodPrice_ = myRow.find(".prodPrice_").val();
            var myRowId = $('#table').find("tr").last().attr("id");

            if (prod.length < 1 && prodDesc.length < 1 && prodQty_.length < 1 && prodPrice_.length < 1) {
                // $("#"+myRowId).remove();
                // generateALine2();
                var index = $('.inputs').index(this);
                myRow.find(".theProductCode_").focus();
            } else {
                generateALine2();
                var myRow2 = $('#table').find("tr").last();
                var prod2 = myRow.find(".theProductCode_").val();
                var myRowId2 = $('#table').find("tr").last().attr("id");
                myRow2.find(".theProductCode_").focus();
                // $('.lst').eq(index).focus();
            }


        }
        if (code == 40 && $(this).closest("tr").is(":last-child") && prodClosest.length > 0 && prodDescClosest
            .length > 0 && prodQtyClosest.length > 0 && prodPriceClosest.length > 0) {

            generateALine2();
        }



    });

    $(document).on('keydown', '.theProductCode_', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            var index = $('.inputs').index(this) + 1;
            $('.inputs').eq(index).focus();
        }
    });
    //
    $(document).on('keyup', '.prodBulk_', function(e) {
        var prodBulk = $(this).closest("tr").find(".prodBulk_").val();
        var bulkUnitCalc = $(this).closest("tr").find(".unitWeight").val();
        var strBulkUnit = $(this).closest("tr").find(".strBulkUnit").val();
        var prodComment_ = $(this).closest("tr").find(".prodComment_").val(prodBulk + ' ' + strBulkUnit);
        var qty = $(this).closest("tr").find(".prodQty_").val(parseFloat(prodBulk * bulkUnitCalc).toFixed(3));

    });
    $(document).on('change', '.col2', function() {
        var colid = $(this).attr("id");
        var warehouseId = $(this).val();
        var prodc = $(this).closest("tr").find(".theProductCode_").val();
        var $this = $(this);
        var id = colid.substring(4, colid.length)

        $.ajax({
            url: '{!! url('/warehouseProductStockLookUp') !!}',
            type: "POST",
            data: {
                warehouseid: warehouseId,
                prodCode: prodc
            },
            success: function(data) {
                //alert( id);
                $('#instockReadOnly_' + id).val(data[0].Available);
                //  $this.closest("tr").find(".instockReadOnly_").val(data.Available);
            }
        });
    });

    $(document).on('keydown', '.inputs', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        var $isAuth = $(this).closest("tr").find(".title").attr("id");
        var $price = $(this).closest("tr").find(".prodPrice_").val();
        var prodQty_ = $(this).closest("tr").find(".prodQty_").val();
        var costing = $(this).closest("tr").find(".costs").val();
        var taxCodes = $(this).closest("tr").find(".taxCodes").val();
        var lineDisc = $(this).closest("tr").find(".prodDisc_").val();
        var finalDisc = (100 - lineDisc) / 100;


        linetotal(prodQty_, $price, taxCodes, marginCalculator(costing, $price * finalDisc));
    });
    $(document).on('click', '.inputs', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        var $isAuth = $(this).closest("tr").find(".title").attr("id");
        var $price = $(this).closest("tr").find(".prodPrice_").val();
        var prodQty_ = $(this).closest("tr").find(".prodQty_").val();
        var costing = $(this).closest("tr").find(".costs").val();
        var taxCodes = $(this).closest("tr").find(".taxCodes").val();
        var lineDisc = $(this).closest("tr").find(".prodDisc_").val();
        var finalDisc = (100 - lineDisc) / 100;
        linetotal(prodQty_, $price, taxCodes, marginCalculator(costing, $price * finalDisc));
    });
    $(document).on('keydown', '.prodPrice_', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        var hiddenToken = '';
        var $isAuth = $(this).closest("tr").find(".title").attr("id");
        var $priceToken = $(this).closest("tr").find(".prodPrice_").attr("id");
        var productCode = $(this).closest("tr").find(".theProductCode_").val();
        var costing = $(this).closest("tr").find(".costs").val();
        var hiddenToken = $(this).closest("tr").find(".hiddenToken").val();
        $(this).closest('tr').find('.title').val('authorize');

        if ((key > 45 && key < 57) || (key > 95 && key < 106) || key == 8) {
            $('#' + $isAuth).val('PRICECHANGED');
            calculator();

        }
        if (key == 107 || key == 17) {
            console.debug('productCode' + productCode);
            $('#custLookUp').show();
            $("#custLookUp").dialog({
                height: 450,
                width: 600,
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

            $.ajax({
                url: '{!! url('/generalPriceCheckAndLastCost') !!}',
                type: "POST",
                data: {
                    productCode: productCode,
                    custCode: $('#inputCustAcc').val()
                },
                success: function(data) {

                    var trHTML = '';
                    var trHTMLSellingPrice = '';
                    $('#lastprice').val('');
                    $('#costOnCustomerOrangeForm').val('');
                    $('#customersellingPrice').empty();
                    if ((data.sellingPrice).length > 0) {
                        $('#lastprice').val(parseFloat(data.sellingPrice[0].Price, 2));
                        //customersellingPrice
                        $.each(data.sellingPrice, function(key, value) {
                            trHTMLSellingPrice +=
                                '<tr style="font-size: 10px;color:black"><td>' +
                                value.Price +
                                '</td><input type="hidden" class="hiddenToken" value="' +
                                hiddenToken + '" ><td><strong>' +
                                value.DeliveryDate + '</strong></td><td>' +
                                value.Margin +
                                '%</td></tr>';
                        });

                        $('#customersellingPrice').append(trHTMLSellingPrice);
                    }
                    $('#costOnCustomerOrangeForm').val(parseFloat(costing, 2));
                    $('#productSelectedForPriceListOrderForm').empty();
                    $('#customerDetailLookUp').empty();
                    $('#productSelectedForPriceListOrderForm').append(productCode);
                    $.each(data.pricelists, function(key, value) {
                        trHTML += '<tr style="font-size: 10px;color:black"><td>' +
                            value.PriceList + '</td><td><strong>' +
                            value.Price + '</strong></td><td>' +
                            '</tr>';
                    });

                    $('#customerDetailLookUp').append(trHTML);

                    //Double click the pricing thingy
                    $('#customersellingPrice').on('dblclick', 'tbody tr', function() {


                        var $this = $(this);
                        var row = $this.closest("tr");
                        var Price = row.find('td:eq(0)').text();
                        //var to = row.find('td:eq(0)').text();


                        $('#prodPrice_' + hiddenToken).val(Price);
                        $("#custLookUp").dialog('close');
                        hiddenToken = '';


                    });
                }
            });
            /* $('#customerDetailLookUp tbody').on('dblclick', 'tr', function (){
        alert("over here");
    });*/
        }
        $('#lastprice').on('click', function() {
            // $('#'+$priceToken).val($('#lastprice').val());
            $("#custLookUp").dialog('close');
        });
    });
    $(document).on('keydown', '.prodComment_', function(e) {
        //$(this).closest("tr").find(".prodComment_").val()
        $(this).prop('title', $(this).closest("tr").find(".prodComment_").val());
    });
    $(document).on('keydown', '.prodQty_', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);

        var qty = $(this).closest("tr").find(".prodQty_").val();
        var prices = $(this).closest("tr").find(".prodPrice_").val();
        var productCode = $(this).closest("tr").find(".theProductCode_").val();
        var instock = $(this).closest("tr").find(".instockReadOnly_").val();
        var linetotal = qty * prices;
        var cstock = instock - qty;
        $(this).closest("tr").find(".col6").val(linetotal.toFixed(2));
        $(this).closest("tr").find(".clcstock_").val(cstock.toFixed(2));
        if ((key > 45 && key < 57) || (key > 95 && key < 106) || key == 8) {
            calculator();
        }
        //extrasononrder
        if (key == 107) {
            console.debug('productCode' + productCode);
            $('#extrasononrder').show();
            $("#extrasononrder").dialog({
                // height: 450,
                width: 400,
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

            $.ajax({
                url: '{!! url('/getextracomunsforItems') !!}',
                type: "POST",
                data: {
                    productCode: productCode,
                    custCode: $('#inputCustAcc').val()
                },
                success: function(data) {
                    console.debug("Testing this this" + data);

                    $('#randomweightdescription').val(data[0].Description_2);
                    //$( "#extrasononrder" ).dialog('close');
                }
            });
            /* $('#customerDetailLookUp tbody').on('dblclick', 'tr', function (){
        alert("over here");
    });*/
        }

    });

    $(document).on('keydown', '.additionalcost_', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        var hiddenToken = '';
        var $isAuth = $(this).closest("tr").find(".title").attr("id");
        var $priceToken = $(this).closest("tr").find(".prodPrice_").attr("id");
        var productCode = $(this).closest("tr").find(".theProductCode_").val();
        var costing = $(this).closest("tr").find(".costs").val();
        var prodQty_ = $(this).closest("tr").find(".prodQty_").val();
        var hiddenToken = $(this).closest("tr").find(".hiddenToken").val();
        var $this = $(this).closest("tr");

        if ((key > 45 && key < 57) || (key > 95 && key < 106) || key == 8) {
            $('#' + $isAuth).val('PRICECHANGED');
            calculator();

        }
        if (key == 107) {
            //   console.debug('productCode' + productCode);
            $('#addcostdialog').show();
            $("#addcostdialog").dialog({
                height: 450,
                width: 600,
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
                    ,
                close: function() {
                    //functionality to clear data here
                    console.debug("closed");
                }
            });

            $.ajax({
                url: '{!! url('/associatedItem') !!}',
                type: "POST",
                data: {
                    productCode: productCode,
                    customerCode: $('#inputCustAcc').val(),
                    delDate: $('#inputDeliveryDate').val(),
                },
                success: function(data) {
                    console.debug(data);
                    var trHTML = '';
                    var trHTMLSellingPrice = '';
                    $('#additionalcost tbody').empty();
                    $.each(data, function(key, value) {
                        trHTMLSellingPrice += `
                            <tr>
                                <td>${value.itemcode}</td>
                                <td>${value.itemdescription}</td>
                                <td>${parseFloat(prodQty_)}</td>
                                <td>${value.Price}</td>
                                <td>${parseFloat(prodQty_ * value.Price)}</td>
                            </tr>
                        `;
                    });
                    $('#additionalcost tbody').append(trHTMLSellingPrice);
                }
            });
        }

        if (key == 13) {
            $.ajax({
                url: '{!! url('/associatedItem') !!}',
                type: "POST",
                data: {
                    productCode: productCode,
                    customerCode: $('#inputCustAcc').val(),
                    delDate: $('#inputDeliveryDate').val(),
                },
                success: function(data) {
                    console.log($isAuth);

                    if (!$.trim(data)) {
                        $this.find(".additionalcost_").val(0);
                    } else {
                        $this.find(".additionalcost_").val(parseFloat(prodQty_ * data[0].Price));
                    }

                }
            });
        }

    });


    $(document).on('keyup', '#posPayMentTypeCash', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        if ((key > 45 && key < 57) || (key > 95 && key < 106) || key == 8) {
            posCalculator();
        }
    });
    $(document).on('click', '#posPayMentTypeCash', function(e) {
        $('#posPayMentTypeCash').select();
    });
    $(document).on('click', '#posPayMentTypeAccount', function(e) {
        $('#posPayMentTypeAccount').select();
    });
    $(document).on('click', '#posPayMentTypeCreditCard', function(e) {
        $('#posPayMentTypeCreditCard').select();
    });
    $(document).on('click', '#posPayMentTypeCheque', function(e) {
        $('#posPayMentTypeCheque').select();
    });

    $(document).on('keyup', '#posPayMentTypeAccount', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        if ((key > 45 && key < 57) || (key > 95 && key < 106) || key == 8) {
            posCalculator();
        }
    });
    $(document).on('keyup', '#posPayMentTypeCreditCard', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        if ((key > 45 && key < 57) || (key > 95 && key < 106) || key == 8) {
            posCalculator();
        }
    });
    $(document).on('keyup', '#posPayMentTypeCheque', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        if ((key > 45 && key < 57) || (key > 95 && key < 106) || key == 8) {
            posCalculator();
        }
    });
    //
    $(document).on('keydown', '#inputDeliveryDate', function(e) {

        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            //alert("alert ....");
            if ($('#submitFilters').is(':visible')) {
                $('#submitFilters').focus();
            }

        }

    });
    $(document).on('click', '.prodQty_', function(e) {
        $(this).select();
    });
    /* $(document).on('keydown', '.calculator', function(e){
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {

        }
        return false;
        });*/
    $('#display').on('keyup keypress', function(e) {

    });

    $(document).on('keydown', '.prodQty_', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            var index = $('.inputs').index(this) + 1;
            $('.inputs').eq(index).focus();
        }
    });
    $(document).on('keyup keypress', '#display', function(e) {

        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            $('#equalOnCalculator').click();
            return false;
        }
    });

    $(document).on('click', '#pricelistLookUpOnForm', function() {
        var dataValue = $(this).data('value');
        var productCode = $('#prodCode_' + dataValue).val();
        console.debug('dataValue' + dataValue);
        console.debug('productCode' + productCode);
        $('#custLookUp').show();
        $("#custLookUp").dialog({
            height: 300,
            width: 400,
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

        $.ajax({
            url: '{!! url('/generalPriceChecking') !!}',
            type: "POST",
            data: {
                productCode: productCode
            },
            success: function(data) {

                var trHTML = '';
                $('#productSelectedForPriceListOrderForm').empty();
                $('#customerDetailLookUp').empty();
                $('#productSelectedForPriceListOrderForm').append(productCode);
                $.each(data, function(key, value) {
                    trHTML += '<tr style="font-size: 10px;color:black"><td>' +
                        value.PriceList + '</td><td><strong>' +
                        value.Price + '</strong></td><td>' +
                        '</tr>';
                });
                $('#customerDetailLookUp').append(trHTML);
            }
        });
        $('#customerDetailLookUp tbody').on('dblclick', 'tr', function() {
            alert("over here");
        });

    });



    /**
     * Log data into tblManagementConsole
     * @param url
     * @param ConsoleTypeId
     * @param Importance
     * @param Message
     * @param Reviewed
     * @param OrderId
     * @param productid
     * @param CustomerId
     * @param OldQty
     * @param NewQty
     * @param OldPrice
     * @param NewPrice
     * @param ReferenceNo
     * @param DocType
     *  @param machine
     * @param DocNumber
     * @param ReturnId
     */
    function consoleManagement(url, ConsoleTypeId, Importance, Message, Reviewed, OrderId, productid,
        CustomerId, OldQty, NewQty, OldPrice, NewPrice, ReferenceNo, DocType, machine, DocNumber, ReturnId) {
        $.ajax({
            url: url,
            type: "POST",
            data: {
                ConsoleTypeId: ConsoleTypeId,
                Importance: Importance,
                Message: Message,
                Reviewed: Reviewed,
                OrderId: OrderId,
                productid: productid,
                CustomerId: CustomerId,
                OldQty: OldQty,
                NewQty: NewQty,
                ReviewedUserId: 0,
                OldPrice: OldPrice,
                NewPrice: NewPrice,
                ReferenceNo: ReferenceNo,
                DocType: DocType,
                DocNumber: DocNumber,
                machine: machine,
                ReturnId: ReturnId,

            },
            success: function(data) {
                //dd(data);
                //Try to use web sql
            }
        });

    }

    function consoleManagementAuths(url, ConsoleTypeId, Importance, Message, Reviewed, OrderId, productid,
        CustomerId, OldQty, NewQty, OldPrice, NewPrice, ReferenceNo, DocType, machine, DocNumber, ReturnId, userId,
        userName) {
        $.ajax({
            url: url,
            type: "POST",
            data: {
                ConsoleTypeId: ConsoleTypeId,
                Importance: Importance,
                Message: Message,
                Reviewed: Reviewed,
                OrderId: OrderId,
                productid: productid,
                CustomerId: CustomerId,
                OldQty: OldQty,
                NewQty: NewQty,
                ReviewedUserId: 0,
                OldPrice: OldPrice,
                NewPrice: NewPrice,
                ReferenceNo: ReferenceNo,
                DocType: DocType,
                DocNumber: DocNumber,
                machine: machine,
                ReturnId: ReturnId,
                userId: userId,
                userName: userName,

            },
            success: function(data) {
                // dd(data);
                //Try to use web sql
            }
        });

    }
    $(document).on('click', '#doAuthcrLimit', function() {
        $('#userAuthPassWordcrLimit').val();
        $.ajax({
            url: '{!! url('/verifyAuth') !!}',
            type: "POST",
            data: {
                userName: $('#userAuthNamecrLimit').val(),
                userPassword: $('#userAuthPassWordcrLimit').val()
            },
            success: function(data) {
                //console.debug("bunch"+data);
                if ($.isEmptyObject(data)) {
                    alert("Wrong Credentials Please Try Again!");
                } else {
                    $('#userAuthNamecrLimit').val('');
                    $('#creditLimitApproved').val('true');
                    $('#userAuthPassWordcrLimit').val('');
                    consoleManagementAuths('{!! url('/logMessageAuth') !!}', 12, 1,
                        'Credit Limit on order Authorised by ' + data[0].UserName,
                        0, $('#orderId').val(), 0, $('#inputCustAcc').val(), 0, 0, 0, $(
                            '#userNewVariablecrLimit').val(), 'NULL', 0, computerName, 0, 0,
                        data[0].UserID, data[0].UserName);
                    $('#finishOrder').click();
                    $("#creditLimitAuth").dialog('close');
                }
            }
        });
    });

    function authReprints() {

        $('#userAuthPassWordcrLimit').val();
        $.ajax({
            url: '{!! url('/verifyAuth') !!}',
            type: "POST",
            data: {
                userName: $('#userAuthNameReprint').val(),
                userPassword: $('#userAuthPassWordReprint').val()
            },
            success: function(data) {
                //console.debug("bunch"+data);
                if ($.isEmptyObject(data)) {
                    alert("Wrong Credentials Please Try Again!");
                } else {
                    $('#userAuthNameReprint').val('');
                    $('#userAuthPassWordReprint').val('');
                    printDoc('{!! url('/intoTblPrintedDoc') !!}', 1, $('#orderId').val(), 0, $('#invoiceNo').val());
                    consoleManagement('{!! url('/logMessageAjax') !!}', 300, 1,
                        'Document has been send to the printer -Reprint', 0, $('#orderId').val(), 0, 0,
                        0, 0, 0, 0, $('#orederNumber').val(), 0, computerName, $('#orderId').val(), 0);

                    consoleManagementAuths('{!! url('/logMessageAuth') !!}', 12, 1, 'Re-Print Authorised by' +
                        data[0].UserName,
                        0, 0, 0, 0, 0, 0, 0, 0, 'NULL', 0, computerName, 0, 0, data[0].UserID, data[0]
                        .UserName);


                    $("#reprintAuth").dialog('close');
                    disableOnFinish();
                }
            }
        });

    }

    function authProhited(token_number) {
        $('#prohibitedProductAuth').show();
        //$('#prohibitedProductAuth').show();
        console.debug('prohibited/----' + token_number);
        $('#userAuthProhibited').val('');
        $('#userAuthPassWordProhibited').val('');
        showDialogWithoutClose('#prohibitedProductAuth', 600, 300);

        $('#doCancelAuthProhibited').off().click(function() {
            console.debug('#new_row_ajax' + token_number);
            $('#new_row_ajax' + token_number).remove();
            $('#prohibitedProductAuth').dialog('close');
            generateALine2();
        });
        $('#doAuthProhibited').click(function() {
            $.ajax({
                url: '{!! url('/verifyAuth') !!}',
                type: "POST",
                data: {
                    userName: $('#userAuthProhibited').val(),
                    userPassword: $('#userAuthPassWordProhibited').val()
                },
                success: function(data) {
                    //console.debug("bunch"+data);
                    if ($.isEmptyObject(data)) {
                        alert("Wrong Credentials Please Try Again!");
                    } else {

                        $('#userAuthProhibited').val('');
                        $('#userAuthPassWordProhibited').val('');
                        $('#prohibited_' + token_number).val('0');
                        console.debug('token_number--prohib' + token_number);

                        consoleManagement('{!! url('/logMessageAjax') !!}', 12, 1,
                            'Price Authorised on a prohibited Product ' + $('#prodCode_' +
                                token_number).val() + ' by ' + data[0].UserName, 0, $(
                                '#orderId').val(), 0, 0, 0, 0, 0, 0, $('#orderId').val(), 0,
                            computerName, $('#orderId').val(), 0);

                        $('#prohibitedProductAuth').dialog('close');

                    }
                }
            });

        });

    }

    function authNewDiscountPerc(message) {



    }

    /**
     * This is now a multipurpose function , authChangeOfOrderType needs to be authChanges but it was too late for me to change it Reginald---25/10/2017 at Robberg
     * @param orderTypeName
     * @param message
     */
    function authChangeOfOrderType(orderTypeName, message) {
        console.debug("orderTypeName---" + orderTypeName);
        $('#userAuthPassWordDropDown').val();
        $.ajax({
            url: '{!! url('/verifyAuth') !!}',
            type: "POST",
            data: {
                userName: $('#userAuthNameDropDown').val(),
                userPassword: $('#userAuthPassWordDropDown').val()
            },
            success: function(data) {
                //console.debug("bunch"+data);
                if ($.isEmptyObject(data)) {
                    alert("Wrong Credentials Please Try Again!");
                } else {

                    $('#userAuthNameDropDown').val('');
                    $('#userAuthPassWordDropDown').val('');

                    consoleManagement('{!! url('/logMessageAjax') !!}', 12, 1, message + orderTypeName + ' by ' +
                        data[0].UserName, 0, $('#orderId').val(), 0, 0, 0, 0, 0, 0, $('#orderId').val(),
                        0, computerName, $('#orderId').val(), 0);

                    $('#authDropDowns').dialog('close');

                }
            }
        });
    }

    function authFinishOrder() {
        $("#authDropDownsClosedRoutePass").dialog({
            height: 300,
            modal: true,
            width: 900,
            containment: false
        }).dialogExtend({
            "closable": false, // enable/disable close button
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

        $('#doCancelAuthDropDownClosedRoutePass').off().click(function() {

        });
        $('#doAuthDropDownClosedRoutePass').off().click(function() {
            $.ajax({
                url: '{!! url('/verifyAuth') !!}',
                type: "POST",
                data: {
                    userName: $('#userAuthClosedRoute').val(),
                    userPassword: $('#userAuthClosedRoutePass').val()
                },
                success: function(data) {
                    //console.debug("bunch"+data);
                    if ($.isEmptyObject(data)) {
                        alert(
                            "Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                    } else {

                        $('#authDropDownsClosedRoutePass').dialog('close');
                        finishThis();
                    }
                }
            });
        });

    }

    function linetotal(quantity, price, tax, margins) {
        var lineTotEx = parseFloat(quantity) * parseFloat(price);
        console.debug("*****************************" + parseFloat(lineTotEx * ((tax / 100) + 1)));
        var lineTotin = parseFloat(lineTotEx * ((tax / 100) + 1));
        $("#linemargins").val(parseFloat(margins).toFixed(2));
        $("#linetotalex").val(parseFloat(lineTotEx).toFixed(2));
        $("#linetotalInc").val(parseFloat(lineTotin).toFixed(2));

    }

    function authReprintsOnTabletLoading() {

        $('#userAuthPassWordcrLimit').val();
        $.ajax({
            url: '{!! url('/verifyAuth') !!}',
            type: "POST",
            data: {
                userName: $('#userAuthNameReprint').val(),
                userPassword: $('#userAuthPassWordReprint').val()
            },
            success: function(data) {
                //console.debug("bunch"+data);
                if ($.isEmptyObject(data)) {
                    alert("Wrong Credentials Please Try Again!");
                } else {
                    $('#userAuthNameReprint').val('');
                    $('#userAuthPassWordReprint').val('');
                    printDoc('{!! url('/intoTblPrintedDoc') !!}', 1, $('#reprintOrderIdFromTablet').val(), 0, $(
                        '#reprintInvoiceFromTablet').val());
                    consoleManagement('{!! url('/logMessageAjax') !!}', 300, 1,
                        'Document has been send to the printer -Reprint', 0, $(
                            '#reprintOrderIdFromTablet').val(), 0, 0, 0, 0, 0, 0, $(
                            '#reprintOrderIdFromTablet').val(), 0, computerName, $('#orderId').val(), 0);

                    consoleManagementAuths('{!! url('/logMessageAuth') !!}', 12, 1, 'Re-Print Authorised by' +
                        data[0].UserName,
                        0, 0, 0, 0, 0, 0, 0, 0, 'NULL', 0, computerName, 0, 0, data[0].UserID, data[0]
                        .UserName);


                    $("#reprintAuth").dialog('close');
                    $("#tabletLoadingDocDetails").dialog('close');
                    // disableOnFinish();
                }
            }
        });

    }

    function commonDialog() {
        $('#authorisations').show();
        $("#authorisations").dialog({
            height: 400,
            modal: true,
            width: 500,
            containment: false
        }).dialogExtend({
            "closable": false, // enable/disable close button
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
        $('#authorisations').keydown(function(event) {
            if (event.keyCode == 27) {
                return false;
            }
        });
    }

    function authPopup(tag, oldV, product, token, mess, isAuthprice, rowHiddenId, theActualOrderDetailID) {

        console.debug("***********************************************");
        //$('#userAuthName').
        $('#appendErrormsg').empty();
        $('#appendErrormsg').append(mess);

        $('#authorisations').show();

        $("#authorisations").dialog({
            height: 400,
            modal: true,
            closeOnEscape: false,
            width: 500,
            containment: false
        }).dialogExtend({
            "closable": false, // enable/disable close button
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

        console.debug(rowHiddenId);
        $('#authorisations').keydown(function(event) {
            if (event.keyCode == 27) {
                return false;
            }
        });
        $('#noThanksRedo').off().click(function() {

            console.debug('#new_row_ajax' + rowHiddenId);

            $('#authorisations').dialog('close');
            if (theActualOrderDetailID.length > 0) {
                console.debug('line id *********' + theActualOrderDetailID);
                var orderLineID = theActualOrderDetailID;
                $.ajax({
                    url: '{!! url('/deleteOrderDetails') !!}',
                    type: "POST",
                    data: {
                        OrderId: $('#orderId').val(),
                        OrderDetailId: orderLineID
                    },
                    success: function(data) {

                        if (data.deletedId != 'FAILED') {
                            if (($('#invoiceNo').val()).length < 1) {
                                $('#new_row_ajax' + rowHiddenId).remove();
                                calculator();
                                generateALine2();
                            }
                        } else {
                            // $('#table').on('click', 'button', function (e) {
                            var dialog = $(
                                '<p><strong style="color:red">Sorry something went wrong when deleting a line ,please try again</strong></p>'
                                ).dialog({
                                height: 200,
                                width: 700,
                                modal: true,
                                containment: false,
                                buttons: {
                                    "Okay": {
                                        text: "Okay",
                                        class: "btn btn-success btn-sm",
                                        click: function() {
                                            dialog.dialog('close');
                                        }
                                    }
                                }
                            });
                        }
                        calculator();

                    }
                });
            } else {
                $('#new_row_ajax' + rowHiddenId).remove();
                calculator();
                generateALine2();
            }
            //  generateALine2();
        });
        $('#doAuth').off().click(function() {
            // $('#userAuthName').val();
            console.debug($('#userAuthPassWord').val());
            $('#userAuthPassWord').val();
            $.ajax({
                url: '{!! url('/verifyAuthOnAdmin') !!}',
                type: "POST",
                data: {
                    userName: $('#userAuthName').val(),
                    userPassword: $('#userAuthPassWord').val(),
                    orderId: $('#orderId').val()
                },
                success: function(data) {
                    //console.debug("bunch"+data);
                    if ($.isEmptyObject(data)) {
                        alert(
                            "Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                    } else {
                        $('#userAuthName').val('');
                        $('#userAuthPassWord').val('');
                        $('#title_' + rowHiddenId).val('');
                        console.debug('///////////////////' + $('#title_' + rowHiddenId).val());
                        $('#' + isAuthprice).val('');
                        if (tag === "Price") {
                            console.debug('auth id' + isAuthprice);
                            console.debug('product===================' + product);
                            consoleManagementAuths('{!! url('/logMessageAuth') !!}', 12, 1,
                                'Product price has been changed by ' + data[0].UserName +
                                ' to ' + oldV,
                                0, $('#orderId').val(), product, $('#inputCustAcc').val(), 0, 0,
                                0, $('#userNewVariable').val(), $('#orderId').val(), 0,
                                computerName, $('#orderId').val(), 0, data[0].UserID, data[0]
                                .UserName);
                            $("#authorisations").dialog('close');
                            $('#' + token).val($('#userNewVariable').val());
                        }
                        if (tag == "Quantity") {
                            consoleManagement('{!! url('/logMessageAuth') !!}', 12, 1,
                                'Quantity has been changed', 0, $('#orderId').val(), product, $(
                                    '#inputCustAcc').val(), oldV, 0, 0, 0, 'NULL', 0,
                                computerName, 0, 0);
                        }

                    }
                }
            });

        });

        //disable the escape button

    }

    function authZeroPricing(rowHiddenId, theActualOrderDetailID, product) {

        $('#doCancelAuthZeroPrice').off().click(function() {

            $('#ZeroPrice').dialog('close');
            console.debug("***********************************theActualOrderDetailID" + theActualOrderDetailID);
            if (theActualOrderDetailID !== "undefined" || theActualOrderDetailID.length > 0) {
                var orderLineID = theActualOrderDetailID;
                $.ajax({
                    url: '{!! url('/deleteOrderDetails') !!}',
                    type: "POST",
                    data: {
                        OrderId: $('#orderId').val(),
                        OrderDetailId: orderLineID
                    },
                    success: function(data) {

                        if (data.deletedId != 'FAILED') {
                            if (($('#invoiceNo').val()).length < 3) {
                                $('#new_row_ajax' + rowHiddenId).remove();
                                calculator();
                                generateALine2();
                            }
                        } else {
                            // $('#table').on('click', 'button', function (e) {
                            var dialog = $(
                                '<p><strong style="color:red">Sorry something went wrong when deleting a line ,please try again</strong></p>'
                                ).dialog({
                                height: 200,
                                width: 700,
                                modal: true,
                                containment: false,
                                buttons: {
                                    "Okay": {
                                        text: "Okay",
                                        class: "btn btn-success btn-sm",
                                        click: function() {
                                            dialog.dialog('close');
                                        }
                                    }
                                }
                            });
                        }
                        calculator();

                    }
                });
            } else {
                $('#new_row_ajax' + rowHiddenId).remove();
                calculator();
                generateALine2();
            }
            //  generateALine2();
        });

        $('#doAuthZeroPrice').off().click(function() {
            $.ajax({
                url: '{!! url('/verifyAuthOnAdmin') !!}',
                type: "POST",
                data: {
                    userName: $('#userauthproductwithzeroprice').val(),
                    userPassword: $('#userAuthPassWordzeroprice').val(),
                    orderId: $('#orderId').val()
                },
                success: function(data) {

                    if ($.isEmptyObject(data)) {
                        alert(
                            "Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                    } else {
                        $('#userauthproductwithzeroprice').val('');
                        $('#userAuthPassWordzeroprice').val('');


                        consoleManagementAuths('{!! url('/logMessageAuth') !!}', 12, 1,
                            'zero pricing on a line item has been authorised by ' + data[0]
                            .UserName,
                            0, $('#orderId').val(), product, $('#inputCustAcc').val(), 0, 0, 0,
                            $('#userauthproductwithzeroprice').val(), $('#orderId').val(), 0,
                            computerName, $('#orderId').val(), 0, data[0].UserID, data[0]
                            .UserName);
                        $("#ZeroPrice").dialog('close');
                        //$('#'+token).val($('#userNewVariable').val());
                        $('#title_' + rowHiddenId).val("authorised");
                        $('#prodPrice_' + rowHiddenId).val('0');

                    }
                }
            });

        });
    }

    function authPopupQuantity(tag, oldV, product, token, mess, isAuthprice, rowHiddenId, theActualOrderDetailID) {

        //$('#userAuthName').
        $('#appendErrormsg').empty();
        $('#appendErrormsg').append(mess);

        $('#authorisations').show();
        $("#authorisations").dialog({
            height: 400,
            modal: true,
            width: 500,
            containment: false
        }).dialogExtend({
            "closable": false, // enable/disable close button
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
        console.debug(rowHiddenId);
        $('#noThanksRedo').off().click(function() {

            console.debug('#new_row_ajax' + rowHiddenId);

            $('#authorisations').dialog('close');
            if (theActualOrderDetailID.length > 0) {
                console.debug('line id *********' + theActualOrderDetailID);
                var orderLineID = theActualOrderDetailID;
                $.ajax({
                    url: '{!! url('/deleteOrderDetails') !!}',
                    type: "POST",
                    data: {
                        OrderId: $('#orderId').val(),
                        OrderDetailId: orderLineID
                    },
                    success: function(data) {

                        if (data.deletedId != 'FAILED') {
                            if (($('#invoiceNo').val()).length < 1) {
                                $('#new_row_ajax' + rowHiddenId).remove();
                                calculator();
                                generateALine2();
                            }
                        } else {
                            // $('#table').on('click', 'button', function (e) {
                            var dialog = $(
                                '<p><strong style="color:red">Sorry something went wrong when deleting a line ,please try again</strong></p>'
                                ).dialog({
                                height: 200,
                                width: 700,
                                modal: true,
                                containment: false,
                                buttons: {
                                    "Okay": {
                                        text: "Okay",
                                        class: "btn btn-success btn-sm",
                                        click: function() {
                                            dialog.dialog('close');
                                        }
                                    }
                                }
                            });
                        }
                        calculator();

                    }
                });
            } else {
                $('#new_row_ajax' + rowHiddenId).remove();
                calculator();
                generateALine2();
            }
            //  generateALine2();
        });
        $('#doAuth').off().click(function() {
            // $('#userAuthName').val();
            console.debug($('#userAuthPassWord').val());
            $('#userAuthPassWord').val();
            $.ajax({
                url: '{!! url('/verifyAuthOnAdmin') !!}',
                type: "POST",
                data: {
                    userName: $('#userAuthName').val(),
                    userPassword: $('#userAuthPassWord').val(),
                    orderId: $('#orderId').val()
                },
                success: function(data) {
                    //console.debug("bunch"+data);
                    if ($.isEmptyObject(data)) {
                        alert(
                            "Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                    } else {
                        $('#userAuthName').val('');
                        $('#userAuthPassWord').val('');
                        console.debug('tag' + tag);
                        $('#' + isAuthprice).val('');

                        consoleManagementAuths('{!! url('/logMessageAuth') !!}', 12, 1,
                            'Quantity has been Authorised by ' + data[0].UserName,
                            0, $('#orderId').val(), product, $('#inputCustAcc').val(), 0, 0,
                            oldV, $('#userNewVariable').val(), $('#orderId').val(), 0,
                            computerName, $('#orderId').val(), 0, data[0].UserID, data[0]
                            .UserName);
                        $("#authorisations").dialog('close');
                        $('#' + token).val($('#userNewVariable').val());
                        $('#title_' + rowHiddenId).val("authorised");

                    }
                }
            });

        });

    }

    function checkifhasmultiaddress() {

        $.ajax({
            url: '{!! url('/checkifhasmultiaddress') !!}',
            type: "POST",
            data: {
                account: $('#inputCustAcc').val()
            },
            success: function(data) {

                if (data[0].result == "SUCCESS") {


                }
            }
        });
        //        confirmmultideliveryaddressonfinish();

    }

    function disableOnFinish() {
        $.ajax({
            url: '{!! url('/clearorderlocksperorder') !!}',
            type: "POST",
            data: {
                OrderId: $('#orderId').val()
            },
            success: function(data) {
                location.reload(true);
                $('#orderId').val('');
                $('#address1').val('');
                $('#address2').val('');
                $('#address3').val('');
                $('#address4').val('');
                $('#address5').val('');
                $('#orederNumber').val('');
                $('#invoiceNo').val('');
                $('#generalRouteForNewDeliveryAddress').empty();
                $('#salesPerson').empty();
                $('#customerSelectedDelDate').val('');
                $('#inputCustAcc').val('');
                $('#inputCustName').val('');
                // $('#inputDeliveryDate').val('');
                // $('#inputOrderDate').val('');
                $(".fast_remove").empty();
                // $("#orderPatternIdTable").empty();
                $('.hidebody').hide();
                $('.itCanHide').show();
                $('#submitFilters').show();
                $("#inputDeliveryDate").prop("disabled", false);
                $("#changeDelvDate").prop("disabled", false);
                $("#changeDelvDate").prop("disabled", false);
                $("#inputCustName").prop("disabled", false);
                $("#inputCustAcc").prop("disabled", false);
                $("#orderId").prop("disabled", false);
                $("#inputOrderDate").prop("disabled", false);
            }
        });
    }

    function empties() {
        $('#orderId').val('');
        $('#address1').val('');
        $('#address2').val('');
        $('#address3').val('');
        $('#address4').val('');
        $('#address5').val('');
        $('#orederNumber').val('');
        $('#invoiceNo').val('');
        $('#generalRouteForNewDeliveryAddress').empty();
        $('#salesPerson').empty();
        $('#customerSelectedDelDate').val('');
        $('#inputCustAcc').val('');
        $('#inputCustName').val('');
        // $('#inputDeliveryDate').val('');
        // $('#inputOrderDate').val('');
        $(".fast_remove").empty();
        // $("#orderPatternIdTable").empty();
        $('.hidebody').hide();
        $('.itCanHide').show();
        $('#submitFilters').show();
        $("#inputDeliveryDate").prop("disabled", false);
        $("#changeDelvDate").prop("disabled", false);
        $("#changeDelvDate").prop("disabled", false);
        $("#inputCustName").prop("disabled", false);
        $("#inputCustAcc").prop("disabled", false);
        $("#orderId").prop("disabled", false);
        $("#inputOrderDate").prop("disabled", false);
    }

    function marginCalculator(cost, onCellVal) {
        return (1 - (cost / onCellVal)) * 100;
    }

    function checkIfOrderHasMultipleProducts(productCode, token_number) {
        console.log("array" + arrayProdCodesCheck);
        if ($.inArray(productCode, arrayProdCodesCheck) !== -1) {
            if (productSetting == 'False') {
                var dialog = $('<p><strong style="color:red">Sorry ' + productCode +
                    ' is already added on your order</strong></p>').dialog({
                    height: 200,
                    width: 700,
                    modal: true,
                    containment: false,
                    buttons: {
                        "Okay": {
                            text: "Okay",
                            class: "btn btn-success btn-sm",
                            click: function() {
                                dialog.dialog('close');
                            }
                        }
                    }
                });
            }

        }
    }

    $(document).on('keydown', '#table', function(e) {
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
                console.debug('$celltheProductCode_******** UP' + $celltheProductCode_);
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

    function showDialogWithoutClose(tag, width, height) {
        $(tag).dialog({
            height: height,
            modal: true,
            width: width,
            containment: false
        }).dialogExtend({
            "closable": false, // enable/disable close button
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
        $('#authorisations').keydown(function(event) {
            if (event.keyCode == 27) {
                return false;
            }
        });


    }

    function quickSearchOnCustomerPrioritisePastelCode(finalDataArray, tag) {
        var inputCustNamesOnDispatchAfterMinus = $(tag).flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            focusFirstResult: true,
            searchContain: true,

            visibleProperties: ["CustomerPastelCode", "StoreName"],
            searchIn: ["CustomerPastelCode", "StoreName"],
            data: finalDataArray
        });
        inputCustNamesOnDispatchAfterMinus.on('select:flexdatalist', function(event, data) {

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
                url: '{!! url('/topOrdersOfACustomer') !!}',
                type: "POST",
                data: {
                    custCode: data.CustomerPastelCode
                },
                success: function(data2) {
                    console.debug(data.CustomerPastelCode);
                    $('#custDescriptionListOfOrder').empty();
                    var toAppend = '<option value=""></option>';

                    $.each(data2, function(i, o) {
                        toAppend += '<option value="' + o.OrderId + '"><strong>' + o
                            .OrderId + '</strong>   ' + o.StoreName + '   ' + o.OrderDate +
                            '   ' + '   ' + o.DeliveryDate + '   <strong>' + o.Backorder +
                            '</strong></option>';
                    });
                    $('#custDescriptionListOfOrder').append(toAppend);
                }
            });

        });
    }

    function onChangeCustomerOnDispatchForm(tag) {
        $(tag).on("change", function() {
            var orderidChange = this.value;
            var dialog = $(
                '<p>This Order has not been printed yet,someone could still be working on it, do you want to proceed? </p>'
                ).dialog({
                height: 200,
                width: 700,
                modal: true,
                containment: false,
                buttons: {
                    Yes: {
                        text: "Yes",
                        class: "btn btn-success btn-sm",
                        click: function() {
                            orderLock('{!! url('/restFullOrderLock') !!}', orderidChange);
                            orderUnLock('{!! url('/clearAllLocksRestFull') !!}');
                            $('#inputCustName').val('');
                            $('#inputCustAcc').val('');
                            $('#awaitingStockOnDispatchOrPickingForm').val('');
                            $('#orderIds').val(orderidChange);
                            $('#DeliveryDate').val('');
                            $('#totalEx').val('');
                            $('#tot' +
                                '' +
                                '' +
                                '' +
                                'alInc').val('');
                            arrayOfCustomerInfo[0] = '';
                            arrayOfCustomerInfo[1] = '';
                            arrayOfCustomerInfo[2] = '';
                            //makeLines(orderidChange);
                            makeALineWithOrderID(orderidChange, '#tableDispatch tbody',
                                '{!! url('/onCheckOrderHeaderDetails') !!}', '{!! url('/contactDetailsOnOrder') !!}',
                                arrayOfCustomerInfo);
                            dialog.dialog('close');
                        }
                    },
                    No: {
                        text: "No",
                        class: "btn btn-primary btn-sm",
                        click: function() {
                            dialog.dialog('close');
                        }
                    }
                }
            });
        });
    }
    document.onkeydown = function(e) {
        if (e.keyCode === 116) {

            if (($('#orderId').val()).length > 2 && ($('#inputCustAcc').val()).length > 0 && ($('#inputCustName')
                    .val()).length > 0) {
                $('#finishOrder').click();
                return false;
            } else {
                return true;
            }
        }
    };

    function posCalculator() {
        $('#posChange').val('');
        if (($('#posPayMentTypeCash').val()).length < 1) {
            $('#posPayMentTypeCash').val(0);
        }
        if (($('#posPayMentTypeAccount').val()).length < 1) {
            $('#posPayMentTypeAccount').val(0);
        }
        if (($('#posPayMentTypeCreditCard').val()).length < 1) {
            $('#posPayMentTypeCreditCard').val(0);
        }
        if (($('#posPayMentTypeCheque').val()).length < 1) {
            $('#posPayMentTypeCheque').val(0);
        }
        $('#confirmOnPosDialog').show();
        var cash = ((parseFloat($('#posPayMentTypeCash').val())).toFixed(2));
        var accounts = ((parseFloat($('#posPayMentTypeAccount').val())).toFixed(2));
        var creditCard = ((parseFloat($('#posPayMentTypeCreditCard').val())).toFixed(2));
        var cheque = ((parseFloat($('#posPayMentTypeCheque').val())).toFixed(2));
        var totalTendered = (parseFloat(cash) + parseFloat(accounts) + parseFloat(creditCard) + parseFloat(cheque))
            .toFixed(2);
        $('#posTotalTendered').val(totalTendered);
        if (($('#posPayMentTypeCash').val()).lenght > 0) {
            $('#posCashTendered').val(parseFloat($('#posPayMentTypeCash').val()));
        } else {
            $('#posCashTendered').val(parseFloat($('#posPayMentTypeCash').val()));
        }
        var noChangeOnOtherPaymentMethods = (parseFloat(accounts) + parseFloat(creditCard) + parseFloat(cheque))
            .toFixed(2);


        if (noChangeOnOtherPaymentMethods >= parseFloat($('#posInvTotal').val())) {
            console.debug("noChangeOnOtherPaymentMethods" + noChangeOnOtherPaymentMethods);
            $('#posChange').val(cash);

        } else {
            var change = (totalTendered - parseFloat($('#posInvTotal').val())).toFixed(2);
            $('#posChange').val(change);
        }



    }

    function waitingInvoice() {
        //
        $.ajax({
            url: '{!! url('/waitingForInvoiceNo') !!}',
            type: "POST",
            data: {
                orderID: $('#orderId').val(),
                customerCode: $('#inputCustAcc').val(),
                TotalTendered: $('#posTotalTendered').val(),
                Change: $('#posChange').val(),
                AmountToPost: $('#posCashTendered').val(),
                posPayMentTypeCash: $('#posPayMentTypeCash').val(),
                posPayMentTypeAccount: $('#posPayMentTypeAccount').val(),
                posPayMentTypeCreditCard: $('#posPayMentTypeCreditCard').val(),
                posPayMentTypeCheque: $('#posPayMentTypeCheque').val(),
                invoiceTotal: $('#totalInc').val()
            },
            success: function(data) {
                console.debug(data);
                if (data != 'False') {
                    disableOnFinish();
                }
            }
        });
    }

    function upDateOrderHeaderAndPOS() {

        $.ajax({
            url: '{!! url('/updateOrderHeader') !!}',
            type: "POST",
            data: {
                orderDate: $('#inputOrderDate').val(),
                orderId: $('#orderId').val(),
                deliveryDate: $("#inputDeliveryDate").val(),
                routeId: $('#routeName').val(),
                OrderType: $('#orderType').val(),
                orderNo: $('#orederNumber').val(),
                messagebox: $('#messagebox').val(),
                awaitingStock: $('#awaitingStock').val(),
                customerCode: $('#inputCustAcc').val(),
                DeliveryAddressID: $('#hiddenDeliveryAddressId').val(),
                address1hidden: $('#address1hidden').val(),
                address2hidden: $('#address2hidden').val(),
                address3hidden: $('#address3hidden').val(),
                address4hidden: $('#address4hidden').val(),
                address5hidden: $('#address5hidden').val(),
                discount: $('#dicPercHeader').val()
            },
            success: function(data) {

                //Point of sale change the route to collection
                $.ajax({
                    url: '{!! url('/updatePosRoute') !!}',
                    type: "GET",
                    data: {
                        orderId: $('#orderId').val()
                    },
                    success: function(data2) {
                        PosDialog();
                    }
                });
            }
        });
    }

    function configFilter($this, colArray) {
        setTimeout(function() {
            var tableName = $this[0].id;
            var columns = $this.api().columns();
            $.each(colArray, function(i, arg) {
                $('#' + tableName + ' th:eq(' + arg + ')').append(
                    '<img src="http://www.icone-png.com/png/39/38556.png" class="filterIcon" onclick="showFilter(event,\'' +
                    tableName + '_' + arg + '\')" />');
            });

            var template = '<div class="modalFilter">' +
                '<div class="modal-content">' +
                '{0}</div>' +
                '<div class="modal-footer">' +
                '<a href="#!" onclick="clearFilter(this, {1}, \'{2}\');"  class=" btn left waves-effect waves-light">Clear</a>' +
                '<a href="#!" onclick="performFilter(this, {1}, \'{2}\');"  class=" btn right waves-effect waves-light">Ok</a>' +
                '</div>' +
                '</div>';
            $.each(colArray, function(index, value) {
                columns.every(function(i) {
                    if (value === i) {
                        var column = this,
                            content =
                            '<input type="text" class="filterSearchText" onkeyup="filterValues(this)" /> <br/>';
                        var columnName = $(this.header()).text().replace(/\s+/g, "_");
                        var distinctArray = [];
                        column.data().each(function(d, j) {
                            if (distinctArray.indexOf(d) == -1) {
                                var id = tableName + "_" + columnName + "_" +
                                j; // onchange="formatValues(this,' + value + ');
                                content += '<div><input type="checkbox" value="' + d +
                                    '"  id="' + id + '"/><label for="' + id + '"> ' +
                                    d + '</label></div>';
                                distinctArray.push(d);
                            }
                        });
                        var newTemplate = $(template.replace('{0}', content).replace('{1}',
                                value).replace('{1}', value).replace('{2}', tableName)
                            .replace('{2}', tableName));
                        $('body').append(newTemplate);
                        modalFilterArray[tableName + "_" + value] = newTemplate;
                        content = '';
                    }
                });
            });
        }, 50);
    }
    var modalFilterArray = {};
    //User to show the filter modal
    function showFilter(e, index) {
        $('.modalFilter').hide();
        $(modalFilterArray[index]).css({
            left: 0,
            top: 0
        });
        var th = $(e.target).parent();
        var pos = th.offset();
        console.log(th);
        $(modalFilterArray[index]).width(th.width() * 0.75);
        $(modalFilterArray[index]).css({
            'left': pos.left,
            'top': pos.top
        });
        $(modalFilterArray[index]).show();
        $('#mask').show();
        e.stopPropagation();
    }

    //This function is to use the searchbox to filter the checkbox
    function filterValues(node) {
        var searchString = $(node).val().toUpperCase().trim();
        var rootNode = $(node).parent();
        if (searchString == '') {
            rootNode.find('div').show();
        } else {
            rootNode.find("div").hide();
            rootNode.find("div:contains('" + searchString + "')").show();
        }
    }

    //Execute the filter on the table for a given column
    function performFilter(node, i, tableId) {
        var rootNode = $(node).parent().parent();
        var searchString = '',
            counter = 0;

        rootNode.find('input:checkbox').each(function(index, checkbox) {
            if (checkbox.checked) {
                searchString += (counter == 0) ? checkbox.value : '|' + checkbox.value;
                counter++;
            }
        });
        $('#' + tableId).DataTable().column(i).search(
            searchString,
            true, false
        ).draw();
        rootNode.hide();
        $('#mask').hide();
    }

    //Removes the filter from the table for a given column
    function clearFilter(node, i, tableId) {
        var rootNode = $(node).parent().parent();
        rootNode.find(".filterSearchText").val('');
        rootNode.find('input:checkbox').each(function(index, checkbox) {
            checkbox.checked = false;
            $(checkbox).parent().show();
        });
        $('#' + tableId).DataTable().column(i).search(
            '',
            true, false
        ).draw();
        rootNode.hide();
        $('#mask').hide();
    }

    function PosDialog() {
        console.debug("I am inside POS");
        $('#pointOfSaleDialog').show();
        showDialog('#pointOfSaleDialog', 910, 400);
        calculator();
        var discount = (parseFloat($('#totalInc').val() * ($('#hiddenCustDiscount').val() / 100)).toFixed(2));
        console.debug("*****************" + discount);

        var totalToBeInvoiced = (parseFloat($('#totalInc').val()) - parseFloat(discount)).toFixed(2);
        $('#posOrdernumber').val($('#orderId').val());
        $('#posInvTotal').val($('#totalInc').val());
        $('#confirmOnPosDialog').click(function() {

            if (parseFloat($('#posChange').val()).toFixed(2) < 0) {

                var dialog = $(
                    '<p><strong style="color:black">sorry the invoice will not print,Please check your change</strong></p>'
                    ).dialog({
                    height: 200,
                    width: 700,
                    modal: true,
                    containment: false,
                    buttons: {
                        "Okay": {
                            text: "Okay",
                            class: "btn btn-success btn-sm",
                            click: function() {
                                dialog.dialog('close');
                            }
                        },
                        "Cancel": {
                            text: "Cancel",
                            class: "btn btn-primary btn-sm",
                            click: function() {
                                dialog.dialog('close');
                            }
                        }
                    }
                });
            } else { //$('#orderId').val()
                consoleManagement('{!! url('/logMessageAjax') !!}', 600, 3, 'POS Confirm Btn ,TotTendered: ' + $(
                        '#posTotalTendered').val() + ' Inv: ' + $('#totalInc').val(), 0, 0, 0, 0, 0, 0, 0,
                    0, $('#orederNumber').val(), 0, computerName, $('#orderId').val(), 0);
                $('#processingpos').show();


                waitingInvoice();
                setInterval(waitingInvoice, 9000);
            }

        });
    }

    function treatAsQuote(val) {

        $.ajax({
            url: '{!! url('/treatAsQuote') !!}',
            type: "POST",
            data: {
                isQuote: val,
                orderId: $('#orderId').val(),

            },
            success: function(data) {
                console.debug("data saved");
            }
        });
    }

    function isAwaitingStock(val) {

        $.ajax({
            url: '{!! url('/markitawaitingstock') !!}',
            type: "POST",
            data: {
                isQuote: val,
                orderId: $('#orderId').val(),

            },
            success: function(data) {
                console.debug("data saved awaiting stock");
            }
        });
    }

    function allInoneDocumentsave(type) {
        //console.debug("unsafe"+escapeHtml("this j& sb"));
        var dialog = $('<p><strong style="color:black">PLEASE WAIT...</strong></p>').dialog({
            height: 200,
            width: 700,
            modal: true,
            containment: false,
            buttons: {
                "Okay": {
                    text: "Okay",
                    class: "btn btn-success btn-sm",
                    click: function() {
                        dialog.dialog('close');
                    }
                }
            }
        });
        var orderlines = new Array();
        var orderheaders = new Array();
        $('#table > tbody  > tr').each(function() {
            var data = $(this);

            var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
            var comment = $(this).closest('tr').find('.prodComment_').val();
            //comment = comment.replace("'","");
            console.debug($(this).closest('tr').find('.col2').val());
            if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                orderlines.push({
                    'productCode': escapeHtml($(this).closest('tr').find('.theProductCode_').val()),
                    'qty': $(this).closest('tr').find('.prodQty_').val(),
                    'price': $(this).closest('tr').find('.prodPrice_').val(),
                    'comment': escapeHtml(comment),
                    'orderDetailID': orderDetailID,
                    'customerCode': escapeHtml($('#inputCustAcc').val()),
                    'prodDisc': $(this).closest('tr').find('.prodDisc_').val(),
                    'OrderId': $('#orderId').val(),
                    'hiddenToken': $(this).closest('tr').find('.hiddenToken').val(),
                    'prodBulk': $(this).closest('tr').find('.prodBulk_').val(),
                    'warehouse': $(this).closest('tr').find('.col2').val()
                });


            }

        });


        orderheaders.push({
            'orderDate': dateReturn($("#inputOrderDate").val()),
            'orderId': $('#orderId').val(),
            'deliveryDate': dateReturn($("#inputDeliveryDate").val()),
            'OrderType': $('#orderType').val(),
            'notification': $('#notification').val(),
            'orderNo': (escapeHtml($('#orederNumber').val())),
            'messagebox': (escapeHtml($('#messagebox').val())),
            'awaitingStock': $('#awaitingStock').val(),
            'customerCode': escapeHtml($('#inputCustAcc').val()),
            'DeliveryAddressID': $('#hiddenDeliveryAddressId').val(),
            'address1hidden': (escapeHtml($('#address1hidden').val())),
            'address2hidden': (escapeHtml($('#address2hidden').val())),
            'address3hidden': (escapeHtml($('#address3hidden').val())),
            'address4hidden': (escapeHtml($('#address4hidden').val())),
            'address5hidden': (escapeHtml($('#address5hidden').val())),
            'headerWh': $('#headerWh').val(),
            'savetype': type

        });

        console.debug(orderlines);
        console.debug(orderheaders);
        $.ajax({
            url: '{!! url('/orderheaderAndOrderLines') !!}',
            type: "POST",
            data: {
                OrderId: $('#orderId').val(),
                orderheaders: orderheaders,
                orderlines: orderlines,
                type: type
            },
            success: function(data) {
                console.debug("really-***********************************");
                console.debug(data);
                if ((data.result).indexOf("CUSTOMER_ON_HOLD") >= 0) {
                    authoriseonholdaccount();

                } else {

                    if (type == "POS" && data.result == "SUCCESS") {
                        console.debug("I am inside POS");
                        $('#pointOfSaleDialog').show();
                        showDialog('#pointOfSaleDialog', 910, 400);
                        calculator();
                        var discount = (parseFloat($('#totalInc').val() * ($('#hiddenCustDiscount').val() /
                            100)).toFixed(2));


                        var totalToBeInvoiced = (parseFloat($('#totalInc').val()) - parseFloat(discount))
                            .toFixed(2);
                        $('#posOrdernumber').val($('#orderId').val());
                        $('#posInvTotal').val($('#totalInc').val());
                        $('#confirmOnPosDialog').click(function() {


                            if (parseFloat($('#posChange').val()).toFixed(2) < 0) {

                                var dialog = $(
                                    '<p><strong style="color:black">sorry the invoice will not print,Please check your change</strong></p>'
                                    ).dialog({
                                    height: 200,
                                    width: 700,
                                    modal: true,
                                    containment: false,
                                    buttons: {
                                        "Okay": {
                                            text: "Okay",
                                            class: "btn btn-success btn-sm",
                                            click: function() {
                                                dialog.dialog('close');
                                            }
                                        },
                                        "Cancel": {
                                            text: "Cancel",
                                            class: "btn btn-primary btn-sm",
                                            click: function() {
                                                dialog.dialog('close');
                                            }
                                        }
                                    }
                                });
                            } else { //$('#orderId').val()
                                $.ajax({
                                    url: '{!! url('/AssignInvoiceNumber') !!}',
                                    type: "POST",
                                    data: {
                                        orderID: $('#orderId').val()
                                    },
                                    success: function(data) {
                                        console.debug(
                                            "******************************************************" +
                                            data);
                                        monitorInvoiced();
                                    }
                                });
                                //alert("pos clicked");

                                var dialog = $(
                                    '<p><strong style="color:black">Please Wait, Do not touch anything we are watching you...</strong></p>'
                                    ).dialog({
                                    height: 200,
                                    width: 700,
                                    modal: true,
                                    containment: false,
                                    buttons: {
                                        "Okay": {
                                            text: "Okay",
                                            class: "btn btn-success btn-sm",
                                            click: function() {
                                                dialog.dialog('close');
                                            }
                                        },

                                    }
                                });
                            }
                        });

                    } else {
                        var dialog = $('<p><strong style="color:black">' + data.result +
                            '<br><i style="color:red;font-weight:900">' + data.Extras +
                            '<i></strong></p>').dialog({
                            height: 200,
                            width: 700,
                            modal: true,
                            containment: false,
                            buttons: {
                                "Okay": {
                                    text: "Okay",
                                    class: "btn btn-success btn-sm",
                                    click: function() {
                                        dialog.dialog('close');
                                    }
                                },
                            }
                        });
                    }

                    console.debug("YES OR NO BEFORE*************" + type);
                    if (type == "NO" || type == "YES") {

                        console.debug(data.result);
                        console.debug("YES OR NO");
                        console.debug(data.Error);
                        if (data.Error != "ALREADY INVOICED") {


                            if (data.result != "SUCCESS" && data.result != "Success") {
                                var dialog = $('<p><strong style="color:black">' + data.result +
                                    '</strong></p>').dialog({
                                    height: 200,
                                    width: 700,
                                    modal: true,
                                    containment: false,
                                    buttons: {
                                        "Okay": {
                                            text: "Okay",
                                            class: "btn btn-success btn-sm",
                                            click: function() {
                                                dialog.dialog('close');
                                            }
                                        },
                                    }
                                });
                            } else {
                                // console.debug("yes or no*************"+checkifhasmultiaddress());
                                //   checkifhasmultiaddress();
                                console.debug("check point ismulti***" + ismulti);
                                $.ajax({
                                    url: '{!! url('/checkifhasmultiaddress') !!}',
                                    type: "POST",
                                    data: {
                                        account: $('#inputCustAcc').val()
                                    },
                                    success: function(data) {

                                        if (data[0].result == "SUCCESS") {
                                            confirmmultideliveryaddressonfinish()

                                        } else {
                                            if (hassplitorder == "LTRUE") {
                                                splitorder();
                                            } else {
                                                disableOnFinish();
                                            }
                                        }
                                    }
                                });

                            }
                        } else {
                            var dialog = $(
                                '<p><strong style="color:black">This order has been invoiced, staged or loaded.</strong></p>'
                                ).dialog({
                                height: 200,
                                width: 700,
                                modal: true,
                                containment: false,
                                buttons: {
                                    "Okay": {
                                        text: "Okay",
                                        class: "btn btn-success btn-sm",
                                        click: function() {
                                            disableOnFinish();
                                        }
                                    },

                                }
                            });
                        }
                    }

                    console.debug("YES OR NO AFTER*************");
                    if (type == "PDF") {
                        console.debug(data.result);
                        if (data.result != "SUCCESS" && data.result != "Success") {
                            var dialog = $('<p><strong style="color:black">' + data.result +
                                '</strong></p>').dialog({
                                height: 200,
                                width: 700,
                                modal: true,
                                containment: false,
                                buttons: {
                                    "Okay": {
                                        text: "Okay",
                                        class: "btn btn-success btn-sm",
                                        click: function() {
                                            dialog.dialog('close');
                                        }
                                    },
                                }
                            });
                        } else {
                            window.open('{!! url('/pdforder') !!}/' + $('#orderId').val(), "PDF",
                                "location=1,status=1,scrollbars=1, width=1200,height=850");
                            disableOnFinish();
                        }
                    }
                    if (type == "AUTHED") {
                        console.debug(data.result);
                        if (data.result != "SUCCESS" && data.result != "Success") {
                            var dialog = $('<p><strong style="color:black">' + data.result +
                                '</strong></p>').dialog({
                                height: 200,
                                width: 700,
                                modal: true,
                                containment: false,
                                buttons: {
                                    "Okay": {
                                        text: "Okay",
                                        class: "btn btn-success btn-sm",
                                        click: function() {
                                            dialog.dialog('close');
                                        }
                                    },
                                }
                            });
                        } else {
                            $.ajax({
                                url: '{!! url('/updateallOrderlinestocostauth') !!}',
                                type: "POST",
                                data: {
                                    orderId: $('#orderId').val(),

                                },
                                success: function(data) {

                                    $.ajax({
                                        url: '{!! url('/checkifhasmultiaddress') !!}',
                                        type: "POST",
                                        data: {
                                            account: $('#inputCustAcc').val()
                                        },
                                        success: function(data) {

                                            if (data[0].result == "SUCCESS") {
                                                confirmmultideliveryaddressonfinish
                                                ()

                                            } else {
                                                if (hassplitorder == "LTRUE") {
                                                    splitorder();
                                                } else {
                                                    disableOnFinish();
                                                }
                                            }
                                        }
                                    });



                                }
                            });


                        }
                    }
                    if (type == "INVOICEIT") {

                        console.debug(data.result);
                        if (data.result != "SUCCESS") {
                            var dialog = $('<p><strong style="color:black">' + data.result +
                                '</strong></p>').dialog({
                                height: 200,
                                width: 700,
                                modal: true,
                                containment: false,
                                buttons: {
                                    "Okay": {
                                        text: "Okay",
                                        class: "btn btn-success btn-sm",
                                        click: function() {
                                            dialog.dialog('close');
                                        }
                                    },
                                }
                            });
                        } else {

                            $.ajax({
                                url: '{!! url('/invoicedoc') !!}',
                                type: "POST",
                                data: {
                                    OrderId: $('#orderId').val()
                                },
                                success: function(data) {
                                    disableOnFinish();
                                }
                            });
                        }

                    }
                    //INVOICEIT
                }



            }
        });

    }

    function authoriseonholdaccount() {
        $('#authonholdaccount').show();

        $("#authonholdaccount").dialog({
            height: 350,
            modal: true,
            closeOnEscape: false,
            width: 800,
            containment: false
        }).dialogExtend({
            "closable": false, // enable/disable close button
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

        $('#authonholdaccount').keydown(function(event) {
            if (event.keyCode == 27) {
                return false;
            }
        });
        $('#treattheauthaccountasquotation').off().click(function() {

            $('#authonholdaccount').dialog('close');
            treatAsQuote(1);
            $('#treatAsQuote').prop('checked', true);
            allInoneDocumentsave("NO");


        });
        $('#doAuthZeroonholdaccount').off().click(function() {

            $('#onholdaccountmanagerpassword').val();
            $.ajax({
                url: '{!! url('/verifyAuthCreditors') !!}',
                type: "POST",
                data: {
                    userName: $('#onholdaccountmanagername').val(),
                    userPassword: $('#onholdaccountmanagerpassword').val(),
                    OrderId: $('#orderId').val()
                },
                success: function(data) {

                    if (data.done == "DONE") {

                        $('#onholdaccountmanagername').val('');
                        $('#onholdaccountmanagerpassword').val('');

                        consoleManagementAuths('{!! url('/logMessageAjax') !!}', 12, 1,
                            'Account on hold authorised by ' + data.result[0].UserName,
                            0, $('#orderId').val(), 0, $('#inputCustAcc').val(), 0, 0, 0, $(
                                '#onholdaccountmanagername').val(), $('#orderId').val(), 0,
                            computerName, $('#orderId').val(), 0, data.result[0].UserID, data
                            .result[0].UserName);
                        $("#authonholdaccount").dialog('close');
                        allInoneDocumentsave("NO");


                    } else {
                        alert("SOMETHING WENT WRONG,PLEASE TRY AGAIN ");
                    }
                }
            });

        });

    }

    function authorZeroCostOnSaving(data) {
        var trHTML = '';

        $('#productwithzerocost').empty();
        $('#productwithzerocost').show();
        $.each(data, function(key, value) {
            trHTML +=
                '<tr style="background: lightgrey;" >' +
                '<td style="">' + value.PastelCode + '</td>' +
                '<td style="">' + value.PastelDescription + '</td>' +

                '</tr>';

        });

        $('#productwithzerocost').append(trHTML);
        $('#authItemsWithzerocosts').show();

        $("#authItemsWithzerocosts").dialog({
            height: 800,
            modal: true,
            closeOnEscape: false,
            width: 800,
            containment: false
        }).dialogExtend({
            "closable": false, // enable/disable close button
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

        $('#authItemsWithzerocosts').keydown(function(event) {
            if (event.keyCode == 27) {
                return false;
            }
        });
        $('#cancelzerocostdialod').off().click(function() {

            $('#authItemsWithzerocosts').dialog('close');

        });
        $('#doAuthZerocost').off().click(function() {

            $('#zerocostmanagerpassword').val();
            $.ajax({
                url: '{!! url('/AuthBulkZeroCost') !!}',
                type: "POST",
                data: {
                    userName: $('#zerocostmanagername').val(),
                    userPassword: $('#zerocostmanagerpassword').val(),
                    OrderId: $('#orderId').val()
                },
                success: function(data) {

                    if (data.done == "DONE") {

                        $('#zerocostmanagername').val('');
                        $('#zerocostmanagerpassword').val('');

                        consoleManagementAuths('{!! url('/logMessageAjax') !!}', 12, 1,
                            'Zero Cost On Bulk Authorization authorized by ' + data.result[0]
                            .UserName,
                            0, $('#orderId').val(), 0, $('#inputCustAcc').val(), 0, 0, 0, $(
                                '#zerocostmanagername').val(), $('#orderId').val(), 0,
                            computerName, $('#orderId').val(), 0, data.result[0].UserID, data
                            .result[0].UserName);
                        $("#authItemsWithzerocosts").dialog('close');
                        allInoneDocumentsave("AUTHED");


                    } else {
                        alert("SOMETHING WENT WRONG,PLEASE TRY AGAIN ");
                    }
                }
            });

        });

    }

    function splitorder() {

        $.ajax({
            url: '{!! url('/splitorders') !!}',
            type: "POST",
            data: {
                orderID: $('#orderId').val()
            },
            success: function(data) {

                if (data.length > 0) {
                    var trHTML = '';
                    $('#griditemoutofstock').empty();
                    $('#itemoutofstock').show(); //table
                    $("#itemoutofstock").dialog({
                        height: 800,
                        modal: true,
                        closeOnEscape: false,
                        width: 800,
                        containment: false
                    }).dialogExtend({
                        "closable": false, // enable/disable close button
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
                    $.each(data, function(key, value) {
                        trHTML +=
                            '<tr style="font-size: 13px !important;color: black;background: lightgrey;font-weight: normal" >' +
                            '<td style="">' + value.strPastelCustomerCode + '</td>' +
                            '<td style="font-size: 13px !important;">' + value
                            .strPastelDescription + '</td>' +
                            '<td style="">' + value.dblQtyOrdered + '</td>' +
                            '<td style="">' + value.dblQtyAvailable + '</td>' +
                            '<td style="">' + value.dblQtyOnHand + '</td>' +
                            '<td style=""><input type="number" class="quantitynew" min="0" max="' +
                            value.dblQty + '"  value="' + value.dblQty + '"</td>' +
                            '<td style=""><input type="checkbox" style="width:80px; height: 18px !important;" name="OrderDetailId" value="' +
                            value.OrderDetailId + '"> </td>' +
                            '</tr>';

                    });
                    $('#griditemoutofstock').append(trHTML);

                    $('#splitorder').click(function() {
                        var favorite = [];
                        $.each($("input[name='OrderDetailId']:checked"), function() {
                            var orderdedatilId = $(this).val();
                            favorite.push({
                                'qty': $(this).closest('tr').find('.quantitynew')
                                    .val(),
                                'orderdedatilId': orderdedatilId,
                            });

                        });
                        $.ajax({
                            url: '{!! url('/splitordersmake') !!}',
                            type: "POST",
                            data: {
                                backorder: favorite,
                                orderID: $('#orderId').val()
                            },
                            success: function(data) {
                                disableOnFinish();
                            }
                        });

                    });

                    $('#cancelsplitorder').click(function() {
                        $("#itemoutofstock").dialog('close');
                        disableOnFinish();
                    });
                } else {
                    disableOnFinish();
                }

            }
        });

    }

    function saveorderswithoutExtras() {

        var orderlines = new Array();
        var orderheaders = new Array();
        $('#table > tbody  > tr').each(function() {
            var data = $(this);

            var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
            var comment = $(this).closest('tr').find('.prodComment_').val();
            //comment = comment.replace("'","");
            console.debug($(this).closest('tr').find('.col2').val());
            if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                orderlines.push({
                    'productCode': escapeHtml($(this).closest('tr').find('.theProductCode_').val()),
                    'qty': $(this).closest('tr').find('.prodQty_').val(),
                    'price': $(this).closest('tr').find('.prodPrice_').val(),
                    'comment': escapeHtml(comment),
                    'orderDetailID': orderDetailID,
                    'customerCode': escapeHtml($('#inputCustAcc').val()),
                    'prodDisc': $(this).closest('tr').find('.prodDisc_').val(),
                    'OrderId': $('#orderId').val(),
                    'hiddenToken': $(this).closest('tr').find('.hiddenToken').val(),
                    'prodBulk': $(this).closest('tr').find('.prodBulk_').val(),
                    'warehouse': $(this).closest('tr').find('.col2').val()
                });


            }

        });


        orderheaders.push({
            'orderDate': dateReturn($("#inputOrderDate").val()),
            'orderId': $('#orderId').val(),
            'deliveryDate': dateReturn($("#inputDeliveryDate").val()),
            'OrderType': $('#orderType').val(),
            'notification': $('#notification').val(),
            'orderNo': (escapeHtml($('#orederNumber').val())),
            'messagebox': (escapeHtml($('#messagebox').val())),
            'awaitingStock': $('#awaitingStock').val(),
            'customerCode': escapeHtml($('#inputCustAcc').val()),
            'DeliveryAddressID': $('#hiddenDeliveryAddressId').val(),
            'address1hidden': (escapeHtml($('#address1hidden').val())),
            'address2hidden': (escapeHtml($('#address2hidden').val())),
            'address3hidden': (escapeHtml($('#address3hidden').val())),
            'address4hidden': (escapeHtml($('#address4hidden').val())),
            'address5hidden': (escapeHtml($('#address5hidden').val())),
            'headerWh': $('#headerWh').val(),
            'savetype': "YES"

        });

        console.debug(orderlines);
        console.debug(orderheaders);
        $.ajax({
            url: '{!! url('/orderheaderAndOrderLines') !!}',
            type: "POST",
            data: {
                OrderId: $('#orderId').val(),
                orderheaders: orderheaders,
                orderlines: orderlines,
                type: "YES"
            },
            success: function(data) {
                //data.result
                var rsult = data.result;
                if (rsult.toUpperCase() != "SUCCESS") {
                    var dialog = $('<p><strong style="color:black">' + data.result + '</strong></p>')
                        .dialog({
                            height: 200,
                            width: 700,
                            modal: true,
                            containment: false,
                            buttons: {
                                "Okay": {
                                    text: "Okay",
                                    class: "btn btn-success btn-sm",
                                    click: function() {
                                        dialog.dialog('close');
                                    }
                                },
                            }
                        });
                } else {

                    $('#table tbody').empty();
                    getLineDetailsOly()
                }
            }
        });
    }

    function saveorderswithoutExtrasPDF() {

        var orderlines = new Array();
        var orderheaders = new Array();
        $('#table > tbody  > tr').each(function() {
            var data = $(this);

            var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
            var comment = $(this).closest('tr').find('.prodComment_').val();
            //comment = comment.replace("'","");
            console.debug($(this).closest('tr').find('.col2').val());
            if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                orderlines.push({
                    'productCode': escapeHtml($(this).closest('tr').find('.theProductCode_').val()),
                    'qty': $(this).closest('tr').find('.prodQty_').val(),
                    'price': $(this).closest('tr').find('.prodPrice_').val(),
                    'comment': escapeHtml(comment),
                    'orderDetailID': orderDetailID,
                    'customerCode': escapeHtml($('#inputCustAcc').val()),
                    'prodDisc': $(this).closest('tr').find('.prodDisc_').val(),
                    'OrderId': $('#orderId').val(),
                    'hiddenToken': $(this).closest('tr').find('.hiddenToken').val(),
                    'prodBulk': $(this).closest('tr').find('.prodBulk_').val(),
                    'warehouse': $(this).closest('tr').find('.col2').val()
                });


            }

        });


        orderheaders.push({
            'orderDate': dateReturn($("#inputOrderDate").val()),
            'orderId': $('#orderId').val(),
            'deliveryDate': dateReturn($("#inputDeliveryDate").val()),
            'OrderType': $('#orderType').val(),
            'notification': $('#notification').val(),
            'orderNo': (escapeHtml($('#orederNumber').val())),
            'messagebox': (escapeHtml($('#messagebox').val())),
            'awaitingStock': $('#awaitingStock').val(),
            'customerCode': escapeHtml($('#inputCustAcc').val()),
            'DeliveryAddressID': $('#hiddenDeliveryAddressId').val(),
            'address1hidden': (escapeHtml($('#address1hidden').val())),
            'address2hidden': (escapeHtml($('#address2hidden').val())),
            'address3hidden': (escapeHtml($('#address3hidden').val())),
            'address4hidden': (escapeHtml($('#address4hidden').val())),
            'address5hidden': (escapeHtml($('#address5hidden').val())),
            'headerWh': $('#headerWh').val(),
            'savetype': "YES"

        });

        console.debug(orderlines);
        console.debug(orderheaders);
        $.ajax({
            url: '{!! url('/orderheaderAndOrderLines') !!}',
            type: "POST",
            data: {
                OrderId: $('#orderId').val(),
                orderheaders: orderheaders,
                orderlines: orderlines,
                type: "YES"
            },
            success: function(data) {
                //data.result
                var rsult = data.result;
                if (rsult.toUpperCase() != "SUCCESS") {
                    var dialog = $('<p><strong style="color:black">' + data.result + '</strong></p>')
                        .dialog({
                            height: 200,
                            width: 700,
                            modal: true,
                            containment: false,
                            buttons: {
                                "Okay": {
                                    text: "Okay",
                                    class: "btn btn-success btn-sm",
                                    click: function() {
                                        dialog.dialog('close');
                                    }
                                },
                            }
                        });
                } else {

                    $('#table tbody').empty();
                    getLineDetailsOlyPDF()
                }
            }
        });
    }
    // I need to start Utilizing this
    function getLineDetailsOly() {
        $.ajax({
            url: '{!! url('/onCheckOrderHeaderDetails') !!}',
            type: "POST",
            data: {
                orderId: $('#orderId').val()
            },
            success: function(dataDetails) {
                InvoiceTotalPriceExcl = 0;
                InvoiceTotalPriceInc = 0;
                $.each(dataDetails, function(keyDetails, valueDetails) {
                    var tokenId = new Date().valueOf();
                    var props = '';
                    console.debug("------------------------------------------------------" +
                        isAllowedToChangeInv);
                    if (($('#invoiceNo').val()).length > 2 && isAllowedToChangeInv != 1) {
                        props = "disabled";

                    }
                    console.debug("************************************ AUTMUTLIWAREHOUSE" +
                        multiLines);
                    if (($('#invoiceNo').val()).length > 2) {
                        $("#inputDeliveryDate").prop("disabled", true);
                        $("#inputOrderDate").prop("disabled", true);
                    }
                    if (multiLines == 1) {
                        var classAnonymouscols = "anonymouscols";
                    } else {
                        var classAnonymouscols = "anonymouscolsOff";
                    }
                    var $row = $(`
                        <tr id="new_row_ajax${tokenId}" class="fast_remove">
                            <td class="text-center">
                                <input type="hidden" id="title_${tokenId}" class="title" value="" />
                                <input type="hidden" id="theOrdersDetailsId" value="${valueDetails.OrderDetailId}" />
                                <input type="hidden" id ="taxCode${tokenId}" value="${valueDetails.Tax}" class="taxCodes" />
                                <input type="hidden" id ="cost_${tokenId}" value="${valueDetails.Cost}" class="costs" />
                                <input type="hidden" id ="inStock_${tokenId}" value="${valueDetails.QtyInStock}" class="inStock" style="color:blue !important" />
                                <input type="hidden" value ="${tokenId}" class="hiddenToken" />
                                <input type="hidden" id ="priceholder_${tokenId}" value="${(parseFloat(valueDetails.Price)).toFixed(2)}" class="priceholder" />
                                <input type="hidden" id ="alcohol_${tokenId}" value="" class="alcohol" />
                                <input type="hidden" id ="margin_${tokenId}" value="" class="margin" />
                                <input type="hidden" id ="soldByWieght${tokenId}" value="" class="soldByWieght" />
                                <input type="hidden" id ="unitWeight${tokenId}" value="" class="unitWeight" />
                                <input type="hidden" id ="strBulkUnit${tokenId}" value="" class="strBulkUnit" />
                                <input type="hidden" id ="prohibited_${tokenId}" value="" class="prohibited" />
                                <input type="hidden" id ="productmarginauth${tokenId}" value="1" class="productmarginauth" />
                                <button type="button" id="deleteaLine" value="${valueDetails.OrderDetailId}" class="getOrderDetailLine btn btn-icon btn-danger btn-sm btn-sm-icon">
                                    <i class="bi bi-trash3-fill fs-4"></i>
                                </button>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 100px;" name="theProductCode" id ="prodCode_${tokenId}" class="theProductCode_ set_autocomplete inputs form-control" value="${valueDetails.PastelCode}" ${props}>
                                <input name="col1" id="col1${tokenId}" class="col1 ${classAnonymouscols}" readonly>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 250px;" name="prodDescription_" id ="prodDescription_${tokenId}" class="prodDescription_ set_autocomplete inputs form-control" value="${valueDetails.PastelDescription}" ${props}>
                                <input name="col8" id ="col8${tokenId}" class="col8 ${classAnonymouscols}" readonly>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 65px;" type="text" name="prodBulk_"  id ="prodBulk_${tokenId}" class="prodBulk_ resize-input-inside form-control"  value="${valueDetails.UnitCount}" ${props} readonly>
                                <input name="col3" id ="col3${tokenId}" class="col3 ${classAnonymouscols}" readonly>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 65px;" type="text" name="prodQty_" id ="prodQty_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodQty_ resize-input-inside inputs form-control" value="${(parseFloat(valueDetails.Qty)).toFixed(3)}" ${props}>
                                <input name="col4" id ="col4${tokenId}" class="col4 ${classAnonymouscols}" readonly>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 100px;" type="text" name="prodPrice_" id ="prodPrice_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs form-control" value="${(parseFloat(valueDetails.Price)).toFixed(2)}" ${props}>
                                <input name="col1" id ="col1${tokenId}" class="col1 ${classAnonymouscols}" readonly>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 80px;" type="text" name="prodDisc_" id ="prodDisc_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside inputs form-control" value="${valueDetails.LineDisc}" ${props} {{ $discountProperty }}>
                                <input name="col6" id ="col6${tokenId}" class="col6 ${classAnonymouscols}" style="color: brown;" readonly>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 75px;" type="text" name="prodUnitSize_" id ="prodUnitSize_${tokenId}" class="prodUnitSize_ resize-input-inside inputs form-control" value="${valueDetails.UnitSize}" ${props}>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 100px; color: blue;" type="text" name="instockReadOnly" id ="instockReadOnly_${tokenId}" value="${valueDetails.QtyInStock}" class="instockReadOnly_ resize-input-inside inputs form-control">
                                <select name="col2" id ="col2${tokenId}" class="col2 ${classAnonymouscols}">
                                    <option value="${valueDetails.ID}" >"${valueDetails.Warehouse}"</option>
                                </select>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 100px; color:blue;" type="text" name="additionalcost_" id ="additionalcost_${tokenId}" class="additionalcost_ resize-input-inside inputs form-control">
                            </td>
                            <td contenteditable="false">
                                <input style="width: 200px;" type="text" name="prodComment_" id ="prodComment_${tokenId}" class="prodComment_ resize-input-inside last inputs form-control" title="${valueDetails.Comment}"  value="${valueDetails.Comment}" ${props}>
                                <input name="col9" id ="col9${tokenId}" class="col9 ${classAnonymouscols}" readonly>
                            </td>
                        </tr>
                    `);
                    $('#table tbody').append($row);


                    var txt = valueDetails.Warehouse; //$("#headerWh option:selected").text();
                    var val = valueDetails.ID;
                    $("#col2" + tokenId).append("<option value='" + val + "'>" + txt + "</option>");
                    $.each(wareautocomplete, function(i, item) {
                        $("#col2" + tokenId).append("<option value='" + item.ID + "'>" +
                            item.Warehouse + "</option>");
                    });
                    var Ltot = valueDetails.Qty * valueDetails.Price;
                    $("#col6" + tokenId).val(Ltot.toFixed(2));

                });
                calculator();
                //Douwnload Excel
                window.location = '{!! url('/exportorder') !!}/' + $('#orderId').val();


            }

        });
    }

    function getLineDetailsOlyPDF() {
        $.ajax({
            url: '{!! url('/onCheckOrderHeaderDetails') !!}',
            type: "POST",
            data: {
                orderId: $('#orderId').val()
            },
            success: function(dataDetails) {
                InvoiceTotalPriceExcl = 0;
                InvoiceTotalPriceInc = 0;
                $.each(dataDetails, function(keyDetails, valueDetails) {
                    var tokenId = new Date().valueOf();
                    var props = '';
                    console.debug("------------------------------------------------------" +
                        isAllowedToChangeInv);
                    if (($('#invoiceNo').val()).length > 2 && isAllowedToChangeInv != 1) {
                        props = "disabled";

                    }
                    console.debug("************************************ AUTMUTLIWAREHOUSE" +
                        multiLines);
                    if (($('#invoiceNo').val()).length > 2) {
                        $("#inputDeliveryDate").prop("disabled", true);
                        $("#inputOrderDate").prop("disabled", true);
                    }
                    if (multiLines == 1) {
                        var classAnonymouscols = "anonymouscols";
                    } else {
                        var classAnonymouscols = "anonymouscolsOff";
                    }
                    var $row = $(`
                        <tr id="new_row_ajax${tokenId}" class="fast_remove">
                            <td class="text-center">
                                <input type="hidden" id="title_${tokenId}" class="title" value="" />
                                <input type="hidden" id="theOrdersDetailsId" value="${valueDetails.OrderDetailId}" />
                                <input type="hidden" id ="taxCode${tokenId}" value="${valueDetails.Tax}" class="taxCodes" />
                                <input type="hidden" id ="cost_${tokenId}" value="${valueDetails.Cost}" class="costs" />
                                <input type="hidden" id ="inStock_${tokenId}" value="${valueDetails.QtyInStock}" class="inStock" style="color:blue !important" />
                                <input type="hidden" value ="${tokenId}" class="hiddenToken" />
                                <input type="hidden" id ="priceholder_${tokenId}" value="${(parseFloat(valueDetails.Price)).toFixed(2)}" class="priceholder" />
                                <input type="hidden" id ="alcohol_${tokenId}" value="" class="alcohol" />
                                <input type="hidden" id ="margin_${tokenId}" value="" class="margin" />
                                <input type="hidden" id ="soldByWieght${tokenId}" value="" class="soldByWieght" />
                                <input type="hidden" id ="unitWeight${tokenId}" value="" class="unitWeight" />
                                <input type="hidden" id ="strBulkUnit${tokenId}" value="" class="strBulkUnit" />
                                <input type="hidden" id ="prohibited_${tokenId}" value="" class="prohibited" />
                                <input type="hidden" id ="productmarginauth${tokenId}" value="1" class="productmarginauth" />
                                <button type="button" id="deleteaLine" value="${valueDetails.OrderDetailId}" class="getOrderDetailLine btn btn-icon btn-danger btn-sm btn-sm-icon">
                                    <i class="bi bi-trash3-fill fs-4"></i>
                                </button>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 100px;" name="theProductCode" id ="prodCode_${tokenId}" class="theProductCode_ set_autocomplete inputs form-control" value="${valueDetails.PastelCode}" ${props}>
                                <input name="col1" id ="col1${tokenId}" class="col1 ${classAnonymouscols}"  readonly>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 250px;" name="prodDescription_" id ="prodDescription_${tokenId}" class="prodDescription_ set_autocomplete inputs form-control" value="${valueDetails.PastelDescription}" ${props}>
                                <input name="col8" id ="col8${tokenId}" class="col8 ${classAnonymouscols}" readonly>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 65px;" type="text" name="prodBulk_"  id ="prodBulk_${tokenId}" class="prodBulk_ resize-input-inside form-control"  value="${valueDetails.UnitCount}" ${props} readonly>
                                <input name="col3" id ="col3${tokenId}" class="col3 ${classAnonymouscols}" readonly>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 65px;" type="text" name="prodQty_" id ="prodQty_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodQty_ resize-input-inside inputs form-control" value="${(parseFloat(valueDetails.Qty)).toFixed(3)}" ${props}>
                                <input name="col4" id ="col4${tokenId}" class="col4 ${classAnonymouscols}" readonly>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 100px;" type="text" name="prodPrice_" id ="prodPrice_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs form-control" value="${(parseFloat(valueDetails.Price)).toFixed(2)}" ${props}>
                                <input name="col1" id ="col1${tokenId}" class="col1 ${classAnonymouscols}" readonly>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 80px;" type="text" name="prodDisc_" id ="prodDisc_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside inputs form-control" value="${valueDetails.LineDisc}" ${props} {{ $discountProperty }}>
                                <input name="col6" id ="col6${tokenId}" class="col6 ${classAnonymouscols}" style="color: brown;" readonly>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 75px;" type="text" name="prodUnitSize_" id ="prodUnitSize_${tokenId}" class="prodUnitSize_ resize-input-inside inputs form-control" value="${valueDetails.UnitSize}" ${props}>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 100px; color: blue;" type="text" name="instockReadOnly" id ="instockReadOnly_${tokenId}" value="${valueDetails.QtyInStock}"  class="instockReadOnly_ resize-input-inside inputs form-control">
                                <select name="col2" id ="col2${tokenId}" class="col2 ${classAnonymouscols}">
                                    <option value="${valueDetails.ID}" >"${valueDetails.Warehouse}"</option>
                                </select>
                            </td>
                            <td contenteditable="false">
                                <input style="width: 100px; color:blue;" type="text" name="additionalcost_" id ="additionalcost_${tokenId}" value ="" class="additionalcost_ resize-input-inside inputs form-control">
                            </td>
                            <td contenteditable="false">
                                <input style="width: 200px;" type="text" name="prodComment_" id ="prodComment_${tokenId}" class="prodComment_ resize-input-inside last inputs form-control" title="${valueDetails.Comment}"  value="${valueDetails.Comment}" ${props}>
                                <input name="col9" id ="col9${tokenId}" class="col9 ${classAnonymouscols}" readonly>
                            </td>
                        </tr>
                    `);
                    $('#table tbody').append($row);


                    var txt = valueDetails.Warehouse; //$("#headerWh option:selected").text();
                    var val = valueDetails.ID;
                    $("#col2" + tokenId).append("<option value='" + val + "'>" + txt + "</option>");
                    $.each(wareautocomplete, function(i, item) {
                        $("#col2" + tokenId).append("<option value='" + item.ID + "'>" +
                            item.Warehouse + "</option>");
                    });
                    var Ltot = valueDetails.Qty * valueDetails.Price;
                    $("#col6" + tokenId).val(Ltot.toFixed(2));

                });
                calculator();
                //Douwnload Excel


            }

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

    function monitorInvoiced() {
        //AssignInvoiceNumber

        $.ajax({
            url: '{!! url('/checkifInvoiced') !!}',
            type: "POST",
            data: {
                orderID: $('#orderId').val()
            },
            success: function(data) {

                if (data != 'False') {

                    $.ajax({
                        url: '{!! url('/waitingForInvoiceNo') !!}',
                        type: "POST",
                        data: {
                            orderID: $('#orderId').val(),
                            customerCode: $('#inputCustAcc').val(),
                            TotalTendered: $('#posTotalTendered').val(),
                            Change: $('#posChange').val(),
                            AmountToPost: $('#posCashTendered').val(),
                            posPayMentTypeCash: $('#posPayMentTypeCash').val(),
                            posPayMentTypeAccount: $('#posPayMentTypeAccount').val(),
                            posPayMentTypeCreditCard: $('#posPayMentTypeCreditCard').val(),
                            posPayMentTypeCheque: $('#posPayMentTypeCheque').val(),
                            invoiceTotal: $('#totalInc').val()
                        },
                        success: function(data) {

                            disableOnFinish();

                        }
                    });

                } else {
                    if (spool > 3) {
                        var dialog = $('<p><strong style="color:black">Printing problem</strong></p>')
                            .dialog({
                                height: 200,
                                width: 700,
                                modal: true,
                                containment: false,
                                buttons: {
                                    "Okay": {
                                        text: "Okay",
                                        class: "btn btn-success btn-sm",
                                        click: function() {
                                            dialog.dialog('close');
                                        }
                                    },
                                }
                            });
                    } else {
                        spool++;
                        setInterval(monitorInvoiced, 3000);
                    }

                }
            }
        });
    }

    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function productRules(authtype, price, productcode, tax, cost, productgp, themessage, available,
    mustauthstocklines) {
        var passedChecks = true;
        var returnedErrorMessage = "";
        console.debug("product rule tag cost " + cost);
        console.debug("product rule tag price " + price);
        console.debug("product rule tag productgp " + productgp);

        switch (authtype) {
            case "stock":
                if (available <= 0 && mustauthstocklines != 0) {
                    passedChecks = false;

                    returnedErrorMessage += " Stock Availability Error \n";
                }
                break;
            case "price":

                if (price.length <= 0) {
                    price = 0;
                    passedChecks = false;
                    returnedErrorMessage += " Pricing Data Error \n";
                }
                if (price <= 0) {
                    passedChecks = false;
                    returnedErrorMessage += " Pricing Error \n";
                }

                if (cost <= 0) {
                    passedChecks = false;
                    returnedErrorMessage += " Cost Error \n";
                }

                if (productgp == 0) {
                    passedChecks = false;
                    returnedErrorMessage += " GP is 0 Error \n";
                }

                if (marginCalculator(cost, price) < productgp) {
                    passedChecks = false;
                    returnedErrorMessage += " GP is too low Error \n";
                }

                if (themessage == "NEEDAUTH") {
                    passedChecks = false;
                    returnedErrorMessage += " Item needs authorisation \n";
                }
                break;
        }

        if (passedChecks) {
            return "";
        } else {
            return returnedErrorMessage;
        } //column name



    }

    function authPriceByTeamLeaders() {
        if ((parseFloat(Productmargin) > parseFloat(margin).toFixed(2)) && auth.length > 4) {
            $('#MarginProblems').show();
            $('#userAuthProhibitedCred_marg').val('');
            $('#userAuthPassWordCredit_marg').val('');
            showDialogWithoutClose('#MarginProblems', 600, 300);
            $('#MarginProblems').keydown(function(event) {
                if (event.keyCode == 27) {
                    return false;
                }
            });
            $('#doAuthCredits').off().click(function() {

                $.ajax({
                    url: '{!! url('/verifyAuthGroupLeaders') !!}',
                    type: "POST",
                    data: {
                        userName: $('#userAuthProhibitedCred_marg').val(),
                        userPassword: $('#userAuthPassWordCredit_marg').val(),
                        orderId: $('#orderId').val()
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data)) {
                            alert(
                                "Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                        } else {
                            $('#margin_auth').val(1);
                            consoleManagementAuths('{!! url('/logMessageAuthMargin') !!}', 12, 1,
                                'Authorized Product (' + theProductCode + ') Margin ( LM :' +
                                margin + ' PM ' + Productmargin + ')  by ' + data[0].UserName,
                                0, $('#orderId').val(), '', $('#inputCustAcc').val(), 0, 0, 0,
                                $('#userAuthProhibitedCred_marg').val(), $('#orderId').val(), 0,
                                computerName, $('#orderId').val(), 0, data[0].UserID, data[0]
                                .UserName);
                            $("#MarginProblems").dialog('close');
                            $this.closest('tr').find('.title').val('');



                            //calculator();
                        }
                    }
                });

            });
            $('#doCancelAuthCredits').off().click(function() {
                $this.closest('tr').find('.prodPrice_').val('');
                $this.closest('tr').find('.prodPrice_').select();
                $this.closest('tr').find('.prodPrice_').focus();
                $('#MarginProblems').dialog('close');
            });
        }
    }

    $(document).keydown(function(e) {
        if (e.keyCode == 27) return false;
    });
</script>

<x-app-layout>
    <x-slot name="header">
        {{ __('Search') }}
    </x-slot>
    <div id="dialog2" title="Price Check">
        <div class="card mb-5">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <label for="orderid">Order ID</label>
                        <input id="orderid" value="{{ $orderid }}" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-5">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <label for="customercode">Account</label>
                            <input type="text" class="form-control " id="customercode">
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <label for="customerdescription">Customer Description</label>
                            <input type="text" class="form-control" id="customerdescription">
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <label for="inputDeliveryDate">Delivery Date</label>
                            <input type="text" class="form-control" id="inputDeliveryDate">
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <button type="button" class="btn btn-success btn-sm mt-md-6" id="copytothisaccount">Copy To
                                This Account</button>
                        </div>
                    </div>
                </form>
                <div class="row mt-3" style="display: none;">
                    <div class="col-md-12">
                        <div id="listOfDelivAdress" title="Delivery Address" style="display: flex;">
                            <div class="col-lg-12">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="generalRouteForNewDeliveryAddress"
                                            style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                                        <select id="generalRouteForNewDeliveryAddress"
                                            class="form-control input-sm col-xs-1 generalRouteForNewDeliveryAddress">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="address1"
                                            style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address
                                            1</label>
                                        <input class="form-control input-sm col-xs-1" id="address1" name="address1">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="address2"
                                            style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address
                                            2</label>
                                        <input class="form-control input-sm col-xs-1" id="address2" name="address2">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="address3"
                                            style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address
                                            3</label>
                                        <input class="form-control input-sm col-xs-1" id="address3" name="address3">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="address4"
                                            style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address
                                            4</label>
                                        <input class="form-control input-sm col-xs-1" id="address4" name="address4">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="address5"
                                            style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address
                                            5</label>
                                        <input class="form-control input-sm col-xs-1" id="address5" name="address5">
                                        <input type="hidden" id="deliveryAddressIdOnPopUp"
                                            name="deliveryAddressIdOnPopUp" value="">
                                    </div>

                                    <button type="button" id="doneCustomAddress"
                                        class="btn-success doneCustomAddress">Done</button>

                                </div>
                                <div class="col-lg-8">
                                    <input type='text' id='txtList' onkeyup="filter(this)" class="form-control"
                                        placeholder="Please search address here..." />
                                    <hr
                                        style="margin-top: 15px;margin-bottom: 15px;border: 0;border-top: 5px solid #00ff00;" />
                                    <div>
                                        <ul id="listaddresses"
                                            style="font-size: 9px;list-style-type: none;overflow-y: auto;height:300px">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div title="Copying Order" id="pricedialog">
        <h5>Would you like to recalculate the Prices? </h5>
        <button id="no" class="btn btn-primary btn-sm">NO</button>
        <button id="yes" class="btn btn-success btn-sm">YES</button>
    </div>

    <script>
        $(document).on('focus', ':input', function() {
            $(this).attr('autocomplete', 'off');
        });
        $(document).keydown(function(e) {
            if (e.keyCode == 27) return false;
        });
        $(document).on('click', '#customerdescription', function(e) {
            $('#customerdescription').select();
        });
        $(document).on('click', '#customercode', function(e) {
            $('#customercode').select();
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
            $('#salesInvoiced').hide();
            $('#pricedialog').hide();
            $("#inputDeliveryDate").datepicker({
                changeMonth: true, //this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: 'dd-mm-yy'
            });
            var currentdate = new Date();
            $("#inputDeliveryDate").val($.datepicker.formatDate('dd-mm-yy', currentdate));
            var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});

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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var inputCustNames = $('#customerdescription').flexdatalist({
                minLength: 1,
                valueProperty: '*',
                selectionRequired: true,
                focusFirstResult: true,
                searchContain: true,
                visibleProperties: ["StoreName", "CustomerPastelCode"],
                searchIn: 'StoreName',
                data: finalData
            });
            inputCustNames.on('select:flexdatalist', function(event, data) {
                $('#customercode').val(data.CustomerPastelCode);
                $('#customerdescription').val(data.StoreName);
                multiaddress();


            });

            var customerCode = $('#customercode').flexdatalist({
                minLength: 1,
                valueProperty: '*',
                selectionRequired: true,
                focusFirstResult: true,
                searchContain: true,
                visibleProperties: ["StoreName", "CustomerPastelCode"],
                searchIn: 'CustomerPastelCode',
                data: finalData
            });
            customerCode.on('select:flexdatalist', function(event, data) {
                $('#customercode').val(data.CustomerPastelCode);
                $('#customerdescription').val(data.StoreName);
                multiaddress();

            });

            $('#copytothisaccount').click(function() {
                $('#pricedialog').show();
                showDialogWithoutClose('#pricedialog', '65%', 420);

                $('#no').click(function() {
                    $.ajax({
                        url: '{!! url('/insertCopyorder') !!}',
                        type: "POST",
                        data: {
                            custCode: $('#customercode').val(),
                            orderid: $('#orderid').val(),
                            deliverydate: $('#inputDeliveryDate').val(),
                            recalcprice: 0,
                        },
                        success: function(data) {
                            alert(data[0].result);
                            let new_window = open(location, '_self');
                            // Close this window
                            new_window.close();
                        }
                    });
                });

                $('#yes').click(function() {
                    $.ajax({
                        url: '{!! url('/insertCopyorder') !!}',
                        type: "POST",
                        data: {
                            custCode: $('#customercode').val(),
                            orderid: $('#orderid').val(),
                            deliverydate: $('#inputDeliveryDate').val(),
                            recalcprice: 1,
                        },
                        success: function(data) {
                            alert(data[0].result);
                            let new_window = open(location, '_self');
                            // Close this window
                            new_window.close();
                        }
                    });
                });

            });

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

            }

            function multiaddress() {
                $.ajax({
                    url: '{!! url('/selectCustomerMultiAddress') !!}',
                    type: "POST",
                    data: {
                        customerCode: $("#customercode").val()
                    },
                    success: function(data) {
                        var toAppend = '';
                        $('#listaddresses').empty();
                        $.each(data, function(i, o) {
                            toAppend += '<li value="' + o.DeliveryAddressID +
                                '" style="border-bottom: 4px solid black;">' + o.DAddress1 +
                                ' ' + o.DAddress2 + ' ' + o.DAddress3 + '<br>' + o.DAddress4 +
                                '<br>' + o.DAddress5 + '</li>';
                        });
                        $('#listaddresses').append(toAppend);
                        $('#listaddresses li').click(function() {
                            var $this = $(this);
                            var selKeyVal = $this.attr("value");
                            // alert('Text ' + $this.text() + 'value ' + selKeyVal);

                            //  $("#hiddenDeliveryAddressId" ).val(selKeyVal);
                            //$("#customerSelectedDelDate" ).val($this.text());
                            //$("#deliveryAddressIdOnPopUp").val(selKeyVal);
                            //$('#doneCustomAddress').show();
                            //pass this to fetch address
                            console.debug(selKeyVal);
                            fetchDeliveyAddressFronSelect(selKeyVal);

                            // $("#listOfDelivAdress" ).dialog("close");
                        });
                    }
                });
            }

            function fetchDeliveyAddressFronSelect(addressId) {
                $.ajax({
                    url: '{!! url('/selectAddressFromMultiAddressDeliveruyAddressId') !!}',
                    type: "POST",
                    data: {
                        CustomerCode: $('#customercode').val(),
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
                        $("#generalRouteForNewDeliveryAddress").prepend('<option value="' + data[0]
                            .Routeid + '" selected="selected">' + data[0].Route + '</option>');

                    }
                });
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

            ///
        });
    </script>
</x-app-layout>

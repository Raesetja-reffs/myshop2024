<div id="multipleDeliveriesOnTheSameDate" title="Orders">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-condensed table-hover" id="multipleAddressesOnTheSameDateModal">
                        <thead>
                            <tr>
                                <th>OrderId</th>
                                <th>Order Date</th>
                                <th>Delv Date</th>
                                <th>Route</th>
                                <th>Delivery Address</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function multipleDeliveriesOnTheSameDateShowPopUp(data, dialog) {
        $('#multipleDeliveriesOnTheSameDate').show();
        $("#multipleDeliveriesOnTheSameDate")
            .dialog({
                height: 600,
                width: 950,
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
                "load": function(evt,
                dlg) {}, // event
                "beforeCollapse": function(evt,
                    dlg) {}, // event
                "beforeMaximize": function(evt,
                    dlg) {}, // event
                "beforeMinimize": function(evt,
                    dlg) {}, // event
                "beforeRestore": function(evt,
                    dlg) {}, // event
                "collapse": function(evt,
                    dlg) {}, // event
                "maximize": function(evt,
                    dlg) {}, // event
                "minimize": function(evt,
                    dlg) {}, // event
                "restore": function(evt,
                    dlg) {} // event
            });
        var trHTML = '';
        $('.fast_removeOrders').empty();
        $.each(data, function(key, value) {
            trHTML += `
                <tr role="row" class="fast_removeOrders">
                    <td>${value.OrderId}</td>
                    <td>${value.OrderDate}</td>
                    <td>${value.DeliveryDate}</td>
                    <td>${value.routename}</td>
                    <td>${value.DeliveryAddress1}</td>
                </tr>
            `;
        });
        $('#multipleAddressesOnTheSameDateModal tbody').append(trHTML);
        $('#multipleAddressesOnTheSameDateModal tbody').on('dblclick', 'tr', function() {
            var orderIdClicked = $(this).closest('tr').find('td:eq(0)').text();
            $('#orderId').val(orderIdClicked);
            dialog.dialog('close');
            $('#checkOrders').click();
            $("#multipleDeliveriesOnTheSameDate").dialog('close');
        });
    }
</script>

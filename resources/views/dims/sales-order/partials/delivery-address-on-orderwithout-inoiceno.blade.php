<div id="deliveryAddressOnOrderWithoutInoiceNo" title="Please Change the Delivery Address">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h6>Please Double click To Change the Delivery Address</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tbldeliveryAddressOnOrderWithoutInoiceNo"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Delivery Address Id</th>
                                    <th>Address 1 </th>
                                    <th>Address 2</th>
                                    <th>Address 3 </th>
                                    <th>Address 4</th>
                                    <th>Address 5</th>
                                    <th>Route</th>
                                    <th>Route ID</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#deliveryAddressOnOrderWithoutInoiceNo').hide();
        $('#changeDeliveryAddressOnNotInvoiced').click(function() {
            changeDeliveryAddress();
        });

        function changeDeliveryAddress() {
            $.ajax({
                url: '{!! url('/changeDeliveryAddressOnNoInvoiceNo') !!}',
                type: "POST",
                data: {
                    customerCode: $('#inputCustAcc').val()
                },
                success: function(data) {
                    $('#tbldeliveryAddressOnOrderWithoutInoiceNo tbody').empty();
                    $('#deliveryAddressOnOrderWithoutInoiceNo').show();
                    showDialog('#deliveryAddressOnOrderWithoutInoiceNo', '85%', 640);
                    var trHTML = '';
                    $.each(data, function(key, value) {
                        trHTML += `
                            <tr class="rebuild_price_check_list">
                                <td>${value.DeliveryAddressID}</td>
                                <td>${value.DAddress1}</td>
                                <td>${value.DAddress2}</td>
                                <td>${value.DAddress3}</td>
                                <td>${value.DAddress4}</td>
                                <td>${value.DAddress5}</td>
                                <td>${value.Route}</td>
                                <td>${value.Routeid}</td>
                            </tr>
                        `;
                    });
                    $('#tbldeliveryAddressOnOrderWithoutInoiceNo tbody').append(trHTML);

                    $('#tbldeliveryAddressOnOrderWithoutInoiceNo tbody').on('dblclick', 'tr', function() {
                        var deliveryID = $(this).closest('tr').find('td:eq(0)').text();
                        var address1 = $(this).closest('tr').find('td:eq(1)').text();
                        var address2 = $(this).closest('tr').find('td:eq(2)').text();
                        var address3 = $(this).closest('tr').find('td:eq(3)').text();
                        var address4 = $(this).closest('tr').find('td:eq(4)').text();
                        var address5 = $(this).closest('tr').find('td:eq(5)').text();
                        var routeids = $(this).closest('tr').find('td:eq(7)').text();
                        $('#hiddenDeliveryAddressId').val(deliveryID);
                        $('#address1hidden').val($.trim(address1));
                        $('#address2hidden').val($.trim(address2));
                        $('#address3hidden').val($.trim(address3));
                        $('#address4hidden').val($.trim(address4));
                        $('#address5hidden').val($.trim(address5));
                        $('#deliveryAddressOnOrderWithoutInoiceNo').dialog('close');
                        $('#customerSelectedDelDate').val($.trim(address1) + ' ' + $.trim(
                                address2) +
                            ' ' + $.trim(address3) + ' ' + $.trim(address4) + ' ' + $
                            .trim(address4)
                        );
                        $.ajax({
                            url: '{!! url('/changerouteonorder') !!}',
                            type: "POST",
                            data: {
                                routeId: routeids,
                                OrderId: $('#orderId').val(),
                            },
                            success: function(data) {
                                //console.debug(data);
                                $('#routeonabutton').val(data);
                            }
                        });
                    });
                }
            });
        }
    });
</script>

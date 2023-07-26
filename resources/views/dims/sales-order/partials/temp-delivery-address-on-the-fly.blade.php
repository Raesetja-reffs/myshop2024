<div id="tempDeliveryAddressOnTheFly" title="Delivery Address associated with this address order only">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <form>
                    <div class="col-md-12 mb-3">
                        <input class="form-control" id="address1OnTheFly" placeholder="Address 1">
                    </div>
                    <div class="col-md-12 mb-3">
                        <input class="form-control" id="address2OnTheFly" placeholder="Address 2">
                    </div>
                    <div class="col-md-12 mb-3">
                        <input class="form-control" id="address3OnTheFly" placeholder="Address 3">
                    </div>
                    <div class="col-md-12 mb-3">
                        <input class="form-control" id="address4OnTheFly" placeholder="Address 4">
                    </div>
                    <div class="col-md-12 mb-3">
                        <input class="form-control" id="address5OnTheFly" placeholder="Address 5">
                    </div>
                </form>
                <div class="col-md-12 mt-3">
                    <button id="doneWithAddressOntheFly" class="btn btn-success btn-sm float-end">Done</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tempDeliveryAddressOnTheFly').hide();
        $('#tempDelivAddress').click(function() {
            $('#tempDeliveryAddressOnTheFly').show();
            showDialog('#tempDeliveryAddressOnTheFly', '50%', 350);
            $('#doneWithAddressOntheFly').click(function() {
                $('#address1hidden').val($('#address1OnTheFly').val());
                $('#address2hidden').val($('#address2OnTheFly').val());
                $('#address3hidden').val($('#address3OnTheFly').val());
                $('#address4hidden').val($('#address4OnTheFly').val());
                $('#address5hidden').val($('#address5OnTheFly').val());
                $('#hiddenDeliveryAddressId').val('');
                $('#customerSelectedDelDate').empty();
                $('#customerSelectedDelDate').val($('#address1OnTheFly').val() + ' ' + $(
                        '#address2OnTheFly').val() + ' ' + $('#address3OnTheFly').val() +
                    ' ' + $('#address4OnTheFly').val() + ' ' + $('#address5OnTheFly').val());

                $.ajax({
                    url: '{!! url('/tempDeliverAddress') !!}',
                    type: "POST",
                    data: {
                        address1: $('#address1OnTheFly').val(),
                        orderID: $('#orderId').val(),
                        address2: $('#address2OnTheFly').val(),
                        address3: $('#address3OnTheFly').val(),
                        address4: $('#address4OnTheFly').val(),
                        address5: $('#address5OnTheFly').val(),
                        Routeid: $('#routeName').val()
                    },
                    success: function(data) {
                        var dialog = $('<p>' + data + '</p>').dialog({
                            height: 200,
                            width: 700,
                            modal: true,
                            containment: false,
                            buttons: {
                                "OKAY": {
                                    text: "OKAY",
                                    class: "btn btn-success btn-sm",
                                    click: function() {
                                        $('#tempDeliveryAddressOnTheFly').dialog('close');
                                        $('#tempDelivAddressClosethis').hide();
                                        dialog.dialog('close');
                                    }
                                }
                            }
                        });
                    }
                });
            });
            //
        });
    });
</script>

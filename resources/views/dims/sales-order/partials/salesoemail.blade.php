<div id="salesOEmail" title="Sales Order">
    <div class="card">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="fromEmail">From</label>
                        <input type="text" class="form-control" id="fromEmail" value="{{ Auth::user() ? Auth::user()->Email : '' }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="toEmail">To</label>
                        <input type="text" class="form-control" id="toEmail">
                    </div>
                    <div class="col-md-12 mb-3" style="display:none">
                        <label for="cc">CC</label>
                        <input type="text" class="form-control" id="cc">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" id="subject">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="bodyOnEmail">Message</label>
                        <input class="form-control" id="bodyOnEmail" style="height:100px" value="Thank you ,the attached document is your order.">
                    </div>
                    <div class="col-md-12">
                        <button type="button" id="sendOrderEmail" class="btn btn-success btn-sm">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#salesOEmail').hide();
        $('#abilityToEmailOrder').hide();
        $('#abilityToEmailOrder').click(function() {
            var ob = new Array();
            ob = emailSalesOrderOnTheFly();
            //console.debug(ob);
            $.ajax({
                url: '{!! url('/generatePDFForOrders') !!}',
                type: "POST",
                data: {
                    orderLinesOnTheFly: ob,
                    totalInc: $("#totalInc").val(),
                    custDescription: $('#custDescription').val(),
                    orderId: $('#orderId').val()
                },
                success: function(data) {
                    $('#toEmail').val($('#customerEmail').val());
                    $('#sendOrderEmail').val(data);
                    $('#subject').val('Order #' + $('#orderId').val());
                    $('#salesOEmail').show();
                    showDialog('#salesOEmail', '50%', 500);
                    $('#sendOrderEmail').on('click', function() {
                        $.ajax({
                            url: '{!! url('/emailSalesOrder') !!}',
                            type: "POST",
                            data: {
                                orderId: $('#orderId').val(),
                                from: $('#fromEmail').val(),
                                to: $('#toEmail').val(),
                                cc: $('#cc').val(),
                                subject: $('#subject').val(),
                                bodyOnEmail: $('#bodyOnEmail').val(),
                                file: data
                            },
                            success: function(data2) {
                                var dialog = $(`<p><strong style="color:black">${data2}</strong></p>`).dialog({
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
                        });
                    });
                }
            });
        });
    });
</script>

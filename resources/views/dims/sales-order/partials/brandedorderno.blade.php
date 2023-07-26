<div id="brandedorderno" title="Order Numbers" style="background: #ffa65d;">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="pt-2">Route</h6>
                    <div class="table-responsive">
                        <table class="table2 table table-bordered table-hover" id="tableorderno">
                            <thead>
                                <tr>
                                    <th>Brand Id</th>
                                    <th>Brand</th>
                                    <th>Order Number</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <button id="submitorderno" class="btn btn-success btn-sm float-end">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#brandedorderno').hide();
        $('#advancedorderNumber').click(function() {
            $('#brandedorderno').show();
            showDialog('#brandedorderno', '45%', 400);
            $.ajax({
                url: '{!! url('/advancedorderno') !!}',
                type: "POST",
                data: {

                    OrderId: $('#orderId').val()

                },
                success: function(data) {
                    // $('#salesmandialog').dialog('close');
                    var trHTML = '';
                    $.each(data, function(key, value) {
                        trHTML += `
                            <tr class="fast_remove">
                                <td>${value.BrandId}</td>
                                <td>${value.Brand}</td>
                                <td>
                                    <input type="text" class="form-control" id="neworderno" value="${value.OrderNo}">
                                    <input type="hidden" id="brandid" value="${value.BrandId}" style="width:1px" class="foo">
                                </td>
                            </tr>
                        `;

                    });
                    $('#tableorderno tbody').append(trHTML);
                }
            });
        });
    });
</script>

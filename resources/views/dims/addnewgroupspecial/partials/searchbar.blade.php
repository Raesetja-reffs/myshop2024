<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Filters</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-2">
                            <label for="inputCustAcc">Group ID</label>
                            <input type="text" name="custCode" class="form-control" id="inputCustAcc" readonly>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="inputCustName">Group Name</label>
                            <input type="text" name="custDescription" class="form-control" id="inputCustName">
                        </div>
                        <div class="col-md-2 itCanHide mb-2">
                            <label for="dateFrom">Date From</label>
                            <input type="text" class="form-control" id="dateFrom">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="dateTo">Date To</label>
                            <input type="text" class="form-control" id="dateTo">
                        </div>
                        <div class="col-md-2 mb-2">
                            <button type="button" id="submitFiltersOnCustSpecial"
                                class="btn btn-success btn-sm mt-md-6">
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#afterFilter').hide();
        $('#submitFiltersOnCustSpecial').click(function() {
            if (($.trim($('#dateFrom').val())).length > 7 && ($.trim($('#dateTo').val())).length > 7) {
                $(".general-loader").show();
                $('#afterFilter').show();
                //Select * between this date for this customer
                $.ajax({
                    url: '{!! url('/customerGroupByDateOrContract') !!}',
                    type: "POST",
                    data: {
                        groupId: $('#inputCustAcc').val(),
                        dateFrom: $('#dateFrom').val(),
                        dateTo: $('#dateTo').val()
                    },
                    success: function(data) {
                        var trHTML = "";
                        $('.remthisLine').remove();

                        $.each(data, function(key, value) {
                            trHTML += `
                                <tr class="remthisLine">
                                    <td>${value.CustomerSpecial}</td>
                                    <td>${value.SpecialHeaderId}</td>
                                    <td>${value.PastelCode}</td>
                                    <td>${value.PastelDescription}</td>
                                    <td>${value.Date}</td>
                                    <td>${value.DateTo}</td>
                                    <td>${parseFloat(value.Price).toFixed(2)}</td>
                                    <td>${parseFloat(value.Cost).toFixed(2)}</td>
                                    <td>${parseFloat(value.GP).toFixed(2)}</td>
                                    <td style="display: none;">${parseFloat(value.CostPrice).toFixed(2)}</td>
                                    <td>
                                        <button class="btn-sx" value="${value.CustomerSpecial}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            `;
                            $('#specialId').val(value.SpecialHeaderId);
                        });
                        $('#tblCreatedCustomerSpecials tbody').append(trHTML);
                        $(".general-loader").hide();
                    }
                });
            } else {
                alert("Please check your date criteria");
            }
        });
    });
</script>

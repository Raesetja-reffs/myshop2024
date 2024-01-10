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
                        <div class="col-md-2 mb-2 itCanHide">
                            <label for="dateFrom">Date From</label>
                            <input type="text" class="form-control" id="dateFrom">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="dateTo">Date To</label>
                            <input type="text" class="form-control" id="dateTo">
                        </div>
                        <div class="col-md-4 mb-2">
                            <button type="button" id="submitFiltersOnCustSpecial"
                                class="btn btn-success btn-sm mt-md-6">Search</button>
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
                $('#specialslink').empty();
                //$('#deleteSelected').empty();
                $('#deleteSelected').show();
                var from = $.datepicker.formatDate('yy-mm-dd', $.datepicker.parseDate('dd-mm-yy', $(
                    '#dateFrom').val()));
                var dateTo = $.datepicker.formatDate('yy-mm-dd', $.datepicker.parseDate('dd-mm-yy', $(
                    '#dateTo').val()));
                $('#specialslink').append(`
                    <a
                        href="{!! url('/groupSpecailJasper') !!}/${from}/${dateTo}/${$('#inputCustAcc').val()}"
                        target="blank"
                        class="btn btn-primary btn-sm mb-1 mb-sm-0"
                    >
                        Print Result
                    </a>
                    <a
                        href="{!! url('/viewgroupinexcel') !!}/${from}/${dateTo}/${$('#inputCustAcc').val()}"
                        target="blank"
                        class="btn btn-info btn-sm mb-1 mb-sm-0 me-1"
                    >
                        View In Grid
                    </a>
                `);

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
                                    <td class="excluded-td">
                                        <input type="checkbox" name="checkproduct[]" value="${value.PastelCode}" class="custom-checkbox-sm">
                                    </td>
                                    <td>${value.SpecialGroupid}</td>
                                    <td>${value.SpecialHeaderId}</td>
                                    <td>${value.PastelCode}</td>
                                    <td>${value.PastelDescription}</td>
                                    <td>${value.Date}</td>
                                    <td>${value.DateTo}</td>
                                    <td>${parseFloat(value.Price).toFixed(2)}</td>
                                    <td>${parseFloat(value.Cost).toFixed(2)}</td>
                                    <td>${parseFloat(value.GP).toFixed(2)}</td>
                                    <td style="display: none;">${parseFloat(value.CostPrice).toFixed(2)}</td>
                                    <td>${parseFloat(value.Available).toFixed(2)}</td>
                                    <td>${parseFloat(value.Instock).toFixed(2)}</td>
                                    <td class="excluded-td">
                                        <button class="btn btn-icon btn-danger btn-sm btn-sm-icon remove_special_product_line" value="${value.SpecialGroupid}">
                                            <i class="bi bi-trash3-fill fs-4"></i>
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

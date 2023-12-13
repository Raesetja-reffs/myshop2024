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
                            <label for="inputCustAcc">Account</label>
                            <input type="text" name="custCode" class="form-control" id="inputCustAcc">
                            <input type="hidden" name="customerId" id="customerId">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="inputCustName">Customer Name</label>
                            <input type="text" name="custDescription" class="form-control" id="inputCustName">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="custheadid">Contract ID</label>
                            <select class="form-control" id="custheadid"></select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="dateFrom">Date From</label>
                            <input type="text" class="form-control" id="dateFrom">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="dateTo">Date To</label>
                            <input type="text" class="form-control" id="dateTo">
                        </div>
                        <div class="col-md-2 mb-2">
                            <button type="button" id="submitFiltersOnCreatingCustSpecial"
                                class="btn btn-success btn-sm mt-md-6">
                                Submit
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

    });
</script>

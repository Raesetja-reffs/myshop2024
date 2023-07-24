<div id="dialog" title="Order Listing" style="background: #0ba7b8c4;">
    <div class="card mb-5">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-2 mb-2">
                        <label for="invoiceNoOrderListing">Inv No</label>
                        <input type="text" class="form-control" id="invoiceNoOrderListing">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="orderIdOrderListing">Order Id</label>
                        <input type="text" class="form-control" id="orderIdOrderListing">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="customerCodeOrderListing">Cust Code</label>
                        <input type="text" class="form-control" id="customerCodeOrderListing">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="customerDescriptionOrderListing">Cust Desc</label>
                        <input type="text" class="form-control" id="customerDescriptionOrderListing">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="deliveryDateOrderListing">Del Date</label>
                        <input type="text" class="form-control" id="deliveryDateOrderListing">
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="button" id="passFiltersOnOrderListing" class="btn btn-success btn-sm mt-md-6">
                            Go
                        </button>
                        <button type="button" id ="refreshOrderListing" class="btn btn-primary btn-sm mt-md-6" >
                            <i class="icon-refresh"></i> Refresh
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-5">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12" style="min-height: 59px;">
                    <div class="table-responsive">
                        <table class="table2 table table-bordered table-hover fs-8" id="createdOrders" tabindex=0>
                            <thead>
                                <tr>
                                    <th>OrderId</th>
                                    <th>Invoice no</th>
                                    <th>Cust Code</th>
                                    <th>Cust Name</th>
                                    <th>Order Types</th>
                                    <th>Route</th>
                                    <th>Delivery Date</th>
                                    <th>Order Date</th>
                                    <th>Reference No</th>
                                    <th>Created By</th>
                                    <th>Total Inv</th>
                                    <th>Terms</th>
                                    <th>Bal.Due</th>
                                    <th>GP(%)</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>OrderId</th>
                                    <th>Invoice no</th>
                                    <th>Cust Code</th>
                                    <th>Cust Name</th>
                                    <th>Order Types</th>
                                    <th>Route</th>
                                    <th>Delivery Date</th>
                                    <th>Order Date</th>
                                    <th>Reference No</th>
                                    <th>Created By</th>
                                    <th>Total Inc</th>
                                    <th>Terms</th>
                                    <th>Bal.Due</th>
                                    <th>GP(%)</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

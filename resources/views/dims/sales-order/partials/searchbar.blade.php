<div class="row">
    <div class="col-md-9 col-sm-12">
        <!-- Empty left column -->
    </div>
    <div class="col-md-3 col-sm-12 p-0">
        <!-- Content on the right side -->
        <div class="content-right">
            <!-- Place your content here -->
            <table class="table">
                <tr>
                    <td class="p-1">No.Orders Today</td>
                    <td class="p-1">Order Val</td>
                    <td class="p-1">Avg Ord Val</td>
                </tr>
                @foreach ($userperformance as $value)
                    <tr>
                        <td class="p-1">{{ $value->NoOfOrders }}</td>
                        <td class="p-1">{{ round($value->OrderValue, 2) }}</td>
                        <td class="p-1">{{ round($value->AvgOrderValue, 2) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 col-sm-12">
        <!-- 30% width section -->
        <div class="row">
            <div class="col-md-4 p-0 me-2 mb-2">
                <label for="inputOrderId">Inv No.</label>
                <input type="text" class="form-control" id="invoiceNo" autocomplete="off">
                <input type="hidden" id="invoiceNoKeeper">
            </div>
            <div class="col-md-4 p-0 me-2 mb-2">
                <label for="inputOrderId">Order ID</label>
                <input type="number" class="form-control disable-input-type-number-arrows" id="orderId" autocomplete="off">
            </div>
            <div class="col-md-3 p-0 me-2 mt-md-6 mb-4">
                <button type="button" id="checkOrders" class="btn btn-primary btn-sm ps-5 pe-5">Check</button>
            </div>
        </div>
    </div>
    <div class="col-md-9 col-sm-12">
        <!-- 70% width section -->
        <div class="row">
            <div class="col-md-2 p-0 me-2 mb-2">
                <label class="text-nowrap" for="inputOrderId">Delivery Type</label>
                <select class="form-control form-select" id="orderType" disabled>
                </select>
            </div>
            <div class="col-md-2 p-0 me-2 mb-2">
                <label for="inputCustAcc">Account</label>
                <input type="text" name="custCode" class="form-control" id="inputCustAcc">
                <input type="hidden" name="hiddenCustomerNotes" id="hiddenCustomerNotes">
                <input type="hidden" name="hiddenRouteId" id="hiddenRouteId">
                <input type="hidden" name="hiddenRouteName" id="hiddenRouteName">
                <input type="hidden" name="CustomerId" id="CustomerId">
            </div>
            <div class="col-md-2 p-0 me-2 mb-2">
                <label for="inputCustName">Customer Name</label>
                <input type="text" name="custDescription" class="form-control" id="inputCustName">
                <input type="hidden" name="customerEmail" id="customerEmail">
                <input type="hidden" name="Routeid" id="Routeid">
                <input type="hidden" name="hiddenCustDiscount" id="hiddenCustDiscount">
                <input type="hidden" name="hiddencustomerGp" id="hiddencustomerGp">
            </div>
            <div class="col-md-2 p-0 me-2 mb-2">
                <label for="inputOrderDate">Order Date</label>
                <input type="text" class="form-control fw-bolder" id="inputOrderDate">
            </div>
            <div class="col-md-2 p-0 me-2 mb-2">
                <label for="inputDeliveryDate">Delivery Date</label>
                <input type="text" class="form-control fw-bolder" id="inputDeliveryDate">
            </div>
            <div class="col-md-1 p-0 me-2 mt-md-6 mb-2">
                <button type="button" id="submitFilters" class="btn btn-primary btn-sm ps-6 pe-6">Submit</button>
            </div>
        </div>
    </div>
</div>

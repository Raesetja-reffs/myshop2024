<div class="row">
    <div class="col-md-9 col-sm-12">
        <!-- Empty left column -->
    </div>
    <div class="col-md-3 col-sm-12">
        <!-- Content on the right side -->
        <div class="content-right">
            <!-- Place your content here -->
            <table class="table">
                <tr>
                    <td>No.Orders Today</td>
                    <td>Order Val</td>
                    <td>Avg Ord Val</td>
                </tr>
                @foreach ($userperformance as $value)
                    <tr>
                        <td>{{ $value->NoOfOrders }}</td>
                        <td>{{ round($value->OrderValue, 2) }}</td>
                        <td>{{ round($value->AvgOrderValue, 2) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 col-sm-12">
        <!-- 30% width section -->
        <div class="form-group d-flex">
            <div class="me-2 flex-grow-1">
                <label for="inputOrderId">Inv No.</label>
                <input type="text" class="form-control" id="invoiceNo" autocomplete="off">
                <input type="hidden" id="invoiceNoKeeper">
            </div>
            <div class="me-2 flex-grow-1">
                <label for="inputOrderId">Order ID</label>
                <input type="number" class="form-control" id="orderId" autocomplete="off">
            </div>
            <div class="me-2 flex-grow-1">
                <button type="button" id="checkOrders" class="btn btn-primary mt-6">Check</button>
            </div>
        </div>
    </div>
    <div class="col-md-9 col-sm-12">
        <!-- 70% width section -->
        <div class="form-group d-flex">
            <div class="me-2 flex-grow-1">
                <label class="text-nowrap" for="inputOrderId">Delivery Type</label>
                <select class="form-control" id="orderType" disabled>
                </select>
            </div>
            <div class="me-2 flex-grow-1">
                <label for="inputCustAcc">Account</label>
                <input type="text" name="custCode" class="form-control" id="inputCustAcc">
                <input type="hidden" name="hiddenCustomerNotes" id="hiddenCustomerNotes">
                <input type="hidden" name="hiddenRouteId" id="hiddenRouteId">
                <input type="hidden" name="hiddenRouteName" id="hiddenRouteName">
                <input type="hidden" name="CustomerId" id="CustomerId">
            </div>
            <div class="me-2 flex-grow-1">
                <label for="inputCustName">Customer Name</label>
                <input type="text" name="custDescription" class="form-control" id="inputCustName">
                <input type="hidden" name="customerEmail" id="customerEmail">
                <input type="hidden" name="Routeid" id="Routeid">
                <input type="hidden" name="hiddenCustDiscount" id="hiddenCustDiscount">
                <input type="hidden" name="hiddencustomerGp" id="hiddencustomerGp">
            </div>
            <div class="me-2 flex-grow-1">
                <label for="inputOrderDate">Order Date</label>
                <input type="text" class="form-control fw-bolder" id="inputOrderDate">
            </div>
            <div class="me-2 flex-grow-1">
                <label for="inputDeliveryDate">Delivery Date</label>
                <input type="text" class="form-control fw-bolder" id="inputDeliveryDate">
            </div>
            <div class="me-2 flex-grow-1">
                <button type="button" id="submitFilters" class="btn btn-primary mt-6">Submit</button>
            </div>
        </div>
    </div>
</div>

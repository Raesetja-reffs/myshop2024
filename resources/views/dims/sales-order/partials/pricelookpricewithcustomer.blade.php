<div id="priceLookPriceWithCustomer" title="Price Look on Customer" style="background-color: #F1F1F2;">
    <div class="card mb-3">
        <div class="card-body">
            <form>
                <div class="row">
                    <h5>Search</h5>
                    <div class="col-md-2">
                        <label for="productCodePl">Product Code</label>
                        <input type="text" class="form-control" id="productCodePl">
                    </div>
                    <div class="col-md-4">
                        <label for="productDescPl">Product Desc</label>
                        <input type="text" class="form-control" id="productDescPl">
                        <input type="hidden" class="form-control input-sm col-xs-1" id="prodId">
                    </div>
                    <div class="col-md-2">
                        <label for="custCodePl">Customer Code</label>
                        <input type="text" class="form-control" id="custCodePl">
                    </div>
                    <div class="col-md-3">
                            <label for="custDescPl">Customer Desc</label>
                            <input type="text" class="form-control" id="custDescPl">
                            <input type="hidden" class="form-control" id="custId">
                    </div>
                    <div class="col-md-1">
                        <button type="button" id="goOnPL" class="btn btn-success btn-sm mt-md-6">GO</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <h5>Unit Of Sale <strong><i id="unitOfSale"></i></strong></h5>
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="individualPriceCheckByCustomer" style="width:100%">
                        <thead>
                            <tr>
                                <th>Price Incl</th>
                                <th>Price Exc</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="individualCost" style="width:100%">
                        <thead>
                            <tr>
                                <th>Cost</th>
                                <th>Remaining</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-hover" id="priceCheckByCustomer" style="width:100%">
                        <thead>
                            <tr>
                                <th>Price List</th>
                                <th>Price</th>
                                <th>Price Inc</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered table-hover" id="currentCustomerPrices" style="width:100%">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Price Type</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#pricingOnCustomer').click(function() {
            $('#priceLookPriceWithCustomer').show();
            showDialog('#priceLookPriceWithCustomer', '65%', 620);
            $('#goOnPL').click(function() {
                PL();
            });
        });
    });

    function PL() {
        $.ajax({
            url: '{!! url('/productPriceLookUp') !!}',
            type: "POST",
            data: {
                productCode: $('#productCodePl').val(),
                customerCode: $('#custCodePl').val(),
                prodId: $('#prodId').val(),
                custId: $('#custId').val(),
            },
            success: function(data) {

                var trHTML = '';
                $('#priceCheckByCustomer tbody').empty();
                $.each(data.priceList, function(key, value) {
                    trHTML +=
                        '<tr  class="rebuild_price_check_list"><td>' +
                        value.PriceList + '</td><td><strong>' +
                        (parseFloat(value.Price)).toFixed(2) + '</strong></td><td>' +
                        (parseFloat(value.PriceInc)).toFixed(2) + '</td><td>' +
                        '</td></tr>';
                });
                $('#priceCheckByCustomer').append(trHTML);

                var trHTML = '';
                $('#currentCustomerPrices tbody').empty();
                $.each(data.currentPrices, function(key, value) {
                    trHTML +=
                        '<tr  class="rebuild_price_check_list"><td>' +
                        value.ProductId + '</td><td><strong>' +
                        value.info + '</strong></td><td>' +
                        (parseFloat(value.Price)).toFixed(2) + '</td><td>' +
                        '</td></tr>';
                });
                $('#currentCustomerPrices').append(trHTML);

                var trHTML = '';
                $('#individualCost tbody').empty();

                $.each(data.stock, function(key, value) {
                    trHTML +=
                        '<tr  class="rebuild_price_check_list"><td>' +
                        (parseFloat(value.Cost)).toFixed(2) + '</td><td><strong>' +
                        value.Remaining + '</strong></td>' +

                        '</td></tr>';
                });
                $('#individualCost').append(trHTML);
                var trHTML = '';
                $('#individualPriceCheckByCustomer tbody').empty(); //+ value.Price
                $.each(data.productPriceForCust, function(key, value) {
                    var pricesInc = (parseFloat(value.Price * value.Tax) + parseFloat(value.Price))
                        .toFixed(2);
                    trHTML +=
                        '<tr  class="rebuild_price_check_list"><td>' +
                        pricesInc + '</td><td><strong>' +
                        (parseFloat(value.Price)).toFixed(2) + '</strong></td>' +
                        '</tr>';
                });
                $('#individualPriceCheckByCustomer').append(trHTML);
            }
        });
    }
</script>

<div class="col-lg-12" id="prodonInvoice" title="Products on Invoices" style="background: #97249eba">
    <div class="card mb-3">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Search</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label for="productCodeOnOrder">Product Code</label>
                        <input type="text" class="form-control" id="productCodeOnInvoice">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="productDescOnOrder">Product Desc</label>
                        <input type="text" class="form-control" id="productDescOnInvoiced">
                    </div>
                    <div class="col-md-4 mb-2">
                        <button type="button" id="callSpOnInvoiced" class="btn btn-success btn-sm mt-md-6">GO</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover search-table" id="tblOnInvoiced" style="overflow-y: scroll; width: 100%;" tabindex=0>
                        <thead>
                            <tr>
                                <th class="col-sm-1">Order Id</th>
                                <th class="col-sm-1">Order Date</th>
                                <th class="col-sm-1">Delivery Date</th>
                                <th>Cust Code</th>
                                <th class="col-md-3">Store Name</th>
                                <th>Qty</th>
                                <th>Prod Code</th>
                                <th class="col-md-4">Prod Description</th>
                                <th>Comment</th>
                                <th>Nett</th>
                                <th>Back Order</th>

                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#salesInvoiced').click(function() {
            $('#prodonInvoice').show();
            showDialog('#prodonInvoice', '85%', 640);
            productsOnInvoiced();
            $('#tblOnInvoiced tbody').on('click', 'tr', function(e) {
                $("#tblOnInvoiced tbody tr").removeClass('row_selected');
                $(this).addClass('row_selected');
                globalOrderIdToBePushed = [];
                arrayOfCustomerInfo = [];
                $('#orderIds').val('');
                var rowOnOrder = $(this).closest("tr");
                var orderIDrowOnOrder = rowOnOrder.find('td:eq(0)').text();
                globalOrderIdToBePushed.push(orderIDrowOnOrder);
                arrayOfCustomerInfo.push(rowOnOrder.find('td:eq(1)').text());
                arrayOfCustomerInfo.push(rowOnOrder.find('td:eq(2)').text());
                arrayOfCustomerInfo.push(rowOnOrder.find('td:eq(3)').text());
            });
            $('#callSpOnInvoiced').click(function() {
                productsOnInvoiced();
            });
        });
    });
    function productsOnInvoiced() {
        productsOnOrders = $('#tblOnInvoiced').DataTable({
            "ajax": {
                url: '{!! url('/productsOnInvoiced') !!}',
                "type": "post",
                data: function(data) {
                    data.productCode = $('#productCodeOnInvoice').val();

                }
            },
            "columns": [{
                    "data": "OrderId",
                    "class": "",
                    "bSortable": true
                },
                {
                    "data": "OrderDate",
                    "class": ""
                },
                {
                    "data": "DeliveryDate",
                    "class": ""
                },
                {
                    "data": "CustomerPastelCode",
                    "class": ""
                },
                {
                    "data": "StoreName",
                    "class": ""
                },
                {
                    "data": "Qty",
                    "class": "",
                    render: function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    },
                    "bSortable": true
                },
                {
                    "data": "PastelCode",
                    "class": ""
                },
                {
                    "data": "PastelDescription",
                    "class": ""
                },
                {
                    "data": "Comment",
                    "class": ""
                },
                {
                    "data": "NettPrice",
                    "class": "",
                    render: function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    },
                    "bSortable": true
                },
                {
                    "data": "Backorder",
                    "class": ""
                }

            ],
            "deferRender": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            searching: true,
            bPaginate: false,
            bFilter: false,
            //dom: 'Bfrtip',
            dom: `<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>
                <'row'<'col-sm-12'tr>>
                <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>
            `,
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn-primary btn-sm',
                },
                {
                    extend: 'csv',
                    className: 'btn-primary btn-sm',
                },
                {
                    extend: 'excel',
                    className: 'btn-primary btn-sm',
                }
            ],
            "LengthChange": false,
            "info": false,
            "destroy": true,
            scrollX: true,
        });
        $("#tblOnInvoiced_wrapper .dt-buttons").parents("div:first").addClass("d-flex align-items-center");
        $("#tblOnInvoiced_wrapper .dt-buttons button").removeClass('btn-secondary').addClass("me-2");
        $("#tblOnInvoiced_wrapper .dataTables_filter input").removeClass('form-control-sm form-control-solid');
    }
</script>

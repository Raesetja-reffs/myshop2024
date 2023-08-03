<div class="col-md-4 col-sm-12 hidebody">
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4 ps-3 mb-3">
                    <label for="routeName" class="form-label">Route</label>
                    <input type="button" id="routeonabutton" class="btn btn-primary btn-sm form-control"
                        value="TEST LONG ROUTE IF">
                    <select class="form-control form-select" name="routeName" id="routeName" style="display:none;">
                    </select>
                </div>
                <div class="col-md-2 p-0 pe-3 ps-3 ps-md-0 mb-3">
                    <label for="creditLimit" class="form-label">CR Limit</label>
                    <input type="text" class="form-control" id="creditLimit" readonly>
                </div>
                <div class="col-md-3 p-0 pe-3 ps-3 ps-md-0 mb-3">
                    <label for="balDue" class="form-label">BalDue</label>
                    <input type="text" class="form-control" id="balDue" readonly>
                </div>
                <div class="col-md-3 p-0 pe-3 ps-3 ps-md-0 mb-3">
                    <label for="headerWh" class="form-label">WH</label>
                    <select id="headerWh" class="form-control form-select">
                    </select>
                </div>
                <div class="col-md-4 p-0 pe-3 ps-3 mb-3" id="deprecated_cangeDate">
                    <label for="changeDelvDate" class="form-label">Delv Date</label>
                    <input type="text" class="form-control" id="changeDelvDate">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#content1">Pattern</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab2" data-bs-toggle="tab" href="#content2">Specials</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab3" data-bs-toggle="tab" href="#content3">Invoices</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab3" data-bs-toggle="tab" href="#content4">On Order</a>
                        </li>
                    </ul>

                    <div class="tab-content fs-8">
                        <div class="tab-pane fade show active" id="content1">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="search-table table table-striped table-bordered table-hover"
                                            id="orderPatternIdTable">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap">Description</th>
                                                    <th>2Week</th>
                                                    <th>Avg</th>
                                                    <th>InStk</th>
                                                    <th>C</th>
                                                    <th>T</th>
                                                    <th>Auth</th>
                                                    <th class="text-nowrap">Code</th>
                                                    <th>P</th>
                                                    <th>Tx</th>
                                                    <th>U</th>
                                                    <th>U.W</th>
                                                    <th>S.B.W</th>
                                                    <th>B.U</th>
                                                    <th>Mgn</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="content2">
                            <div class="row mt-3">
                                <div class="col-md-12" style="height: 350px;overflow-y:auto;">
                                    <h6>Customer Special Pricing</h6>
                                    <div class="table-responsive">
                                        <table id="customerSpecials" class="table table-bordered table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap">Item</th>
                                                    <th class="text-nowrap">Code</th>
                                                    <th>Price</th>
                                                    <th class="text-nowrap">From</th>
                                                    <th class="text-nowrap">To</th>
                                                    <th>UOM</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12" style="height: 350px;overflow-y:auto;">
                                    <h6 class="pt-2">Group Special Pricing</h6>
                                    <div class="table-responsive">
                                        <table id="groupSpecials" class="table table-bordered table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap">Item</th>
                                                    <th class="text-nowrap">Code</th>
                                                    <th>Price</th>
                                                    <th class="text-nowrap">From</th>
                                                    <th class="text-nowrap">To</th>
                                                    <th>UOM</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="content3">
                            <div class="row mt-3">
                                <div class="col-md-12" style="height: 400px;overflow-y:auto;">
                                    <div class="table-responsive">
                                        <table id="pastInvoices" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap">Invoice No</th>
                                                    <th class="text-nowrap">Order date</th>
                                                    <th class="text-nowrap">Delivery Date</th>
                                                    <th>Ref</th>
                                                    <th style="width:1px"></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="content4">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div id="gridbackorders" style="max-width: 100% !important">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function backorderandawaiting(addressId) {
        $.ajax({
            url: '{!! url('/backordersandawaiting') !!}',
            type: "POST",
            data: {
                addressId: addressId,
                customerCode: $('#inputCustAcc').val(),
            },
            success: function(data) {
                console.log(data);

                $("#gridbackorders").dxDataGrid({
                    dataSource: data, //as json
                    hoverStateEnabled: true,
                    showBorders: true,
                    filterRow: {
                        visible: false
                    },
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    wordWrapEnabled: true,
                    showScrollbar: "always",
                    // height: 500,
                    paging: {
                        pageSize: 10,
                    },
                    editing: {
                        mode: 'single',
                        // allowUpdating: true,
                        allowDeleting: true,
                    },
                    selection: {
                        mode: 'batch',
                    },
                    columns: [
                        {
                            dataField: "prodStatusType",
                            caption: "Type",
                            width: 62,
                            cellTemplate: function(cellElement, cellInfo) {

                                cellElement.addClass('custom-font');

                                cellElement.text(cellInfo.text);
                            }

                        },
                        {
                            dataField: "OrderId",
                            caption: "OrderId",
                            width: 75,
                            cellTemplate: function(cellElement, cellInfo) {
                                cellElement.addClass('custom-font');
                                cellElement.text(cellInfo.text);
                            }

                        },
                        {
                            dataField: "ProductId",
                            caption: "ProductId",
                            visible: false,
                        },
                        {
                            dataField: "DeliveryAddressID",
                            caption: "DeliveryAddressID",
                            visible: false,
                        },
                        {
                            dataField: "OrderDetailId",
                            caption: "OrderDetailId",
                            visible: false,
                        },
                        {
                            dataField: "PastelCode",
                            caption: "Product Code",
                            width: 30,
                            visible: false,
                            cellTemplate: function(cellElement, cellInfo) {

                                cellElement.addClass('custom-font');

                                cellElement.text(cellInfo.text);
                            }
                        },
                        {
                            dataField: "Description",
                            caption: "Item",
                            width: 200,
                            cellTemplate: function(cellElement, cellInfo) {
                                console.debug("column");
                                console.debug(cellInfo.column);

                                cellElement.addClass('custom-font');
                                cellElement.attr('title', cellInfo.text)

                                cellElement.text(cellInfo.text);
                            }
                        },
                        {
                            dataField: "Ordered",
                            caption: "QTY",
                            width: 70,
                            cellTemplate: function(cellElement, cellInfo) {

                                cellElement.addClass('custom-font');

                                cellElement.text(cellInfo.text);
                            }
                        },
                        {
                            dataField: "originalQty",
                            caption: "Orig.Qty",
                            width: 88,
                            cellTemplate: function(cellElement, cellInfo) {

                                cellElement.addClass('custom-font');

                                cellElement.text(cellInfo.text);
                            }
                        },
                        {
                            dataField: "DeliveryDate",
                            caption: "D.Date",
                            width: 100,
                            displayFormat: "yyyy-mm-dd",
                            cellTemplate: function(cellElement, cellInfo) {

                                cellElement.addClass('custom-font');

                                cellElement.text(cellInfo.text);
                            }
                        },
                        {
                            dataField: "UnitWeight",
                            caption: "UnitWeight",
                            width: 30,
                            visible: false,
                            cellTemplate: function(cellElement, cellInfo) {

                                cellElement.addClass('custom-font');

                                cellElement.text(cellInfo.text);
                            }
                        },
                        {
                            dataField: "SoldByWeight",
                            caption: "SoldByWeight",
                            width: 30,
                            visible: false,
                            cellTemplate: function(cellElement, cellInfo) {
                                cellElement.addClass('custom-font');
                                cellElement.text(cellInfo.text);
                            }
                        },
                        {
                            dataField: "Tax",
                            caption: "Tax",
                            visible: false,

                            cellTemplate: function(cellElement, cellInfo) {

                                cellElement.addClass('custom-font');
                                cellElement.text(cellInfo.text);
                            }
                        },
                        {
                            dataField: "strBulkUnit",
                            caption: "strBulkUnit",
                            visible: false,
                            cellTemplate: function(cellElement, cellInfo) {

                                cellElement.addClass('custom-font');

                                cellElement.text(cellInfo.text);
                            }
                        },
                        {
                            dataField: "ProductMargin",
                            caption: "ProductMargin",
                            visible: false,
                            cellTemplate: function(cellElement, cellInfo) {

                                cellElement.addClass('custom-font');

                                cellElement.text(cellInfo.text);
                            }
                        },
                        {
                            dataField: "UnBookedStock",
                            caption: "UnBookedStock",
                            width: 30,
                            visible: false,
                            format: {
                                type: "fixedPoint",
                                precision: 3
                            },
                            customizeText: function(cellInfo) {
                                return Number(cellInfo.value).toFixed(3);
                            }
                        },
                        {
                            dataField: "OrderNumber",
                            caption: "O.Num",
                            width: 71,
                            cellTemplate: function(cellElement, cellInfo) {
                                if (cellInfo.column.index === 0) {
                                    cellElement.addClass('custom-font');
                                }
                                cellElement.text(cellInfo.text);
                            }
                        },
                        {
                            dataField: "Comment",
                            caption: "Comment",
                            width: 30,
                            visible: false,
                            cellTemplate: function(cellElement, cellInfo) {
                                if (cellInfo.column.index === 0) {
                                    cellElement.addClass('custom-font');
                                }
                                cellElement.text(cellInfo.text);
                            }
                        },
                        {
                            dataField: "Cost",
                            caption: "Cost",
                            width: 30,
                            visible: false,
                            format: {
                                type: "fixedPoint",
                                precision: 2
                            },
                            customizeText: function(cellInfo) {
                                return Number(cellInfo.value).toFixed(2);
                            }
                        },
                        {
                            dataField: "UnitSize",
                            caption: "UnitSize",
                            width: 30,
                            visible: false,
                            cellTemplate: function(cellElement, cellInfo) {
                                if (cellInfo.column.index === 0) {
                                    cellElement.addClass('custom-font');
                                }
                                cellElement.text(cellInfo.text);
                            }
                        }
                    ],
                    onRowDblClick: function(e) {
                        var invNum = e.data.OrderId;
                        var productCode = e.data.PastelCode;
                        var producutDescr = e.data.Description;
                        if (e.rowType == 'data' && e.data.prodStatusType == "Awaiting Stock") {
                        }
                    },
                    onRowPrepared(e) {
                        if (e.rowType == 'data' && e.data.prodStatusType == "Back Order") {
                            e.rowElement.css('background', 'rgb(155, 236, 248)');
                        }
                    },
                    onRowRemoving: function(e) {
                        var OrderDetailId = e.data.OrderDetailId;
                        console.debug("orderdetail Id ____________" + OrderDetailId);
                        $.ajax({
                            url: '{!! url('/deleteOrderLinedetails') !!}',
                            type: "POST",
                            data: {
                                OrderId: OrderDetailId,
                            },
                            success: function(data) {
                                alert(data[0]['Result']);
                            }
                        });
                    }
                });
            }
        });
    }
</script>

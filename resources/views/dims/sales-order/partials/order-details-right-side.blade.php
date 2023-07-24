<div class="col-md-4 col-sm-12 hidebody">
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 ps-3 me-4 mb-3">
                    <label for="routeName" class="form-label">Route</label>
                    <input type="button" id="routeonabutton" class="btn btn-primary btn-sm ps-1 pe-1"
                        value="TEST LONG ROUTE IF">
                    <select class="form-control form-select" name="routeName" id="routeName" style="display:none;">
                    </select>
                </div>
                <div class="col-md-2 ps-3 p-md-0 me-1" id="deprecated_cangeDate">
                    <label for="changeDelvDate" class="form-label">Delv Date</label>
                    <input type="text" class="form-control" id="changeDelvDate">
                </div>
                <div class="col-md-2 ps-3 p-md-0 me-1 mb-3">
                    <label for="creditLimit" class="form-label">CR Limit</label>
                    <input type="text" class="form-control" id="creditLimit" readonly>
                </div>
                <div class="col-md-2 p-md-0 ps-3 me-1 mb-3">
                    <label for="balDue" class="form-label">BalDue</label>
                    <input type="text" class="form-control" id="balDue" readonly>
                </div>
                <div class="col-md-2 ps-3 p-md-0 mb-3">
                    <label for="headerWh" class="form-label">WH</label>
                    <select id="headerWh" class="form-control form-select">
                    </select>
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
                                        <table class="search-table table table-striped table-bordered table-hover" id="orderPatternIdTable">
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
                                        <table id="groupSpecials" class="table table-bordered table-hover" style="width: 100%;">
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
                            <div id="gridbackorders" style="max-width: 100% !important">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

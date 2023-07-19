<div class="col-md-4 col-sm-12 bg-gray-200 /*hidebody*/">
    <div class="row mb-3">
        <div class="col-md-4 p-0 me-1">
            <label for="" class="form-label">Route</label>
            <input type="button" id="routeonabutton" class="btn btn-primary btn-sm ps-1 pe-1" value="TEST LONG ROUTE IF">
            <select class="form-control form-select" name="routeName" id="routeName">
            </select>
        </div>
        <div class="col-md-2 p-0 me-1" id="deprecated_cangeDate">
            <label for="descriptionSearch" class="form-label">Delv Date</label>
            <input type="text" class="form-control" id="changeDelvDate">
        </div>
        <div class="col-md-2 p-0 me-1">
            <label for="creditLimit" class="form-label">CR Limit</label>
            <input type="text" class="form-control" id="creditLimit" readonly>
        </div>
        <div class="col-md-2 p-0 me-1">
            <label for="balDue" class="form-label">BalDue</label>
            <input type="text" class="form-control" id="balDue" readonly>
        </div>
        <div class="col-md-2 p-0 me-1">
            <label for="balDue" class="form-label">WH</label>
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

            <div class="tab-content">
                <div class="tab-pane fade show active" id="content1">
                    <table class="table search-table" id="orderPatternIdTable"
                        style="overflow-y: scroll; width: 100%;font-family: sans-serif;!important; ">
                        <thead>
                            <tr>
                                <th class="col-md-8">Description</th>
                                <th class="col-xs-1">2Week</th>
                                <th class="col-xs-1">Avg</th>
                                <th class="col-xs-1">InStk</th>
                                <th style="width:2px;font-size:5px;">C</th>
                                <th class="col-xs-1">T</th>
                                <th class="col-xs-1 ">Auth</th>
                                <th class="col-xs-1 ">Code</th>
                                <th class="col-xs-1 ">P</th>
                                <th class="col-xs-1 ">Tx</th>
                                <th class="col-xs-1 ">U</th>
                                <th class="col-xs-1 ">U.W</th>
                                <th class="col-xs-1 ">S.B.W</th>
                                <th class="col-xs-1 ">B.U</th>
                                <th class="col-xs-1 ">Mgn</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="tab-pane fade" id="content2">
                    <div class="col-lg-12 " style="height: 46%;overflow-y:auto;padding: 0px;">
                        <h5>Customer Special Pricing</h5>
                        <table id="customerSpecials" class="table" style=" width: 100%;font-family: sans-serif;">

                            <tr style="font-size: 10px;">
                                <th>Item</th>
                                <th>Code</th>
                                <th>Price</th>
                                <th>From</th>
                                <th>To</th>
                                <th>UOM</th>
                                <th></th>
                            </tr>
                        </table>
                    </div>

                    <div class="col-lg-12 " style="height: 46%;overflow-y:auto;background: lightcyan;padding: 0px;">
                        <h5>Group Special Pricing</h5>
                        <table id="groupSpecials" class="table" style=" width: 100%;font-family: sans-serif;">
                            <tr style="font-size: 10px;">
                                <th>Item</th>
                                <th>Code</th>
                                <th>Price</th>
                                <th>From</th>
                                <th>To</th>
                                <th>UOM</th>
                                <th></th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="content3">
                    <table id="pastInvoices" class="table"
                        style="font-weight: 700;color: #062a04; width: 100%;font-family: sans-serif;">
                        <tr style="font-size: 9px;">
                            <th>Invoice No</th>
                            <th>Order date</th>
                            <th>Delivery Date</th>
                            <th>Ref</th>
                            <th style="width:1px"></th>
                        </tr>
                    </table>
                </div>
                <div class="tab-pane fade" id="content4">
                    <div id="gridbackorders" style="max-width: 100% !important">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('dims.sales-order.partials.calllistdialog')

<div id="tabletLoading" title="Tablet Loading">
    <div class="col-lg-12">
        <form>
            <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="deliveryDates"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                <select class="form-control input-sm col-xs-1" id="deliveryDates"
                    style="height:30px;font-size: 10px;"></select>

            </div>
            <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="orderTypesTabletLoading"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Type</label>
                <select name="custCode" class="form-control input-sm col-xs-1" id="orderTypesTabletLoading"
                    style="height:30px;font-size: 10px;"></select>
            </div>
            <div class="form-group col-md-3" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="rouTabletLoadingtes"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                <select name="custDescription" class="form-control input-sm col-xs-1" id="rouTabletLoadingtes"
                    style="height:30px;font-size: 10px;"></select>
            </div>
            <button type="button" id="tabletLoadingGo" class="btn-sm btn-success">Go</button>
        </form>
    </div>
    <div class="col-lg-12">
        <table class="table" id="tabletLoadingAppTable">
            <thead>
                <tr>
                    <th>Delivery date</th>
                    <th>Order Type</th>
                    <th>Route</th>
                    <th>Customer</th>
                    <th>Inv NO</th>
                    <th>Order ID</th>
                    <th>Code</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="tabletLoadingDocDetails" title="Tablet Loading Document Details">
    <div>
        <button type="button" id="reprintInvoiceOnTablet" class="btn-info btn-md">Print</button>
        <input type="hidden" id="reprintOrderIdFromTablet">
        <input type="hidden" id="reprintInvoiceFromTablet">
    </div>
    <div class="col-lg-12">
        <div class="container">
            <div class="row">
                <div class="col-xs-6" id="orderinfoAddress" style="font-size: 10px;">
                    <img src="{{ URL::asset('/images/logo.png') }}" />
                </div>
                <div class="col-xs-6" id="orderinfo" style="font-size: 10px;">
                    TWO
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <table class="table" id="tabletLoadingAppTableDocDetails">

                <th>Item name</th>
                <th>Quantity</th>
                <th>Unit Size</th>
                <th>Comments</th>

            </table>
        </div>
    </div>
</div>

@include('dims.sales-order.partials.listofdelivadress')

<div id='loadingmessage' style='display:none'>
    <img src="{{ asset('images/Rolling.gif') }}" />
</div>

@include('dims.sales-order.partials.copyorderdialog')

<div id="copyOrderDialogComfirmation" title="Copied Items">
    <div class="col-lg-12" style="">
        <p>The Order has been copied with new order No </p>
        <strong class="newOrderId"></strong>
    </div>
</div>

@include('dims.sales-order.partials.authorisations')

@include('dims.sales-order.partials.custlookup')

@include('dims.sales-order.partials.extrasononrder')

<div id="addNewDeliveryAddressForSingleCustomer" title="Add Address" style="display:none">
    <button id="addNewLineOnAddress" class="btn-success btn-xs">New Line</button>
    <table class="table2" id="addNewAddForSingleACuustomer">
    </table>
    <button class="btn-success btn-">Done</button>
</div>

@include('dims.sales-order.partials.creditlimitauth')

@include('dims.sales-order.partials.reprintauth')

@include('dims.sales-order.partials.authdropdowns')

@include('dims.sales-order.partials.authdropdownsclosedroutepass')

@include('dims.sales-order.partials.addnewaddress')

@include('dims.sales-order.partials.multipledeliveriesonthesamedate')

@include('dims.sales-order.partials.copyprdersmenu')

<div id="copyingOrderProgress" title="Copying Order">
</div>

@include('dims.sales-order.partials.salesoemail')

@include('dims.sales-order.partials.useractiongrid')

@include('dims.sales-order.partials.temp-delivery-address-on-the-fly')

@include('dims.sales-order.partials.pricelookpricewithcustomer')

@include('dims.sales-order.partials.delivery-address-on-orderwithout-inoiceno')

@include('dims.sales-order.partials.tamaracalculator')

@include('dims.sales-order.partials.pointofsaledialog')

@include('dims.sales-order.partials.prohibitedproductauth')

@include('dims.sales-order.partials.authdiscount')

<div id="theCustomerNotes" title="Customer Notes">
    <h4 id="putTheCustomerNoteHere" style="color:red;"></h4>
</div>

@include('dims.sales-order.partials.assignrouteonthefly')

<div title="Transaction" id="popTransaction">
    <table id="tablePopUpSuccessRes" class="table table-bordered">
        <thead>
            <th>productCode</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Comment</th>
            <th>Transaction Method</th>
        </thead>
    </table>
</div>

<div title="In Stock Warning" id="popLessStock" style="background:yellow;font-weight:900;color:red;">
    <h2 style="text-align:center;">There Is Less Available</h2>
</div>

<div title="In Stock Warning" id="popZeroStock" style="background:red;font-weight:900;color:white;">
    <h2 style="text-align:center;">There Is 0 (ZERO) Available</h2>
</div>

@include('dims.sales-order.partials.createorderoncalllist')

<div id="emailDoc" title="Email Document">
    <label>From :</label> <input id="yourEmail" name="yourEmail"><br>
    <label>To :</label> <input id="customerEmail" name="customerEmail">
    <button id="emailthis" class="btn-md btn-success">Send</button>
</div>

@include('dims.sales-order.partials.salesmandialog')

@include('dims.sales-order.partials.routingdialog')

@include('dims.sales-order.partials.brandedorderno')

<div id="splitOrder" title="Split Order">
    <div class="col-md-12">
        <table id="tblSplitOrder" class="table2 table-bordered">
            <thead>
                <tr>
                    <th class="col-md-1">Code</th>
                    <th class="col-md-3">Description</th>
                    <th>Ordered</th>
                    <th>Available</th>
                    <th>On Hand</th>
                    <th>Back</th>
                    <th>Selected</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
            <button id="cancelsplit" class="btn-md">CANCEL</button>
        </div>
        <div class="col-md-6">
            <button id="dosplit" class="btn-md btn-success">SPLIT</button>
        </div>
    </div>
</div>

<div id="exceeded" title="Exceeds Available Quantity">

    <h5>Certain lines exceed the available quantity,do you wish to split this order?</h5>
    <div class="col-md-12">
        <div class="col-md-6"><button id="yestosplit" class="btn-md btn-success"
                style="width: 70px;">Yes</button></div>
        <div class="col-md-6"><button id="notosplit" class="btn-md btn-danger" style="width: 70px;">No</button>
        </div>
    </div>
</div>

@include('dims.sales-order.partials.qtyzero')

@include('dims.sales-order.partials.marginproblems')

@include('dims.sales-order.partials.zeroprice')

<div title="Processing Receipt" id="processingpos">
    <h2 style="color:green">Please wait .........</h2>

</div>

<div id="generaldialog">
    <h3 id="appengeneralmsg"></h3>
    <input type="hidden" id="appengeneralmsgval" value="">
    <button id="submitgenmsg">OKAY</button>
</div>

<div title="Check the Delivery date" id="checkdeliverydate">
    <h2>Please make sure your delivery date is correct.</h2>
    <button class="btn-lg btn-primary" id="delvokay">OK</button>

</div>

@include('dims.sales-order.partials.authonholdaccount')

@include('dims.sales-order.partials.addcostdialog')

<div title="ITEMS WITH ZERO COST" id="authItemsWithzerocosts">
    <h2>PLEASE AUTHORIZE ITEMS WITH ZERO COST</h2>
    <form>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="zerocostmanagername"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label><br>
            <input class="" id="zerocostmanagername" name="zerocostmanagername"
                style="height:30px;font-size: 10px;" autocomplete="off" value="-">
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="zerocostmanagerpassword"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label><br>
            <input type="password" name="zerocostmanagerpassword" class="" id="zerocostmanagerpassword"
                style="height:30px;font-size: 10px;" autocomplete="off" value="-">
        </div><br>
        <div>
            <button type="button" id="doAuthZerocost" class="btn-success btn-xs pull-right"
                style="margin-top: 29px;margin-right: 15px;">Authorise</button>
        </div>
        <div class="form-group  col-md-12">
            <table>
                <tbody id="productwithzerocost">

                </tbody>
            </table>

            <button type="button" id="cancelzerocostdialod" class="btn-danger btn-xs pull-right"
                style="margin-top: 29px;margin-right: 15px;">Cancel</button>

        </div>
    </form>
</div>

<div title="Item having less stock" id="itemoutofstock">
    <h2>These lines exceeds the available qty.</h2>
    <form>
        <div class="form-group  col-md-12">
            <table class="table2 table-bordered  dataTable">
                <thead>
                    <tr>
                        <td>Item Code</td>
                        <td>Item Name</td>
                        <td>Ordered</td>
                        <td>Available</td>
                        <td>On Hand</td>
                        <td>Back</td>
                        <td>Select</td>
                    </tr>
                </thead>
                <tbody id="griditemoutofstock">

                </tbody>
            </table>
            <button type="button" id="cancelsplitorder" class="btn-danger btn-xs pull-left"
                style="margin-top: 29px;margin-right: 15px;">Cancel</button>
            <button type="button" id="splitorder" class="btn-danger btn-xs pull-right"
                style="margin-top: 29px;margin-right: 15px;">SPILT </button>
        </div>
    </form>
</div>

<div title="Zero Pricing" id="itemseithzeropricing">
    <h2>These lines have zero pricing, please authorize.</h2>
    <form>

        <div class="form-group  col-md-12">
            <table class="table2 table-bordered  dataTable">
                <thead>
                    <tr>
                        <td>Item Code</td>
                        <td>Item Name</td>
                        <td>Price</td>
                        <td>GP</td>
                    </tr>
                </thead>
                <tbody id="griditemzeropricing">

                </tbody>
            </table>

            <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="zeropricingname"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label><br>
                <input class="" id="zeropricingname" name="zeropricingname"
                    style="height:30px;font-size: 10px;" autocomplete="off" value="-" />
            </div>
            <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="zeropricingpassword"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label><br>
                <input type="password" name="zeropricingpassword" class="" id="zeropricingpassword"
                    style="height:30px;font-size: 10px;" autocomplete="off" value="-">
            </div><br>
            <div>
                <button type="button" id="doAuthzeropricing" class="btn-success btn-xs pull-right"
                    style="margin-top: 29px;margin-right: 15px;">Authorise</button>
            </div>

        </div>
    </form>
</div>

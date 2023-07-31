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

<div id="listOfDelivAdress" title="Delivery Address" style="display: flex;">
    <div class="col-lg-12">
        <div class="col-lg-4">
            <div class="form-group">
                <label class="control-label" for="generalRouteForNewDeliveryAddress"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                <select id="generalRouteForNewDeliveryAddress"
                    class="form-control input-sm col-xs-1 generalRouteForNewDeliveryAddress">
                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="address1"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 1</label>
                <input class="form-control input-sm col-xs-1" id="address1" name="address1">
            </div>
            <div class="form-group">
                <label class="control-label" for="address2"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 2</label>
                <input class="form-control input-sm col-xs-1" id="address2" name="address2">
            </div>
            <div class="form-group">
                <label class="control-label" for="address3"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 3</label>
                <input class="form-control input-sm col-xs-1" id="address3" name="address3">
            </div>
            <div class="form-group">
                <label class="control-label" for="address4"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 4</label>
                <input class="form-control input-sm col-xs-1" id="address4" name="address4">
            </div>
            <div class="form-group">
                <label class="control-label" for="address5"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 5</label>
                <input class="form-control input-sm col-xs-1" id="address5" name="address5">
                <input type="hidden" id="deliveryAddressIdOnPopUp" name="deliveryAddressIdOnPopUp" value="">
            </div>
            <div class="form-group">
                <label class="control-label" for="salesPerson"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">SalesPerson</label>
                <select class="form-control input-sm col-xs-1" id="salesPerson">
                </select>
            </div>
            <button type="button" id="doneCustomAddress" class="btn-success doneCustomAddress">Done</button>

        </div>
        <div class="col-lg-8">
            <input type='text' id='txtList' onkeyup="filter(this)" class="form-control"
                placeholder="Please search address here..." />
            <hr style="margin-top: 15px;margin-bottom: 15px;border: 0;border-top: 5px solid #00ff00;" />
            <div>
                <ul id="listaddresses" style="font-size: 9px;list-style-type: none;overflow-y: auto;height:300px">
                </ul>
            </div>

        </div>
        <div class="col-lg-12" id="dynamicaddress" style="background: #f8f8f8;">
            <form>
                <table class="table table-bordered table-condensed">
                    <tr>
                        <td>
                            <label class="control-label">Route</label>
                            <select name="AddressAddSelect" id="AddressAddSelect" style="font-size: 9px;">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><input style="height: 20px;" name="Address1Add" id="Address1Add"
                                placeholder="Please type address1 "></td>
                        <td><input style="height: 20px;" name="Address2Add" id="Address2Add"
                                placeholder="Please type address2 "></td>
                        <td><input style="height: 20px;" name="Address3Add" id="Address3Add"
                                placeholder="Please type address3 "></td>
                        <td><input style="height: 20px;" name="Address4Add" id="Address4Add"
                                placeholder="Please type address4 "></td>
                        <td><input style="height: 20px;" name="Address5Add" id="Address5Add"
                                placeholder="Please type address5 "></td>
                        <td>
                            <select name="salesPersonOnDynamic" id="salesPersonOnDynamic"
                                style="font-size: 9px;height: 20px;" placeholder="Sales Person"></select>
                        </td>
                        <td><button type="button" id="AddressAddMakeNew" class="btn-xs btn-warning ">Add</button>
                        </td>
                    </tr>
                </table>
            </form>
            <table class="table" id="generateDynamicAddress" style="background: #f5e5e5;font-size: 9px;">
                <tr>
                    <th></th>
                    <th>Route</th>
                    <th>Address1</th>
                    <th>Address2</th>
                    <th>Address3</th>
                    <th>Address4</th>
                    <th>Address5</th>
                    <th>Sales Person</th>
                    <th></th>
                </tr>
            </table>
        </div>
    </div>
</div>

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

<div id="creditLimitAuth" title="Credit Limit Authorisation" style="background:rgba(0,0,255,0.31)">
    <div id="appendErrormsgCreditLimit" style="background: white;font-size:10px">
    </div>
    <form>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthNamecrLimit"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
            <input class="form-control input-sm col-md-4 auto-complete-off" name="userAuthNamecrLimit"
                id="userAuthNamecrLimit" style="height:30px;font-size: 10px;">
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthPassWordcrLimit"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
            <input type="password" name="userAuthPassWordcrLimit"
                class="form-control input-sm col-md-4 auto-complete-off" id="userAuthPassWordcrLimit"
                style="height:30px;font-size: 10px;" readonly onfocus="$(this).removeAttr('readonly');">
        </div>
        <div>
            <div class="form-group  col-md-4"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;display:none;">
                <label class="control-label" for="userNewVariable"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Value</label>
                <input type="text" name="userNewVariablecrLimit" class="form-control input-sm col-md-4"
                    id="userNewVariablecrLimit" style="display:none;height:30px;font-size: 10px;" value="0"
                    readonly>
            </div>
        </div>
        <button type="button" id="doAuthcrLimit" class="btn-success btn-xs pull-right"
            style="margin-top: 29px;margin-right: 15px;">Authorise</button>
        <button type="button" id="cancelWithoutSaving" class="btn-warning btn-xs pull-right"
            style="margin-top: 29px;margin-right: 15px;">Cancel Without Saving</button>
    </form>
</div>

@include('dims.sales-order.partials.reprintauth')

@include('dims.sales-order.partials.authdropdowns')

@include('dims.sales-order.partials.authdropdownsclosedroutepass')

@include('dims.sales-order.partials.addnewaddress')

@include('dims.sales-order.partials.multipledeliveriesonthesamedate')

<div id="copyOrdersMenu" title="Copy Order">
    <div class="col-lg-12">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 pull-right" id="orderinfoAddress" style="font-size: 10px;">
                    <div>
                        <form>
                            <div class="form-group  col-md-4"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="custDescToCopyFrom"
                                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Cust Desc</label>
                                <input type="text" class="form-control input-sm col-md-4 auto-complete-off"
                                    name="custDescToCopyFrom" id="custDescToCopyFrom"
                                    style="height:30px;font-size: 10px;">
                            </div>
                            <div class="form-group  col-md-4"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="custCodeToCopyFrom"
                                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Cust Code</label>
                                <input type="text" name="custCodeToCopyFrom"
                                    class="form-control input-sm col-md-4 auto-complete-off" id="custCodeToCopyFrom"
                                    style="height:30px;font-size: 10px;">
                            </div>
                            <div class="form-group  col-md-4">
                                <label class="control-label" for="orderIdToCopy"
                                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Id</label>
                                <select class="form-control input-sm col-md-4" id="orderIdToCopy"> </select>
                            </div>
                            <div class="form-group  col-md-4">
                                <label class="control-label" for="orderDateToCopy"
                                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Date</label>
                                <input type="text" name="orderDateToCopy" class="form-control input-sm col-md-4"
                                    id="orderDateToCopy" style="height:30px;font-size: 10px;">
                            </div>
                            <div class="form-group  col-md-4">
                                <label class="control-label" for="delvDateToCopy"
                                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delv Date</label>
                                <input type="text" name="delvDateToCopy" class="form-control input-sm col-md-4"
                                    id="delvDateToCopy" style="height:30px;font-size: 10px;">
                            </div>

                            <!--<button type="button" id="doAuthcrLimit" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;display:none">Go</button>-->
                            <button type="button" id="doAuthcrLimit2" class="btn-success btn-xs pull-right"
                                style="margin-top: 29px;margin-right: 15px;display:none">Go</button>
                        </form>
                    </div>
                    <div class="col-lg-12" style="background: beige;height: 250px;">
                        <table class="table" id="tableOrdersDetailsToCopy">
                            <thead>
                                <th>Item Code</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Comment</th>
                                <th>Select</th>
                            </thead>
                        </table>
                        <button id="doneDetailsToCopy" class="btn-success btn-xs">Done Selecting</button>
                    </div>
                </div>
                <div class="col-xs-6" id="orderinfo" style="font-size: 10px;">
                    <h4>Select customer to copy orders to</h4>
                    <button class="btn-warning btn-xs" id="addCustomer">Add New Line</button>
                    <div style="height:300px;overflow-y: auto">
                        <table class="table table-bordered table-condensed"
                            style="font-family: sans-serif;color:black" id="customerToPick">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Customer Name</th>
                                    <th>Delivery Address</th>
                                    <th>Order Types</th>
                                    <th>Order Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <button class="btn-success btn-xs" id="startCopying">Start Copying</button>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="copyingOrderProgress" title="Copying Order">
</div>

@include('dims.sales-order.partials.salesoemail')

@include('dims.sales-order.partials.useractiongrid')

@include('dims.sales-order.partials.temp-delivery-address-on-the-fly')

<div id="priceLookPriceWithCustomer" title="Price Look on Customer">
    <div class="col-lg-12" style="line-height: 0.88;">
        <form>
            <fieldset class="well">

                <legend class="well-legend">Search</legend>
                <div class="col-md-12">
                    <div class="form-group col-md-4">
                        <label class="control-label" for="productCodePl"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Product Code</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="productCodePl"
                            style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label" for="productDescPl"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Product Desc</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="productDescPl"
                            style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        <input type="hidden" class="form-control input-sm col-xs-1" id="prodId">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group col-md-4">
                        <label class="control-label" for="custCodePl"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Code</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="custCodePl"
                            style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label" for="custDescPl"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Desc</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="custDescPl"
                            style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        <input type="hidden" class="form-control input-sm col-xs-1" id="custId">
                    </div>
                    <div class="form-group col-md-4">
                        <button type="button" id="goOnPL" class="btn-xs btn-success"
                            style="background: deeppink;border-color: deeppink;">GO</button>
                    </div>
                </div>

            </fieldset>
        </form>
    </div>
    <div class="col-md-12" style="background: #fcf6f6;">
        <p style="text-align: center;background: #f5c485;">Unit Of Sale <strong><i id="unitOfSale"></i></strong></p>
        <table class="table" id="individualPriceCheckByCustomer" style="width:100%">
            <thead>
                <tr>
                    <th>Price Incl</th>
                    <th>Price Exc</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="col-md-12">
        <table class="table" id="individualCost" style="width:100%">
            <thead>
                <tr>
                    <th>Cost</th>
                    <th>Remaining</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="col-md-12" style="background: #32cd32;">
        <div class="col-md-6">
            <table class="table" id="priceCheckByCustomer" style="width:100%">
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
            <table class="table" id="currentCustomerPrices" style="width:100%">
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

@include('dims.sales-order.partials.delivery-address-on-orderwithout-inoiceno')

@include('dims.sales-order.partials.tamaracalculator')

<div id="pointOfSaleDialog" title="Point Of Sale">
    <div class="col-md-12">
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                    <th>Tender Type</th>
                    <th>Amount</th>
                </thead>
                <tbody style=" font-weight: 900;color:#1d1d1d">
                    <tr>
                        <td>Cash</td>
                        <td><input type="text" id="posPayMentTypeCash" value="0"
                                onkeypress="return isFloatNumber(this,event)" class="onPosAmount"></td>
                    </tr>
                    <tr>
                        <td>Account</td>
                        <td><input type="text" id="posPayMentTypeAccount" value="0"
                                onkeypress="return isFloatNumber(this,event)" class="onPosAmount"></td>
                    </tr>
                    <tr>
                        <td>Credit Card</td>
                        <td><input type="text" id="posPayMentTypeCreditCard" value="0"
                                onkeypress="return isFloatNumber(this,event)" class="onPosAmount"></td>
                    </tr>
                    <tr>
                        <td>Cheque</td>
                        <td><input type="text" id="posPayMentTypeCheque" value="0"
                                onkeypress="return isFloatNumber(this,event)" class="onPosAmount"></td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="col-md-6" style="background: #ede5e5;padding: 9px;">
            <table class="table">

                <tbody>
                    <tr style=" font-weight: 900;color:black">
                        <td>Order Number</td>
                        <td><input type="text" id="posOrdernumber" readonly></td>
                    </tr>
                    <tr style=" font-weight: 900;color:purple">
                        <td>Invoice Total</td>
                        <td><input type="text" id="posInvTotal" readonly></td>
                    </tr>
                    <tr style=" font-weight: 900;color:blue">
                        <td>Total Tendered</td>
                        <td><input type="text" id="posTotalTendered" readonly></td>
                    </tr>
                    <tr style=" font-weight: 900;color:saddlebrown">
                        <td>Cash Tendered</td>
                        <td><input type="text" id="posCashTendered" readonly></td>
                    </tr>
                    <tr style=" font-weight: 900;color:darkgreen">
                        <td>Change</td>
                        <td><input type="text" id="posChange" readonly></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12">
        <button class="btn-md btn-danger pull-left">Cancel</button>
        <button class="btn-md btn-success pull-right" id="confirmOnPosDialog">Confirm</button>
    </div>
</div>

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

<div title="Additional Cost" id="addcostdialog">
    <table class="table2 table-bordered" id="additionalcost">
        <thead>
            <tr>
                <th>Item Code</th>
                <th>Item Description</th>
                <th>QTY</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
    </table>
</div>

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

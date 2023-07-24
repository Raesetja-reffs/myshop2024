@extends('layouts.app')

@section('content')
    <div class="container" style="width: 100%;">

        <div class="row">
            <div class="col-lg-12 text-center">

            </div>
            <div class="col-lg-12  visible-md visible-lg" style="line-height: 0.9">
                <div class="col-lg-4">
                    <form>
                        <fieldset class="well" style="background:#8BC34A">
                            <legend class="well-legend">Search</legend>
                            <div class="form-group col-md-4" style="display:none;">
                                <label class="control-label" for="inputOrderId"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Inv No</label>
                                <input type="text" class="form-control input-sm col-xs-1" id="invoiceNo" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                                <input type="hidden"  id="invoiceNoKeeper" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                            </div>
                            <div class="form-group col-md-4" >
                                <label class="control-label" for="inputOrderId"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Return Id</label>
                                <input type="text" class="form-control input-sm col-xs-1" id="orderId" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                            </div>
                            <button type="button" id="checkOrders" class="btn-xs btn-info">Check</button>
                            <button type="button" id="quoteListing" class="btn-xs btn-warning">View List</button>
                        </fieldset>
                    </form>

                </div>
                <fieldset class="well">
                    <legend class="well-legend">Create New Quotation</legend>
                    <form>
                        <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                            <label class="control-label" for="inputOrderId"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Type</label>
                            <select class="form-control input-sm col-xs-1" id="orderType" style="height:26px;font-size: 10px;"></select>
                        </div>
                        <div class="form-group  col-md-2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                            <label class="control-label" for="inputCustAcc"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Account</label>
                            <input type="text" name="custCode" class="form-control input-sm col-xs-1" id="inputCustAcc" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
                            <input type="hidden" name="hiddenCustomerNotes" class="form-control input-sm col-xs-1" id="hiddenCustomerNotes" >
                            <input type="hidden" name="hiddenRouteId" class="form-control input-sm col-xs-1" id="hiddenRouteId" >
                            <input type="hidden" name="hiddenRouteName" class="form-control input-sm col-xs-1" id="hiddenRouteName" >
                        </div>

                        <div class="form-group col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                            <label class="control-label" for="inputCustName"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Name</label>
                            <input type="text" name="custDescription" class="form-control input-sm col-xs-1" id="inputCustName" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
                            <input type="hidden" name="customerEmail" class="form-control input-sm col-xs-1" id="customerEmail" >
                            <input type="hidden" name="Routeid" class="form-control input-sm col-xs-1" id="Routeid" >
                            <input type="hidden" name="hiddenCustDiscount" class="form-control input-sm col-xs-1" id="hiddenCustDiscount" >
                        </div>
                        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                            <label class="control-label" for="inputOrderDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date From</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="inputOrderDate" style="font-weight: 900;    color: black;font-size: 13px;">
                        </div>
                        <div class="form-group col-md-2 "  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                            <label class="control-label" for="inputDeliveryDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date To</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="inputDeliveryDate" style="font-weight: 900;    color: black;font-size: 13px;">

                        </div>

                        <button type="button" id="submitFilters" class="btn-xs btn-primary">Submit</button>


                    </form>
                </fieldset>
            </div>
            <div class="col-md-12 visible-md visible-lg" >

                <div class="panel panel-default hidebody" id="toAutoScroll" style="height: 44%;min-height: 200px;overflow-y:auto;" >
                    <div id="two-columns" class="grid-container" style="display:none;">
                        <button type="button" id="button_row" class="btn-xs btn-success">Add</button>

                        <input type="checkbox" id="checkboxDescription" >Description
                        <input type="checkbox" id="checkboxCode" >Code
                        <button type="button" id="button_user_actions" class="btn-xs btn-info pull-right">User Actions</button>
                        <table id="table" class="table table-bordered table-condensed" style="font-family: sans-serif;color:black">
                            <thead>
                            <tr>

                                <th>Code</th>
                                <th class="col-md-4">Description</th>
                                <th class="col-md-1">Qty</th>
                                <th style="display: none;" class="col-md-1">Bulk</th>
                                <th class="col-md-1">Margin(%)</th>
                                <th class="col-md-1">Deal Price</th>
                                <th class="col-md-1">Prd.O.Price</th>
                                <th class="col-md-1">Cost</th>

                                <th style="display: none;" class="col-md-1">Disc %</th>
                                <th class="col-md-1">UOM</th>
                                <th class="col-md-1">Stk</th>
                                <th class="col-md-3">DateFrom...</th>
                                <th class="col-md-3">DateTo.....</th>
                                <th class="col-md-3">Comment</th>
                                <th class="col-md-1 table-header">Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div><h6 id="numberOfLines" style=" margin-bottom: 0px !important;" class="hidebody">0 Lines</h6>
                <div class="col-md-0 pull-right hidebody" style="line-height: 1.1;">
                    <h5 id="availableOnTheFly" > </h5>
                    <fieldset class="well">
                        <legend class="well-legend">Totals</legend>
                        <table class="table table-condensed-footer">
                            <tr>
                                <td>Exc</td>
                                <td><input id="totalEx" ></td>
                                <td>Inc</td>
                                <td><input id="totalInc"></td>
                            </tr>
                        </table>
                    </fieldset>
                    <div style="color:black;font-weight: 900;">Total Margin %<input type="text" id="totalmargin" class="form-control input-xs col-xs-1"  readonly style="height:13px"></div>
                    <div style="color:black;font-weight: 900;">Discount %<input type="text" id="dicPercHeader" class="form-control input-xs col-xs-1" onkeypress="return isFloatNumber(this,event)" readonly style="height:13px"></div>
                    <button id="invoiceNow" name="invoiceNow" class="btn-xs btn-danger" style=" width: 115px;display:none;">Print</button>
                    <button id="reprintInvoice" name="reprintInvoice" class="btn-xs btn-success" style=" width: 115px;display:none;">Re-Print</button>
                    <button id="convertToOrder" name="convertToOrder" class="btn-xs btn-success" >Convert To Sales Order</button>
                    <div class="col-md-12" style="padding:0px;margin-top: 1%;">
                        <p id="creditLimitWarningMessage" style="color:red;font-family: monospace;    font-size: 12px;">
                        </p><input type="hidden" name="creditLimitApproved" id="creditLimitApproved" value="">
                        <input type="text" name="boozeLisence" id="boozeLisence" class="form-control input-sm col-xs-1" value="" style="height:13px" readonly>

                        <input type="hidden" name="boozeChecked" id="boozeChecked" class="form-control input-sm col-xs-1" value="">
                    </div>
                    <input type="checkbox" name="awaitingStock" id="awaitingStock" value="0">Awaiting Stock
                    <div style="display:none;">
                        <table class="table" style="font-size: 10px;font-weight: 900;color: black;">
                            <tr>
                                <td>Contact Cell</td>
                                <td><input id="contactCellOnDispatch" class="form-control input-sm col-xs-1"></td>
                            </tr>
                            <tr>
                                <td>Contact Person</td>
                                <td><input id="contactPersonOnDispatch" class="form-control input-sm col-xs-1"></td>
                            </tr>
                            <tr>
                                <td>Tel</td>
                                <td><input id="telOnDispatch" class="form-control input-sm col-xs-1"></td>
                            </tr>
                        </table>
                    </div>
                    <h5 id="nbNotes" style="color:red;"></h5>
                </div>
                <div class="col-md-4 hidebody" style="line-height: 1.1;padding-left: 0px;">
                    <div class="form-group hidebody"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="messagebox"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Message</label>
                        <input type="text" name="message" id="messagebox" class="form-control input-sm col-xs-1" value="" >
                    </div>
                    <div class=" col-md-12"    style="padding-left: 0px;">
                        <label class="control-label" for="orederNumber"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Reference Number</label>
                        <input type="text"   id="orederNumber" maxlength="18" style="font-weight: 900;color: black;"><span id="characters"></span>/18
                        <input type="hidden" name="hiddenDeliveryAddressId" id="hiddenDeliveryAddressId">
                        <input type="hidden" name="address1hidden" id="address1hidden">
                        <input type="hidden" name="address2hidden" id="address2hidden">
                        <input type="hidden" name="address3hidden" id="address3hidden">
                        <input type="hidden" name="address4hidden" id="address4hidden">
                        <input type="hidden" name="address5hidden" id="address5hidden">
                    </div>

                    <div>
                        <h5>Delivery Address</h5>
                        <div  style="display: none;">
                            <button class="btn-xs btn-warning " id="changeDeliveryAddress" type="button" >Change</button>
                            <button class="btn-xs btn-warning " id="makeNewDelivAddress" type="button" >New</button>
                        </div>
                        <div style="background: white;">
                            <i class="fa fa-plus-square" aria-hidden="true" id="addANewDelvAddressOnModal"></i>
                            <textarea id="customerSelectedDelDate" style="height: 52px;width:100%;font-size: x-small;color: black;font-weight: 700;"></textarea>
                            <i style="font-size: 11px;font-weight: 700;color: black;" id="tempDelivAddressClosethis">Press <button id="tempDelivAddress">here</button> to create a temp delivery address </i>
                            <button class="btn-md btn-warning" id="changeDeliveryAddressOnNotInvoiced">Change Delivery Address</button>
                        </div>

                    </div>

                </div>
                <button type="button" id="finishOrder" class="btn-xs btn-primary hidebody" style=" width: 115px;">Finish</button>


                <div class="col-md-12 " style="margin-top: 7px;" >

                    <button type="button" id="abilityToEmailOrder" class="btn-xs btn-warning " style=" width: 115px;">Email Order</button>
                    <button type="button" id="copyThisOrder" class="btn-xs btn-warning " style=" width: 115px;display:none">Copy Order</button>
                    <button type="button" id="printDocument" class="btn-xs btn-primary " style="display:none; width: 115px;display:none">Print</button>
                </div>
            </div>
            <div style="display:none !important;">
                <div  style="background: #999;height:50px">
                    <form>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="codeSearch"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                            <select class="form-control input-sm col-xs-1" name="routeName" id="routeName" style="font-weight: 900;height:25px;font-size: 10px;color: black;">
                            </select>

                        </div>
                        <div class="form-group col-md-3" id="deprecated_cangeDate">
                            <label class="control-label" for="descriptionSearch"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delv Date</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="changeDelvDate" style="height:25px;font-size: 10px;">
                        </div>
                        <div class="form-group col-md-2" style="display:none;">
                            <label class="control-label" for="creditLimit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">CR Limit</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="creditLimit" style="    font-weight: 900;color: black;height:25px;font-size: 9px;display: inline;width: 70px;font-family: sans-serif;" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label" for="balDue"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">BalDue</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="balDue" style="    font-weight: 900;color: black;height:25px;font-size: 10px;display: inline;width: 78px;font-family: sans-serif;" readonly>
                        </div>
                    </form>
                </div>
                <div class="panel panel-default">
                    <div id="two-columns" class="grid-container" style="display:block;">
                        <ul class="rig columns-1">
                            <li style=" width: 97%;font-family: sans-serif">
                                <div class="tab-frame" >
                                    <input type="radio" checked name="tab" id="tab1">
                                    <label for="tab1">Pattern</label>

                                    <input type="radio" name="tab" id="tab2">
                                    <label for="tab2" style="display:none;" >Specials</label>
                                    <input type="radio" name="tab" id="tab3">
                                    <label for="tab3" style="display:none;">Invoices</label>
                                    <!-- <input type="radio" name="tab" id="tab4">
                                     <label for="tab4">Prices</label>-->


                                    <div class="tab" style="overflow-y: scroll;height:56%">
                                        <div style="display: block !important;">
                                            <table class="table search-table" id="orderPatternIdTable" style="overflow-y: scroll; width: 100%;font-family: sans-serif;height:62% !important;">
                                                <thead>

                                                <tr >
                                                    <th class="col-md-8" >Description</th>
                                                    <th class="col-xs-1">2Week</th>
                                                    <th class="col-xs-1">Avg</th>
                                                    <th class="col-xs-1">InStock</th>
                                                    <th class="col-xs-1">Cost</th>
                                                    <th class="col-xs-1" >T</th>
                                                    <th class="col-xs-1 " >Auth</th>
                                                    <th class="col-xs-1 " >Code</th>
                                                    <th class="col-xs-1 " >Push</th>
                                                    <th class="col-xs-1 " >Tax</th>
                                                    <th class="col-xs-1 " >Unit</th>
                                                </tr>
                                                </thead>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="tab" style="overflow-y: scroll;height:56%">
                                        <div class="col-lg-12 " style="height: 46%;overflow-y:auto;padding: 0px;">
                                            <h5>Customer Special Pricing</h5>
                                            <table id="customerSpecials" class="table" style=" width: 100%;font-family: sans-serif;">

                                                <tr style="font-size: 10px;" >
                                                    <th>Item</th>
                                                    <th>Code</th>
                                                    <th>Price</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th></th>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-lg-12 " style="height: 46%;overflow-y:auto;background: lightcyan;padding: 0px;">
                                            <h5>Group Special Pricing</h5>
                                            <table id="groupSpecials" class="table" style=" width: 100%;font-family: sans-serif;">

                                                <tr style="font-size: 10px;" >
                                                    <th>Item</th>
                                                    <th>Price</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th></th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab" style="overflow-y: scroll;height:56%">
                                        <table id="pastInvoices" class="table" style="    font-weight: 700;color: #062a04; width: 100%;font-family: sans-serif;">
                                            <tr style="font-size: 9px;" >
                                                <th>Invoice No</th>
                                                <th>Order date</th>
                                                <th>Delivery Date</th>
                                                <th>Ref</th>
                                                <th style="width:1px"></th>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="tab col-lg-12" style="background: #e3e3e3;display:none">
                                        <div>
                                            <form>
                                                <fieldset class="well">
                                                    <legend class="well-legend">Search</legend>
                                                    <div class="form-group col-md-4">
                                                        <label class="control-label" for="codeSearch"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Code</label>
                                                        <input type="text" class="form-control input-sm col-xs-1" id="codeSearch" style="height:25px;font-size: 10px;display: inline;">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label" for="descriptionSearch"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Description</label>
                                                        <input type="text" class="form-control input-sm col-xs-1" id="descriptionSearch" style="height:25px;font-size: 10px;display: inline;width: 150px;">
                                                    </div>

                                                </fieldset>
                                            </form>
                                            <table class="table" id="priceLookUpResult">
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                </div></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="dialog" title="Quatatios" style="background: darkgoldenrod;">
        <div class="col-lg-12">
            <div>
                <button id ="refreshOrderListing" class="btn-primary btn-xs" ><i class="icon-refresh"></i> Refresh</button>
                <form style=" height: 64px;    background: lightgrey;">
                    <div class="form-group col-md-2">
                        <label class="control-label" for="invoiceNoOrderListing"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Inv No</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="invoiceNoOrderListing" style="height:15px;font-size: 10px;">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label" for="orderIdOrderListing"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Id</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="orderIdOrderListing" style="height:15px;font-size: 10px;">
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label" for="customerCodeOrderListing"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Cust Code</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="customerCodeOrderListing" style="height:15px;font-size: 10px;">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label" for="customerDescriptionOrderListing"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Cust Desc</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="customerDescriptionOrderListing" style="height:15px;font-size: 10px;">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label" for="deliveryDateOrderListing"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Del Date</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="deliveryDateOrderListing" style="height:15px;font-size: 10px;">
                    </div>
                    <button type="button" id="passFiltersOnOrderListing" class="btn-xs btn-success">Go</button>

                </form>
            </div>
            <div class="col-lg-12" style="">
                <table class="table2 table-bordered" id="createdOrders" style="overflow-y: auto;width:100%;color: black;    font-weight: 700;">
                    <thead>
                    <tr>
                        <th class="col-sm-1">OrderId</th><th class="col-sm-1">Invoice no</th><th class="col-sm-1">Cust Code</th><th>Cust Name</th><th>Order Types</th><th>Route</th><th>Delivery Date</th><th>Order Date</th><th>Reference No</th></tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
    <div id="dialog2" title="Price Check">
        <div class="col-lg-12">
            <form>
                <div class="form-group col-md-4">
                    <label class="control-label" for="productCodeSearchPrice"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Code</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="productCodeSearchPrice" style="height:15px;font-size: 10px;">
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label" for="productDescriptionSearchPrice"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Description</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="productDescriptionSearchPrice" style="height:15px;font-size: 10px;">
                </div>

            </form>
            <div class="col-lg-12">
                <table class="table" id="priceCheckingOnCall" style="width:100%">
                    <thead>
                    <tr>
                        <th>Price List</th><th>Price</th><th>Price Inc</th></tr>
                    </thead>

                </table>
                <div style="width: 50%;float: right;background: darkseagreen;">
                    <table class="table" id="appendQtyOnHand">

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="callListDialog" title="Call List">
        <div class="col-lg-12">
            <form>
                <div class="form-group col-md-3">
                    <label class="control-label" for="callListOrderDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Date</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="callListOrderDate" style="font-size: 10px;">
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label" for="callListDeliveryDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="callListDeliveryDate" style="font-size: 10px;">
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label" for="callListUser"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">User</label>
                    <select class="form-control input-sm col-xs-1" name="callListUser"  id="callListUser"  >
                        <option value="" ></option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label" for="routeToFilterWith"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                    <select class="form-control input-sm col-xs-1"   name="routeToFilterWith" id="routeToFilterWith">
                        <option value="" ></option>
                    </select>
                </div>
                <button type="button" id="passCallistFilter" class="btn-xs btn-success">Go</button>
            </form>
            <div class="col-lg-12" style="height:400px; overflow-y:scroll;">
                <table class="table2 table-bordered" id="callListTable" style="overflow-y: auto;width:100%">
                    <thead>
                    <tr>
                        <th>Code</th><th>Description</th><th>Call</th>
                        <th>Buyer</th><th>Buyer Tel</th><th>Buyer Cell</th><th>Route</th>
                        <th>Account Contact</th><th>Address</th>
                    </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
    <div id="tabletLoading" title="Tablet Loading">
        <div class="col-lg-12">
            <form >
                <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="deliveryDates"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                    <select class="form-control input-sm col-xs-1" id="deliveryDates" style="height:30px;font-size: 10px;"></select>

                </div>
                <div class="form-group  col-md-2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="orderTypesTabletLoading"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Type</label>
                    <select name="custCode" class="form-control input-sm col-xs-1" id="orderTypesTabletLoading" style="height:30px;font-size: 10px;"></select>
                </div>
                <div class="form-group col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="rouTabletLoadingtes"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                    <select name="custDescription" class="form-control input-sm col-xs-1" id="rouTabletLoadingtes" style="height:30px;font-size: 10px;"></select>
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
            <input type="hidden" id="reprintOrderIdFromTablet" >
            <input type="hidden" id="reprintInvoiceFromTablet" >
        </div>
        <div class="col-lg-12">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6" id="orderinfoAddress" style="font-size: 10px;">
                        <img src="{{URL::asset('/images/logo.png')}}" />
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
        <div  class="col-lg-12">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="control-label" for="generalRouteForNewDeliveryAddress"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                    <select id="generalRouteForNewDeliveryAddress" class="form-control input-sm col-xs-1">
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="address1"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 1</label>
                    <input class="form-control input-sm col-xs-1" id="address1" name="address1">
                </div>
                <div class="form-group">
                    <label class="control-label" for="address2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 2</label>
                    <input class="form-control input-sm col-xs-1" id="address2" name="address2">
                </div>
                <div class="form-group">
                    <label class="control-label" for="address3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 3</label>
                    <input class="form-control input-sm col-xs-1" id="address3" name="address3">
                </div>
                <div class="form-group">
                    <label class="control-label" for="address4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 4</label>
                    <input class="form-control input-sm col-xs-1" id="address4" name="address4">
                </div>
                <div class="form-group">
                    <label class="control-label" for="address5"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 5</label>
                    <input class="form-control input-sm col-xs-1" id="address5" name="address5">
                    <input type="hidden" id="deliveryAddressIdOnPopUp" name="deliveryAddressIdOnPopUp" value="">
                </div>
                <div class="form-group">
                    <label class="control-label" for="salesPerson"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">SalesPerson</label>
                    <select class="form-control input-sm col-xs-1" id="salesPerson">
                    </select>
                </div>
                <button type="button" id="doneCustomAddress" class="btn-success">Done</button>

            </div>
            <div class="col-lg-8" >
                <input type='text' id='txtList' onkeyup="filter(this)" class="form-control"   placeholder="Please search address here..."/>
                <hr style="margin-top: 15px;margin-bottom: 15px;border: 0;border-top: 5px solid #00ff00;"/>
                <div >
                    <ul id="listaddresses" style="font-size: 9px;list-style-type: none;overflow-y: auto;height:300px"></ul>
                </div>

            </div>
            <div  class="col-lg-12" style="background: #f8f8f8;">
                <form>
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td>
                                <label class="control-label">Route</label>
                                <select name="AddressAddSelect" id="AddressAddSelect" style="font-size: 9px;" >
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td ><input style="height: 20px;" name="Address1Add" id="Address1Add" placeholder="Please type address1 "></td>
                            <td ><input style="height: 20px;" name="Address2Add" id="Address2Add" placeholder="Please type address2 "></td>
                            <td ><input style="height: 20px;" name="Address3Add" id="Address3Add" placeholder="Please type address3 "></td>
                            <td ><input style="height: 20px;" name="Address4Add" id="Address4Add" placeholder="Please type address4 "></td>
                            <td><input  style="height: 20px;" name="Address5Add" id="Address5Add" placeholder="Please type address5 "></td>
                            <td>
                                <select name="salesPersonOnDynamic" id="salesPersonOnDynamic" style="font-size: 9px;height: 20px;" placeholder="Sales Person"></select>
                            </td>
                            <td><button type="button" id="AddressAddMakeNew" class="btn-xs btn-warning ">Add</button></td>
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
            </div></div>
    </div>
    <div id='loadingmessage' style='display:none'>
        <img src="{{ asset('images/Rolling.gif') }}"/>
    </div>
    <div id="copyOrderDialog" title="Copying Order">
        <div class="col-lg-12">

            <form>
                <div class="form-group col-md-2">
                    <label class="control-label" for="copyDeliveryDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="copyDeliveryDate" style="font-size: 10px;">
                </div>
                <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="inputOrderId"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Type</label>
                    <select class="form-control input-sm col-xs-1" id="CopyorderType" style="font-size: 10px;"></select>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label" for="inputOrderId"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;"></label>
                    <input type="hidden" class="form-control input-sm col-xs-1" id="copyCustCode" style="font-size: 10px;">
                    <input type="hidden" class="form-control input-sm col-xs-1" id="copyRouteID" style="height:15px;font-size: 10px;">
                    <button type="button" id="submitCopyOrder" class="btn-xs btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <div id="copyOrderDialogComfirmation" title="Copied Items">
        <div class="col-lg-12" style="">
            <p>The Order has been copied with new order No </p>
            <strong class="newOrderId"></strong>
        </div>
    </div>

    <div id="authorisations" title="Please Authorise" style="background: #d03939;">
        <div id="appendErrormsg" style="background: white;font-size:10px">

        </div>
        <form>
            <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="userAuthName"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
                <input class="form-control input-sm col-md-4 auto-complete-off" name="userAuthName" id="userAuthName" style="height:30px;font-size: 10px;"></input>
            </div>
            <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="userAuthPassWord"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
                <input type="password" name="userAuthPassWord" class="form-control input-sm col-md-4 auto-complete-off" id="userAuthPassWord" style="height:30px;font-size: 10px;" readonly onfocus="$(this).removeAttr('readonly');" >
            </div>
            <div>
                <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;display:none;">
                    <label class="control-label" for="userNewVariable"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">New Val</label>
                    <input type="text" name="userNewVariable" class="form-control input-sm col-md-4" id="userNewVariable" style="height:30px;font-size: 10px;" value="0" readonly>
                </div>
            </div>
            <button type="button" id="doAuth" class="btn-success btn-xs" style="margin-top: 4%;">Authorise</button>
        </form>

        <button type="button" id="noThanksRedo" class="btn-warning btn-xs pull-right" style="margin-top: 10%;">No Thanks Redo the Line</button>

    </div>
    <div id="custLookUp" title="Price look up on order" style="background: darkorange;">
        <div class="col-lg-12">
            <div id="productSelectedForPriceListOrderForm"></div>
            <table class="table" id="customerDetailLookUp" style="width:100%">
                <thead>
                <tr>
                    <th>Price List</th><th>Price</th></tr>
                </thead>

            </table>
            <input type="text" id="lastprice" readonly>
        </div>
    </div>
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
                <label class="control-label" for="userAuthNamecrLimit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
                <input class="form-control input-sm col-md-4 auto-complete-off" name="userAuthNamecrLimit" id="userAuthNamecrLimit" style="height:30px;font-size: 10px;"></input>
            </div>
            <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="userAuthPassWordcrLimit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
                <input type="password" name="userAuthPassWordcrLimit" class="form-control input-sm col-md-4 auto-complete-off" id="userAuthPassWordcrLimit" style="height:30px;font-size: 10px;" readonly onfocus="$(this).removeAttr('readonly');" >
            </div>
            <div>
                <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;display:none;">
                    <label class="control-label" for="userNewVariable"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Value</label>
                    <input type="text" name="userNewVariablecrLimit" class="form-control input-sm col-md-4" id="userNewVariablecrLimit" style="display:none;height:30px;font-size: 10px;" value="0" readonly>
                </div>
            </div>
            <button type="button" id="doAuthcrLimit" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Authorise</button>
            <button type="button" id="cancelWithoutSaving" class="btn-warning btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Cancel Without Saving</button>
        </form>
    </div>

    <div id="reprintAuth" title="Please Authorise before using this action" style="background:rgba(0,0,255,0.31)">

        <form>
            <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="userAuthNameReprint"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
                <input class="form-control input-sm col-md-4 auto-complete-off" name="userAuthNameReprint" id="userAuthNameReprint" style="height:30px;font-size: 10px;"></input>
            </div>
            <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="userAuthPassWordReprint"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
                <input type="password" name="userAuthPassWordReprint" class="form-control input-sm col-md-4 auto-complete-off" id="userAuthPassWordReprint" style="height:30px;font-size: 10px;" readonly onfocus="$(this).removeAttr('readonly');" >
            </div>

            <button type="button" id="doAuthReprint" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Authorise</button>
        </form>
    </div>
    <div id="authDropDowns" title="Please Authorise before using this action" style="background:rgba(0,0,255,0.31)">
        <h4  style="color:red">BY CLICKING CANCEL THIS WILL GO BACK TO THE ORIGINAL DATA LOADED WITH THIS ORDER</h4>

        <form>
            <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="userAuthNameDropDown"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
                <input class="form-control input-sm col-md-4 auto-complete-off" name="userAuthNameDropDown" id="userAuthNameDropDown" style="height:30px;font-size: 10px;"></input>
            </div>
            <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="userAuthPassWordDropDown"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
                <input type="password" name="userAuthPassWordDropDown" class="form-control input-sm col-md-4 auto-complete-off" id="userAuthPassWordDropDown" style="height:30px;font-size: 10px;" readonly onfocus="$(this).removeAttr('readonly');" >
            </div>

            <button type="button" id="doAuthDropDown" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Authorise</button>
            <button type="button" id="doCancelAuthDropDown" class="btn-warning btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Cancel</button>
        </form>
    </div>



    <div id="addNewAddress" title="Add new address">
        <div class="col-lg-12">

            <table class="table table-bordered table-condensed" style="font-family: sans-serif;color:black" id="addNewAddressModal" >
                <thead>
                <tr>
                    <th>Address1</th><th>Address2</th>
                    <th>Address3</th><th>Address4</th>
                    <th>Address5</th>
                </tr>
                </thead>

            </table>
            <button id="addTableAddressToDB" class="btn-xs btn-success pull-right">Done</button>
        </div>
    </div>
    <div id="multipleDeliveriesOnTheSameDate" title="Orders">
        <div class="col-lg-12">
            <table class="table table-bordered table-condensed" style="font-family: sans-serif;color:black" id="multipleAddressesOnTheSameDateModal" >
                <thead>
                <tr>
                    <th>OrderId</th>
                    <th>Order Date</th>
                    <th>Delv Date</th>
                    <th>Route</th>
                    <th>Delivery Address</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
    <div id="copyOrdersMenu" title="Copy Order">
        <div class="col-lg-12">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 pull-right" id="orderinfoAddress" style="font-size: 10px;">
                        <div>
                            <form>
                                <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                    <label class="control-label" for="custDescToCopyFrom"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Cust Desc</label>
                                    <input type="text" class="form-control input-sm col-md-4 auto-complete-off" name="custDescToCopyFrom" id="custDescToCopyFrom" style="height:30px;font-size: 10px;">
                                </div>
                                <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                    <label class="control-label" for="custCodeToCopyFrom"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Cust Code</label>
                                    <input type="text" name="custCodeToCopyFrom" class="form-control input-sm col-md-4 auto-complete-off" id="custCodeToCopyFrom" style="height:30px;font-size: 10px;" >
                                </div>
                                <div class="form-group  col-md-4"  >
                                    <label class="control-label" for="orderIdToCopy"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Id</label>
                                    <select class="form-control input-sm col-md-4" id="orderIdToCopy" > </select>
                                </div>
                                <div class="form-group  col-md-4" >
                                    <label class="control-label" for="orderDateToCopy"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Date</label>
                                    <input type="text" name="orderDateToCopy" class="form-control input-sm col-md-4" id="orderDateToCopy" style="height:30px;font-size: 10px;">
                                </div>
                                <div class="form-group  col-md-4" >
                                    <label class="control-label" for="delvDateToCopy"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delv Date</label>
                                    <input type="text" name="delvDateToCopy" class="form-control input-sm col-md-4" id="delvDateToCopy" style="height:30px;font-size: 10px;">
                                </div>

                                <!--<button type="button" id="doAuthcrLimit" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;display:none">Go</button>-->
                                <button type="button" id="doAuthcrLimit2" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;display:none">Go</button>
                            </form></div>
                        <div class="col-lg-12" style="background: beige;height: 250px;">
                            <table class="table" id="tableOrdersDetailsToCopy" >
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
                            <table class="table table-bordered table-condensed" style="font-family: sans-serif;color:black" id="customerToPick">
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
    <div id="salesOEmail" title="Sales Order">
        <div class="col-lg-12">

            <form>
                <div class="form-group ">
                    <label class="control-label" for="fromEmail"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">From</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="fromEmail" style="font-size: 10px;" value="{{Auth::user()->Email}}">
                </div>
                <div class="form-group ">
                    <label class="control-label" for="toEmail"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">To</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="toEmail" style="font-size: 10px;">
                </div>
                <div class="form-group " style="display:none">
                    <label class="control-label" for="cc"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">CC</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="cc" style="font-size: 10px;">
                </div>
                <div class="form-group ">
                    <label class="control-label" for="subject"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Subject</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="subject" style="font-size: 10px;" >
                </div>
                <div class="form-group ">
                    <label class="control-label" for="bodyOnEmail"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Message</label>
                    <input class="form-control" id="bodyOnEmail" style="height:100px" value="Thank you ,the attached document is your order.">
                </div>
                <button type="button" id="sendOrderEmail" class="btn-success btn-xs " >Send</button>
            </form>
        </div>
    </div>
    <div id="userActionGrid" title="User Actions">
        <i class="fa fa-refresh pull-left" aria-hidden="true" id="refreshUserActionDataGrid"></i>
        <table class="table cell-border" id="tableUserActions">
            <thead>
            <th class="col-md-3">Message</th>
            <th class="col-md-1">Logged By</th>
            <th class="col-md-1">Computer Name</th>
            <th class="col-md-3">Product Desc</th>
            <th class="col-md-1">Product Code</th>
            <th class="col-md-3">Date Time</th>
            <th class="col-md-3">Customer Name</th>
            <th class="col-md-1">Customer Code</th>
            <th class="col-md-1">Reference</th>
            <th class="col-sm-1">New Qty</th>
            <th class="col-sm-1">Old Qty</th>
            <th class="col-sm-1">New Price</th>
            <th class="col-sm-1">Old Price</th>
            </thead>
        </table>
    </div>
    <div id="tempDeliveryAddressOnTheFly" title="Delivery Address associated with this address order only">
        <form>
            <input class="form-control" id="address1OnTheFly" placeholder="Address 1">
            <input class="form-control" id="address2OnTheFly" placeholder="Address 2">
            <input class="form-control" id="address3OnTheFly" placeholder="Address 3">
            <input class="form-control" id="address4OnTheFly" placeholder="Address 4">
            <input class="form-control" id="address5OnTheFly" placeholder="Address 5">
        </form>
        <button id="doneWithAddressOntheFly" class="btn-xs btn-success pull-right">Done</button>
    </div>
    <div id="priceLookPriceWithCustomer" title="Price Look on Customer">
        <div class="col-lg-12" style="line-height: 0.88;">
            <form>
                <fieldset class="well">

                    <legend class="well-legend">Search</legend>
                    <div class="col-md-12">
                        <div class="form-group col-md-4">
                            <label class="control-label" for="productCodePl"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Product Code</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="productCodePl" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="productDescPl"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Product Desc</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="productDescPl" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group col-md-4">
                            <label class="control-label" for="custCodePl"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Code</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="custCodePl" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="custDescPl"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Desc</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="custDescPl" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-4">
                            <button type="button" id="goOnPL" class="btn-xs btn-success" style="background: deeppink;border-color: deeppink;">GO</button>
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
        <div class="col-md-12" style="background: #fcf6f6;">
            <p style="text-align: center;background: #f5c485;">Unit Of Sale <strong><i id="unitOfSale" ></i></strong></p>
            <table class="table" id="individualPriceCheckByCustomer" style="width:100%">
                <thead>
                <tr>
                    <th>Price Incl</th><th>Price Exc</th></tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="col-md-12">
            <table class="table" id="individualCost" style="width:100%">
                <thead>
                <tr>
                    <th>Cost</th><th>Remaining</th></tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="col-md-12" style="background: #32cd32;">
            <table class="table" id="priceCheckByCustomer" style="width:100%">
                <thead>
                <tr>
                    <th>Price List</th><th>Price</th><th>Price Inc</th></tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div id="deliveryAddressOnOrderWithoutInoiceNo" title="Please Change the Delivery Address">
        <p>Please Double click To Change the Delivery Address</p>
        <table class="table" id="tbldeliveryAddressOnOrderWithoutInoiceNo" style="width:100%">
            <thead>
            <tr>
                <th>Delivery Address Id</th>
                <th>Address 1 </th><th>Address 2</th>
                <th>Address 3 </th><th>Address 4</th>
                <th>Address 5</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div id="tamaraCalculator" title="Calculate" class="col-md-12">
        <form id="formID">
            <table class="calculator" cellspacing="0" cellpadding="1"></table>

            <tr>
                <td colspan="5"><input id="display" class="form-control input-sm col-xs-1" name="display" value="0" size="28" maxlength="25"></td>
            </tr>
            <tr>
                <td><input type="button" class="btnTop" name="btnTop" value="C" onclick="this.form.display.value=  0 "></td>
                <td><input type="button" class="btnTop" name="btnTop" value="<--" onclick="deleteChar(this.form.display)"></td>
                <td><input type="button" id="equalOnCalculator" class="btnTop" name="btnTop" value="=" onclick="if(checkNum(this.form.display.value)) { compute(this.form) }"></td>
                <td><input type="button" class="btnOpps" name="btnOpps" value="&#960;" onclick="addChar(this.form.display,'3.14159265359')"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="%" onclick=" percent(this.form.display)"></td>
            </tr>
            <tr>
                <td><input type="button" class="btnNum" name="btnNum" value="7" onclick="addChar(this.form.display, '7')"></td>
                <td><input type="button" class="btnNum" name="btnNum" value="8" onclick="addChar(this.form.display, '8')"></td>
                <td><input type="button" class="btnNum" name="btnNum" value="9" onclick="addChar(this.form.display, '9')"></td>
                <td><input type="button" class="btnOpps" name="btnOpps" value="x&#94;" onclick="if(checkNum(this.form.display.value)) { exp(this.form) }"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="/" onclick="addChar(this.form.display, '/')"></td>
            <tr>
                <td><input type="button" class="btnNum" name="btnNum" value="4" onclick="addChar(this.form.display, '4')"></td>
                <td><input type="button" class="btnNum" name="btnNum" value="5" onclick="addChar(this.form.display, '5')"></td>
                <td><input type="button" class="btnNum" name="btnNum" value="6" onclick="addChar(this.form.display, '6')"></td>
                <td><input type="button" class="btnOpps" name="btnOpps" value="ln" onclick="if(checkNum(this.form.display.value)) { ln(this.form) }"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="*" onclick="addChar(this.form.display, '*')"></td>
            </tr>
            <tr>
                <td><input type="button" class="btnNum" name="btnNum" value="1" onclick="addChar(this.form.display, '1')"></td>
                <td><input type="button" class="btnNum" name="btnNum" value="2" onclick="addChar(this.form.display, '2')"></td>
                <td><input type="button" class="btnNum" name="btnNum" value="3" onclick="addChar(this.form.display, '3')"></td>
                <td><input type="button" class="btnOpps" name="btnOpps" value="&radic;" onclick="if(checkNum(this.form.display.value)) { sqrt(this.form) }"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="-" onclick="addChar(this.form.display, '-')"></td>
            </tr>
            <tr>
                <td><input type="button" class="btnMath" name="btnMath" value="&#177" onclick="changeSign(this.form.display)"></td>
                <td><input type="button" class="btnNum" name="btnNum" value="0" onclick="addChar(this.form.display, '0')"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="&#46;" onclick="addChar(this.form.display, '&#46;')"></td>
                <td><input type="button" class="btnOpps" name="btnOpps" value="x&#50;" onclick="if(checkNum(this.form.display.value)) { square(this.form) }"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="+" onclick="addChar(this.form.display, '+')"></td>
            </tr>
            <tr>
                <td><input type="button" class="btnMath" name="btnMath" value="(" onclick="addChar(this.form.display, '(')"></td>
                <td><input type="button" class="btnMath" name="btnMath" value=")" onclick="addChar(this.form.display,')')"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="cos" onclick="if(checkNum(this.form.display.value)) { cos(this.form) }"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="sin" onclick="if(checkNum(this.form.display.value)) { sin(this.form) }"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="tan" onclick="if(checkNum(this.form.display.value)) { tan(this.form) }"></td>
            </tr>
            </tabel>
        </form>
    </div>
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
                        <td><input type="text" id="posPayMentTypeCash" value="0" onkeypress="return isFloatNumber(this,event)" class="onPosAmount"></td>
                    </tr>
                    <tr>
                        <td>Account</td>
                        <td><input type="text" id="posPayMentTypeAccount" value="0" onkeypress="return isFloatNumber(this,event)"  class="onPosAmount"></td>
                    </tr>
                    <tr>
                        <td>Credit Card</td>
                        <td><input type="text" id="posPayMentTypeCreditCard" value="0" onkeypress="return isFloatNumber(this,event)"  class="onPosAmount"></td>
                    </tr>
                    <tr>
                        <td>Cheque</td>
                        <td><input type="text" id="posPayMentTypeCheque" value="0" onkeypress="return isFloatNumber(this,event)"  class="onPosAmount"></td>
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
                        <td><input type="text" id="posInvTotal"  readonly></td>
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
    <div id="prohibitedProductAuth" title="Please Authorise">
        <h5>This is a Prohibited Product</h5>
        <form>
            <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="userAuthProhibited"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
                <input class="form-control input-sm col-md-4 auto-complete-off" name="userAuthProhibited" id="userAuthProhibited" style="height:30px;font-size: 10px;"  autocomplete="off"></input>
            </div>
            <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="userAuthPassWordProhibited"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
                <input type="password" name="userAuthPassWordProhibited" class="form-control input-sm col-md-4 auto-complete-off" id="userAuthPassWordProhibited" style="height:30px;font-size: 10px;" readonly onfocus="$(this).removeAttr('readonly');"  autocomplete="off">
            </div>

            <button type="button" id="doAuthProhibited" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Authorise</button>
            <button type="button" id="doCancelAuthProhibited" class="btn-warning btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">No Thanks,Redo The Line</button>
        </form>
    </div>
    <div id="authDiscount" title="Authorise Discount">
        <h5>To change the Discount % you need to put in the new discount % and authorise</h5>
        Discount %<input class="form-control input-sm col-md-4" id="newDiscountPercentage" onkeypress="return isFloatNumber(this,event)" >
        <form>
            <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="userAuthDisc"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
                <input class="form-control input-sm col-md-4 auto-complete-off" name="userAuthDisc" id="userAuthDisc" style="height:30px;font-size: 10px;"  autocomplete="off"></input>
            </div>
            <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="userAuthPassWordDisc"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
                <input type="password" name="userAuthPassWordDisc" class="form-control input-sm col-md-4 auto-complete-off" id="userAuthPassWordDisc" style="height:30px;font-size: 10px;" readonly onfocus="$(this).removeAttr('readonly');"  autocomplete="off">
            </div>

            <button type="button" id="doAuthDiscounts" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Authorise</button>
        </form>
    </div>
    <div id="theCustomerNotes" title="Customer Notes">
        <h4 id="putTheCustomerNoteHere" style="color:red;"></h4>
    </div>
    <div id="assignRouteOnTheFly" id="Customer With No Routes">
        <h4>Customer Has No Route,Please select a route below</h4>
        <select class="form-control" id="assignRouteOnTheFlyDropDown"></select>
        <button id="doneAssigningRoutes" class="btn-success btn-sm pull-right">Done</button>
    </div>
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
    @include('dims.on_order')

@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>

    var reportmarginControl = 'marginType1';
    var booze = '';
    var productSetting = '';
    var finalDataProduct = '';
    var finalDataProductTest = '';
    var arrayProdCodesCheck = [];
    var arrayProds = [];
    var globalOrderIdToBePushed = [];
    var arrayOfCustomerInfo = [];
    var accounting = "<?php echo config('app.Accounting') ?>";
    var CompanyMargin = "<?php echo config('app.Margin') ?>";
    //console.debug("accounting*******"+accounting);

    reportmarginControl = JSON.stringify({!! json_encode($margin) !!});
    reportmarginControl = JSON.parse(reportmarginControl);
    console.debug(reportmarginControl);
    var jArray = JSON.stringify({!! json_encode($products) !!});
    var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
    var jArrayCustomerAll = JSON.stringify({!! json_encode($customersDontcareStatus) !!});
    var jArrayOrderTypes = JSON.stringify({!! json_encode($orderTypes) !!});
    var jArrayLastInserted = JSON.stringify({!! json_encode($LastInserted) !!});
    var jArraydelivDates = JSON.stringify({!! json_encode($delivDates) !!});
    var jArraydelivRoutes = JSON.stringify({!! json_encode($routesNames) !!});
    var jArraytrueOrFalse = JSON.stringify({!! json_encode($trueOrFalse) !!});

    // console.debug(jArrayCustomer);
    var computerName = '<?php echo gethostname() ?>';
    var byWho = '<?php echo Auth::user()->UserName ?>';
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).keydown(function (e) {
            booze = $('#boozeLisence').val();
        });
    });
    $(function () {
        if (($.trim($('#invoiceNo').val())).length > 1)
        {
            $('#changeDeliveryAddressOnNotInvoiced').hide();
        }

        if (($('#invoiceNo').val()).length < 1 && ($('#orderId').val()).length < 1)
        {
            $('#changeDeliveryAddressOnNotInvoiced').hide();
        }
    });

    //anonymus function to assign margin report control


    //Dialog = Order Listing Dialog
    function refresh_dialog() {
        $('#dialog').dialog();
    }
    var GlobalcustomerId = '';
    var GlobalRouteId = '';
    var GlobalOrderType = '';
    var datatableOrderPattern = '';
    var datatableGroupSpecials = '';
    var datatableUserActions = '';
    function updateCount() {
        var cs = $(this).val().length;
        $('#characters').text(cs);
    }

    var dataMenuOnRightClick = [
        [{
            text: "Open In New Tab",
            action: function () {
                window.open('{!!url("/callist")!!}');
            }
        },{
            text: "Open In New Tab",
            action: function () {
                window.open('{!!url("/callist")!!}');
            }
        }]
    ];
    $(document).ready(function() {

        $('#posPayMentTypeCash').select();
        $('#posPayMentTypeCreditCard').select();
        $('#posPayMentTypeAccount').select();
        $('#posPayMentTypeCheque').select();
        //simple calc
        $('#tamaraCalculatorId').click(function(){
            $('#tamaraCalculator').show();
            showDialog('#tamaraCalculator',320,350);
            $('#display').select();
        });


        $.each(JSON.parse(jArraytrueOrFalse), function (i, o) {
            switch (o.ReportType) {
                case "Allow Duplicate Products On Ordering":
                    productSetting = o.ReportName;
                    break;
            }
        });
        $.each(JSON.parse(jArrayLastInserted), function (i, o) {
            var Odate = new Date(o.OrderDate);

            var newODate = $.datepicker.formatDate('dd-mm-yy', new Date(Odate));
            var Ddate = new Date(o.DeliveryDate);
            var newDDate = $.datepicker.formatDate('dd-mm-yy', new Date(Ddate));
            $('#inputOrderDate').val(newODate);
            $('#inputDeliveryDate').val(newDDate);
            $('#submitFilters').prop('disabled', false);
        });
        var toAppendOrderTypes = '';
        // var toAppendOrderTypes = '';
        $.each(JSON.parse(jArrayOrderTypes), function (i, o) {
            toAppendOrderTypes += '<option value="' + o.OrderTypeId + '">' + o.OrderType + '</option>';
        });
        $('#orderType').append(toAppendOrderTypes);
        $('#orderTypesTabletLoading').append(toAppendOrderTypes);
        var toAppenddelvdates = '';
        $.each(JSON.parse(jArraydelivDates), function (i, o) {
            toAppenddelvdates += '<option value="' + o.DeliveryDate + '">' + o.DeliveryDate + '</option>';
        });
        $('#deliveryDates').append(toAppenddelvdates);
        var toAppendRoutes = '';
        $.each(JSON.parse(jArraydelivRoutes), function (i, o) {
            toAppendRoutes += '<option value="' + o.Routeid + '">' + o.Route + '</option>';
        });
        $('#generalRouteForNewDeliveryAddress').append(toAppendRoutes);
        $('#routeToFilterWith').append(toAppendRoutes);
        $('#rouTabletLoadingtes').append(toAppendRoutes);
        $('#AddressAddSelect').append(toAppendRoutes);
        $('#assignRouteOnTheFlyDropDown').append(toAppendRoutes);

        finalDataProduct = $.map(JSON.parse(jArray), function (item) {
            return {
                value: item.PastelCode,
                PastelCode: item.PastelCode,
                PastelDescription: item.PastelDescription,
                UnitSize: item.UnitSize,
                Tax: item.Tax,
                Cost: item.Cost,
                QtyInStock: item.QtyInStock,
                Margin: item.Margin,
                Alcohol: item.Alcohol,
                Available: item.Available
            }

        });

        finalDataProductTest = $.map(JSON.parse(jArray), function (item) {
            return {
                value: item.PastelDescription,
                PastelCode: item.PastelCode,
                PastelDescription: item.PastelDescription,
                UnitSize: item.UnitSize,
                Tax: item.Tax,
                Cost: item.Cost,
                QtyInStock: item.QtyInStock,
                Margin: item.Margin,
                Alcohol: item.Alcohol,
                Available: item.Available
            }

        });

        var finalData =$.map(JSON.parse(jArrayCustomer), function(item) {

            return {
                BalanceDue:item.BalanceDue,
                CustomerPastelCode:item.CustomerPastelCode,
                StoreName:item.StoreName,
                UserField5:item.UserField5,
                CustomerId:item.CustomerId,
                CreditLimit:item.CreditLimit,
                Email:item.Email,
                Routeid:item.Routeid,
                Discount:item.Discount,
                OtherImportantNotes:item.OtherImportantNotes,
                Routeid:item.Routeid,
                strRoute:item.strRoute
            }

        });
        var finalDataAll =$.map(JSON.parse(jArrayCustomerAll), function(item) {

            return {
                BalanceDue:item.BalanceDue,
                CustomerPastelCode:item.CustomerPastelCode,
                StoreName:item.StoreName,
                UserField5:item.UserField5,
                CustomerId:item.CustomerId,
                CreditLimit:item.CreditLimit,
                Email:item.Email,
                Routeid:item.Routeid,
                Discount:item.Discount,
                OtherImportantNotes:item.OtherImportantNotes,
                Routeid:item.Routeid,
                strRoute:item.strRoute
            }

        });

        //console.debug(getCustomers);
        $('body').tipPop({
            type: 'all' // listen on focus and hover events, it's default value
        });
        $('#table').sortable({
            containerSelector: 'table',
            itemPath: '> tbody',
            itemSelector: 'tr',
            placeholder: '<tr class="placeholder"/>'
        });

        $('input,textarea').attr('autocomplete', 'off');
        $('#orederNumber').keyup(updateCount);
        $('#orederNumber').keydown(updateCount);
        $('#creditLimitApproved').val('');
        $('#authorisations').hide();
        //getTheLastInsertedDeliveryDate();
        $('#dialog').hide();//Dialog
        $('#dialog2').hide();//Dialog
        $('#callListDialog').hide();//Dialog
        $('#listOfDelivAdress').hide();//Dialog
        $('#customDeliveeryAddress').hide();//Dialog
        $('#tabletLoading').hide();
        $('#tabletLoadingDocDetails').hide();
        $('#changeDeliveryAddress').hide();
        $('#copyOrderDialog').hide();
        $('#copyOrderDialogComfirmation').hide();
        $('#custLookUp').hide();
        $('#creditLimitAuth').hide();
        $('#reprintAuth').hide();
        $('#addNewAddress').hide();
        $('#copyOrdersMenu').hide();
        $('#multipleDeliveriesOnTheSameDate').hide();
        $('#copyingOrderProgress').hide();
        $('#abilityToEmailOrder').hide();
        $('#reprintInvoice').hide();
        $('#userActionGrid').hide();
        $('#salesOEmail').hide();
        $('#prodOnOrder').hide();
        $('#dispatchQuantityForm').hide();
        $('#tempDeliveryAddressOnTheFly').hide();
        $('#priceLookPriceWithCustomer').hide();
        $('#deliveryAddressOnOrderWithoutInoiceNo').hide();
        $('#tamaraCalculator').hide();
        $('#pointOfSaleDialog').hide();
        $('#posCashUp').hide();
        $('#authDropDowns').hide();
        $('#prohibitedProductAuth').hide();
        $('#authDiscount').hide();
        $('#theCustomerNotes').hide();
        $('#assignRouteOnTheFly').hide();
        $('#popTransaction').hide();
        $('#salesInvoiced').hide();

        //TABS
        $('#routePlanningPopUp').hide();
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#tabletLoadingApp').hide();
        $('#salesQuotebtn').hide();
        $('#afterFiltering').hide();
        $('#doneSorting').hide();
        $('#updateSorting').hide();
        $('#popUpForNewTruckControlSheetHeader').hide();
        $('#messageNB').hide();
        $('#straightForwardPrintThtTruckControlId').hide();
        $('#instantPrint').hide();
        $('#pricingOnCustomer').hide();
        $('#salesOnOrder').hide();
        $('#posCashUp').hide();

        var otable = ''; // Order Listing Table
        var productsOnOrders = ''; // products On Order

        var callListTable2 = ''; //Call List Table
        //test


        $('#changeDeliveryAddressOnNotInvoiced').click(function(){
            changeDeliveryAddress();
        });
        $('#dicPercHeader').click(function(){
            //changeDeliveryAddress();
            var oldDiscPercent = $('#dicPercHeader').val();
            $('#authDiscount').show();
            showDialog('#authDiscount',500,300);
            $('#newDiscountPercentage').val($('#dicPercHeader').val());
            $('#newDiscountPercentage').select();
            //authNewDiscountPerc(message);
            $('#doAuthDiscounts').click(function(){
                $.ajax({
                    url: '{!!url("/verifyAuth")!!}',
                    type: "POST",
                    data: {
                        userName: $('#userAuthDisc').val(),
                        userPassword: $('#userAuthPassWordDisc').val()
                    },
                    success: function (data) {
                        //console.debug("bunch"+data);
                        if ($.isEmptyObject(data)) {
                            alert("Wrong Credentials Please Try Again!");
                        } else
                        {
                            $('#userAuthDisc').val('');
                            $('#userAuthPassWordDisc').val('');
                            $('#dicPercHeader').val($('#newDiscountPercentage').val());
                            consoleManagement('{!!url("/logMessageAjax")!!}', 12, 1, 'Discount Changed from '+oldDiscPercent+' To ' +$('#dicPercHeader').val() +' by '+data[0].UserName, 0, $('#orderId').val(), 0, 0, 0, 0, 0,  0, $('#orderId').val(), 0, computerName, $('#orderId').val(), 0);
                            //updateDiscount

                            $.ajax({
                                url: '{!!url("/updateDiscount")!!}',
                                type: "POST",
                                data: {
                                    OrderId: $('#orderId').val(),
                                    Disc: $('#dicPercHeader').val()
                                },
                                success: function (data) {
                                    $('#authDiscount').dialog('close');
                                }
                            });
                            $('#authDiscount').dialog('close');
                            calculator();

                        }
                    }
                });
            });
        });
        $('#addANewDelvAddressOnModal').click(function () {
            $('#addNewAddress').show();
            $("#addNewAddress").dialog({
                height: 600,
                width: 900, containment: false
            }).dialogExtend({
                "closable": true, // enable/disable close button
                "maximizable": false, // enable/disable maximize button
                "minimizable": true, // enable/disable minimize button
                "collapsable": true, // enable/disable collapse button
                "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                "titlebar": false, // false, 'none', 'transparent'
                "minimizeLocation": "right", // sets alignment of minimized dialogues
                "icons": { // jQuery UI icon class
                    "close": "ui-icon-circle-close",
                    "maximize": "ui-icon-circle-plus",
                    "minimize": "ui-icon-circle-minus",
                    "collapse": "ui-icon-triangle-1-s",
                    "restore": "ui-icon-bullet"
                },
                "load": function (evt, dlg) {
                }, // event
                "beforeCollapse": function (evt, dlg) {
                }, // event
                "beforeMaximize": function (evt, dlg) {
                }, // event
                "beforeMinimize": function (evt, dlg) {
                }, // event
                "beforeRestore": function (evt, dlg) {
                }, // event
                "collapse": function (evt, dlg) {
                }, // event
                "maximize": function (evt, dlg) {
                }, // event
                "minimize": function (evt, dlg) {
                }, // event
                "restore": function (evt, dlg) {
                } // event
            });

            for (var i = 0; i < 20; i++) {
                addAddressLineOnSingleCustAddress('#addNewAddressModal');
            }
        });
        $('#tempDelivAddress').click(function(){
            $('#tempDeliveryAddressOnTheFly').show();
            showDialog('#tempDeliveryAddressOnTheFly','50%',250);
            $('#doneWithAddressOntheFly').click(function(){
                $('#address1hidden').val($('#address1OnTheFly').val());
                $('#address2hidden').val($('#address2OnTheFly').val());
                $('#address3hidden').val($('#address3OnTheFly').val());
                $('#address4hidden').val($('#address4OnTheFly').val());
                $('#address5hidden').val($('#address5OnTheFly').val());
                $('#hiddenDeliveryAddressId').val('');
                $('#customerSelectedDelDate').empty();
                $('#customerSelectedDelDate').val($('#address1OnTheFly').val()+' '+$('#address2OnTheFly').val()+' '+$('#address3OnTheFly').val()+' '+$('#address4OnTheFly').val()+' '+$('#address5OnTheFly').val());

                $.ajax({
                    url: '{!!url("/tempDeliverAddress")!!}',
                    type: "POST",
                    data: {
                        address1: $('#address1OnTheFly').val(),
                        orderID: $('#orderId').val(),
                        address2: $('#address2OnTheFly').val(),
                        address3: $('#address3OnTheFly').val(),
                        address4: $('#address4OnTheFly').val(),
                        address5: $('#address5OnTheFly').val(),
                        Routeid: $('#routeName').val()
                    },
                    success: function (data) {
                        var dialog = $('<p>'+data+'</p>').dialog({
                            height: 200, width: 700, modal: true, containment: false,
                            buttons: {
                                "OKAY": function () {
                                    $('#tempDeliveryAddressOnTheFly').dialog('close');
                                    $('#tempDelivAddressClosethis').hide();
                                    dialog.dialog('close');

                                }
                            }
                        });
                    }
                });
            });
            //
        });
        $('#addTableAddressToDB').click(function () {
            createAddressArray('{!!url("/insertNewAddress")!!}', $('#inputCustAcc').val());
        });
        /**
         * CALL LIST
         * */


        /**
         * List Top 1000 orders and order them  by date in desc
         * */
        $('#quoteListing').click(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            otable = $('#createdOrders').DataTable({
                "ajax": {
                    url: '{!!url("/getOrderListingOtherTrans")!!}', "type": "POST", data: function (data) {
                        data.OrderId = $('#orderIdOrderListing').val();
                        data.InvNo = $('#invoiceNoOrderListing').val();
                        data.CustCode = $('#customerCodeOrderListing').val();
                        data.delDate = $('#deliveryDateOrderListing').val();
                    }
                },
                "processing": false,
                "serverSide": false,
                "stateSave": false,
                "columns": [
                    {"data": "OrderId", "class": "small"},
                    {"data": "InvoiceNo", "class": "small"},
                    {"data": "CustomerPastelCode", "class": "small"},
                    {"data": "StoreName", "class": "small"},
                    {"data": "LateOrder", "class": "small"},
                    {"data": "Route", "class": "small"},
                    {"data": "DeliveryDate", "class": "small", "bSortable": true},
                            {"data": "OrderDate", "class": "small"},
                    {"data": "OrderNo", "class": "small"},

                ],
                "order": [[ 6, "desc" ]],
                "deferRender": true,
                "scrollY": "405px",
                "scrollCollapse": true,
                searching: true,
                bPaginate: false,
                bFilter: false,
                "LengthChange": false,
                "info": false,
                "ordering": true,
                "bDestroy": true
            });

            $('#createdOrders tbody').on('dblclick', 'tr', function () {
                var data = otable.row(this).data();
                console.debug(data.OrderId);
                if ($('#orderId').val().length > 0) {
                    alert('There is Currently an order Opened Please Close it !');
                }
                else {
                    $('<div></div>').appendTo('body')
                        .html('<div><h6>Yes or No?</h6></div>')
                        .dialog({
                            modal: true,
                            title: 'Do you want to view this order?',
                            zIndex: 10000,
                            autoOpen: true,
                            width: '45%',
                            resizable: false,
                            buttons: {
                                Yes: function () {
                                    $('#orderId').val(data.OrderId);
                                    $("#checkOrders").click();
                                    $("#dialog").dialogExtend("minimize");
                                    $(this).dialog("close");
                                },
                                No: function () {
                                    $(this).dialog("close");
                                }
                            },
                            close: function (event, ui) {
                                $(this).remove();
                            }
                        });
                }
                //document.location.href = '/operator/'+data['slug'];
            });
            $('#passFiltersOnOrderListing').on('click change', function (event) {
                // otable.draw();
                otable = $('#createdOrders').DataTable({
                    "ajax": {
                        url: '{!!url("/getOrderListing")!!}', "type": "POST", data: function (data) {
                            data.OrderId = $('#orderIdOrderListing').val();
                            data.InvNo = $('#invoiceNoOrderListing').val();
                            data.CustCode = $('#customerCodeOrderListing').val();
                            data.delDate = $('#deliveryDateOrderListing').val();
                        }
                    },
                    "processing": false,
                    "serverSide": false,
                    "stateSave": false,
                    "columns": [
                        {"data": "OrderId", "class": "small"},
                        {"data": "InvoiceNo", "class": "small"},
                        {"data": "CustomerPastelCode", "class": "small"},
                        {"data": "StoreName", "class": "small"},
                        {"data": "LateOrder", "class": "small"},
                        {"data": "Route", "class": "small"},
                        {"data": "DeliveryDate", "class": "small", "bSortable": true},
                            {"data": "OrderDate", "class": "small"},
                        {"data": "OrderNo", "class": "small"},


                    ],
                    "order": [[ 6, "desc" ]],
                    "deferRender": true,
                    "scrollY": "405px",
                    "scrollCollapse": true,
                    searching: true,
                    bPaginate: false,
                    bFilter: false,
                    "LengthChange": false,
                    "info": false,
                    "ordering": true,
                    "bDestroy": true
                });
            });
            $('#refreshOrderListing').on('click change', function (event) {
                // otable.draw();
                $('#orderIdOrderListing').val('');
                $('#invoiceNoOrderListing').val('');
                $('#customerCodeOrderListing').val('');
                $('#deliveryDateOrderListing').val('');
                otable = $('#createdOrders').DataTable({
                    "ajax": {
                        url: '{!!url("/getOrderListing")!!}', "type": "POST", data: function (data) {
                            data.OrderId = $('#orderIdOrderListing').val();
                            data.InvNo = $('#invoiceNoOrderListing').val();
                            data.CustCode = $('#customerCodeOrderListing').val();
                            data.delDate = $('#deliveryDateOrderListing').val();
                        }
                    },
                    "order": [[ 6, "desc" ]],
                    "processing": false,
                    "serverSide": false,
                    "stateSave": false,
                    "columns": [
                        {"data": "OrderId", "class": "small"},
                        {"data": "InvoiceNo", "class": "small"},
                        {"data": "CustomerPastelCode", "class": "small"},
                        {"data": "StoreName", "class": "small"},
                        {"data": "LateOrder", "class": "small"},
                        {"data": "Route", "class": "small"},
                        {"data": "DeliveryDate", "class": "small", "bSortable": true},
                            {"data": "OrderDate", "class": "small"},
                        {"data": "OrderNo", "class": "small"},


                    ],

                    "deferRender": true,
                    "scrollY": "405px",
                    "scrollCollapse": true,
                    searching: true,
                    bPaginate: false,
                    bFilter: false,
                    "LengthChange": false,
                    "info": false,
                    "ordering": true,
                    "bDestroy": true
                });
            });
            $('#dialog').show();
            $("#dialog").dialog({
                height: 500,
                width: 1100, containment: false
            }).dialogExtend({
                "closable": true, // enable/disable close button
                "maximizable": false, // enable/disable maximize button
                "minimizable": true, // enable/disable minimize button
                "collapsable": true, // enable/disable collapse button
                "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                "titlebar": "transparent", // false, 'none', 'transparent'
                "minimizeLocation": "right", // sets alignment of minimized dialogues
                "icons": { // jQuery UI icon class
                    "close": "ui-icon-circle-close",
                    "maximize": "ui-icon-circle-plus",
                    "minimize": "ui-icon-circle-minus",
                    "collapse": "ui-icon-triangle-1-s",
                    "restore": "ui-icon-bullet"
                },
                "load": function (evt, dlg) {
                }, // event
                "beforeCollapse": function (evt, dlg) {
                }, // event
                "beforeMaximize": function (evt, dlg) {
                }, // event
                "beforeMinimize": function (evt, dlg) {
                }, // event
                "beforeRestore": function (evt, dlg) {
                }, // event
                "collapse": function (evt, dlg) {
                }, // event
                "maximize": function (evt, dlg) {
                }, // event
                "minimize": function (evt, dlg) {
                }, // event
                "restore": function (evt, dlg) {
                } // event
            });
        });
        $('#convertToOrder').click(function(){
            var dialog = $('<p><strong style="color:black">Note that only saved data will be converted</strong></p>').dialog({
                height: 200, width: 700,modal: true,containment: false,
                buttons: {
                    "OKAY CONTINUE": function () {
                        $(this).dialog("close");
                        $.ajax({
                            url: '{!! url("/convertToSalesOrder") !!}',
                            type: "POST",
                            data: {
                                OrderId: $('#orderId').val()
                            },
                            success: function (data) {
                                console.debug(data[0].ID);
                                var dialog = $('<p><strong style="color:black">The Order Id is '+data[0].ID+'</strong></p>').dialog({
                                    height: 200, width: 700,modal: true,containment: false,
                                    buttons: {
                                        "OKAY": function () {
                                            $(this).dialog("close");
                                            disableOnFinish();
                                        }
                                    }
                                });
                            }
                        });

                    }
                }
            });
        });
        /**
         * General Plrice check for any customer on a product
         * */
        $('#pricing').click(function () {
            window.open('{!!url("/pl")!!}', "PriceLook", "location=1,status=1,scrollbars=1, width=1200,height=550");

        });
        //$("#two-columns").zoomTarget();
        $('.hidebody').hide();
        var GLOBALPRODCODE = '';
        var GLOBALPRODUCTDESCRIPTION = '';
        var GLOBALPRICE = '';
        var GLOBALQUANTITY = '';
        var GLOBALBULK = '';
        var GLOBALCOMMENT = '';
        var GLOBALDISC = '';
        var GLOBALUNITSIZE = '';
        var TotalExc = 0;
        var TotalInc = 0;
        $('#awaitingStock').on('change',function(){
            if($(this).prop('checked')){
                $(this).val('1');
            }else{
                $(this).val('0');
            }

        });
        /**
         * Clicking the Finish button
         * */
        $('#finishOrder').click(function () {
            /* var crLimit = parseFloat($('#totalInc').val()) + parseFloat($('#balDue').val());
             //console.debug("--------"+$('#creditLimitApproved').val());
             if (crLimit > $('#creditLimit').val() && ($('#creditLimitApproved').val().length) < 2 && $('#totalEx').val() > 0) {
             var difference = crLimit - $('#creditLimit').val();
             // creditLimitAuth('The order is greater than Credit Limit Plus Balance Due By ' + difference.toFixed(2))
             } else {*/

            $('<div></div>').appendTo('body')
                .html('<div><h6>Yes or No?</h6></div>')
                .dialog({
                    modal: true,
                    title: 'Click Yes to save and Print Or No to save Only',
                    zIndex: 10000,
                    autoOpen: true,
                    width: '65%',
                    resizable: false,
                    buttons: {

                        "Convert":function () {
                            //Update the tblOrders and tblOrdersDetails here

                            var dialog = $('<p><strong style="color:black"> Please wait...</strong></p>').dialog({
                                height: 200, width: 700, modal: true, containment: false,
                                buttons: {
                                    "Okay": function () {

                                        dialog.dialog('close');
                                    }
                                }
                            });

                            //finishArray2 -- use to be
                            $.ajax({
                                url: '{!!url("/updateOrderHeaderForOtherTransactions")!!}',
                                type: "POST",
                                data: {
                                    orderDate: $('#inputOrderDate').val(),
                                    orderId: $('#orderId').val(),
                                    deliveryDate: $("#inputDeliveryDate").val(),
                                    routeId: $('#routeName').val(),
                                    OrderType: $('#orderType').val(),
                                    orderNo: $('#orederNumber').val(),
                                    messagebox: $('#messagebox').val(),
                                    awaitingStock: $('#awaitingStock').val(),
                                    customerCode: $('#inputCustAcc').val(),
                                    DeliveryAddressID: $('#hiddenDeliveryAddressId').val(),
                                    address1hidden: $('#address1hidden').val(),
                                    address2hidden: $('#address2hidden').val(),
                                    address3hidden: $('#address3hidden').val(),
                                    address4hidden: $('#address4hidden').val(),
                                    address5hidden: $('#address5hidden').val(),
                                    customerSelectedDelDate: $('#customerSelectedDelDate').val()
                                },
                                success: function (data) {

                                    var productsLinesOnPicking = new Array();
                                    $('#table > tbody  > tr').each(function() {
                                        var data = $(this);
                                        var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                                        console.debug($(this).closest('tr').find('.theProductCode_').val());
                                        if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                                            productsLinesOnPicking.push({
                                                'productCode': $(this).closest('tr').find('.theProductCode_').val(),
                                                'desc': $(this).closest('tr').find('.prodDescription_').val(),
                                                'qty': $(this).closest('tr').find('.prodQty_').val(),
                                                'price': $(this).closest('tr').find('.prodPrice_').val(),
                                                'comment': $(this).closest('tr').find('.prodComment_').val(),
                                                'orderDetailID': orderDetailID,
                                                'customerCode': $('#inputCustAcc').val(),
                                                'prodDisc': $(this).closest('tr').find('.prodDisc_').val(),
                                                'margin': $(this).closest('tr').find('.margin_').val(),
                                                'prodOPrice': $(this).closest('tr').find('.prodOPrice_ ').val(),
                                                'dateFrom': $(this).closest('tr').find('.dateFrom_').val(),
                                                'dateTo': $(this).closest('tr').find('.dateTo_ ').val()
                                            });
                                        }

                                    });
                                    calculator();
                                    $.ajax({
                                        url: '{!!url("/jsonOtherTransactionsLinesDetails")!!}',
                                        type: "POST",
                                        data: {
                                            OrderId: $('#orderId').val(),
                                            orderDetails: productsLinesOnPicking,
                                            exclusive:$('#totalEx').val()
                                        },
                                        success: function (data) {

                                            if(data.OrderId ==='Error')
                                            {
                                                var dialog = $('<p><strong style="color:black">  Something went Wrong on this Order ,Please Double Check this order.Make sure you do not have duplicated products with the same information  Or Call Linx Systems</strong></p>').dialog({
                                                    height: 200, width: 700, modal: true, containment: false,
                                                    buttons: {
                                                        "Okay": function () {

                                                            dialog.dialog('close');
                                                        }
                                                    }
                                                });
                                            }else
                                            {
                                                consoleManagement('{!!url("/logMessageAjax")!!}', 300, 2, 'Sales Quotation Lines saved', 0, 0, 0, 0, 0, 0, 0, 0, $('#orederNumber').val(), 0, computerName, $('#orderId').val(), 0);

                                                $.ajax({
                                                    url: '{!! url("/convertToSalesOrder") !!}',
                                                    type: "POST",
                                                    data: {
                                                        OrderId: $('#orderId').val()
                                                    },
                                                    success: function (data) {
                                                        console.debug(data[0].ID);
                                                        var dialog = $('<p><strong style="color:black">The Sales Order Id is '+data[0].ID+'</strong></p>').dialog({
                                                            height: 200, width: 700,modal: true,containment: false,
                                                            buttons: {
                                                                "OKAY": function () {
                                                                    $(this).dialog("close");
                                                                    disableOnFinish();
                                                                }
                                                            }
                                                        });
                                                    }
                                                });

                                            }
                                        }
                                    });

                                }
                            });


                            $(this).dialog("close");
                        },
                        Yes: function () {
                            //Update the tblOrders and tblOrdersDetails here

                            var dialog = $('<p><strong style="color:black"> Please wait...</strong></p>').dialog({
                                height: 200, width: 700, modal: true, containment: false,
                                buttons: {
                                    "Okay": function () {

                                        dialog.dialog('close');
                                    }
                                }
                            });

                            //finishArray2 -- use to be
                            $.ajax({
                                url: '{!!url("/updateOrderHeaderForOtherTransactions")!!}',
                                type: "POST",
                                data: {
                                    orderDate: $('#inputOrderDate').val(),
                                    orderId: $('#orderId').val(),
                                    deliveryDate: $("#inputDeliveryDate").val(),
                                    routeId: $('#routeName').val(),
                                    OrderType: $('#orderType').val(),
                                    orderNo: $('#orederNumber').val(),
                                    messagebox: $('#messagebox').val(),
                                    awaitingStock: $('#awaitingStock').val(),
                                    customerCode: $('#inputCustAcc').val(),
                                    DeliveryAddressID: $('#hiddenDeliveryAddressId').val(),
                                    address1hidden: $('#address1hidden').val(),
                                    address2hidden: $('#address2hidden').val(),
                                    address3hidden: $('#address3hidden').val(),
                                    address4hidden: $('#address4hidden').val(),
                                    address5hidden: $('#address5hidden').val(),
                                    customerSelectedDelDate: $('#customerSelectedDelDate').val()
                                },
                                success: function (data) {

                                    var productsLinesOnPicking = new Array();
                                    $('#table > tbody  > tr').each(function() {
                                        var data = $(this);
                                        var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                                        console.debug($(this).closest('tr').find('.theProductCode_').val());
                                        if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                                            productsLinesOnPicking.push({
                                                'productCode': $(this).closest('tr').find('.theProductCode_').val(),
                                                'desc': $(this).closest('tr').find('.prodDescription_').val(),
                                                'qty': $(this).closest('tr').find('.prodQty_').val(),
                                                'price': $(this).closest('tr').find('.prodPrice_').val(),
                                                'comment': $(this).closest('tr').find('.prodComment_').val(),
                                                'orderDetailID': orderDetailID,
                                                'customerCode': $('#inputCustAcc').val(),
                                                'prodDisc': $(this).closest('tr').find('.prodDisc_').val(),
                                                'margin': $(this).closest('tr').find('.margin_').val(),
                                                'prodOPrice': $(this).closest('tr').find('.prodOPrice_ ').val(),
                                                'dateFrom': $(this).closest('tr').find('.dateFrom_').val(),
                                                'dateTo': $(this).closest('tr').find('.dateTo_ ').val()
                                            });
                                        }

                                    });
                                    calculator();
                                    $.ajax({
                                        url: '{!!url("/jsonOtherTransactionsLinesDetails")!!}',
                                        type: "POST",
                                        data: {
                                            OrderId: $('#orderId').val(),
                                            orderDetails: productsLinesOnPicking,
                                            exclusive:$('#totalEx').val()
                                        },
                                        success: function (data) {

                                            if(data.OrderId ==='Error')
                                            {
                                                var dialog = $('<p><strong style="color:black">  Something went Wrong on this Order ,Please Double Check this order.Make sure you do not have duplicated products with the same information  Or Call Linx Systems</strong></p>').dialog({
                                                    height: 200, width: 700, modal: true, containment: false,
                                                    buttons: {
                                                        "Okay": function () {

                                                            dialog.dialog('close');
                                                        }
                                                    }
                                                });
                                            }else
                                            {
                                                consoleManagement('{!!url("/logMessageAjax")!!}', 300, 2, 'Sales Quotation Lines saved', 0, 0, 0, 0, 0, 0, 0, 0, $('#orederNumber').val(), 0, computerName, $('#orderId').val(), 0);
                                                var dialog = $('<p><strong style="color:black"> Saved successfully,Would you Print PDF?</strong></p><a href={!!url("/printQuatation")!!} class="btnPrint">Print</a>').dialog({
                                                    height: 200, width: 700, modal: true, containment: false,
                                                    buttons: {
                                                        "YES": function () {

                                                            window.open('{!!url("/testJaspr")!!}/'+$('#orderId').val(), "jasper", "width=600, height=400, scrollbars=yes")
                                                            disableOnFinish();
                                                            //dialog.dialog('close');
                                                        },
                                                        "NO": function () {
                                                            disableOnFinish();
                                                        }
                                                    }
                                                });

                                            }
                                        }
                                    });

                                }
                            });


                            $(this).dialog("close");
                        },
                        No: function () {
                            var dialog2 = $('<p><strong style="color:black"> Please wait...</strong></p>').dialog({
                                height: 200, width: 700, modal: true, containment: false,
                                buttons: {
                                    "Okay": function () {

                                        dialog2.dialog('close');
                                    }
                                }
                            });
                            // finishArray2 -It was
                            $.ajax({
                                url: '{!!url("/updateOrderHeaderForOtherTransactions")!!}',
                                type: "POST",
                                data: {
                                    orderDate: $('#inputOrderDate').val(),
                                    orderId: $('#orderId').val(),
                                    deliveryDate: $("#inputDeliveryDate").val(),
                                    routeId: $('#routeName').val(),
                                    OrderType: $('#orderType').val(),
                                    orderNo: $('#orederNumber').val(),
                                    messagebox: $('#messagebox').val(),
                                    awaitingStock: $('#awaitingStock').val(),
                                    customerCode: $('#inputCustAcc').val(),
                                    DeliveryAddressID: $('#hiddenDeliveryAddressId').val(),
                                    address1hidden: $('#address1hidden').val(),
                                    address2hidden: $('#address2hidden').val(),
                                    address3hidden: $('#address3hidden').val(),
                                    address4hidden: $('#address4hidden').val(),
                                    address5hidden: $('#address5hidden').val(),
                                    customerSelectedDelDate: $('#customerSelectedDelDate').val()
                                },
                                success: function (data) {

                                    var productsLinesOnPicking = new Array();
                                    $('#table > tbody  > tr').each(function() {
                                        var data = $(this);
                                        var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                                        console.debug($(this).closest('tr').find('.theProductCode_').val());
                                        if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                                            productsLinesOnPicking.push({
                                                'productCode': $(this).closest('tr').find('.theProductCode_').val(),
                                                'desc': $(this).closest('tr').find('.prodDescription_').val(),
                                                'qty': $(this).closest('tr').find('.prodQty_').val(),
                                                'price': $(this).closest('tr').find('.prodPrice_').val(),
                                                'comment': $(this).closest('tr').find('.prodComment_').val(),
                                                'orderDetailID': orderDetailID,
                                                'customerCode': $('#inputCustAcc').val(),
                                                'prodDisc': $(this).closest('tr').find('.prodDisc_').val(),
                                                'margin': $(this).closest('tr').find('.margin_').val(),
                                                'prodOPrice': $(this).closest('tr').find('.prodOPrice_ ').val(),
                                                'dateFrom': $(this).closest('tr').find('.dateFrom_').val(),
                                                'dateTo': $(this).closest('tr').find('.dateTo_ ').val()
                                            });
                                        }

                                    });
                                    calculator();
                                    $.ajax({
                                        url: '{!!url("/updateOrderHeaderForOtherTransactions")!!}',
                                        type: "POST",
                                        data: {
                                            OrderId: $('#orderId').val(),
                                            orderDetails: productsLinesOnPicking,
                                            exclusive:$('#totalEx').val()
                                        },
                                        success: function (data) {

                                            if(data.OrderId ==='Error')
                                            {
                                                var dialog = $('<p><strong style="color:black"> Something went Wrong on this Order ,Please Double Check this order.Make sure you do not have duplicated products with the same information  Or Call Linx Systems</strong></p>').dialog({
                                                    height: 200, width: 700, modal: true, containment: false,
                                                    buttons: {
                                                        "Okay": function () {

                                                            dialog.dialog('close');
                                                        }
                                                    }
                                                });
                                            }else
                                            {

                                                consoleManagement('{!!url("/logMessageAjax")!!}', 300, 2, 'Sales Order Saved', 0, 0, 0, 0, 0, 0, 0, 0, $('#orederNumber').val(), 0, computerName, $('#orderId').val(), 0);

                                                disableOnFinish();
                                            }
                                        }
                                    });


                                }
                            });

                        }
                    },
                    close: function (event, ui) {
                        $(this).remove();
                    }
                });
            //}
        });

        /**
         * Send the request to the server and get order headers and details
         * */
        $('#checkOrders').click(function () {

            var account = '';
            var Description = '';
            var DeliveryDate = '';
            var OrderDate = '';
            var InvoiceTotalPriceInc = 0;
            var InvoiceTotalPriceExcl = 0;
            $(".fast_remove").empty();
            $('.hidebody').show();
            $('#two-columns').css({display: "block"});
            $('#submitFilters').hide();
            $('#changeDelvDate').hide();
            $('#deprecated_cangeDate').hide();
            //Pass the Ids
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //Order Header
            $.ajax({
                url: '{!!url("/onCheckOrderHeaderForOtherTrans")!!}',
                type: "POST",
                data: {invoiceNo: $('#invoiceNo').val(), orderId: $('#orderId').val()},
                success: function (data) {
                    console.debug("************" + data.returns);
                    if (data.returns != "inserted") {
                        var dialog = $('<p>Sorry <strong style="color:red">' + data.data[0].orderID + '</strong></p>').dialog({
                            height: 200, width: 700,
                            buttons: {
                                "Okay": function () {
                                    dialog.dialog('close');
                                    location.reload(true);
                                }
                            }
                        });
                    } else {
                        console.debug(data.data);
                        var trHTML = '';
                        var Address = '';
                        $.each(data.data, function (key, value) {
                            $("#inputCustAcc").val(value.CustomerPastelCode);
                            $("#inputCustName").val(value.StoreName);
                            $("#inputDeliveryDate").val(value.DeliveryDate);
                            $("#inputOrderDate").val(value.OrderDate);
                            $('#invoiceNo').val(value.InvoiceNo);
                            $('#invoiceNoKeeper').val(value.InvoiceNo);
                            $('#orederNumber').val(value.OrderNo);
                            $('#creditLimit').val(value.CreditLimit);
                            $('#hiddenCustDiscount').val(value.Discount);
                            $('#dicPercHeader').val(value.Discount);
                            $('#hiddenCustomerNotes').val(value.OtherImportantNotes);
                            $('#hiddenRouteId').val(value.Routeid);
                            // $('#hiddenRouteName').val(value.strRoute);
                            $('#balDue').val(parseFloat(value.BalanceDue).toFixed(2));
                            $('#orderType').prepend('<option value="'+value.LateOrder+'" selected="selected">'+value.OrderType+'</option>');

                            //
                            // $('#hiddenDeliveryAddressId').val(value.DeliveryAddressID);
                            $('#messagebox').val(value.MESSAGESINV);
                            account = value.CustomerPastelCode;
                            Description = value.StoreName;
                            DeliveryDate = value.DeliveryDate;
                            OrderDate = value.OrderDate;
                            console.debug("del address**" + value.DeliveryAddressID);
                            console.debug("value.DeliveryAddressID" + value.DeliveryAddressID);
                            Address += $.trim(value.DeliveryAddress1) + ' , ' + $.trim(value.DeliveryAddress2) + ' , ' + $.trim(value.DeliveryAddress3) + ' , ' + $.trim(value.DeliveryAddress4) + ' , ' + $.trim(value.DeliveryAddress5);
                            Address = Address.replace("null", "");
                            $('#customerSelectedDelDate').val(Address);
                            $('#address1hidden').val(value.DeliveryAddress1);
                            $('#address2hidden').val(value.DeliveryAddress2);
                            $('#address3hidden').val(value.DeliveryAddress3);
                            $('#address4hidden').val(value.DeliveryAddress4);
                            $('#address5hidden').val(value.DeliveryAddress5);

                            if( value.DeliveryAddressID == 'Null')
                            {
                                $('#hiddenDeliveryAddressId').val('');
                                $('#tempDelivAddressClosethis').hide();
                                orderPattern(0);
                            }
                            else
                            {
                                $('#hiddenDeliveryAddressId').val(value.DeliveryAddressID);
                                orderPattern(value.DeliveryAddressID);
                            }

                            customerAndGroupSpecials();
                            $("#routeName").empty();
                            $('#routeName').prepend('<option value="'+value.RouteId+'" selected="selected">'+value.Route+'</option>');
                            previousRouteVal = $("#routeName").val();
                            previousTextRoute = $("#routeName").find("option:selected").text();
                            $("#routeName").on('change', function () {
                                if( ($('#orderId').val()).length > 1 ) {
                                    console.debug(this.value);

                                    $('#authDropDowns').show();
                                    showDialogWithoutClose('#authDropDowns', '65%', 420);

                                    $('#doAuthDropDown').click(function () {
                                        authChangeOfOrderType(previousTextRoute,'Authorised Route To ');
                                    });
                                    $('#doCancelAuthDropDown').click(function () {
                                        $("#routeName").prepend('<option value="' + previousRouteVal + '" selected="selected">' + previousTextRoute + '</option>');
                                        $('#authDropDowns').dialog('close');
                                    });
                                }
                            });

                            //Assign the Routes

                            $("#inputOrderDate").prop("disabled", true);
                            // $("#inputDeliveryDate").prop("disabled", true);
                            $("#inputDeliveryDate").prop("disabled", false);
                            $("#inputCustName").prop("disabled", true);
                            $("#inputCustAcc").prop("disabled", true);

                            //ORDER DETAILS
                            $.ajax({
                                url: '{!!url("/onCheckOrderHeaderDetailsForOtherTrans")!!}',
                                type: "POST",
                                data: {orderId: $('#orderId').val()},
                                success: function (dataDetails) {
                                    InvoiceTotalPriceExcl = 0;
                                    InvoiceTotalPriceInc = 0;
                                    $.each(dataDetails, function (keyDetails, valueDetails) {
                                        var tokenId = Math.floor(Math.pow(10, 9 - 1) + Math.random() * 9 * Math.pow(10, 9 - 1));
                                        var props = '';
                                        if (($('#invoiceNo').val()).length > 1) {
                                            props = "disabled";
                                        }
                                        var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
                                            '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_' + tokenId + '" class="theProductCode_ set_autocomplete" value="' + valueDetails.PastelCode + '" ' + props + ' ></td>' +
                                            '<td contenteditable="false" class="col-md-4"><input name="prodDescription_" id ="prodDescription_' + tokenId + '" class="prodDescription_ set_autocomplete" value="' + valueDetails.PastelDescription + '" ' + props + ' ></td>' +
                                            '<td  contenteditable="false" class="col-md-1"><input type="text" name="prodQty_" id ="prodQty_' + tokenId + '"   onkeypress="return isFloatNumber(this,event)"  class="prodQty_ resize-input-inside" value="' + (parseFloat(valueDetails.Qty)).toFixed(2) + '" ' + props + '></td>' +
                                            '<td  style="display: none;" contenteditable="false" class="col-md-1"><input type="text" name="prodBulk_"  id ="prodBulk_' + tokenId + '" class="prodBulk_ resize-input-inside" ' + props + '></td>' +
                                            '<td contenteditable="false"  class="col-md-1"><input type="text" name="margin_" id ="margin_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="margin_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" value="' + (parseFloat(valueDetails.fltMargin)).toFixed(2) + '" ' + props + ' >' +
                                            '<td  contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside" value="' + (parseFloat(valueDetails.Price)).toFixed(2) + '" ' + props + '></td>' +
                                            '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodOPrice_" id ="prodOPrice_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodOPrice_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" value="' + (parseFloat(valueDetails.fltPOPrice)).toFixed(2) + '" disabled>' +
                                            '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodCost_" id ="prodCost_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodCost_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" value="' + (parseFloat(valueDetails.CostPrice)).toFixed(2) + '" ' + props + '>' +
                                            '<td  style="display: none;"  contenteditable="false"  class="col-md-1"><input type="text" name="prodDisc_" id ="prodDisc_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside" value="' + valueDetails.LineDisc + '" ' + props + ' ></td>' +
                                            '<td  contenteditable="false"  class="col-md-1"><input  type="text" name="prodUnitSize_" id ="prodUnitSize_' + tokenId + '" class="prodUnitSize_ resize-input-inside" value="' + valueDetails.UnitSize + '" ' + props + ' ></td>' +
                                            '<td contenteditable="false"  class="col-md-1"><input type="text" name="instockReadOnly" id ="instockReadOnly_' + tokenId + '" value="' + valueDetails.QtyInStock + '"  class="instockReadOnly_ resize-input-inside inputs" style="font-weight: 800;width: 80%;">' +
                                            '<td contenteditable="false"  class="col-md-3"><input type="text" name="dateFrom" id ="dateFrom_' + tokenId + '" class="dateFrom_ resize-input-inside inputs" style="font-size:9px;" value="' + valueDetails.dteFrom + '" ' + props + ' ></td>' +
                                            '<td contenteditable="false"  class="col-md-3"><input type="text" name="dateTo" id ="dateTo_' + tokenId + '" class="dateTo_ resize-input-inside inputs"  style="font-size:9px;" value="' + valueDetails.dteTo + '" ' + props + ' ></td>' +
                                            '<td  contenteditable="false" class="col-md-3"><input type="text" name="prodComment_" id ="prodComment_' + tokenId + '" class="prodComment_ resize-input-inside last inputs" value="' + valueDetails.Comment + '" ' + props + ' ></td>' +
                                            '<td><input type="hidden" id="title_' + tokenId + '" class="title" value="" /><input type="hidden" id="theOrdersDetailsId" value="' + valueDetails.OrderDetailId + '" /><input type="hidden" id ="taxCode' + tokenId + '" value="' + valueDetails.Tax + '" class="taxCodes" />' +
                                            '<input type="hidden" id ="cost_' + tokenId + '" value="' + valueDetails.Cost + '" class="costs" /><input type="hidden" id ="inStock_' + tokenId + '" value="' + valueDetails.QtyInStock + '" class="inStock" /><input type="hidden" value ="' + tokenId + '" class="hiddenToken" />' +
                                            '<input type="hidden" id ="priceholder_' + tokenId + '" value="' + (parseFloat(valueDetails.Price)).toFixed(2) + '" class="priceholder" />' +
                                            '<input type="hidden" id ="alcohol_' + tokenId + '" value="" class="alcohol" /><input type="hidden" id ="margin_' + tokenId + '" value="" class="margin" />' +
                                            '<input type="hidden" id ="prohibited_' + tokenId + '" value="" class="prohibited" />' +
                                            '<button type="button" id="deleteaLine" value="' + valueDetails.OrderDetailId + '" class="getOrderDetailLine btn-warning" >Delete</button>' +
                                            '</td></tr>');
                                        $('#table tbody').append($row);

                                        if (valueDetails.Price == null || valueDetails.IncPrice == null) {
                                            InvoiceTotalPriceExcl = (parseFloat(InvoiceTotalPriceExcl) + (0 * parseFloat(valueDetails.Qty))).toFixed(2);
                                            InvoiceTotalPriceInc = (parseFloat(InvoiceTotalPriceInc) + (0 * parseFloat(valueDetails.Qty))).toFixed(2);
                                        } else {
                                            InvoiceTotalPriceExcl = (parseFloat(InvoiceTotalPriceExcl) + (parseFloat(valueDetails.Price) * parseFloat(valueDetails.Qty))).toFixed(2);
                                            InvoiceTotalPriceInc = (parseFloat(InvoiceTotalPriceInc) + (parseFloat(valueDetails.IncPrice) * parseFloat(valueDetails.Qty))).toFixed(2);

                                        }


                                    });
                                    if ($('#invoiceNo').val().length < 3) {
                                        $('#changeDeliveryAddressOnNotInvoiced').show();
                                        generateALine2();
                                    } else {
                                        $(".getOrderDetailLine ").css("display", "none");
                                    }


                                    $('#totalEx').val(InvoiceTotalPriceExcl);
                                    $('#totalInc').val(InvoiceTotalPriceInc);
                                }

                            });

                            $("#invoiceNo").prop("disabled", true);
                            $("#orderId").prop("disabled", true);
                            if (( $("#invoiceNoKeeper").val()).length > 1) {
                                $("#orederNumber").prop("disabled", true);
                                $("#totalEx").prop("disabled", true);
                                $("#totalInc").prop("disabled", true);
                                $("#button_row").prop("disabled", true);
                                $("#invoiceNow").hide();
                                $("#reprintInvoice").show();
                            }


                        });
                    }

                    //$("#two-columns").find("input").attr("disabled", "disabled");

                }
            });
            //End of Order Header

        });

        $('#pricingOnCustomer').click(function(){
            $('#priceLookPriceWithCustomer').show();
            showDialog('#priceLookPriceWithCustomer','65%',620);
            $('#goOnPL').click(function(){
                PL();
            });

        });

        /**
         * Main form filters to generate the order
         * */
        $('#submitFilters').click(function () {
            //Check if there is an order
            //checkIfOrderExistsWithOrderType
            $("#deprecated_cangeDate").hide();
            $('#copyThisOrder').hide();
            $('#printDocument').hide();
            $('#checkOrders').hide();
            //
            console.debug($('#hiddenRouteId').val());
            if($('#hiddenRouteId').val()==='0')
            {
                $('#assignRouteOnTheFly').show();
                showDialog('#assignRouteOnTheFly',520,300);
                $("#assignRouteOnTheFlyDropDown").on("change", function () {

                    $('#routeName').prepend('<option value="'+this.value+'" selected="selected">'+$("#assignRouteOnTheFlyDropDown option:selected").text()+'</option>');

                });
                $('#doneAssigningRoutes').click(function(){
                    $.ajax({
                        url: '{!! url("/assignRouteToTheCustomer") !!}',
                        type: "POST",
                        data: {
                            custCode: $('#inputCustAcc').val(),
                            routeId: $('#assignRouteOnTheFlyDropDown').val(),
                        },success: function (data) {
                            $('#assignRouteOnTheFly').dialog('close');
                        }
                    });
                });
                //assignRouteOnTheFlyDropDown
            }


            $('body').pleaseWait();
            $.ajax({
                url: '{!! url("/checkIfOrderExistsWithOrderType") !!}',
                type: "POST",
                data: {
                    customerCode: $('#inputCustAcc').val(),
                    deliveryDate: $('#inputDeliveryDate').val(),
                    orderDate: $('#inputOrderDate').val(),
                    routeId: $('#Routeid').val(),
                    OrderType: $('#orderType').val(),
                    orderNo: '',
                    statement: 'Check'
                },
                success: function (data) {
                    console.debug(data);

                    if (data.length > 0) {
                        //e.preventDefault();
                        var dialog = $('<p>Sorry there is already an order for that delivery date,please click <strong style="color:#356a1b">YES</strong> to add another , <strong style="color:red">NO</strong> to view the existing order or <strong style="color:blue">CANCEL</strong> to restart the process</p>').dialog({
                            height: 200, width: 700,
                            buttons: {
                                "Yes": function () {
                                    anonymus();
                                    dialog.dialog('close');
                                },
                                "No": function () {
                                    $('#multipleDeliveriesOnTheSameDate').show();
                                    $("#multipleDeliveriesOnTheSameDate").dialog({
                                        height: 600,
                                        width: 950, containment: false
                                    }).dialogExtend({
                                        "closable": true, // enable/disable close button
                                        "maximizable": false, // enable/disable maximize button
                                        "minimizable": true, // enable/disable minimize button
                                        "collapsable": true, // enable/disable collapse button
                                        "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                                        "titlebar": false, // false, 'none', 'transparent'
                                        "minimizeLocation": "right", // sets alignment of minimized dialogues
                                        "icons": { // jQuery UI icon class
                                            "close": "ui-icon-circle-close",
                                            "maximize": "ui-icon-circle-plus",
                                            "minimize": "ui-icon-circle-minus",
                                            "collapse": "ui-icon-triangle-1-s",
                                            "restore": "ui-icon-bullet"
                                        },
                                        "load": function (evt, dlg) {
                                        }, // event
                                        "beforeCollapse": function (evt, dlg) {
                                        }, // event
                                        "beforeMaximize": function (evt, dlg) {
                                        }, // event
                                        "beforeMinimize": function (evt, dlg) {
                                        }, // event
                                        "beforeRestore": function (evt, dlg) {
                                        }, // event
                                        "collapse": function (evt, dlg) {
                                        }, // event
                                        "maximize": function (evt, dlg) {
                                        }, // event
                                        "minimize": function (evt, dlg) {
                                        }, // event
                                        "restore": function (evt, dlg) {
                                        } // event
                                    });
                                    var trHTML = '';
                                    $('.fast_removeOrders').empty();
                                    $.each(data, function (key, value) {
                                        trHTML += '<tr role="row" class="fast_removeOrders"  style="font-size: 16px;color:black"><td>' +
                                            value.OrderId + '</td><td>' +
                                            value.OrderDate + '</td><td>' +
                                            value.DeliveryDate + '</td><td>' +
                                            value.routename + '</td><td>' +
                                            value.DeliveryAddress1 + '</td>' +
                                            '</tr>';
                                    });
                                    $('#multipleAddressesOnTheSameDateModal').append(trHTML);
                                    $('#multipleAddressesOnTheSameDateModal tbody').on('dblclick', 'tr', function () {
                                        var orderIdClicked = $(this).closest('tr').find('td:eq(0)').text();

                                        $('#orderId').val(orderIdClicked);
                                        dialog.dialog('close');
                                        $('#checkOrders').click();
                                        $("#multipleDeliveriesOnTheSameDate").dialog('close');

                                    });
                                },
                                "Cancel": function () {
                                    alert('you chose cancel');
                                    dialog.dialog('close');

                                }
                            }
                        });

                    }
                    else {
                        anonymus()
                    }
                }
            });

            function anonymus() {

                $.ajax({
                    url: '{!! url("/insertHeaderForOtherTrans") !!}',
                    type: "POST",
                    data: {
                        customerCode: $('#inputCustAcc').val(),
                        deliveryDate: $('#inputDeliveryDate').val(),
                        orderDate: $('#inputOrderDate').val(),
                        routeId:$('#Routeid').val(),
                        OrderType: $('#orderType').val(),
                        customerSelectedDelDate: $('#customerSelectedDelDate').val(),
                        orderNo: '',
                        statement: 'Insert'
                    },
                    success: function (data) {
                        $('#orderId').val(data.orderId);
                        consoleManagement('{!!url("/logMessageAjax")!!}', 300, 1, 'New Order Created For '+$('#inputCustAcc').val()+' - '+data.orderId, 0 , 0, 0, 0, 0, 0, 0, 0, +data.orderId, 0, computerName, +data.orderId, 0);

                        customerAndGroupSpecials();
                        $('#convertToOrder').hide();
                        if (data.counter.CustomerId == "1") {
                            //$('.container').pleaseWait();
                            orderPattern('0');
                            var Address = '';
                            //countomerSingleAddress ---before
                            Address += $.trim(data.singleAddress.DAddress1) + ' , ' + $.trim(data.singleAddress.DAddress2) + ' , ' + $.trim(data.singleAddress.DAddress3) + ' , ' + $.trim(data.singleAddress.DAddress4) + ' , ' + $.trim(data.singleAddress.DAddress5);
                            Address = Address.replace("null", "");
                            $('#customerSelectedDelDate').val(Address);
                            $('#address1hidden').val(data.singleAddress.DAddress1);
                            $('#address2hidden').val(data.singleAddress.DAddress2);
                            $('#address3hidden').val(data.singleAddress.DAddress3);
                            $('#address4hidden').val(data.singleAddress.DAddress4);
                            $('#address5hidden').val(data.singleAddress.DAddress5);
                            $('#hiddenDeliveryAddressId').val(data.singleAddress.DeliveryAddressID);
                            console.debug(data.singleAddress.DeliveryAddressID);

                            $('#changeDeliveryAddress').hide();
                            $('#loadingmessage').hide();


                        } else {

                            $.ajax({
                                url: '{!! url("/selectCustomerMultiAddress") !!}',
                                type: "POST",
                                data: {customerCode: $("#inputCustAcc").val()},
                                success: function (data) {
                                    var toAppend = '';
                                    $.each(data, function (i, o) {
                                        toAppend += '<li value="' + o.DeliveryAddressID + '" style="border-bottom: 4px solid black;">' + o.DAddress1 + ' ' + o.DAddress2 + ' ' + o.DAddress3 + '<br>' + o.DAddress4 + '<br>' + o.DAddress5 + '</li>';
                                    });
                                    $('#listaddresses').append(toAppend);
                                    $('#changeDeliveryAddress').show();

                                    getDimsUsers('#salesPerson', '{!!url("/getDimsUsers")!!}');
                                    getDimsUsers('#salesPersonOnDynamic', '{!!url("/getDimsUsers")!!}');
                                    //$('body').pleaseWait('stop');
                                    // $('#doneCustomAddress').hide();

                                    onClickingDeliveryAddress();
                                    $('#generateDynamicAddress').on('click', 'tr', function () {
                                        $('#address1').val('');
                                        $('#address2').val('');
                                        $('#address3').val('');
                                        $('#address4').val('');
                                        $('#address5').val('');
                                        //$('#doneCustomAddress').show();
                                        console.debug($(this).closest('tr').find('td').eq(1).text());
                                        $('#address1').val($(this).closest('tr').find('td').eq(2).text());
                                        console.debug($('#address1').val());
                                        $('#address2').val($(this).closest('tr').find('td').eq(3).text());
                                        $('#address3').val($(this).closest('tr').find('td').eq(4).text());
                                        $('#address4').val($(this).closest('tr').find('td').eq(5).text());
                                        $('#address5').val($(this).closest('tr').find('td').eq(6).text());
                                        $('#generalRouteForNewDeliveryAddress').prepend('<option value="'+$(this).closest('tr').find('#hiddenRouteId').val()+'" selected="selected">'+$(this).closest('tr').find('td').eq(1).text()+'</option>');
                                        $('#deliveryAddressIdOnPopUp').val($(this).closest('tr').find('#hiddenDeliveryAddressIdAfterSaved').val());
                                    });
                                    $('#doneCustomAddress').click(function () {

                                        if($('#generalRouteForNewDeliveryAddress').val() === 'null')
                                        {
                                            alert('The RouteID/Route Name is not correct,Please Choose the Route Or Speak to the manager.');

                                        }else
                                        {
                                            orderPattern($("#deliveryAddressIdOnPopUp").val());

                                            var textAddress = $('#address1').val() + ' ' + $('#address2').val() + ' ' + $('#address3').val() + ' ' + $('#address4').val() + ' ' + $('#address5').val();
                                            $("#customerSelectedDelDate").val(textAddress);
                                            $('#address1hidden').val($('#address1').val());
                                            $('#address2hidden').val($('#address2').val());
                                            $('#address3hidden').val($('#address3').val());
                                            $('#address4hidden').val($('#address4').val());
                                            $('#address5hidden').val($('#address5').val());
                                            //$("#hiddenDeliveryAddressId").val($("#deliveryAddressIdOnPopUp").val());
                                            $("#hiddenDeliveryAddressId").val($("#deliveryAddressIdOnPopUp").val());
                                            $('#routeName').prepend('<option value="'+$('#generalRouteForNewDeliveryAddress').val()+'" selected="selected">'+$('#generalRouteForNewDeliveryAddress option:selected').text()+'</option>');
                                            $("#listOfDelivAdress").dialog("close");
                                        }


                                    });

                                }
                            });
                            $('#AddressAddMakeNew').click(function () {
                                $.ajax({
                                    url: '{!!url("/createNewCustomDelvDate")!!}',
                                    type: "POST",
                                    data: {
                                        customerCode: $('#inputCustAcc').val(),
                                        address1: $('#Address1Add').val(),
                                        address2: $('#Address2Add').val(),
                                        address3: $('#Address3Add').val(),
                                        address4: $('#Address4Add').val(),
                                        address5: $('#Address5Add').val(),
                                        routeId: $("#AddressAddSelect").val(),
                                        SalesPerson: $("#salesPersonOnDynamic").val(),
                                        SalesPersonName: $("#salesPersonOnDynamic option:selected").text(),
                                        routeName: $("#AddressAddSelect option:selected").text()
                                    },
                                    success: function (data) {
                                        var toAppend = '';
                                        toAppend += '<tr><td><button type="button" id="selectThisAddressOnTable">Select</button></td><td>' +
                                            data.routeName + '</td><td>' +
                                            data.address1 + '</td><td>' +
                                            data.address2 + '</td><td>' +
                                            data.address3 + '</td><td>' +
                                            data.address4 + '</td><td>' +
                                            data.address5 + '</td><td>' +
                                            data.salesName + '</td><td>' +
                                            '<input type="hidden"  id="hiddenDeliveryAddressIdAfterSaved" value="' + data.ID + '"> <input type="hidden"  id="hiddenRouteId" value="' + $("#AddressAddSelect").val() + '"> ' + '</td></tr>';
                                        $('#generateDynamicAddress').append(toAppend);
                                    }
                                });

                            });

                            $('#loadingmessage').hide();
                        }
                        $('#orderId').prop('disabled', true);
                    }
                });
                if(($('#hiddenCustomerNotes').val()).length > 0){
                    $('#theCustomerNotes').show();
                    showDialog('#theCustomerNotes',400,250);
                    $('#putTheCustomerNoteHere').empty();
                    $('#nbNotes').empty();
                    $('#putTheCustomerNoteHere').append($('#hiddenCustomerNotes').val());
                    $('#nbNotes').append($('#hiddenCustomerNotes').val());
                }

                var counts = 0;
                //it used to be countAddress
                /* $.ajax({
                 url: countAddress,
                 type: "POST",
                 data: {customerCode: $("#inputCustAcc").val()},
                 success: function (data) {

                 counts = data[0].CustomerId;
                 console.debug("counts" + counts);

                 }
                 });*/

                //use the customer route name comming with customer on search

                $("#routeName").prepend('<option value="' + $('#hiddenRouteId').val() + '" selected="selected" >' + $('#hiddenRouteName').val() + '</option>');
                previousRouteVal = $("#routeName").val();
                previousTextRoute = $("#routeName").find("option:selected").text();

                $("#routeName").on('change', function () {
                    if( ($('#orderId').val()).length > 1 ) {
                        console.debug(this.value);

                        $('#authDropDowns').show();
                        showDialogWithoutClose('#authDropDowns', '65%', 420);

                        $('#doAuthDropDown').click(function () {
                            authChangeOfOrderType(previousTextRoute,'Authorised Route To ');
                        });
                        $('#doCancelAuthDropDown').click(function () {
                            $("#routeName").prepend('<option value="' + previousRouteVal + '" selected="selected">' + previousTextRoute + '</option>');
                            $('#authDropDowns').dialog('close');
                        });
                    }
                });

                GlobalOrderType = $("#orderType").val();
                $('#changeDelvDate').val($("#inputDeliveryDate").val());
                GlobalRouteId = $("#routeName").val();
                console.debug("route id" + $("#routeName").val());
                $('.hidebody').show();
                $('.itCanHide').hide();
                // generateALine();
                generateALine2();
                // $("#inputDeliveryDate").prop("disabled", true);
                $("#changeDelvDate").prop("disabled", true);
                $("#inputCustName").prop("disabled", true);
                $("#inputCustAcc").prop("disabled", true);
                //$('#abilityToEmailOrder').show();


                $('#two-columns').css({display: "block"});
                $('#submitFilters').hide();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                //getTheCustomerId();


                //PRICES
                $("#codeSearch").autocomplete({
                    source: '{!!url("/prodCode")!!}',
                    minlength: 1,
                    autoFocus: true,
                    select: function (e, ui) {
                        $('#codeSearch').val(ui.item.value);
                        $('#descriptionSearch').val(ui.item.extra);

                        /*GET PRICE *********************************************************/
                        $.ajax({
                            url: '{!!url("/priceSearch")!!}',
                            type: "POST",
                            data: {
                                customerCode: $('#inputCustAcc').val(),
                                deliveryDate: $('#inputDeliveryDate').val(),
                                prodCode: ui.item.value
                            },
                            success: function (data) {

                                var trHTML = '';

                                $.each(data, function (key, value) {
                                    trHTML += '<tr  style="font-size: 9px;color:black"><td>' +
                                        ui.item.extra + '</td><td>' +
                                        parseFloat(value.Price).toFixed(2) + '</td><td>' +
                                        '</tr>';


                                });
                                $('#priceLookUpResult').append(trHTML);

                            }
                        });//End of get price

                    }
                });
                $("#descriptionSearch").autocomplete({
                    source: '{!!url("/prodDesciption")!!}',
                    minlength: 1,
                    autoFocus: true,
                    select: function (e, ui) {
                        $('#descriptionSearch').val(ui.item.value);
                        $('#codeSearch').val(ui.item.extra);

                        /*GET PRICE *********************************************************/
                        $.ajax({
                            url: '{!!url("/priceSearch")!!}',
                            type: "POST",
                            data: {
                                customerCode: $('#inputCustAcc').val(),
                                deliveryDate: $('#inputDeliveryDate').val(),
                                prodCode: ui.item.extra
                            },
                            success: function (data) {
                                $('#priceLookUpResult').empty();
                                var trHTML = '';

                                $.each(data, function (key, value) {
                                    trHTML += '<tr class="fast_remove" style="font-size: 9px;color:black"><td>' +
                                        ui.item.value + '</td><td>' +
                                        parseFloat(value.Price).toFixed(2) + '</td><td>' +
                                        '</tr>';


                                });
                                $('#priceLookUpResult').append(trHTML);

                            }
                        });//End of get price

                    }
                });
            }

            if (($('#invoiceNo').val()).length > 1)
            {
                $('#changeDeliveryAddressOnNotInvoiced').hide();
            }else{
                $('#changeDeliveryAddressOnNotInvoiced').show();
            }

            $('body').pleaseWait('stop');
        });//END OF SUBMITFILTER


        $('#changeDeliveryAddress').click(function () {
            $('#listOfDelivAdress').show();
            $("#listOfDelivAdress").dialog({
                height: 700,
                width: 1100, containment: false
            }).dialogExtend({
                "closable": true, // enable/disable close button
                "maximizable": false, // enable/disable maximize button
                "minimizable": true, // enable/disable minimize button
                "collapsable": true, // enable/disable collapse button
                "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                "titlebar": false, // false, 'none', 'transparent'
                "minimizeLocation": "right", // sets alignment of minimized dialogues
                "icons": { // jQuery UI icon class
                    "close": "ui-icon-circle-close",
                    "maximize": "ui-icon-circle-plus",
                    "minimize": "ui-icon-circle-minus",
                    "collapse": "ui-icon-triangle-1-s",
                    "restore": "ui-icon-bullet"
                },
                "load": function (evt, dlg) {
                }, // event
                "beforeCollapse": function (evt, dlg) {
                }, // event
                "beforeMaximize": function (evt, dlg) {
                }, // event
                "beforeMinimize": function (evt, dlg) {
                }, // event
                "beforeRestore": function (evt, dlg) {
                }, // event
                "collapse": function (evt, dlg) {
                }, // event
                "maximize": function (evt, dlg) {
                }, // event
                "minimize": function (evt, dlg) {
                }, // event
                "restore": function (evt, dlg) {
                } // event
            });
            ;
            $('#listaddresses li').on('click', function () {
                var $this = $(this);
                var selKeyVal = $this.attr("value");
                $("#deliveryAddressIdOnPopUp").val(selKeyVal);
                $("#hiddenDeliveryAddressId").val(selKeyVal);
            });

        });
        /*  $('#orderPatternIdTable').on('dblclick', 'tr', function() {
         $(this).closest("tr").hide();
         });*/

        $('.inputs').keydown(function (event) {
            if (!$(this).hasClass("last")) {
                if (event.which == 13) {
                    event.preventDefault();

                    // generateALine();
                }
            }
        });
        /**
         * ON Double Click pattern row add this to the busket
         * */
        $('#orderPatternIdTable').on('dblclick', 'tbody tr', function () {

            if (($('#invoiceNoKeeper').val()).length < 2) {

                var $this = $(this);
                var row = $this.closest("tr");
                var producutDescr = row.find('td:eq(0)').text();
                var cost = row.find('td:eq(4)').text();
                var inStock = row.find('td:eq(3)').text();
                var productCode = row.find('td:eq(6)').text();
                var unitSizes = row.find('td:eq(9)').text();
                var tax = row.find('td:eq(8)').text();
                //var tax = '14.0';
                console.debug("unitSizes on double click"+unitSizes);

                productPriceOnReadyMadeLine(productCode,producutDescr,tax,cost,'authorised',inStock,unitSizes);
                // console.debug("*************"+ $(this).find(".prodPrice_").val(12));
                row.remove();
            }

        });
        $('#orderPatternIdTable').on('click', 'tbody tr', function () {

            // if (($('#invoiceNoKeeper').val()).length < 2) {
            var $this = $(this);
            var row = $this.closest("tr");
            var productCode = row.find('td:eq(6)').text();
            qtyAvailableOnClick(productCode);

            //}

        });
        $('#customerSpecials tbody').on('dblclick', 'tr', function () {
//Disable double click  orderPatternIdTable
            if (($('#invoiceNoKeeper').val()).length < 2) {

                var $this = $(this);
                var row = $this.closest("tr");
                var producutDescr = row.find('td:eq(0)').text();
                var productCode = row.find('td:eq(1)').text();
                var Prodcost = $(this).find('#Prodcost').val();
                var ProdQnt = $(this).find('#ProdQnt').val();
                var titles = $(this).find('#titles').val();
                var tax = $(this).find('#taxCode').val();
                var price = '';
                //tag,prodDesc,prodCodes,prodQty,price,cost,instock,titles
                // console.debug("*************"+ $(this).find(".prodPrice_").val(12));
                productPriceOnReadyMadeLine(productCode,producutDescr,tax,Prodcost,titles,ProdQnt);

            }
        });
        $('#groupSpecials tbody').on('dblclick', 'tr', function () {
            if (($('#invoiceNoKeeper').val()).length < 2) {

                var $this = $(this);
                var row = $this.closest("tr");
                var producutDescr = row.find('td:eq(0)').text();
                var productCode = row.find('td:eq(1)').text();
                var Prodcost = $(this).find('#Prodcost').val();
                var ProdQnt = $(this).find('#ProdQnt').val();
                var titles = $(this).find('#titles').val();
                var tax = $(this).find('#taxCode').val();
                var price = '';

                productPriceOnReadyMadeLine(productCode,producutDescr,tax,Prodcost,titles,ProdQnt);

            }

        });
        /**
         * ON Double click the past invoice product add  it to the busket
         * */
        $('#pastInvoices tbody').on('dblclick', 'tr', function () {
            //Disable the double click if it is already invoiced
            if (($('#invoiceNoKeeper').val()).length < 2) {

                if ($(this).find(".dontTakeme").val().length > 1) {
                } else {
                    var productCode = $(this).find(".foo").val();
                    var $this = $(this);
                    var row = $this.closest("tr");
                    var producutDescr = row.find('td:eq(0)').text();
                    var Prodcost = $(this).find('#Prodcost').val();
                    var ProdQnt = $(this).find('#ProdQnt').val();
                    var titles = $(this).find('#titles').val();
                    var tax = $(this).find('#taxCode').val();
                    var UnitSizes = $(this).find('#UnitSizes').val();
                    console.debug(" on PastInvoice" + UnitSizes);
                    var priceReturned = getPriceForProductDependingOnCustAndDeliveryDate('{!!url("/getCutomerPriceOnOrderForm")!!}', $('#inputCustAcc').val(), $('#inputDeliveryDate').val(), productCode);
                    console.debug('priceReturned' + priceReturned);

                    $.ajax({
                        url: '{!!url("/getCutomerPriceOnOrderForm")!!}',
                        type: "POST",
                        data: {
                            customerID: $('#inputCustAcc').val(),
                            deliveryDate: $('#inputDeliveryDate').val(),
                            productCode: productCode
                        },
                        success: function (data) {
                            console.debug(data);
                            var price = ''
                            if ($.isEmptyObject(data)) {
                                price = '';
                                readyMadeLineOrderLine('#table tbody', producutDescr, productCode, '', price, Prodcost, ProdQnt, titles, tax,UnitSizes,'0');
                            } else {
                                price = parseFloat(data[0].Price).toFixed(2);
                                if (reportmarginControl === 'marginType5')
                                {

                                    readyMadeLineOrderLine('#table tbody', producutDescr, productCode, '', price, Prodcost, ProdQnt, '', tax,UnitSizes,data[0].Prohibited);

                                }else{
                                    readyMadeLineOrderLine('#table tbody', producutDescr, productCode, '', price, Prodcost, ProdQnt, titles, tax,UnitSizes,data[0].Prohibited);
                                }
                            }

                        }
                    });

                    row.remove();
                }
            }
        });


        //On click show available
        $('#table tbody').on('click', 'tr', function () {

            var  $this = $(this);
            var row_closestTrColumns = $this.closest('tr');
            var prodCode1 = row_closestTrColumns.find('.theProductCode_').val();
            if(prodCode1.length > 0)
            {
                qtyAvailableOnClick(prodCode1);
            }else
            {
                console.debug('product code length*******'+prodCode1.length);
            }


        });

        datePicker();
        validate();
        $('#inputCustAcc, #inputCustName, #inputDeliveryDate,#routeName').change(validate);
        $("#routeName").on("change", function () {
            GlobalRouteId = this.value;
        });

        /* $("#orderType").on("change", function () {

         // alert('Please change this');
         //GlobalOrderType = this.value;
         });*/
        var previous;
        var previousText;
        var previousRouteVal;
        var previousTextRoute;


        var lastValue;
        $("#orderType").bind("click", function(e){
            lastValue = $(this).val();
        }).bind("change", function(e){
            changeConfirmation = confirm("Are you sure?");
            if (changeConfirmation) {
                if( ($('#orderId').val()).length > 1 ) {

                    consoleManagement('{!!url("/logMessageAjax")!!}', 12, 1, 'OrderType Changed To '+$("#orderType").find("option:selected").text() +' by '+byWho, 0, $('#orderId').val(), 0, 0, 0, 0, 0,  0, $('#orderId').val(), 0, computerName, $('#orderId').val(), 0);
                }
            } else {
                $(this).val(lastValue);
            }
        });

        /* $("#orderType").on('change', function () {
         if( ($('#orderId').val()).length > 1 ) {

         }
         });*/

        /* ON BUTTON TO CREATE NEW LINE*/
        $('#button_row').click(function () {
            var tr = $('#table tr:last');
            GLOBALPRODCODE = $(tr).find("td").find('input.theProductCode_').val();
            GLOBALPRODUCTDESCRIPTION = $(tr).find("td").find('input.prodDescription_').val();
            GLOBALPRICE = $(tr).find("td").find('input.prodPrice_').val();
            GLOBALQUANTITY = $(tr).find("td").find('input.prodQty_').val();
            GLOBALBULK = $(tr).find("td").find('input.prodBulk_').val();
            GLOBALCOMMENT = $(tr).find("td").find('input.prodComment_').val();
            GLOBALDISC = $(tr).find("td").find('input.prodDisc_').val();

            if (GLOBALQUANTITY.length > 0 &&
                GLOBALPRODCODE.length > 0 &&
                GLOBALPRICE.length > 0 &&
                GLOBALPRODUCTDESCRIPTION.length > 0) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                TotalExc = TotalExc + (parseFloat(GLOBALPRICE) * parseFloat(GLOBALQUANTITY)).toFixed(2);
                //generateALine();
                generateALine2();
            }
            else {
                $("<div title='Fill in required fields'>Please make sure all required fields such as <br>Product code and Description<br>Quantity<br> Price<br> Discount <br>Contains Data Before saving </div>").dialog({modal: true});

            }

        });
        /* $('#cancelThis').on('click', function () {
         //test
         $(this).closest('tr').remove();
         calculator();
         });*/

        /* END OF -----ON BUTTON TO CREATE NEW LINE*/
        var inputCustNames = $('#inputCustName').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            focusFirstResult: true,
            searchContain:true,
            visibleProperties: ["StoreName","CustomerPastelCode"],
            searchIn: 'StoreName',
            data: finalData
        });
        inputCustNames.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#inputDeliveryDate').focus();
            $('#creditLimit').val(data.CreditLimit);
            $('#balDue').val(parseFloat(data.BalanceDue).toFixed(2));
            $('#boozeLisence').val(data.UserField5);
            $("#submitFilters").prop("disabled", false);
            $('#customerEmail').val(data.Email);
            $('#Routeid').val(data.Routeid);
            $('#hiddenCustDiscount').val(data.Discount);
            $('#dicPercHeader').val(data.Discount);
            $('#hiddenCustomerNotes').val(data.OtherImportantNotes);
            $('#hiddenRouteId').val(data.Routeid);
            $('#hiddenRouteName').val(data.strRoute);
            GlobalcustomerId = data.CustomerId;
        });


//////////////////////////////////////////////////

        var custAcc = $('#customerCodeOrderListing').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'CustomerPastelCode',
            data: finalDataAll
        });

        var custDescriptionOrderListing = $('#customerDescriptionOrderListing').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'StoreName',
            data: finalDataAll
        });
        custDescriptionOrderListing.on('select:flexdatalist', function (event, data) {

            $('#customerCodeOrderListing').val(data.CustomerPastelCode);
            $('#customerDescriptionOrderListing').val(data.StoreName);

        });
        custAcc.on('select:flexdatalist', function (event, data) {

            $('#customerCodeOrderListing').val(data.CustomerPastelCode);
            $('#customerDescriptionOrderListing').val(data.StoreName);

        });

        ///////////////////

        var inputCustAccount = $('#inputCustAcc').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'CustomerPastelCode',
            data: finalData
        });
        inputCustAccount.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#inputDeliveryDate').focus();
            $('#creditLimit').val(data.CreditLimit);
            $('#balDue').val(parseFloat(data.BalanceDue).toFixed(2));
            $('#boozeLisence').val(data.UserField5);
            $("#submitFilters").prop("disabled", false);
            $('#customerEmail').val(data.Email);
            $('#Routeid').val(data.Routeid);
            $('#hiddenCustDiscount').val(data.Discount);
            $('#dicPercHeader').val(data.Discount);
            $('#hiddenCustomerNotes').val(data.OtherImportantNotes);
            $('#hiddenRouteId').val(data.Routeid);
            $('#hiddenRouteName').val(data.strRoute);
            GlobalcustomerId = data.CustomerId;
        });
        var custCodeOnOrder = $('#custCodeOnOrder').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'CustomerPastelCode',
            data: finalData
        });
        custCodeOnOrder.on('select:flexdatalist', function (event, data) {

            $('#custCodeOnOrder').val(data.CustomerPastelCode);
            $('#custDescOnOrder').val(data.StoreName);

        });
        var custCodePl = $('#custCodePl').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'CustomerPastelCode',
            data: finalData
        });
        custCodePl.on('select:flexdatalist', function (event, data) {

            $('#custCodePl').val(data.CustomerPastelCode);
            $('#custDescPl').val(data.StoreName);

        });
        var custDescOnOrder = $('#custDescOnOrder').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'StoreName',
            data: finalData
        });
        custDescOnOrder.on('select:flexdatalist', function (event, data) {

            $('#custCodeOnOrder').val(data.CustomerPastelCode);
            $('#custDescOnOrder').val(data.StoreName);

        });

        var custDescPl = $('#custDescPl').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'StoreName',
            data: finalData
        });
        custDescPl.on('select:flexdatalist', function (event, data) {

            $('#custCodePl').val(data.CustomerPastelCode);
            $('#custDescPl').val(data.StoreName);

        });

        $("#productCodeOnOrder").mcautocomplete({
            source: finalDataProduct,
            columns: columnsC,
            minlength: 1,
            autoFocus: true,
            delay: 0,
            select: function (e, ui) {
                $('#productDescOnOrder').val(ui.item.PastelDescription);
                $('#productCodeOnOrder').val(ui.item.PastelCode);
            }
        });

        var columnsC = [{name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'},
            {name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
            {name: 'Available', minWidth:'20px',valueField: 'Available'}];
        $("#productCodeOnOrder").mcautocomplete({
            source: finalDataProduct,
            columns: columnsC,
            minlength: 1,
            autoFocus: true,
            delay: 0,
            appendTo: "#prodOnOrder",
            select: function (e, ui) {
                $('#productDescOnOrder').val(ui.item.PastelDescription);
                $('#productCodeOnOrder').val(ui.item.PastelCode);
            }
        });
        $("#productCodePl").mcautocomplete({
            source: finalDataProduct,
            columns: columnsC,
            minlength: 1,
            autoFocus: true,
            delay: 0,
            appendTo: "#priceLookPriceWithCustomer",
            select: function (e, ui) {
                $('#productDescPl').val(ui.item.PastelDescription);
                $('#productCodePl').val(ui.item.PastelCode);
                $('#unitOfSale').empty();
                $('#unitOfSale').append(ui.item.UnitSize);

            }
        });
        var columnsD = [{name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
            {name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'}
            ,{name: 'Available', minWidth:'20px',valueField: 'Available'}];
        $("#productDescOnOrder").mcautocomplete({
            source: finalDataProductTest,
            columns: columnsD,
            autoFocus: true,
            minlength: 2,
            delay: 0,
            multiple: true,
            multipleSeparator: " ",
            appendTo: "#prodOnOrder",
            select: function (e, ui) {
                $('#productDescOnOrder').val(ui.item.PastelDescription);
                $('#productCodeOnOrder').val(ui.item.PastelCode);
            }
        });
        $("#productDescPl").mcautocomplete({
            source: finalDataProductTest,
            columns: columnsD,
            autoFocus: true,
            minlength: 2,
            delay: 0,
            multiple: true,
            multipleSeparator: " ",
            appendTo: "#priceLookPriceWithCustomer",
            select: function (e, ui) {
                $('#productDescPl').val(ui.item.PastelDescription);
                $('#productCodePl').val(ui.item.PastelCode);
                $('#unitOfSale').empty();
                $('#unitOfSale').append(ui.item.UnitSize);
            }
        });



        $("#invoiceNo").autocomplete({
            source: '{!!url("/invoiceLookUp")!!}',
            minlength: 2,
            autoFocus: true,
            select: function (e, ui) {
                $('#invoiceNo').val(ui.item.value);
                $('#orderId').val(ui.item.id);

            }
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var table = '<table class="table2"><tr style="font-size: 12px;color:black"><td style="background: green;width:25px;color:white">' +
                item.value + '</td><td>' +
                item.id + '</td><td style="background: green;width:25px;color:white">' +
                item.CustomerPastelCode + '</td><td>' +
                item.StoreName + '</td>' +
                '</tr></table>';
            return $("<li>")
                .data("ui-autocomplete-item", item)
                .append("<a>" + table + "</a>")
                .appendTo(ul);
        };

        $('#theProductCode').autocomplete({
            source: '{!!url("/prodCode")!!}',
            minlength: 1,
            autoFocus: true,
            select: function (e, ui) {
                $('#theProductCode').val(ui.item.value);
                $('#theProductDescription').val(ui.item.extra);
                //generateALine();
                generateALine2();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{!!url("/getCutomerPriceOnOrderForm")!!}',
                    type: "POST",
                    data: {
                        customerID: $('#inputCustAcc').val(),
                        deliveryDate: $('#inputDeliveryDate').val(),
                        productCode: $('#theProductCode').val()
                    },
                    success: function (data) {

                        console.debug("the price" + parseFloat(data[0].Price).toFixed(2));
                        $('#thePrice').val(parseFloat(data[0].Price).toFixed(2));

                    }
                });
            }
        });

        $('#theProductDescription').autocomplete({
            source: '{!!url("/prodDesciption")!!}',
            minlength: 2,
            autoFocus: true,
            select: function (e, ui) {
                $('#theProductDescription').val(ui.item.value);
                $('#theProductCode').val(ui.item.extra);
                //generateALine();
                generateALine2();
                $('#theQuantity').val("0.00");
                $('#theDisc').val("0.00");
                $('#theUnitSize').val(ui.item.unitSize);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{!!url("/getCutomerPriceOnOrderForm")!!}',
                    type: "POST",
                    data: {
                        customerID: $('#inputCustAcc').val(),
                        deliveryDate: $('#inputDeliveryDate').val(),
                        productCode: $('#theProductCode').val()
                    },
                    success: function (data) {
                        console.debug("the price" + parseFloat(data[0].Price).toFixed(2));
                        $('#thePrice').val(parseFloat(data[0].Price).toFixed(2));

                    }
                });
            }
        });
        $('#invoiceNow').on('click', function () {
            $('<div></div>').appendTo('body')
                .html('<div><h6>Yes or No?</h6></div>')
                .dialog({
                    modal: true,
                    title: 'Click Yes to invoice this Order or No to save',
                    zIndex: 10000,
                    autoOpen: true,
                    width: '50%',
                    resizable: false,
                    buttons: {
                        DelUser: {
                            class: 'leftButton',
                            text: 'Point Of Sale ',
                            click: function () {
                                finishArray2($('#inputCustAcc').val(), $('#orderId').val(), '{!!url("/jsonOrderDetails")!!}');
                                upDateOrderHeaderAndPOS();
                                consoleManagement('{!!url("/logMessageAjax")!!}', 600, 3, 'Point Of Sale button Clicked', 0, 0, 0, 0, 0, 0, 0, 0, $('#orederNumber').val(), 0, computerName, $('#orderId').val(), 0);

                            }
                        },
                        Yes: function () {
                            //Update the tblOrders and tblOrdersDetails here
                            if (($('#invoiceNo').val()).length > 0) {
                                disableOnFinish();
                                $(this).dialog("close");
                            } else {

                                finishArray2($('#inputCustAcc').val(), $('#orderId').val(), '{!!url("/jsonOrderDetails")!!}');
                                $.ajax({
                                    url: '{!!url("/updateOrderHeader")!!}',
                                    type: "POST",
                                    data: {
                                        orderDate: $('#inputOrderDate').val(),
                                        orderId: $('#orderId').val(),
                                        deliveryDate: $("#inputDeliveryDate").val(),
                                        routeId: $('#routeName').val(),
                                        OrderType: $('#orderType').val(),
                                        orderNo: $('#orederNumber').val(),
                                        messagebox: $('#messagebox').val(),
                                        awaitingStock: $('#awaitingStock').val(),
                                        customerCode: $('#inputCustAcc').val(),
                                        DeliveryAddressID: $('#hiddenDeliveryAddressId').val(),
                                        address1hidden: $('#address1hidden').val(),
                                        address2hidden: $('#address2hidden').val(),
                                        address3hidden: $('#address3hidden').val(),
                                        address4hidden: $('#address4hidden').val(),
                                        address5hidden: $('#address5hidden').val()
                                    },
                                    success: function (data) {
                                        printDoc('{!!url("/intoTblPrintedDoc")!!}', 1, $('#orderId').val(), 0,$('#invoiceNo').val());
                                        consoleManagement('{!!url("/logMessageAjax")!!}', 300, 2, 'Document has been send to the printer', 0, 0, 0, 0, 0, 0, 0, 0, $('#orederNumber').val(), 0, computerName, $('#orderId').val(), 0);

                                        disableOnFinish();

                                        //}
                                        // generateALine();

                                    }
                                });
                            }

                            $(this).dialog("close");
                        },
                        No: function () {

                            $(this).dialog("close");
                        }
                    },
                    close: function (event, ui) {
                        $(this).remove();
                    }
                });

        });
        $('#reprintInvoice').on('click',function(){
            var dialog = $('<p><strong style="color:black">Click Yes to Reprint</strong></p>').dialog({
                height: 200, width: 700,modal: true,containment: false,
                buttons: {
                    Yes: function () {
                        $('#reprintAuth').show();
                        showDialog('#reprintAuth','65%',420);
                        $(this).dialog("close");
                        $('#doAuthReprint').click(function(){
                            authReprints();

                        });

                    },
                    No: function () {
                        $(this).dialog("close");
                        disableOnFinish();
                    }
                }
            });

        });
        //reprint the Invoice
        $('#reprintInvoiceOnTablet').on('click',function(){
            var dialog = $('<p><strong style="color:black">Click Yes to Reprint</strong></p>').dialog({
                height: 200, width: 700,modal: true,containment: false,
                buttons: {
                    Yes: function () {
                        $('#reprintAuth').show();
                        showDialog('#reprintAuth','65%',420);
                        $(this).dialog("close");
                        $('#doAuthReprint').click(function(){
                            authReprintsOnTabletLoading();

                        });

                    },
                    No: function () {
                        $(this).dialog("close");
                        $( "#tabletLoadingDocDetails" ).dialog('close');
                        //disableOnFinish();
                    }
                }
            });

        });

        //DELETE A LINE
        $('#table').on('click', 'button', function (e) {
            var $this = $(this);
            var row_index = $this.closest('tr').index();
            var row_closestTrColumns = $this.closest('tr');
            var orderLineID = $this.attr("value");

            var prodCode1 = row_closestTrColumns.find('.theProductCode_').val();
            console.debug('Order Details------------**************** '+orderLineID);

            if(orderLineID === "undefined" || orderLineID === undefined) {
                if (($('#invoiceNo').val()).length < 1) {
                    $this.closest('tr').remove();
                    var prodCode2 = row_closestTrColumns.find('.theProductCode_').val();
                    console.debug('prodCode2- AFTER------------****************'+prodCode2);
                    if (prodCode2 === prodCode1)
                    {
                        //console.debug('they are equal - AFTER------------**************** '+prodCode2);
                        $this.closest('tr').remove();
                    }
                    //   generateALine2();
                    calculator();

                }

                if (row_index < 1 && ($('#invoiceNo').val()).length < 1) {
                    //generateALine();
                    calculator();
                    generateALine2();
                }

            }
            else
            {
                $.ajax({
                    url:'{!!url("/DeleteOrderDetailsOrtherTrans")!!}',
                    type: "POST",
                    data: {
                        OrderId: $('#orderId').val(),
                        OrderDetailId: orderLineID},
                    success: function(data){

                        if (data.deletedId != 'FAILED')
                        {
                            if (($('#invoiceNo').val()).length < 1) {
                                $this.closest('tr').remove();
                                calculator();
                                generateALine2();
                            }
                        }
                        else
                        {
                            // $('#table').on('click', 'button', function (e) {
                            var dialog = $('<p><strong style="color:red">Sorry something went wrong when deleting a line ,please try again</strong></p>').dialog({
                                height: 200, width: 700,modal: true,containment: false,
                                buttons: {
                                    "Okay": function () {
                                        dialog.dialog('close');
                                    }
                                }
                            });
                        }
                        calculator();

                    }});

                if (row_index < 1 && ($('#invoiceNo').val()).length < 1) {
                    //generateALine();
                    generateALine2();
                }
            }

            calculator();
        });


        function datePicker() {
            var today = new Date();
            $("#inputDeliveryDate").datepicker({
                changeMonth: true,//this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: 'dd-mm-yy'
            });
            $("#changeDelvDate").datepicker({
                changeMonth: true,//this option for allowing user to select month
                changeYear: true //this option for allowing user to select from year range
                //minDate: today
            });
            $("#inputOrderDate").datepicker({
                changeMonth: true,//this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: 'dd-mm-yy'
            });
            $("#deliveryDateOrderListing").datepicker({
                changeMonth: true,//this option for allowing user to select month
                changeYear: true //this option for allowing user to select from year range
            });

            var currentdate = new Date();
            $("#callListOrderDate").val($.datepicker.formatDate('dd-mm-yy', currentdate));
            $("#callListDeliveryDate").val($.datepicker.formatDate('dd-mm-yy', currentdate));
            $("#callListDeliveryDate").datepicker({
                changeMonth: true,//this option for allowing user to select month
                changeYear: true,
                dateFormat: "dd-mm-yyyy" //this option for allowing user to select from year range
            });
            $("#callListOrderDate").datepicker({
                changeMonth: true,//this option for allowing user to select month
                changeYear: true //this option for allowing user to select from year range
            });
            $("#copyDeliveryDate").datepicker({
                changeMonth: true,//this option for allowing user to select month
                changeYear: true //this option for allowing user to select from year range
            });
            //getDataFromTblManagement()

            $('#button_user_actions').on('click',function(){
                $('#userActionGrid').show();
                showDialog('#userActionGrid', '65%', 500);
                getDataFromTblManagement();
                $('#refreshUserActionDataGrid').click(function(){
                    datatableUserActions.draw();
                });
            });



        }
        /**
         * ON SALES ORDER
         * */
        $('#salesOnOrder').click(function(){
            $('#prodOnOrder').show();
            showDialog('#prodOnOrder','85%',640);
            productsOnOrder();
            $('#tblOnsalesOrder tbody').on('click', 'tr', function (e){
                $("#tblOnsalesOrder tbody tr").removeClass('row_selected');
                $(this).addClass('row_selected');
                globalOrderIdToBePushed = [];
                arrayOfCustomerInfo = [];
                $('#orderIds').val('');
                var rowOnOrder =  $(this).closest("tr");
                var orderIDrowOnOrder = rowOnOrder.find('td:eq(0)').text();
                globalOrderIdToBePushed.push(orderIDrowOnOrder);
                arrayOfCustomerInfo.push(rowOnOrder.find('td:eq(1)').text());
                arrayOfCustomerInfo.push(rowOnOrder.find('td:eq(2)').text());
                arrayOfCustomerInfo.push(rowOnOrder.find('td:eq(3)').text());
            });
            $('#callSpOnOrder').click(function(){
                productsOnOrder();
            });

        });
        //Search method

        quickSearchOnCustomerPrioritisePastelCode(finalData,'#inputCustCustomers');
        onChangeCustomerOnDispatchForm("#custDescriptionListOfOrder");
        $('#finishedDispatching').click(function(){
            var productsLinesOnPicking = new Array();
            $('#tableDispatch > tbody  > tr').each(function() {
                var data = $(this);
                var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                console.debug($(this).closest('tr').find('.theProductCode_').val());
                productsLinesOnPicking.push({'productCode': $(this).closest('tr').find('.theProductCode_').val(),'desc':  $(this).closest('tr').find('.prodDescription_').val(),
                    'qty':$(this).closest('tr').find('.prodQty_').val(),'price':$(this).closest('tr').find('.prodPrice_').val(),'comment':$(this).closest('tr').find('.prodComment_').val(),
                    'orderDetailID':orderDetailID,'customerCode':$('#inputCustAcc').val()});
            });
            var dialog = $('<p>Do you want to Print this Invoice?</p>').dialog({
                height: 200, width: 700, modal: true, containment: false,
                buttons: {
                    Yes: function () {

                        $.ajax({
                            url: '{!!url("/printAdjustmentDispatch")!!}',
                            type: "POST",
                            data: {
                                orderId: $('#orderIds').val(),
                                message: $('#dispatchMessage').val(),
                                prodLines: productsLinesOnPicking,
                                orderNo:$('#orderNumberOnDispatch').val(),
                                awaiting:$('#awaitingStockOnDispatchOrPickingForm').val()
                            },
                            success: function (dataDetails) {

                                if (!$.isEmptyObject(dataDetails)){


                                    $('.fast_remove_backOrder').remove();
                                    dialog.dialog('close');
                                    $('#dispatchQuantityForm').dialog('close');
                                }
                            }
                        });

                    },
                    No: function () {
                        //Change the dispatch qty
                        adjustQuantingOnPickingForm($('#orderIds').val(),$('#dispatchMessage').val(),'{!!url("/adjustDispatch")!!}',$('#inputCustAcc').val());
                        $('.fast_remove').remove();

                        $('#orderIds').val('');
                        if (($('#orderIds').val()).length < 1){
                            dialog.dialog('close');
                        }
                        $('#dispatchQuantityForm').dialog('close');
                    }
                }
            });
            $('#orderIdlbl').append($('#orderIds').val());
            $('#orderNolbl').append($('#orderIds').val());
            $('#deliveryDatelbl').append($('#DeliveryDate').val());
            $('#custAcclbl').append($('#inputCustAcc').val());
            $('#custDesclbl').append($('#inputCustName').val());

        });
        $('.btnPrint').printPage();
    });

    function validate(){
        if ($('#inputCustAcc').val().length   >   0   &&
            $('#inputCustName').val().length  >   0   &&
            $('#inputDeliveryDate').val().length    >   0) {
            $("#submitFilters").prop("disabled", false);
            // getTheCustomerId();
            getCustomerRoutesPriority('#routeName','{!!url("/getCustomerRoutes")!!}',$('#inputCustAcc').val());

            //
        }
        else {
            $("#submitFilters").prop("disabled", true);
            $("#inputDeliveryDate").prop("disabled", false);
            $("#inputCustName").prop("disabled", false);
            $("#inputCustAcc").prop("disabled", false);
        }
    }
    /**
     * This function also includes the past ten invoices of a customer
     */
    function customerAndGroupSpecials()
    {
        //CUSTOMER SPECIALS
        $.ajax({
            url: '{!!url("/combinedSpecials")!!}',
            type: "POST",
            data: {
                customerCode: $('#inputCustAcc').val(),
                deliveryDate: $('#inputDeliveryDate').val()
            },
            success: function (data) {

                var trHTML = '';
                console.debug("combined special"+data);

                $.each(data.customerSpecials, function (key, value) {
                    trHTML += '<tr class="fast_remove" style="font-size: 9px;color:black"><td>' +
                        value.PastelDescription + '</td><td>' +
                        value.PastelCode + '</td><td>' +
                        parseFloat(value.Price).toFixed(2) + '</td><td>' +
                        value.DateFrom + '</td><td>' +
                        value.DateTo +
                        '<input type="hidden" id="' + value.PastelCode + '" value="' + value.PastelCode + '" style="width:1px" class="foo">' +
                        '<input type="hidden" id="Prodcost" value="' + parseFloat(value.Cost).toFixed(2) + '" style="width:1px" >' +
                        '<input type="hidden" id="ProdQnt" value="' + parseFloat(value.QtyInStock).toFixed(2) + '" style="width:1px" ></td>' +
                        '<input type="hidden" id="titles" value="authorised" style="width:1px" ><input type="hidden" id="taxCode" class="taxCodes" value="' + value.Tax + '" style="width:1px" ></td>' +
                        '</td></tr>';

                });
                $('#customerSpecials').append(trHTML);
                var trHTML = '';

                $.each(data.GroupSpecials, function (key, value) {
                    trHTML += '<tr class="fast_remove"  style="font-size: 9px;color:black"><td>' +
                        value.PastelDescription + '</td><td>' +
                        value.PastelCode + '</td><td>' +
                        parseFloat(value.Price).toFixed(2) + '</td><td>' +
                        value.DateFrom + '</td><td>' +
                        value.DateTo +
                        '<input type="hidden" id="' + value.PastelCode + '" value="' + value.PastelCode + '" style="width:1px" class="foo">' +
                        '<input type="hidden" id="Prodcost" value="' + parseFloat(value.Cost).toFixed(2) + '" style="width:1px" >' +
                        '<input type="hidden" id="ProdQnt" value="' + parseFloat(value.QtyInStock).toFixed(2) + '" style="width:1px" ></td>' +
                        '<input type="hidden" id="titles" value="authorised" style="width:1px" ><input type="hidden" id="taxCode" class="taxCodes" value="' + value.Tax + '" style="width:1px" ></td>' +
                        '</td></tr>';


                });
                $('#groupSpecials').append(trHTML);
                var trHTML = '';
                var inv = 'id';
                var counter = 0;
                $.each(data.pastInvoices, function (key,value) {
                    if (inv != value.InvoiceNo )
                    {
                        var k = parseInt(counter)+parseInt(1);
                        trHTML +='<tr ondblclick="this.style.display = none" class="fast_remove" style="font-size: 11px;" onclick="show_hide_row(\'hidden_row1'+ k +'\') ;"><td>'+
                            value.InvoiceNo +'</td><td>'+
                            value.OrderDate +'</td><td>'+
                            value.DeliveryDate +'</td><td>'+
                            value.OrderNo +'<input type="hidden" class="dontTakeme" value="thisIsIt"></td><td></tr>';
                        counter++;
                    }

                    trHTML +='<tr style="font-size: 9px;color: black" class="hidden_row1'+counter+' hidden_row">'+
                        '<td style="padding: 0px;">'+value.PastelDescription+'</td>'+
                        '<input type="hidden" id="' + value.PastelCode + '" value="' + value.PastelCode + '" style="width:1px" class="foo">' +
                        '<input type="hidden" id="Prodcost" value="' + parseFloat(value.Cost).toFixed(2) + '" style="width:1px" >' +
                        '<input type="hidden" id="ProdQnt" value="' + parseFloat(value.QtyInStock).toFixed(2) + '" style="width:1px" ></td>' +
                        '<input type="hidden" id="titles" value="authorised" style="width:1px" ><input type="hidden" class="dontTakeme" value=""><input type="hidden" id="UnitSizes" value="' + value.UnitSize + '" style="width:1px" ></td>' +
                        '<td style="padding: 0px;">' +parseFloat(value.Qty).toFixed(2) + '</td><tr>';

                    inv = value.InvoiceNo

                });
                $('#pastInvoices').append(trHTML);

                //data.contacts[0].
                $.each(data.contacts, function (key,value){
                    $('#contactCellOnDispatch').val(value.CellPhone);
                    $('#contactPersonOnDispatch').val(value.ContactPerson);
                    $('#telOnDispatch').val(value.ContactTel);
                });

            }
            ,
            error: function (xhr, textStatus, errorThrown) {
                if (textStatus == 'timeout') {
                    this.tryCount++;
                    if (this.tryCount <= this.retryLimit) {
                        //try again
                        $.ajax(this);
                        return;
                    }
                    return;
                }
                if (xhr.status == 500) {
                    //handle error
                } else {
                    //handle error
                }
            }
        });

    }
    function PL()
    {
        $.ajax({
            url: '{!!url("/productPriceLookUp")!!}' ,
            type: "POST",
            data:{productCode:$('#productCodePl').val(),customerCode:$('#custCodePl').val()},
            success: function(data){

                var trHTML = '';
                $('#priceCheckByCustomer tbody').empty();
                $.each(data.priceList, function (key, value) {
                    trHTML += '<tr  class="rebuild_price_check_list" style="font-size: 10px;color:black"><td>' +
                        value.PriceList + '</td><td><strong>' +
                        (parseFloat(value.Price)).toFixed(2) + '</strong></td><td>' +
                        (parseFloat(value.PriceInc)).toFixed(2) + '</td><td>' +
                        '</td></tr>';
                });
                $('#priceCheckByCustomer').append(trHTML);
                var trHTML = '';
                $('#individualCost tbody').empty();

                switch(accounting)
                {
                    case 'Pastel':
                        $.ajax({
                            url: '{!!url("/stockApi")!!}',
                            type: "POST",
                            data: {
                                ItemCode:$('#productCodePl').val()
                            },
                            success: function (data3) {
                                $.each(data.stock, function (key, value) {
                                    trHTML += '<tr  class="rebuild_price_check_list" style="font-size: 10px;color:black"><td>' +
                                        (parseFloat(value.Cost)).toFixed(2) + '</td><td><strong>' +
                                        data3  + '</strong></td>'+

                                        '</td></tr>';
                                });
                                $('#individualCost').append(trHTML);
                                var trHTML = '';
                                $('#individualPriceCheckByCustomer tbody').empty(); //+ value.Price
                                $.each(data.productPriceForCust, function (key, value) {
                                    var pricesInc =  (parseFloat(value.Price * value.Tax ) + parseFloat(value.Price)).toFixed(2);
                                    trHTML += '<tr  class="rebuild_price_check_list" style="font-size: 18px;color:black"><td>' +
                                        pricesInc+ '</td><td><strong>' +
                                        (parseFloat(value.Price)).toFixed(2) + '</strong></td>' +
                                        '</tr>';
                                });
                                $('#individualPriceCheckByCustomer').append(trHTML);
                            }
                        });
                        break;
                    case 'Other':

                        $.each(data.stock, function (key, value) {
                            trHTML += '<tr  class="rebuild_price_check_list" style="font-size: 10px;color:black"><td>' +
                                (parseFloat(value.Cost)).toFixed(2) + '</td><td><strong>' +
                                value.Remaining  + '</strong></td>'+

                                '</td></tr>';
                        });
                        $('#individualCost').append(trHTML);
                        var trHTML = '';
                        $('#individualPriceCheckByCustomer tbody').empty(); //+ value.Price
                        $.each(data.productPriceForCust, function (key, value) {
                            var pricesInc =  (parseFloat(value.Price * value.Tax ) + parseFloat(value.Price)).toFixed(2);
                            trHTML += '<tr  class="rebuild_price_check_list" style="font-size: 18px;color:black"><td>' +
                                pricesInc+ '</td><td><strong>' +
                                (parseFloat(value.Price)).toFixed(2) + '</strong></td>' +
                                '</tr>';
                        });
                        $('#individualPriceCheckByCustomer').append(trHTML);
                        break;

                }



            }
        });
    }
    function productsOnOrder()
    {

        productsOnOrders = $('#tblOnsalesOrder').DataTable({
            "ajax": {
                url: '{!!url("/productsOnOrder")!!}', "type": "post", data: function (data) {
                    data.productCode = $('#productCodeOnOrder').val();
                    data.customerCode = $('#custCodeOnOrder').val();
                }
            },
            "columns": [
                {"data": "OrderId", "class": "small", "bSortable": true},
                {"data": "OrderDate", "class": "small"},
                {"data": "DeliveryDate", "class": "small"},
                {"data": "CustomerPastelCode", "class": "small"},
                {"data": "StoreName", "class": "small"},
                {"data": "Qty", "class": "small",
                    render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    } ,"bSortable": true },
                {"data": "PastelCode", "class": "small"},
                {"data": "PastelDescription", "class": "small"},
                {"data": "Comment", "class": "small"},
                {"data": "NettPrice", "class": "small",
                    render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    } ,"bSortable": true },
                {"data": "Backorder", "class": "small"}

            ],
            "deferRender": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            searching: true,
            bPaginate: false,
            bFilter: false,
            "LengthChange": false,
            "info": false,
            "destroy": true
        });
    }
    function show_hide_row(row)
    {
        $("."+row).toggle();
    }

    function callList()
    {
        $.ajax({
            url: '{!!url("/getCallList")!!}',
            type: "POST",
            data:{userId:$('#callListUser').val(),routeId:$('#routeToFilterWith').val(),OrderDate:$('#callListOrderDate').val(),deliveryDate:$('#callListDeliveryDate').val()},
            success: function(data){
                var trHTML = '';
                $('.fast_removeCallList').empty();
                $.each(data, function (key,value) {
                    trHTML +='<tr role="row" class="fast_removeCallList"  style="font-size: 9px;color:black"><td>'+
                        value.CustomerPastelCode +'</td><td>'+
                        $.trim(value.StoreName) +'</td><td>'+
                        '<input type="checkbox"  name="called" style="width:18px;height:11px !important" value="'+value.CustomerId+'" onclick="javascript: SelectallColorsForStyle(this, value);" ></td><td>'+
                        value.ContactPerson +'</td><td>' +
                        value.BuyerTelephone +'</td><td>' +
                        value.CellPhone +'</td><td>' +
                        value.Routeid +'</td><td>'+
                        value.BuyerContact +'</td><td>' +
                        value.LocationID +'</td><td>' +
                        '</tr>';

                });
                $('#callListTable').append(trHTML);
                $('#callListTable tbody').on('dblclick', 'tr', function () {
                    // var productCode = $(this).find(".foo").val();
                    var $this = $(this);
                    var row = $this.closest("tr");
                    var custDescr = row.find('td:eq(1)').text();
                    var custCode = row.find('td:eq(0)').text();
                    if($('#orderId').val().length > 0){
                        alert('There is Currently an order Opened Please Close it !');
                    }
                    else {
                        $('<div></div>').appendTo('body')
                            .html('<div><h6>Yes or No?</h6></div>')
                            .dialog({
                                modal: true,
                                title: 'Creating Order',
                                zIndex: 10000,
                                autoOpen: true,
                                width: '40%',
                                resizable: false,
                                buttons: {
                                    Yes: function () {
                                        $('#inputCustAcc').val(custCode);
                                        $('#inputCustName').val(custDescr);
                                        $('#inputDeliveryDate').val($('#callListDeliveryDate').val());
                                        $('#inputOrderDate').val($('#callListOrderDate').val());
                                        $("#submitFilters").click();
                                        $(this).dialog("close");
                                        called('{!!url("/isCalled")!!}',$('#callListDeliveryDate').val(),custCode,'0');
                                        row.hide();
                                        //console.debug("check if it hits here");

                                        // console.debug("check if it hits here");
                                    },
                                    No: function () {
                                        $(this).dialog("close");
                                    }
                                },
                                close: function (event, ui) {
                                    $(this).remove();
                                }
                            });

                    }

                });
            }
        });
    }


    function reprintList()
    {
        $('#tabletLoading').pleaseWait();
        $.ajax({
            url: '{!!url("/getRouteData")!!}',
            type: "POST",
            data:{routeId:$('#rouTabletLoadingtes').val(),deliveryDate:$('#deliveryDates').val(),OrderType:$('#orderTypesTabletLoading').val()},
            success: function(data) {
                var trHTML = '';
                $('.invoiceslistedHeader').empty();
                $.each(data, function (key, value) {
                    trHTML +='<tr role="row" class="invoiceslistedHeader"  style="font-size: 9px;color:black"><td>'+
                        value.DeliveryDate +'</td><td>'+
                        value.OrderType +'</td><td>' +
                        value.Route +'</td><td>' +
                        value.StoreName +'</td><td>' +
                        value.InvoiceNo +'</td><td>' +
                        value.OrderId +'</td><td>' +
                        value.CustomerPastelCode +'<input type="hidden"  name="orderId" style="width:18px;height:18px" value="'+value.OrderId+'" class="orderID" ><input type="hidden"  name="invoiceNo" style="width:18px;height:18px" value="'+value.InvoiceNo+'" class="invoiceNo" ></td><td>'+
                        '</tr>';
                });
                $('#tabletLoadingAppTable').append(trHTML);
                $('#tabletLoading').pleaseWait('stop');
                $('#tabletLoadingAppTable tbody').on('dblclick', 'tr', function () {
                    $("#orderinfo" ).empty();
                    $("#orderinfoAddress" ).empty();
                    $(".invoiceslisted" ).remove();
                    var $this = $(this);
                    var row = $this.closest("tr");
                    var orderID = row.find('.orderID').val();
                    var invoiceNo = row.find('.invoiceNo').val();
                    var orderType = row.find('td:eq(1)').text();
                    var route = row.find('td:eq(2)').text();
                    var Customer = row.find('td:eq(3)').text();
                    var code = row.find('td:eq(4)').text();
                    var right = Customer+' <br> '+orderID+'<br>'+invoiceNo+' <br> '+orderType+'<br>'+route;
                    $('#tabletLoadingDocDetails').pleaseWait();
                    $('#reprintOrderIdFromTablet').val(orderID);
                    $('#reprintInvoiceFromTablet').val(invoiceNo);
                    orderDetailsWithDeliveryAddress('{!!url("/orderDetailsWithDeliveryAddress")!!}',orderID,'#orderinfoAddress');
                    orderDetailsWithDeliveryAddressOnOrder('{!!url("/orderDetailsWithDeliveryAddressOnOrder")!!}',orderID,'#tabletLoadingAppTableDocDetails');
                    $('#tabletLoadingDocDetails').pleaseWait('stop');
                    $('#reprintInvoice').click(function(){
                        printDoc('{!!url("/intoTblPrintedDoc")!!}',4,orderID,0,$('#invoiceNo').val());
                        consoleManagement('{!!url("/logMessageAjax")!!}',300,2,'Tablet loading web button clicked',0,0,0,0,0,0,0,0,invoiceNo,0,computerName,orderID,0);
                    });

                    $( "#orderinfo" ).append( right);
                    $('#tabletLoadingDocDetails').show();
                    $( "#tabletLoadingDocDetails" ).dialog({height: 600,
                        width: 900,containment: false}).dialogExtend({
                        "closable" : true, // enable/disable close button
                        "maximizable" : false, // enable/disable maximize button
                        "minimizable" : true, // enable/disable minimize button
                        "collapsable" : true, // enable/disable collapse button
                        "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                        "titlebar" : false, // false, 'none', 'transparent'
                        "minimizeLocation" : "right", // sets alignment of minimized dialogues
                        "icons" : { // jQuery UI icon class
                            "close" : "ui-icon-circle-close",
                            "maximize" : "ui-icon-circle-plus",
                            "minimize" : "ui-icon-circle-minus",
                            "collapse" : "ui-icon-triangle-1-s",
                            "restore" : "ui-icon-bullet"
                        },
                        "load" : function(evt, dlg){ }, // event
                        "beforeCollapse" : function(evt, dlg){ }, // event
                        "beforeMaximize" : function(evt, dlg){ }, // event
                        "beforeMinimize" : function(evt, dlg){ }, // event
                        "beforeRestore" : function(evt, dlg){ }, // event
                        "collapse" : function(evt, dlg){  }, // event
                        "maximize" : function(evt, dlg){ }, // event
                        "minimize" : function(evt, dlg){  }, // event
                        "restore" : function(evt, dlg){  } // event
                    });
                    console.debug(orderID);
                });
            }
        });
    }
    function getTheCustomerId()
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{!!url("/custID")!!}',
            type: "POST",
            data:{customerCode:$('#inputCustAcc').val()},
            success: function(data){
                GlobalcustomerId =data[0].CustomerId;
                console.debug("GlobalcustomerId"+GlobalcustomerId);
            }
        });

        return GlobalcustomerId;
    }
    function cancelAdd() {
        //$("#add-more").show();
        //Find ID
        $("#new_row_ajax").remove();
    }
    function deleteOrderLine(url,orderDetailLineId,orderId)
    {
        $.ajax({
            url:url,
            type: "POST",
            data: {
                OrderId: orderId,
                OrderDetailId: orderDetailLineId},
            success: function(data){
                console.debug('deleted msg'+data.deletedId);

            }});
    }

    function SelectallColorsForStyle(e, val) {
        console.debug("e.value//////"+e.value);
        console.debug("val***+-//////"+val);
        $.ajax({
            url: '{!!url("/isCalled")!!}',
            type: "POST",
            data: {
                CustomerId: e.value,
                DeivDate: $('#callListDeliveryDate').val(),
                Show:"0",
                DeliveryAddressId: "0"
            },
            success: function (data) {
                console.debug("data saved");
            }
        });
    }
    function isFloatNumber(item,evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode==46)
        {
            var regex = new RegExp(/\./g)
            var count = $(item).val().match(regex).length;
            if (count > 1)
            {
                return false;
            }
        }
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    function getCustomerRoutesPriority(tag,url,param)
    {
        $.ajax({
            url: url ,
            type: "POST",
            data:{customerCode:param},
            success: function(data){
                var toAppend = '';
                $.each(data,function(i,o){
                    toAppend += '<option value="'+o.Routeid+'">'+o.Route+'</option>';
                });

                $(tag).append(toAppend);

            }
        });
        //
    }
    function filter(element) {
        var value = $(element).val().toLowerCase();
        $("#listaddresses li").each(function () {
            if ($(this).text().toLowerCase().search(value) > -1) {
                $(this).show();
                $(this).prevAll('.header').first().show();
            } else {
                $(this).hide();
            }
        });
    }

    function generateALine2()
    {
        $("#toAutoScroll").animate({ scrollTop: $(this).height() }, "slow");
        var dateFrom = $("#inputOrderDate").val();
        var dateTo = $("#inputDeliveryDate").val();
        calculator();
        var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));
        var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
            '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_'+tokenId+'" class="theProductCode_ set_autocomplete inputs"></td>' +
            '<td contenteditable="false" class="col-md-4"><input name="prodDescription_" id ="prodDescription_'+tokenId+'" class="prodDescription_ set_autocomplete inputs" tabindex="-1"></td>' +
            '<td  contenteditable="false" class="col-md-1"><input type="text" name="prodQty_" id ="prodQty_'+tokenId+'"   onkeypress="return isFloatNumber(this,event)" title="in stock" class="prodQty_ resize-input-inside inputs"></td>' +
            '<td style="display: none;"  contenteditable="false" class="col-md-1"><input type="text" name="prodBulk_"  id ="prodBulk_'+tokenId+'" class="prodBulk_ resize-input-inside"></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="margin_" id ="margin_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="margin_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" >' +

            '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" >' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodOPrice_" id ="prodOPrice_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodOPrice_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" >' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodCost_" id ="prodCost_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodCost_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" >' +
            '<div style="display: initial;" data-value="'+tokenId+'"><i class="fa fa-suitcase"  style="display:none" id="pricelistLookUpOnForm" aria-hidden="true" data-value="'+tokenId+'"></i></div></td>' +
            '<td style="display: none;" contenteditable="false"  class="col-md-1"><input type="text" name="prodDisc_" id ="prodDisc_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside "></td>' +
            '<td  contenteditable="false"  class="col-md-1"><input  type="text" name="prodUnitSize_" id ="prodUnitSize_'+tokenId+'" class="prodUnitSize_ resize-input-inside inputs" ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="instockReadOnly" id ="instockReadOnly_' + tokenId + '" class="instockReadOnly_ resize-input-inside inputs" style="color:white;"></td>' +
            '<td contenteditable="false"  class="col-md-3"><input type="text" name="dateFrom" id ="dateFrom_' + tokenId + '" class="dateFrom_ resize-input-inside inputs" value ="' + dateFrom + '" style="font-size:9px;" ></td>' +
            '<td contenteditable="false"  class="col-md-3"><input type="text" name="dateTo" id ="dateTo_' + tokenId + '" class="dateTo_ resize-input-inside inputs"  value ="' + dateTo + '" style="font-size:9px;"></td>' +
            '<td  contenteditable="false" class="col-md-3"><input type="text" name="prodComment_" id ="prodComment_'+tokenId+'" class="prodComment_ resize-input-inside lst inputs"></td>' +
            '<td><input type="hidden" id="title_'+tokenId+'" class="title" value="authorised" /><input type="hidden" id="theOrdersDetailsId" value="" /><input type="hidden" id ="taxCode'+tokenId+'" value="" class="taxCodes" />' +
            '<input type="hidden" id ="cost_'+tokenId+'" value="" class="costs" /><input type="hidden" id ="inStock_'+tokenId+'" value="" class="inStock" /><input type="hidden" value ="'+tokenId+'" class="hiddenToken" />' +
            '<input type="hidden" id ="priceholder_'+tokenId+'" value="" class="priceholder" />' +
            '<input type="hidden" id ="alcohol_'+tokenId+'" value="" class="alcohol" /><input type="hidden" id ="margin_'+tokenId+'" value="" class="margin" />' +
            '<input type="hidden" id ="prohibited_' + tokenId + '" value="" class="prohibited" />' +
            '<button type="button" id="cancelThis" class="btn-danger btn-xs cancel" style="height: 16px;padding: 0px 5px;font-size: 9px;">Cancel</button></td></tr>');
        $('#table tbody')
            .append( $row )
            .trigger('addRows', [ $row, false ]);
        if(!$('.lst').is(":focus"))
        {
            $('#prodCode_' + tokenId).focus();

            if ($('#checkboxDescription').is(':checked')) {
                $('#prodDescription_' + tokenId).focus();
            }
        }

        $('input').on('click keyup' ,function(){
            // $('input').click(function(){
            var ID = $(this).attr('id');
            var jID = '#'+ID;
            var x = ID.indexOf("_");
            var get_token_number = ID.substring(x+1,ID.length);
            GLOBALQUANTITY = $('#prodQty_'+get_token_number).val();
            GLOBALPRICE = $('#prodPrice_'+get_token_number).val();
            GLOBALPRODCODE = $('#prodCode_'+get_token_number).val();
            GLOBALDISC = $('#prodDisc_'+get_token_number).val();
            GLOBALPRODUCTDESCRIPTION = $('#prodDescription_'+get_token_number).val();
            GLOBALUNITSIZE = $('#prodUnitSize_'+get_token_number).val();
            GLOBALCOMMENT = $('#prodComment_'+get_token_number).val();

            if ($(this).hasClass("prodDescription_") && $(this).hasClass("set_autocomplete")) {
                var columnsD = [{name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                    {name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'}
                    ,{name: 'Available', minWidth:'20px',valueField: 'Available'}];
                $(""+jID+"").mcautocomplete({
                    source: finalDataProductTest,
                    columns:columnsD,
                    autoFocus: true,
                    minlength: 2,
                    delay: 0,
                    multiple: true,
                    multipleSeparator: ",",
                    select:function (e, ui) {
                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);

                        if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                        {
                            $('#prodQty_'+token_number).val('0');
                            $('#prodPrice_'+token_number).val('0');
                        }
                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                        //checkIfOrderHasMultipleProducts(ui.item.extra,token_number);
                        $('#prodQty_' + token_number).val('');

                        $('#table').find('#prodQty_' + token_number).focus();
                        $('#prodUnitSize_' + token_number).val(ui.item.UnitSize);
                        $('#instockReadOnly_' + token_number).val(ui.item.QtyInStock);
                        $('#taxCode' + token_number).val(ui.item.Tax);
                        $('#cost_' + token_number).val(ui.item.Cost);
                        $('#prodCost_' + token_number).val( parseFloat(ui.item.Cost).toFixed(2));
                        GLOBALPRODCODE = ui.item.extra;
                        GLOBALPRODUCTDESCRIPTION = ui.item.value;
                        GLOBALQUANTITY = $('#prodQty_' + token_number).val();
                        GLOBALDISC = $('#prodDisc_' + token_number).val();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        productPrice(token_number);
                        switch(accounting)
                        {
                            case 'Pastel':
                                qtyInStock(token_number);
                                break;
                            // $('#prodQty_' + token_number).attr('title', 'In Stock ' + parseFloat(ui.item.QtyInStock).toFixed(3));

                            case 'Other':
                                $('#instockReadOnly_' + token_number).val(ui.item.QtyInStock);
                                break;

                        }

                    }
                });

            }

            if ($(this).hasClass("theProductCode_") && $(this).hasClass("set_autocomplete")) {
                var columnsC = [{name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'},
                    {name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                    {name: 'Available', minWidth:'20px',valueField: 'Available'}];
                $("" + jID + "").mcautocomplete({
                    source: finalDataProduct,
                    columns:columnsC,
                    minlength: 1,
                    autoFocus: true,
                    delay: 0,
                    select:function (e, ui) {

                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                        {
                            $('#prodQty_'+token_number).val('0');
                            $('#prodPrice_'+token_number).val('0');
                        }
                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                        //checkIfOrderHasMultipleProducts(ui.item.extra,token_number);
                        $('#prodQty_' + token_number).val('');
                        $('#prodQty_' + token_number).focus();
                        //$('#inStock_' + token_number).val(ui.item.QtyInStock);
                        $('#table').find('#prodQty_' + token_number).focus();
                        $('#prodUnitSize_' + token_number).val(ui.item.UnitSize);
                        $('#instockReadOnly_' + token_number).val(ui.item.QtyInStock);
                        $('#taxCode' + token_number).val(ui.item.Tax);
                        $('#cost_' + token_number).val(ui.item.Cost);
                        $('#prodCost_' + token_number).val( parseFloat(ui.item.Cost).toFixed(2));
                        // $('#prodQty_' + token_number).attr('title', 'In Stock ' + parseFloat(ui.item.QtyInStock).toFixed(3));

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        productPrice(token_number);
                        switch(accounting)
                        {
                            case 'Pastel':
                                qtyInStock(token_number);
                                break;
                            case 'Other':
                                $('#instockReadOnly_' + token_number).val(ui.item.QtyInStock);
                                break;

                        }
                    }



                });
            }
            calculator();
        });
        $(".dateFrom_,.dateTo_").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
    }
    function calculator()
    {
        var arrayPrice = [];
        var arrayPrice = [];
        var arrayQty = [];
        var arrayPriceInc = [];
        var cost = [];

        $('#table tr').each(function() {

            var valuesPrice = [];
            var valuesQty = [];
            var valuesPriceInc = [];
            var valuesCost = [];

            $(this).find(".prodPrice_").each(function(){
                valuesPrice.push($(this).val());
            });
            $(this).find(".prodQty_").each(function(){
                valuesQty.push($(this).val());
            });
            $(this).find(".taxCodes").each(function(){
                valuesPriceInc.push($(this).val());
            });
            $(this).find(".costs").each(function(){
                valuesCost.push($(this).val());
            });

            arrayPrice.push(valuesPrice);
            arrayQty.push(valuesQty);
            arrayPriceInc.push(valuesPriceInc);
            cost.push(valuesCost);

        });
        var ar3 = [];
        for(var i = 0; i < arrayPrice.length; i++){
            var valu = arrayPrice[i] * arrayQty[i];
            ar3[i] = valu;
        }

        var arPriceInclusive=[];
        for(var i = 0; i < arrayPrice.length; i++){
            var valu = (arrayPrice[i] * arrayQty[i])*(arrayPriceInc[i]/100) + (arrayPrice[i] * arrayQty[i]);
            console.debug(valu);
            arPriceInclusive[i] = valu;
        }
        var totalCost = eval((cost).join("+"));
        var totalPrice = eval((arrayPrice).join("+"));
        var totalMargin = marginCalculator(totalCost,totalPrice)
        var sumarray = eval((ar3).join("+"));
        var sumPriceInc = eval((arPriceInclusive).join("+"));
        if( ($('#dicPercHeader').val()).length < 1 )
        {
            $('#dicPercHeader').val('0');
        }

        var sumarrayOnInclusiveForDiscount = (sumPriceInc - parseFloat((parseFloat($('#dicPercHeader').val())/100) * sumPriceInc) ).toFixed(2);
        var sumarrayOnExclusiveForDiscount = (sumarray - parseFloat((parseFloat($('#dicPercHeader').val())/100) * sumarray) ).toFixed(2);
        console.debug("sumarrayOnExclusiveForDiscount***"+sumarrayOnExclusiveForDiscount);
        $('#totalEx').val(sumarrayOnExclusiveForDiscount.toFixed(2));
        $('#totalInc').val(sumarrayOnInclusiveForDiscount.toFixed(2));
        $('#totalmargin').val(totalMargin.toFixed(2));

        var crLimit = parseFloat($('#totalInc').val()) + parseFloat($('#balDue').val());

        if (crLimit > $('#creditLimit').val()) {
            var difference  = crLimit - $('#creditLimit').val();
            $('#creditLimitWarningMessage').append('CREDIT LIMIT REACHED : '+difference.toFixed(2));
        }

    }
    function printDoc(url,docType,docID,isDeliveryNote,invoiceNumber)
    {
        $.ajax({
            url: url ,
            type: "POST",
            data:{DocType:docType,DocId:docID,PrintDeliveryNote:isDeliveryNote,invoiceNumber:invoiceNumber},
            success: function(data){
                if (data =='Process failed')
                {
                    alert('Process failed');
                }
            }
        });
    }
    function orderPattern(addressId)
    {
        //
        datatableOrderPattern = $('#orderPatternIdTable').DataTable( {
            "ajax": {url:'{!!url("/getOrderPattern")!!}',"type": "POST",
                data:function(data) {
                    data.CustomerCode = $('#inputCustAcc').val();
                    data.orderID = $('#orderId').val();
                    data.DeliveryAddressIId = addressId;
                }
            },
            "columns": [
                { "data": "PastelDescription","class":"small" },
                { "data": "twoWeeks","class":"small",
                    render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    }},
                { "data": "Avg","class":"small",
                    render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    }  },
                { "data": "Remaining","class":"small" ,
                    render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        // console.debug("product code on the order pattern**********",row['PastelCode']);
                        try {
                            var jsn = JSON.parse(data);
                            if (jsn === "undefined")
                            {
                                jsn = 0;
                            }
                            if (jsn === ".000")
                            {
                                jsn = 0;
                            }
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);
                    }
                },
                { "data": "Cost","class":"small",
                    render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            if (jsn === "undefined")
                            {
                                jsn = 0;
                            }
                            if (jsn === ".000")
                            {
                                jsn = 0;
                            }
                            //console.log(" parsing json" + jsn);
                        } catch (e) {
                            jsn = 0;

                            return jsn;
                        }
                        return parseFloat(jsn).toFixed(2);

                    }

                },
                { "data": "TrendingId","class":"small",
                    render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {
                            //console.log("error parsing json - " + e.toString());
                            return jsn.data;
                        }
                        var icon = '<i class="fa fa-circle" ></i>';

                        switch (jsn)
                        {
                            case 1:
                                icon =  '<i class="fa fa-arrow-up" ></i>';
                                break;
                            case 2:
                                icon = '<i class="fa fa-arrow-down" ></i>';
                                break;
                            case 3:
                                icon = '<i class="fa fa-circle" ></i>';
                                break;
                            case 4:
                                icon = '<i class="fa fa-stop" ></i>';
                                break;
                            default:
                                icon = '<i class="fa fa-circle" ></i>';
                                break;
                        }
                        return icon;

                    }

                },
                { "data": "authorised","class":"small"  },
                { "data": "PastelCode","class":"small"  },
                { "data": "PushProduct","class":"small" },
                { "data": "Tax","class":"small"  },
                { "data": "UnitSize","class":"small"  }

            ],
            "createdRow": function( row, data, dataIndex ) {

                if(data.PushProduct == "1")
                {
                    $(row).addClass('green');
                }
                if(data.TrendingId == "1")
                {
                    $(row).addClass('up');
                }
                if(data.TrendingId == "2")
                {
                    $(row).addClass('down');
                }
                if(data.TrendingId == "3")
                {
                    $(row).addClass('circle');
                }
                if(data.TrendingId == "4")
                {
                    $(row).addClass('stopped');
                }
            },
            "columnDefs": [
                {
                    "width": "44%",
                    "targets": 0
                },{
                    "width": "0%",
                    "targets": 7
                }
                ,{
                    "width": "0%",
                    "targets": 8
                }
            ],
            "deferRender": true,
            "scrollY": "365px",
            "scrollCollapse": true,
            searching: true,
            bPaginate: false,
            bFilter: false,
            "LengthChange": false,
            "info":     false,
            "ordering": false,
            "bDestroy": true,

        } );
        datatableOrderPattern.columns([6]).visible(false);

    }


    function getDataFromTblManagement()
    {
        datatableUserActions = $('#tableUserActions').DataTable( {
            "ajax": {url:'{!!url("/getDataFromManagementConsole")!!}',"type": "GET",
                data:function(data) {

                    data.orderID = $('#orderId').val();

                }
            },
            "columns": [
                { "data": "Message","class":"small","bSortable": false },
                { "data": "LoggedBy","class":"small","bSortable": false},
                { "data": "Computer","class":"small","bSortable": false},
                { "data": "PastelDescription","class":"small"},
                { "data": "PastelCode","class":"small"},
                { "data": "dtm","class":"small","bSortable": true },
                { "data": "StoreName","class":"small"},
                { "data": "CustomerPastelCode","class":"small"  },
                { "data": "ReferenceNo","class":"small","bSortable": true  },
                { "data": "NewQty","class":"small",
                    render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    } ,"bSortable": true },
                { "data": "OldQty","class":"small",
                    render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    } ,"bSortable": true },
                { "data": "NewPrice","class":"small"
                    ,render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    },"bSortable": true },
                { "data": "OldPrice","class":"small",
                    render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    },"bSortable": true  }

            ],
            "deferRender": true,
            "scrollY": "200px",
            "scrollCollapse": true,
            searching: true,
            bPaginate: false,
            bFilter: false,
            "LengthChange": false,
            "info":     false,
            "bDestroy": true

        } );
        //datatableOrderPattern.columns([6,8,9]).visible(false);
    }
    function fetchDeliveyAddressFronSelect(addressId)
    {
        $.ajax({
            url: '{!!url("/selectAddressFromMultiAddressDeliveruyAddressId")!!}',
            type: "POST",
            data: {CustomerCode: $('#inputCustAcc').val(), DeliveryAddressIId: addressId},
            success: function (data) {
                $('#address1').val(data[0].DAddress1);
                $('#address2').val(data[0].DAddress2);
                $('#address3').val(data[0].DAddress3);
                $('#address4').val(data[0].DAddress4);
                $('#address5').val(data[0].DAddress5);
                //$('#deliveryAddressIdOnPopUp').val(data[0].DeliveryAddressIId);
                $('#generalRouteForNewDeliveryAddress').empty();
                getRoutes('#generalRouteForNewDeliveryAddress','{!!url("/getCommonRoutes")!!}');
                $("#generalRouteForNewDeliveryAddress").prepend('<option value="'+data[0].Routeid+'" selected="selected">'+data[0].Route+'</option>');

            }
        });
    }
    function onClickingDeliveryAddress()
    {
        $('#listOfDelivAdress').show();
        $( "#listOfDelivAdress" ).dialog({height: 600,
            width: 950,containment: false}).dialogExtend({
            "closable" : false, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class
                "close" : "ui-icon-circle-close",
                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });;
        $('#listaddresses li').click(function(){
            var $this = $(this);
            var selKeyVal = $this.attr("value");
            // alert('Text ' + $this.text() + 'value ' + selKeyVal);

            $("#hiddenDeliveryAddressId" ).val(selKeyVal);
            $("#customerSelectedDelDate" ).val($this.text());
            $("#deliveryAddressIdOnPopUp").val(selKeyVal);
            //$('#doneCustomAddress').show();
            //pass this to fetch address
            console.debug(selKeyVal);
            fetchDeliveyAddressFronSelect(selKeyVal);

            // $("#listOfDelivAdress" ).dialog("close");
        });
    }

    function putInArray(productCode)
    {
        var productCodes = [];
        $('#table tr').each(function() {
            $(this).find(".theProductCode_").each(function(){
                productCodes.push($(this).val());
                if($.inArray(productCode,productCodes) == -1){
                    // the element is not in the array
                    productCodes.push(productCode);
                }else
                {
                    alert("it already added");
                }
            });
        });

    }
    function productPrice(token_number)
    {
        $.ajax({
            url: '{!!url("/getCutomerPriceOnOrderForm")!!}',
            type: "POST",
            data: {
                customerID: $('#inputCustAcc').val(),
                deliveryDate: $('#inputDeliveryDate').val(),
                productCode: $('#prodCode_' + token_number).val()
            },
            success: function (data) {
                if($('#prodQty_' + token_number).val() == '0'){
                    $('#prodQty_' + token_number).val('');
                }
                if ($.isEmptyObject(data)) {
                    $('#prodPrice_' + token_number).val('');
                    $('#cost_' + token_number).val('');

                    //GLOBALPRICE = 0;
                } else {

                    $('#prodPrice_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                    $('#prodOPrice_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                    $('#prohibited_' + token_number).val(parseFloat(data[0].Prohibited).toFixed(2));
                    $('#margin_' + token_number).val(parseFloat( marginCalculator($('#prodCost_' + token_number).val(),parseFloat(data[0].Price).toFixed(2))).toFixed(2));

                    if (reportmarginControl === 'marginType5')
                    {
                        $('#priceholder_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                    }


                }

            }
        });
    }
    function qtyInStock(token_number)
    {
        $.ajax({
            url: '{!!url("/stockApi")!!}',
            type: "POST",
            data: {
                ItemCode: $('#prodCode_' + token_number).val()
            },
            success: function (data) {
                $('#availableOnTheFly').empty();
                $('#availableOnTheFly').append('Available : '+data);
                $('#instockReadOnly_' + token_number).val(data);
            }
        });
    }
    function qtyAvailableOnClick(productCode)
    {
        //On click show available
        $.ajax({
            url: '{!!url("/stockApi")!!}',
            type: "POST",
            data: {
                ItemCode: productCode
            },
            success: function (data) {
                $('#availableOnTheFly').empty();
                $('#availableOnTheFly').append('Available : '+data);

            }
        });
    }
    function qtyInStockOnPriceCheck(productCode)
    {
        var instock;
        instock = $.ajax({
            url: '{!!url("/stockApi")!!}',
            type: "POST",
            data: {
                ItemCode:productCode
            },
            success: function (data) {
                console.debug('*********************'+data);
                instock = data;
            }
        });
        return instock;
    }
    function productPriceOnReadyMadeLine(productCode,producutDescr,tax,cost,title,inStock,unitSizes)
    {
        calculator();
        $.ajax({
            url: '{!!url("/getCutomerPriceOnOrderForm")!!}',
            type: "POST",
            data: {
                customerID: $('#inputCustAcc').val(),
                deliveryDate: $('#inputDeliveryDate').val(),
                productCode: productCode
            },
            success: function (data) {
                console.debug(data);
                var price = '';

                if ($.isEmptyObject(data)) {
                    price = '';
                    readyMadeLineOrderLine('#table tbody', producutDescr, productCode, ' ', price, 0, 0, title, tax,unitSizes,0);
                } else {
                    price = parseFloat(data[0].Price).toFixed(2);

                    if (reportmarginControl === 'marginType5')
                    {
                        cost = price;
                    }
                    readyMadeLineOrderLine('#table tbody', producutDescr, productCode, '', price, cost, inStock, title, tax,unitSizes,data[0].Prohibited);
                    // }

                }

            }
        });
    }
    //Plus key is Pressed
    $(function(){
        $('#tblOnsalesOrder').on('keydown', function(ev) {

            if(ev.keyCode === 107 && ($('#orderId').val()).length < 1)
            {
                if ((globalOrderIdToBePushed[0]).length > 1) {
                    $('#orderId').val(globalOrderIdToBePushed[0]);
                    $('#checkOrders').click();
                    $('#prodOnOrder').dialogExtend("minimize");
                }

            }else if(($('#orderId').val()).length > 3)
            {
                alert('You have opened already ,Please finish the current');
            }


        });
        $('#tblOnsalesOrder').focus();
    });
    $(function(){
        $('#tblOnsalesOrder').on('keydown', function(ev) {

            if(ev.keyCode === 109 && ($('#orderIds').val()).length < 1)
            {
                if ((globalOrderIdToBePushed[0]).length > 1) {
                    //dispatchQuantityForm
                    $('#dispatchQuantityForm').show();
                    showDialog('#dispatchQuantityForm','80%',640);
                    console.debug("********"+globalOrderIdToBePushed[0]);
                    makeALineWithOrderID(globalOrderIdToBePushed[0],'#tableDispatch tbody', '{!!url("/onCheckOrderHeaderDetails")!!}','{!!url("/contactDetailsOnOrder")!!}',arrayOfCustomerInfo)
                }

            }else if(($('#orderIds').val()).length > 3)
            {
                alert('You have opened already ,Please finish the current');
            }


        });
        $('#tblOnsalesOrder').focus();
    });
    $(document).ready(function() {
        $('#table,#tableDispatch tbody').on('focusout','tr', function () {
            //+ alert("slut");
            calculator();
            var $cells = $(this).find(".prodPrice_");
            var $cellsId = $(this).find(".prodPrice_").attr("id");
            var $cellProdCode = $(this).find(".theProductCode_");
            var $cellProdCodeID = $(this).find(".theProductCode_").attr("id");
            //productSetting

            if( $.inArray($('#'+$cellProdCodeID).val(), arrayProdCodesCheck) !== -1 ) {

                console.debug("inside array");
                console.debug("inside array ---"+productSetting);

            }
            else
            {
                arrayProdCodesCheck.push($('#'+$cellProdCodeID).val());
                console.debug(arrayProdCodesCheck);
                //alert("new born");
            }
            var $cellProdDescription = $(this).find(".prodDescription_");
            var $cellProdDescriptionID = $(this).find(".prodDescription_").attr("id");
            var $cellProdQuant = $(this).find(".prodQty_").attr("id");
            var $isAuth = $(this).find(".title");
            var $isAuthAtrr = $(this).find(".title").attr("id");
            var $iTHasMargin = $(this).find(".margin").attr("id");
            var $alcohol = $(this).find(".alcohol").attr("id");
            var $cost = $(this).find(".priceholder").val();
            var $hiddenToken = $(this).find(".hiddenToken").val();
            var $inStock = $(this).find(".inStock").val();
            var authString = $(this).find(".title").val();
            var prohited = $(this).find(".prohibited").val();
            var prodCell = $('#' + $cellsId).val();
            var margin = marginCalculator($cost, prodCell);
            var companyMargin = ($('#'+$iTHasMargin).val()/100);//this a field

            if (prodCell != $cost)
                console.debug(margin);
            console.debug('margin' +margin);

            if (($('#' + $cellsId).val()).length < 1 && ($('#' + $cellProdCodeID).val()).length > 0) {
                $('#' + $cellsId).val('');
            }
            console.debug('prohited--'+ parseInt(prohited) );

            if(parseInt(prohited) === 1)
            {
                //alert("good");
                authProhited($hiddenToken);
            }

            console.debug(companyMargin);
            console.debug("*****"+reportmarginControl);
            //Athorise below and above
            // if (reportmarginControl === 'marginType1')
            //{
            switch(reportmarginControl){
                case 'marginType1':
                    if ($inStock.length > 0 && prodCell.length > 0)
                    {
                        if (margin < companyMargin )
                        {
                            if (authString.length > 0 && ($('#' + $cellProdCodeID).val()).length > 0) {
                                authPopup("Price", $('#' + $cellsId).val(), 0, $('#'+$cellProdCodeID).val(), 'Price below margin ' + $cellProdCode.val() + '(' + $cellProdDescription.val() + ')', $isAuthAtrr, $hiddenToken);
                            }
                        }

                        if(booze.length < 1  && $('#'+$alcohol).val() == 1 && $('#boozeChecked').val().length < 1)
                        {
                            // $('#table').on('click', 'button', function (e) {
                            var dialog = $('<p><strong style="color:red">You are aware that this customer does not have liquore license and you cannot sell alcohol to them</strong></p>').dialog({
                                height: 200, width: 700,modal: true,containment: false,
                                buttons: {
                                    "Okay": function () {
                                        $('#boozeChecked').val('true');
                                        $('#'.$cellProdQuant).focus();
                                        dialog.dialog('close');
                                    }
                                }
                            });
                        }

                    }
                    break;
                case 'marginType5':
                    console.debug(prodCell+'*****'+$cost);

                    if (($.trim(prodCell)).length > 0 && prodCell != $cost)
                    {
                        if (authString.length > 0 && ($('#' + $cellProdCodeID).val()).length > 0) {

                            if( margin < CompanyMargin) {
                                authPopup("Price", $('#' + $cellsId).val(), 0, $('#' + $cellProdCodeID).val(), 'Changed Price ' + $cellProdCode.val() + '(' + $cellProdDescription.val() + ')', $isAuthAtrr, $hiddenToken);
                            }
                        }
                    }
                    break;
            }
            if (($('#' + $cellProdQuant).val()).length < 1 && ($('#' + $cellProdCodeID).val()).length > 0) {
                $('#' + $cellProdQuant).val(1);
                $('#' + $cellProdQuant).select();

            }


        });
    });
    $(document).on('keyup', '.lst', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13 || code == 9) {
            console.debug("sales");
            var myRow = $('#table').find("tr").last();
            var prod = myRow.find(".theProductCode_").val();
            var prodDesc = myRow.find(".prodDescription_").val();
            var prodQty_ = myRow.find(".prodQty_").val();
            var prodPrice_ = myRow.find(".prodPrice_").val();
            var myRowId = $('#table').find("tr").last().attr("id");

            if (prod.length < 1 || prodDesc.length < 1 || prodQty_.length < 1 || prodPrice_.length < 1)
            {
                // $("#"+myRowId).remove();
                // generateALine2();
                var index = $('.inputs').index(this);
                myRow.find(".theProductCode_").focus();
            }else
            {
                $('.lst').eq(index).focus();
                generateALine2();


            }


        }
    });
    //
    $(document).on('keydown', '.onPosAmount', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        var testLst = $(this).closest('tr');
        if ((code == 13 || code == 39)) {
            var index = $('.onPosAmount').index(this) + 1;
            $('.onPosAmount').eq(index).focus();
        }
    });

    $(document).on('keydown', '.inputs', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        var testLst = $(this).closest('tr');
        if ((code == 13 || code==39) ) {
            var index = $('.inputs').index(this) + 1;
            $('.inputs').eq(index).focus();
        }
        if(code==37)
        {
            var index = $('.inputs').index(this) - 1;
            $('.inputs').eq(index).focus();
        }
        var closesttr =  $(this).closest('tr');
        var prodClosest = closesttr.find(".theProductCode_").val();
        var prodDescClosest = closesttr.find(".prodDescription_").val();
        var prodQtyClosest = closesttr.find(".prodQty_").val();
        var prodPriceClosest = closesttr.find(".prodPrice_").val();
        if ( code == 34 && $.trim(prodClosest.length) > 0 && prodDescClosest.length > 0 && prodQtyClosest.length > 0 && prodPriceClosest.length > 0) {
            console.debug("sales");
            var myRow = $('#table').find("tr").last();
            var prod = myRow.find(".theProductCode_").val();
            var prodDesc = myRow.find(".prodDescription_").val();
            var prodQty_ = myRow.find(".prodQty_").val();
            var prodPrice_ = myRow.find(".prodPrice_").val();
            var myRowId = $('#table').find("tr").last().attr("id");

            if (prod.length < 1 && prodDesc.length < 1 && prodQty_.length < 1 && prodPrice_.length < 1)
            {
                // $("#"+myRowId).remove();
                // generateALine2();
                var index = $('.inputs').index(this);
                myRow.find(".theProductCode_").focus();
            }else
            {
                generateALine2();
                var myRow2 = $('#table').find("tr").last();
                var prod2 = myRow.find(".theProductCode_").val();
                var myRowId2= $('#table').find("tr").last().attr("id");
                myRow2.find(".theProductCode_").focus();
                // $('.lst').eq(index).focus();
            }


        }
        if (code== 40 && $(this).closest("tr").is(":last-child") && prodClosest.length > 0 && prodDescClosest.length > 0 && prodQtyClosest.length > 0 && prodPriceClosest.length > 0) {

            generateALine2();
        }



    });

    $(document).on('keydown', '.theProductCode_', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            var index = $('.inputs').index(this) + 1;
            $('.inputs').eq(index).focus();
        }
    });
    $(document).on('keyup', '.prodPrice_', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        var $isAuth = $(this).closest("tr").find(".title").attr("id");
        var $priceToken = $(this).closest("tr").find(".prodPrice_").attr("id");
        var productCode = $(this).closest("tr").find(".theProductCode_").val();
        var prodCost_ = $(this).closest("tr").find(".prodCost_").val();
        var prodPrice_ = $(this).closest("tr").find(".prodPrice_").val();
        $(this).closest("tr").find(".margin_").val(marginCalculator(prodCost_,prodPrice_));

        if ((key > 45 && key < 57) || (key > 95 && key < 106) ||  key == 8) {
            $('#'+$isAuth).val('authorised');
            calculator();
        }
        if ( key == 107)
        {
            console.debug('productCode'+productCode);
            $('#custLookUp').show();
            $( "#custLookUp" ).dialog({height: 450,
                width: 400,containment: false}).dialogExtend({
                "closable" : true, // enable/disable close button
                "maximizable" : false, // enable/disable maximize button
                "minimizable" : true, // enable/disable minimize button
                "collapsable" : true, // enable/disable collapse button
                "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                "titlebar" : false, // false, 'none', 'transparent'
                "minimizeLocation" : "right", // sets alignment of minimized dialogues
                "icons" : { // jQuery UI icon class
                    "close" : "ui-icon-circle-close",
                    "maximize" : "ui-icon-circle-plus",
                    "minimize" : "ui-icon-circle-minus",
                    "collapse" : "ui-icon-triangle-1-s",
                    "restore" : "ui-icon-bullet"
                },
                "load" : function(evt, dlg){ }, // event
                "beforeCollapse" : function(evt, dlg){ }, // event
                "beforeMaximize" : function(evt, dlg){ }, // event
                "beforeMinimize" : function(evt, dlg){ }, // event
                "beforeRestore" : function(evt, dlg){ }, // event
                "collapse" : function(evt, dlg){  }, // event
                "maximize" : function(evt, dlg){ }, // event
                "minimize" : function(evt, dlg){  }, // event
                "restore" : function(evt, dlg){  } // event
            });

            $.ajax({
                url: '{!!url("/generalPriceCheckAndLastCost")!!}',
                type: "POST",
                data:{
                    productCode:productCode,custCode : $('#inputCustAcc').val()
                },
                success: function(data) {

                    var trHTML = '';

                    $('#lastprice').val('');
                    if((data.sellingPrice).length > 0){
                        $('#lastprice').val(parseFloat(data.sellingPrice[0].Price,2));
                    }
                    $('#productSelectedForPriceListOrderForm').empty();
                    $('#customerDetailLookUp').empty();
                    $('#productSelectedForPriceListOrderForm').append(productCode);
                    $.each(data.pricelists, function (key, value) {
                        trHTML += '<tr style="font-size: 10px;color:black"><td>' +
                            value.PriceList + '</td><td><strong>' +
                            value.Price + '</strong></td><td>' +
                            '</tr>';
                    });
                    $('#customerDetailLookUp').append(trHTML);
                }
            });
            /* $('#customerDetailLookUp tbody').on('dblclick', 'tr', function (){
             alert("over here");
             });*/
        }
        $('#lastprice').on('click',function(){
            $('#'+$priceToken).val($('#lastprice').val());
            $( "#custLookUp" ).dialog('close');
        });
    });
    $(document).on('keydown', '.prodQty_', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);

        if ((key > 45 && key < 57) || (key > 95 && key < 106) ||  key == 8) {
            calculator();
        }
    });
    $(document).on('keyup', '#posPayMentTypeCash', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        if ((key > 45 && key < 57) || (key > 95 && key < 106) ||  key == 8) {
            posCalculator();
        }
    });
    $(document).on('click', '#posPayMentTypeCash', function(e) {
        $('#posPayMentTypeCash').select();
    });
    $(document).on('click', '#posPayMentTypeAccount', function(e) {
        $('#posPayMentTypeAccount').select();
    });
    $(document).on('click', '#posPayMentTypeCreditCard', function(e) {
        $('#posPayMentTypeCreditCard').select();
    });
    $(document).on('click', '#posPayMentTypeCheque', function(e) {
        $('#posPayMentTypeCheque').select();
    });

    $(document).on('keyup', '#posPayMentTypeAccount', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        if ((key > 45 && key < 57) || (key > 95 && key < 106) ||  key == 8) {
            posCalculator();
        }
    });
    $(document).on('keyup', '#posPayMentTypeCreditCard', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        if ((key > 45 && key < 57) || (key > 95 && key < 106) ||  key == 8) {
            posCalculator();
        }
    });
    $(document).on('keyup', '#posPayMentTypeCheque', function(e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        if ((key > 45 && key < 57) || (key > 95 && key < 106) ||  key == 8) {
            posCalculator();
        }
    });
    //
    $(document).on('keydown', '#inputDeliveryDate', function(e) {

        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            //alert("alert ....");
            if($('#submitFilters').is(':visible')) {
                $('#submitFilters').focus();
            }

        }

    });
    $(document).on('click', '.prodQty_', function(e) {
        $(this).select();
    });
    /* $(document).on('keydown', '.calculator', function(e){
     var code = (e.keyCode ? e.keyCode : e.which);
     if (code == 13) {

     }
     return false;
     });*/
    $('#display').on('keyup keypress', function(e) {

    });

    $(document).on('keydown', '.prodQty_', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            var index = $('.inputs').index(this) + 1;
            $('.inputs').eq(index).focus();
        }
    });
    $(document).on('keyup keypress', '#display', function(e) {

        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            $('#equalOnCalculator').click();
            return false;
        }
    });

    $(document).on('click','#pricelistLookUpOnForm',function(){
        var dataValue = $(this).data('value');
        var productCode = $('#prodCode_'+dataValue).val();
        console.debug('dataValue'+dataValue);
        console.debug('productCode'+productCode);
        $('#custLookUp').show();
        $( "#custLookUp" ).dialog({height: 300,
            width: 400,containment: false}).dialogExtend({
            "closable" : true, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class
                "close" : "ui-icon-circle-close",
                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });

        $.ajax({
            url: '{!!url("/generalPriceChecking")!!}',
            type: "POST",
            data:{productCode:productCode},
            success: function(data) {

                var trHTML = '';
                $('#productSelectedForPriceListOrderForm').empty();
                $('#customerDetailLookUp').empty();
                $('#productSelectedForPriceListOrderForm').append(productCode);
                $.each(data, function (key, value) {
                    trHTML += '<tr style="font-size: 10px;color:black"><td>' +
                        value.PriceList + '</td><td><strong>' +
                        value.Price + '</strong></td><td>' +
                        '</tr>';
                });
                $('#customerDetailLookUp').append(trHTML);
            }
        });
        $('#customerDetailLookUp tbody').on('dblclick', 'tr', function (){
            alert("over here");
        });

    });



    /**
     * Log data into tblManagementConsole
     * @param url
     * @param ConsoleTypeId
     * @param Importance
     * @param Message
     * @param Reviewed
     * @param OrderId
     * @param productid
     * @param CustomerId
     * @param OldQty
     * @param NewQty
     * @param OldPrice
     * @param NewPrice
     * @param ReferenceNo
     * @param DocType
     *  @param machine
     * @param DocNumber
     * @param ReturnId
     */
    function consoleManagement(url,ConsoleTypeId,Importance,Message,Reviewed,OrderId,productid,
                               CustomerId,OldQty,NewQty,OldPrice,NewPrice,ReferenceNo,DocType,machine,DocNumber,ReturnId)
    {
        $.ajax({
            url:url,
            type: "POST",
            data:{ConsoleTypeId:ConsoleTypeId,
                Importance:Importance,
                Message:Message,
                Reviewed:Reviewed,
                OrderId:OrderId,
                productid:productid,
                CustomerId:CustomerId,
                OldQty:OldQty,
                NewQty:NewQty,
                ReviewedUserId:0,
                OldPrice:OldPrice,
                NewPrice:NewPrice,
                ReferenceNo:ReferenceNo,
                DocType:DocType,
                DocNumber:DocNumber,
                machine:machine,
                ReturnId:ReturnId,

            },
            success: function(data){
                //dd(data);
                //Try to use web sql
            }});

    }
    function consoleManagementAuths(url,ConsoleTypeId,Importance,Message,Reviewed,OrderId,productid,
                                    CustomerId,OldQty,NewQty,OldPrice,NewPrice,ReferenceNo,DocType,machine,DocNumber,ReturnId,userId,userName)
    {
        $.ajax({
            url:url,
            type: "POST",
            data:{ConsoleTypeId:ConsoleTypeId,
                Importance:Importance,
                Message:Message,
                Reviewed:Reviewed,
                OrderId:OrderId,
                productid:productid,
                CustomerId:CustomerId,
                OldQty:OldQty,
                NewQty:NewQty,
                ReviewedUserId:0,
                OldPrice:OldPrice,
                NewPrice:NewPrice,
                ReferenceNo:ReferenceNo,
                DocType:DocType,
                DocNumber:DocNumber,
                machine:machine,
                ReturnId:ReturnId,
                userId:userId,
                userName:userName,

            },
            success: function(data){
                // dd(data);
                //Try to use web sql
            }});

    }
    function creditLimitAuth(mess)
    {
        $('#appendErrormsgCreditLimit').empty();
        $('#appendErrormsgCreditLimit').append(mess);

        $('#creditLimitAuth').show();
        $("#creditLimitAuth").dialog({
            height: 250, modal: true,
            width: 500, containment: false
        }).dialogExtend({
            "closable": true, // enable/disable close button
            "maximizable": false, // enable/disable maximize button
            "minimizable": true, // enable/disable minimize button
            "collapsable": true, // enable/disable collapse button
            "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar": false, // false, 'none', 'transparent'
            "minimizeLocation": "right", // sets alignment of minimized dialogues
            "icons": { // jQuery UI icon class
                "close": "ui-icon-circle-close",
                "maximize": "ui-icon-circle-plus",
                "minimize": "ui-icon-circle-minus",
                "collapse": "ui-icon-triangle-1-s",
                "restore": "ui-icon-bullet"
            },
            "load": function (evt, dlg) {
            }, // event
            "beforeCollapse": function (evt, dlg) {
            }, // event
            "beforeMaximize": function (evt, dlg) {
            }, // event
            "beforeMinimize": function (evt, dlg) {
            }, // event
            "beforeRestore": function (evt, dlg) {
            }, // event
            "collapse": function (evt, dlg) {
            }, // event
            "maximize": function (evt, dlg) {
            }, // event
            "minimize": function (evt, dlg) {
            }, // event
            "restore": function (evt, dlg) {
            } // event
        });
        $('#doAuthcrLimit').off().click(function() {

        });
        $('#cancelWithoutSaving').off().click(function() {
            location.reload(true);
        });

    }
    $(document).on('click','#doAuthcrLimit',function(){
        $('#userAuthPassWordcrLimit').val();
        $.ajax({
            url: '{!!url("/verifyAuth")!!}',
            type: "POST",
            data: {
                userName: $('#userAuthNamecrLimit').val(),
                userPassword: $('#userAuthPassWordcrLimit').val()
            },
            success: function (data) {
                //console.debug("bunch"+data);
                if ($.isEmptyObject(data)) {
                    alert("Wrong Credentials Please Try Again!");
                } else
                {
                    $('#userAuthNamecrLimit').val('');
                    $('#creditLimitApproved').val('true');
                    $('#userAuthPassWordcrLimit').val('');
                    consoleManagementAuths('{!!url("/logMessageAuth")!!}',12,1,'Credit Limit on order Authorised by '+data[0].UserName,
                        0,$('#orderId').val(),0,$('#inputCustAcc').val(),0,0,0,$('#userNewVariablecrLimit').val(),'NULL',0,computerName,0,0,data[0].UserID,data[0].UserName);
                    $('#finishOrder').click();
                    $( "#creditLimitAuth" ).dialog('close');
                }
            }
        });
    });
    function authReprints()
    {

        $('#userAuthPassWordcrLimit').val();
        $.ajax({
            url: '{!!url("/verifyAuth")!!}',
            type: "POST",
            data: {
                userName: $('#userAuthNameReprint').val(),
                userPassword: $('#userAuthPassWordReprint').val()
            },
            success: function (data) {
                //console.debug("bunch"+data);
                if ($.isEmptyObject(data)) {
                    alert("Wrong Credentials Please Try Again!");
                } else
                {
                    $('#userAuthNameReprint').val('');
                    $('#userAuthPassWordReprint').val('');
                    printDoc('{!!url("/intoTblPrintedDoc")!!}', 1, $('#orderId').val(), 0,$('#invoiceNo').val());
                    consoleManagement('{!!url("/logMessageAjax")!!}', 300, 1, 'Document has been send to the printer -Reprint', 0, $('#orderId').val(), 0, 0, 0, 0, 0,  0, $('#orederNumber').val(), 0, computerName, $('#orderId').val(), 0);

                    consoleManagementAuths('{!!url("/logMessageAuth")!!}',12,1,'Re-Print Authorised by'+data[0].UserName,
                        0,0,0,0,0,0,0,0,'NULL',0,computerName,0,0,data[0].UserID,data[0].UserName);


                    $( "#reprintAuth" ).dialog('close');
                    disableOnFinish();
                }
            }
        });

    }
    function authProhited(token_number)
    {
        $('#prohibitedProductAuth').show();
        //$('#prohibitedProductAuth').show();
        console.debug('prohibited/----'+token_number);
        $('#userAuthProhibited').val('');
        $('#userAuthPassWordProhibited').val('');
        showDialogWithoutClose('#prohibitedProductAuth',600,400);

        $('#doCancelAuthProhibited').off().click(function(){
            console.debug('#new_row_ajax'+token_number);
            $('#new_row_ajax'+token_number).remove();
            $('#prohibitedProductAuth').dialog('close');
            generateALine2();
        });
        $('#doAuthProhibited').click(function(){
            $.ajax({
                url: '{!!url("/verifyAuth")!!}',
                type: "POST",
                data: {
                    userName: $('#userAuthProhibited').val(),
                    userPassword: $('#userAuthPassWordProhibited').val()
                },
                success: function (data) {
                    //console.debug("bunch"+data);
                    if ($.isEmptyObject(data)) {
                        alert("Wrong Credentials Please Try Again!");
                    } else
                    {

                        $('#userAuthProhibited').val('');
                        $('#userAuthPassWordProhibited').val('');
                        $('#prohibited_'+token_number).val('0');
                        console.debug('token_number--prohib'+token_number);

                        consoleManagement('{!!url("/logMessageAjax")!!}', 12, 1, 'Price Authorised on a prohibited Product '+$('#prodCode_' + token_number).val() +' by '+data[0].UserName, 0, $('#orderId').val(), 0, 0, 0, 0, 0,  0, $('#orderId').val(), 0, computerName, $('#orderId').val(), 0);

                        $('#prohibitedProductAuth').dialog('close');

                    }
                }
            });

        });

    }
    function authNewDiscountPerc(message)
    {



    }

    /**
     * This is now a multipurpose function , authChangeOfOrderType needs to be authChanges but it was too late for me to change it Reginald---25/10/2017 at Robberg
     * @param orderTypeName
     * @param message
     */
    function authChangeOfOrderType(orderTypeName,message)
    {
        console.debug("orderTypeName---"+orderTypeName);
        $('#userAuthPassWordDropDown').val();
        $.ajax({
            url: '{!!url("/verifyAuth")!!}',
            type: "POST",
            data: {
                userName: $('#userAuthNameDropDown').val(),
                userPassword: $('#userAuthPassWordDropDown').val()
            },
            success: function (data) {
                //console.debug("bunch"+data);
                if ($.isEmptyObject(data)) {
                    alert("Wrong Credentials Please Try Again!");
                } else
                {

                    $('#userAuthNameDropDown').val('');
                    $('#userAuthPassWordDropDown').val('');

                    consoleManagement('{!!url("/logMessageAjax")!!}', 12, 1, message+orderTypeName +' by '+data[0].UserName, 0, $('#orderId').val(), 0, 0, 0, 0, 0,  0, $('#orderId').val(), 0, computerName, $('#orderId').val(), 0);

                    $('#authDropDowns').dialog('close');

                }
            }
        });
    }
    function authReprintsOnTabletLoading()
    {

        $('#userAuthPassWordcrLimit').val();
        $.ajax({
            url: '{!!url("/verifyAuth")!!}',
            type: "POST",
            data: {
                userName: $('#userAuthNameReprint').val(),
                userPassword: $('#userAuthPassWordReprint').val()
            },
            success: function (data) {
                //console.debug("bunch"+data);
                if ($.isEmptyObject(data)) {
                    alert("Wrong Credentials Please Try Again!");
                } else
                {
                    $('#userAuthNameReprint').val('');
                    $('#userAuthPassWordReprint').val('');
                    printDoc('{!!url("/intoTblPrintedDoc")!!}', 1, $('#reprintOrderIdFromTablet').val(), 0,$('#reprintInvoiceFromTablet').val());
                    consoleManagement('{!!url("/logMessageAjax")!!}', 300, 1, 'Document has been send to the printer -Reprint', 0, $('#reprintOrderIdFromTablet').val(), 0, 0, 0, 0, 0,  0, $('#reprintOrderIdFromTablet').val(), 0, computerName, $('#orderId').val(), 0);

                    consoleManagementAuths('{!!url("/logMessageAuth")!!}',12,1,'Re-Print Authorised by'+data[0].UserName,
                        0,0,0,0,0,0,0,0,'NULL',0,computerName,0,0,data[0].UserID,data[0].UserName);


                    $( "#reprintAuth" ).dialog('close');
                    $( "#tabletLoadingDocDetails" ).dialog('close');
                    // disableOnFinish();
                }
            }
        });

    }
    function authPopup(tag,oldV,product,token,mess,isAuthprice,rowHiddenId)
    {

        //$('#userAuthName').
        $('#appendErrormsg').empty();
        $('#appendErrormsg').append(mess);

        $('#authorisations').show();
        $( "#authorisations" ).dialog({height: 250, modal: true,
            width: 500,containment: false}).dialogExtend({
            "closable" : false, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class
                "close" : "ui-icon-circle-close",
                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });
        console.debug(rowHiddenId);
        $('#noThanksRedo').off().click(function(){

            console.debug('#new_row_ajax'+rowHiddenId);
            $('#new_row_ajax'+rowHiddenId).remove();
            $('#authorisations').dialog('close');
            generateALine2();
        });
        $('#doAuth').off().click(function(){
            // $('#userAuthName').val();
            console.debug($('#userAuthPassWord').val());
            $('#userAuthPassWord').val();
            $.ajax({
                url: '{!!url("/verifyAuthOnAdmin")!!}' ,
                type: "POST",
                data:{userName:$('#userAuthName').val(),
                    userPassword:$('#userAuthPassWord').val()},
                success: function(data){
                    //console.debug("bunch"+data);
                    if ($.isEmptyObject(data)){
                        alert("Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                    }else
                    {
                        $('#userAuthName').val('');
                        $('#userAuthPassWord').val('');
                        console.debug('tag'+tag);
                        $('#'+isAuthprice).val('');
                        if(tag === "Price")
                        {
                            console.debug('auth id'+isAuthprice);
                            consoleManagementAuths('{!!url("/logMessageAuth")!!}',12,1,'Product price has been changed by '+data[0].UserName,
                                0,$('#orderId').val(),product,$('#inputCustAcc').val(),0,0,oldV,$('#userNewVariable').val(),$('#orderId').val(),0,computerName,$('#orderId').val(),0,data[0].UserID,data[0].UserName);
                            $( "#authorisations" ).dialog('close');
                            $('#'+token).val($('#userNewVariable').val());
                        }
                        if(tag == "Quantity")
                        {
                            consoleManagement('{!!url("/logMessageAuth")!!}',12,1,'Quantity has been changed',0,$('#orderId').val(),product,$('#inputCustAcc').val(),oldV,0,0,0,'NULL',0,computerName,0,0);
                        }

                    }
                }
            });

        });

    }
    function disableOnFinish()
    {

        location.reload(true);
        $('#orderId').val('');
        $('#address1').val('');
        $('#address2').val('');
        $('#address3').val('');
        $('#address4').val('');
        $('#address5').val('');
        $('#orederNumber').val('');
        $('#invoiceNo').val('');
        $('#generalRouteForNewDeliveryAddress').empty();
        $('#salesPerson').empty();
        $('#customerSelectedDelDate').val('');
        $('#inputCustAcc').val('');
        $('#inputCustName').val('');
        // $('#inputDeliveryDate').val('');
        // $('#inputOrderDate').val('');
        $(".fast_remove").empty();
        // $("#orderPatternIdTable").empty();
        $('.hidebody').hide();
        $('.itCanHide').show();
        $('#submitFilters').show();
        $("#inputDeliveryDate").prop("disabled", false);
        $("#changeDelvDate").prop("disabled", false);
        $("#changeDelvDate").prop("disabled", false);
        $("#inputCustName").prop("disabled", false);
        $("#inputCustAcc").prop("disabled", false);
        $("#orderId").prop("disabled", false);
        $("#inputOrderDate").prop("disabled", false);


    }
    function marginCalculator(cost,onCellVal)
    {
        return (1-(cost/onCellVal))*100;
    }
    function marginToPrice(cost,margin)
    {
        return (cost/(1-(margin/100)));
    }
    $(document).on('keyup', '.margin_', function(e) {
        var margin = $(this).closest("tr").find(".margin_").val();
        var cost = $(this).closest("tr").find(".prodCost_ ").val();
        $(this).closest("tr").find(".prodPrice_ ").val(  parseFloat(marginToPrice(cost,margin)).toFixed(2)) ;
    });
    function checkIfOrderHasMultipleProducts(productCode,token_number)
    {
        console.log("array"+arrayProdCodesCheck);
        if( $.inArray(productCode, arrayProdCodesCheck) !== -1 ) {
            if(productSetting == 'False')
            {
                var dialog = $('<p><strong style="color:red">Sorry '+productCode+' is already added on your order</strong></p>').dialog({
                    height: 200, width: 700,modal: true,containment: false,
                    buttons: {
                        "Okay": function () {
                            dialog.dialog('close');

                        }
                    }
                });
            }

        }
    }

    $(document).on('keydown', '#table', function(e) {
        var $table = $(this);

        var $active = $('input:focus,select:focus,li:focus',$table);
        var $next = null;
        var focusableQuery = 'input:visible,select:visible,textarea:visible,li:visible';
        var position = parseInt( $active.closest('td').index()) + 1;

        switch(e.keyCode){
            case 37: // <Left>
                $next = $active.parent('td').prev().find(focusableQuery);
                break;
            case 33: // <Up>

                $next = $active
                    .closest('tr')
                    .prev()
                    .find('td:nth-child(' + position + ')')
                    .find(focusableQuery)
                ;

                break;
            case 38: // <Up>

                $next = $active
                    .closest('tr')
                    .prev()
                    .find('td:nth-child(' + position + ')')
                    .find(focusableQuery)
                ;

                break;
            case 34: // <Right>
                $next = $active.closest('td').next().find(focusableQuery);
                break;
            case 40: // <Down>

                $next = $active
                    .closest('tr')
                    .next()
                    .find('td:nth-child(' + position + ')')
                    .find(focusableQuery)
                ;
                break;

        }
        if($next && $next.length)
        {
            $next.focus();
        }
    });
    function createAddressArray(url,CustomerCode) {
        var address1 = [];
        var address2 = [];
        var address3 = [];
        var address4 = [];
        var address5 = [];
        var objectTable = [];
        var i = 0;
        $('#addNewAddressModal tr').each(function () {

            var address1v = [];
            var address2v = [];
            var address3v = [];
            var address4v = [];
            var address5v = [];
            var valueobjectTable = [];

            $(this).find(".AddressLine1").each(function () {
                address1v.push($(this).val());
                valueobjectTable["AddressLine1"] = $(this).val();
            });
            $(this).find(".AddressLine2").each(function () {
                address2v.push($(this).val());
                valueobjectTable["AddressLine2"] = $(this).val();
            });
            $(this).find(".AddressLine3").each(function () {
                address3v.push($(this).val());
                valueobjectTable["AddressLine3"] = $(this).val();
            });
            $(this).find(".AddressLine4").each(function () {
                address4v.push($(this).val());
                valueobjectTable["AddressLine4"] = $(this).val();
            });
            $(this).find(".AddressLine5").each(function () {
                address5v.push($(this).val());
                valueobjectTable["AddressLine5"] = $(this).val();
            });

            address1.push(address1v);
            address2.push(address2v);
            address3.push(address3v);
            address4.push(address4v);
            address5.push(address5v);

            if ((address1v[0]) != 0 || (address2v[0]) != 0 || (address3v[0])!= 0 || (address4v[0]) != 0 || (address5v[0])!= 0) {
                objectTable[i] = valueobjectTable;
                i = i + 1;
            } else {

            }

        });
        for (var i = 0; i < objectTable.length; i++) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    AddressLine1: objectTable[i]['AddressLine1'],
                    AddressLine2: objectTable[i]['AddressLine2'],
                    AddressLine3: objectTable[i]['AddressLine3'],
                    AddressLine4: objectTable[i]['AddressLine4'],
                    AddressLine5: objectTable[i]['AddressLine5'],
                    CustomerCode: CustomerCode
                },
                success: function (data) {
                }
            });

        }
    }
    //copy the order
    $(document).on('click', '#copyOrdersBtn', function(e) {
        var valuesObject = new Array();
        var today = new Date();
        var dt_to = $.datepicker.formatDate('dd-mm-yy', new Date());
        $("#orderDateToCopy").val(dt_to);
        $("#delvDateToCopy").val(dt_to);
        $("#orderDateToCopy").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true,//this option for allowing user to select from year range
            dateFormat:"dd-mm-yy"

        });
        $("#delvDateToCopy").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat:"dd-mm-yy"

        });
        appenOderIds('#orderIdToCopy','{!!url("/getAllOrderIDs")!!}');

        $('#copyOrdersMenu').show();
        $( "#copyOrdersMenu" ).dialog({height: 500, modal: true,
            width: '90%',containment: false}).dialogExtend({
            "closable" : true, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class
                "close" : "ui-icon-circle-close",
                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });
        //autoCompleteOnCustomerToCopyOrderTo();
        //CustomerLineGenerator();
        $('#addCustomer').on('click',function(){
            CustomerLineGenerator();
            autoCompleteOnCustomerToCopyOrderTo();

        });

        //
        $( "#custCodeToCopyFrom" ).autocomplete({
            source:'{!!url("/custCode")!!}',
            minlength:2,
            autoFocus:true,
            select:function(e,ui)
            {
                if (!ui.item) {
                    $(event.target).val("");
                } else {
                    $('#custCodeToCopyFrom').val(ui.item.value);
                    $('#custDescToCopyFrom').val(ui.item.extra);
                    appenOderIdsOfCustomer('#orderIdToCopy','{!!url("/getCustomerOrderId")!!}',ui.item.value)

                }

            },
            focus: function (event, ui) {
                return false;
            }
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            var table = '<table class="table2"><tr style="font-size: 12px;color:black"><td style="background: green;width:25px;color:white">' +
                item.value + '</td><td>' +
                item.extra + '</td></tr></table>';
            return $("<li>")
                .data("ui-autocomplete-item", item)
                .append("<a>" + table + "</a>")
                .appendTo(ul);
        };

        $( "#custDescToCopyFrom" ).autocomplete({
            source:'{!!url("/custDescription")!!}',
            minlength:2,
            autoFocus:true,
            select:function(e,ui)
            {
                if (!ui.item) {
                    $(event.target).val("");
                } else {
                    $('#custCodeToCopyFrom').val(ui.item.extra);
                    $('#custDescToCopyFrom').val(ui.item.value);
                    appenOderIdsOfCustomer('#orderIdToCopy','{!!url("/getCustomerOrderId")!!}',ui.item.extra)

                }

            },
            focus: function (event, ui) {
                return false;
            }
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            var table = '<table class="table2"><tr style="font-size: 12px;color:black"><td style="background: green;width:25px;color:white">' +
                item.extra + '</td><td>' +
                item.value + '</td></tr></table>';
            return $("<li>")
                .data("ui-autocomplete-item", item)
                .append("<a>" + table + "</a>")
                .appendTo(ul);
        };
        $('#startCopying').hide();
        $("#orderIdToCopy").on("change", function() {
            //
            $.ajax({
                url:'{!!url("/onCheckOrderHeaderDetails")!!}',
                type: "POST",
                data:{orderId:this.value},
                success: function(data){
                    var trHTML ="";
                    $('.remthisLine').remove();

                    $.each(data, function (key,value) {
                        trHTML += '<tr  class="remthisLine" style="font-size: 11px;color:black;"><td>' +
                            value.PastelCode + '</td><td style="text-align: center;">' +
                            value.PastelDescription+ '</td><td style="text-align: center;background: blue;color: white;" contenteditable="true">' +
                            parseFloat(value.Qty).toFixed(2)+'</td><td>' +
                            parseFloat(value.Price).toFixed(2) + '</td>'+
                            '<td contenteditable="true">'+
                            '</td>'+
                            '<td><input type="checkbox" class="checkedOrderLine" name="case[]" style="height:auto !important"></td></tr>';

                    });
                    $('#tableOrdersDetailsToCopy').append(trHTML);


                    $('#doneDetailsToCopy').on('click',function(){
                        $('#startCopying').show();
                        var values = new Array();
                        $.each($("input[name='case[]']:checked"),
                            function () {
                                var data = $(this).parents('tr:eq(0)');
                                values.push({ 'desc':$(data).find('td:eq(1)').text(), 'code':$(data).find('td:eq(0)').text() , 'qty':$(data).find('td:eq(2)').text(),
                                    'price':$(data).find('td:eq(3)').text() , 'priceInc':$(data).find('td:eq(4)').text(),'comment':$(data).find('td:eq(5)').text()});
                            });
                        console.debug(values);
                        valuesObject = values;
                        //console.debug(valuesObject);

                    });
                }
            });

        });
        $('#startCopying').click(function(){
            arrayOfCustomerToCopyTo(valuesObject,$('#orderDateToCopy').val(),$('#delvDateToCopy').val());
        });

    });
    function CustomerLineGenerator(){
        var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));
        var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove">' +
            '<td contenteditable="false" ><input name="theCustCode" id ="theCustCode_'+tokenId+'" class="theCustCode_ set_autocomplete inputs"></td>' +
            '<td contenteditable="false" ><input name="theCustDescription_" id ="theCustDescription_'+tokenId+'" class="theCustDescription_ set_autocomplete inputs"></td>' +
            '<td contenteditable="false" class="col-md-3"><select name="delAddress_" id ="delAddress_'+tokenId+'" class="delAddress_ resize-input-inside" ></select></td>' +
            '<td contenteditable="false" class="col-md-3"><select name="delType_" id ="delType_'+tokenId+'" class="delType_ resize-input-inside" ></select></td>' +
            '<td  contenteditable="false" ><input type="text" name="orderNumber_" id ="orderNumber_'+tokenId+'" class="orderNumber_ resize-input-inside inputs lst"></td>' +
            '<td><button type="button" id="cancelThisCustomer" class="btn-danger btn-xs cancel" style="height: 16px;padding: 0px 5px;font-size: 9px;">Cancel</button></td></tr>');
        $('#customerToPick tbody')
            .append( $row );
        getOrderTypes('#delType_' + tokenId,'{!!url("/deliveryTypes")!!}');
        $('#delvDate_' + tokenId).datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true //this option for allowing user to select from year range
        });

    }
    function autoCompleteOnCustomerToCopyOrderTo()
    {
        $('input').on('click keyup', function () {
            var ID = $(this).attr('id');
            var jID = '#' + ID;
            console.debug(jID);

            var x = ID.indexOf("_");
            var get_token_number = ID.substring(x + 1, ID.length);
            if ($(this).hasClass("delvDate_")) {
                //alert("i am here");
                /* $("" + jID + "").datepicker({
                 changeMonth: true,//this option for allowing user to select month
                 changeYear: true //this option for allowing user to select from year range
                 });*/
            }
            if ($(this).hasClass("theCustCode_") && $(this).hasClass("set_autocomplete")) {
                $("" + jID + "").autocomplete({
                    source: function (request, response) {
                        $.getJSON("{!!url("/custCode")!!}", {
                                term: request.term
                            },
                            response);
                    },
                    minlength: 2,
                    autoFocus: true,
                    select: function (e, ui) {
                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        $('#theCustCode_' + token_number).val(ui.item.value);
                        $('#theCustDescription_' + token_number).val(ui.item.extra);
                        getCustomerAddress('#delAddress_' + token_number,'{!!url("/selectCustomerMultiAddress")!!}',ui.item.value);

                    }
                });

            }
            if ($(this).hasClass("theCustDescription_") && $(this).hasClass("set_autocomplete")) {
                $("" + jID + "").autocomplete({
                    source: function (request, response) {
                        $.getJSON("{!!url("/custDescription")!!}", {
                                term: request.term
                            },
                            response);
                    },
                    minlength: 2,
                    autoFocus: true,
                    select: function (e, ui) {
                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        $('#theCustCode_' + token_number).val(ui.item.extra);
                        $('#theCustDescription_' + token_number).val(ui.item.value);
                        getCustomerAddress('#delAddress_' + token_number,'{!!url("/selectCustomerMultiAddress")!!}',ui.item.extra);
                    }
                });
            }
        });
    }
    function getCustomerAddress(tag,url,CustomerCode)
    {
        $.ajax({
            url: url,
            type: "Post",
            data:{customerCode:CustomerCode},
            success: function(data){
                var toAppend = '';
                toAppend += '<option value=""></option>';
                $.each(data,function(i,o){

                    toAppend += '<option value="'+o.DeliveryAddressId+'"><table><tr><td style="background: green">'+o.DeliveryAddressId+' </td>|'+o.DAddress1+"|"+o.DAddress2+"|"+o.DAddress3+"|"+o.DAddress4+"|"+o.DAddress5+'</tr></table></option>';
                });
                $(tag).append(toAppend);
            }
        });
    }
    function arrayOfCustomerToCopyTo(productsObject,orderDate,DelvDate)
    {
        var theCustCode_ = [];
        var theCustDescription_ = [];
        var delvDate_ = [];
        var delAddress_ = [];
        var delAddressText_ = [];
        var orderNumber_ = [];
        var delType_ = [];
        var objectTable = [];
        var i = 0;
        $('#customerToPick tr').each(function () {

            var theCustCode_v = [];
            var theCustDescription_v = [];
            var delvDate_v = [];
            var delAddress_v = [];
            var delAddressText_v = [];
            var orderNumber_v = [];
            var delType_v = [];
            var valueobjectTable = [];

            $(this).find(".theCustCode_").each(function () {
                theCustCode_v.push($(this).val());
                valueobjectTable["theCustCode_"] = $(this).val();
            });
            $(this).find(".theCustDescription_").each(function () {
                theCustDescription_v.push($(this).val());
                valueobjectTable["theCustDescription_"] = $(this).val();
            });

            $(this).find(".delAddress_").each(function () {
                delAddress_v.push($(this).val());
                delAddressText_v.push($(this).text());
                valueobjectTable["delAddress_"] = $(this).val();
                valueobjectTable["delAddressText_"] = $(this).text();
            });
            $(this).find(".orderNumber_").each(function () {
                orderNumber_v.push($(this).val());
                valueobjectTable["orderNumber_"] = $(this).val();
            });
            $(this).find(".delType_").each(function () {
                delType_v.push($(this).val());
                valueobjectTable["delType_"] = $(this).val();
            });

            theCustCode_.push(theCustCode_v);
            theCustDescription_.push(theCustDescription_v);
            delvDate_.push(delvDate_v);
            delAddress_.push(delAddress_v);
            delAddressText_.push(delAddressText_v);
            orderNumber_.push(orderNumber_v);
            delType_.push(delType_v);

            if ((theCustCode_v[0]) != 0 && (theCustDescription_v[0]) != 0) {
                objectTable[i] = valueobjectTable;
                i = i + 1;
            } else {

            }

        });
        $('#copyingOrderProgress').show();
        showDialog('#copyingOrderProgress','35%',400);
        for (var i = 0; i < objectTable.length; i++) {
            $.ajax({
                url: '{!!url("/copyOrdersToCustomers")!!}',
                type: "POST",
                data: {
                    theCustCode_: objectTable[i]['theCustCode_'],
                    delvDate_: DelvDate,
                    orderDate: orderDate,
                    delAddress_: objectTable[i]['delAddress_'],
                    delAddressText_: objectTable[i]['delAddressText_'],
                    orderNumber_: objectTable[i]['orderNumber_'],
                    delType_: objectTable[i]['delType_'],
                    productsObject: productsObject
                },
                success: function (data) {

                    $('#copyingOrderProgress').append(data.custCode+" - "+data.orderId+'<br>');

                }
            });

        }
    }
    function showDialog(tag,width,height)
    {
        $( tag ).dialog({height: height, modal: false,
            width: width,containment: false}).dialogExtend({
            "closable" : true, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class

                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });
    }
    function showDialogWithoutClose(tag,width,height)
    {
        $( tag ).dialog({height: height, modal: true,
            width: width,containment: false}).dialogExtend({
            "closable" : false, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class
                "close" : "ui-icon-circle-close",
                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });
    }

    function quickSearchOnCustomerPrioritisePastelCode(finalDataArray,tag)
    {
        var inputCustNamesOnDispatchAfterMinus = $(tag).flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            focusFirstResult: true,
            searchContain:true,

            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: ["CustomerPastelCode","StoreName"],
            data: finalDataArray
        });
        inputCustNamesOnDispatchAfterMinus.on('select:flexdatalist', function (event, data) {

            $('.fast_remove').remove();
            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#custCreditLimit').val(data.CreditLimit);
            $('#orderIds').val('');
            $('#DeliveryDate').val('');
            //$('#balDue').val(parseFloat(data.BalanceDue).toFixed(2));
            //$('#boozeLisence').val(data.UserField5);
            $('#customerEmail').val(data.Email);
            $.ajax({
                url: '{!!url("/topOrdersOfACustomer")!!}',
                type: "POST",
                data:{custCode:data.CustomerPastelCode},
                success: function(data2){
                    console.debug(data.CustomerPastelCode);
                    $('#custDescriptionListOfOrder').empty();
                    var toAppend = '<option value=""></option>';

                    $.each(data2,function(i,o){
                        toAppend += '<option value="'+o.OrderId+'"><strong>'+o.OrderId+'</strong>   '+o.StoreName+'   '+o.OrderDate+'   '+'   '+o.DeliveryDate+'   <strong>'+o.Backorder+'</strong></option>';
                    });
                    $('#custDescriptionListOfOrder').append(toAppend);
                }
            });

        });
    }
    function changeDeliveryAddress()
    {
        $.ajax({
            url: '{!!url("/changeDeliveryAddressOnNoInvoiceNo")!!}',
            type: "POST",
            data:{customerCode:$('#inputCustAcc').val()},
            success: function(data){
                $('#tbldeliveryAddressOnOrderWithoutInoiceNo tbody').empty();
                $('#deliveryAddressOnOrderWithoutInoiceNo').show();
                showDialog('#deliveryAddressOnOrderWithoutInoiceNo','85%',640);
                var trHTML = '';
                $.each(data, function (key, value) {
                    trHTML += '<tr  class="rebuild_price_check_list" style="font-size: 10px;color:black"><td>' +
                        value.DeliveryAddressID + '</td><td>' +
                        value.DAddress1 + '</td><td>' +
                        value.DAddress2 + '</td><td>' +
                        value.DAddress3 + '</td><td>' +
                        value.DAddress4 + '</td><td>' +
                        value.DAddress5 + '</td>' +
                        '</tr>';
                });
                $('#tbldeliveryAddressOnOrderWithoutInoiceNo').append(trHTML);

                $('#tbldeliveryAddressOnOrderWithoutInoiceNo tbody').on('dblclick', 'tr', function () {
                    var deliveryID = $(this).closest('tr').find('td:eq(0)').text();
                    var address1 = $(this).closest('tr').find('td:eq(1)').text();
                    var address2 = $(this).closest('tr').find('td:eq(2)').text();
                    var address3 = $(this).closest('tr').find('td:eq(3)').text();
                    var address4 = $(this).closest('tr').find('td:eq(4)').text();
                    var address5 = $(this).closest('tr').find('td:eq(5)').text();
                    $('#hiddenDeliveryAddressId').val(deliveryID);
                    $('#address1hidden').val($.trim(address1));
                    $('#address2hidden').val($.trim(address2));
                    $('#address3hidden').val($.trim(address3));
                    $('#address4hidden').val($.trim(address4));
                    $('#address5hidden').val($.trim(address5));
                    $('#deliveryAddressOnOrderWithoutInoiceNo').dialog('close');
                    $('#customerSelectedDelDate').val($.trim(address1)+' '+$.trim(address2)+' '+$.trim(address3)+' '+$.trim(address4)+' '+$.trim(address4));

                });

            }
        });
    }
    function onChangeCustomerOnDispatchForm(tag)
    {
        $(tag).on("change", function() {
            var orderidChange = this.value;
            var dialog = $('<p>This Order has not been printed yet,someone could still be working on it, do you want to proceed? </p>').dialog({
                height: 200, width: 700, modal: true, containment: false,
                buttons: {
                    Yes: function () {
                        orderLock('{!!url("/restFullOrderLock")!!}',orderidChange);
                        orderUnLock('{!!url("/clearAllLocksRestFull")!!}');
                        $('#inputCustName').val('');
                        $('#inputCustAcc').val('');
                        $('#awaitingStockOnDispatchOrPickingForm').val('');f
                        $('#orderIds').val(orderidChange);
                        $('#DeliveryDate').val('');
                        $('#totalEx').val('');
                        $('#tot' +
                            '' +
                            '' +
                            '' +
                            'alInc').val('');
                        arrayOfCustomerInfo[0]='';
                        arrayOfCustomerInfo[1]='';
                        arrayOfCustomerInfo[2]='';
                        //makeLines(orderidChange);
                        makeALineWithOrderID(orderidChange,'#tableDispatch tbody', '{!!url("/onCheckOrderHeaderDetails")!!}','{!!url("/contactDetailsOnOrder")!!}',arrayOfCustomerInfo);
                        dialog.dialog('close');
                    },
                    No: function () {
                        dialog.dialog('close');
                    }
                }
            });
        });
    }
    document.onkeydown = function (e) {
        if (e.keyCode === 116) {

            if( ($('#orderId').val()).length > 2 && ($('#inputCustAcc').val()).length > 0 && ($('#inputCustName').val()).length > 0 )
            {
                $('#finishOrder').click();
                return false;
            }else
            {
                return true;
            }
        }
    };

    function posCalculator()
    {
        $('#posChange').val('');
        if (($('#posPayMentTypeCash').val()).length < 1 )
        {
            $('#posPayMentTypeCash').val(0);
        }
        if (($('#posPayMentTypeAccount').val()).length < 1 )
        {
            $('#posPayMentTypeAccount').val(0);
        }
        if (($('#posPayMentTypeCreditCard').val()).length < 1 )
        {
            $('#posPayMentTypeCreditCard').val(0);
        }
        if (($('#posPayMentTypeCheque').val()).length < 1 )
        {
            $('#posPayMentTypeCheque').val(0);
        }
        $('#confirmOnPosDialog').show();
        var cash = ((parseFloat($('#posPayMentTypeCash').val()) ).toFixed(2)) ;
        var accounts = ((parseFloat($('#posPayMentTypeAccount').val()) ).toFixed(2));
        var creditCard = ((parseFloat($('#posPayMentTypeCreditCard').val()) ).toFixed(2));
        var cheque = ((parseFloat($('#posPayMentTypeCheque').val()) ).toFixed(2));
        var totalTendered = (parseFloat(cash) + parseFloat(accounts) + parseFloat(creditCard) + parseFloat(cheque)).toFixed(2);
        $('#posTotalTendered').val(totalTendered);
        if(($('#posPayMentTypeCash').val()).lenght > 0)
        {
            $('#posCashTendered').val(parseFloat($('#posPayMentTypeCash').val()));
        }else
        {
            $('#posCashTendered').val(parseFloat($('#posPayMentTypeCash').val()));
        }
        var noChangeOnOtherPaymentMethods = (parseFloat(accounts) + parseFloat(creditCard) + parseFloat(cheque)).toFixed(2);


        if(noChangeOnOtherPaymentMethods >= parseFloat($('#posInvTotal').val()))
        {
            console.debug("noChangeOnOtherPaymentMethods"+noChangeOnOtherPaymentMethods);
            $('#posChange').val(cash);

        }
        else
        {
            var change = (totalTendered - parseFloat($('#posInvTotal').val())).toFixed(2);
            $('#posChange').val(change);
        }



    }
    function waitingInvoice()
    {
        //
        $.ajax({
            url: '{!!url("/waitingForInvoiceNo")!!}' ,
            type: "POST",
            data:{orderID: $('#orderId').val(),customerCode:$('#inputCustAcc').val(),
                TotalTendered:$('#posTotalTendered').val(),Change:$('#posChange').val()
                ,AmountToPost:$('#posCashTendered').val(),
                posPayMentTypeCash:$('#posPayMentTypeCash').val(),
                posPayMentTypeAccount:$('#posPayMentTypeAccount').val(),
                posPayMentTypeCreditCard:$('#posPayMentTypeCreditCard').val(),
                posPayMentTypeCheque:$('#posPayMentTypeCheque').val(),
                invoiceTotal:$('#totalInc').val()
            },
            success: function(data){
                console.debug(data);
                if(data != 'False'){
                    disableOnFinish();
                }
            }
        });
    }
    function PosDialog()
    {
        $('#pointOfSaleDialog').show();
        showDialog('#pointOfSaleDialog',910,400);
        calculator();
        var discount = ( parseFloat($('#totalInc').val() * ($('#hiddenCustDiscount').val() /100)).toFixed(2) );
        console.debug("*****************"+discount);

        var totalToBeInvoiced = (parseFloat($('#totalInc').val()) - parseFloat(discount) ).toFixed(2);
        $('#posOrdernumber').val($('#orderId').val());
        $('#posInvTotal').val($('#totalInc').val());
        $('#confirmOnPosDialog').click(function(){

            if(parseFloat($('#posChange').val()).toFixed(2) < 0 )
            {

                var dialog = $('<p><strong style="color:black">sorry the invoice will not print,Please check your change</strong></p>').dialog({
                    height: 200, width: 700, modal: true, containment: false,
                    buttons: {

                        "Okay": function () {

                            dialog.dialog('close');
                        },
                        "Cancel": function () {

                            dialog.dialog('close');
                        }

                    }
                });
            }else
            {//$('#orderId').val()
                consoleManagement('{!!url("/logMessageAjax")!!}', 600, 3, 'POS Confirm Btn ,TotTendered: '+$('#posTotalTendered').val()+' Inv: '+ $('#totalInc').val(), 0, 0, 0, 0, 0, 0, 0, 0, $('#orederNumber').val(), 0, computerName, $('#orderId').val(), 0);

                var dialog = $('<p><strong style="color:black">Please Wait, Do not touch anything we are watching you...</strong></p>').dialog({
                    height: 200, width: 700, modal: true, containment: false,
                    buttons: {
                        "Okay": function () {
                            dialog.dialog('close');
                        },

                    }
                });
                printDoc('{!!url("/intoTblPrintedDoc")!!}', 1,$('#orderId').val() , 0,$('#invoiceNo').val());
                waitingInvoice();
                setInterval( waitingInvoice , 5000 );

            }

        });
    }
    function upDateOrderHeaderAndPOS()
    {

        $.ajax({
            url: '{!!url("/updateOrderHeader")!!}',
            type: "POST",
            data: {
                orderDate: $('#inputOrderDate').val(),
                orderId: $('#orderId').val(),
                deliveryDate: $("#inputDeliveryDate").val(),
                routeId: $('#routeName').val(),
                OrderType: $('#orderType').val(),
                orderNo: $('#orederNumber').val(),
                messagebox: $('#messagebox').val(),
                awaitingStock: $('#awaitingStock').val(),
                customerCode: $('#inputCustAcc').val(),
                DeliveryAddressID: $('#hiddenDeliveryAddressId').val(),
                address1hidden: $('#address1hidden').val(),
                address2hidden: $('#address2hidden').val(),
                address3hidden: $('#address3hidden').val(),
                address4hidden: $('#address4hidden').val(),
                address5hidden: $('#address5hidden').val()
            },
            success: function (data) {

                //Point of sale change the route to collection
                $.ajax({
                    url: '{!!url("/updatePosRoute")!!}',
                    type: "GET",
                    data: {orderId: $('#orderId').val()},
                    success: function (data2) {
                        PosDialog();
                    }
                });
            }
        });
    }

</script>

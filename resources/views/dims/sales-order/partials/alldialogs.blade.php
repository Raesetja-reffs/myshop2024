<div id="callListDialog" title="Call List">
    <div class="col-lg-12" style="background: #f3b9c3">
        <form>
            <div class="form-group col-md-3">
                <label class="control-label" for="callListOrderDate"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Date</label>
                <input type="text" class="form-control input-sm col-xs-1" id="callListOrderDate"
                    scustomeronholdtyle="font-size: 10px;">
            </div>
            <div class="form-group col-md-3">
                <label class="control-label" for="callListDeliveryDate"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                @if (count($callistDelvDate) > 0)
                    <input type="text" class="form-control input-sm col-xs-1" id="callListDeliveryDate"
                        value="{{ $callistDelvDate[0]->dteSessionDate }}" style="font-size: 10px;">
                @else
                    <input type="text" class="form-control input-sm col-xs-1" id="callListDeliveryDate"
                        style="font-size: 10px;">
                @endif

            </div>
            <div class="form-group col-md-3">
                <label class="control-label" for="callListUser"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">User</label>
                <select class="form-control input-sm col-xs-1" name="callListUser" id="callListUser">
                    <option value="{{ Auth::user()->UserID }}">{{ Auth::user()->UserName }}</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label class="control-label" for="routeToFilterWith"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                <select class="form-control input-sm col-xs-1" name="routeToFilterWith" id="routeToFilterWith">
                    @foreach ($callistCurrentRoute as $value)
                        <option value="{{ $value->Routeid }}">{{ $value->Route }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" id="passCallistFilter" class="btn-lg btn-success">Press Go!</button>
        </form>
        <div class="col-lg-12" style="height:500px; overflow-y:scroll;">
            <table class="table2 table-bordered" id="callListTable" style="overflow-y: auto;width:100%" tabindex=0>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Call</th>
                        <th>Account Contact</th>
                        <th>Buyer Tel</th>
                        <th>Buyer Cell</th>
                        <th>Route</th>
                        <th>Buyer </th>
                        <th>Address</th>
                        <th>Notes</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
    <a href='{!! url('/getphonebook') !!}' clas="btn-md bnt-primary pull-right"
        style="color:black;font-weight:900;text-decoration: underline; padding: 3px;"
        onclick="window.open(this.href, 'getphonebook','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Phone
        Book</a>
</div>

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

<div id="copyOrderDialog" title="Copying Order">
    <div class="col-lg-12">
        <form>
            <div class="form-group col-md-2">
                <label class="control-label" for="copyDeliveryDate"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                <input type="text" class="form-control input-sm col-xs-1" id="copyDeliveryDate"
                    style="font-size: 10px;">
            </div>
            <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="inputOrderId"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Type</label>
                <select class="form-control input-sm col-xs-1" id="CopyorderType" style="font-size: 10px;"></select>
            </div>
            <div class="form-group col-md-2">
                <label class="control-label" for="inputOrderId"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;"></label>
                <input type="hidden" class="form-control input-sm col-xs-1" id="copyCustCode"
                    style="font-size: 10px;">
                <input type="hidden" class="form-control input-sm col-xs-1" id="copyRouteID"
                    style="height:15px;font-size: 10px;">
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
            <label class="control-label" for="userAuthName"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
            <input class="form-control input-sm col-md-4 auto-complete-off" name="userAuthName" id="userAuthName"
                style="height:30px;font-size: 10px;">
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthPassWord"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
            <input type="password" name="userAuthPassWord" class="form-control input-sm col-md-4 auto-complete-off"
                id="userAuthPassWord" style="height:30px;font-size: 10px;" readonly
                onfocus="$(this).removeAttr('readonly');">
        </div>
        <div>
            <div class="form-group  col-md-4"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;display:none;">
                <label class="control-label" for="userNewVariable"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">New Val</label>
                <input type="text" name="userNewVariable" class="form-control input-sm col-md-4"
                    id="userNewVariable" style="height:30px;font-size: 10px;" value="0" readonly>
            </div>
        </div>
        <button type="button" id="doAuth" class="btn-success btn-xs" style="margin-top: 4%;">Authorise</button>
    </form>

    <button type="button" id="noThanksRedo" class="btn-warning btn-xs pull-right" style="margin-top: 10%;">No
        Thanks Redo the Line</button>

</div>

<div id="custLookUp" title="Price look up on order" style="background: darkorange;">
    <div class="col-lg-12">
        <div id="productSelectedForPriceListOrderForm"></div>
        <table class="table" id="customersellingPrice" style="width:100%">
            <thead>
                <tr>
                    <th>Price</th>
                    <th>Delv Date</th>
                </tr>
            </thead>
        </table>
        <hr>
        <h5>Other Prices</h5>
        <table class="table" id="customerDetailLookUp" style="width:100%">
            <thead>
                <tr>
                    <th>Price List</th>
                    <th>Price</th>
                </tr>
            </thead>
        </table>
        <input type="text" id="lastprice" readonly>
        <input type="text" id="costOnCustomerOrangeForm" readonly style="background:red;">Cost
    </div>
</div>

<div id="extrasononrder" title="Extras" style="background: #9ab5bb;">
    <div class="col-lg-12">
        <input type="text" id="randomweightdescription" style="width: 100%;" readonly>
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

<div id="reprintAuth" title="Please Authorise before using this action" style="background:rgba(0,0,255,0.31)">
    <form>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthNameReprint"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
            <input class="form-control input-sm col-md-4 auto-complete-off" name="userAuthNameReprint"
                id="userAuthNameReprint" style="height:30px;font-size: 10px;">
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthPassWordReprint"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
            <input type="password" name="userAuthPassWordReprint"
                class="form-control input-sm col-md-4 auto-complete-off" id="userAuthPassWordReprint"
                style="height:30px;font-size: 10px;" readonly onfocus="$(this).removeAttr('readonly');">
        </div>

        <button type="button" id="doAuthReprint" class="btn-success btn-xs pull-right"
            style="margin-top: 29px;margin-right: 15px;">Authorise</button>
    </form>
</div>

<div id="authDropDowns" title="Please Authorise before using this action" style="background:rgba(0,0,255,0.31)">
    <h4 style="color:red">BY CLICKING CANCEL THIS WILL GO BACK TO THE ORIGINAL DATA LOADED WITH THIS ORDER</h4>

    <form>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthNameDropDown"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
            <input class="form-control input-sm col-md-4 auto-complete-off" name="userAuthNameDropDown"
                id="userAuthNameDropDown" style="height:30px;font-size: 10px;">
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthPassWordDropDown"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
            <input type="password" name="userAuthPassWordDropDown"
                class="form-control input-sm col-md-4 auto-complete-off" id="userAuthPassWordDropDown"
                style="height:30px;font-size: 10px;" readonly onfocus="$(this).removeAttr('readonly');">
        </div>

        <button type="button" id="doAuthDropDown" class="btn-success btn-xs pull-right"
            style="margin-top: 29px;margin-right: 15px;">Authorise</button>
        <button type="button" id="doCancelAuthDropDown" class="btn-warning btn-xs pull-right"
            style="margin-top: 29px;margin-right: 15px;">Cancel</button>
    </form>
</div>

<div id="authDropDownsClosedRoutePass" title="Please Authorise" style="background:rgba(0,0,255,0.31)">
    <h4 style="color:red">The Route You Are Trying to Place this Order Is Currently Closed Please Authorise First.
    </h4>

    <form>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthClosedRoute"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
            <input class="form-control input-sm col-md-4 auto-complete-off" name="userAuthClosedRoute"
                id="userAuthClosedRoute" style="height:30px;font-size: 10px;">
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthClosedRoutePass"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
            <input type="password" name="userAuthClosedRoutePass"
                class="form-control input-sm col-md-4 auto-complete-off" id="userAuthClosedRoutePass"
                style="height:30px;font-size: 10px;" onfocus="$(this).removeAttr('readonly');">
        </div>

        <button type="button" id="doAuthDropDownClosedRoutePass" class="btn-success btn-xs pull-right"
            style="margin-top: 29px;margin-right: 15px;">Authorise</button>
        <button type="button" id="doCancelAuthDropDownClosedRoutePass" class="btn-warning btn-xs pull-right"
            style="margin-top: 29px;margin-right: 15px;">Cancel</button>
    </form>
</div>

@include('dims.sales-order.partials.addnewaddress')

<div id="multipleDeliveriesOnTheSameDate" title="Orders">
    <div class="col-lg-12">
        <table class="table table-bordered table-condensed" style="font-family: sans-serif;color:black"
            id="multipleAddressesOnTheSameDateModal">
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

<div id="salesOEmail" title="Sales Order">
    <div class="col-lg-12">
        <form>
            <div class="form-group ">
                <label class="control-label" for="fromEmail"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">From</label>
                <input type="text" class="form-control input-sm col-xs-1" id="fromEmail" style="font-size: 10px;"
                    value="{{ Auth::user()->Email }}">
            </div>
            <div class="form-group ">
                <label class="control-label" for="toEmail"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">To</label>
                <input type="text" class="form-control input-sm col-xs-1" id="toEmail"
                    style="font-size: 10px;">
            </div>
            <div class="form-group " style="display:none">
                <label class="control-label" for="cc"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">CC</label>
                <input type="text" class="form-control input-sm col-xs-1" id="cc"
                    style="font-size: 10px;">
            </div>
            <div class="form-group ">
                <label class="control-label" for="subject"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Subject</label>
                <input type="text" class="form-control input-sm col-xs-1" id="subject"
                    style="font-size: 10px;">
            </div>
            <div class="form-group ">
                <label class="control-label" for="bodyOnEmail"
                    style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Message</label>
                <input class="form-control" id="bodyOnEmail" style="height:100px"
                    value="Thank you ,the attached document is your order.">
            </div>
            <button type="button" id="sendOrderEmail" class="btn-success btn-xs ">Send</button>
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

<div id="deliveryAddressOnOrderWithoutInoiceNo" title="Please Change the Delivery Address">
    <p>Please Double click To Change the Delivery Address</p>
    <table class="table" id="tbldeliveryAddressOnOrderWithoutInoiceNo" style="width:100%">
        <thead>
            <tr>
                <th>Delivery Address Id</th>
                <th>Address 1 </th>
                <th>Address 2</th>
                <th>Address 3 </th>
                <th>Address 4</th>
                <th>Address 5</th>
                <th>Route</th>
                <th>Route ID</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div id="tamaraCalculator" title="Calculate" class="col-md-12">
    <form id="formID">
        <table class="calculator" cellspacing="0" cellpadding="1">
            <tr>
                <td colspan="5"><input id="display" class="form-control input-sm col-xs-1" name="display"
                        value="0" size="28" maxlength="25"></td>
            </tr>
            <tr>
                <td><input type="button" class="btnTop" name="btnTop" value="C"
                        onclick="this.form.display.value=  0 "></td>
                <td><input type="button" class="btnTop" name="btnTop" value="<--"
                        onclick="deleteChar(this.form.display)"></td>
                <td><input type="button" id="equalOnCalculator" class="btnTop" name="btnTop" value="="
                        onclick="if(checkNum(this.form.display.value)) { compute(this.form) }"></td>
                <td><input type="button" class="btnOpps" name="btnOpps" value="&#960;"
                        onclick="addChar(this.form.display,'3.14159265359')"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="%"
                        onclick=" percent(this.form.display)"></td>
            </tr>
            <tr>
                <td><input type="button" class="btnNum" name="btnNum" value="7"
                        onclick="addChar(this.form.display, '7')"></td>
                <td><input type="button" class="btnNum" name="btnNum" value="8"
                        onclick="addChar(this.form.display, '8')"></td>
                <td><input type="button" class="btnNum" name="btnNum" value="9"
                        onclick="addChar(this.form.display, '9')"></td>
                <td><input type="button" class="btnOpps" name="btnOpps" value="x&#94;"
                        onclick="if(checkNum(this.form.display.value)) { exp(this.form) }"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="/"
                        onclick="addChar(this.form.display, '/')"></td>
            <tr>
                <td><input type="button" class="btnNum" name="btnNum" value="4"
                        onclick="addChar(this.form.display, '4')"></td>
                <td><input type="button" class="btnNum" name="btnNum" value="5"
                        onclick="addChar(this.form.display, '5')"></td>
                <td><input type="button" class="btnNum" name="btnNum" value="6"
                        onclick="addChar(this.form.display, '6')"></td>
                <td><input type="button" class="btnOpps" name="btnOpps" value="ln"
                        onclick="if(checkNum(this.form.display.value)) { ln(this.form) }"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="*"
                        onclick="addChar(this.form.display, '*')"></td>
            </tr>
            <tr>
                <td><input type="button" class="btnNum" name="btnNum" value="1"
                        onclick="addChar(this.form.display, '1')"></td>
                <td><input type="button" class="btnNum" name="btnNum" value="2"
                        onclick="addChar(this.form.display, '2')"></td>
                <td><input type="button" class="btnNum" name="btnNum" value="3"
                        onclick="addChar(this.form.display, '3')"></td>
                <td><input type="button" class="btnOpps" name="btnOpps" value="&radic;"
                        onclick="if(checkNum(this.form.display.value)) { sqrt(this.form) }"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="-"
                        onclick="addChar(this.form.display, '-')"></td>
            </tr>
            <tr>
                <td><input type="button" class="btnMath" name="btnMath" value="&#177"
                        onclick="changeSign(this.form.display)"></td>
                <td><input type="button" class="btnNum" name="btnNum" value="0"
                        onclick="addChar(this.form.display, '0')"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="&#46;"
                        onclick="addChar(this.form.display, '&#46;')"></td>
                <td><input type="button" class="btnOpps" name="btnOpps" value="x&#50;"
                        onclick="if(checkNum(this.form.display.value)) { square(this.form) }"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="+"
                        onclick="addChar(this.form.display, '+')"></td>
            </tr>
            <tr>
                <td><input type="button" class="btnMath" name="btnMath" value="("
                        onclick="addChar(this.form.display, '(')"></td>
                <td><input type="button" class="btnMath" name="btnMath" value=")"
                        onclick="addChar(this.form.display,')')"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="cos"
                        onclick="if(checkNum(this.form.display.value)) { cos(this.form) }"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="sin"
                        onclick="if(checkNum(this.form.display.value)) { sin(this.form) }"></td>
                <td><input type="button" class="btnMath" name="btnMath" value="tan"
                        onclick="if(checkNum(this.form.display.value)) { tan(this.form) }"></td>
            </tr>
        </table>
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

<div id="prohibitedProductAuth" title="Please Authorise">
    <h5>This is a Prohibited Product</h5>
    <form>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthProhibited"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
            <input class="form-control input-sm col-md-4 auto-complete-off" name="userAuthProhibited"
                id="userAuthProhibited" style="height:30px;font-size: 10px;" autocomplete="off"></input>
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthPassWordProhibited"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
            <input type="password" name="userAuthPassWordProhibited"
                class="form-control input-sm col-md-4 auto-complete-off" id="userAuthPassWordProhibited"
                style="height:30px;font-size: 10px;" readonly onfocus="$(this).removeAttr('readonly');"
                autocomplete="off">
        </div>

        <button type="button" id="doAuthProhibited" class="btn-success btn-xs pull-right"
            style="margin-top: 29px;margin-right: 15px;">Authorise</button>
        <button type="button" id="doCancelAuthProhibited" class="btn-warning btn-xs pull-right"
            style="margin-top: 29px;margin-right: 15px;">No Thanks,Redo The Line</button>
    </form>
</div>

<div id="authDiscount" title="Authorise Discount">
    <h5>To change the Discount % you need to put in the new discount % and authorise</h5>
    Discount %<input class="form-control input-sm col-md-4" id="newDiscountPercentage"
        onkeypress="return isFloatNumber(this,event)">
    <form>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthDisc"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
            <input class="form-control input-sm col-md-4 auto-complete-off" name="userAuthDisc" id="userAuthDisc"
                style="height:30px;font-size: 10px;" autocomplete="off">
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthPassWordDisc"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
            <input type="password" name="userAuthPassWordDisc"
                class="form-control input-sm col-md-4 auto-complete-off" id="userAuthPassWordDisc"
                style="height:30px;font-size: 10px;" readonly onfocus="$(this).removeAttr('readonly');"
                autocomplete="off">
        </div>

        <button type="button" id="doAuthDiscounts" class="btn-success btn-xs pull-right"
            style="margin-top: 29px;margin-right: 15px;">Authorise</button>
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

<div title="In Stock Warning" id="popLessStock" style="background:yellow;font-weight:900;color:red;">
    <h2 style="text-align:center;">There Is Less Available</h2>
</div>

<div title="In Stock Warning" id="popZeroStock" style="background:red;font-weight:900;color:white;">
    <h2 style="text-align:center;">There Is 0 (ZERO) Available</h2>
</div>

<div title="Create Order" class="col-md-6" id="createOrderOnCallList">
    <h3>Press YES to create Or NO to Cancel</h3>
    <div class="col-md-3">
        <button class="btn-md btn-success" id="yesOnCreatingOrderFromCallList">YES</button>
    </div>
    <div class="col-md-3">
        <button class="btn-md btn-danger" id="noOnCreatingOrderFromCallList">NO.</button>
    </div>

</div>

<div id="emailDoc" title="Email Document">
    <label>From :</label> <input id="yourEmail" name="yourEmail"><br>
    <label>To :</label> <input id="customerEmail" name="customerEmail">
    <button id="emailthis" class="btn-md btn-success">Send</button>
</div>

<div id="salesmandialog" title="Choose the Salesman" style="background: ghostwhite;">
    <label>Salesman</label><br>

    <select id="salesmanselectstatement">
        @foreach ($salesmen as $value)
            <option value="{{ $value->strSalesmanCode }}">{{ $value->UserName }}</option>
        @endforeach
    </select>
    <br>
    <div>
        <fieldset>
            <legend>This require authorization. </legend>
            <div>
                <label>UserName</label><br>
                <input id="authsalesmanusername" class="form-control input-sm col-md-4 auto-complete-off">
            </div>
            <div>
                <label>Password</label><br>
                <input type="password" id="authsalesmanpassword"
                    class="form-control input-sm col-md-4 auto-complete-off">
            </div>
        </fieldset>

    </div>
    <button id="submitsalesman" class="btn-md btn-success">Submit</button>
</div>

<div id="routingdialog" title="Choose Route" style="background: #ffa65d;">
    <label>Route</label><br>

    <select id="changetcurrentrouteonorder">
        @foreach ($routesNames as $value)
            <option value="{{ $value->Routeid }}">{{ $value->Route }}</option>
        @endforeach
    </select>
    <br>
    <p>BY CLICKING SUBMIT YOU ARE AUTHORISING THE ROUTE CHANGE ON THIS ORDER</p>
    <button id="auththisrouteontheorder" class="btn-md btn-success">Submit</button>
</div>

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

<div id="qtyzero" title="Quatity of 0">
    <p><strong style="color:red">You have entered zero (0) quantity.</strong></p>
    <button id="yestozeroqty" class="btn-md btn-danger">OKAY</button>
</div>

<div id="MarginProblems" title="Please Authorise">
    <h5>The Order/Product is below the minimum margin, Please Authorise and Report to your manager </h5>
    <form>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <input id="margin_auth" type="hidden" value="0">
            <label class="control-label" for="userAuthProhibitedCred"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
            <input class="form-control col-md-4 auto-complete-off" id="userAuthProhibitedCred_marg"
                name="userAuthProhibitedCred" style="height:30px;font-size: 10px;" autocomplete="off">
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthPassWordCredit"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
            <input type="password" name="userAuthPassWordCredit" class="form-control col-md-4 auto-complete-off"
                id="userAuthPassWordCredit_marg" style="height:30px;font-size: 10px;" autocomplete="off">
        </div>

        <div class="form-group  col-md-12">
            <div class="form-group  col-md-6">
                <button type="button" id="doAuthCredits" class="btn-success btn-xs pull-right"
                    style="margin-top: 29px;margin-right: 15px;">Authorise</button>
            </div>
            <div class="form-group  col-md-6">
                <button type="button" id="doCancelAuthCredits" class="btn-danger btn-xs pull-right"
                    style="margin-top: 29px;margin-right: 15px;">Cancel</button>
            </div>
        </div>
    </form>
</div>

<div id="ZeroPrice" title="Please Authorise">
    <h5>The product has zero(0) price ,please authorise. </h5>
    <form>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userauthproductwithzeroprice"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
            <input class="form-control col-md-4 auto-complete-off" id="userauthproductwithzeroprice"
                name="userauthproductwithzeroprice" style="height:30px;font-size: 10px;" autocomplete="off">
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthPassWordzeroprice"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
            <input type="password" name="userAuthPassWordzeroprice"
                class="form-control col-md-4 auto-complete-off" id="userAuthPassWordzeroprice"
                style="height:30px;font-size: 10px;" autocomplete="off">
        </div>

        <div class="form-group  col-md-12">
            <div class="form-group  col-md-6">
                <button type="button" id="doAuthZeroPrice" class="btn-success btn-xs pull-right"
                    style="margin-top: 29px;margin-right: 15px;">Authorise</button>
            </div>
            <div class="form-group  col-md-6">
                <button type="button" id="doCancelAuthZeroPrice" class="btn-danger btn-xs pull-right"
                    style="margin-top: 29px;margin-right: 15px;">Re-do Line</button>
            </div>
        </div>
    </form>
</div>

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

<div title="ACCOUNT ON HOLD" id="authonholdaccount">
    <h2>PLEASE AUTHORIZE</h2>
    <form>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="onholdaccountmanagername"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label><br>
            <input class="" id="onholdaccountmanagername" name="onholdaccountmanagername"
                style="height:30px;font-size: 10px;" autocomplete="off" value="-">
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="onholdaccountmanagerpassword"
                style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label><br>
            <input type="password" name="onholdaccountmanagerpassword" class=""
                id="onholdaccountmanagerpassword" style="height:30px;font-size: 10px;" autocomplete="off"
                value="-">
        </div><br>
        <div>
            <button type="button" id="doAuthZeroonholdaccount" class="btn-success btn-xs pull-right"
                style="margin-top: 29px;margin-right: 15px;">Authorise</button>
        </div>
        <div class="form-group  col-md-12">
            <div>
                <fieldset>
                    <legend>NB :THIS ORDER WILL NOT GO FOR PICKING UNTIL AUTHORISATION.</legend>
                    <button type="button" id="treattheauthaccountasquotation"
                        class="btn-danger btn-xs pull-right"
                        style="margin-top: 29px;margin-right: 15px;display:none;">Notify Managers And
                        Continue</button>
                </fieldset>
            </div>
        </div>
    </form>
</div>

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

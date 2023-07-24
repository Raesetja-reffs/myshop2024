@extends('layouts.app')

@section('content')
    <?php
    if ((Auth::guest()))
    {

    }else{
        $v  =  new \App\Http\Controllers\SalesForm();
        $thingsAllowDiscount = $v->getThings(Auth::user()->GroupId,'Discountinput');
        $userActions = $v->getThings(Auth::user()->GroupId,'Access User Actions');
    }
    $discountProperty = "";
    if($thingsAllowDiscount != 1)
    {
        $discountProperty = "readonly";
    }

    ?>
    <div class="col-lg-12">

        <div class="row">
            <div class="col-lg-12 text-center" style="height:60px;">
                <div class="col-lg-4"></div>
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <table class="table" style="margin-bottom: -14px;font-family: monospace;">
                        <tr style="font-size: 10px;" >
                            <td>No.Orders Today</td>
                            <td>Order Val</td>
                            <td>Avg Ord Val</td>
                        </tr>
                        @foreach($userperformance as $value)
                            <tr>
                                <td>{{$value->NoOfOrders}}</td>
                                <td>{{round($value->OrderValue,2)}}</td>
                                <td>{{round($value->AvgOrderValue,2)}}</td>

                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="col-lg-12 p-3" style="background-color: white;">
                <div class="col-lg-3 h-100">
                    <div class="form-group col-md-4">
                        <label class="control-label" for="inputOrderId">Inv No.</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="invoiceNo" autocomplete="off">
                        <input type="hidden"  id="invoiceNoKeeper">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label" for="inputOrderId">Order ID</label>
                        <input type="number" class="form-control input-sm col-xs-1" id="orderId"  autocomplete="off" style="font-size: 13px;font-weight: 900;">
                    </div>
                    <button type="button" id="checkOrders" class="btn btn-primary">Check</button>
                </div>

                <div class="col-lg-9 h-100">
                    <div class="form-group  col-md-2">
                        <label class="control-label" for="inputOrderId">Delivery Type</label>
                        <select class="form-control input-sm col-xs-1" id="orderType" disabled></select>
                    </div>
                    <div class="form-group  col-md-2">
                        <label class="control-label" for="inputCustAcc">Account</label>
                        <input type="text" name="custCode" class="form-control input-sm col-xs-1" id="inputCustAcc">
                        <input type="hidden" name="hiddenCustomerNotes" class="form-control input-sm col-xs-1" id="hiddenCustomerNotes" >
                        <input type="hidden" name="hiddenRouteId" class="form-control input-sm col-xs-1" id="hiddenRouteId" >
                        <input type="hidden" name="hiddenRouteName" class="form-control input-sm col-xs-1" id="hiddenRouteName" >
                        <input type="hidden" name="CustomerId" class="form-control input-sm col-xs-1" id="CustomerId">
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label" for="inputCustName">Customer Name</label>
                        <input type="text" name="custDescription" class="form-control input-sm col-xs-1" id="inputCustName">
                        <input type="hidden" name="customerEmail" class="form-control input-sm col-xs-1" id="customerEmail" >
                        <input type="hidden" name="Routeid" class="form-control input-sm col-xs-1" id="Routeid" >
                        <input type="hidden" name="hiddenCustDiscount" class="form-control input-sm col-xs-1" id="hiddenCustDiscount" >
                        <input type="hidden" name="hiddencustomerGp" class="form-control input-sm col-xs-1" id="hiddencustomerGp" >
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label" for="inputOrderDate">Order Date</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="inputOrderDate" style="font-weight: 900;    color: black;font-size: 13px;">
                    </div>
                    <div class="form-group col-md-2 ">
                        <label class="control-label" for="inputDeliveryDate">Delivery Date</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="inputDeliveryDate" style="font-weight: 900;    color: black;font-size: 13px;">

                    </div>

                    <button type="button" id="submitFilters" class="btn btn-primary">Submit</button>
                </div>
            </div>

            <div class="col-md-8 visible-md visible-lg" >

                <div class="panel panel-default hidebody" id="toAutoScroll" style="height: 44%;min-height: 200px;overflow-y:auto;" >
                    <div id="two-columns" class="grid-container" style="display:none;">
                        <button type="button" id="button_row" class="btn-xs btn-success">Add</button>
                        <button type="button" id="copythisorder" class="btn-xs btn-primary" style="">Copy Order</button>
                        <button type="button" id="excelexportorder" class="btn-xs btn-primary" style="">Export To Excel</button>
                        <button type="button" id="pdfexportorder" class="btn-xs btn-primary" style="">Export To PDF</button>

                        <button type="button" id="edit_row" class="btn-xs btn-success">Edit</button>

                        <input type="checkbox" id="checkboxDescription" style="display:none;" >
                        <input type="checkbox" id="checkboxCode" style="display:none;" >
                        <input type="text" id="customeronhold" style="color:red;font-weight:900;width: 40%;text-align: center;border: 0px;" readonly>
                        <button class="btn-danger pull-right" id="deleteAllLines">Delete All Lines</button>
                        <input type="text" class=" pull-right" id="customerpricelist" style="font-weight: 900;border: 0px;">
                        @if($userActions !=0)
                            <button type="button" id="button_user_actions" class="btn-xs btn-info pull-right">User Actions</button>
                        @endif

                        <table id="table" class="table table-bordered table-condensed" style="font-family: sans-serif;color:black">
                            <thead>
                            <tr>
                                <th class="<?php  echo env('PRODUCT_CODE_LENGTH'); ?>">Code</th>
                                <th class="col-md-4">Description</th>
                                <th style=""  >Bulk</th>
                                <th class="col-md-1">Qty</th>
                                <th class="col-md-1">Price</th>
                                <th class="col-md-1">Disc% L.Tot</th>
                                <th  >UOM</th>
                                <th >In Stk<i style="color:red;float:right">W Stk</i></th>
                                <th  >C Stk</th>
                                <th  >Addt.Cst</th>
                                <th class="col-md-3">Comment</th>
                                <th class="col-md-1 table-header">Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div><h6 id="numberOfLines" style=" margin-bottom: 0px !important;" class="hidebody">0 Lines  </h6>
                <div class="col-md-5 pull-right hidebody" style="line-height: 1.1;">
                    Special Notification<br>
                    <select id="notification">
                        <option value="2">Normal</option>
                        <option value="1">Low</option>
                        <option value="3">High</option>
                    </select>
                    <h5 id="availableOnTheFly" > </h5>
                    <input type="hidden" id="instockGlobal" >
                    <legend class="well-legend">Line Extra Info</legend>
                    <table class="table table-condensed-footer" style="color:red;    font-size: 9px;">
                        <tr>
                            <td>L.Margin</td>
                            <td><input id="linemargins" style="font-size:15px;height: 22px;" ></td>
                            <td>L.Total (Exc)</td>
                            <td><input id="linetotalex" style="font-size:15px;height: 22px;"></td>
                            <td>L.Total (Inc)</td>
                            <td><input id="linetotalInc" style="font-size:15px;height: 22px;"></td>
                        </tr>

                    </table>
                    <legend class="well-legend">Totals</legend>
                    <label>Add.Cst:</label><input id="totaddidtionalcst" style="font-size:18px;height: 32px;font-family: sans-serif;" >

                    <fieldset class="well">
                        <legend class="well-legend">Totals</legend>
                        <table class="table table-condensed-footer">
                            <tr style="height: 32px;">
                                <td>Exc</td>
                                <td><input id="totalEx" style="font-size:18px;height: 32px;" ></td>
                                <td>Inc</td>
                                <td><input id="totalInc" style="font-size:18px;height: 32px;"></td>
                            </tr>

                        </table>
                    </fieldset>
                    <fieldset class="well">
                        <legend class="well-legend">Order Disc Totals</legend>
                        <table class="table table-condensed-footer">
                            <tr>
                                <td>Tot(Inc)</td>
                                <td><input id="totalInOrder" ></td>
                            </tr>
                        </table>
                    </fieldset>

                    <div style="color:black;font-weight: 900;">Total Margin %<input type="text" id="totalmargin" class="form-control input-xs col-xs-1"  readonly style="height:13px"></div>
                    <div style="color:black;font-weight: 900;">Discount %<input type="text" id="dicPercHeader" class="form-control input-xs col-xs-1" onkeypress="return isFloatNumber(this,event)" readonly style="height:13px"></div>
                    @if($printinvoices !="0")
                        <button id="invoiceNow" name="invoiceNow" class="btn-xs btn-danger" style=" width: 115px;">Print</button>
                    @endif

                    <button id="reprintInvoice" name="reprintInvoice" class="btn-xs btn-success" style=" width: 115px;">Re-Print</button>
                    <div class="col-md-12" style="padding:0px;margin-top: 1%;">
                        <p id="creditLimitWarningMessage" style="color:red;font-family: monospace;    font-size: 12px;">

                            <input type="hidden" name="creditLimitApproved" id="creditLimitApproved" value="">
                            <input type="hidden" name="creditLimitStutusMesg" id="creditLimitStutusMesg" value="">
                            <input type="text" name="boozeLisence" id="boozeLisence" class="form-control input-sm col-xs-1" value="" style="height:13px" readonly>

                            <input type="hidden" name="boozeChecked" id="boozeChecked" class="form-control input-sm col-xs-1" value="">
                    </div>
                    <input type="checkbox" name="awaitingStock" id="awaitingStock" value="">Awaiting Stock<br>
                    <input type="checkbox" name="treatAsQuote" id="treatAsQuote" >Treat As Quotation<br>


                    <div >
                        <fieldset class="well">
                            <legend class="well-legend">Contact Details</legend>
                            <table class="table" style="font-size: 10px;font-weight: 900;color: black;">
                                <tr>
                                    <td>Contact Cell</td>
                                    <td><input id="contactCellOnDispatch" class="form-control input-sm col-xs-1"></td>
                                </tr>
                                <tr>
                                    <td>Buyer</td>
                                    <td><input id="contactPersonOnDispatch" class="form-control input-sm col-xs-1"></td>
                                </tr>
                                <tr>
                                    <td>Buyer Tel/Cell</td>
                                    <td><input id="telOnDispatch" class="form-control input-sm col-xs-1"></td>
                                </tr>
                            </table>
                            <button class="btn-success btn-sm" id="updatecontactsontheorder">Update Contacts</button>
                        </fieldset>
                    </div>

                    <h5 id="nbNotes" style="color:red;"></h5>
                </div>
                <div class="col-md-4 hidebody" style="line-height: 1.1;padding-left: 0px;">
                    <div class="form-group hidebody"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="messagebox"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Message</label>
                        <input type="text" name="message" id="messagebox" class="form-control input-sm col-xs-1" value="" >
                    </div>
                    <div class=" col-md-12"    style="padding-left: 0px;">
                        <label class="control-label" for="orederNumber"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Number</label><br>
                        <input type="text" name="orederNumber"  class="form-control input-sm col-xs-1"  id="orederNumber" maxlength="25" style="font-weight: 900;color: black;" autocomplete="new-password" value="." readonly><span id="characters"></span>/25
                        <button id="advancedorderNumber">Advanced Order No</button>
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
                            <textarea id="customerSelectedDelDate" style="height: 52px;width:100%;font-size: x-small;color: black;font-weight: 700;background: #e4e0e0;" readonly></textarea>
                            <i style="font-size: 11px;font-weight: 700;color: black;" id="tempDelivAddressClosethis">Press <button id="tempDelivAddress">here</button> to create a temp delivery address </i>
                            <button class="btn-md btn-warning" id="changeDeliveryAddressOnNotInvoiced">Change Delivery Address</button>
                        </div>
                        <button class="btn-xs btn-success " id="addTheSalesMan" type="button" >Salesman</button><br>
                        On Hold : <input type="checkbox"  id="authoriseblockedorder"> <input type="hidden"  id="marginandpriceauthbycustomer"><br>
                    </div>

                </div>
                <button type="button" id="finishOrder" class="btn-xs btn-primary hidebody" style=" width: 115px;">Finish</button>


                <div class="col-md-12 " style="margin-top: 7px;" >

                    <button type="button" id="printPDFPickIndOrder" class="btn-xs btn-warning " style=" width: 115px;display:none">Print Picking Slip</button>
                    <button type="button" id="abilityToEmailOrder" class="btn-xs btn-warning " style=" width: 115px;">Email Order</button>
                    <button type="button" id="copyThisOrder" class="btn-xs btn-warning " style=" width: 115px;display:none">Copy Order</button>
                    <button type="button" id="printDocument" class="btn-xs btn-primary " style=" width: 115px;display:none;">Print</button>
                </div>
            </div>

            <div class="col-md-4 hidebody">
                <div  class="col-md-12" style="background: #999;height:50px">
                    <form>
                        <div class="form-group col-md-3">
                            <label class="control-label" for="codeSearch"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                            <input type="button" id="routeonabutton" class="btn-md btn-primary" value="TEST LONG ROUTE IF ">

                            <select class="form-control input-sm col-xs-1" name="routeName" id="routeName" style="font-weight: 900;height:25px;font-size: 10px;color: black;display:none;">
                            </select>

                        </div>
                        <div class="form-group col-md-3" id="deprecated_cangeDate">
                            <label class="control-label" for="descriptionSearch"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delv Date</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="changeDelvDate" style="height:25px;font-size: 10px;">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label" for="creditLimit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">CR Limit</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="creditLimit" style="    font-weight: 900;color: black;height:25px;font-size: 9px;display: inline;width: 70px;font-family: sans-serif;" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label" for="balDue"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">BalDue</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="balDue" style="    font-weight: 900;color: black;height:25px;font-size: 10px;display: inline;width: 78px;font-family: sans-serif;" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label" for="balDue"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">WH</label>
                            <select id="headerWh">

                            </select>
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
                                    <label for="tab2">Specials</label>
                                    <input type="radio" name="tab" id="tab3">
                                    <label for="tab3">Invoices</label>
                                    <input type="radio" name="tab" id="tab4">
                                     <label for="tab4">On Order</label>


                                    <div class="tab" style="overflow-y: scroll;height:56%">
                                        <div style="display: block !important;">
                                            <table class="table search-table" id="orderPatternIdTable" style="overflow-y: scroll; width: 100%;font-family: sans-serif;!important; ">
                                                <thead>

                                                <tr >
                                                    <th class="col-md-8" >Description</th>
                                                    <th class="col-xs-1">2Week</th>
                                                    <th class="col-xs-1">Avg</th>
                                                    <th class="col-xs-1">InStk</th>
                                                    <th  style="width:2px;font-size:5px;">C</th>
                                                    <th class="col-xs-1" >T</th>
                                                    <th class="col-xs-1 " >Auth</th>
                                                    <th class="col-xs-1 " >Code</th>
                                                    <th class="col-xs-1 " >P</th>
                                                    <th class="col-xs-1 " >Tx</th>
                                                    <th class="col-xs-1 " >U</th>
                                                    <th class="col-xs-1 " >U.W</th>
                                                    <th class="col-xs-1 " >S.B.W</th>
                                                    <th class="col-xs-1 " >B.U</th>
                                                    <th class="col-xs-1 " >Mgn</th>
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
                                                    <th>UOM</th>
                                                    <th></th>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-lg-12 " style="height: 46%;overflow-y:auto;background: lightcyan;padding: 0px;">
                                            <h5>Group Special Pricing</h5>
                                            <table id="groupSpecials" class="table" style=" width: 100%;font-family: sans-serif;">

                                                <tr style="font-size: 10px;" >
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

                                    <div class="tab col-lg-12" >
                                        <div id="gridbackorders" style="max-width: 100% !important"/>
                                    </div>

                                </div></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="dialog" title="Order Listing" style="background: #0ba7b8c4;">
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
            <div class="col-lg-12" style="min-height: 59px;">
                <table class="table2 table-bordered " id="createdOrders" style="overflow-y: auto;width:100%;color: black;    font-weight: 700;" tabindex=0>
                    <thead>
                    <tr>
                        <th class="col-sm-1">OrderId</th><th class="col-sm-1">Invoice no</th><th class="col-sm-1">Cust Code</th><th>Cust Name</th><th class="col-sm-1">Order Types</th><th class="col-sm-1">Route</th><th class="col-sm-1">Delivery Date</th><th>Order Date</th><th>Reference No</th><th>Created By</th><th>Total Inv</th><th>Terms</th> <th>Bal.Due</th><th>GP(%)</th></tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>OrderId</th><th >Invoice no</th><th >Cust Code</th><th>Cust Name</th><th>Order Types</th><th>Route</th><th>Delivery Date</th><th>Order Date</th><th>Reference No</th><th>Created By</th><th>Total Inc</th><th>Terms</th> <th>Bal.Due</th><th>GP(%)</th></tr>
                    </tfoot>

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
                <div class="col-lg-12">
                    <table class="table" id="priceCheckingOnCall" style="width:100%">
                        <thead>
                        <tr>
                            <th>Price List</th><th>Price</th><th>Price Inc</th></tr>
                        </thead>

                    </table>
                </div>
                <div class="col-lg-12">
                    <div style="width: 50%;float: right;background: darkseagreen;">
                        <table class="table" id="appendQtyOnHand">

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="callListDialog" title="Call List">
            <div class="col-lg-12" style="background: #f3b9c3">
                <form>
                    <div class="form-group col-md-3">
                        <label class="control-label" for="callListOrderDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Date</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="callListOrderDate" scustomeronholdtyle="font-size: 10px;">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label" for="callListDeliveryDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                        @if(count($callistDelvDate) > 0 )
                            <input type="text" class="form-control input-sm col-xs-1" id="callListDeliveryDate" value="{{$callistDelvDate[0]->dteSessionDate}}" style="font-size: 10px;">
                        @else
                            <input type="text" class="form-control input-sm col-xs-1" id="callListDeliveryDate" style="font-size: 10px;">
                        @endif

                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label" for="callListUser"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">User</label>
                        <select class="form-control input-sm col-xs-1" name="callListUser"  id="callListUser"  >
                            <option value="{{Auth::user()->UserID}}" >{{Auth::user()->UserName}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label" for="routeToFilterWith"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                        <select class="form-control input-sm col-xs-1"   name="routeToFilterWith" id="routeToFilterWith">
                            @foreach($callistCurrentRoute as $value)
                                <option value="{{$value->Routeid}}">{{$value->Route}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" id="passCallistFilter" class="btn-lg btn-success">Press Go!</button>
                </form>
                <div class="col-lg-12" style="height:500px; overflow-y:scroll;">
                    <table class="table2 table-bordered" id="callListTable" style="overflow-y: auto;width:100%" tabindex=0>
                        <thead>
                        <tr>
                            <th>Code</th><th>Description</th><th>Call</th>
                            <th>Account Contact</th><th>Buyer Tel</th><th>Buyer Cell</th><th>Route</th>
                            <th>Buyer </th>
                            <th>Address</th>
                            <th>Notes</th>
                        </tr>
                        </thead>

                    </table>
                </div>


            </div>
            <a href='{!!url("/getphonebook")!!}' clas="btn-md bnt-primary pull-right" style="color:black;font-weight:900;text-decoration: underline; padding: 3px;"   onclick="window.open(this.href, 'getphonebook','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Phone Book</a>
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
                        <select id="generalRouteForNewDeliveryAddress" class="form-control input-sm col-xs-1 generalRouteForNewDeliveryAddress">
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
                    <button type="button" id="doneCustomAddress" class="btn-success doneCustomAddress">Done</button>

                </div>
                <div class="col-lg-8" >
                    <input type='text' id='txtList' onkeyup="filter(this)" class="form-control"   placeholder="Please search address here..."/>
                    <hr style="margin-top: 15px;margin-bottom: 15px;border: 0;border-top: 5px solid #00ff00;"/>
                    <div >
                        <ul id="listaddresses" style="font-size: 9px;list-style-type: none;overflow-y: auto;height:300px"></ul>
                    </div>

                </div>
                <div  class="col-lg-12" id="dynamicaddress" style="background: #f8f8f8;">
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
                <table class="table" id="customersellingPrice" style="width:100%">
                    <thead>
                    <tr>
                        <th>Price</th><th>Delv Date</th></tr>
                    </thead>
                </table>
                <hr><h5>Other Prices</h5>
                <table class="table" id="customerDetailLookUp" style="width:100%">
                    <thead>
                    <tr>
                        <th>Price List</th><th>Price</th></tr>
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
        <div id="authDropDownsClosedRoutePass" title="Please Authorise" style="background:rgba(0,0,255,0.31)">
            <h4  style="color:red">The Route You Are Trying to Place this Order Is Currently Closed Please Authorise First. </h4>

            <form>
                <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="userAuthClosedRoute"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
                    <input class="form-control input-sm col-md-4 auto-complete-off" name="userAuthClosedRoute" id="userAuthClosedRoute" style="height:30px;font-size: 10px;"></input>
                </div>
                <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="userAuthClosedRoutePass"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
                    <input type="password" name="userAuthClosedRoutePass" class="form-control input-sm col-md-4 auto-complete-off" id="userAuthClosedRoutePass" style="height:30px;font-size: 10px;"  onfocus="$(this).removeAttr('readonly');" >
                </div>

                <button type="button" id="doAuthDropDownClosedRoutePass" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Authorise</button>
                <button type="button" id="doCancelAuthDropDownClosedRoutePass" class="btn-warning btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Cancel</button>
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
                                <input type="hidden" class="form-control input-sm col-xs-1" id="prodId">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group col-md-4">
                                <label class="control-label" for="custCodePl" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Code</label>
                                <input type="text" class="form-control input-sm col-xs-1" id="custCodePl" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label" for="custDescPl"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Desc</label>
                                <input type="text" class="form-control input-sm col-xs-1" id="custDescPl" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                                <input type="hidden" class="form-control input-sm col-xs-1" id="custId">
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
                <div class="col-md-6">
                    <table class="table" id="priceCheckByCustomer" style="width:100%">
                        <thead>
                        <tr>
                            <th>Price List</th><th>Price</th><th>Price Inc</th></tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table" id="currentCustomerPrices" style="width:100%">
                        <thead>
                        <tr>
                            <th>Product ID</th><th>Price Type</th><th>Price</th></tr>
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
                    <th>Address 1 </th><th>Address 2</th>
                    <th>Address 3 </th><th>Address 4</th>
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
                @foreach($salesmen as $value)
                    <option value="{{$value->strSalesmanCode}}">{{$value->UserName}}</option>
                @endforeach
            </select>
            <br>
            <div>
                <fieldset>
                    <legend>This require authorization.  </legend>
                    <div>
                        <label>UserName</label><br>
                        <input id="authsalesmanusername" class="form-control input-sm col-md-4 auto-complete-off">
                    </div>
                    <div>
                        <label>Password</label><br>
                        <input type="password" id="authsalesmanpassword" class="form-control input-sm col-md-4 auto-complete-off">
                    </div>
                </fieldset>

            </div>
            <button id="submitsalesman" class="btn-md btn-success">Submit</button>
        </div>
        <div id="routingdialog" title="Choose Route" style="background: #ffa65d;">
            <label>Route</label><br>

            <select id="changetcurrentrouteonorder">
                @foreach($routesNames as $value)
                    <option value="{{$value->Routeid}}">{{$value->Route}}</option>
                @endforeach
            </select>
            <br>
            <p>BY CLICKING SUBMIT YOU ARE AUTHORISING THE ROUTE CHANGE ON THIS ORDER</p>
            <button id="auththisrouteontheorder" class="btn-md btn-success">Submit</button>
        </div>

        <div id="brandedorderno" title="Order Numbers" style="background: #ffa65d;">
            <label>Route</label><br>
            <table class="table2" id="tableorderno">
                <thead>
                <tr>
                    <th class="col-md-1">Brand Id</th>
                    <th class="col-md-2">Brand</th>
                    <th class="col-md-5">Order Number</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <button id="submitorderno" class="btn-md btn-success pull-right">Submit</button>
        </div>
        <div id="splitOrder" title="Split Order" >
            <div class="col-md-12">
                <table id="tblSplitOrder" class="table2 table-bordered">
                    <thead>
                    <tr>
                        <th class="col-md-1">Code</th>
                        <th class="col-md-3">Description</th>
                        <th >Ordered</th>
                        <th >Available</th>
                        <th >On Hand</th>
                        <th >Back</th>
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
                <div class="col-md-6"><button id="yestosplit" class="btn-md btn-success" style="width: 70px;">Yes</button></div>
                <div class="col-md-6"><button id="notosplit" class="btn-md btn-danger" style="width: 70px;">No</button></div>
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
                    <label class="control-label" for="userAuthProhibitedCred"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
                    <input class="form-control col-md-4 auto-complete-off" id="userAuthProhibitedCred_marg" name="userAuthProhibitedCred"  style="height:30px;font-size: 10px;"  autocomplete="off"></input>
                </div>
                <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="userAuthPassWordCredit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
                    <input type="password" name="userAuthPassWordCredit" class="form-control col-md-4 auto-complete-off" id="userAuthPassWordCredit_marg" style="height:30px;font-size: 10px;"   autocomplete="off">
                </div>

                <div class="form-group  col-md-12" >
                    <div class="form-group  col-md-6" >
                        <button type="button" id="doAuthCredits" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Authorise</button>
                    </div>
                    <div class="form-group  col-md-6" >
                        <button type="button" id="doCancelAuthCredits" class="btn-danger btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="ZeroPrice" title="Please Authorise">
            <h5>The product has zero(0) price ,please authorise. </h5>
            <form>
                <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="userauthproductwithzeroprice"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
                    <input class="form-control col-md-4 auto-complete-off" id="userauthproductwithzeroprice" name="userauthproductwithzeroprice"  style="height:30px;font-size: 10px;"  autocomplete="off"></input>
                </div>
                <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="userAuthPassWordzeroprice"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
                    <input type="password" name="userAuthPassWordzeroprice" class="form-control col-md-4 auto-complete-off" id="userAuthPassWordzeroprice" style="height:30px;font-size: 10px;"   autocomplete="off">
                </div>

                <div class="form-group  col-md-12" >
                    <div class="form-group  col-md-6" >
                        <button type="button" id="doAuthZeroPrice" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Authorise</button>
                    </div>
                    <div class="form-group  col-md-6" >
                        <button type="button" id="doCancelAuthZeroPrice" class="btn-danger btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Re-do Line</button>
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
                    <label class="control-label" for="onholdaccountmanagername"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label><br>
                    <input class="" id="onholdaccountmanagername" name="onholdaccountmanagername"  style="height:30px;font-size: 10px;"  autocomplete="off" value="-"></input>
                </div>
                <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="onholdaccountmanagerpassword"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label><br>
                    <input type="password" name="onholdaccountmanagerpassword" class="" id="onholdaccountmanagerpassword" style="height:30px;font-size: 10px;"   autocomplete="off" value="-">
                </div><br>
                <div  >
                    <button type="button" id="doAuthZeroonholdaccount" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Authorise</button>
                </div>
                <div class="form-group  col-md-12" >

                    <div  >
                        <fieldset>
                            <legend>NB :THIS ORDER WILL NOT GO FOR PICKING UNTIL AUTHORISATION.</legend>
                            <button type="button" id="treattheauthaccountasquotation" class="btn-danger btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;display:none;">Notify Managers And Continue</button>
                        </fieldset>
                    </div>
                </div>
            </form>

        </div>
        <div title="Additional Cost" id="addcostdialog">
            <table class="table2 table-bordered" id="additionalcost">
                <thead>
                <tr>
                    <th>Item Code</th><th>Item Description</th><th>QTY</th><th>Price</th><th>Total</th>
                </tr>
                </thead>
            </table>

        </div>
        <div title="ITEMS WITH ZERO COST" id="authItemsWithzerocosts">
            <h2>PLEASE AUTHORIZE ITEMS WITH ZERO COST</h2>
            <form>
                <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="zerocostmanagername"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label><br>
                    <input class="" id="zerocostmanagername" name="zerocostmanagername"  style="height:30px;font-size: 10px;"  autocomplete="off" value="-"></input>
                </div>
                <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="zerocostmanagerpassword"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label><br>
                    <input type="password" name="zerocostmanagerpassword" class="" id="zerocostmanagerpassword" style="height:30px;font-size: 10px;"   autocomplete="off" value="-">
                </div><br>
                <div  >
                    <button type="button" id="doAuthZerocost" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Authorise</button>
                </div>
                <div class="form-group  col-md-12" >
                    <table>
                        <tbody id="productwithzerocost">

                        </tbody>
                    </table>

                    <button type="button" id="cancelzerocostdialod" class="btn-danger btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Cancel</button>

                </div>
            </form>

        </div>

        <div title="Item having less stock" id="itemoutofstock">
            <h2>These lines exceeds the available qty.</h2>
            <form>

                <div class="form-group  col-md-12" >
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

                    <button type="button" id="cancelsplitorder" class="btn-danger btn-xs pull-left" style="margin-top: 29px;margin-right: 15px;">Cancel</button>
                    <button type="button" id="splitorder" class="btn-danger btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">SPILT </button>

                </div>
            </form>

        </div>

        <div title="Zero Pricing" id="itemseithzeropricing">
            <h2>These lines have zero pricing, please authorize.</h2>
            <form>

                <div class="form-group  col-md-12" >
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
                        <label class="control-label" for="zeropricingname"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label><br>
                        <input class="" id="zeropricingname" name="zeropricingname"  style="height:30px;font-size: 10px;"  autocomplete="off" value="-"/>
                    </div>
                    <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="zeropricingpassword"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label><br>
                        <input type="password" name="zeropricingpassword" class="" id="zeropricingpassword" style="height:30px;font-size: 10px;"   autocomplete="off" value="-">
                    </div><br>
                    <div>
                        <button type="button" id="doAuthzeropricing" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Authorise</button>
                    </div>

                </div>
            </form>
:
        </div>



        @include('dims.on_order')
        @include('dims.oninvoiced')

        @endsection
        <style>
            .hide-close-btn .ui-dialog-titlebar-close{
                display: none;
            }
            .ui-dialog-titlebar-close{
                display: none;
            }
            .custom-font {
                font-family: "Arial", sans-serif;
                font-size: 10px !important;
                font-weight: 900 !important;
            }
            .dx-datagrid {
                font-size: 11px; /* Change the font size to the desired size */
            }
            .bulkitemcolor{
                background: #0BA008;
            }
        </style>

        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>

        <script>

            $( document ).on( 'focus', ':input', function(){

                $( this ).attr( 'autocomplete', 'off' );
            });
            $( document ).on( 'focus', ':input', function(){

                $( this ).attr( 'autocomplete', 'this-is-it' );
            });

            $(document).keydown(function(e) {
                if (e.keyCode == 27) return false;
            });

            window.onstorage = event => { // same as window.addEventListener('storage', event => {
                if (event.key == 'onorders') {
                    console.debug(event.key + ':' + event.newValue + " at " + event.url);
                    let products = JSON.parse(event.newValue);
                    console.debug(products);
                    if(products.passedorderid !=null ){

                        if( $('#orderId').val().length < 3){
                            $('#orderId').val(products.passedorderid );
                            $("#checkOrders").click();
                        }else{
                            localStorage.removeItem('openorder');
                            localStorage.setItem('openorder', JSON.stringify({openorderid:  $('#orderId').val() }));
                        }



                    }


                }
                //console.debug(event.key + ':' + event.newValue + " at " + event.url);
            };
            //var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);

            //alert("isChrome"+isChrome);
            //element.autocomplete = isChrome ? 'disabled' :  'off';
            var ismulti = false;
            var reportmarginControl = 'marginType1';
            var booze = '';
            var spool = 0;
            var productSetting = '';
            var finalDataProduct = '';
            var finalDataProductTest = '';
            var wareautocomplete = '';
            var arrayProdCodesCheck = [];
            var arrayProds = [];
            var globalOrderIdToBePushed = [];
            var arrayOfCustomerInfo = [];
            var accounting = "<?php echo config('app.Accounting') ?>";
            var donotshowAvailable = "<?php echo config('app.donotshowAvailable') ?>";
            var CompanyMarginApp = "<?php echo config('app.Margin') ?>";
            var CompanyMargin = "<?php echo config('app.Margin') ?>";
            var isAllowedToChangeInv = "<?php  echo Auth::user()->authInvoices; ?>";
            var isAuthMyLine = "<?php  echo env('APP_AUTHLINE'); ?>";
            var isAuthPrice = "<?php  echo env('APP_AUTH_PRICE'); ?>";
            var hassplitorder = "<?php  echo env('SPLITORDER'); ?>";
            var authzerocost = "<?php  echo env('AUTHZEROCOST'); ?>";
            var isBlockRouteChanges = "<?php  echo env('APP_ROUTECHANGES'); ?>";
            var searchstring = "<?php  echo env('STRING_LENGTH'); ?>";
            var isBlockDeliveryTypeChanges = "<?php  echo env('APP_DELIVERYTYPE'); ?>";
            var hasBasketAuth = "<?php  echo env('APP_BASKET_MARGIN'); ?>";
            var multiLines = "<?php  echo Auth::user()->intAllowMultiLines?>";
            var linediscount = "<?php  echo $discountProperty; ?>";
            // console.debug("isAuthMyLine*******"+isAuthMyLine);
            // console.debug("isBlockRouteChanges*******"+isBlockRouteChanges);
            //

            reportmarginControl = JSON.stringify({!! json_encode($margin) !!});
            reportmarginControl = JSON.parse(reportmarginControl);
            // console.debug(reportmarginControl);
            var jArray = JSON.stringify({!! json_encode($products) !!});
            var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
            var jArrayCustomerAll = JSON.stringify({!! json_encode($customersDontcareStatus) !!});
            var jArrayOrderTypes = JSON.stringify({!! json_encode($orderTypes) !!});
            var jArrayLastInserted = JSON.stringify({!! json_encode($LastInserted) !!});
            var jArraydelivDates = JSON.stringify({!! json_encode($delivDates) !!});
            var jArraydelivRoutes = JSON.stringify({!! json_encode($routesNames) !!});
            var jArraytrueOrFalse = JSON.stringify({!! json_encode($trueOrFalse) !!});
            var warehouses = JSON.stringify({!! json_encode($warehouses) !!});

            // console.debug(jArrayCustomer);
            // var computerName = '<?php echo gethostname() ?>';
            var computerName = '<?php echo php_uname('n'); ?>';
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
            var dataMenuOnRightClickOnOrder = [
                [
                    {
                        text: "Choose Option",
                        action: function () {

                        }
                    },{
                    text: "Open In New Tab",
                    action: function () {
                        window.open('{!!url("/getOnOrder")!!}');
                    }
                },{
                    text: "Open In Dialog Mode",
                    action: function () {
                        window.open('{!!url("/getOnOrder")!!}', "getOnOrder-Dialog", "location=1,status=1,scrollbars=1, width=1200,height=850");

                    }
                }]
            ];
            $(document).ready(function() {

                $(document).on('click', '#orederNumber', function(e) {
                    e.preventDefault();
                    $("#orederNumber").prop("disabled", false);
                    $("#orederNumber").removeAttr('disabled');
                });
                $('#orederNumber').click(function(){


                    $("#orederNumber").removeAttr('readonly');
                });

                $(function() {
                    var pressed = false;
                    var start = undefined;
                    var startX, startWidth;

                    $("table th").mousedown(function(e) {
                        start = $(this);
                        pressed = true;
                        startX = e.pageX;
                        startWidth = $(this).width();
                        $(start).addClass("resizing");
                    });

                    $(document).mousemove(function(e) {
                        if(pressed) {
                            $(start).width(startWidth+(e.pageX-startX));
                        }
                    });

                    $(document).mouseup(function() {
                        if(pressed) {
                            $(start).removeClass("resizing");
                            pressed = false;
                        }
                    });
                });
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
                $('#treatAsQuote').change(function() {
                    if($('#treatAsQuote').is(':checked')) {
                        treatAsQuote(1);
                    }else
                    {
                        alert("NOT A QUOTATION ANYMORE");
                        treatAsQuote(0);
                    }
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
                //  $('#routeToFilterWith').append(toAppendRoutes);
                $('#rouTabletLoadingtes').append(toAppendRoutes);
                $('#AddressAddSelect').append(toAppendRoutes);
                $('#assignRouteOnTheFlyDropDown').append(toAppendRoutes);
//,'PurchOrder','UnitWeight','SoldByWeight','strBulkUnit'
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
                        UnitWeight: item.UnitWeight,
                        SoldByWeight: item.SoldByWeight,
                        strBulkUnit: item.strBulkUnit,
                        Available: parseFloat(item.Available).toFixed(2),
                        ProductId:item.ProductId
                    }

                });
                wareautocomplete = $.map(JSON.parse(warehouses), function (item) {
                    return {
                        ID: item.ID,
                        Warehouse: item.Warehouse

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
                        UnitWeight: item.UnitWeight,
                        SoldByWeight: item.SoldByWeight,
                        strBulkUnit: item.strBulkUnit,
                        Available: parseFloat(item.Available).toFixed(2),
                        ProductId:item.ProductId
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
                        strRoute:item.strRoute,
                        mnyCustomerGp:item.mnyCustomerGp,
                        Warehouse:item.Warehouse,
                        ID:item.ID,
                        CustomerOnHold:item.CustomerOnHold,
                        termsAndList:item.termsAndList
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
                        strRoute:item.strRoute,
                        mnyCustomerGp:item.mnyCustomerGp,
                        Warehouse:item.Warehouse,
                        ID:item.ID,
                        CustomerOnHold:item.CustomerOnHold,
                        termsAndList:item.termsAndList
                    }

                });

                //console.debug(getCustomers);
                $('body').tipPop({
                    type: 'all' // listen on focus and hover events, it's default value
                });
                /* $('#table').sortable({
            containerSelector: 'table',
            itemPath: '> tbody',
            itemSelector: 'tr',
            placeholder: '<tr class="placeholder"/>'
        });*/

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
                $('#extrasononrder').hide();
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
                $('#prodonInvoice').hide();
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
                $('#popLessStock').hide();
                $('#popZeroStock').hide();
                $('#edit_row').hide();
                $('#authDropDownsClosedRoutePass').hide();//authFinishOrder
                $('#createOrderOnCallList').hide();
                $('#copyOrdersBtn').hide();
                $('#emailDoc').hide();
                $('#salesmandialog').hide();
                $('#routingdialog').hide();
                $('#brandedorderno').hide();
                $('#splitOrder').hide();
                $('#exceeded').hide();
                $('#qtyzero').hide();
                $('#MarginProblems').hide();
                $('#processingpos').hide();
                $('#generaldialog').hide();
                $('#deleteAllLines').hide();
                $('#checkdeliverydate').hide();
                $('#ZeroPrice').hide();
                $('#authonholdaccount').hide();
                $('#addcostdialog').hide();
                $('#authItemsWithzerocosts').hide();
                $('#itemoutofstock').hide();
                $('#itemseithzeropricing').hide();


                if(isBlockDeliveryTypeChanges.length > 4) {
                    $("#orderType").prop('disabled', 'disabled');
                }




                var otable = ''; // Order Listing Table
                var productsOnOrders = ''; // products On Order

                var callListTable2 = ''; //Call List Table
                //test

                $('#salesQuotebtn').click(function () {
                    window.open('{!!url("/salesquote")!!}');
                });
                $('#copythisorder').click(function () {
                    window.open('{!!url("/copyorder")!!}/'+$('#orderId').val(),"copyorder", "location=1,status=1,scrollbars=1, width=1200,height=850");

                });

                $('#returns').click(function () {
                    window.open('{!!url("/salesquote")!!}');
                });
                $('#reports').click(function () {
                    window.open('{!!url("/reports")!!}');
                });
                $('#routePlanning').click(function () {
                    window.open('{!!url("/routeplanner")!!}');
                });

                //

                $('#callList').click(function () {
                    //callList();

                    getDimsUsers('#callListUser', '{!!url("/getDimsUsers")!!}');
                    $('#callListDialog').show();

                    $("#callListDialog").dialog({
                        height: 700.4,
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

                $('#passCallistFilter').click(function () {
                    callList();
                });
                $("#callList").contextMenu(dataMenuOnRightClick);
                $("#salesOnOrder").contextMenu(dataMenuOnRightClickOnOrder);
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
                 * TABLET LOADING APP
                 * */
                $('#tabletLoadingApp').click(function () {
                    //url,ConsoleTypeId,Importance,Message,Reviewed,OrderId,productid,
                    // CustomerId,OldQty,NewQty,OldPrice,NewPrice,ReviewedUserId,ReferenceNo,DocType,DocNumber,machine,ReturnId
                    consoleManagement('{!!url("/logMessageAjax")!!}', 300, 2, 'Dims Tablet Loading button Clicked', 0, 0, 0, 0, 0, 0, 0, 0, 'NULL', 0, computerName, 0, 0);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    $('#tabletLoadingGo').click(function () {
                        reprintList();
                    });

                    $('#tabletLoading').show();
                    $("#tabletLoading").dialog({
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
                });

                /**
                 * List Top 1000 orders and order them  by date in desc
                 * */
                $('#orderListing').click(function () {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
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
                            {"data": "OrderId", "class": "small", "bSortable": true},
                            {"data": "InvoiceNo", "class": "small"},
                            {"data": "CustomerPastelCode", "class": "small"},
                            {"data": "StoreName", "class": "small"},
                            {"data": "LateOrder", "class": "small"},
                            {"data": "Route", "class": "small"},
                            {"data": "DeliveryDate", "class": "small"},
                            {"data": "OrderDate", "class": "small"},
                            {"data": "OrderNo", "class": "small"},
                            {"data": "UserName", "class": "small"},
                            {"data": "inclusives", "class": "small"},
                            {"data": "Terms", "class": "small"},
                            {"data": "BalanceDue", "class": "small"},
                            {"data": "GPperc", "class": "small", render:function(data, type, row, meta) {
                                    // check to see if this is JSON
                                    try {
                                        var jsn = JSON.parse(data);
                                        //console.log(" parsing json" + jsn);
                                    } catch (e) {

                                        return jsn.data;
                                    }
                                    return parseFloat(jsn).toFixed(2);

                                }}

                        ],
                        "order": [[ 0, "desc" ]],
                        "deferRender": true,
                        "scrollY": "370px",
                        "scrollCollapse": true,
                        searching: true,
                        bPaginate: false,
                        bFilter: false,
                        "LengthChange": true,
                        "info": false,
                        "ordering": true,
                        "initComplete": function () {
                            this.api().columns().every( function () {
                                var column = this;
                                var select = $('<select><option value=""></option></select>')
                                    .appendTo( $(column.footer()).empty() )
                                    .on( 'change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                        );

                                        column
                                            .search( val ? '^'+val+'$' : '', true, false )
                                            .draw();
                                    } );

                                column.data().unique().sort().each( function ( d, j ) {
                                    select.append( '<option value="'+d+'">'+d+'</option>' )
                                } );
                            } );
                        },
                        "bDestroy": true
                    });

                    $('#createdOrders tbody').on('dblclick', 'tr', function () {
                        var data = otable.row(this).data();
                        $("#evil").dialog( "close" );
                        console.debug(data.StoreName);
                        if ($('#orderId').val().length > 0) {
                            alert('There is Currently an order Opened Please Close it !');
                        }
                        else {

                            $('<div id="evil" style="z-index: 60000 !important;"></div>')
                                .html('<div ><h6><a href={!!url("/pdforder")!!}/'+ data.OrderId+' target="blank">View PDF ('+data.StoreName + ' - ' + data.OrderId + ' )</a><br><a href={!!url("/PDFDelDate")!!}/'+ data.OrderId+' target="blank" style="background: #43bbc8;text-decoration: underline;">DELIVERY NOTE ('+data.StoreName + ' - ' + data.OrderId + ' )</a><br><a href={!!url("/exportorder")!!}/'+ data.OrderId+'  style="text-decoration: underline;">EXCEL Order('+data.StoreName + ' - ' + data.OrderId + ' )</a><br></h6></div>')
                                .dialog({

                                    modal: true,
                                    title: 'Do you want to view this order?',
                                    autoOpen: true,
                                    width: '66%',
                                    resizable: false,

                                    buttons: {

                                        Yes: function () {
                                            $(this).dialog("close");
                                            if($('#orderId').val().length < 3)
                                            {
                                                $('#orderId').val(data.OrderId);
                                                $("#checkOrders").click();
                                            }


                                            $("#dialog").dialogExtend("minimize");

                                            $(this).prop("disable",true);
                                        },
                                        No: function () {

                                            $(this).dialog("close");
                                        }

                                    },
                                    close: function (event, ui) {
                                        $(this).remove();
                                    }
                                });

                            $("body").on("click",".ui-widget-overlay",function() {
                                $('#evil').dialog( "close" );
                            });


                        }
                        //document.location.href = '/operator/'+data['slug'];
                    });
                    $('#createdOrders tbody').on('click', 'tr', function (e){
                        $("#createdOrders tbody tr").removeClass('row_selectedYellowish');
                        $(this).addClass('row_selectedYellowish');
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
                                {"data": "UserName", "class": "small"},
                                {"data": "inclusives", "class": "small"},
                                {"data": "Terms", "class": "small"},
                                {"data": "BalanceDue", "class": "small"},
                                {"data": "GPperc", "class": "small", render:function(data, type, row, meta) {
                                        // check to see if this is JSON
                                        try {
                                            var jsn = JSON.parse(data);
                                            //console.log(" parsing json" + jsn);
                                        } catch (e) {

                                            return jsn.data;
                                        }
                                        return parseFloat(jsn).toFixed(2);

                                    }}

                            ],
                            "order": [[ 6, "desc" ]],
                            "deferRender": true,
                            "scrollY": "389px",
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
                                {"data": "UserName", "class": "small"},
                                {"data": "inclusives", "class": "small"},
                                {"data": "Terms", "class": "small"},
                                {"data": "BalanceDue", "class": "small"},
                                {"data": "GPperc", "class": "small", render:function(data, type, row, meta) {
                                        // check to see if this is JSON
                                        try {
                                            var jsn = JSON.parse(data);
                                            //console.log(" parsing json" + jsn);
                                        } catch (e) {

                                            return jsn.data;
                                        }
                                        return parseFloat(jsn).toFixed(2);

                                    }}


                            ],

                            "deferRender": true,
                            "scrollY": "389px",
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
                        height: 600,
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
                /**
                 * General Plrice check for any customer on a product
                 * */
                $('#pricing').click(function () {
                    window.open('{!!url("/pl")!!}', "PriceLook", "location=1,status=1,scrollbars=1, width=1200,height=850");

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
                $('#awaitingStock').on('change',function(){ // this change function seems fine, it logs messages, it changes the checkbox
                    if($('#awaitingStock').is(':checked')) { // status and it runs a simple update, this would be the cause as CLICKING isnt the issue
                        isAwaitingStock(1);                    // its the lack thereof clicking.
                        $('#awaitingStock').val("1");
                    }else
                    {
                        alert("NOT WAITING FOR STOCK");
                        isAwaitingStock(0);
                        $('#awaitingStock').val("0");
                    }

                });
                /**
                 * Clicking the Finish button
                 * */
                $('#finishOrder').click(function () {

                    var zeropricingdoublecheck = new Array();
                    $('#table > tbody  > tr').each(function() {
                        var data = $(this);

                        var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                        var comment = $(this).closest('tr').find('.prodComment_').val();
                        //comment = comment.replace("'","");
                        console.debug($(this).closest('tr').find('.col2').val());
                        if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                            zeropricingdoublecheck.push({
                                'productCode': escapeHtml($(this).closest('tr').find('.theProductCode_').val()),
                                'qty': $(this).closest('tr').find('.prodQty_').val(),
                                'price': $(this).closest('tr').find('.prodPrice_').val(),
                                'comment': escapeHtml(comment),
                                'orderDetailID': orderDetailID,
                                'customerCode': escapeHtml($('#inputCustAcc').val()),
                                'prodDisc': $(this).closest('tr').find('.prodDisc_').val(),
                                'OrderId':$('#orderId').val(),
                                'hiddenToken':$(this).closest('tr').find('.hiddenToken').val(),
                                'prodBulk':$(this).closest('tr').find('.prodBulk_').val(),
                                'warehouse':$(this).closest('tr').find('.col2').val()
                            });


                        }

                    });

                    calculator();
                    // if (parseFloat((parseFloat($('#totalmargin').val()).toFixed(2)) < parseFloat(parseFloat($('#hiddencustomerGp').val()).toFixed(2) )) && ($('#margin_auth').val() != 1) )
                    if ( Math.round($('#totalmargin').val()  ) <  Math.round($('#hiddencustomerGp').val()  )  && ($('#margin_auth').val() != 1) && ($('#invoiceNo').val()).length < 3 && $('#marginandpriceauthbycustomer').val().lenght > 1 )
                    {
                        $('#MarginProblems').show();
                        showDialogWithoutClose('#MarginProblems',400,400);
                        $('#MarginProblems').keydown(function(event) {
                            if (event.keyCode == 27){
                                return false;
                            }
                        });
                        $('#doAuthCredits').off().click(function(){

                            $.ajax({
                                url: '{!!url("/verifyAuthOnAdmin")!!}' ,
                                type: "POST",
                                data:{ userName:$('#userAuthProhibitedCred_marg').val(),
                                    userPassword:$('#userAuthPassWordCredit_marg').val(),
                                    orderId:$('#orderId').val()
                                },
                                success: function(data){
                                    if ($.isEmptyObject(data)){
                                        alert("Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                                    }else
                                    {
                                        $('#margin_auth').val(1);
                                        consoleManagementAuths('{!!url("/logMessageAuthMargin")!!}',12,1,'Authorized Order Margin by '+data[0].UserName + '( ' +$('#totalmargin').val()+' )',
                                            0,$('#orderId').val(),'',$('#inputCustAcc').val(),0,0,0,$('#userAuthProhibitedCred_marg').val(),$('#orderId').val(),0,computerName,$('#orderId').val(),0,data[0].UserID,data[0].UserName);
                                        $("#MarginProblems").dialog('close');
                                        finishThis();


                                        //calculator();
                                    }
                                }
                            });

                        });
                        $('#doCancelAuthCredits').off().click(function(){
                            $('#MarginProblems').dialog('close');
                        });
                        //
                    }else{

                        $.ajax({
                            url: '{!!url("/isClosedRoute")!!}',
                            type: "POST",
                            data:{
                                delDate:$('#inputDeliveryDate').val(),
                                orderType:$('#orderType').val(),
                                routeId:$('#routeName').val(),
                                inputCustAcc:$('#inputCustAcc').val()


                            },
                            success: function(data){
                                //console.debug('I am Zero');

                                if (data.isClosed == '0'){
                                    console.debug('I am Zero');
                                    if($.trim(data.routeId) == $.trim(data.routeOnOrder) )
                                    {
                                        finishThis();
                                    }else
                                    {
                                        var dialog = $('<p>Sorry <strong style="color:red"> THIS IS NOT THE DEFAULT ROUTE FOR THIS CUSTOMER !</strong></p>').dialog({
                                            height: 200, width: 700,
                                            buttons: {
                                                "FIX": function () {

                                                    dialog.dialog('close');
                                                    consoleManagement('{!!url("/logMessageAjax")!!}', 325, 2, 'User Pressed FIX', 0, 0, 0, 0, 0, 0, 0, 0, $('#orederNumber').val(), 0, computerName, $('#orderId').val(), 0);
                                                } ,
                                                "CONTINUE ANYWAY": function () {

                                                    finishThis();
                                                    dialog.dialog('close');
                                                    consoleManagement('{!!url("/logMessageAjax")!!}', 325, 2, 'User Pressed FIX', 0, 0, 0, 0, 0, 0, 0, 0, $('#orederNumber').val(), 0, computerName, $('#orderId').val(), 0);

                                                }
                                            }
                                        });

                                    }


                                }else{

                                    if( ($('#invoiceNo').val()).length <5 )
                                    {authFinishOrder();}

                                }
                                // }
                            }
                        });
                    }
                });
                $('#abilityToEmailOrder').click(function () {
                    var ob = new Array();
                    ob = emailSalesOrderOnTheFly();
                    //console.debug(ob);
                    $.ajax({
                        url: '{!!url("/generatePDFForOrders")!!}',
                        type: "POST",
                        data: {
                            orderLinesOnTheFly: ob,
                            totalInc: $("#totalInc").val(),
                            custDescription: $('#custDescription').val(),
                            orderId: $('#orderId').val()
                        },
                        success: function (data) {
                            $('#toEmail').val($('#customerEmail').val());
                            $('#sendOrderEmail').val(data);
                            $('#subject').val('Order #' + $('#orderId').val());
                            $('#salesOEmail').show();
                            showDialog('#salesOEmail', '50%', 500);
                            $('#sendOrderEmail').on('click', function () {
                                $.ajax({
                                    url: '{!!url("/emailSalesOrder")!!}',
                                    type: "POST",
                                    data: {
                                        orderId: $('#orderId').val(),
                                        from: $('#fromEmail').val(),
                                        to: $('#toEmail').val(),
                                        cc: $('#cc').val(),
                                        subject: $('#subject').val(),
                                        bodyOnEmail: $('#bodyOnEmail').val(),
                                        file: data
                                    },
                                    success: function (data2) {

                                        var dialog = $('<p><strong style="color:black">' + data2 + '</strong></p>').dialog({
                                            height: 200, width: 700, modal: true, containment: false,
                                            buttons: {
                                                "Okay": function () {

                                                    dialog.dialog('close');
                                                }
                                            }
                                        });
                                    }
                                });
                            });
                        }
                    });
                });
                /**
                 * Send the request to the server and get order headers and details
                 *
                 * */

                $('#checkOrders').click(function () {

                    var account = '';
                    var Description = '';
                    var DeliveryDate = '';
                    var OrderDate = '';
                    var InvoiceTotalPriceInc = 0;
                    var InvoiceTotalPriceIncLineDisc = 0;
                    var InvoiceTotalPriceExcl = 0;
                    $(".fast_remove").empty();
                    $('.hidebody').show();
                    $('#deleteAllLines').show();
                    $('#orderType').prop("disabled", false);

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
                        url: '{!!url("/onCheckOrderHeader")!!}',
                        type: "POST",
                        data: {invoiceNo: $('#invoiceNo').val(), orderId: $('#orderId').val()},
                        success: function (data) {
                            console.debug("************ check" + data.returns);
                            if (data.returns != "inserted") {
                                $('#orderId').val("");
                                $('#deleteAllLines').hide();
                                var dialog = $('<p>Sorry <strong style="color:red">' + data.data[0].orderID + '</strong></p>').dialog({
                                    height: 200, width: 700,modal: true,
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
                                    $('#routeonabutton').val(value.Route);
                                    $('#hiddencustomerGp').val(value.mnyCustomerGp);
                                    $('#CustomerId').val(value.CustomerId);
                                    $('#balDue').val(parseFloat(value.BalanceDue).toFixed(2));
                                    $('#margin_auth').val(value.Authorised);
                                    $('#customerpricelist').val(value.termsAndList);
                                    $('#notification').prepend('<option value="'+value.intNotification+'" selected="selected">'+value.specificNotification+'</option>');

                                    console.debug('************************************* ttreat as '+value.TreatAsQuotation);
                                    if(value.TreatAsQuotation == '1')
                                    {
                                        $('#treatAsQuote').prop('checked',true);
                                    }
                                    else
                                    {
                                        $('#treatAsQuote').prop('checked',false);
                                    }

                                    if(value.AwaitingStock == '1')
                                    {
                                        $('#awaitingStock').prop('checked',true);

                                        $('#awaitingStock').val("1");
                                    }
                                    else
                                    {
                                        $('#awaitingStock').prop('checked',false);

                                        $('#awaitingStock').val("0");
                                    }

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
                                        backorderandawaiting(0);

                                    }
                                    else
                                    {
                                        $('#hiddenDeliveryAddressId').val(value.DeliveryAddressID);
                                        orderPattern(value.DeliveryAddressID);
                                        backorderandawaiting(value.DeliveryAddressID)
                                        $('#orderPatternIdTable_filter input').val('');
                                    }

                                    customerAndGroupSpecials();
                                    $("#routeName").empty();
                                    $('#routeName').prepend('<option value="'+value.RouteId+'" selected="selected">'+value.Route+'</option>');

                                    previousRouteVal = $("#routeName").val();
                                    previousTextRoute = $("#routeName").find("option:selected").text();
                                    $("#routeName").data('pre', previousTextRoute);
                                    $("#routeName").on('change', function () {
                                        if( ($('#orderId').val()).length > 1 ) {
                                            var toRoute = $(this).find("option:selected").text();
                                            var jqThis = $(this).data('pre');

                                            $('#authDropDowns').show();
                                            showDialogWithoutClose('#authDropDowns', '65%', 420);

                                            $('#doAuthDropDown').click(function () {
                                                authChangeOfOrderType(toRoute,'Authorised Route From '+jqThis+' To ');
                                                $("#routeName").data('pre', toRoute);
                                                //$('#authDropDowns').dialog('close');
                                                // authChangeOfOrderType(previousTextRoute,'Authorised Route To ');
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
                                    $.each(wareautocomplete, function (i, item) {
                                        $("#headerWh").append("<option value='"+item.ID+"'>" + item.Warehouse + "</option>");
                                    });
                                    //ORDER DETAILS
                                    $.ajax({
                                        url: '{!!url("/onCheckOrderHeaderDetails")!!}',
                                        type: "POST",
                                        data: {orderId: $('#orderId').val()},
                                        success: function (dataDetails) {
                                            InvoiceTotalPriceExcl = 0;
                                            InvoiceTotalPriceInc = 0;
                                            $.each(dataDetails, function (keyDetails, valueDetails) {
                                                var tokenId=new Date().valueOf();
                                                var props = '';
                                                console.debug("------------------------------------------------------"+isAllowedToChangeInv);
                                                if (($('#invoiceNo').val()).length > 2 && isAllowedToChangeInv != 1) {
                                                    props = "disabled";

                                                }
                                                console.debug("************************************ AUTMUTLIWAREHOUSE"+multiLines);
                                                if (($('#invoiceNo').val()).length > 2)
                                                {
                                                    $("#inputDeliveryDate").prop("disabled", true);
                                                    $("#inputOrderDate").prop("disabled", true);
                                                }
                                                if (multiLines ==1)
                                                {
                                                    var classAnonymouscols="anonymouscols";
                                                }else
                                                {
                                                    var classAnonymouscols="anonymouscolsOff";
                                                }
                                                var bulkitemcolor="";
                                                if(valueDetails.SoldByWeight !=0){
                                                    bulkitemcolor="bulkitemcolor";
                                                }
                                                var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
                                                    '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_' + tokenId + '" class="theProductCode_ set_autocomplete inputs" value="' + valueDetails.PastelCode + '" ' + props + ' ><br><input name="col1" id ="col1'+tokenId+'" class="col1 '+classAnonymouscols+'"  readonly></td>' +
                                                    '<td contenteditable="false" class="col-md-4"><input name="prodDescription_" id ="prodDescription_' + tokenId + '" class="prodDescription_ set_autocomplete inputs" value="' + valueDetails.PastelDescription + '" ' + props + ' ><br><input name="col8" id ="col8'+tokenId+'" class="col8 '+classAnonymouscols+'" readonly></td>' +
                                                    '<td  style="" contenteditable="false" class="col-md-1"><input type="text" name="prodBulk_"  id ="prodBulk_' + tokenId + '" class="prodBulk_ resize-input-inside '+bulkitemcolor+'"  value="' + valueDetails.UnitCount + '" '+ props + ' readonly><br><input name="col3" id ="col3'+tokenId+'" class="col3 '+classAnonymouscols+'" readonly></td>' +
                                                    '<td  contenteditable="false" class="col-md-1"><input type="text" name="prodQty_" id ="prodQty_' + tokenId + '"   onkeypress="return isFloatNumber(this,event)"  class="prodQty_ resize-input-inside inputs" value="' + (parseFloat(valueDetails.Qty)).toFixed(3) + '" ' + props + '><br><input name="col4" id ="col4'+tokenId+'" class="col4 '+classAnonymouscols+'" readonly></td>' +
                                                    '<td  contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" value="' + (parseFloat(valueDetails.Price)).toFixed(2) + '" ' + props + '><br><input name="col1" id ="col1'+tokenId+'" class="col1 '+classAnonymouscols+'" readonly></td>' +
                                                    '<td  contenteditable="false"  class="col-md-1"><input type="text" name="prodDisc_" id ="prodDisc_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside inputs" value="' + valueDetails.LineDisc + '" ' + props + ' {{$discountProperty}}><br><input name="col6" id ="col6'+tokenId+'" class="col6 '+classAnonymouscols+'" style="color: brown;" readonly></td>' +
                                                    '<td  contenteditable="false"  class="col-md-1"><input  type="text" name="prodUnitSize_" id ="prodUnitSize_' + tokenId + '" class="prodUnitSize_ resize-input-inside inputs" value="' + valueDetails.UnitSize + '" ' + props + ' ></td>' +
                                                    '<td contenteditable="false" style="display:flex;" class="col-md-1"><input type="text" name="instockReadOnly" id ="instockReadOnly_' + tokenId + '" value="' + valueDetails.QtyInStock + '"  class="instockReadOnly_ resize-input-inside inputs" style="font-weight: 800;width: 54px !important;color:blue;"><input type="text" name="shelf" id ="shelf_' + tokenId + '" class="shelf_ resize-input-inside" value="' + valueDetails.shelf + '" style="font-weight: 800;color:red;width: 54px;float:right;"><select name="col2" id ="col2'+tokenId+'" class="col2 '+classAnonymouscols+'"><option value="' + valueDetails.ID + '" >"' + valueDetails.Warehouse + '"</option> </select></td>' +
                                                    '<td contenteditable="false"  class="col-md-1"><input type="text" name="instockReadOnly" id ="clcstock_' + tokenId + '" value="' + valueDetails.QtyInStock + '"  class="clcstock_ resize-input-inside inputs" style="font-weight: 800;width: 80%;color:blue;"></td>' +
                                                    '<td contenteditable="false"  class="col-md-1"><input type="text" name="additionalcost_" id ="additionalcost_' + tokenId + '" value ="" class="additionalcost_ resize-input-inside inputs" style="font-weight: 800;font-size:8px !important;color:blue;"></td>' +
                                                    '<td  contenteditable="false" class="col-md-3"><input type="text" name="prodComment_" id ="prodComment_' + tokenId + '" class="prodComment_ resize-input-inside last inputs" title="' + valueDetails.Comment + '"  value="' + valueDetails.Comment + '" ' + props + ' ><br><input name="col9" id ="col9'+tokenId+'" class="col9 '+classAnonymouscols+'" readonly></td>' +
                                                    '<td><input type="hidden" id="title_' + tokenId + '" class="title" value="" /><input type="hidden" id="theOrdersDetailsId" value="' + valueDetails.OrderDetailId + '" /><input type="hidden" id ="taxCode' + tokenId + '" value="' + valueDetails.Tax + '" class="taxCodes" />' +
                                                    '<input type="hidden" id ="cost_' + tokenId + '" value="' + valueDetails.Cost + '" class="costs" /><input type="hidden" id ="inStock_' + tokenId + '" value="' + valueDetails.QtyInStock + '" class="inStock" style="color:blue !important" /><input type="hidden" value ="' + tokenId + '" class="hiddenToken" />' +
                                                    '<input type="hidden" id ="priceholder_' + tokenId + '" value="' + (parseFloat(valueDetails.Price)).toFixed(2) + '" class="priceholder" />' +
                                                    '<input type="hidden" id ="alcohol_' + tokenId + '" value="" class="alcohol" /><input type="hidden" id ="margin_' + tokenId + '" value="" class="margin" />' +
                                                    '<input type="hidden" id ="soldByWieght' + tokenId + '" value="" class="soldByWieght" />' +
                                                    '<input type="hidden" id ="unitWeight' + tokenId + '" value="" class="unitWeight" />' +
                                                    '<input type="hidden" id ="strBulkUnit' + tokenId + '" value="" class="strBulkUnit" />' +
                                                    '<input type="hidden" id ="prohibited_' + tokenId + '" value="" class="prohibited" />' +
                                                    '<input type="hidden" id ="productmarginauth' + tokenId + '" value="1" class="productmarginauth" />' +
                                                    '<button type="button" id="deleteaLine" value="' + valueDetails.OrderDetailId + '" class="getOrderDetailLine btn-warning" >Delete</button>' +
                                                    '</td></tr>');
                                                $('#table tbody').append($row);

                                                if (valueDetails.Price == null || valueDetails.IncPrice == null) {
                                                    InvoiceTotalPriceExcl = (parseFloat(InvoiceTotalPriceExcl) + (0 * parseFloat(valueDetails.Qty))).toFixed(2);
                                                    InvoiceTotalPriceInc = (parseFloat(InvoiceTotalPriceInc) + (0 * parseFloat(valueDetails.Qty))).toFixed(2);
                                                } else {
                                                    InvoiceTotalPriceExcl = (parseFloat(InvoiceTotalPriceExcl) + (parseFloat(valueDetails.Price) * parseFloat(valueDetails.Qty))).toFixed(2);
                                                    InvoiceTotalPriceInc = (parseFloat(InvoiceTotalPriceInc) + (parseFloat(valueDetails.IncPrice) * parseFloat(valueDetails.Qty))).toFixed(2);
                                                    InvoiceTotalPriceIncLineDisc = (parseFloat(InvoiceTotalPriceIncLineDisc) + ((parseFloat(valueDetails.IncPrice)*((100-valueDetails.LineDisc)/100)) * parseFloat(valueDetails.Qty))).toFixed(2);

                                                }
                                                focusoutcaladditionalcost(valueDetails.PastelCode,(parseFloat(valueDetails.Qty)).toFixed(3),'additionalcost_' + tokenId);
                                                var txt = valueDetails.Warehouse;//$("#headerWh option:selected").text();
                                                var val = valueDetails.ID;
                                                $("#col2"+tokenId).append("<option value='"+val+"'>" + txt + "</option>");
                                                $.each(wareautocomplete, function (i, item) {
                                                    $("#col2"+tokenId).append("<option value='"+item.ID+"'>" + item.Warehouse + "</option>");
                                                });
                                                var Ltot = valueDetails.Qty * valueDetails.Price;
                                                $("#col6"+tokenId).val(Ltot.toFixed(2));

                                            });
                                            if ($('#invoiceNo').val().length < 3 ) {
                                                $('#changeDeliveryAddressOnNotInvoiced').show();
                                                generateALine2();
                                            } else {
                                                if(isAllowedToChangeInv !=1){
                                                    $(".getOrderDetailLine ").css("display", "none");
                                                    $("#deleteAllLines").hide();
                                                    $('#changeDeliveryAddressOnNotInvoiced').hide();

                                                }

                                            }

                                            $('#totalEx').val(InvoiceTotalPriceExcl);
                                            $('#totalInc').val(InvoiceTotalPriceInc);
                                            $('#totalInOrder').val(InvoiceTotalPriceIncLineDisc);
                                            calculator();
                                        }

                                    });

                                    $("#invoiceNo").prop("disabled", true);
                                    $("#orderId").prop("disabled", true);
                                    $("#inputCustAcc").flexdatalist('disabled', true );
                                    $("#inputCustName").flexdatalist('disabled', true );
                                    if (( $("#invoiceNoKeeper").val()).length > 1 && isAllowedToChangeInv != 1) {
                                        $("#orederNumber").prop("disabled", true);
                                        $("#totalEx").prop("disabled", true);
                                        $("#totalInc").prop("disabled", true);
                                        $("#button_row").prop("disabled", true);
                                        $("#routeonabutton").prop("disabled", true);

                                        $("#invoiceNow").hide();
                                        $("#reprintInvoice").show();

                                        // $('#edit_row').show()
                                    }


                                });
                            }

                            //$("#two-columns").find("input").attr("disabled", "disabled");

                        }
                    });
                    //End of Order Header

                });
                $('#totaddidtionalcst').click(function(){
                    calcAdditionalCost();
                });
                $('#advancedorderNumber').click(function () {
                    //brandedorderno
                    $('#brandedorderno').show();
                    showDialog('#brandedorderno','45%',400);
                    $.ajax({
                        url: '{!! url("/advancedorderno") !!}',
                        type: "POST",
                        data: {

                            OrderId: $('#orderId').val()

                        },success: function (data) {
                            // $('#salesmandialog').dialog('close');
                            var trHTML = '';
                            $.each(data, function (key, value) {
                                trHTML += '<tr class="fast_remove" style="font-size: 9px;color:black"><td>' +
                                    value.BrandId + '</td><td>' +
                                    value.Brand + '</td><td>' +
                                    '<input type="text"  class="form-control input-sm col-xs-1" id="neworderno" value="' + value.OrderNo + '" class="foo">' +
                                    '<input type="hidden" id="brandid" value="' + value.BrandId + '" style="width:1px" class="foo">' +
                                    '</td></tr>';

                            });
                            $('#tableorderno').append(trHTML);
                        }
                    });

                });
                $('#pricingOnCustomer').click(function(){
                    $('#priceLookPriceWithCustomer').show();
                    showDialog('#priceLookPriceWithCustomer','65%',620);
                    $('#goOnPL').click(function(){
                        PL();
                    });

                });
                $('#addTheSalesMan').click(function(){
                    $('#salesmandialog').show();
                    showDialog('#salesmandialog','35%',350);
                    $('#authsalesmanusername').val(" ");
                    $('#authsalesmanpassword').val(" ");
                    $('#submitsalesman').click(function(){
                        $.ajax({
                            url: '{!! url("/changesalesman") !!}',
                            type: "POST",
                            data: {
                                userID: $('#salesmanselectstatement').val(),
                                OrderId: $('#orderId').val(),
                                DriverDeliveryDate: $('#inputDeliveryDate').val(),
                                authUserName: $('#authsalesmanusername').val(),
                                authUserPassword: $('#authsalesmanpassword').val()
                            },success: function (data) {
                                if (data=="DONE")
                                {
                                    $('#salesmandialog').dialog('close');
                                }else
                                {
                                    alert("Sorry ,you don't have access to authorize rep codes");
                                }

                            }
                        });
                    });

                });
                $('#routeonabutton').click(function(){
                    $('#routingdialog').show();
                    showDialog('#routingdialog','25%',250);
                    $('#auththisrouteontheorder').click(function(){
                        $.ajax({
                            url: '{!! url("/changerouteonorder") !!}',
                            type: "POST",
                            data: {
                                routeId: $('#changetcurrentrouteonorder').val(),
                                OrderId: $('#orderId').val(),

                            },success: function (data) {
//console.debug(data);
                                $('#routeonabutton').val(data);
                                $('#routingdialog').dialog('close');
                            }
                        });
                    });

                });

                /**
                 * Main form filters to generate the order
                 * */
                $('#submitFilters').click(function () {
                    //Check if there is an order
                    //checkIfOrderExistsWithOrderType
                    // alert(computerName);
                    $("#deprecated_cangeDate").hide();
                    $('#copyThisOrder').hide();
                    $('#printDocument').hide();
                    $('#checkOrders').hide();
                    $('#orderType').prop("disabled", false);





                    $("#inputCustAcc").flexdatalist('disabled', true );
                    $("#inputCustName").flexdatalist('disabled', true );
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
                            url: '{!! url("/insertOrderHeader") !!}',
                            type: "POST",
                            data: {
                                customerCode: $('#inputCustAcc').val(),
                                deliveryDate: $('#inputDeliveryDate').val(),
                                orderDate: $('#inputOrderDate').val(),
                                routeId:$('#Routeid').val(),
                                OrderType: $('#orderType').val(),
                                orderNo: '',
                                statement: 'Insert',
                                discount: $('#hiddenCustDiscount').val()
                            },
                            success: function (data) {

                                $('#orderId').val(data.orderId);
                                consoleManagement('{!!url("/logMessageAjax")!!}', 300, 1, 'New Order Created For '+$('#inputCustAcc').val()+' - '+data.orderId, 0 , 0, 0, 0, 0, 0, 0, 0, +data.orderId, 0, computerName, +data.orderId, 0);

                                customerAndGroupSpecials();
                                if (data.counter.CustomerId == "1") {
                                    //$('.container').pleaseWait();
                                    orderPattern('0');
                                    backorderandawaiting(0);
                                    $('#orderPatternIdTable_filter input').val('');
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

                                    if(data.singleAddress.CustomerOnHold !="0")
                                    {
                                        $('#customeronhold').val("ACCOUNT ON HOLD");
                                    }

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
                                                    backorderandawaiting($("#deliveryAddressIdOnPopUp").val());
                                                    $('#orderPatternIdTable_filter input').val('');
                                                    $.ajax({
                                                        url: '{!! url("/changerouteonorder") !!}',
                                                        type: "POST",
                                                        data: {
                                                            routeId: $('#generalRouteForNewDeliveryAddress').val(),
                                                            OrderId: $('#orderId').val(),

                                                        },success: function (data) {
//console.debug(data);
                                                            var textAddress = $('#address1').val() + ' ' + $('#address2').val() + ' ' + $('#address3').val() + ' ' + $('#address4').val() + ' ' + $('#address5').val();
                                                            $("#customerSelectedDelDate").val(textAddress);
                                                            $('#address1hidden').val($('#address1').val());
                                                            $('#address2hidden').val($('#address2').val());
                                                            $('#address3hidden').val($('#address3').val());
                                                            $('#address4hidden').val($('#address4').val());
                                                            $('#address5hidden').val($('#address5').val());
                                                            $('#routeonabutton').val($('#generalRouteForNewDeliveryAddress option:selected').text());
                                                            //$("#hiddenDeliveryAddressId").val($("#deliveryAddressIdOnPopUp").val());
                                                            $("#hiddenDeliveryAddressId").val($("#deliveryAddressIdOnPopUp").val());
                                                            $('#routeName').prepend('<option value="'+$('#generalRouteForNewDeliveryAddress').val()+'" selected="selected">'+$('#generalRouteForNewDeliveryAddress option:selected').text()+'</option>');
                                                            $("#listOfDelivAdress").dialog("close");

                                                        }
                                                    });


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
                                $('#deleteAllLines').show();
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


                        previousRouteVal = $("#routeName").val();
                        previousTextRoute = $("#routeName").find("option:selected").text();
                        $("#routeName").data('pre', previousTextRoute);

                        $("#routeName").on('change', function () {
                            if( ($('#orderId').val()).length > 1 ) {

                                var toRoute = $(this).find("option:selected").text();
                                var jqThis = $(this).data('pre');

                                $('#authDropDowns').show();
                                showDialogWithoutClose('#authDropDowns', '65%', 420);

                                $('#doAuthDropDown').click(function () {
                                    authChangeOfOrderType(toRoute,'Authorised Route From '+jqThis+' To ');
                                    $("#routeName").data('pre', toRoute);
                                });
                                $('#doCancelAuthDropDown').click(function () {
                                    $("#routeName").prepend('<option value="' + previousRouteVal + '" >' + previousTextRoute + '</option>');
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

                        $.each(wareautocomplete, function (i, item) {
                            $("#headerWh").append("<option value='"+item.ID+"'>" + item.Warehouse + "</option>");
                        });
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
                    // $('#checkdeliverydate').show();
                    // showDialog('#checkdeliverydate',700,200);
                    $('#delvokay').click(function(){
                        $('#checkdeliverydate').dialog('close');

                        /* $.ajax({
                    url: ,
                    type: "POST",
                    data: {
                        customerCode: $('#inputCustAcc').val(),
                        delvDate: $('#inputDeliveryDate').val(),
                        OrderId: $('#orderId').val(),

                    },
                    success: function (data) {

                    }
                });*/


                    });
                });//END OF SUBMITFILTER

                $("#pdfexportorder").click(function(){

                    {

                        if (($('#invoiceNo').val()).length > 3) {
                            window.open('{!!url("/pdforder")!!}/'+$('#orderId').val(), "PDF", "location=1,status=1,scrollbars=1, width=1200,height=850");
//View PDF
                        } else {
                            window.open('{!!url("/pdforder")!!}/'+$('#orderId').val(), "PDF", "location=1,status=1,scrollbars=1, width=1200,height=850");
                        }

                    }
                    saveorderswithoutExtrasPDF();
                });

                $('#excelexportorder').click(function(){
                    saveorderswithoutExtras();
                });
                $('#copyThisOrder').click(function () {
                    getOrderTypes('#CopyorderType', '{!!url("/deliveryTypes")!!}');
                    $('#copyOrderDialog').show();
                    $("#copyOrderDialog").dialog({
                        height: 200,
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
                    $('#copyCustCode').val($('#inputCustAcc').val());
                    $('#copyRouteID').val($('#routeName').val());

                    $('#submitCopyOrder').click(function () {

                        $.ajax({
                            url: '{!!url("/copyInvoice")!!}',
                            type: "POST",
                            data: {
                                customerCode: $('#copyCustCode').val(),
                                delvDate: $('#copyDeliveryDate').val(),
                                orderType: $('#CopyorderType').val(),
                                delvAddress: $('#hiddenDeliveryAddressId').val(),
                                routeId: $('#copyRouteID').val(),
                                orderNo: $('#orederNumber').val(),
                                OrderId: $('#orderId').val(),

                            },
                            success: function (data) {
                                $('#copyOrderDialogComfirmation').show();
                                $('#copyOrderDialogComfirmation').dialog({
                                    height: 200,
                                    width: 900, containment: false
                                }).dialogExtend({
                                    "closable": true, // enable/disable close button
                                    "maximizable": false, // enable/disable maximize button
                                    "minimizable": false, // enable/disable minimize button
                                    "collapsable": false, // enable/disable collapse button
                                    "dblclick": false, // set action on double click. false, 'maximize', 'minimize', 'collapse'
                                    "titlebar": false, // false, 'none', 'transparent'
                                    "minimizeLocation": "right", // sets alignment of minimized dialogues
                                    "icons": { // jQuery UI icon class
                                        "close": "ui-icon-circle-close",
                                    },
                                    "load": function (evt, dlg) {
                                    }, // event
                                    "beforeMaximize": function (evt, dlg) {
                                    }, // event
                                    "beforeMinimize": function (evt, dlg) {
                                    }, // event
                                    "beforeRestore": function (evt, dlg) {
                                    }, // event
                                });
                                $('.newOrderId').empty();
                                $('.newOrderId').append(data[0].OrderId);
                                $("#copyOrderDialog").dialog("close");
                            }
                        });
                    });
                });
                $('#printPDFPickIndOrder').click(function(){

                    var productsLinesOnPickingOneOrder = new Array();
                    $('#table > tbody  > tr').each(function() {
                        var data = $(this);
                        var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                        console.debug($(this).closest('tr').find('.theProductCode_').val());
                        if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                            productsLinesOnPickingOneOrder.push({
                                'productCode': $(this).closest('tr').find('.theProductCode_').val(),
                                'desc': $(this).closest('tr').find('.prodDescription_').val(),
                                'qty': $(this).closest('tr').find('.prodQty_').val(),
                                'price': $(this).closest('tr').find('.prodPrice_').val(),
                                'comment': $(this).closest('tr').find('.prodComment_').val(),
                                'orderDetailID': orderDetailID,
                                'customerCode': $('#inputCustAcc').val(),
                                'prodDisc': $(this).closest('tr').find('.prodDisc_').val()
                            });
                        }

                    });
                    //printPickingSlipPerOrder


                    $.ajax({
                        url: '{!!url("/printPickingSlipPerOrder")!!}',
                        type: "POST",
                        data: {
                            OrderId: $('#orderId').val(),
                            orderDetails: productsLinesOnPickingOneOrder,
                        },
                        success: function (data) {
                            console.debug(data);
                            // upDateOrderHeaderAndPOS();
                        }
                    });
                });

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
                        //var productCode = row.find('td:eq(6)').text(); when you hide it
                        var productCode = row.find('td:eq(7)').text();

                        var tax = row.find('td:eq(9)').text();
                        var unitSizes = row.find('td:eq(10)').text();
                        var UnitWeight = row.find('td:eq(11)').text();
                        var SoldByWeight = row.find('td:eq(12)').text();
                        var strBulkUnit = row.find('td:eq(13)').text();
                        var ProductMargin = row.find('td:eq(14)').text();
                        var isCheckedOrderPatternAuth = true;

                        if(inStock<1)
                        {
                            isCheckedOrderPatternAuth=false;
                            $('#appendErrormsg').empty();
                            $('#appendErrormsg').append("It appears that you don't have enough in stock");
                            showDialogWithoutClose("#authorisations", 500, 500);
                            //if (e.keyCode == 27) return false;
                            $('#noThanksRedo').off().click(function () {

                                calculator();

                                $("#authorisations").dialog('close');
                            });
                            $('#doAuth').off().click(function () {
                                // $('#userAuthName').val();
                                console.debug($('#userAuthPassWord').val());
                                $('#userAuthPassWord').val();
                                $.ajax({
                                    url: '{!!url("/verifyAuthMario")!!}',
                                    type: "POST",
                                    data: {
                                        userName: $('#userAuthName').val(),
                                        userPassword: $('#userAuthPassWord').val()
                                    },
                                    success: function (data) {
                                        //console.debug("bunch"+data);
                                        if ($.isEmptyObject(data)) {
                                            alert("Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                                        } else {
                                            $('#userAuthName').val('');
                                            $('#userAuthPassWord').val('');
                                            isCheckedOrderPatternAuth = true;
                                            consoleManagementAuths('{!!url("/logMessageAuth")!!}', 12, 1, 'Authorized out os Stock by ' + data[0].UserName,
                                                0, $('#orderId').val(), '', $('#inputCustAcc').val(), 0, 0, 0, $('#userNewVariable').val(), $('#orderId').val(), 0, computerName, $('#orderId').val(), 0, data[0].UserID, data[0].UserName);
                                            $("#authorisations").dialog('close');
                                            calculator();


                                        }
                                    }
                                });

                            });

                        }

                        //var tax = '14.0';
                        //console.debug("unitSizes on double click"+unitSizes);
                        $('#availableOnTheFly').empty();

                        //console.debug("************************ProductMargin ------"+ProductMargin);
                        if(isCheckedOrderPatternAuth){

                            productPriceOnReadyMadeLine(productCode,producutDescr,tax,cost,isAuthMyLine,inStock,unitSizes,UnitWeight,SoldByWeight,strBulkUnit,ProductMargin,multiLines);
                            // console.debug("*************"+ $(this).find(".prodPrice_").val(12));
                            row.remove();
                        }
                    }

                });
                $('#orderPatternIdTable').on('click', 'tbody tr', function () {

                    // if (($('#invoiceNoKeeper').val()).length < 2) {
                    var $this = $(this);
                    var row = $this.closest("tr");
                    var productCode = row.find('td:eq(6)').text();
                    switch(donotshowAvailable){
                        case 'FALSE':
                            qtyAvailableOnClick(productCode);
                            break;
                    }


                    //}

                });
                $('#customerSpecials tbody').on('dblclick', 'tr', function () {
//Disable double click  orderPatternIdTable
                    if (($('#invoiceNoKeeper').val()).length < 2) {

                        var $this = $(this);
                        var row = $this.closest("tr");
                        var producutDescr = row.find('td:eq(0)').text();
                        var productCode = row.find('td:eq(1)').text();
                        var uom = row.find('td:eq(5)').text();
                        var Prodcost = $(this).find('#Prodcost').val();
                        var ProdQnt = $(this).find('#ProdQnt').val();
                        var titles =isAuthMyLine; //$(this).find('#titles').val();
                        var tax = $(this).find('#taxCode').val();
                        var SoldByWeight = $(this).find('#soldByWieght').val();
                        var strBulkUnit = $(this).find('#strBulkUnit').val();
                        var UnitWeight = $(this).find('#UnitWeight').val();
                        var ProductMargin = $(this).find('#ProductMargin').val();
                        var price = '';
                        console.debug("ke nna"+SoldByWeight);
                        //tag,prodDesc,prodCodes,prodQty,price,cost,instock,titles
                        // console.debug("*************"+ $(this).find(".prodPrice_").val(12));
                        productPriceOnReadyMadeLine(productCode,producutDescr,tax,Prodcost,titles,ProdQnt,uom,UnitWeight,SoldByWeight,strBulkUnit,ProductMargin,multiLines);

                    }
                });
                $('#groupSpecials tbody').on('dblclick', 'tr', function () {
                    if (($('#invoiceNoKeeper').val()).length < 2) {

                        var $this = $(this);
                        var row = $this.closest("tr");
                        var producutDescr = row.find('td:eq(0)').text();
                        var productCode = row.find('td:eq(1)').text();
                        var uom = row.find('td:eq(5)').text();
                        var Prodcost = $(this).find('#Prodcost').val();
                        var ProdQnt = $(this).find('#ProdQnt').val();
                        var titles = isAuthMyLine;//$(this).find('#titles').val();
                        var tax = $(this).find('#taxCode').val();
                        var SoldByWeight = $(this).find('#SoldByWeight').val();
                        var strBulkUnit = $(this).find('#strBulkUnit').val();
                        var UnitWeight = $(this).find('#UnitWeight').val();
                        var ProductMargin = $(this).find('#ProductMargin').val();
                        var price = '';


                        productPriceOnReadyMadeLine(productCode,producutDescr,tax,Prodcost,titles,ProdQnt,uom,UnitWeight,SoldByWeight,strBulkUnit,ProductMargin,multiLines);

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
                            var titles = isAuthMyLine;//$(this).find('#titles').val();
                            var tax = $(this).find('#taxCode').val();
                            var UnitSizes = $(this).find('#UnitSizes').val();
                            var SoldByWeight = $(this).find('#SoldByWeight').val();
                            var strBulkUnit = $(this).find('#strBulkUnit').val();
                            var UnitWeight = $(this).find('#UnitWeight').val();
                            var ProductMargin = $(this).find('#ProductMargin').val();
                            console.debug(" on PastInvoice" + UnitSizes);
                            var priceReturned = getPriceForProductDependingOnCustAndDeliveryDate('{!!url("/getCutomerPriceOnOrderForm")!!}', $('#inputCustAcc').val(), $('#inputDeliveryDate').val(), productCode,$('#headerWh').val());
                            console.debug('priceReturned' + priceReturned);

                            $.ajax({
                                url: '{!!url("/getCutomerPriceOnOrderForm")!!}',
                                type: "POST",
                                data: {
                                    customerID: $('#inputCustAcc').val(),
                                    deliveryDate: $('#inputDeliveryDate').val(),
                                    productCode: productCode,
                                    warehouseid:$('#headerWh').val()
                                },
                                success: function (data) {
                                    //console.debug('sluuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuut');
                                    var weneedauth = 0;
                                    if(data[0].theMg == "NEEDAUTH"){
                                        weneedauth = 1;

                                    }
                                    console.debug(data);
                                    var price = '';
                                    if ($.isEmptyObject(data)) {
                                        price = '';
                                        linetotal(1,0,tax,marginCalculator(0,0));
                                        readyMadeLineOrderLine('#table tbody', producutDescr, productCode, '', price, Prodcost, ProdQnt, titles, tax,UnitSizes,'0',UnitWeight,SoldByWeight,strBulkUnit,ProductMargin,multiLines,data[0].LineDisc,linediscount,weneedauth);
                                    } else {
                                        price = parseFloat(data[0].Price).toFixed(2);
                                        console.debug('something'+data[0].LineDisc);
                                        linetotal(1,price,tax,marginCalculator(data[0].Cost,price));
                                        if (reportmarginControl === 'marginType5')
                                        {
                                            console.debug('margin 5'+data[0].LineDisc);
                                            console.debug('linediscount# '+linediscount);
                                            readyMadeLineOrderLine('#table tbody', producutDescr, productCode, '', price, Prodcost, ProdQnt, titles, tax,UnitSizes,data[0].Prohibited,UnitWeight,SoldByWeight,strBulkUnit,ProductMargin,multiLines,data[0].LineDisc,linediscount,weneedauth);

                                        }else{
                                            console.debug('margin not 5'+data[0].LineDisc);
                                            console.debug('linediscount not# '+linediscount);
                                            readyMadeLineOrderLine('#table tbody', producutDescr, productCode, '', price, Prodcost, ProdQnt, titles, tax,UnitSizes,data[0].Prohibited,UnitWeight,SoldByWeight,strBulkUnit,multiLines,data[0].LineDisc,linediscount,weneedauth);
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
                    $('#routeonabutton').val(data.strRoute);
                    $('#hiddencustomerGp').val(data.mnyCustomerGp);
                    $('#CustomerId').val(data.CustomerId);
                    $('#customerpricelist').val(data.termsAndList);

                    $("#headerWh").prepend("<option value='"+data.ID+"'>" + data.Warehouse + "</option>");
                    GlobalcustomerId = data.CustomerId;
                    console.debug("onhold"+data.CustomerOnHold);

                    if( data.CustomerOnHold != 0){
                        var dialog = $('<p><strong style="color:red">Account on Hold</strong></p>').dialog({
                            height: 200, width: 700,modal: true,containment: false,
                            buttons: {
                                "Ignore": function () {
                                    dialog.dialog('close');
                                },
                                "CANCEL": function () {
                                    $('#inputCustAcc').val('');
                                    $('#inputCustName').val('');
                                    dialog.dialog('close');
                                }
                            }
                        });
                    }
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
                    $('#routeonabutton').val(data.strRoute);
                    $('#hiddencustomerGp').val(data.mnyCustomerGp);
                    $('#CustomerId').val(data.CustomerId);
                    $('#customerpricelist').val(data.termsAndList);
                    $("#headerWh").prepend("<option value='"+data.ID+"'>" + data.Warehouse + "</option>");
                    GlobalcustomerId = data.CustomerId;
                    console.debug("onhold"+data.CustomerOnHold);
                    if(data.CustomerOnHold != 0){
                        var dialog = $('<p><strong style="color:red">Account on Hold</strong></p>').dialog({
                            height: 200, width: 700,modal: true,containment: false,
                            buttons: {
                                "Ignore": function () {
                                    dialog.dialog('close');
                                },
                                "CANCEL": function () {
                                    $('#inputCustAcc').val('');
                                    $('#inputCustName').val('');
                                    dialog.dialog('close');
                                }
                            }
                        });
                    }

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
                    $('#custId').val(data.CustomerId);

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
                    $('#custId').val(data.CustomerId);

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
                $("#productCodeOnInvoice").mcautocomplete({
                    source: finalDataProduct,
                    columns: columnsC,
                    minlength: 1,
                    autoFocus: true,
                    delay: 0,
                    appendTo: "#prodonInvoice",
                    select: function (e, ui) {
                        $('#productDescOnInvoiced').val(ui.item.PastelDescription);
                        $('#productCodeOnInvoice').val(ui.item.PastelCode);
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
                        $('#prodId').val(ui.item.ProductId);

                    }
                });
                var columnsD = [{name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                    {name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'}
                    ,{name: 'Available', minWidth:'20px',valueField: 'Available'}];
                $("#productDescOnOrder").mcautocomplete({
                    source: finalDataProductTest,
                    columns: columnsD,
                    autoFocus: true,
                    minlength: 3,
                    delay: 0,
                    multiple: true,
                    multipleSeparator: " ",
                    appendTo: "#prodOnOrder",
                    select: function (e, ui) {
                        $('#productDescOnOrder').val(ui.item.PastelDescription);
                        $('#productCodeOnOrder').val(ui.item.PastelCode);
                    }
                });
                $("#productDescOnInvoiced").mcautocomplete({
                    source: finalDataProductTest,
                    columns: columnsD,
                    autoFocus: true,
                    minlength: 2,
                    delay: 0,
                    multiple: true,
                    multipleSeparator: " ",
                    appendTo: "#prodonInvoice",
                    select: function (e, ui) {
                        $('#productDescOnInvoiced').val(ui.item.PastelDescription);
                        $('#productCodeOnInvoice').val(ui.item.PastelCode);
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
                        $('#prodId').val(ui.item.ProductId);
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
                                productCode: $('#theProductCode').val(),
                                warehouseid:$('#headerWh').val()
                            },
                            success: function (data) {
                                console.debug("********************"+data[0].AvailableToSell);

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
                                productCode: $('#theProductCode').val(),
                                warehouseid:$('#headerWh').val()
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
                                        allInoneDocumentsave("POS");
                                    }
                                },
                                Yes: function () {
                                    //Update the tblOrders and tblOrdersDetails here

                                    calculator();
                                    allInoneDocumentsave("INVOICEIT");


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
                $('#updatecontactsontheorder').on('click',function(){

                    $.ajax({
                        url: '{!!url("/updateCContactsOnOrder")!!}',
                        type: "POST",
                        data: {
                            CustomerPastelCode: $('#inputCustAcc').val(),
                            contactCellOnDispatch: $('#contactCellOnDispatch').val(),
                            telOnDispatch: $('#telOnDispatch').val(),
                            contactPersonOnDispatch: $('#contactPersonOnDispatch').val()
                        },
                        success: function (data) {
                            if (data == 1)
                            {
                                var dialog = $('<p><strong style="color:red">Contact Info updated successfully</strong></p>').dialog({
                                    height: 200, width: 700,modal: true,containment: false,
                                    buttons: {
                                        "Okay": function () {
                                            dialog.dialog('close');
                                        }
                                    }
                                });
                            }
                            else {
                                alert("Something went Wrong");
                            }

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
                $('#deleteAllLines').click(function () {

                    var dialog = $('<p><strong style="color:red">This will delete all the lines mapped to this order</strong></p>').dialog({
                        height: 200, width: 700,modal: true,containment: false,
                        buttons: {
                            "Finish": function () {



                                $.ajax({
                                    url: '{!!url("/deleteallLinesOnOrder")!!}',
                                    type: "POST",
                                    data: {
                                        orderId: $('#orderId').val(),
                                        customerCode: $('#inputCustAcc').val(),
                                        delivdate: $('#inputDeliveryDate').val()
                                    },
                                    success: function (dataDetails) {
                                        if(dataDetails[0].Result=='THIS ORDER HAS ALREADY BEEN PARTIALLY PICKED OR LOADED')
                                        {
                                            console.log("PICKED OR LOADED!");

                                            dialog.dialog('close');
                                            var dialogalreadydone= $('<p><strong style="color:red">This order has already been partially picked or loaded. Delete failed.</strong></p>').dialog({
                                                height: 200, width: 700,modal: true,containment: false,
                                                buttons:{"Okay": function () {
                                                        dialogalreadydone.dialog('close');
                                                    }}
                                            });
                                        }
                                        else{
                                            $("#table > tbody:last").children().remove();
                                            dialog.dialog('close');
                                            generateALine2();
                                        }
                                    }
                                });
                                //dialog.dialog('close');
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
                    var hiddenToken = row_closestTrColumns.find('.hiddenToken').val();

                    if(orderLineID === "undefined" || orderLineID === undefined) {
                        if (($('#invoiceNo').val()).length < 1 ) {
                            $this.closest('tr').remove();
                            var prodCode2 = row_closestTrColumns.find('.theProductCode_').val();

                            if (prodCode2 === prodCode1)
                            {
                                //console.debug('they are equal - AFTER------------**************** '+prodCode2);
                                $this.closest('tr').remove();
                            }
                            //   generateALine2();
                            calculator();
                            $.ajax({
                                url:'{!!url("/deleteByHiddenToken")!!}',
                                type: "POST",
                                data: {
                                    orderId: $('#orderId').val(),
                                    hiddenToken: hiddenToken
                                },
                                success: function(data){

                                    console.debug("////////////////////////////////////////////////////////////"+data.result);
                                    if(data.result !="SUCCESS" && data.result !="Success")
                                    {
                                        var dialog = $('<p><strong style="color:black">'+data.result+'</strong></p>').dialog({
                                            height: 200, width: 700, modal: true, containment: false,
                                            buttons: {
                                                "Okay": function () {
                                                    dialog.dialog('close');
                                                },

                                            }
                                        });
                                    }


                                }
                            });
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
                            url:'{!!url("/deleteOrderDetails")!!}',
                            type: "POST",
                            data: {
                                OrderId: $('#orderId').val(),
                                OrderDetailId: orderLineID},
                            success: function(data){

                                if (data.deletedId != 'FAILED')
                                {
                                    if (($('#invoiceNo').val()).length < 1 || isAllowedToChangeInv == 1) {
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
                    // $("#callListDeliveryDate").val();
                    $("#callListDeliveryDate").datepicker({
                        changeMonth: true,//this option for allowing user to select month
                        changeYear: true,
                        dateFormat: "dd-mm-yy" //this option for allowing user to select from year range
                    });
                    $("#callListOrderDate").datepicker({
                        changeMonth: true,//this option for allowing user to select month
                        changeYear: true //this option for allowing user to select from year range
                    });
                    $("#copyDeliveryDate").datepicker({
                        changeMonth: true,//this option for allowing user to select month
                        changeYear: true, //this option for allowing user to select from year range
                        dateFormat: "dd-mm-yyyy"
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
                    showDialog('#prodOnOrder','100%',800);
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
                $('#salesInvoiced').click(function(){
                    $('#prodonInvoice').show();
                    showDialog('#prodonInvoice','85%',640);
                    productsOnInvoiced();
                    $('#tblOnInvoiced tbody').on('click', 'tr', function (e){
                        $("#tblOnInvoiced tbody tr").removeClass('row_selected');
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
                    $('#callSpOnInvoiced').click(function(){
                        productsOnInvoiced();
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
                //$("#table").colResizable({liveDrag:true});
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
                                '<input type="hidden" id ="soldByWieght" class="soldByWieght" value="' +value.SoldByWeight + '" />' +
                                '<input type="hidden" id ="unitWeight"  class="unitWeight" value="' +value.UnitWeight + '" />' +
                                '<input type="hidden" id ="strBulkUnit"  class="strBulkUnit" value="' +value.strBulkUnit + '" />' +
                                '<input type="hidden" id ="ProductMargin"  class="ProductMargin" value="' +value.ProductMargin + '" />' +
                                '</td><td>'+
                                value.UnitSize+'</td></tr>';

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
                                '<input type="hidden" id ="soldByWieght" class="soldByWieght" value="' +value.SoldByWeight + '" />' +
                                '<input type="hidden" id ="unitWeight"  class="unitWeight" value="' +value.UnitWeight + '" />' +
                                '<input type="hidden" id ="strBulkUnit"  class="strBulkUnit" value="' +value.strBulkUnit + '" />' +
                                '<input type="hidden" id ="ProductMargin"  class="ProductMargin" value="' +value.ProductMargin + '" />' +
                                '</td><td>'+
                                value.UnitSize+'</td></tr>';
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
                                '<input type="hidden" id ="soldByWieght" class="soldByWieght" value="' +value.SoldByWeight + '" />' +
                                '<input type="hidden" id ="unitWeight"  class="unitWeight" value="' +value.UnitWeight + '" />' +
                                '<input type="hidden" id ="strBulkUnit"  class="strBulkUnit" value="' +value.strBulkUnit + '" />' +
                                '<input type="hidden" id ="strBulkUnit"  class="strBulkUnit" value="' +value.strBulkUnit + '" />' +
                                '<input type="hidden" id ="ProductMargin"  class="ProductMargin" value="' +value.ProductMargin + '" />' +
                                '<input type="hidden" id ="taxCode"  class="taxCode" value="' +value.Tax + '" />' +
                                '<td style="padding: 0px;">' +parseFloat(value.Qty).toFixed(2) + '</td><tr>';

                            inv = value.InvoiceNo

                        });
                        $('#pastInvoices').append(trHTML);

                        //data.contacts[0].
                        $.each(data.contacts, function (key,value){
                            $('#contactCellOnDispatch').val(value.CellPhone);
                            $('#contactPersonOnDispatch').val(value.BuyerContact);
                            $('#telOnDispatch').val(value.BuyerTelephone);
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
            function finishThis()
            {
                var orderlinesValidations = [];

                $('#table > tbody  > tr').each(function() {
                    var data = $(this);

                    var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                    var comment = $(this).closest('tr').find('.prodComment_').val();
                    //comment = comment.replace("'","");

                    console.debug($(this).closest('tr').find('.col2').val());
                    if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                        orderlinesValidations.push({
                            'productCode': escapeHtml($(this).closest('tr').find('.theProductCode_').val()),
                            'qty': $(this).closest('tr').find('.prodQty_').val(),
                            'price': $(this).closest('tr').find('.prodPrice_').val()
                        });
                    }
                });

                $.ajax({
                    url: '{!!url("/checkZeroCostOnOrder")!!}',
                    type: "POST",
                    data: {
                        OrderId: $('#orderId').val(),
                        orderlines: orderlinesValidations
                    },
                    success: function (data) {
                        if(data.result != "Nothing")
                        {
                            authorZeroCostOnSaving(data.data);
                        }else
                        {


                            $('<div></div>').appendTo('body')
                                .html('<div><h6>Yes or No?</h6></div>')
                                .dialog({
                                    modal: true,
                                    title: 'Click Yes to Print the Sales Order Or No to exit.',
                                    zIndex: 10000,
                                    autoOpen: true,
                                    width: '65%',
                                    resizable: false,
                                    buttons: {
                                        DelUser: {
                                            class: 'leftButton',
                                            text: 'Point Of Sale ',
                                            click: function () {
                                                allInoneDocumentsave("POS");

                                            }
                                        },
                                        Yes: function () {
                                            allInoneDocumentsave("YES");
                                        },
                                        No: function () {

                                            allInoneDocumentsave("NO");
                                        },
                                        PDF:function(){
                                            var dialog = $('<p><strong style="color:black"> Please wait...</strong></p>').dialog({
                                                height: 200, width: 700, modal: true, containment: false,
                                                buttons: {
                                                    "Okay": function () {
                                                        dialog.dialog('close');
                                                    }
                                                }
                                            });
                                            if (($('#invoiceNo').val()).length > 3) {
                                                window.open('{!!url("/pdforder")!!}/'+$('#orderId').val(), "PDF", "location=1,status=1,scrollbars=1, width=1200,height=850");
//View PDF
                                                disableOnFinish();
                                                $(this).dialog("close");
                                                $('#finishOrder').hide();
                                            } else {
                                                //finishArray2 -- use to be
                                                allInoneDocumentsave("PDF");
                                            }

                                            $(this).dialog("close");
                                        }

                                    },
                                    close: function (event, ui) {
                                        $(this).remove();
                                    }
                                });
                        }


                    }
                });


            }

            function PosDialog()
            {
                console.debug("I am inside POS");
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

                        //waitingInvoice();
                        //( waitingInvoice , 8000 );
                    }

                });
            }
            function PL()
            {
                $.ajax({
                    url: '{!!url("/productPriceLookUp")!!}' ,
                    type: "POST",
                    data:{productCode:$('#productCodePl').val(),
                        customerCode:$('#custCodePl').val(),
                        prodId:$('#prodId').val(),
                        custId:$('#custId').val(),
                    },
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
                        $('#currentCustomerPrices tbody').empty();
                        $.each(data.currentPrices, function (key, value) {
                            trHTML += '<tr  class="rebuild_price_check_list" style="font-size: 10px;color:black"><td>' +
                                value.ProductId + '</td><td><strong>' +
                                value.info + '</strong></td><td>' +
                                (parseFloat(value.Price)).toFixed(2) + '</td><td>' +
                                '</td></tr>';
                        });
                        $('#currentCustomerPrices').append(trHTML);

                        var trHTML = '';
                        $('#individualCost tbody').empty();

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

                    }
                });
            }
            function productsOnOrder()
            {
                $.ajax({
                    url: '{!!url("/productsOnOrder")!!}',
                    type: "POST",
                    data: {
                        productCode: $('#productCodeOnOrder').val(),
                        customerCode: $('#custCodeOnOrder').val(),
                    },
                    success: function (data) {
                        console.log(data);
                        getGrid(data);
                    }
                });


                // productsOnOrders = $('#tblOnsalesOrder').DataTable({
                //     "ajax": {
                //         url: '{!!url("/productsOnOrder")!!}', "type": "post", data: function (data) {
                //             data.productCode = $('#productCodeOnOrder').val();
                //             data.customerCode = $('#custCodeOnOrder').val();
                //         }
                //     },
                //     "columns": [
                //         {"data": "OrderId", "class": "small", "bSortable": true},
                //         {"data": "OrderDate", "class": "small"},
                //         {"data": "DeliveryDate", "class": "small"},
                //         {"data": "CustomerPastelCode", "class": "small"},
                //         {"data": "StoreName", "class": "small"},
                //         {"data": "AwaitingStock", "class": "small"},
                //         {"data": "Qty", "class": "small",
                //             render:function(data, type, row, meta) {
                //                 // check to see if this is JSON
                //                 try {
                //                     var jsn = JSON.parse(data);
                //                     //console.log(" parsing json" + jsn);
                //                 } catch (e) {

                //                     return jsn.data;
                //                 }
                //                 return parseFloat(jsn).toFixed(2);

                //             } ,"bSortable": true },

                //         {"data": "InStock", "class": "small"},
                //         {"data": "PastelCode", "class": "small"},
                //         {"data": "PastelDescription", "class": "small"},
                //         {"data": "Comment", "class": "small"},
                //         {"data": "NettPrice", "class": "small",
                //             render:function(data, type, row, meta) {
                //                 // check to see if this is JSON
                //                 try {
                //                     var jsn = JSON.parse(data);
                //                     //console.log(" parsing json" + jsn);
                //                 } catch (e) {

                //                     return jsn.data;
                //                 }
                //                 return parseFloat(jsn).toFixed(2);

                //             } ,"bSortable": true },
                //         {"data": "Backorder", "class": "small"}

                //     ],
                //     "deferRender": true,
                //     "scrollY": "300px",
                //     "scrollCollapse": true,
                //     searching: true,
                //     bPaginate: false,
                //     bFilter: false,
                //     "LengthChange": false,
                //     "info": false,
                //     "destroy": true
                // });
            }

            function getGrid(data){
                $("#gridContainer").dxDataGrid({

                            dataSource:data, //as json
                            hoverStateEnabled: true,
                            showBorders: true,
                            filterRow: { visible: true },
                            allowColumnResizing: true,
                            columnAutoWidth: true,
                            width: "100%",
                            scrolling: {
                                showScrollbar: 'always',
                                useNative: false,
                                scrollByThumb: true
                            },
                            paging: {
                                enabled: false
                            },
                            export: {
                                enabled: true
                            },
                            editing: {
                                mode: 'single',
                                // allowUpdating: true,
                                allowDeleting: true,
                            },
                            selection: {
                                mode: 'batch',
                            },
                            onExporting(e) {
                                const workbook = new ExcelJS.Workbook();
                                const worksheet = workbook.addWorksheet('On_Order');

                                DevExpress.excelExporter.exportDataGrid({
                                    component: e.component,
                                    worksheet,
                                    autoFilterEnabled: true,
                                }).then(() => {
                                    workbook.xlsx.writeBuffer().then((buffer) => {
                                        saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'On_Order.xlsx');
                                    });
                                });
                                e.cancel = true;
                            },

                            columns: [
                                {
                                    dataField: "OrderId",
                                    caption: "Order Id",
                                    width:100

                                },{
                                    dataField: "OrderDetailId",
                                    caption: "Order Detail Id",
                                    visible: false,
                                },{
                                    dataField: "OrderDate",
                                    caption: "Order Date",
                                    cellTemplate: function(cellElement, cellInfo) {
                                        cellElement.addClass('custom-font');
                                        cellElement.text(cellInfo.text);
                                    },
                                    width:80
                                },{
                                    dataField: "DeliveryDate",
                                    caption: "Delivery Date",
                                    width:80,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        cellElement.addClass('custom-font');
                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "CustomerPastelCode",
                                    caption: "Cust Code",
                                    width:100,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        cellElement.addClass('custom-font');
                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "StoreName",
                                    caption: "Store Name",
                                    width:380,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        cellElement.addClass('custom-font');
                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "AwaitingStock",
                                    caption: "Awaiting Stock",
                                    width:60,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        cellElement.addClass('custom-font');
                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "Qty",
                                    caption: "Qty",
                                    width:80,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        cellElement.addClass('custom-font');
                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "InStock",
                                    caption: "In Stock",
                                    width:80,
                                    format: {
                                        type: "fixedPoint",
                                        precision: 3
                                    },
                                    customizeText: function(cellInfo) {
                                        return Number(cellInfo.value).toFixed(3);
                                    }
                                },{
                                    dataField: "PastelCode",
                                    caption: "Prod Code",
                                    width:100,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        cellElement.addClass('custom-font');
                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "PastelDescription",
                                    caption: "Prod Description",
                                    width:280,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        cellElement.addClass('custom-font');
                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "Comment",
                                    caption: "Comment",
                                    width:100,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        cellElement.addClass('custom-font');
                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "NettPrice",
                                    caption: "Nett",
                                    width:100,
                                    format: {
                                        type: "fixedPoint",
                                        precision: 2
                                    },
                                    customizeText: function(cellInfo) {
                                        return Number(cellInfo.value).toFixed(2);
                                    }
                                },{
                                    dataField: "Backorder",
                                    caption: "Back Order",
                                    width:100,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        cellElement.addClass('custom-font');
                                        cellElement.text(cellInfo.text);
                                    }
                                },
                            ],
                            onRowDblClick: function(e){
                                var invNum = e.data.OrderId
                                $('#invoiceNo').val(invNum);
                                $('#orderIds').val(invNum);
                                $('#orderId').val(invNum);
                                $('#checkOrders').click();
                                $('#prodOnOrder').dialog('close');
                            },
                                onRowPrepared(e) {
                                    if (e.rowType == 'data' && e.data.dataField =="1") {
                                        e.rowElement.css('background', 'rgb(155, 236, 248)');
                                    }
                                },

                                onRowRemoving: function(e) {
                                    var OrderDetailId = e.data.OrderDetailId;
                                    if (e.rowType == 'data' && e.data.AwaitingStock =="1") {
                                        console.debug("orderdetail Id ____________" + OrderDetailId);
                                        $.ajax({
                                            url: '{!!url("/deleteOrderLinedetails")!!}',
                                            type: "POST",
                                            data: {
                                                OrderId: OrderDetailId,
                                            },
                                            success: function (data) {
                                                alert(data[0]['Result']);
                                            }
                                        });
                                    }else{
                                        alert("Sorry, you cannot delete the line because it is not a stock item that is Awaiting Stock.");
                                    }
                                }
                        });
            }
            function productsOnInvoiced()
            {
                productsOnOrders = $('#tblOnInvoiced').DataTable({
                    "ajax": {
                        url: '{!!url("/productsOnInvoiced")!!}', "type": "post", data: function (data) {
                            data.productCode = $('#productCodeOnInvoice').val();

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
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel'
                    ],
                    "LengthChange": false,
                    "info": false,
                    "destroy": true
                });
            }
            function show_hide_row(row)
            {
                $("."+row).toggle();
            }
            $(document).on("dblclick","#callListTable tbody tr",function() {
                // alert('Row dblclicked');
                //$('#callListTable tbody').on('dblclick', 'tr', function () {
                // var productCode = $(this).find(".foo").val();
                var $this = $(this);
                var row = $this.closest("tr");
                var custDescr = row.find('td:eq(1)').text();
                var custCode = row.find('td:eq(0)').text();
                var Disc = row.find('td:eq(9)').text();
                var custRouteId = row.find('td:eq(10)').text();
                var custRouteName = row.find('td:eq(6)').text();
                var notes = row.find(".notes").val();//
                var custids = row.find(".custids").val();//

                if($('#orderId').val().length > 3){
                    alert('There is Currently an order Opened Please Close it !');
                }
                else {
                    $('#createOrderOnCallList').show();
                    showDialog('#createOrderOnCallList',900,200);
                    $('#yesOnCreatingOrderFromCallList').click(function(){

                        $('#inputCustAcc').val(custCode);
                        $('#inputCustName').val(custDescr);
                        $('#hiddenCustDiscount').val(Disc);
                        $('#inputDeliveryDate').val($('#callListDeliveryDate').val());
                        $('#inputOrderDate').val($('#callListOrderDate').val());
                        $('#routeonabutton').val(custRouteName);
                        $('#Routeid').val(custRouteId);
                        $('#CustomerId').val(custids);

                        /* if(submitAttemt < 2)
                     {

                     submitAttemt++
                     }*/
                        $("#submitFilters").click();

                        $('#callListDialog').dialog("close");
                        $('#createOrderOnCallList').dialog("close");
                        called('{!!url("/isCalled")!!}',$('#callListDeliveryDate').val(),custCode,'0',notes);
                        row.hide();
                    });
                    $('#noOnCreatingOrderFromCallList').click(function(){
                        $('#createOrderOnCallList').dialog("close");
                    });

                }

                // });
            });

            function callList()
            {
                $.ajax({
                    url: '{!!url("/getCallList")!!}',
                    type: "POST",
                    data:{
                        userId:$('#callListUser').val(),
                        routeId:$('#routeToFilterWith').val(),
                        OrderDate:$('#callListOrderDate').val(),
                        deliveryDate:$('#callListDeliveryDate').val(),
                        UserName:$('#callListUser').find("option:selected").text(),
                        routeName:$('#routeToFilterWith').find("option:selected").text()

                    },
                    success: function(data){
                        var trHTML = '';

                        $('.fast_removeCallList').empty();
                        $.each(data, function (key,value) {

                            var tokenIdn=parseInt(Math.random()*1000000000, 10);
                            // alert(tokenIdn);
                            trHTML +='<tr role="row" class="fast_removeCallList"  style="font-size: 9px;color:black"><td>'+
                                value.CustomerPastelCode +'</td><td>'+
                                $.trim(value.StoreName) +'</td><td>'+
                                '<input type="checkbox"  name="called" style="width:18px;height:15px !important" value="'+value.CustomerPastelCode+'" onclick="javascript: SelectallColorsForStyle(this, value,'+tokenIdn+');" ></td><td>'+
                                value.ContactPerson +'</td><td>' +
                                value.BuyerTelephone +'</td><td>' +
                                value.CellPhone +'</td><td>' +
                                value.Routeid +'</td><td>'+
                                value.BuyerContact +'</td><td>' +
                                value.LocationID +'</td><td>' +
                                value.Discount +'</td><td>' +
                                value.custRouteId +'</td><td><input type="text" id="'+tokenIdn +'" class="notes"><input type="hidden" value="'+value.CustomerId +'" class="custids"></td>' +
                                '</tr>';
                        });
                        $('#callListTable').append(trHTML);
                        console.debug("check how many times i get called+++++++++++++++++++++++++++++");


                        $('#callListTable tbody').on('click', 'tr', function (e){
                            $("#callListTable tbody tr").removeClass('row_selectedYellowish');
                            $(this).addClass('row_selectedYellowish');
                        });

                    }
                });

            }
            function confirmmultideliveryaddressonfinish(){
                console.debug("******************************* Routing ID "+$('#hiddenDeliveryAddressIdAfterSaved').val());


                $.ajax({
                    url: '{!! url("/selectCustomerMultiAddressconfirm") !!}',
                    type: "POST",
                    data: {
                        customerCode: $("#inputCustAcc").val(),
                        OrderId:  $('#orderId').val()
                    },
                    success: function (data) {
                        var toAppend = '';
                        var routnamereturn="";
                        var routeidreturn ="";
                        $('#listaddresses').empty();
                        $(".generalRouteForNewDeliveryAddress").empty();
                        $.each(data.addresses, function (i, o) {
                            toAppend += '<li value="' + o.DeliveryAddressID + '" style="border-bottom: 4px solid black;">' + o.DAddress1 + ' ' + o.DAddress2 + ' ' + o.DAddress3 + '<br>' + o.DAddress4 + '<br>' + o.DAddress5 + '</li>';
                        });
                        $('#listaddresses').append(toAppend);
                        $('#changeDeliveryAddress').show();
                        $('#dynamicaddress').empty();
                        $('#doneCustomAddress').empty();
                        $.each(data.selectedaddress, function (i, o) {
                            routnamereturn = o.Route;
                            routeidreturn = o.Routeid;
                            $('#address1').val(o.DAddress1);
                            $('#address2').val(o.DAddress2);
                            $('#address3').val(o.DAddress3);
                            $('#address4').val(o.DAddress4);
                            $('#address5').val(o.DAddress5);
                        });
                        $('.generalRouteForNewDeliveryAddress').prepend('<option value="'+routeidreturn+'"  selected="selected">'+routnamereturn+'</option>');

                        var toAppendr = '';
                        $.each(data.routes,function(i,o){
                            toAppendr += '<option value="'+o.Routeid+'">'+o.Route+'</option>';
                        });

                        $('.generalRouteForNewDeliveryAddress').append(toAppendr);

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
                            $('.generalRouteForNewDeliveryAddress').prepend('<option value="'+$(this).closest('tr').find('#hiddenRouteId').val()+'" selected="selected">'+$(this).closest('tr').find('td').eq(1).text()+'</option>');
                            $('#deliveryAddressIdOnPopUp').val($(this).closest('tr').find('#hiddenDeliveryAddressIdAfterSaved').val());
                        });

                        var $input = $('<button type="button" id="updateaddresses">UPDATE</button> <button type="button" style="float:right;" id="ignoresave">IGNORE</button>');
                        $input.appendTo($("#dynamicaddress"));
                        $('#updateaddresses').click(function () {
                            var routeidselect = $('#generalRouteForNewDeliveryAddress').val();

                            if($('#generalRouteForNewDeliveryAddress').val() === 'null' || routeidselect.length < 1 )
                            {
                                alert('The RouteID/Route Name is not correct,Please Choose the Route Or Speak to the manager.');

                            }else
                            {
                                var selectedAddress = new Array();
                                selectedAddress.push({
                                    'orderId': $('#orderId').val(),
                                    'DeliveryAddressID': $('#hiddenDeliveryAddressId').val(),
                                    'routeid': $('.generalRouteForNewDeliveryAddress').val(),
                                    'address1': (escapeHtml($('#address1').val())),
                                    'address2': (escapeHtml($('#address2').val())),
                                    'address3':( escapeHtml($('#address3').val())),
                                    'address4': (escapeHtml($('#address4').val())),
                                    'address5': (escapeHtml($('#address5').val()))

                                });

                                $.ajax({
                                    url: '{!! url("/submitchangeddeliveryaddress") !!}',
                                    type: "POST",
                                    data: {

                                        OrderId: $('#orderId').val(),
                                        delvdata:selectedAddress

                                    },success: function (data) {
                                        console.debug(data[0]);
                                        if(data[0].results =="SUCCESS"){
                                            var dialog = $('<p><strong style="color:black">Updated To Address ID #'+$('#hiddenDeliveryAddressId').val()+' </strong></p>').dialog({
                                                height: 200, width: 700, modal: true, containment: false,
                                                buttons: {
                                                    "Okay": function () {
                                                        dialog.dialog('close');
                                                    }

                                                }
                                            });
                                            if(hassplitorder =="LTRUE"){
                                                splitorder();
                                            }else{
                                                disableOnFinish();
                                            }

                                        }

                                        //console.debug(data);

                                    }
                                });


                            }


                        });

                        $('#ignoresave').click(function(){
                            if(hassplitorder =="LTRUE"){
                                splitorder();
                            }else{
                                $.ajax({
                                    url: '{!!url("/clearorderlocksperorder")!!}',
                                    type: "POST",
                                    data: {
                                        OrderId: $('#orderId').val()
                                    },
                                    success: function (data) {
                                        empties();
                                        location.reload();

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
                                printDoc('{!!url("/intoTblPrintedDoc")!!}',1,orderID,0,$('#invoiceNo').val());
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

            function SelectallColorsForStyle(e, val,note) {
                console.debug("e.value//////"+e.value);
                console.debug("val***+-//////"+note);
                $.ajax({
                    url: '{!!url("/isCalled")!!}',
                    type: "POST",
                    data: {
                        CustomerCode: e.value,
                        DeivDate: $('#callListDeliveryDate').val(),
                        Show:"0",
                        DeliveryAddressId: "0", notes:$('#'+note).val()
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
                // $( "#table" ).colResizable({ disable : true });
                // var styleAnony = ""
                calculator();

                if (multiLines ==1)
                {
                    var classAnonymouscols="anonymouscols";
                }else
                {
                    var classAnonymouscols="anonymouscolsOff";
                }


                var tokenId=new Date().valueOf();
                var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
                    '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_'+tokenId+'" style="font-weight:900;border: 2px solid gray;" class="theProductCode_ set_autocomplete inputs"><br><input name="col1" id ="col1'+tokenId+'" class="col1 '+classAnonymouscols+'"  readonly></td>' +
                    '<td contenteditable="false" class="col-md-4"><input name="prodDescription_" id ="prodDescription_'+tokenId+'" class="prodDescription_ set_autocomplete inputs" style="font-weight:900;border: 2px solid gray;font-size:10px" tabindex="-1"><br>' +
                    '<input name="col8" id ="col8'+tokenId+'" class="col8 '+classAnonymouscols+ '" readonly></td>' +
                    '<td style=""  contenteditable="false" class="col-md-1"><input type="text" name="prodBulk_"  id ="prodBulk_'+tokenId+'" class="prodBulk_ resize-input-inside" onkeypress="return isFloatNumber(this,event)" ><br><input name="col3" id ="col3'+tokenId+'" class="col3 '+classAnonymouscols+'"  readonly></td>' +

                    '<td  contenteditable="false" class="col-md-1"><input type="text" name="prodQty_" id ="prodQty_'+tokenId+'"   onkeypress="return isFloatNumber(this,event)" title="in stock" class="prodQty_ resize-input-inside inputs"><input name="col4" id ="col4'+tokenId+'" class="col4 '+classAnonymouscols+'"  readonly></td>' +
                    '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" >' +
                    '<div style="display: initial;" data-value="'+tokenId+'"></div></td>' +
                    '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodDisc_" id ="prodDisc_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside inputs" {{$discountProperty}}><input name="col6" id ="col6'+tokenId+'" class="col6 '+classAnonymouscols+'"  style="color: brown;" readonly></td>' +
                    '<td  contenteditable="false"  class="col-md-1"><input  type="text" name="prodUnitSize_" id ="prodUnitSize_'+tokenId+'" class="prodUnitSize_ resize-input-inside" ><input name="col7" id ="col7'+tokenId+'" class="col7 '+classAnonymouscols+'" readonly></td>' +
                    '<td contenteditable="false" style="display: flex;" class="col-md-1"><input type="text" name="instockReadOnly" id ="instockReadOnly_' + tokenId + '" class="instockReadOnly_ resize-input-inside inputs" style="font-weight: 800;color:blue;font-size:8px !important;width: 54px;"><input type="text" name="shelf" id ="shelf_' + tokenId + '" class="shelf_ resize-input-inside " style="font-weight: 800;color:red;font-size:8px !important;width: 54px;float:right;"><select name="col2" id ="col2'+tokenId+'" class="col2 '+classAnonymouscols+'" ></select></td>' +
                    '<td contenteditable="false"  class="col-md-1"><input type="text" name="clcstock" id ="clcstock_' + tokenId + '" class="clcstock_ resize-input-inside inputs" style="font-weight: 800;color:blue;font-size:8px !important"></td>' +
                    '<td contenteditable="false"  class="col-md-1"><input type="text" name="additionalcost" id ="additionalcost_' + tokenId + '" class="additionalcost_ resize-input-inside inputs" style="font-weight: 800;color:blue;font-size:8px !important"></td>' +
                    '<td  contenteditable="false" class="col-md-3"><input type="text" name="prodComment_" id ="prodComment_'+tokenId+'" class="prodComment_ resize-input-inside lst inputs"><input name="col9" id ="col9'+tokenId+'" class="col9 '+classAnonymouscols+'"  readonly></td>' +
                    '<td><input type="hidden" id="title_'+tokenId+'" class="title" value="'+isAuthMyLine+'" /><input type="hidden" id="theOrdersDetailsId" value="" /><input type="hidden" id ="taxCode'+tokenId+'" value="" class="taxCodes" />' +
                    '<input type="hidden" id ="cost_'+tokenId+'" value="" class="costs" /><input type="hidden" id ="inStock_'+tokenId+'" value="" class="inStock" /><input type="hidden" value ="'+tokenId+'" class="hiddenToken" />' +
                    '<input type="hidden" id ="priceholder_'+tokenId+'" value="" class="priceholder" />' +
                    '<input type="hidden" id ="alcohol_'+tokenId+'" value="" class="alcohol" /><input type="hidden" id ="margin_'+tokenId+'" value="" class="margin" />' +
                    '<input type="hidden" id ="prohibited_' + tokenId + '" value="" class="prohibited" />' +
                    '<input type="hidden" id ="soldByWieght' + tokenId + '" value="" class="soldByWieght" />' +
                    '<input type="hidden" id ="unitWeight' + tokenId + '" value="" class="unitWeight" />' +
                    '<input type="hidden" id ="strBulkUnit' + tokenId + '" value="" class="strBulkUnit" />' +
                    '<input type="hidden" id ="productmarginauth' + tokenId + '" value="0" class="productmarginauth" />' +
                    '<input type="hidden" id ="stockmanagement' + tokenId + '" value="0" class="stockmanagement" />' +
                    '<button type="button" id="cancelThis" class="btn-danger btn-xs cancel" style="height: 16px;padding: 0px 5px;font-size: 9px;">Cancel</button></td></tr>');
                $('#table tbody')
                    .append( $row )
                    .trigger('addRows', [ $row, false ]);

                var txt = $("#headerWh option:selected").text();
                var val = $("#headerWh option:selected").val();
                $("#col2"+tokenId).append("<option value='"+val+"'>" + txt + "</option>");
                $.each(wareautocomplete, function (i, item) {
                    $("#col2"+tokenId).append("<option value='"+item.ID+"'>" + item.Warehouse + "</option>");
                });

                if(!$('.lst').is(":focus"))
                {
                    $('#prodCode_' + tokenId).focus();

                    if ($('#checkboxDescription').is(':checked')) {
                        $('#prodDescription_' + tokenId).focus();
                    }
                }

                /* $('.col2 ').on('click keyup' ,function(){
            var warehCols =  [{name: 'ID', minWidth:'230px',valueField: 'value'},
                ,{name: 'Warehouse', minWidth:'20px',valueField: 'Warehouse'}];
            $(""+jID+"").mcautocomplete({
                source: finalDataProductTest,
                columns:columnsD,
                autoFocus: true,
                minlength: 2,
                delay: 0,
                multiple: true,
                multipleSeparator: ",",
                select:function (e, ui) {

                }
            });
        });*/

                $('input').on('click keyup' ,function(){
                    // $('input').click(function(){
                    console.debug( $(this));
                    var ID = $(this).attr('id');
                    var jID = '#'+ID;
                    console.debug("ID---------------------------------"+ID);
                    var x = ID.indexOf("_");
                    var get_token_number = ID.substring(x+1,ID.length);


                    if ($(this).hasClass("prodDescription_") && $(this).hasClass("set_autocomplete")) {
                        var columnsD = [{name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                            {name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'}
                            ,{name: 'Available', minWidth:'20px',valueField: 'Available'}];
                        $(""+jID+"").mcautocomplete({
                            source: finalDataProductTest,
                            columns:columnsD,
                            autoFocus: true,
                            minLength: searchstring,
                            delay: 2,
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
                                $('#prodDescription_' + token_number).prop('title', ui.item.PastelDescription);
                                $('#prodCode_' + token_number).val(ui.item.PastelCode);
                                //checkIfOrderHasMultipleProducts(ui.item.extra,token_number);
                                $('#prodQty_' + token_number).val('');

                                $('#table').find('#prodQty_' + token_number).focus();
                                $('#prodUnitSize_' + token_number).val(ui.item.UnitSize);
                                //   $('#instockReadOnly_' + token_number).val(ui.item.QtyInStock);
                                $('#taxCode' + token_number).val(ui.item.Tax);
                                $('#cost_' + token_number).val(ui.item.Cost);
                                $('#inStock_' + token_number).val(ui.item.Available);
                                $('#shelf_' + token_number).val( ui.item.Available);
                                $('#soldByWieght' + token_number).val(ui.item.SoldByWeight);
                                $('#unitWeight' + token_number).val(ui.item.UnitWeight);
                                $('#strBulkUnit' + token_number).val(ui.item.strBulkUnit);
                                $('#margin_' + token_number).val(ui.item.Margin);


                                if($.trim(ui.item.SoldByWeight) == "1")
                                {
                                    $('#table').find('#prodBulk_' + token_number).focus();
                                    $('#prodBulk_' + token_number).addClass('inputs');
                                    $('#prodBulk_' + token_number).addClass('addgreen');

                                }else
                                {
                                    $('#prodBulk_' + token_number).prop('readonly', true);
                                    $('#prodBulk_' + token_number).val(0);
                                }
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


                            }
                        });

                    }

                    if ($(this).hasClass("theProductCode_") && $(this).hasClass("set_autocomplete")) {
                        var columnsC = [{name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'},
                            {name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'}
                            ,
                            {name: 'Available', minWidth:'20px',valueField: 'Available'}];
                        $("" + jID + "").mcautocomplete({
                            //source: finalDataProduct,
                            source: function(req, response) {
                                var re = $.ui.autocomplete.escapeRegex(req.term);
                                var matcher = new RegExp("^" + re, "i");
                                response($.grep(finalDataProduct, function(item) {
                                    return matcher.test(item.value);
                                }));
                            },
                            columns:columnsC,
                            minlength: 1,
                            autoFocus: true,
                            delay: 0,
                            select:function (e, ui) {

                                var n = ID.indexOf("_");
                                var token_number = ID.substring(n + 1, ID.length);

                                $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                                $('#prodDescription_' + token_number).prop('title', ui.item.PastelDescription);
                                $('#prodCode_' + token_number).val(ui.item.PastelCode);
                                //checkIfOrderHasMultipleProducts(ui.item.extra,token_number);
                                $('#prodQty_' + token_number).val('');
                                $('#prodQty_' + token_number).focus();
                                //$('#inStock_' + token_number).val(ui.item.QtyInStock);
                                $('#table').find('#prodQty_' + token_number).focus();
                                $('#prodUnitSize_' + token_number).val(ui.item.UnitSize);
                                //$('#instockReadOnly_' + token_number).val(ui.item.QtyInStock);
                                $('#taxCode' + token_number).val(ui.item.Tax);
                                $('#cost_' + token_number).val(ui.item.Cost);
                                $('#inStock_' + token_number).val(ui.item.Available);
                                $('#shelf_' + token_number).val(ui.item.Available);
                                $('#soldByWieght' + token_number).val(ui.item.SoldByWeight);
                                $('#unitWeight' + token_number).val(ui.item.UnitWeight);
                                $('#strBulkUnit' + token_number).val(ui.item.strBulkUnit);
                                $('#margin_' + token_number).val(ui.item.Margin);
                                if($.trim(ui.item.SoldByWeight) == "1")
                                {
                                    $('#table').find('#prodBulk_' + token_number).focus();
                                    $('#prodBulk_' + token_number).addClass('inputs');
                                    $('#prodBulk_' + token_number).addClass('addgreen');
                                }else
                                {
                                    $('#prodBulk_' + token_number).prop('readonly', true);
                                    $('#prodBulk_' + token_number).val(0);
                                }
                                // $('#prodQty_' + token_number).attr('title', 'In Stock ' + parseFloat(ui.item.QtyInStock).toFixed(3));

                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                productPrice(token_number);

                            }

                        });
                    }
                    calculator();
                });

            }


            function calcAdditionalCost()
            {

                console.log("I am logging this things");
                $('#table tbody tr').each(function() {
                    //

                    $(this).find(".theProductCode_").each(function() {
                        var totalAddCst = 0;
                        var $this =$(this).closest('tr');
                        var mQty = $this.find('.prodQty_').val();
                        var productCode = $this.find('.theProductCode_').val();


                        if( $.trim((productCode)).length > 1 &&  parseFloat(mQty)  > 0){
                            $.ajax({
                                url: '{!!url("/associatedItem")!!}',
                                type: "POST",
                                data: {
                                    productCode: productCode,
                                    customerCode: $('#inputCustAcc').val(),
                                    delDate: $('#inputDeliveryDate').val(),
                                },
                                success: function (data) {


                                    if (!$.trim(data)){

                                        $this.find(".additionalcost_").val(parseFloat(0) );
                                        totalAddCst = totalAddCst + parseFloat(0);
                                        // $('#totaddidtionalcst').val(totalAddCst);
                                    }
                                    else{
                                        console.debug('tot '+ mQty*data[0].Price);
                                        $this.find(".additionalcost_").val(parseFloat(mQty*data[0].Price) );
                                        totalAddCst = totalAddCst + parseFloat(mQty*data[0].Price);
                                        //   $('#totaddidtionalcst').val(totalAddCst);
                                    }
                                }
                            });

                        }
                    });

                });

            }

            function focusoutcaladditionalcost(productCode,mQty,$this)
            {

                //  var totalAddCst = 0;
                // var $this =$(this).closest('tr');
                //  var mQty = $this.find('.prodQty_').val();
                // var productCode = $this.find('.theProductCode_').val();


                if( $.trim((productCode)).length > 1 &&  parseFloat(mQty)  > 0){
                    $.ajax({
                        url: '{!!url("/associatedItem")!!}',
                        type: "POST",
                        data: {
                            productCode: productCode,
                            customerCode: $('#inputCustAcc').val(),
                            delDate: $('#inputDeliveryDate').val(),
                        },
                        success: function (data) {
                            if( !$.trim(data)) {

                                $('#' + $this).val(parseFloat(0));
                            }else{
                                console.debug('tot ' + mQty * data[0].Price);
                                $('#' + $this).val(parseFloat(mQty * data[0].Price));
                            }
                            // totalAddCst = totalAddCst + parseFloat(mQty*data[0].Price);
                            //$('#totaddidtionalcst').val(totalAddCst);
                        }
                    });

                }

            }
            function calculator()
            {

                var arrayPrice = [];
                var arrayPrice = [];
                var arrayQty = [];
                var arrayDisc = [];
                var arrayPriceInc = [];
                var arrayProductsCode = [];
                var cost = [];
                var sumTotalCost = 0.00;
                var totalPrice = 0.00;
                var totalPriceDisc = 0;
                $('#table tbody tr').each(function() {

                    var valuesPrice = [];
                    var valuesQty = [];
                    var valuesDisc = [];
                    var valuesPriceInc = [];
                    var valuesProdCodes = [];
                    var valuesCost = [];


                    $(this).find(".prodPrice_").each(function(){
                        valuesPrice.push($(this).val());
                        var mQty = $(this).closest('tr').find('.prodQty_').val();
                        var myTDisc = $(this).closest('tr').find('.prodPrice_').val();

                        if($.trim($(this).val()) !='')
                        {
                            totalPriceDisc = (parseFloat($(this).val())* parseFloat(mQty)) *((100-myTDisc)/100) ;
                            totalPrice = parseFloat(totalPrice) + totalPriceDisc ;
                            console.debug('Total Price *****************'+totalPrice);
                            console.debug('Total Price *****************totalPriceDisctotalPriceDisctotalPriceDisctotalPriceDisc'+totalPriceDisc);
                            //valuesProdCodes.push($(this).val());
                        }
                    });
                    $(this).find(".prodQty_").each(function(){
                        valuesQty.push($(this).val());
                    });
                    $(this).find(".prodDisc_").each(function(){
                        if ($.trim(($(this).val())).length < 1)
                        {
                            valuesDisc.push(0);
                        }
                        else
                        {
                            valuesDisc.push($(this).val());
                        }

                    });
                    $(this).find(".taxCodes").each(function(){
                        valuesPriceInc.push($(this).val());
                    });
                    $(this).find(".theProductCode_").each(function(){

                        if($.trim($(this).val()) !='')
                        {

                            arrayProductsCode.push($(this).val());
                        }

                    });
                    $(this).find(".costs").each(function(){
                        var mQty = $(this).closest('tr').find('.prodQty_').val();
                        if($.trim($(this).val()) !='') {
                            sumTotalCost = parseFloat(sumTotalCost) + (parseFloat($(this).val()) * parseFloat(mQty) );
                        }
                        //valuesCost.push($(this).val());
                    });

                    arrayPrice.push(valuesPrice);
                    arrayQty.push(valuesQty);
                    arrayDisc.push(valuesDisc);
                    arrayPriceInc.push(valuesPriceInc);
                    //cost.push(valuesCost);

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
                var arPriceInclusiveDisc=[];
                for(var i = 0; i < arrayPrice.length; i++){
                    var valu = ((arrayPrice[i]* ((100-arrayDisc[i])/100)) * arrayQty[i])*(arrayPriceInc[i]/100) + ((arrayPrice[i] * ((100-arrayDisc[i])/100)) * arrayQty[i]);
                    // console.debug("valu***************************valu"+valu);
                    arPriceInclusiveDisc[i] = valu;
                }
                var totalCost = sumTotalCost;

                var totalMargin = marginCalculator(totalCost,totalPrice);

                var sumarray = eval((ar3).join("+"));
                var sumPriceInc = eval((arPriceInclusive).join("+"));
                var sumPriceIncDisc = eval((arPriceInclusiveDisc).join("+"));
                var sumarrayOnInclusiveForDiscount = (sumPriceInc - parseFloat((parseFloat($('#dicPercHeader').val())/100) * sumPriceInc) ).toFixed(2);
                var sumarrayOnInclusiveForDiscountAndLineDisc = (sumPriceIncDisc - parseFloat((parseFloat($('#dicPercHeader').val())/100) * sumPriceIncDisc) ).toFixed(2);
                var sumarrayOnExclusiveForDiscount = (sumarray - parseFloat((parseFloat($('#dicPercHeader').val())/100) * sumarray) ).toFixed(2);

                $('#numberOfLines').empty();

                $('#numberOfLines').append(arrayProductsCode.length);
                $('#totalEx').val(parseFloat(sumarrayOnExclusiveForDiscount).toFixed(2));
                $('#totalInc').val(parseFloat(sumarrayOnInclusiveForDiscount).toFixed(2));
                $('#totalInOrder').val(parseFloat(sumarrayOnInclusiveForDiscountAndLineDisc).toFixed(2));
                $('#totalmargin').val(totalMargin.toFixed(2));
                // calcAdditionalCost();

                // console.debug("array sum" + sumarray.toFixed(2));
                //console.debug("array sum" + sumPriceInc.toFixed(2));
                var crLimit = parseFloat($('#totalInc').val()) + parseFloat($('#balDue').val());
                $('#creditLimitWarningMessage').empty();
                if (crLimit > $('#creditLimit').val()) {
                    var difference  = crLimit - $('#creditLimit').val();
                    $('#creditLimitWarningMessage').append('CREDIT LIMIT REACHED : '+difference.toFixed(2));
                    // console.debug('CREDIT LIMIT REACHED : '+difference.toFixed(2));
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
                            data.CustomerId = $('#CustomerId').val();
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
                        { "data": "Remaining","class":"small" },
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
                        { "data": "UnitSize","class":"small"  },
                        { "data": "UnitWeight","class":"small"  },
                        { "data": "SoldByWeight","class":"small"  },
                        { "data": "strBulkUnit","class":"small"  },
                        { "data": "ProductMargin","class":"small"  }

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
                    initComplete: function() {
                        $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'this-is');
                    },
                    autoFill: false,

                } );
                //  datatableOrderPattern.columns([6]).visible(false);
                $('#orderPatternIdTable_filter input').attr('autocomplete', 'this-is');
                // var formid=$(this).parents('td').prev().text().match(/[a-zA-Z]{,4}/);
                $('#orderPatternIdTable_filter input').attr("id","thiswwwwwwwwwwwwwwwwww");
                $('#orderPatternIdTable_filter input').prop('readonly', true);

                $( "#thiswwwwwwwwwwwwwwwwww" ).click(function(e) {
                    e.preventDefault();
                    $('#thiswwwwwwwwwwwwwwwwww').removeAttr('readonly');
                    console.debug("this is it*********************______");
                });


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
                    "bDestroy": true,
                    dom: 'Bfrtip',
                    buttons: [
                        'copy',
                        {
                            extend: 'csv', className: 'btn-primary',
                            title: 'Dims User Actions #'+$('#orderId').val()
                        },
                        {
                            extend: 'excel', className: 'btn-primary',
                            title: 'Dims User Actions #'+$('#orderId').val()
                        },
                        {
                            extend: 'pdf', className: 'btn-primary',
                            title:  'Dims User Actions #'+$('#orderId').val(),
                            exportOptions: {
                                columns: [0,1,5]
                            }
                        }

                    ]

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
                });
                $('#listaddresses li').click(function(){
                    var $this = $(this);
                    var selKeyVal = $this.attr("value");
                    // alert('Text ' + $this.text() + 'value ' + selKeyVal);

                    $("#hiddenDeliveryAddressId" ).val(selKeyVal);
                    $("#customerSelectedDelDate" ).val($this.text());
                    $("#deliveryAddressIdOnPopUp").val(selKeyVal);
                    //$('#doneCustomAddress').show();
                    //pass this to fetch address
                    console.debug("just assigned this now*******"+selKeyVal);
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
                        productCode: $('#prodCode_' + token_number).val(),
                        warehouseid:$('#headerWh').val()
                    },
                    success: function (data) {


                        if(data.length > 0)
                        {
                            console.debug("Price Here"+data[0].Price);
                            if (parseFloat(data[0].Price).toFixed(2) > 0 ) {

                                if ($('#prodQty_' + token_number).val() == '0') {
                                    $('#prodQty_' + token_number).val('');
                                }
                                if ($.isEmptyObject(data)) {
                                    // $('#prodPrice_' + token_number).val('');
                                    $('#cost_' + token_number).val('');

                                } else {
//AvailOnly

                                    if (data[0].AvailOnly <= 0 && data[0].mustAuthLine != 0) {
                                        $('#title_' + token_number).val('preauthorised');
                                        $('#appendErrormsg').empty();
                                        $('#appendErrormsg').append("It appears that you don't have enough in stock");
                                        showDialogWithoutClose("#authorisations", 500, 500);
                                        //if (e.keyCode == 27) return false;
                                        $('#noThanksRedo').off().click(function () {
                                            $('#new_row_ajax' + token_number).remove();
                                            calculator();
                                            generateALine2();
                                            $("#authorisations").dialog('close');
                                        });
                                        $('#doAuth').off().click(function () {
                                            // $('#userAuthName').val();
                                            console.debug($('#userAuthPassWord').val());
                                            $('#userAuthPassWord').val();
                                            $.ajax({
                                                url: '{!!url("/verifyAuthOnAdmin")!!}',
                                                type: "POST",
                                                data: {
                                                    userName: $('#userAuthName').val(),
                                                    userPassword: $('#userAuthPassWord').val()
                                                },
                                                success: function (data) {
                                                    //console.debug("bunch"+data);
                                                    if ($.isEmptyObject(data)) {
                                                        alert("Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                                                    } else {
                                                        $('#userAuthName').val('');
                                                        $('#userAuthPassWord').val('');
                                                        $('#title_' + token_number).val('preauthorised');
                                                        console.debug('///////////////////' + $('#title_' + token_number).val());

                                                        consoleManagementAuths('{!!url("/logMessageAuth")!!}', 12, 1, 'Authorized out os Stock by ' + data[0].UserName,
                                                            0, $('#orderId').val(), '', $('#inputCustAcc').val(), 0, 0, 0, $('#userNewVariable').val(), $('#orderId').val(), 0, computerName, $('#orderId').val(), 0, data[0].UserID, data[0].UserName);
                                                        $("#authorisations").dialog('close');
                                                        calculator();


                                                    }
                                                }
                                            });

                                        });

                                        //isCorrectCredentials
                                    }
                                    $('#prodPrice_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                                    $('#marginandpriceauthbycustomer').val(data[0].authPrices);
                                    $('#prohibited_' + token_number).val(parseFloat(data[0].Prohibited).toFixed(2));
                                    $('#instockReadOnly_' + token_number).val(data[0].AvailableToSell);
                                    $('#prodDisc_' + token_number).val(parseFloat(data[0].LineDisc).toFixed(2));
                                    $('#stockmanagement' + token_number).val(data[0].StockManagement);

                                    if(data[0].theMg == "NEEDAUTH"){
                                        linetotal(1,data[0].Price,data[0].Tax,marginCalculator(data[0].Cost,data[0].Price));
                                        $('#prodPrice_' + token_number).focus();
                                        /* var dialog = $('<p><strong style="color:red">Authorization Needed</strong></p>').dialog({
                                             height: 200, width: 700,modal: true,containment: false,
                                             buttons: {
                                                 "Okay": function () {
                                                     dialog.dialog('close');
                                                 }
                                             }
                                         });*/
                                    }
                                    if(data[0].intAssociated != "0"){
                                        $('#' + token_number).css('background', '#FF0000');
                                    }


                                    //   console.debug("allow discount *************************************"+data[0].allowedDiscount);
                                    /* if(data[0].allowedDiscount != 0)
                            {
                                console.debug("allow discount *************************************"+data[0].allowedDiscount);
                              //  $('#prodPrice_' + token_number).prop('readonly', true);
                            }*/
                                    if (reportmarginControl === 'marginType5') {
                                        $('#priceholder_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                                    }


                                }
                            }
                            else
                            {
                                if(data[0].theMg == "NEEDAUTH"){
                                    $('#prodPrice_' + token_number).focus();
                                    /* var dialog = $('<p><strong style="color:red">Authorization Needed</strong></p>').dialog({
                                         height: 200, width: 700,modal: true,containment: false,
                                         buttons: {
                                             "Okay": function () {
                                                 dialog.dialog('close');
                                             }
                                         }
                                     });*/
                                }
                                //theOrdersDetailsId
                                $('#prodPrice_' + token_number).val('0');
                                if($('#marginandpriceauthbycustomer').val().length >1) {
                                    $('#prodPrice_' + token_number).val('0');
                                    $('#ZeroPrice').show();
                                    showDialogWithoutClose('#ZeroPrice', '40%', 250);
                                    $('#ZeroPrice').keydown(function (event) {
                                        if (event.keyCode == 27) {
                                            return false;
                                        }
                                    });
                                    //   $( "#authorisations" ).dialog('close');
                                    // $( "#MarginProblems" ).dialog('close');
                                    authZeroPricing(token_number, $('#theOrdersDetailsId' + token_number).val(), $('#prodCode_' + token_number).val());
                                }
                            }
                        }else
                        {
                            if(data[0].theMg == "NEEDAUTH"){
                                $('#prodPrice_' + token_number).focus();
                                /* var dialog = $('<p><strong style="color:red">Authorization Needed</strong></p>').dialog({
                                     height: 200, width: 700,modal: true,containment: false,
                                     buttons: {
                                         "Okay": function () {
                                             dialog.dialog('close');
                                         }
                                     }
                                 });*/
                            }

                            if($('#marginandpriceauthbycustomer').val().length > 1 ){
                                $('#prodPrice_'+token_number).val('0');
                                $('#ZeroPrice').show();
                                showDialogWithoutClose('#ZeroPrice','40%',250);
                                $('#ZeroPrice').keydown(function(event) {
                                    if (event.keyCode == 27){
                                        return false;
                                    }
                                });

                                // $( "#MarginProblems" ).dialog('close');
                                authZeroPricing(token_number,$('#theOrdersDetailsId' + token_number).val(), $('#prodCode_' + token_number).val());
                                $( "#authorisations" ).dialog('close');
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

                        $('#instockGlobal').val('');

                        $('#instockGlobal').val(data);
                        $('#instockReadOnly_' + token_number).val(data);

                        $('#clcstock_' + token_number).val(ParseFloat(data)-1);
                    }
                });
            }
            function isCorrectCredentials(username,password)
            {
                var answer = 'match';
                $.ajax({
                    url: '{!!url("/credentialsmatch")!!}',
                    type: "POST",
                    data: {
                        ItemCode: 1
                    },
                    success: function (data) {
                        answer = data;
                    }
                });
                return answer
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
                        $('#instockGlobal').val('');
                        $('#instockGlobal').val(data);


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
            function productPriceOnReadyMadeLine(productCode,producutDescr,tax,cost,title,inStock,unitSizes,UnitWeight,SoldByWeight,strBulkUnit,ProductMargin,multiLines)
            {

                calculator();
                $.ajax({
                    url: '{!!url("/getCutomerPriceOnOrderForm")!!}',
                    type: "POST",
                    data: {
                        customerID: $('#inputCustAcc').val(),
                        deliveryDate: $('#inputDeliveryDate').val(),
                        productCode: productCode,
                        warehouseid:$('#headerWh').val()
                    },
                    success: function (data) {
                        console.debug(data);
                        var price = '';

                        var weneedauth = 0;
                        if(data[0].theMg == "NEEDAUTH"){
                            weneedauth = 1;

                        }
                         console.debug("********************"+data[0].shelf);

                        if ($.isEmptyObject(data)) {
                            price = '';
                            console.debug("UnitWeight ===="+UnitWeight);
                            console.debug("SoldByWeight ===="+SoldByWeight);
                            console.debug("strBulkUnit ===="+strBulkUnit);
                            readyMadeLineOrderLine('#table tbody', producutDescr, productCode, ' ', price, 0, inStock, title, tax,unitSizes,0,UnitWeight,SoldByWeight,strBulkUnit,ProductMargin,multiLines,data[0].LineDisc,linediscount,weneedauth,data[0].shelf);
                        } else {
                            price = parseFloat(data[0].Price).toFixed(2);

                            if (reportmarginControl === 'marginType5')
                            {
                                //cost = price;
                                cost = cost;
                            }
                            readyMadeLineOrderLine('#table tbody', producutDescr, productCode, '', price, cost, inStock, title, tax,unitSizes,data[0].Prohibited,UnitWeight,SoldByWeight,strBulkUnit,ProductMargin,multiLines,data[0].LineDisc,linediscount,weneedauth,data[0].shelf);
                            // }

                        }

                    }
                });
            }
            //Plus key is Pressed
            $(function(){
                $('#tblOnsalesOrder,#tblOnInvoiced').on('keydown', function(ev) {

                    if((ev.keyCode === 107 || ev.keyCode === 17) && ($('#orderId').val()).length < 1)
                    {
                        if ((globalOrderIdToBePushed[0]).length > 1) {
                            $('#orderId').val(globalOrderIdToBePushed[0]);
                            $('#checkOrders').click();
                            $('#prodOnOrder').dialogExtend("minimize");
                            $('#prodonInvoice').dialogExtend("minimize");
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
                    //alert("focusing out tests");

                    calculator();
                    var $cells = $(this).find(".prodPrice_");
                    var $cellsId = $(this).find(".prodPrice_").attr("id");
                    var $cellProdCode = $(this).find(".theProductCode_");
                    var $cellProdCodeID = $(this).find(".theProductCode_").attr("id");

                    //productSetting

                    if( $.inArray($('#'+$cellProdCodeID).val(), arrayProdCodesCheck) !== -1 ) {

                    }
                    else
                    {
                        arrayProdCodesCheck.push($('#'+$cellProdCodeID).val());
                        console.debug(arrayProdCodesCheck);
                        //alert("new born");
                    }
                    var $cellProdDescription = $(this).find(".prodDescription_");
                    var $Description = $(this).find(".prodDescription_").val();
                    var $cellProdDescriptionID = $(this).find(".prodDescription_").attr("id");
                    var additionalcostcolumn = $(this).find(".additionalcost_").attr("id");
                    var $cellProdQuant = $(this).find(".prodQty_").attr("id");
                    //var $cellProdQuantOld = $(this).find(".prodQty_").data('val');
                    var $isAuth = $(this).find(".title");
                    var $isAuthAtrr = $(this).find(".title").attr("id");
                    var $iTHasMargin = $(this).find(".margin").attr("id");
                    var productmargin = $(this).find(".margin").val();
                    var $alcohol = $(this).find(".alcohol").attr("id");
                    var $deleteaLine = $(this).find("#deleteaLine").val();
                    var productmarginauth = $(this).find(".productmarginauth").val();

                    var $cost = $(this).find(".priceholder").val();
                    var theProductCode_ = $(this).find(".theProductCode_").val();
                    var $costFromTheDatabase = $(this).find(".costs").val();
                    var $hiddenToken = $(this).find(".hiddenToken").val();
                    var $inStock = $(this).find(".inStock").val();
                    var authString = $(this).find(".title").val();
                    var prohited = $(this).find(".prohibited").val();
                    var fieldQuantity = $(this).find(".prodQty_").val();
                    var theOrdersDetailsId = $(this).find("#theOrdersDetailsId").val();
                    var prodCell = $('#' + $cellsId).val();
                    focusoutcaladditionalcost(theProductCode_,fieldQuantity,additionalcostcolumn);
                    var margin = marginCalculator($costFromTheDatabase, prodCell);
                    var companyMargin = ($('#'+$iTHasMargin).val()/100);//this a field

                    if (prodCell != $cost)

                        if (($('#' + $cellsId).val()).length < 1 && ($('#' + $cellProdCodeID).val()).length > 0) {
                            $('#' + $cellsId).val('');
                        }

                    if(parseInt(prohited) === 1)
                    {
                        //alert("good");
                        authProhited($hiddenToken);
                    }

                    //{
                    switch(reportmarginControl){
                        case 'marginType1':
                            if ($inStock.length > 0 && prodCell.length > 0)
                            {
                                if (margin < companyMargin )
                                {
                                    if (authString.length > 0 && ($('#' + $cellProdCodeID).val()).length > 0) {
                                        authPopup("Price", $('#' + $cellsId).val(), 0, $('#'+$cellProdCodeID).val(), 'Price below margin ' + $cellProdCode.val() + '(' + $cellProdDescription.val() + ')', $isAuthAtrr, $hiddenToken,$.trim(theOrdersDetailsId));
                                    }
                                }

                                if(booze.length < 1  && $('#'+$alcohol).val() == 1 && $('#boozeChecked').val().length < 1)
                                {

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

                            if (($.trim(prodCell)).length > 0 && prodCell != $costFromTheDatabase)
                            {
                                if (authString.length > 0 && ($('#' + $cellProdCodeID).val()).length > 0) {
                                    console.debug('margin vs CompanyMargin '+ margin+' vs '+CompanyMargin+'prodCell '+prodCell+' $cost '+$cost+'auth string **********'+authString.length);
                                    if( margin < CompanyMargin && prodCell != $cost && isAuthPrice != "LFALSE") {
                                        console.debug("I need auth+++++++++++++++++++++++++++++++"+$('#' + $cellProdCodeID).val());
                                        console.debug("I need auth isAuthPrice+++++++++++++++++++++++++++++++"+isAuthPrice);
                                        authPopup("Price", $('#' + $cellsId).val(), theProductCode_, $('#' + $cellProdCodeID).val(), 'Changed Price ' + $cellProdCode.val() + '(' + $cellProdDescription.val() + ')', $isAuthAtrr, $hiddenToken,$.trim(theOrdersDetailsId));
                                    }
                                }
                            }


                            break;
                    }

                    var global = parseFloat($('#instockGlobal').val()).toFixed(2);
                    var prodQuantity = parseFloat($('#' + $cellProdQuant).val()).toFixed(2);
                    var inQuant = parseFloat($inStock).toFixed(2);


                    if (($('#' + $cellProdQuant).val()).length < 1 && ($('#' + $cellProdCodeID).val()).length > 0) {
                        $('#' + $cellProdQuant).val(1);
                        $('#' + $cellProdQuant).select();
                        //$('#' + $cellsId).select();
                    }



                    if($.trim($iTHasMargin) > 0 && ($.trim($('#' + $cellsId).val())).length > 0)
                    {
                        if (margin < companyMargin )
                        {

                            if (authString.length > 0 && ($('#' + $cellProdCodeID).val()).length > 0) {
                                authPopup("Price", $('#' + $cellsId).val(), theProductCode_, $('#'+$cellProdCodeID).val(), 'Price below margin ' + $cellProdCode.val() + '(' + $cellProdDescription.val() + ')', $isAuthAtrr, $hiddenToken,$.trim(theOrdersDetailsId));
                            }
                        }
                    }


                    if(isAuthPrice === 'LTRUE' && authString === 'PRICECHANGED')
                    {
                        authPopup("Price", $('#' + $cellsId).val(), theProductCode_, $('#'+$cellProdCodeID).val(), 'Price Changed ' + $cellProdCode.val() + '(' + $cellProdDescription.val() + ')', $isAuthAtrr, $hiddenToken,$.trim(theOrdersDetailsId));

                    }

//productmargin    $costFromTheDatabase  margin


                    if(fieldQuantity < 0.0000005 && ($('#' + $cellProdQuant).val()).length > 0 && theProductCode_.length > 0 && fieldQuantity.length > 0)
                    {
                        $('#qtyzero').show();
                        showDialogWithoutClose('#qtyzero',350,350);
                        $('#yestozeroqty').click(function(){
                            $('#qtyzero').dialog('close');
                        });
                    }

                    ///var margin = marginCalculator(cost, price);
                    if ((productmargin > margin) && isAuthPrice !== 'LTRUE' && authString === 'PRICECHANGED' )
                    {
                        console.debug("Morning vibe================================================="+$.trim(prodCell).length);
                        if($.trim(prodCell).length > 0)
                        {

                            $('#MarginProblems').show();
                            $('#userAuthProhibitedCred_marg').val('');
                            $('#userAuthPassWordCredit_marg').val('');
                            showDialogWithoutClose('#MarginProblems',400,400);
                            var $this = $(this);
                            $('#MarginProblems').keydown(function(event) {
                                if (event.keyCode == 27){
                                    return false;
                                }
                            });

                            $('#doAuthCredits').off().click(function(){

                                $.ajax({
                                    url: '{!!url("/verifyAuthGroupLeaders")!!}' ,
                                    type: "POST",
                                    data:{ userName:$('#userAuthProhibitedCred_marg').val(),
                                        userPassword:$('#userAuthPassWordCredit_marg').val(),
                                        orderId:$('#orderId').val()
                                    },
                                    success: function(data){
                                        if ($.isEmptyObject(data)){
                                            alert("Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                                        }else
                                        {
                                            $('#margin_auth').val(1);
                                            consoleManagementAuths('{!!url("/logMessageAuthMargin")!!}',12,1,'Authorized Product ('+theProductCode+') Margin ( LM :'+margin+' PM '+productmargin+')  by '+data[0].UserName,
                                                0,$('#orderId').val(),'',$('#inputCustAcc').val(),0,0,0,$('#userAuthProhibitedCred_marg').val(),$('#orderId').val(),0,computerName,$('#orderId').val(),0,data[0].UserID,data[0].UserName);
                                            $("#MarginProblems").dialog('close');
                                            $this.closest('tr').find('.title').val('');



                                            //calculator();
                                        }
                                    }
                                });

                            });
                            $('#doCancelAuthCredits').off().click(function(){
                                $this.closest('tr').find('.prodPrice_').val('');
                                $this.closest('tr').find('.prodPrice_').select();
                                $this.closest('tr').find('.prodPrice_').focus();
                                $('#MarginProblems').dialog('close');
                            });
                        }

                    }

                });
//prodDescription_
                /*    $(document).on("focusout",".prodDescription_",function(){
                         var auth = $(this).closest('tr').find('.title').val();
                         var cost = $(this).closest('tr').find('.costs').val();
                         var price = $(this).closest('tr').find('.prodPrice_').val();
                         var theProductCode = $(this).closest('tr').find('.theProductCode_').val();
                         var margin = $(this).closest('tr').find('.margin').val();
                         var prodQty = $(this).closest('tr').find('.prodQty_').val();
                         var hiddenToken = $(this).closest('tr').find('.hiddenToken').val();
                         var $cellsId = $(this).find(".prodPrice_").attr("id");

                         if(theProductCode.length > 0 && auth.length > 4){
                             somemainAuth(theProductCode,price,prodQty,cost,margin,hiddenToken)
                         }
                        //alert("product name "+auth);
                     });
                     $(document).on("focusout",".theProductCode_",function(){
                         var auth = $(this).closest('tr').find('.title').val();
                         var cost = $(this).closest('tr').find('.costs').val();
                         var price = $(this).closest('tr').find('.prodPrice_').val();
                         var theProductCode = $(this).closest('tr').find('.theProductCode_').val();
                         var margin = $(this).closest('tr').find('.margin').val();
                         var prodQty = $(this).closest('tr').find('.prodQty_').val();
                         var hiddenToken = $(this).closest('tr').find('.hiddenToken').val();
                         var $cellsId = $(this).find(".prodPrice_").attr("id");

                         if(theProductCode.length > 0 && auth.length > 4){
                             somemainAuth(theProductCode,price,prodQty,cost,margin,hiddenToken)
                         }
                        // alert("product code "+auth );
                     });
                     $(document).on("focusout",".prodBulk_",function(){
                         var auth = $(this).closest('tr').find('.title').val();
                         var cost = $(this).closest('tr').find('.costs').val();
                         var price = $(this).closest('tr').find('.prodPrice_').val();
                         var theProductCode = $(this).closest('tr').find('.theProductCode_').val();
                         var margin = $(this).closest('tr').find('.margin').val();
                         var prodQty = $(this).closest('tr').find('.prodQty_').val();
                         var hiddenToken = $(this).closest('tr').find('.hiddenToken').val();
                         var $cellsId = $(this).find(".prodPrice_").attr("id");

                         if(theProductCode.length > 0 && auth.length > 4){
                             somemainAuth(theProductCode,price,prodQty,cost,margin,hiddenToken)
                         }
                        // alert("product Bulk "+auth);
                     });
                     $(document).on("focusout",".prodQty_",function(){
                         var auth = $(this).closest('tr').find('.title').val();
                         var cost = $(this).closest('tr').find('.costs').val();
                         var price = $(this).closest('tr').find('.prodPrice_').val();
                         var theProductCode = $(this).closest('tr').find('.theProductCode_').val();
                         var margin = $(this).closest('tr').find('.margin').val();
                         var prodQty = $(this).closest('tr').find('.prodQty_').val();
                         var hiddenToken = $(this).closest('tr').find('.hiddenToken').val();
                         var $cellsId = $(this).find(".prodPrice_").attr("id");

                         if(theProductCode.length > 0 && auth.length > 4){
                             somemainAuth(theProductCode,price,prodQty,cost,margin,hiddenToken)
                         }
                       //  alert("product qty "+auth);
                     });
                     $(document).on("focusout",".prodComment_",function(){
                         var auth = $(this).closest('tr').find('.title').val();
                         var cost = $(this).closest('tr').find('.costs').val();
                         var price = $(this).closest('tr').find('.prodPrice_').val();
                         var theProductCode = $(this).closest('tr').find('.theProductCode_').val();
                         var margin = $(this).closest('tr').find('.margin').val();
                         var prodQty = $(this).closest('tr').find('.prodQty_').val();
                         var hiddenToken = $(this).closest('tr').find('.hiddenToken').val();
                         var $cellsId = $(this).find(".prodPrice_").attr("id");

                         if(theProductCode.length > 0 && auth.length > 4){
                             somemainAuth(theProductCode,price,prodQty,cost,margin,hiddenToken)
                         }
                        // somemainAuth(productCode,price,qty,cost,itemMargin,token_number)
                         //alert("product comment "+auth);
                     });*/
                function somemainAuth(productCode,price,qty,cost,itemMargin,token_number){
                    price = parseFloat(price);
                    qty = parseFloat(qty);
                    cost = parseFloat(cost);
                    itemMargin = parseFloat(itemMargin);
                    console.debug("token_number**********************"+token_number);
                    //  var n = token_number.indexOf("_");
                    var  token_numbernew = token_number;
                    console.debug("token_numbernew****"+token_numbernew);
                    console.debug("itemMargin****"+itemMargin);
                    console.debug("cost****"+cost);
                    console.debug("price****"+price);

                    if(marginCalculator(cost,price) <  itemMargin && productCode.length > 0 && itemMargin.length > 0){
                        $('#MarginProblems').show();
                        $('#userAuthProhibitedCred_marg').val('');
                        $('#userAuthPassWordCredit_marg').val('');
                        showDialogWithoutClose('#MarginProblems',400,400);
                        $('#MarginProblems').keydown(function(event) {
                            if (event.keyCode == 27) {
                                return false;
                            }
                        });
                        $('#MarginProblems').keyup(function(event) {
                            if (event.keyCode == 27) {
                                return false;
                            }
                        });

                        $('#doAuthCredits').off().click(function(){
                            //$('#MarginProblems').dialog('close');
                            $.ajax({
                                url: '{!!url("/verifyAuthGroupLeaders")!!}' ,
                                type: "POST",
                                data:{ userName:$('#userAuthProhibitedCred_marg').val(),
                                    userPassword:$('#userAuthPassWordCredit_marg').val(),
                                    orderId:$('#orderId').val()
                                },
                                success: function(datainner){
                                    console.debug(datainner);
                                    if ($.isEmptyObject(datainner)){
                                        $('#new_row_ajax'+token_numbernew).remove();
                                        calculator();
                                        generateALine2();
                                        alert("Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");

                                    }else
                                    {
                                        //console.debug("title "+title);
                                        $('#margin_auth').val(1);
                                        consoleManagementAuths('{!!url("/logMessageAuthMargin")!!}',12,1,'Authorized Product ('+$('#prodCode_' + token_numbernew).val()+')  by '+datainner[0].UserName,
                                            0,$('#orderId').val(),'',$('#inputCustAcc').val(),0,0,0,$('#userAuthProhibitedCred_marg').val(),$('#orderId').val(),0,computerName,$('#orderId').val(),0,datainner[0].UserID,data[0].UserName);
                                        $("#MarginProblems").dialog('close');

                                        $('#title_' + token_numbernew).val('');
                                        $('#MarginProblems').dialog('close');


                                    }
                                    //calculator();
                                }

                            });

                        });
                        $('#doCancelAuthCredits').off().click(function(){
                            console.debug("Function has occured as margin problem cancel click");
                            $('#MarginProblems').dialog('close');

                            $('#new_row_ajax'+token_numbernew).remove();
                            calculator();
                            generateALine2();

                        });

                    }

                }
                $(document).on("focusout",".prodPrice_",function(){

                    var $this = $(this);
                    var price = $(this).closest('tr').find('.prodPrice_').val();
                    if(price.length<1){
                        price = 0;
                    }
                    var cost = $(this).closest('tr').find('.costs').val();
                    //  var price = $(this).closest('tr').find('.prodPrice_').val();
                    var theProductCode = $(this).closest('tr').find('.theProductCode_').val();
                    var Productmargin = $(this).closest('tr').find('.margin').val();
                    var auth = $(this).closest('tr').find('.title').val();


                    var margin = marginCalculator(cost, price);

                    // if((parseFloat(Productmargin)  > parseFloat(margin).toFixed(2)) && auth.length>4  )
                    if(price ==7125 )
                    {
                        $('#MarginProblems').show();
                        $('#userAuthProhibitedCred_marg').val('');
                        $('#userAuthPassWordCredit_marg').val('');
                        showDialogWithoutClose('#MarginProblems',400,400);
                        $('#MarginProblems').keydown(function(event) {
                            if (event.keyCode == 27) {
                                return false;
                            }
                        });
                        $('#MarginProblems').keyup(function(event) {
                            if (event.keyCode == 27) {
                                return false;
                            }
                        });
                        $('#doAuthCredits').off().click(function(){

                            $.ajax({
                                url: '{!!url("/verifyAuthGroupLeaders")!!}' ,
                                type: "POST",
                                data:{ userName:$('#userAuthProhibitedCred_marg').val(),
                                    userPassword:$('#userAuthPassWordCredit_marg').val(),
                                    orderId:$('#orderId').val()
                                },
                                success: function(data){
                                    if ($.isEmptyObject(data)){
                                        alert("Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                                    }else
                                    {
                                        $('#margin_auth').val(1);
                                        consoleManagementAuths('{!!url("/logMessageAuthMargin")!!}',12,1,'Authorized Product ('+theProductCode+') Margin ( LM :'+margin+' PM '+Productmargin+')  by '+data[0].UserName,
                                            0,$('#orderId').val(),'',$('#inputCustAcc').val(),0,0,0,$('#userAuthProhibitedCred_marg').val(),$('#orderId').val(),0,computerName,$('#orderId').val(),0,data[0].UserID,data[0].UserName);
                                        $("#MarginProblems").dialog('close');
                                        $this.closest('tr').find('.title').val('');



                                        //calculator();
                                    }
                                }
                            });

                        });
                        $('#doCancelAuthCredits').off().click(function(){
                            $this.closest('tr').find('.prodPrice_').val('');
                            $this.closest('tr').find('.prodPrice_').select();
                            $this.closest('tr').find('.prodPrice_').focus();
                            $('#MarginProblems').dialog('close');
                        });
                    }


                });
                //Split form
                $('#tblSplitOrder tbody').on('focusout','tr', function () {
                    var $this = $(this);
                    var backorderqty = $this.find(".back").val();
                    var orderedqty = $this.find(".ordered").val();
                    var origingback = $this.find(".origingback").val();

                    if(backorderqty > orderedqty)
                    {
                        var dialog = $('<p><strong style="color:red">You cannot put value greater than ordered quantity</strong></p>').dialog({
                            height: 200, width: 700,modal: true,containment: true,
                            buttons: {
                                "Okay": function () {
                                    $this.find(".back").val(origingback);
                                    dialog.dialog('close');
                                }
                            }
                        });
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


            $(document).on('click', '#dosplit', function(e) {
                //alert("I am clicked");

                var productsLines = new Array();
                $('input:checkbox:checked').each(function() {
                    productsLines.push({
                        'back': parseFloat( $(this).closest('tr').find('.back').val()).toFixed(2),
                        'code': $(this).closest('tr').find('.theProductCode').val(),
                        'ordered': parseFloat( $(this).closest('tr').find('.ordered').val()).toFixed(2),
                        'orderdetailid': $(this).closest('tr').find('.orderdetailid').val()
                    });

                    //ajax

                });

                $.ajax({
                    url: '{!!url("/createbackorderonsplit")!!}',
                    type: "POST",
                    data: {
                        productsLines: productsLines, orderid: $('#orderId').val()
                    },
                    success: function (data) {
                        location.reload();
                    }
                });
            });
            //cancelsplit
            $(document).on('click', '#cancelsplit', function(e) {
                $('#splitOrder').dialog('close');
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
            //
            $(document).on('keyup', '.prodBulk_', function(e) {
                var prodBulk = $(this).closest("tr").find(".prodBulk_").val();
                var bulkUnitCalc = $(this).closest("tr").find(".unitWeight").val();
                var strBulkUnit = $(this).closest("tr").find(".strBulkUnit").val();
                var prodComment_ = $(this).closest("tr").find(".prodComment_").val(prodBulk+' '+strBulkUnit);
                var qty = $(this).closest("tr").find(".prodQty_").val(parseFloat( prodBulk * bulkUnitCalc).toFixed(3));

            });
            $(document).on('change', '.col2', function() {
                var colid =$(this).attr("id");
                var warehouseId = $(this).val();
                var prodc = $(this).closest("tr").find(".theProductCode_").val();
                var $this =  $(this);
                var id =colid.substring(4,colid.length)

                $.ajax({
                    url: '{!!url("/warehouseProductStockLookUp")!!}',
                    type: "POST",
                    data: {
                        warehouseid: warehouseId,
                        prodCode: prodc
                    },
                    success: function (data) {
                        //alert( id);
                        $('#instockReadOnly_'+id).val(data[0].Available);
                        //  $this.closest("tr").find(".instockReadOnly_").val(data.Available);
                    }
                });
            });

            $(document).on('keydown', '.inputs', function(e) {
                var key = (e.keyCode ? e.keyCode : e.which);
                var $isAuth = $(this).closest("tr").find(".title").attr("id");
                var $price = $(this).closest("tr").find(".prodPrice_").val();
                var prodQty_ = $(this).closest("tr").find(".prodQty_").val();
                var costing = $(this).closest("tr").find(".costs").val();
                var taxCodes = $(this).closest("tr").find(".taxCodes").val();
                var lineDisc = $(this).closest("tr").find(".prodDisc_").val();
                var finalDisc = (100-lineDisc)/100;


                linetotal(prodQty_,$price,taxCodes,marginCalculator(costing,$price*finalDisc));
            });
            $(document).on('click', '.inputs', function(e) {
                var key = (e.keyCode ? e.keyCode : e.which);
                var $isAuth = $(this).closest("tr").find(".title").attr("id");
                var $price = $(this).closest("tr").find(".prodPrice_").val();
                var prodQty_ = $(this).closest("tr").find(".prodQty_").val();
                var costing = $(this).closest("tr").find(".costs").val();
                var taxCodes = $(this).closest("tr").find(".taxCodes").val();
                var lineDisc = $(this).closest("tr").find(".prodDisc_").val();
                var finalDisc = (100-lineDisc)/100;
                linetotal(prodQty_,$price,taxCodes,marginCalculator(costing,$price*finalDisc));
            });
            $(document).on('keydown', '.prodPrice_', function(e) {
                var key = (e.keyCode ? e.keyCode : e.which);
                var hiddenToken ='';
                var $isAuth = $(this).closest("tr").find(".title").attr("id");
                var $priceToken = $(this).closest("tr").find(".prodPrice_").attr("id");
                var productCode = $(this).closest("tr").find(".theProductCode_").val();
                var costing = $(this).closest("tr").find(".costs").val();
                var hiddenToken = $(this).closest("tr").find(".hiddenToken").val();
                $(this).closest('tr').find('.title').val('authorize');

                if ((key > 45 && key < 57) || (key > 95 && key < 106) ||  key == 8) {
                    $('#'+$isAuth).val('PRICECHANGED');
                    calculator();

                }
                if ( key == 107 || key==17)
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
                            var trHTMLSellingPrice = '';
                            $('#lastprice').val('');
                            $('#costOnCustomerOrangeForm').val('');
                            $('#customersellingPrice').empty();
                            if((data.sellingPrice).length > 0){
                                $('#lastprice').val(parseFloat(data.sellingPrice[0].Price,2));
                                //customersellingPrice
                                $.each(data.sellingPrice, function (key, value) {
                                    trHTMLSellingPrice += '<tr style="font-size: 10px;color:black"><td>' +
                                        value.Price + '</td><input type="hidden" class="hiddenToken" value="'+hiddenToken+'" ><td><strong>' +
                                        value.DeliveryDate + '</strong></td><td>' +
                                        value.Margin+
                                        '%</td></tr>';
                                });

                                $('#customersellingPrice').append(trHTMLSellingPrice);
                            }
                            $('#costOnCustomerOrangeForm').val(parseFloat(costing,2));
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

                            //Double click the pricing thingy
                            $('#customersellingPrice').on('dblclick', 'tbody tr', function () {


                                var $this = $(this);
                                var row = $this.closest("tr");
                                var Price = row.find('td:eq(0)').text();
                                //var to = row.find('td:eq(0)').text();


                                $('#prodPrice_'+hiddenToken).val(Price);
                                $( "#custLookUp" ).dialog('close');
                                hiddenToken='';


                            });
                        }
                    });
                    /* $('#customerDetailLookUp tbody').on('dblclick', 'tr', function (){
                alert("over here");
            });*/
                }
                $('#lastprice').on('click',function(){
                    // $('#'+$priceToken).val($('#lastprice').val());
                    $( "#custLookUp" ).dialog('close');
                });
            });
            $(document).on('keydown', '.prodComment_', function(e) {
//$(this).closest("tr").find(".prodComment_").val()
                $(this).prop('title', $(this).closest("tr").find(".prodComment_").val());
            });
            $(document).on('keydown', '.prodQty_', function(e) {
                var key = (e.keyCode ? e.keyCode : e.which);

                var qty= $(this).closest("tr").find(".prodQty_").val();
                var prices = $(this).closest("tr").find(".prodPrice_").val();
                var productCode = $(this).closest("tr").find(".theProductCode_").val();
                var instock = $(this).closest("tr").find(".instockReadOnly_").val();
                var linetotal = qty * prices;
                var cstock = instock - qty ;
                $(this).closest("tr").find(".col6").val(linetotal.toFixed(2));
                $(this).closest("tr").find(".clcstock_").val(cstock.toFixed(2));
                if ((key > 45 && key < 57) || (key > 95 && key < 106) ||  key == 8) {
                    calculator();
                }
//extrasononrder
                if ( key == 107)
                {
                    console.debug('productCode'+productCode);
                    $('#extrasononrder').show();
                    $( "#extrasononrder" ).dialog({height: 450,
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
                        url: '{!!url("/getextracomunsforItems")!!}',
                        type: "POST",
                        data:{
                            productCode:productCode,custCode : $('#inputCustAcc').val()
                        },
                        success: function(data) {
                            console.debug("Testing this this" +data);

                            $('#randomweightdescription').val(data[0].Description_2);
                            //$( "#extrasononrder" ).dialog('close');
                        }
                    });
                    /* $('#customerDetailLookUp tbody').on('dblclick', 'tr', function (){
                alert("over here");
            });*/
                }

            });

            $(document).on('keydown', '.additionalcost_', function(e) {
                var key = (e.keyCode ? e.keyCode : e.which);
                var hiddenToken = '';
                var $isAuth = $(this).closest("tr").find(".title").attr("id");
                var $priceToken = $(this).closest("tr").find(".prodPrice_").attr("id");
                var productCode = $(this).closest("tr").find(".theProductCode_").val();
                var costing = $(this).closest("tr").find(".costs").val();
                var prodQty_ = $(this).closest("tr").find(".prodQty_").val();
                var hiddenToken = $(this).closest("tr").find(".hiddenToken").val();
                var $this = $(this).closest("tr");

                if ((key > 45 && key < 57) || (key > 95 && key < 106) || key == 8) {
                    $('#' + $isAuth).val('PRICECHANGED');
                    calculator();

                }
                if (key == 107) {
                    //   console.debug('productCode' + productCode);
                    $('#addcostdialog').show();
                    $("#addcostdialog").dialog({
                        height: 450,
                        width: 400, containment: false
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
                        ,close : function() {
                            //functionality to clear data here
                            console.debug("closed");
                        }
                    });

                    $.ajax({
                        url: '{!!url("/associatedItem")!!}',
                        type: "POST",
                        data:{
                            productCode:productCode,
                            customerCode : $('#inputCustAcc').val(),
                            delDate : $('#inputDeliveryDate').val(),
                        },
                        success: function(data) {

                            console.debug(data);
                            var trHTML = '';
                            var trHTMLSellingPrice = '';

                            $('#additionalcost tbody').empty();
                            $.each(data, function (key, value) {
                                trHTMLSellingPrice += '<tr style="font-size: 10px;color:black"><td>' +
                                    value.itemcode + '</td><td>' +
                                    value.itemdescription + '</td><td>' +
                                    parseFloat(prodQty_) + '</td><td>' +
                                    value.Price + '</td><td>' +
                                    parseFloat(prodQty_*value.Price)+
                                    '</td></tr>';
                            });

                            $('#additionalcost').append(trHTMLSellingPrice);


                        }
                    });
                }

                if(key ==13)
                {
                    $.ajax({
                        url: '{!!url("/associatedItem")!!}',
                        type: "POST",
                        data: {
                            productCode: productCode,
                            customerCode: $('#inputCustAcc').val(),
                            delDate: $('#inputDeliveryDate').val(),
                        },
                        success: function (data) {
                            console.log($isAuth);

                            if (!$.trim(data)){
                                $this.find(".additionalcost_").val(0);
                            }
                            else{
                                $this.find(".additionalcost_").val(parseFloat(prodQty_*data[0].Price) );
                            }

                        }
                    });
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
            function backorderandawaiting(addressId) {
                $.ajax({
                    url: '{!!url("/backordersandawaiting")!!}',
                    type: "POST",
                    data: {
                        addressId: addressId,
                        customerCode: $('#inputCustAcc').val(),
                    },
                    success: function (data) {
                        console.log(data);

                        $("#gridbackorders").dxDataGrid({

                            dataSource:data, //as json
                            hoverStateEnabled: true,
                            showBorders: true,
                            filterRow: { visible: false },
                            allowColumnResizing: true,
                            columnAutoWidth: true,
                            wordWrapEnabled: true,
                            showScrollbar: "always",
                            height: 500,
                            paging:{
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
                                    width: 30,
                                    cellTemplate: function(cellElement, cellInfo) {

                                        cellElement.addClass('custom-font');

                                        cellElement.text(cellInfo.text);
                                    }

                                },{
                                    dataField: "OrderId",
                                    caption: "OrderId",
                                    width: 70,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        cellElement.addClass('custom-font');
                                        cellElement.text(cellInfo.text);
                                    }

                                },{
                                    dataField: "ProductId",
                                    caption: "ProductId",
                                    visible: false,
                                },{
                                    dataField: "DeliveryAddressID",
                                    caption: "DeliveryAddressID",
                                    visible: false,
                                },{
                                    dataField: "OrderDetailId",
                                    caption: "OrderDetailId",
                                    visible: false,
                                },{
                                    dataField: "PastelCode",
                                    caption: "Product Code",
                                    width: 30,
                                    visible:false,
                                    cellTemplate: function(cellElement, cellInfo) {

                                        cellElement.addClass('custom-font');

                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "Description",
                                    caption: "Item",
                                    width: 100,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        console.debug("column");
                                        console.debug(cellInfo.column);

                                            cellElement.addClass('custom-font');

                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "Ordered",
                                    caption: "QTY",
                                    width: 70,
                                    cellTemplate: function(cellElement, cellInfo) {

                                            cellElement.addClass('custom-font');

                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "originalQty",
                                    caption: "Orig.Qty",
                                    width: 70,
                                    cellTemplate: function(cellElement, cellInfo) {

                                            cellElement.addClass('custom-font');

                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "DeliveryDate",
                                    caption: "D.Date",
                                    width: 100,
                                    displayFormat: "yyyy-mm-dd",
                                    cellTemplate: function(cellElement, cellInfo) {

                                            cellElement.addClass('custom-font');

                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "UnitWeight",
                                    caption: "UnitWeight",
                                    width: 30,
                                    visible:false,
                                    cellTemplate: function(cellElement, cellInfo) {

                                            cellElement.addClass('custom-font');

                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "SoldByWeight",
                                    caption: "SoldByWeight",
                                    width: 30,
                                    visible:false,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        cellElement.addClass('custom-font');
                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "Tax",
                                    caption: "Tax",
                                    visible:false,

                                    cellTemplate: function(cellElement, cellInfo) {

                                        cellElement.addClass('custom-font');
                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "strBulkUnit",
                                    caption: "strBulkUnit",
                                    visible:false,
                                    cellTemplate: function(cellElement, cellInfo) {

                                            cellElement.addClass('custom-font');

                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "ProductMargin",
                                    caption: "ProductMargin",
                                    visible:false,
                                    cellTemplate: function(cellElement, cellInfo) {

                                            cellElement.addClass('custom-font');

                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "UnBookedStock",
                                    caption: "UnBookedStock",
                                    width: 30,
                                    visible:false,
                                    format: {
                                        type: "fixedPoint",
                                        precision: 3
                                    },
                                    customizeText: function(cellInfo) {
                                        return Number(cellInfo.value).toFixed(3);
                                    }
                                },{
                                    dataField: "OrderNumber",
                                    caption: "O.Num",
                                    width: 70,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        if(cellInfo.column.index === 0) {
                                            cellElement.addClass('custom-font');
                                        }
                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "Comment",
                                    caption: "Comment",
                                    width: 30,
                                    visible:false,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        if(cellInfo.column.index === 0) {
                                            cellElement.addClass('custom-font');
                                        }
                                        cellElement.text(cellInfo.text);
                                    }
                                },{
                                    dataField: "Cost",
                                    caption: "Cost",
                                    width: 30,
                                    visible:false,
                                    format: {
                                        type: "fixedPoint",
                                        precision: 2
                                    },
                                    customizeText: function(cellInfo) {
                                        return Number(cellInfo.value).toFixed(2);
                                    }
                                },{
                                    dataField: "UnitSize",
                                    caption: "UnitSize",
                                    width: 30,
                                    visible:false,
                                    cellTemplate: function(cellElement, cellInfo) {
                                        if(cellInfo.column.index === 0) {
                                            cellElement.addClass('custom-font');
                                        }
                                        cellElement.text(cellInfo.text);
                                    }
                                },
                            ],
                            onRowDblClick: function(e){
                                var invNum = e.data.OrderId;
                                var productCode = e.data.PastelCode;
                                var producutDescr = e.data.Description;
                                if (e.rowType == 'data' && e.data.prodStatusType =="Awaiting Stock") {


                                }

                            },
                            onRowPrepared(e) {
                                if (e.rowType == 'data' && e.data.prodStatusType =="Back Order") {
                                    e.rowElement.css('background', 'rgb(155, 236, 248)');
                                }
                            },

                            onRowRemoving: function(e) {
                                var OrderDetailId = e.data.OrderDetailId;

                                console.debug("orderdetail Id ____________"+OrderDetailId);
                                $.ajax({
                                    url: '{!!url("/deleteOrderLinedetails")!!}',
                                    type: "POST",
                                    data: {
                                        OrderId:OrderDetailId,
                                    },
                                    success: function (data) {
                                        alert(data[0]['Result']);
                                    }
                                });
                            }
                        });
                    }
                });
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
            function authFinishOrder()
            {
                $( "#authDropDownsClosedRoutePass" ).dialog({height: 500, modal: true,
                    width: 1200,containment: false}).dialogExtend({
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

                $('#doCancelAuthDropDownClosedRoutePass').off().click(function(){

                });
                $('#doAuthDropDownClosedRoutePass').off().click(function(){
                    $.ajax({
                        url: '{!!url("/verifyAuth")!!}' ,
                        type: "POST",
                        data:{
                            userName: $('#userAuthClosedRoute').val(),
                            userPassword: $('#userAuthClosedRoutePass').val()
                        },
                        success: function(data){
                            //console.debug("bunch"+data);
                            if ($.isEmptyObject(data)){
                                alert("Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                            }else
                            {

                                $('#authDropDownsClosedRoutePass').dialog('close');
                                finishThis();
                            }
                        }
                    });
                });

            }
            function linetotal(quantity,price,tax,margins)
            {
                var lineTotEx = parseFloat(quantity) * parseFloat(price);
                console.debug("*****************************"+parseFloat(lineTotEx*((tax/100) +1)));
                var lineTotin = parseFloat(lineTotEx*((tax/100) +1));
                $("#linemargins").val(parseFloat(margins).toFixed(2));
                $("#linetotalex").val(parseFloat(lineTotEx).toFixed(2));
                $("#linetotalInc").val(parseFloat(lineTotin).toFixed(2));

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
            function commonDialog(){
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
                $('#authorisations').keydown(function(event) {
                    if (event.keyCode == 27){
                        return false;
                    }
                });
            }

            function authPopup(tag,oldV,product,token,mess,isAuthprice,rowHiddenId,theActualOrderDetailID)
            {

                console.debug("***********************************************");
                //$('#userAuthName').
                $('#appendErrormsg').empty();
                $('#appendErrormsg').append(mess);

                $('#authorisations').show();

                $( "#authorisations" ).dialog({height: 250, modal: true, closeOnEscape: false,
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
                $('#authorisations').keydown(function(event) {
                    if (event.keyCode == 27){
                        return false;
                    }
                });
                $('#noThanksRedo').off().click(function(){

                    console.debug('#new_row_ajax'+rowHiddenId);

                    $('#authorisations').dialog('close');
                    if (theActualOrderDetailID.length > 0 )
                    {
                        console.debug('line id *********'+theActualOrderDetailID);
                        var orderLineID = theActualOrderDetailID;
                        $.ajax({
                            url:'{!!url("/deleteOrderDetails")!!}',
                            type: "POST",
                            data: {
                                OrderId: $('#orderId').val(),
                                OrderDetailId: orderLineID},
                            success: function(data){

                                if (data.deletedId != 'FAILED')
                                {
                                    if (($('#invoiceNo').val()).length < 1) {
                                        $('#new_row_ajax'+rowHiddenId).remove();
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
                    }
                    else
                    {
                        $('#new_row_ajax'+rowHiddenId).remove();
                        calculator();
                        generateALine2();
                    }
                    //  generateALine2();
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
                                $('#title_'+rowHiddenId).val('');
                                console.debug('///////////////////'+$('#title_'+rowHiddenId).val());
                                $('#'+isAuthprice).val('');
                                if(tag === "Price")
                                {
                                    console.debug('auth id'+isAuthprice);
                                    console.debug('product==================='+product);
                                    consoleManagementAuths('{!!url("/logMessageAuth")!!}',12,1,'Product price has been changed by '+data[0].UserName+' to '+oldV,
                                        0,$('#orderId').val(),product,$('#inputCustAcc').val(),0,0,0,$('#userNewVariable').val(),$('#orderId').val(),0,computerName,$('#orderId').val(),0,data[0].UserID,data[0].UserName);
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

                //disable the escape button

            }
            function authZeroPricing(rowHiddenId,theActualOrderDetailID,product)
            {

                $('#doCancelAuthZeroPrice').off().click(function(){

                    $('#ZeroPrice').dialog('close');
                    console.debug("***********************************theActualOrderDetailID"+theActualOrderDetailID);
                    if ( theActualOrderDetailID !== "undefined" || theActualOrderDetailID.length > 0 )
                    {
                        var orderLineID = theActualOrderDetailID;
                        $.ajax({
                            url:'{!!url("/deleteOrderDetails")!!}',
                            type: "POST",
                            data: {
                                OrderId: $('#orderId').val(),
                                OrderDetailId: orderLineID},
                            success: function(data){

                                if (data.deletedId != 'FAILED')
                                {
                                    if (($('#invoiceNo').val()).length < 3) {
                                        $('#new_row_ajax'+rowHiddenId).remove();
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
                    }
                    else
                    {
                        $('#new_row_ajax'+rowHiddenId).remove();
                        calculator();
                        generateALine2();
                    }
                    //  generateALine2();
                });

                $('#doAuthZeroPrice').off().click(function(){
                    $.ajax({
                        url: '{!!url("/verifyAuthOnAdmin")!!}' ,
                        type: "POST",
                        data:{
                            userName:$('#userauthproductwithzeroprice').val(),
                            userPassword:$('#userAuthPassWordzeroprice').val()},
                        success: function(data){

                            if($.isEmptyObject(data)){
                                alert("Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                            }
                            else
                            {
                                $('#userauthproductwithzeroprice').val('');
                                $('#userAuthPassWordzeroprice').val('');


                                consoleManagementAuths('{!!url("/logMessageAuth")!!}',12,1,'zero pricing on a line item has been authorised by '+data[0].UserName,
                                    0,$('#orderId').val(),product,$('#inputCustAcc').val(),0,0,0,$('#userauthproductwithzeroprice').val(),$('#orderId').val(),0,computerName,$('#orderId').val(),0,data[0].UserID,data[0].UserName);
                                $( "#ZeroPrice" ).dialog('close');
                                //$('#'+token).val($('#userNewVariable').val());
                                $('#title_'+rowHiddenId).val("authorised");
                                $('#prodPrice_'+rowHiddenId).val('0');

                            }
                        }
                    });

                });
            }
            function authPopupQuantity(tag,oldV,product,token,mess,isAuthprice,rowHiddenId,theActualOrderDetailID)
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

                    $('#authorisations').dialog('close');
                    if (theActualOrderDetailID.length > 0 )
                    {
                        console.debug('line id *********'+theActualOrderDetailID);
                        var orderLineID = theActualOrderDetailID;
                        $.ajax({
                            url:'{!!url("/deleteOrderDetails")!!}',
                            type: "POST",
                            data: {
                                OrderId: $('#orderId').val(),
                                OrderDetailId: orderLineID},
                            success: function(data){

                                if (data.deletedId != 'FAILED')
                                {
                                    if (($('#invoiceNo').val()).length < 1) {
                                        $('#new_row_ajax'+rowHiddenId).remove();
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
                    }
                    else
                    {
                        $('#new_row_ajax'+rowHiddenId).remove();
                        calculator();
                        generateALine2();
                    }
                    //  generateALine2();
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

                                consoleManagementAuths('{!!url("/logMessageAuth")!!}',12,1,'Quantity has been Authorised by '+data[0].UserName,
                                    0,$('#orderId').val(),product,$('#inputCustAcc').val(),0,0,oldV,$('#userNewVariable').val(),$('#orderId').val(),0,computerName,$('#orderId').val(),0,data[0].UserID,data[0].UserName);
                                $( "#authorisations" ).dialog('close');
                                $('#'+token).val($('#userNewVariable').val());
                                $('#title_'+rowHiddenId).val("authorised");

                            }
                        }
                    });

                });

            }
            function checkifhasmultiaddress(){

                $.ajax({
                    url: '{!!url("/checkifhasmultiaddress")!!}',
                    type: "POST",
                    data: {
                        account: $('#inputCustAcc').val()
                    },
                    success: function (data) {

                        if (data[0].result == "SUCCESS") {


                        }
                    }
                });
                //        confirmmultideliveryaddressonfinish();

            }
            function disableOnFinish()
            {
                $.ajax({
                    url:'{!!url("/clearorderlocksperorder")!!}',
                    type: "POST",
                    data: {
                        OrderId: $('#orderId').val()
                    },
                    success: function(data){
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
                });
            }
            function empties(){
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
                var $celltheProductCode_ = $active.closest('td').find(".theProductCode_").val();

                switch(e.keyCode){
                    case 37: // <Left>
                        $next = $active.parent('td').prev().find(focusableQuery);
                        break;
                    case 33: // <Up>
                        console.debug('$celltheProductCode_******** UP'+$celltheProductCode_);
                        if ($celltheProductCode_.length < 1) {
                            $next = $active
                                .closest('tr')
                                .prev()
                                .find('td:nth-child(' + position + ')')
                                .find(focusableQuery)
                            ;
                        }

                        break;
                    case 38: // <Up>
                        if ($celltheProductCode_.length < 1) {
                            $next = $active
                                .closest('tr')
                                .prev()
                                .find('td:nth-child(' + position + ')')
                                .find(focusableQuery)
                            ;
                        }
                        break;
                    case 34: // <Right>
                        $next = $active.closest('td').next().find(focusableQuery);
                        break;
                    case 40: // <Down>
                        if ($celltheProductCode_.length < 1) {
                            $next = $active
                                .closest('tr')
                                .next()
                                .find('td:nth-child(' + position + ')')
                                .find(focusableQuery)
                            ;
                        }
                        console.debug('$celltheProductCode_******** DOWN'+$celltheProductCode_);
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
                            $('#addNewAddress').dialog('close');
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
                    var table = '<table class="table2" ><tr style="font-size: 12px;color:black"><td style="background: green;width:25px;color:white">' +
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
                var tokenId=new Date().valueOf();
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
                $('#authorisations').keydown(function(event) {
                    if (event.keyCode == 27) {
                        return false;
                    }
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
                                value.DAddress5 + '</td><td>' +
                                value.Route + '</td><td>' +
                                value.Routeid + '</td>' +
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
                            var routeids = $(this).closest('tr').find('td:eq(7)').text();
                            $('#hiddenDeliveryAddressId').val(deliveryID);
                            $('#address1hidden').val($.trim(address1));
                            $('#address2hidden').val($.trim(address2));
                            $('#address3hidden').val($.trim(address3));
                            $('#address4hidden').val($.trim(address4));
                            $('#address5hidden').val($.trim(address5));
                            $('#deliveryAddressOnOrderWithoutInoiceNo').dialog('close');
                            $('#customerSelectedDelDate').val($.trim(address1)+' '+$.trim(address2)+' '+$.trim(address3)+' '+$.trim(address4)+' '+$.trim(address4));
                            $.ajax({
                                url: '{!! url("/changerouteonorder") !!}',
                                type: "POST",
                                data: {
                                    routeId: routeids,
                                    OrderId: $('#orderId').val(),

                                },success: function (data) {
//console.debug(data);
                                    $('#routeonabutton').val(data);

                                }
                            });

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
                                $('#awaitingStockOnDispatchOrPickingForm').val('');
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
                        if(data != 'False'){disableOnFinish();
                        }
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
                        address5hidden: $('#address5hidden').val(),
                        discount: $('#dicPercHeader').val()
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

            function configFilter($this, colArray) {
                setTimeout(function () {
                    var tableName = $this[0].id;
                    var columns = $this.api().columns();
                    $.each(colArray, function (i, arg) {
                        $('#' + tableName + ' th:eq(' + arg + ')').append('<img src="http://www.icone-png.com/png/39/38556.png" class="filterIcon" onclick="showFilter(event,\'' + tableName + '_' + arg + '\')" />');
                    });

                    var template = '<div class="modalFilter">' +
                        '<div class="modal-content">' +
                        '{0}</div>' +
                        '<div class="modal-footer">' +
                        '<a href="#!" onclick="clearFilter(this, {1}, \'{2}\');"  class=" btn left waves-effect waves-light">Clear</a>' +
                        '<a href="#!" onclick="performFilter(this, {1}, \'{2}\');"  class=" btn right waves-effect waves-light">Ok</a>' +
                        '</div>' +
                        '</div>';
                    $.each(colArray, function (index, value) {
                        columns.every(function (i) {
                            if (value === i) {
                                var column = this, content = '<input type="text" class="filterSearchText" onkeyup="filterValues(this)" /> <br/>';
                                var columnName = $(this.header()).text().replace(/\s+/g, "_");
                                var distinctArray = [];
                                column.data().each(function (d, j) {
                                    if (distinctArray.indexOf(d) == -1) {
                                        var id = tableName + "_" + columnName + "_" + j; // onchange="formatValues(this,' + value + ');
                                        content += '<div><input type="checkbox" value="' + d + '"  id="' + id + '"/><label for="' + id + '"> ' + d + '</label></div>';
                                        distinctArray.push(d);
                                    }
                                });
                                var newTemplate = $(template.replace('{0}', content).replace('{1}', value).replace('{1}', value).replace('{2}', tableName).replace('{2}', tableName));
                                $('body').append(newTemplate);
                                modalFilterArray[tableName + "_" + value] = newTemplate;
                                content = '';
                            }
                        });
                    });
                }, 50);
            }
            var modalFilterArray = {};
            //User to show the filter modal
            function showFilter(e, index) {
                $('.modalFilter').hide();
                $(modalFilterArray[index]).css({ left: 0, top: 0 });
                var th = $(e.target).parent();
                var pos = th.offset();
                console.log(th);
                $(modalFilterArray[index]).width(th.width() * 0.75);
                $(modalFilterArray[index]).css({ 'left': pos.left, 'top': pos.top });
                $(modalFilterArray[index]).show();
                $('#mask').show();
                e.stopPropagation();
            }

            //This function is to use the searchbox to filter the checkbox
            function filterValues(node) {
                var searchString = $(node).val().toUpperCase().trim();
                var rootNode = $(node).parent();
                if (searchString == '') {
                    rootNode.find('div').show();
                } else {
                    rootNode.find("div").hide();
                    rootNode.find("div:contains('" + searchString + "')").show();
                }
            }

            //Execute the filter on the table for a given column
            function performFilter(node, i, tableId) {
                var rootNode = $(node).parent().parent();
                var searchString = '', counter = 0;

                rootNode.find('input:checkbox').each(function (index, checkbox) {
                    if (checkbox.checked) {
                        searchString += (counter == 0) ? checkbox.value : '|' + checkbox.value;
                        counter++;
                    }
                });
                $('#' + tableId).DataTable().column(i).search(
                    searchString,
                    true, false
                ).draw();
                rootNode.hide();
                $('#mask').hide();
            }

            //Removes the filter from the table for a given column
            function clearFilter(node, i, tableId) {
                var rootNode = $(node).parent().parent();
                rootNode.find(".filterSearchText").val('');
                rootNode.find('input:checkbox').each(function (index, checkbox) {
                    checkbox.checked = false;
                    $(checkbox).parent().show();
                });
                $('#' + tableId).DataTable().column(i).search(
                    '',
                    true, false
                ).draw();
                rootNode.hide();
                $('#mask').hide();
            }
            function PosDialog()
            {
                console.debug("I am inside POS");
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
                        $('#processingpos').show();


                        waitingInvoice();
                        setInterval( waitingInvoice , 9000 );
                    }

                });
            }

            function treatAsQuote(val) {

                $.ajax({
                    url: '{!!url("/treatAsQuote")!!}',
                    type: "POST",
                    data: {
                        isQuote: val,
                        orderId: $('#orderId').val(),

                    },
                    success: function (data) {
                        console.debug("data saved");
                    }
                });
            }
            function isAwaitingStock(val) {

                $.ajax({
                    url: '{!!url("/markitawaitingstock")!!}',
                    type: "POST",
                    data: {
                        isQuote: val,
                        orderId: $('#orderId').val(),

                    },
                    success: function (data) {
                        console.debug("data saved awaiting stock");
                    }
                });
            }

            function allInoneDocumentsave(type)
            {
                //console.debug("unsafe"+escapeHtml("this j& sb"));
                var dialog = $('<p><strong style="color:black">PLEASE WAIT...</strong></p>').dialog({
                    height: 200, width: 700, modal: true, containment: false,
                    buttons: {

                        "Okay": function () {
                            dialog.dialog('close');
                        }


                    }
                });
                var orderlines = new Array();
                var orderheaders = new Array();
                $('#table > tbody  > tr').each(function() {
                    var data = $(this);

                    var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                    var comment = $(this).closest('tr').find('.prodComment_').val();
                    //comment = comment.replace("'","");
                    console.debug($(this).closest('tr').find('.col2').val());
                    if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                        orderlines.push({
                            'productCode': escapeHtml($(this).closest('tr').find('.theProductCode_').val()),
                            'qty': $(this).closest('tr').find('.prodQty_').val(),
                            'price': $(this).closest('tr').find('.prodPrice_').val(),
                            'comment': escapeHtml(comment),
                            'orderDetailID': orderDetailID,
                            'customerCode': escapeHtml($('#inputCustAcc').val()),
                            'prodDisc': $(this).closest('tr').find('.prodDisc_').val(),
                            'OrderId':$('#orderId').val(),
                            'hiddenToken':$(this).closest('tr').find('.hiddenToken').val(),
                            'prodBulk':$(this).closest('tr').find('.prodBulk_').val(),
                            'warehouse':$(this).closest('tr').find('.col2').val()
                        });


                    }

                });


                orderheaders.push({
                    'orderDate':dateReturn($("#inputOrderDate").val()),
                    'orderId': $('#orderId').val(),
                    'deliveryDate': dateReturn($("#inputDeliveryDate").val()),
                    'OrderType': $('#orderType').val(),
                    'notification': $('#notification').val(),
                    'orderNo': (escapeHtml($('#orederNumber').val())),
                    'messagebox': (escapeHtml($('#messagebox').val())),
                    'awaitingStock': $('#awaitingStock').val(),
                    'customerCode': escapeHtml($('#inputCustAcc').val()),
                    'DeliveryAddressID': $('#hiddenDeliveryAddressId').val(),
                    'address1hidden': (escapeHtml($('#address1hidden').val())),
                    'address2hidden': (escapeHtml($('#address2hidden').val())),
                    'address3hidden':( escapeHtml($('#address3hidden').val())),
                    'address4hidden': (escapeHtml($('#address4hidden').val())),
                    'address5hidden': (escapeHtml($('#address5hidden').val())),
                    'headerWh': $('#headerWh').val(),
                    'savetype': type

                });

                console.debug(orderlines);
                console.debug(orderheaders);
                $.ajax({
                    url: '{!!url("/orderheaderAndOrderLines")!!}',
                    type: "POST",
                    data: {
                        OrderId: $('#orderId').val(),
                        orderheaders: orderheaders,
                        orderlines:orderlines,
                        type: type
                    },
                    success: function (data) {
                        console.debug("really-***********************************");
                        console.debug(data);
                        if ((data.result).indexOf("CUSTOMER_ON_HOLD") >= 0)
                        {
                            authoriseonholdaccount();

                        }else{

                            if (type == "POS"  && data.result =="SUCCESS") {
                                console.debug("I am inside POS");
                                $('#pointOfSaleDialog').show();
                                showDialog('#pointOfSaleDialog', 910, 400);
                                calculator();
                                var discount = (parseFloat($('#totalInc').val() * ($('#hiddenCustDiscount').val() / 100)).toFixed(2));


                                var totalToBeInvoiced = (parseFloat($('#totalInc').val()) - parseFloat(discount)).toFixed(2);
                                $('#posOrdernumber').val($('#orderId').val());
                                $('#posInvTotal').val($('#totalInc').val());
                                $('#confirmOnPosDialog').click(function () {


                                    if (parseFloat($('#posChange').val()).toFixed(2) < 0) {

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
                                    } else {//$('#orderId').val()
                                        $.ajax({
                                            url: '{!!url("/AssignInvoiceNumber")!!}',
                                            type: "POST",
                                            data: {
                                                orderID: $('#orderId').val()
                                            },
                                            success: function (data) {
                                                console.debug("******************************************************"+data);
                                                monitorInvoiced();
                                            }
                                        });
                                        //alert("pos clicked");

                                        var dialog = $('<p><strong style="color:black">Please Wait, Do not touch anything we are watching you...</strong></p>').dialog({
                                            height: 200, width: 700, modal: true, containment: false,
                                            buttons: {
                                                "Okay": function () {
                                                    dialog.dialog('close');
                                                },

                                            }
                                        });
                                    }
                                });

                            }
                            else
                            {
                                var dialog = $('<p><strong style="color:black">'+data.result+'<br><i style="color:red;font-weight:900">'+data.Extras+'<i></strong></p>').dialog({
                                    height: 200, width: 700, modal: true, containment: false,
                                    buttons: {
                                        "Okay": function () {
                                            dialog.dialog('close');
                                        },

                                    }
                                });
                            }

                            console.debug("YES OR NO BEFORE*************"+type);
                            if (type == "NO" || type == "YES" )
                            {

                                console.debug(data.result);
                                console.debug("YES OR NO");
                                console.debug(data.Error);
                                if (data.Error !="ALREADY INVOICED"){


                                    if(data.result !="SUCCESS" && data.result !="Success")
                                    {
                                        var dialog = $('<p><strong style="color:black">'+data.result+'</strong></p>').dialog({
                                            height: 200, width: 700, modal: true, containment: false,
                                            buttons: {
                                                "Okay": function () {
                                                    dialog.dialog('close');
                                                },

                                            }
                                        });
                                    }
                                    else
                                    {
                                        // console.debug("yes or no*************"+checkifhasmultiaddress());
                                        //   checkifhasmultiaddress();
                                        console.debug("check point ismulti***"+ismulti);
                                        $.ajax({
                                            url: '{!!url("/checkifhasmultiaddress")!!}',
                                            type: "POST",
                                            data: {
                                                account: $('#inputCustAcc').val()
                                            },
                                            success: function (data) {

                                                if (data[0].result == "SUCCESS") {
                                                    confirmmultideliveryaddressonfinish()

                                                }else{
                                                    if(hassplitorder =="LTRUE"){
                                                        splitorder();
                                                    }else{
                                                        disableOnFinish();
                                                    }
                                                }
                                            }
                                        });

                                    }
                                }else
                                {
                                    var dialog = $('<p><strong style="color:black">This order has been invoiced, staged or loaded.</strong></p>').dialog({
                                        height: 200, width: 700, modal: true, containment: false,
                                        buttons: {
                                            "Okay": function () {
                                                disableOnFinish();
                                            },

                                        }
                                    });
                                }
                            }

                            console.debug("YES OR NO AFTER*************");
                            if (type == "PDF")
                            {
                                console.debug(data.result);
                                if(data.result !="SUCCESS" && data.result !="Success")
                                {
                                    var dialog = $('<p><strong style="color:black">'+data.result+'</strong></p>').dialog({
                                        height: 200, width: 700, modal: true, containment: false,
                                        buttons: {
                                            "Okay": function () {
                                                dialog.dialog('close');
                                            },

                                        }
                                    });
                                }
                                else
                                {
                                    window.open('{!!url("/pdforder")!!}/'+$('#orderId').val(), "PDF", "location=1,status=1,scrollbars=1, width=1200,height=850");
                                    disableOnFinish();
                                }
                            }
                            if (type == "AUTHED")
                            {
                                console.debug(data.result);
                                if(data.result !="SUCCESS" && data.result !="Success")
                                {
                                    var dialog = $('<p><strong style="color:black">'+data.result+'</strong></p>').dialog({
                                        height: 200, width: 700, modal: true, containment: false,
                                        buttons: {
                                            "Okay": function () {
                                                dialog.dialog('close');
                                            },

                                        }
                                    });
                                }
                                else
                                {
                                    $.ajax({
                                        url: '{!!url("/updateallOrderlinestocostauth")!!}',
                                        type: "POST",
                                        data: {
                                            orderId: $('#orderId').val(),

                                        },
                                        success: function (data) {

                                            $.ajax({
                                                url: '{!!url("/checkifhasmultiaddress")!!}',
                                                type: "POST",
                                                data: {
                                                    account: $('#inputCustAcc').val()
                                                },
                                                success: function (data) {

                                                    if (data[0].result == "SUCCESS") {
                                                        confirmmultideliveryaddressonfinish()

                                                    }else{
                                                        if(hassplitorder =="LTRUE"){
                                                            splitorder();
                                                        }else{
                                                            disableOnFinish();
                                                        }
                                                    }
                                                }
                                            });



                                        }
                                    });


                                }
                            }
                            if (type == "INVOICEIT")
                            {

                                console.debug(data.result);
                                if(data.result !="SUCCESS")
                                {
                                    var dialog = $('<p><strong style="color:black">'+data.result+'</strong></p>').dialog({
                                        height: 200, width: 700, modal: true, containment: false,
                                        buttons: {
                                            "Okay": function () {
                                                dialog.dialog('close');
                                            },

                                        }
                                    });
                                }
                                else
                                {

                                    $.ajax({
                                        url: '{!!url("/invoicedoc")!!}',
                                        type: "POST",
                                        data: {
                                            OrderId: $('#orderId').val()
                                        },
                                        success: function (data) {
                                            disableOnFinish();
                                        }
                                    });
                                }

                            }
                            //INVOICEIT
                        }



                    }
                });

            }
            function authoriseonholdaccount()
            {
                $('#authonholdaccount').show();

                $( "#authonholdaccount" ).dialog({height: 800, modal: true, closeOnEscape: false,
                    width: 800,containment: false}).dialogExtend({
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

                $('#authonholdaccount').keydown(function(event) {
                    if (event.keyCode == 27){
                        return false;
                    }
                });
                $('#treattheauthaccountasquotation').off().click(function(){

                    $('#authonholdaccount').dialog('close');
                    treatAsQuote(1);
                    $('#treatAsQuote').prop('checked', true);
                    allInoneDocumentsave("NO");


                });
                $('#doAuthZeroonholdaccount').off().click(function(){

                    $('#onholdaccountmanagerpassword').val();
                    $.ajax({
                        url: '{!!url("/verifyAuthCreditors")!!}' ,
                        type: "POST",
                        data:{userName:$('#onholdaccountmanagername').val(),
                            userPassword:$('#onholdaccountmanagerpassword').val(),
                            OrderId:$('#orderId').val()},
                        success: function(data){

                            if (data.done=="DONE") {

                                $('#onholdaccountmanagername').val('');
                                $('#onholdaccountmanagerpassword').val('');

                                consoleManagementAuths('{!!url("/logMessageAjax")!!}', 12, 1, 'Account on hold authorised by ' + data.result[0].UserName,
                                    0, $('#orderId').val(), 0, $('#inputCustAcc').val(), 0, 0, 0, $('#onholdaccountmanagername').val(), $('#orderId').val(), 0, computerName, $('#orderId').val(), 0, data.result[0].UserID, data.result[0].UserName);
                                $("#authonholdaccount").dialog('close');
                                allInoneDocumentsave("NO");


                            }else
                            {
                                alert("SOMETHING WENT WRONG,PLEASE TRY AGAIN ");
                            }
                        }
                    });

                });

            }
            function authorZeroCostOnSaving(data)
            {
                var trHTML = '';

                $('#productwithzerocost').empty();
                $('#productwithzerocost').show();
                $.each(data, function (key, value) {
                    trHTML +='<tr style="font-size: 12px;color: black;background: lightgrey;font-family: Roboto;font-weight: normal" >'+
                        '<td style="">'+value.PastelCode+'</td>'+
                        '<td style="">'+value.PastelDescription+'</td>'+

                        '</tr>';

                });

                $('#productwithzerocost').append(trHTML);
                $('#authItemsWithzerocosts').show();

                $( "#authItemsWithzerocosts" ).dialog({height: 800, modal: true, closeOnEscape: false,
                    width: 800,containment: false}).dialogExtend({
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

                $('#authItemsWithzerocosts').keydown(function(event) {
                    if (event.keyCode == 27){
                        return false;
                    }
                });
                $('#cancelzerocostdialod').off().click(function(){

                    $('#authItemsWithzerocosts').dialog('close');

                });
                $('#doAuthZerocost').off().click(function(){

                    $('#zerocostmanagerpassword').val();
                    $.ajax({
                        url: '{!!url("/AuthBulkZeroCost")!!}' ,
                        type: "POST",
                        data:{
                            userName:$('#zerocostmanagername').val(),
                            userPassword:$('#zerocostmanagerpassword').val(),
                            OrderId:$('#orderId').val()},
                        success: function(data){

                            if (data.done=="DONE") {

                                $('#zerocostmanagername').val('');
                                $('#zerocostmanagerpassword').val('');

                                consoleManagementAuths('{!!url("/logMessageAjax")!!}', 12, 1, 'Zero Cost On Bulk Authorization authorized by ' + data.result[0].UserName,
                                    0, $('#orderId').val(), 0, $('#inputCustAcc').val(), 0, 0, 0, $('#zerocostmanagername').val(), $('#orderId').val(), 0, computerName, $('#orderId').val(), 0, data.result[0].UserID, data.result[0].UserName);
                                $("#authItemsWithzerocosts").dialog('close');
                                allInoneDocumentsave("AUTHED");


                            }else
                            {
                                alert("SOMETHING WENT WRONG,PLEASE TRY AGAIN ");
                            }
                        }
                    });

                });

            }
            function splitorder()
            {

                $.ajax({
                    url: '{!!url("/splitorders")!!}',
                    type: "POST",
                    data: {
                        orderID: $('#orderId').val()
                    },
                    success: function (data) {

                        if(data.length > 0) {
                            var trHTML = '';
                            $('#griditemoutofstock').empty();
                            $('#itemoutofstock').show(); //table
                            $("#itemoutofstock").dialog({
                                height: 800, modal: true, closeOnEscape: false,
                                width: 800, containment: false
                            }).dialogExtend({
                                "closable": false, // enable/disable close button
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
                            $.each(data, function (key, value) {
                                trHTML += '<tr style="font-size: 13px !important;color: black;background: lightgrey;font-weight: normal" >' +
                                    '<td style="">' + value.strPastelCustomerCode + '</td>' +
                                    '<td style="font-size: 13px !important;">' + value.strPastelDescription + '</td>' +
                                    '<td style="">' + value.dblQtyOrdered + '</td>' +
                                    '<td style="">' + value.dblQtyAvailable + '</td>' +
                                    '<td style="">' + value.dblQtyOnHand + '</td>' +
                                    '<td style=""><input type="number" class="quantitynew" min="0" max="' + value.dblQty + '"  value="' + value.dblQty + '"</td>' +
                                    '<td style=""><input type="checkbox" style="width:80px; height: 18px !important;" name="OrderDetailId" value="' + value.OrderDetailId + '"> </td>' +
                                    '</tr>';

                            });
                            $('#griditemoutofstock').append(trHTML);

                            $('#splitorder').click(function () {
                                var favorite = [];
                                $.each($("input[name='OrderDetailId']:checked"), function () {
                                    var orderdedatilId = $(this).val();
                                    favorite.push({
                                        'qty': $(this).closest('tr').find('.quantitynew').val(),
                                        'orderdedatilId': orderdedatilId,
                                    });

                                });
                                $.ajax({
                                    url: '{!!url("/splitordersmake")!!}',
                                    type: "POST",
                                    data: {
                                        backorder: favorite,
                                        orderID: $('#orderId').val()
                                    },
                                    success: function (data) {
                                        disableOnFinish();
                                    }
                                });

                            });

                            $('#cancelsplitorder').click(function () {
                                $("#itemoutofstock").dialog('close');
                                disableOnFinish();
                            });
                        }else{
                            disableOnFinish();
                        }

                    }
                });

            }
            function saveorderswithoutExtras(){

                var orderlines = new Array();
                var orderheaders = new Array();
                $('#table > tbody  > tr').each(function() {
                    var data = $(this);

                    var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                    var comment = $(this).closest('tr').find('.prodComment_').val();
                    //comment = comment.replace("'","");
                    console.debug($(this).closest('tr').find('.col2').val());
                    if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                        orderlines.push({
                            'productCode': escapeHtml($(this).closest('tr').find('.theProductCode_').val()),
                            'qty': $(this).closest('tr').find('.prodQty_').val(),
                            'price': $(this).closest('tr').find('.prodPrice_').val(),
                            'comment': escapeHtml(comment),
                            'orderDetailID': orderDetailID,
                            'customerCode': escapeHtml($('#inputCustAcc').val()),
                            'prodDisc': $(this).closest('tr').find('.prodDisc_').val(),
                            'OrderId':$('#orderId').val(),
                            'hiddenToken':$(this).closest('tr').find('.hiddenToken').val(),
                            'prodBulk':$(this).closest('tr').find('.prodBulk_').val(),
                            'warehouse':$(this).closest('tr').find('.col2').val()
                        });


                    }

                });


                orderheaders.push({
                    'orderDate':dateReturn($("#inputOrderDate").val()),
                    'orderId': $('#orderId').val(),
                    'deliveryDate': dateReturn($("#inputDeliveryDate").val()),
                    'OrderType': $('#orderType').val(),
                    'notification': $('#notification').val(),
                    'orderNo': (escapeHtml($('#orederNumber').val())),
                    'messagebox': (escapeHtml($('#messagebox').val())),
                    'awaitingStock': $('#awaitingStock').val(),
                    'customerCode': escapeHtml($('#inputCustAcc').val()),
                    'DeliveryAddressID': $('#hiddenDeliveryAddressId').val(),
                    'address1hidden': (escapeHtml($('#address1hidden').val())),
                    'address2hidden': (escapeHtml($('#address2hidden').val())),
                    'address3hidden':( escapeHtml($('#address3hidden').val())),
                    'address4hidden': (escapeHtml($('#address4hidden').val())),
                    'address5hidden': (escapeHtml($('#address5hidden').val())),
                    'headerWh': $('#headerWh').val(),
                    'savetype': "YES"

                });

                console.debug(orderlines);
                console.debug(orderheaders);
                $.ajax({
                    url: '{!!url("/orderheaderAndOrderLines")!!}',
                    type: "POST",
                    data: {
                        OrderId: $('#orderId').val(),
                        orderheaders: orderheaders,
                        orderlines: orderlines,
                        type: "YES"
                    },
                    success: function (data) {
                        //data.result
                        var rsult = data.result;
                        if(rsult.toUpperCase() !="SUCCESS" )
                        {
                            var dialog = $('<p><strong style="color:black">'+data.result+'</strong></p>').dialog({
                                height: 200, width: 700, modal: true, containment: false,
                                buttons: {
                                    "Okay": function () {
                                        dialog.dialog('close');
                                    },

                                }
                            });
                        }else{

                            $('#table tbody').empty();
                            getLineDetailsOly()
                        }
                    }
                });
            }
            function saveorderswithoutExtrasPDF(){

                var orderlines = new Array();
                var orderheaders = new Array();
                $('#table > tbody  > tr').each(function() {
                    var data = $(this);

                    var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
                    var comment = $(this).closest('tr').find('.prodComment_').val();
                    //comment = comment.replace("'","");
                    console.debug($(this).closest('tr').find('.col2').val());
                    if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
                        orderlines.push({
                            'productCode': escapeHtml($(this).closest('tr').find('.theProductCode_').val()),
                            'qty': $(this).closest('tr').find('.prodQty_').val(),
                            'price': $(this).closest('tr').find('.prodPrice_').val(),
                            'comment': escapeHtml(comment),
                            'orderDetailID': orderDetailID,
                            'customerCode': escapeHtml($('#inputCustAcc').val()),
                            'prodDisc': $(this).closest('tr').find('.prodDisc_').val(),
                            'OrderId':$('#orderId').val(),
                            'hiddenToken':$(this).closest('tr').find('.hiddenToken').val(),
                            'prodBulk':$(this).closest('tr').find('.prodBulk_').val(),
                            'warehouse':$(this).closest('tr').find('.col2').val()
                        });


                    }

                });


                orderheaders.push({
                    'orderDate':dateReturn($("#inputOrderDate").val()),
                    'orderId': $('#orderId').val(),
                    'deliveryDate': dateReturn($("#inputDeliveryDate").val()),
                    'OrderType': $('#orderType').val(),
                    'notification': $('#notification').val(),
                    'orderNo': (escapeHtml($('#orederNumber').val())),
                    'messagebox': (escapeHtml($('#messagebox').val())),
                    'awaitingStock': $('#awaitingStock').val(),
                    'customerCode': escapeHtml($('#inputCustAcc').val()),
                    'DeliveryAddressID': $('#hiddenDeliveryAddressId').val(),
                    'address1hidden': (escapeHtml($('#address1hidden').val())),
                    'address2hidden': (escapeHtml($('#address2hidden').val())),
                    'address3hidden':( escapeHtml($('#address3hidden').val())),
                    'address4hidden': (escapeHtml($('#address4hidden').val())),
                    'address5hidden': (escapeHtml($('#address5hidden').val())),
                    'headerWh': $('#headerWh').val(),
                    'savetype': "YES"

                });

                console.debug(orderlines);
                console.debug(orderheaders);
                $.ajax({
                    url: '{!!url("/orderheaderAndOrderLines")!!}',
                    type: "POST",
                    data: {
                        OrderId: $('#orderId').val(),
                        orderheaders: orderheaders,
                        orderlines: orderlines,
                        type: "YES"
                    },
                    success: function (data) {
                        //data.result
                        var rsult = data.result;
                        if(rsult.toUpperCase() !="SUCCESS" )
                        {
                            var dialog = $('<p><strong style="color:black">'+data.result+'</strong></p>').dialog({
                                height: 200, width: 700, modal: true, containment: false,
                                buttons: {
                                    "Okay": function () {
                                        dialog.dialog('close');
                                    },

                                }
                            });
                        }else{

                            $('#table tbody').empty();
                            getLineDetailsOlyPDF()
                        }
                    }
                });
            }
            // I need to start Utilizing this
            function getLineDetailsOly(){
                $.ajax({
                    url: '{!!url("/onCheckOrderHeaderDetails")!!}',
                    type: "POST",
                    data: {orderId: $('#orderId').val()},
                    success: function (dataDetails) {
                        InvoiceTotalPriceExcl = 0;
                        InvoiceTotalPriceInc = 0;
                        $.each(dataDetails, function (keyDetails, valueDetails) {
                            var tokenId=new Date().valueOf();
                            var props = '';
                            console.debug("------------------------------------------------------"+isAllowedToChangeInv);
                            if (($('#invoiceNo').val()).length > 2 && isAllowedToChangeInv != 1) {
                                props = "disabled";

                            }
                            console.debug("************************************ AUTMUTLIWAREHOUSE"+multiLines);
                            if (($('#invoiceNo').val()).length > 2)
                            {
                                $("#inputDeliveryDate").prop("disabled", true);
                                $("#inputOrderDate").prop("disabled", true);
                            }
                            if (multiLines ==1)
                            {
                                var classAnonymouscols="anonymouscols";
                            }else
                            {
                                var classAnonymouscols="anonymouscolsOff";
                            }
                            var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
                                '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_' + tokenId + '" class="theProductCode_ set_autocomplete inputs" value="' + valueDetails.PastelCode + '" ' + props + ' ><br><input name="col1" id ="col1'+tokenId+'" class="col1 '+classAnonymouscols+'"  readonly></td>' +
                                '<td contenteditable="false" class="col-md-4"><input name="prodDescription_" id ="prodDescription_' + tokenId + '" class="prodDescription_ set_autocomplete inputs" value="' + valueDetails.PastelDescription + '" ' + props + ' ><br><input name="col8" id ="col8'+tokenId+'" class="col8 '+classAnonymouscols+'" readonly></td>' +
                                '<td  style="" contenteditable="false" class="col-md-1"><input type="text" name="prodBulk_"  id ="prodBulk_' + tokenId + '" class="prodBulk_ resize-input-inside"  value="' + valueDetails.UnitCount + '" '+ props + ' readonly><br><input name="col3" id ="col3'+tokenId+'" class="col3 '+classAnonymouscols+'" readonly></td>' +
                                '<td  contenteditable="false" class="col-md-1"><input type="text" name="prodQty_" id ="prodQty_' + tokenId + '"   onkeypress="return isFloatNumber(this,event)"  class="prodQty_ resize-input-inside inputs" value="' + (parseFloat(valueDetails.Qty)).toFixed(3) + '" ' + props + '><br><input name="col4" id ="col4'+tokenId+'" class="col4 '+classAnonymouscols+'" readonly></td>' +
                                '<td  contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" value="' + (parseFloat(valueDetails.Price)).toFixed(2) + '" ' + props + '><br><input name="col1" id ="col1'+tokenId+'" class="col1 '+classAnonymouscols+'" readonly></td>' +
                                '<td  contenteditable="false"  class="col-md-1"><input type="text" name="prodDisc_" id ="prodDisc_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside inputs" value="' + valueDetails.LineDisc + '" ' + props + ' {{$discountProperty}}><br><input name="col6" id ="col6'+tokenId+'" class="col6 '+classAnonymouscols+'" style="color: brown;" readonly></td>' +
                                '<td  contenteditable="false"  class="col-md-1"><input  type="text" name="prodUnitSize_" id ="prodUnitSize_' + tokenId + '" class="prodUnitSize_ resize-input-inside inputs" value="' + valueDetails.UnitSize + '" ' + props + ' ></td>' +
                                '<td contenteditable="false"  class="col-md-1"><input type="text" name="instockReadOnly" id ="instockReadOnly_' + tokenId + '" value="' + valueDetails.QtyInStock + '"  class="instockReadOnly_ resize-input-inside inputs" style="font-weight: 800;width: 80%;color:blue;"><select name="col2" id ="col2'+tokenId+'" class="col2 '+classAnonymouscols+'"><option value="' + valueDetails.ID + '" >"' + valueDetails.Warehouse + '"</option> </select>' +
                                '<td contenteditable="false"  class="col-md-1"><input type="text" name="additionalcost_" id ="additionalcost_' + tokenId + '" value ="" class="additionalcost_ resize-input-inside inputs" style="font-weight: 800;font-size:8px !important;color:blue;">' +
                                '<td  contenteditable="false" class="col-md-3"><input type="text" name="prodComment_" id ="prodComment_' + tokenId + '" class="prodComment_ resize-input-inside last inputs" title="' + valueDetails.Comment + '"  value="' + valueDetails.Comment + '" ' + props + ' ><br><input name="col9" id ="col9'+tokenId+'" class="col9 '+classAnonymouscols+'" readonly></td>' +
                                '<td><input type="hidden" id="title_' + tokenId + '" class="title" value="" /><input type="hidden" id="theOrdersDetailsId" value="' + valueDetails.OrderDetailId + '" /><input type="hidden" id ="taxCode' + tokenId + '" value="' + valueDetails.Tax + '" class="taxCodes" />' +
                                '<input type="hidden" id ="cost_' + tokenId + '" value="' + valueDetails.Cost + '" class="costs" /><input type="hidden" id ="inStock_' + tokenId + '" value="' + valueDetails.QtyInStock + '" class="inStock" style="color:blue !important" /><input type="hidden" value ="' + tokenId + '" class="hiddenToken" />' +
                                '<input type="hidden" id ="priceholder_' + tokenId + '" value="' + (parseFloat(valueDetails.Price)).toFixed(2) + '" class="priceholder" />' +
                                '<input type="hidden" id ="alcohol_' + tokenId + '" value="" class="alcohol" /><input type="hidden" id ="margin_' + tokenId + '" value="" class="margin" />' +
                                '<input type="hidden" id ="soldByWieght' + tokenId + '" value="" class="soldByWieght" />' +
                                '<input type="hidden" id ="unitWeight' + tokenId + '" value="" class="unitWeight" />' +
                                '<input type="hidden" id ="strBulkUnit' + tokenId + '" value="" class="strBulkUnit" />' +
                                '<input type="hidden" id ="prohibited_' + tokenId + '" value="" class="prohibited" />' +
                                '<input type="hidden" id ="productmarginauth' + tokenId + '" value="1" class="productmarginauth" />' +
                                '<button type="button" id="deleteaLine" value="' + valueDetails.OrderDetailId + '" class="getOrderDetailLine btn-warning" >Delete</button>' +
                                '</td></tr>');
                            $('#table tbody').append($row);


                            var txt = valueDetails.Warehouse;//$("#headerWh option:selected").text();
                            var val = valueDetails.ID;
                            $("#col2"+tokenId).append("<option value='"+val+"'>" + txt + "</option>");
                            $.each(wareautocomplete, function (i, item) {
                                $("#col2"+tokenId).append("<option value='"+item.ID+"'>" + item.Warehouse + "</option>");
                            });
                            var Ltot = valueDetails.Qty * valueDetails.Price;
                            $("#col6"+tokenId).val(Ltot.toFixed(2));

                        });
                        calculator();
                        //Douwnload Excel
                        window.location ='{!!url("/exportorder")!!}/'+$('#orderId').val();


                    }

                });
            }
            function getLineDetailsOlyPDF(){
                $.ajax({
                    url: '{!!url("/onCheckOrderHeaderDetails")!!}',
                    type: "POST",
                    data: {orderId: $('#orderId').val()},
                    success: function (dataDetails) {
                        InvoiceTotalPriceExcl = 0;
                        InvoiceTotalPriceInc = 0;
                        $.each(dataDetails, function (keyDetails, valueDetails) {
                            var tokenId=new Date().valueOf();
                            var props = '';
                            console.debug("------------------------------------------------------"+isAllowedToChangeInv);
                            if (($('#invoiceNo').val()).length > 2 && isAllowedToChangeInv != 1) {
                                props = "disabled";

                            }
                            console.debug("************************************ AUTMUTLIWAREHOUSE"+multiLines);
                            if (($('#invoiceNo').val()).length > 2)
                            {
                                $("#inputDeliveryDate").prop("disabled", true);
                                $("#inputOrderDate").prop("disabled", true);
                            }
                            if (multiLines ==1)
                            {
                                var classAnonymouscols="anonymouscols";
                            }else
                            {
                                var classAnonymouscols="anonymouscolsOff";
                            }
                            var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
                                '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_' + tokenId + '" class="theProductCode_ set_autocomplete inputs" value="' + valueDetails.PastelCode + '" ' + props + ' ><br><input name="col1" id ="col1'+tokenId+'" class="col1 '+classAnonymouscols+'"  readonly></td>' +
                                '<td contenteditable="false" class="col-md-4"><input name="prodDescription_" id ="prodDescription_' + tokenId + '" class="prodDescription_ set_autocomplete inputs" value="' + valueDetails.PastelDescription + '" ' + props + ' ><br><input name="col8" id ="col8'+tokenId+'" class="col8 '+classAnonymouscols+'" readonly></td>' +
                                '<td  style="" contenteditable="false" class="col-md-1"><input type="text" name="prodBulk_"  id ="prodBulk_' + tokenId + '" class="prodBulk_ resize-input-inside"  value="' + valueDetails.UnitCount + '" '+ props + ' readonly><br><input name="col3" id ="col3'+tokenId+'" class="col3 '+classAnonymouscols+'" readonly></td>' +
                                '<td  contenteditable="false" class="col-md-1"><input type="text" name="prodQty_" id ="prodQty_' + tokenId + '"   onkeypress="return isFloatNumber(this,event)"  class="prodQty_ resize-input-inside inputs" value="' + (parseFloat(valueDetails.Qty)).toFixed(3) + '" ' + props + '><br><input name="col4" id ="col4'+tokenId+'" class="col4 '+classAnonymouscols+'" readonly></td>' +
                                '<td  contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" value="' + (parseFloat(valueDetails.Price)).toFixed(2) + '" ' + props + '><br><input name="col1" id ="col1'+tokenId+'" class="col1 '+classAnonymouscols+'" readonly></td>' +
                                '<td  contenteditable="false"  class="col-md-1"><input type="text" name="prodDisc_" id ="prodDisc_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside inputs" value="' + valueDetails.LineDisc + '" ' + props + ' {{$discountProperty}}><br><input name="col6" id ="col6'+tokenId+'" class="col6 '+classAnonymouscols+'" style="color: brown;" readonly></td>' +
                                '<td  contenteditable="false"  class="col-md-1"><input  type="text" name="prodUnitSize_" id ="prodUnitSize_' + tokenId + '" class="prodUnitSize_ resize-input-inside inputs" value="' + valueDetails.UnitSize + '" ' + props + ' ></td>' +
                                '<td contenteditable="false"  class="col-md-1"><input type="text" name="instockReadOnly" id ="instockReadOnly_' + tokenId + '" value="' + valueDetails.QtyInStock + '"  class="instockReadOnly_ resize-input-inside inputs" style="font-weight: 800;width: 80%;color:blue;"><select name="col2" id ="col2'+tokenId+'" class="col2 '+classAnonymouscols+'"><option value="' + valueDetails.ID + '" >"' + valueDetails.Warehouse + '"</option> </select>' +
                                '<td contenteditable="false"  class="col-md-1"><input type="text" name="additionalcost_" id ="additionalcost_' + tokenId + '" value ="" class="additionalcost_ resize-input-inside inputs" style="font-weight: 800;font-size:8px !important;color:blue;">' +
                                '<td  contenteditable="false" class="col-md-3"><input type="text" name="prodComment_" id ="prodComment_' + tokenId + '" class="prodComment_ resize-input-inside last inputs" title="' + valueDetails.Comment + '"  value="' + valueDetails.Comment + '" ' + props + ' ><br><input name="col9" id ="col9'+tokenId+'" class="col9 '+classAnonymouscols+'" readonly></td>' +
                                '<td><input type="hidden" id="title_' + tokenId + '" class="title" value="" /><input type="hidden" id="theOrdersDetailsId" value="' + valueDetails.OrderDetailId + '" /><input type="hidden" id ="taxCode' + tokenId + '" value="' + valueDetails.Tax + '" class="taxCodes" />' +
                                '<input type="hidden" id ="cost_' + tokenId + '" value="' + valueDetails.Cost + '" class="costs" /><input type="hidden" id ="inStock_' + tokenId + '" value="' + valueDetails.QtyInStock + '" class="inStock" style="color:blue !important" /><input type="hidden" value ="' + tokenId + '" class="hiddenToken" />' +
                                '<input type="hidden" id ="priceholder_' + tokenId + '" value="' + (parseFloat(valueDetails.Price)).toFixed(2) + '" class="priceholder" />' +
                                '<input type="hidden" id ="alcohol_' + tokenId + '" value="" class="alcohol" /><input type="hidden" id ="margin_' + tokenId + '" value="" class="margin" />' +
                                '<input type="hidden" id ="soldByWieght' + tokenId + '" value="" class="soldByWieght" />' +
                                '<input type="hidden" id ="unitWeight' + tokenId + '" value="" class="unitWeight" />' +
                                '<input type="hidden" id ="strBulkUnit' + tokenId + '" value="" class="strBulkUnit" />' +
                                '<input type="hidden" id ="prohibited_' + tokenId + '" value="" class="prohibited" />' +
                                '<input type="hidden" id ="productmarginauth' + tokenId + '" value="1" class="productmarginauth" />' +
                                '<button type="button" id="deleteaLine" value="' + valueDetails.OrderDetailId + '" class="getOrderDetailLine btn-warning" >Delete</button>' +
                                '</td></tr>');
                            $('#table tbody').append($row);


                            var txt = valueDetails.Warehouse;//$("#headerWh option:selected").text();
                            var val = valueDetails.ID;
                            $("#col2"+tokenId).append("<option value='"+val+"'>" + txt + "</option>");
                            $.each(wareautocomplete, function (i, item) {
                                $("#col2"+tokenId).append("<option value='"+item.ID+"'>" + item.Warehouse + "</option>");
                            });
                            var Ltot = valueDetails.Qty * valueDetails.Price;
                            $("#col6"+tokenId).val(Ltot.toFixed(2));

                        });
                        calculator();
                        //Douwnload Excel


                    }

                });
            }
            function dateReturn(dates)
            {
                //27-02-2019
                var datearray = dates.split("-");
                if (datearray[0].length > 2){
                    var newdateDelivDate = dates;
                }
                else {
                    var newdateDelivDate = datearray[2] + '-' + datearray[1] + '-' + datearray[0];
                }


                return newdateDelivDate
            }
            function monitorInvoiced()
            {
                //AssignInvoiceNumber

                $.ajax({
                    url: '{!!url("/checkifInvoiced")!!}' ,
                    type: "POST",
                    data:{orderID: $('#orderId').val()
                    },
                    success: function(data){

                        if(data != 'False'){

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

                                    disableOnFinish();

                                }
                            });

                        }else
                        {
                            if (spool > 3)
                            {
                                var dialog = $('<p><strong style="color:black">Printing problem</strong></p>').dialog({
                                    height: 200, width: 700, modal: true, containment: false,
                                    buttons: {
                                        "Okay": function () {
                                            dialog.dialog('close');
                                        },

                                    }
                                });
                            }else {
                                spool++;
                                setInterval( monitorInvoiced , 3000 );
                            }

                        }
                    }
                });
            }
            function escapeHtml(unsafe) {
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }
            function productRules(authtype,price,productcode,tax,cost,productgp,themessage, available,mustauthstocklines){
                var passedChecks= true;
                var returnedErrorMessage = "";
                console.debug("product rule tag cost "  + cost);
                console.debug("product rule tag price "  + price);
                console.debug("product rule tag productgp "  + productgp);

                switch(authtype){
                    case "stock":
                        if (available <= 0 && mustauthstocklines != 0){
                            passedChecks= false;

                            returnedErrorMessage +=" Stock Availability Error \n";
                        }
                        break;
                    case "price":

                        if (price.length<=0 ){
                            price = 0;
                            passedChecks= false;
                            returnedErrorMessage +=" Pricing Data Error \n";
                        }
                        if (price <= 0){
                            passedChecks= false;
                            returnedErrorMessage +=" Pricing Error \n";
                        }

                        if (cost <= 0 ){
                            passedChecks= false;
                            returnedErrorMessage +=" Cost Error \n";
                        }

                        if (productgp == 0 ){
                            passedChecks= false;
                            returnedErrorMessage +=" GP is 0 Error \n";
                        }

                        if (marginCalculator(cost,price) < productgp){
                            passedChecks= false;
                            returnedErrorMessage +=" GP is too low Error \n";
                        }

                        if(themessage=="NEEDAUTH"){
                            passedChecks= false;
                            returnedErrorMessage +=" Item needs authorisation \n";
                        }
                        break;
                }

                if(passedChecks)
                {
                    return "";
                }
                else
                {
                    return returnedErrorMessage;
                }//column name



            }
            function authPriceByTeamLeaders()
            {
                if((parseFloat(Productmargin)  > parseFloat(margin).toFixed(2)) && auth.length>4  )
                {
                    $('#MarginProblems').show();
                    $('#userAuthProhibitedCred_marg').val('');
                    $('#userAuthPassWordCredit_marg').val('');
                    showDialogWithoutClose('#MarginProblems',400,400);
                    $('#MarginProblems').keydown(function(event) {
                        if (event.keyCode == 27){
                            return false;
                        }
                    });
                    $('#doAuthCredits').off().click(function(){

                        $.ajax({
                            url: '{!!url("/verifyAuthGroupLeaders")!!}' ,
                            type: "POST",
                            data:{ userName:$('#userAuthProhibitedCred_marg').val(),
                                userPassword:$('#userAuthPassWordCredit_marg').val(),
                                orderId:$('#orderId').val()
                            },
                            success: function(data){
                                if ($.isEmptyObject(data)){
                                    alert("Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                                }else
                                {
                                    $('#margin_auth').val(1);
                                    consoleManagementAuths('{!!url("/logMessageAuthMargin")!!}',12,1,'Authorized Product ('+theProductCode+') Margin ( LM :'+margin+' PM '+Productmargin+')  by '+data[0].UserName,
                                        0,$('#orderId').val(),'',$('#inputCustAcc').val(),0,0,0,$('#userAuthProhibitedCred_marg').val(),$('#orderId').val(),0,computerName,$('#orderId').val(),0,data[0].UserID,data[0].UserName);
                                    $("#MarginProblems").dialog('close');
                                    $this.closest('tr').find('.title').val('');



                                    //calculator();
                                }
                            }
                        });

                    });
                    $('#doCancelAuthCredits').off().click(function(){
                        $this.closest('tr').find('.prodPrice_').val('');
                        $this.closest('tr').find('.prodPrice_').select();
                        $this.closest('tr').find('.prodPrice_').focus();
                        $('#MarginProblems').dialog('close');
                    });
                }
            }

            $(document).keydown(function(e) {
                if (e.keyCode == 27) return false;
            });

        </script>

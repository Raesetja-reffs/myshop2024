<div class="col-lg-12" id="prodOnOrder" title="Products on Sales Order" style="background: darkgoldenrod">
    <form>
        <fieldset class="well" style="    background: #e8e8e8;">
            <a href='{!!url("/warehouseitems")!!}' onclick="window.open(this.href, 'briefcase','left=20,top=20,width=1400,height=950,toolbar=1,resizable=0'); return false;">Advanced</a>
            <legend class="well-legend">Search</legend>
                <div class="col-md-12">
                    <div class="form-group col-md-4">
                        <label class="control-label" for="productCodeOnOrder"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Product Code</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="productCodeOnOrder" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label" for="productDescOnOrder"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Product Desc</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="productDescOnOrder" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group col-md-4">
                        <label class="control-label" for="custCodeOnOrder"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Code</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="custCodeOnOrder" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label" for="custDescOnOrder"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Desc</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="custDescOnOrder" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                    </div>
                    <div class="form-group col-md-4">
                        <button type="button" id="callSpOnOrder" class="btn-xs btn-success">GO</button>
                    </div>
                </div>

        </fieldset>
    </form>

    <div id="gridContainer" style="height: 590px;"></div>

    {{-- <table class="table  search-table" id="tblOnsalesOrder" style=" color: black;overflow-y: scroll; width: 100%;font-family: sans-serif; font-weight: 700;font-size: 36px;" tabindex=0>
        <thead>

            <tr style="font-size: 17px;">
                <th class="col-sm-1">Order Id</th>
                <th class="col-sm-1">Order Date</th>
                <th class="col-sm-1">Delivery Date</th>
                <th >Cust Code</th>
                <th class="col-md-3">Store Name</th>
                <th>Awaiting Stock</th>
                <th>Qty</th>
                <th>In Stock</th>
                <th>Prod Code</th>
                <th class="col-md-4">Prod Description</th>
                <th>Comment</th>
                <th>Nett</th>
                <th>Back Order</th>
            </tr>
        </thead>
    </table> --}}
</div>

<div id="dispatchQuantityForm" title="Dispatch Form">
    <div class="col-lg-12">
        <div class="col-lg-7">
            <fieldset class="well">
                <legend class="well-legend">Customer Information</legend>
                <div>
                    <form>
                        <div class="form-group  col-md-2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                            <label class="control-label" for="inputCustAccD"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Account</label>
                            <input type="text" name="inputCustAccD" class="form-control input-sm col-xs-1" id="inputCustAccD" style="height:22px;font-size: 8px;">
                        </div>
                        <div class="form-group col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                            <label class="control-label" for="inputCustNameD"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Name</label>
                            <input type="text" name="inputCustNameD" class="form-control input-sm col-xs-1" id="inputCustNameD" style="height:22px;font-size: 8px;">
                            <input type="hidden" name="customerEmail" class="form-control input-sm col-xs-1" id="customerEmail" >
                        </div>
                    </form>
                </div>
                <div>
                    <form>
                        <div class="form-group  col-md-2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                            <label class="control-label" for="orderIds"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order</label>
                            <input type="text" name="orderIds" class="form-control input-sm col-xs-1" id="orderIds" style="height:22px;font-size: 8px;" readonly>
                            <input type="hidden" name="invNo" class="form-control input-sm col-xs-1" id="invNo" style="height:22px;font-size: 8px;">
                        </div>

                    </form>
                </div>
                <div>
                    <form>
                        <div class="form-group  col-md-2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;display:none;">
                            <label class="control-label" for="custCreditLimit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Crd Lmt</label>
                            <input type="text" name="custCreditLimit" class="form-control input-sm col-xs-1" id="custCreditLimit" style="height:22px;font-size: 8px;">
                        </div>
                        <div class="form-group col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                            <label class="control-label" for="DeliveryDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                            <input type="text" name="DeliveryDate" class="form-control input-sm col-xs-1" id="DeliveryDate" style="height:22px;font-size: 8px;">
                            <input type="hidden" name="customerEmail" class="form-control input-sm col-xs-1" id="customerEmail" >
                        </div>
                    </form>
                </div>
            </fieldset>
        </div>
        <div class="col-lg-5">
            <fieldset class="well">
                <legend class="well-legend">Filters</legend>
                <form>
                    <div class="form-group col-md-4"  style="display:none;margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="pickingTeam"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Search by OrderId</label>
                        <input id="serchByOrderId" class="form-control input-sm col-xs-1" style="height:22px;font-size: 10px;">
                        <select name="pickingTeam" class="form-control input-sm col-xs-1" id="pickingTeam" style="display:none;height:22px;font-size: 8px;"></select>
                    </div>
                    <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="inputCustCustomers"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customers</label>
                        <input type="text" name="inputCustCustomers" class="form-control input-sm col-xs-1" id="inputCustCustomers" style="height:22px;font-size: 10px;">
                    </div>
                    <div class="form-group col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="custDescriptionListOfOrder"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order IDs</label>
                        <select name="custDescriptionListOfOrder" class="form-control input-sm col-xs-1" id="custDescriptionListOfOrder" style="font-size: 9px;"></select>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
    <div class="col-lg-12" style="overflow-y: scroll;height:60%">
        <table id="tableDispatch" class="table table-bordered table-condensed" style="font-family: sans-serif;color:black;">
            <thead>
            <tr>
                <th>Code</th>
                <th class="col-md-3">Description</th>
                <th class="col-md-1">Dispatch</th>
                <th style="display: none;" class="col-md-1">Bulk</th>
                <th class="col-md-1">Price</th>
                <th style="display: none;" class="col-md-1">Disc %</th>
                <th class="col-md-1">Unit Size</th>
                <th class="col-md-1">In Stock</th>
                <th class="col-md-3">Comment</th>
                <th class="col-md-1 table-header">Actions</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="col-lg-12" style="background: #ececec">
        <div class="col-lg-3" >
            <table class="table" style="font-size: 10px;">
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
        <div class="col-lg-3">
            <div class="form-group ">
                <label class="control-label" for="dispatchMessage"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Message</label>
                <textarea id="dispatchMessage" class="form-control input-sm col-xs-1"></textarea>

            </div>
            <div class="form-group ">
                <label class="control-label" for="orderNumberOnDispatch"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Number</label>
                <input id="orderNumberOnDispatch" class="form-control input-sm col-xs-1" maxlength="18"><span id="characters"></span>/18

            </div>

        </div>
        <div class="col-lg-3">
            <div class="form-group ">
                <label class="control-label" for="dispatchMessage"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Awaiting Stock</label>
                <input type="checkbox" id="awaitingStockOnDispatchOrPickingForm" >
            </div>
            <div class="form-group ">
                <p id="creditLimitWarningMessage" style="color:red;font-family: monospace;    font-size: 12px;"></div>
        </div>
        <div class="col-lg-2">
            <div class="form-group ">
                <label>Inclusive</label>
                <input type="text" class="form-control input-sm col-xs-1" id="totalIncD" style="height:22px;font-size: 8px;">
                <hr>
                <label>Excusive</label>
                <input type="text" class="form-control input-sm col-xs-1" id="totalExD" style="height:22px;font-size: 8px;">

            </div>
        </div>
        <button id="finishedDispatching" class="btn-success btn-md pull-right">Finished</button>
    </div>
</div>

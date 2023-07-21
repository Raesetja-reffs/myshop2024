<div class="row">
    <div class="col-md-8 col-sm-12 hidebody">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <button type="button" id="button_row"
                            class="btn btn-success btn-sm ps-3 pe-3 mb-2 mb-md-0">Add</button>
                        <button type="button" id="copythisorder" class="btn btn-primary btn-sm ps-2 pe-2 mb-2 mb-md-0"
                            style="">Copy Order</button>
                        <button type="button" id="excelexportorder"
                            class="btn btn-primary btn-sm ps-2 pe-2 mb-2 mb-md-0" style="">Export To
                            Excel</button>
                        <button type="button" id="pdfexportorder" class="btn btn-primary btn-sm ps-2 pe-2 mb-2 mb-md-0"
                            style="">Export To PDF</button>
                        <button type="button" id="edit_row"
                            class="btn btn-success btn-sm ps-3 pe-3 mb-2 mb-md-0">Edit</button>
                        <input type="checkbox" id="checkboxDescription" class="form-check-input mt-2 mb-2 mb-md-0"
                            style="display:none;">
                        <input type="checkbox" id="checkboxCode" class="form-check-input mt-2 mb-2 mb-md-0"
                            style="display:none;">
                        <input type="text" id="customeronhold"
                            class="form-control float-end mb-2 mb-md-0 mt-0 mt-md-2" style="color:red;font-weight:900;"
                            readonly>
                    </div>
                    <div class="col-md-4">
                        <!-- Search input aligned to the right -->
                        <input type="text" class="form-control mb-2" id="customerpricelist"
                            style="font-weight: 900;">
                        <button class="btn btn-danger btn-sm ps-1 pe-1" id="deleteAllLines">Delete All
                            Lines</button>
                        @if ($userActions != 0 || true)
                            <button type="button" id="button_user_actions" class="btn btn-info btn-sm ps-1 pe-1">User
                                Actions</button>
                        @endif
                    </div>
                </div>

                <div class="row mb-3 mt-6">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-condensed table-hover">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800">
                                    <th>Actions</th>
                                    <th class="<?php echo env('PRODUCT_CODE_LENGTH'); ?>">Code</th>
                                    <th>Description</th>
                                    <th>Bulk</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Disc% L.Tot</th>
                                    <th>UOM</th>
                                    <th>In Stk<i style="color:red;float:right">W Stk</i></th>
                                    <th>C Stk</th>
                                    <th>Addt.Cst</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mb-3 mt-6">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 id="numberOfLines" style="margin-bottom: 0px !important;" class="hidebody">
                                    0 Line Item(s)</h6>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="messagebox">Message</label>
                                <input type="text" name="message" id="messagebox" class="form-control"
                                    value="">
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="orederNumber">Order Number</label><br>
                                <input type="text" name="orederNumber" class="form-control" id="orederNumber"
                                    maxlength="25" style="font-weight: 900;color: black;" autocomplete="new-password"
                                    value="" readonly>
                                <div class="form-group mt-2">
                                    <span id="characters"></span>/25
                                    <button id="advancedorderNumber" class="btn btn-info btn-sm ps-1 pe-1">Advanced
                                        Order No</button>
                                </div>
                                <input type="hidden" name="hiddenDeliveryAddressId" id="hiddenDeliveryAddressId">
                                <input type="hidden" name="address1hidden" id="address1hidden">
                                <input type="hidden" name="address2hidden" id="address2hidden">
                                <input type="hidden" name="address3hidden" id="address3hidden">
                                <input type="hidden" name="address4hidden" id="address4hidden">
                                <input type="hidden" name="address5hidden" id="address5hidden">
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="orederNumber">
                                    Delivery Address
                                </label>
                                <div style="display: none;">
                                    <button class="btn btn-warning btn-sm ps-1 pe-1" id="changeDeliveryAddress"
                                        type="button">Change</button>
                                    <button class="btn btn-warning btn-sm ps-1 pe-1" id="makeNewDelivAddress"
                                        type="button">New</button>
                                </div>
                                <i class="fa fa-plus-square" aria-hidden="true" id="addANewDelvAddressOnModal"></i>
                                <textarea id="customerSelectedDelDate" class="form-control" style="" readonly></textarea>
                                <i style="" id="tempDelivAddressClosethis">Press <a href="javascript:void(0);"
                                        id="tempDelivAddress">here</a> to create a temp delivery address </i>
                                <button class="btn btn-warning btn-sm ps-1 pe-1"
                                    id="changeDeliveryAddressOnNotInvoiced">Change Delivery Address</button>
                            </div>
                            <div class="col-md-12 mb-2">
                                <button class="btn btn-success btn-sm ps-1 pe-1" id="addTheSalesMan"
                                    type="button">Salesman</button>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="align-items-center d-flex">
                                    <label class="form-check-label" for="authoriseblockedorder">On Hold:&nbsp;</label>
                                    <input type="checkbox" class="custom-checkbox-sm" id="authoriseblockedorder">
                                    <input type="hidden" id="marginandpriceauthbycustomer">
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <button type="button" id="finishOrder"
                                    class="btn btn-primary btn-sm hidebody">Finish</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                &nbsp;
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="notification">Special Notification</label>
                                <select id="notification" class="form-control form-select">
                                    <option value="2">Normal</option>
                                    <option value="1">Low</option>
                                    <option value="3">High</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-2">
                                <h5 id="availableOnTheFly"> </h5>
                                <input type="hidden" id="instockGlobal">
                            </div>
                            <div class="col-md-12 mb-2">
                                <label>Line Extra Info</label>
                                <div class="row text-red">
                                    <div class="col-md-4">
                                        <label>L.Margin</label>
                                        <input id="linemargins" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label>L.Total (Exc)</label>
                                        <input id="linetotalex" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label>L.Total (Inc)</label>
                                        <input id="linetotalInc" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label>Totals</label><br>
                                <label>Add.Cst:</label>
                                <input id="totaddidtionalcst" class="form-control">
                            </div>
                            <div class="col-md-12 mb-2">
                                <label>Totals</label>
                                <div class="row text-red">
                                    <div class="col-md-6">
                                        <label>Exc</label>
                                        <input id="totalEx" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Inc</label>
                                        <input id="totalInc" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label>Order Disc Totals</label>
                                <div class="row text-red">
                                    <div class="col-md-12">
                                        <label>Tot(Inc)</label>
                                        <input id="totalInOrder" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label>Total Margin %</label>
                                <input type="text" id="totalmargin" class="form-control" readonly>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label>Discount %</label>
                                <input type="text" id="dicPercHeader" class="form-control"
                                    onkeypress="return isFloatNumber(this,event)" readonly>
                            </div>
                            @if ($printinvoices != '0')
                                <div class="col-md-12 mb-2">
                                    <button id="invoiceNow" name="invoiceNow"
                                        class="btn btn-danger btn-sm">Print</button>
                                </div>
                            @endif
                            <div class="col-md-12 mb-2">
                                <button id="reprintInvoice" name="reprintInvoice"
                                    class="btn btn-success btn-sm">Re-Print</button>
                            </div>
                            <div class="col-md-12 mb-2">
                                <p id="creditLimitWarningMessage"
                                    style="color:red;font-family: monospace;    font-size: 12px;">
                                </p>
                                <input type="hidden" name="creditLimitApproved" id="creditLimitApproved"
                                    value="">
                                <input type="hidden" name="creditLimitStutusMesg" id="creditLimitStutusMesg"
                                    value="">
                                <input type="text" name="boozeLisence" id="boozeLisence" class="form-control"
                                    value="" readonly>
                                <input type="hidden" name="boozeChecked" id="boozeChecked" value="">
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="align-items-center d-flex">
                                    <input type="checkbox" class="custom-checkbox-sm" name="awaitingStock"
                                        id="awaitingStock" value="">&nbsp;
                                    <label class="form-check-label" for="awaitingStock">Awaiting Stock</label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="align-items-center d-flex">
                                    <input type="checkbox" class="custom-checkbox-sm" name="treatAsQuote"
                                        id="treatAsQuote">&nbsp;
                                    <label class="form-check-label" for="treatAsQuote">Treat As Quotation</label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Contact Details:</label>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <div class="form-group row">
                                            <label for="contactCellOnDispatch" class="col-sm-3 form-label">Contact
                                                Cell</label>
                                            <div class="col-sm-9">
                                                <input id="contactCellOnDispatch" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="form-group row">
                                            <label for="contactPersonOnDispatch"
                                                class="col-sm-3 form-label">Buyer</label>
                                            <div class="col-sm-9">
                                                <input id="contactPersonOnDispatch" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="form-group row">
                                            <label for="telOnDispatch" class="col-sm-3 form-label">Buyer
                                                Tel/Cell</label>
                                            <div class="col-sm-9">
                                                <input id="telOnDispatch" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-success btn-sm" id="updatecontactsontheorder">Update
                                            Contacts</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <h5 id="nbNotes" style="color:red;"></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <button type="button" id="printPDFPickIndOrder" class="btn btn-warning btn-sm mb-2 mb-md-0"
                            style="display:none">Print Picking Slip</button>
                        <button type="button" id="abilityToEmailOrder"
                            class="btn btn-warning btn-sm mb-2 mb-md-0" style="">Email Order</button>
                        <button type="button" id="copyThisOrder" class="btn btn-warning btn-sm mb-2 mb-md-0"
                            style="display:none">Copy Order</button>
                        <button type="button" id="printDocument" class="btn btn-primary btn-sm mb-2 mb-md-0"
                            style="display:none;">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dims.sales-order.partials.order-details-right-side')
</div>

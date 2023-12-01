<div class="row mb-3">
    <div class="col-md-8 col-sm-12 hidebody">
        <div class="card h-500px">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-5 pe-0">
                        <button type="button" id="button_row"
                            class="btn btn-success btn-sm ps-3 pe-3 mb-2 mb-md-0">Add</button>
                        <button type="button" id="copythisorder" class="btn btn-primary btn-sm ps-2 pe-2 mb-2 mb-md-0"
                            style="">Copy Order</button>
                        <button type="button" id="excelexportorder"
                            class="btn btn-primary btn-sm ps-2 pe-2 mb-2 mb-md-0" style="">Export To
                            Excel</button>
                        <button type="button" id="pdfexportorder" class="btn btn-primary btn-sm ps-2 pe-2 mb-2 mb-md-0"
                            style="">Export To PDF</button>
                    </div>
                    <div class="col-md-2 pe-0">
                        <input type="text" id="customeronhold" class="form-control float-end mb-2 mb-md-0"
                            style="color:red;font-weight:900;" readonly>
                    </div>
                    <div class="col-md-2 pe-0">
                        <!-- Search input aligned to the right -->
                        <input type="text" class="form-control mb-2" id="customerpricelist"
                            style="font-weight: 900;">
                    </div>
                    <div class="col-md-3 pe-0">
                        <button class="btn btn-danger btn-sm ps-2 pe-2" id="deleteAllLines">Delete All
                            Lines</button>
                        @if ($userActions != 0)
                            <button type="button" id="button_user_actions" class="btn btn-info btn-sm ps-2 pe-2">User
                                Actions</button>
                        @endif
                    </div>
                </div>

                <div class="row mb-3 mt-3">
                    <div class="table-responsive scroll h-375px">
                        <table id="table" class="table table-bordered table-condensed table-hover">
                            <thead>
                                <tr>
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
                    <div class="row mb-2">
                        <div class="col-md-6 mt-2">
                            <div class="row text-danger">
                                <div class="col-md-4">
                                    <label>L.Margin</label>
                                    <input id="linemargins" class="form-control text-danger">
                                </div>
                                <div class="col-md-4">
                                    <label>L.Total (Exc)</label>
                                    <input id="linetotalex" class="form-control text-danger">
                                </div>
                                <div class="col-md-4">
                                    <label>L.Total (Inc)</label>
                                    <input id="linetotalInc" class="form-control text-danger">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4">
                                    <h6 id="numberOfLines" style="margin-bottom: 0px !important;"
                                        class="hidebody mt-md-8">
                                        0 Line Item(s)
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dims.sales-order.partials.order-details-right-side')
</div>
<div class="row">
    <div class="col-md-12 hidebody">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="contactCellOnDispatch">Contact
                                Cell</label>
                            <input id="contactCellOnDispatch" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="contactPersonOnDispatch">Buyer</label>
                            <input id="contactPersonOnDispatch" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="telOnDispatch">Buyer Tel/Cell</label>
                            <div class="">
                                <input id="telOnDispatch" class="form-control">
                            </div>
                        </div>
                        <button class="btn btn-success btn-sm mt-2" id="updatecontactsontheorder">Update
                            Contacts</button>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <div class="align-items-center d-flex">
                                <input type="checkbox" class="custom-checkbox-sm" id="authoriseblockedorder">
                                <input type="hidden" id="marginandpriceauthbycustomer">&nbsp;
                                <label class="form-check-label" for="authoriseblockedorder">On Hold</label>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="align-items-center d-flex">
                                <input type="checkbox" class="custom-checkbox-sm" name="awaitingStock"
                                    id="awaitingStock" value="">&nbsp;
                                <label class="form-check-label" for="awaitingStock">Awaiting Stock</label>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="align-items-center d-flex">
                                <input type="checkbox" class="custom-checkbox-sm" name="treatAsQuote"
                                    id="treatAsQuote">&nbsp;
                                <label class="form-check-label" for="treatAsQuote">Treat As Quotation</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notification">Special Notification</label>
                            <select id="notification" class="form-control form-select">
                                <option value="2">Normal</option>
                                <option value="1">Low</option>
                                <option value="3">High</option>
                            </select>
                            <h5 id="availableOnTheFly"> </h5>
                            <input type="hidden" id="instockGlobal">
                        </div>
                        <div class="form-group mb-2">
                            <button class="btn btn-success btn-sm ps-1 pe-1" id="addTheSalesMan"
                                type="button">Salesman</button>
                        </div>
                        <div class="form-group mb-2">
                            <p id="creditLimitWarningMessage" class="mb-0"
                                style="color:red;font-family: monospace;    font-size: 12px;">
                            </p>
                        </div>
                        <div class="form-group mb-2">
                            <label for="contactPersonOnDispatch">Liquor No</label>
                            <input type="hidden" name="creditLimitApproved" id="creditLimitApproved"
                                value="">
                            <input type="hidden" name="creditLimitStutusMesg" id="creditLimitStutusMesg"
                                value="">
                            <input type="text" name="boozeLisence" id="boozeLisence" class="form-control"
                                value="" readonly>
                            <input type="hidden" name="boozeChecked" id="boozeChecked" value="">
                        </div>
                        <div class="form-group mb-2">
                            <h5 id="nbNotes" style="color:red;"></h5>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="messagebox">Message</label>
                            <input type="text" name="message" id="messagebox" class="form-control"
                                value="">
                        </div>
                        <div class="form-group">
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
                        <div class="form-group">
                            <label for="orederNumber">
                                Delivery Address
                            </label>
                            <div style="display: none;">
                                <button class="btn btn-warning btn-sm ps-1 pe-1" id="changeDeliveryAddress"
                                    type="button">Change</button>
                                <button class="btn btn-warning btn-sm ps-1 pe-1" id="makeNewDelivAddress"
                                    type="button">New</button>
                            </div>
                            <i class="fa fa-plus-square cursor-pointer" aria-hidden="true"
                                id="addANewDelvAddressOnModal"></i>
                            <textarea id="customerSelectedDelDate" class="form-control" rows="4" style="" readonly></textarea>
                            <i style="" id="tempDelivAddressClosethis">Press <a href="javascript:void(0);"
                                    id="tempDelivAddress">here</a> to create a temp delivery address </i>
                            <button class="btn btn-warning btn-sm ps-1 pe-1 mt-1"
                                id="changeDeliveryAddressOnNotInvoiced">Change Delivery Address</button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="table-responsive">
                            <table id="table-summary" class="table table-bordered table-condensed table-hover">
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-end">
                                            Discount %
                                        </td>
                                        <td class="text-end">
                                            <input type="text" id="dicPercHeader" class="form-control"
                                                onkeypress="return isFloatNumber(this,event)" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end">
                                            Add.Cst:
                                        </td>
                                        <td class="text-end">
                                            <input id="totaddidtionalcst" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end">
                                            Total GP %
                                        </td>
                                        <td class="text-end">
                                            <input type="text" id="totalmargin" class="form-control" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end">
                                            Total Disc
                                        </td>
                                        <td class="text-end">
                                            <input id="totalInOrder" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end">
                                            Total Exc
                                        </td>
                                        <td class="text-end">
                                            <input id="totalEx" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">
                                            Grand Total
                                        </td>
                                        <td class="text-gray-900 fs-3 fw-bolder text-end">
                                            <input id="totalInOrder" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row fixed-parent hidebody">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                {{-- <button type="button" id="printPDFPickIndOrder" class="btn btn-warning btn-sm ms-2"
                        style="display:none">Print Picking Slip</button> --}}
                <button type="button" id="abilityToEmailOrder" class="btn btn-warning btn-sm ms-2"
                    style="">Email Order</button>
                {{-- <button type="button" id="copyThisOrder" class="btn btn-warning btn-sm ms-2"
                        style="display:none">Copy Order</button> --}}
                {{-- <button type="button" id="printDocument" class="btn btn-primary btn-sm ms-2"
                        style="display:none;">Print</button> --}}
                @if ($printinvoices != '0')
                    <button id="invoiceNow" name="invoiceNow" class="btn btn-danger btn-sm ms-2">Print</button>
                @endif
                <button id="reprintInvoice" name="reprintInvoice"
                    class="btn btn-success btn-sm ms-2">Re-Print</button>
            </div>
            <div class="col-md-6">
                <button type="button" id="finishOrder" class="btn btn-primary btn-sm hidebody ms-2">Finish</button>
            </div>
        </div>
    </div>
</div>

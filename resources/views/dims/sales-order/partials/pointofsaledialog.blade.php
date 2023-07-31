<div id="pointOfSaleDialog" title="Point Of Sale">
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <th>Tender Type</th>
                            <th>Amount</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cash</td>
                                <td>
                                    <input type="text" id="posPayMentTypeCash" value="0"
                                        onkeypress="return isFloatNumber(this,event)" class="onPosAmount form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Account</td>
                                <td>
                                    <input type="text" id="posPayMentTypeAccount" value="0"
                                        onkeypress="return isFloatNumber(this,event)" class="onPosAmount form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Credit Card</td>
                                <td>
                                    <input type="text" id="posPayMentTypeCreditCard" value="0"
                                        onkeypress="return isFloatNumber(this,event)" class="onPosAmount form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Cheque</td>
                                <td>
                                    <input type="text" id="posPayMentTypeCheque" value="0"
                                        onkeypress="return isFloatNumber(this,event)" class="onPosAmount form-control">
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="col-md-6" style="background: #ede5e5;">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Order Number</td>
                                <td>
                                    <input type="text" id="posOrdernumber" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr style=" font-weight: 900;color:purple">
                                <td>Invoice Total</td>
                                <td>
                                    <input type="text" id="posInvTotal" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr style=" font-weight: 900;color:blue">
                                <td>Total Tendered</td>
                                <td>
                                    <input type="text" id="posTotalTendered" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr style=" font-weight: 900;color:saddlebrown">
                                <td>Cash Tendered</td>
                                <td>
                                    <input type="text" id="posCashTendered" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr style=" font-weight: 900;color:darkgreen">
                                <td>Change</td>
                                <td>
                                    <input type="text" id="posChange" class="form-control" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-danger btn-sm">Cancel</button>
                    <button class="btn btn-success btn-sm" id="confirmOnPosDialog">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

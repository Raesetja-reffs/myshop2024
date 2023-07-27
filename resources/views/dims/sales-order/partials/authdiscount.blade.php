<div id="authDiscount" title="Authorise Discount">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h6>To change the Discount % you need to put in the new discount % and authorise</h6>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="newDiscountPercentage">Discount %</label>
                    <input class="form-control" id="newDiscountPercentage" onkeypress="return isFloatNumber(this,event)">
                </div>
                <form>
                    <div class="col-md-12 mb-3">
                        <label for="userAuthDisc">Name</label>
                        <input class="form-control auto-complete-off" name="userAuthDisc" id="userAuthDisc" autocomplete="off">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="userAuthPassWordDisc">Password</label>
                        <input type="password" name="userAuthPassWordDisc" class="form-control auto-complete-off"
                            id="userAuthPassWordDisc" readonly
                            onfocus="$(this).removeAttr('readonly');"
                            autocomplete="off"
                        >
                    </div>
                    <div class="col-md-12">
                        <button type="button" id="doAuthDiscounts" class="btn btn-success btn-sm">Authorise</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

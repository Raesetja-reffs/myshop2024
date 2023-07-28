<div id="prohibitedProductAuth" title="Please Authorise">
    <div class="card">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <h5>This is a Prohibited Product</h5>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="userAuthProhibited">Name</label>
                        <input class="form-control auto-complete-off" name="userAuthProhibited" id="userAuthProhibited" autocomplete="off">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="userAuthPassWordProhibited">PassWord</label>
                        <input type="password" name="userAuthPassWordProhibited" class="form-control auto-complete-off"
                            id="userAuthPassWordProhibited" readonly
                            onfocus="$(this).removeAttr('readonly');"
                            autocomplete="off"
                        >
                    </div>
                    <div class="col-md-12">
                        <button type="button" id="doAuthProhibited" class="btn btn-success btn-sm">
                            Authorise
                        </button>
                        <button type="button" id="doCancelAuthProhibited" class="btn btn-warning btn-sm">
                            No Thanks, Redo the Line
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

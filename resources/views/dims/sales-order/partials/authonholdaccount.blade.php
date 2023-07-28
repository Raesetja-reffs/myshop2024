<div title="ACCOUNT ON HOLD" id="authonholdaccount">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h2>PLEASE AUTHORIZE</h2>
                </div>
                <form>
                    <div class="col-md-12 mb-3">
                        <label for="onholdaccountmanagername">Name</label><br>
                        <input class="form-control" id="onholdaccountmanagername" name="onholdaccountmanagername"
                            autocomplete="off" value="-">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="onholdaccountmanagerpassword">PassWord</label>
                        <input type="password" name="onholdaccountmanagerpassword" class="form-control"
                            id="onholdaccountmanagerpassword" autocomplete="off" value="-">
                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="button" id="doAuthZeroonholdaccount"
                            class="btn btn-success btn-sm">Authorise</button>
                    </div>
                    <div class="col-md-12">
                        <p class="text-danger">NB :THIS ORDER WILL NOT GO FOR PICKING UNTIL AUTHORISATION.</p>
                        <button type="button" id="treattheauthaccountasquotation" class="btn btn-danger btn-sm" style="display:none;">
                            Notify Managers And Continue
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="MarginProblems" title="Please Authorise">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5>The Order/Product is below the minimum margin, Please Authorise and Report to your manager </h5>
                </div>
                <form>
                    <div class="col-md-12 mb-3">
                        <input id="margin_auth" type="hidden" value="0">
                        <label for="userAuthProhibitedCred">Name</label>
                        <input class="form-control auto-complete-off" id="userAuthProhibitedCred_marg" name="userAuthProhibitedCred" autocomplete="off">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="userAuthPassWordCredit">PassWord</label>
                        <input type="password" name="userAuthPassWordCredit" class="form-control auto-complete-off" id="userAuthPassWordCredit_marg" autocomplete="off">
                    </div>
                    <div class="col-md-12">
                        <button type="button" id="doAuthCredits" class="btn btn-success btn-sm pull-right">Authorise</button>
                        <button type="button" id="doCancelAuthCredits" class="btn btn-danger btn-sm pull-right">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

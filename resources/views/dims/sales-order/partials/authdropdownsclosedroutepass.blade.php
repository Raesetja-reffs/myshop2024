<div id="authDropDownsClosedRoutePass" title="Please Authorise" style="background:rgba(0,0,255,0.31)">
    <div class="card">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <h4 style="color:red">The Route You Are Trying to Place this Order Is Currently Closed Please Authorise First.</h4>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="userAuthClosedRoute">Name</label>
                        <input class="form-control auto-complete-off" name="userAuthClosedRoute" id="userAuthClosedRoute">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="userAuthClosedRoutePass">PassWord</label>
                        <input type="password" name="userAuthClosedRoutePass"
                            class="form-control auto-complete-off" id="userAuthClosedRoutePass"
                            onfocus="$(this).removeAttr('readonly');"
                        >
                    </div>
                    <div class="col-md-12">
                        <button type="button" id="doAuthDropDownClosedRoutePass" class="btn btn-success btn-sm">
                            Authorise
                        </button>
                        <button type="button" id="doCancelAuthDropDownClosedRoutePass" class="btn btn-warning btn-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

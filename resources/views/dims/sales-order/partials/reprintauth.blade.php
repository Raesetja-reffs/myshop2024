<div id="reprintAuth" title="Please Authorise before using this action" style="background:rgba(0,0,255,0.31)">
    <div class="card">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="userAuthNameReprint">Name</label>
                        <input class="form-control auto-complete-off" name="userAuthNameReprint" id="userAuthNameReprint">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="userAuthPassWordReprint">PassWord</label>
                        <input type="password" name="userAuthPassWordReprint" class="form-control auto-complete-off"
                            id="userAuthPassWordReprint"
                            readonly
                            onfocus="$(this).removeAttr('readonly');"
                        >
                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="button" id="doAuthReprint" class="btn btn-success btn-sm">Authorise</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

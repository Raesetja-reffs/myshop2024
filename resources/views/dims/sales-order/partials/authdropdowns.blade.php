<div id="authDropDowns" title="Please Authorise before using this action" style="background:rgba(0,0,255,0.31)">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h4 style="color:red">BY CLICKING CANCEL THIS WILL GO BACK TO THE ORIGINAL DATA LOADED WITH THIS ORDER</h4>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="control-label" for="userAuthNameDropDown">Name</label>
                    <input class="form-control auto-complete-off" name="userAuthNameDropDown" id="userAuthNameDropDown">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="userAuthPassWordDropDown">PassWord</label>
                    <input type="password" name="userAuthPassWordDropDown" class="form-control auto-complete-off"
                        id="userAuthPassWordDropDown"
                        readonly
                        onfocus="$(this).removeAttr('readonly');"
                    >
                </div>
                <div class="col-md-12 mb-3">
                    <button type="button" id="doAuthDropDown" class="btn btn-success btn-sm">Authorise</button>
                    <button type="button" id="doCancelAuthDropDown" class="btn btn-warning btn-sm">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

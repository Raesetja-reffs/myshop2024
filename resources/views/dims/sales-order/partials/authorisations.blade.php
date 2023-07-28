<div id="authorisations" title="Please Authorise" style="background: #d03939;">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div id="appendErrormsg">
                    </div>
                </div>
                <form>
                    <div class="col-md-12 mb-3">
                        <label for="userAuthName">Name</label>
                        <input class="form-control auto-complete-off" name="userAuthName" id="userAuthName">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="userAuthPassWord">PassWord</label>
                        <input type="password" name="userAuthPassWord" class="form-control auto-complete-off"
                            id="userAuthPassWord"
                            readonly
                            onfocus="$(this).removeAttr('readonly');"
                        >
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="userNewVariable" >New Val</label>
                        <input type="text" name="userNewVariable" class="form-control" id="userNewVariable" value="0" readonly>
                    </div>
                </form>
                <div class="col-md-12">
                    <button type="button" id="doAuth" class="btn btn-success btn-sm">
                        Authorise
                    </button>
                    <button type="button" id="noThanksRedo" class="btn btn-warning btn-sm">
                        No Thanks, Redo the Line
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

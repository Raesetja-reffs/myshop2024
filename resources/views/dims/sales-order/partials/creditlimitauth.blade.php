<div id="creditLimitAuth" title="Credit Limit Authorisation" style="background:rgba(0,0,255,0.31)">
    <div class="card mb-3">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div id="appendErrormsgCreditLimit" style="background: white;font-size:10px">
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="userAuthNamecrLimit">Name</label>
                        <input class="form-control auto-complete-off" name="userAuthNamecrLimit" id="userAuthNamecrLimit">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="userAuthPassWordcrLimit">PassWord</label>
                        <input type="password" name="userAuthPassWordcrLimit"
                            class="form-control auto-complete-off" id="userAuthPassWordcrLimit"
                            readonly onfocus="$(this).removeAttr('readonly');"
                        >
                    </div>
                    <div class="col-md-12 mb-3" style="display:none;">
                        <label for="userNewVariable">Value</label>
                        <input type="text" name="userNewVariablecrLimit" class="form-control" id="userNewVariablecrLimit"
                            style="display:none;" value="0" readonly
                        >
                    </div>
                    <div class="col-md-12">
                        <button type="button" id="doAuthcrLimit" class="btn btn-success btn-sm">
                            Authorise
                        </button>
                        <button type="button" id="cancelWithoutSaving" class="btn btn-warning btn-sm">
                            Cancel Without Saving
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#creditLimitAuth').hide();
    function creditLimitAuth(mess) {
        $('#appendErrormsgCreditLimit').empty();
        $('#appendErrormsgCreditLimit').append(mess);

        $('#creditLimitAuth').show();
        $("#creditLimitAuth").dialog({
            height: 300,
            modal: true,
            width: 500,
            containment: false
        }).dialogExtend({
            "closable": true, // enable/disable close button
            "maximizable": false, // enable/disable maximize button
            "minimizable": true, // enable/disable minimize button
            "collapsable": true, // enable/disable collapse button
            "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar": false, // false, 'none', 'transparent'
            "minimizeLocation": "right", // sets alignment of minimized dialogues
            "icons": { // jQuery UI icon class
                "close": "ui-icon-circle-close",
                "maximize": "ui-icon-circle-plus",
                "minimize": "ui-icon-circle-minus",
                "collapse": "ui-icon-triangle-1-s",
                "restore": "ui-icon-bullet"
            },
            "load": function(evt, dlg) {}, // event
            "beforeCollapse": function(evt, dlg) {}, // event
            "beforeMaximize": function(evt, dlg) {}, // event
            "beforeMinimize": function(evt, dlg) {}, // event
            "beforeRestore": function(evt, dlg) {}, // event
            "collapse": function(evt, dlg) {}, // event
            "maximize": function(evt, dlg) {}, // event
            "minimize": function(evt, dlg) {}, // event
            "restore": function(evt, dlg) {} // event
        });
        $('#doAuthcrLimit').off().click(function() {

        });
        $('#cancelWithoutSaving').off().click(function() {
            location.reload(true);
        });

    }
</script>

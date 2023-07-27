<div id="salesmandialog" title="Choose the Salesman" style="background: ghostwhite;">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-6">
                    <label for="salesmanselectstatement">Salesman</label>
                    <select id="salesmanselectstatement" class="form-control form-select">
                        @foreach ($salesmen as $value)
                            <option value="{{ $value->strSalesmanCode }}">{{ $value->UserName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 mb-1">
                    <label>This require authorization.</label>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="authsalesmanusername">UserName</label>
                    <input id="authsalesmanusername" class="form-control auto-complete-off">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="Password">Password</label>
                    <input type="password" id="authsalesmanpassword" class="form-control auto-complete-off">
                </div>
                <div class="col-md-12">
                    <button id="submitsalesman" class="btn btn-success btn-sm">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#salesmandialog').hide();
        $('#addTheSalesMan').click(function() {
            $('#salesmandialog').show();
            showDialog('#salesmandialog', '35%', 350);
            $('#authsalesmanusername').val(" ");
            $('#authsalesmanpassword').val(" ");
            $('#submitsalesman').click(function() {
                $.ajax({
                    url: '{!! url('/changesalesman') !!}',
                    type: "POST",
                    data: {
                        userID: $('#salesmanselectstatement').val(),
                        OrderId: $('#orderId').val(),
                        DriverDeliveryDate: $('#inputDeliveryDate').val(),
                        authUserName: $('#authsalesmanusername').val(),
                        authUserPassword: $('#authsalesmanpassword').val()
                    },
                    success: function(data) {
                        if (data == "DONE") {
                            $('#salesmandialog').dialog('close');
                        } else {
                            alert("Sorry ,you don't have access to authorize rep codes");
                        }
                    }
                });
            });
        });
    });
</script>

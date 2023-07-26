<div id="addNewAddress" title="Add new address">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12" style="height: 450px !important;overflow-y: scroll;">
                    <table class="table table-bordered table-hover" id="addNewAddressModal">
                        <thead>
                            <tr>
                                <th>Address1</th>
                                <th>Address2</th>
                                <th>Address3</th>
                                <th>Address4</th>
                                <th>Address5</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-md-12 mt-8">
                    <button id="addTableAddressToDB" class="btn btn-success btn-sm float-end">Done</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#addNewAddress').hide();
        $('#addANewDelvAddressOnModal').click(function() {
            $('#addNewAddress').show();
            $("#addNewAddress").dialog({
                height: 600,
                width: 900,
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

            for (var i = 0; i < 20; i++) {
                addAddressLineOnSingleCustAddress('#addNewAddressModal');
            }
        });
        $('#addTableAddressToDB').click(function() {
            createAddressArray('{!! url('/insertNewAddress') !!}', $('#inputCustAcc').val());
        });
        function createAddressArray(url, CustomerCode) {
            var address1 = [];
            var address2 = [];
            var address3 = [];
            var address4 = [];
            var address5 = [];
            var objectTable = [];
            var i = 0;
            $('#addNewAddressModal tr').each(function() {

                var address1v = [];
                var address2v = [];
                var address3v = [];
                var address4v = [];
                var address5v = [];
                var valueobjectTable = [];

                $(this).find(".AddressLine1").each(function() {
                    address1v.push($(this).val());
                    valueobjectTable["AddressLine1"] = $(this).val();
                });
                $(this).find(".AddressLine2").each(function() {
                    address2v.push($(this).val());
                    valueobjectTable["AddressLine2"] = $(this).val();
                });
                $(this).find(".AddressLine3").each(function() {
                    address3v.push($(this).val());
                    valueobjectTable["AddressLine3"] = $(this).val();
                });
                $(this).find(".AddressLine4").each(function() {
                    address4v.push($(this).val());
                    valueobjectTable["AddressLine4"] = $(this).val();
                });
                $(this).find(".AddressLine5").each(function() {
                    address5v.push($(this).val());
                    valueobjectTable["AddressLine5"] = $(this).val();
                });

                address1.push(address1v);
                address2.push(address2v);
                address3.push(address3v);
                address4.push(address4v);
                address5.push(address5v);

                if ((address1v[0]) != 0 || (address2v[0]) != 0 || (address3v[0]) != 0 || (address4v[0]) != 0 || (
                        address5v[0]) != 0) {
                    objectTable[i] = valueobjectTable;
                    i = i + 1;
                } else {

                }

            });
            for (var i = 0; i < objectTable.length; i++) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        AddressLine1: objectTable[i]['AddressLine1'],
                        AddressLine2: objectTable[i]['AddressLine2'],
                        AddressLine3: objectTable[i]['AddressLine3'],
                        AddressLine4: objectTable[i]['AddressLine4'],
                        AddressLine5: objectTable[i]['AddressLine5'],
                        CustomerCode: CustomerCode
                    },
                    success: function(data) {
                        $('#addNewAddress').dialog('close');
                    }
                });

            }
        }
    });
</script>

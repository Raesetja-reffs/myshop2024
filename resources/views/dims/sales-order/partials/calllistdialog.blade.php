<div id="callListDialog" title="Call List" style="background: #f3b9c3">
    <div class="card mb-3">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-2 mb-2">
                        <label for="callListOrderDate">Order Date</label>
                        <input type="text" class="form-control" id="callListOrderDate" scustomeronholdtyle="font-size: 10px;">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="callListDeliveryDate">Delivery Date</label>
                        @if (count($callistDelvDate) > 0)
                            <input type="text" class="form-control" id="callListDeliveryDate"
                                value="{{ $callistDelvDate[0]->dteSessionDate }}">
                        @else
                            <input type="text" class="form-control" id="callListDeliveryDate">
                        @endif
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="callListUser">User</label>
                        <select class="form-control form-select" name="callListUser" id="callListUser">
                            @if (Auth::user())
                                <option value="{{ Auth::user()->UserID }}">{{ Auth::user()->UserName }}</option>
                            @endif
                            @if (Auth::guard('central_api_user')->user())
                                <option value="{{ Auth::guard('central_api_user')->user()->id }}">{{ Auth::guard('central_api_user')->user()->username }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="routeToFilterWith">Route</label>
                        <select class="form-control" name="routeToFilterWith" id="routeToFilterWith">
                            @foreach ($callistCurrentRoute as $value)
                                <option value="{{ $value->Routeid }}">{{ $value->Route }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="button" id="passCallistFilter" class="btn btn-success btn-sm mt-md-6">Press Go!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12" style="height:430px; overflow-y:scroll;">
                    <table class="table2 table table-bordered table-hover fs-8" id="callListTable" style="overflow-y: auto;width:100%" tabindex=0>
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Call</th>
                                <th>Account Contact</th>
                                <th>Buyer Tel</th>
                                <th>Buyer Cell</th>
                                <th>Route</th>
                                <th>Buyer </th>
                                <th>Address</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href='{!! url('/getphonebook') !!}' class="btn btn-primary btn-sm"
                        onclick="window.open(this.href, 'getphonebook','left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;"
                    >
                        Phone Book
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#callListDialog').hide(); //Dialog
        $('#callList').click(function() {
            getDimsUsers('#callListUser', '{!! url('/getDimsUsers') !!}');
            $('#callListDialog').show();
            $("#callListDialog").dialog({
                height: 660,
                width: '80%',
                containment: false
            }).dialogExtend({
                "closable": true, // enable/disable close button
                "maximizable": false, // enable/disable maximize button
                "minimizable": true, // enable/disable minimize button
                "collapsable": true, // enable/disable collapse button
                "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                "titlebar": "transparent", // false, 'none', 'transparent'
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
        });

        $('#passCallistFilter').click(function() {
            callList();
        });
    });
    function callList() {
        $.ajax({
            url: '{!! url('/getCallList') !!}',
            type: "POST",
            data: {
                userId: $('#callListUser').val(),
                routeId: $('#routeToFilterWith').val(),
                OrderDate: $('#callListOrderDate').val(),
                deliveryDate: $('#callListDeliveryDate').val(),
                UserName: $('#callListUser').find("option:selected").text(),
                routeName: $('#routeToFilterWith').find("option:selected").text()

            },
            success: function(data) {
                var trHTML = '';
                $('.fast_removeCallList').empty();
                $.each(data, function(key, value) {
                    var tokenIdn = parseInt(Math.random() * 1000000000, 10);
                    // alert(tokenIdn);
                    trHTML +=`
                        <tr role="row" class="fast_removeCallList">
                            <td>${value.CustomerPastelCode}</td>
                            <td>${$.trim(value.StoreName)}</td>
                            <td>
                                <input type="checkbox" name="called" style="width:18px;height:15px !important"
                                    value="${value.CustomerPastelCode}" onclick="javascript: SelectallColorsForStyle(this, value, ${tokenIdn});">
                            </td>
                            <td>${value.ContactPerson}</td>
                            <td>${value.BuyerTelephone}</td>
                            <td>${value.CellPhone}</td>
                            <td>${value.Routeid}</td>
                            <td>${value.BuyerContact}</td>
                            <td>${value.LocationID}</td>
                            <td>${value.Discount}</td>
                            <td>${value.custRouteId}</td>
                            <td>
                                <input type="text" id="${tokenIdn}" class="notes form-control">
                                <input type="hidden" value="${value.CustomerId}" class="custids">
                            </td>
                        </tr>
                    `;
                });
                $('#callListTable tbody').append(trHTML);
                console.debug("check how many times i get called+++++++++++++++++++++++++++++");

                $('#callListTable tbody').on('click', 'tr', function(e) {
                    $("#callListTable tbody tr").removeClass('row_selectedYellowish');
                    $(this).addClass('row_selectedYellowish');
                });
            }
        });
    }
</script>

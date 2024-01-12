<x-app-layout>

    <x-slot name="header">
        {{ __('Groups') }}
    </x-slot>

    <x-slot name="breadcrum">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <!--end::Item-->

        <!--begin::Item-->
        <li class="breadcrumb-item text-dark">
            Groups </li>
        <!--end::Item-->
    </x-slot>

    <style>
        /* h2{color:red;}
        h3 {color:blue;}
        h4 {color:blue;}
        td{color:orange;} */
        /* tbody{background-color:black;} */
        /* input[type=text], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 2px;
            box-sizing: border-box;
            cursor: text;
        } */
        /* div.scrollable {
            width:100%;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-y: scroll
        } */
    </style>

    <div class="card mt-5">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <form>
                        <h5>Add Screen</h5>
                        <div class="form-group mb-3">
                            <label for="GroupName">Group Name</label>
                            <input type="text" class="form-control" id="GroupName" placeholder="Enter an Group Name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="GroupCode">Group Code</label>
                            <input type="text" class="form-control" id="GroupCode" placeholder="Enter an Group Code">
                        </div>
                        <div class="form-group mb-3">
                            <label for="RebateAcc">Rebate Acc</label>
                            <input type="text" class="form-control" id="RebateAcc" placeholder="Enter an RebateAcc">
                        </div>
                        <div class="form-group mb-3">
                            <label for="RebatePercent">Rebate Percent</label>
                            <input type="text" class="form-control" id="RebatePercent" placeholder="Enter an RebateAcc" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="InvoiceSeperately">InvoiceSeperately</label>
                            <select id="InvoiceSeperately" class="form-control form-select">
                                <option value="0">-- Please Choose NewRec--</option>
                                <option value="1">True</option>
                                <option value="0">False</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="NewRec">New Rec</label>
                            <select id="NewRec" class="form-control form-select">
                                <option value="0">-- Please Choose NewRec--</option>
                                <option value="1">True</option>
                                <option value="0">False</option>
                            </select>
                        </div>
                        <button class="btn btn-success btn-sm w-100" type="submit" id="add">
                            <i class="fas fa-plus-circle fs-4 me-2"></i>ADD
                        </button>
                    </form>
                </div>
                <div class="col-md-8">
                    <div id="Groups" title="Groups List">
                        <form>
                            <div class="table-responsive scrollable overflow-y-auto" style="max-height: 480px;">
                                <table id="tableGroups" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Group ID</th>
                                            <th>Group Name</th>
                                            <th>Group Code</th>
                                            <th>RebateAcc</th>
                                            <th>RebatePercent</th>
                                            <th>InvoiceSeperately</th>
                                            <th>New Rec</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($readGroup as $values)
                                            <tr class="item{{$values->GroupId}}">
                                                <td>{{$values->GroupId}}</td>
                                                <td>{{$values->GroupName}}</td>
                                                <td>{{$values->GroupCode}}</td>
                                                <td>{{$values->RebateAcc}}</td>
                                                <td>{{$values->RebatePercent}}</td>
                                                <td>{{$values->InvoiceSeperately}}</td>
                                                <td>{{$values->NewRec}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editGroup" title="Please Edit Group Information" style="background-color: #F1F1F2;">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>Edit Screen</p>
                    </div>
                    <div class="col-md-12">
                        <h2 id="updatemessage"></h2>
                    </div>
                    <div class="col-md-12 mb-3">
                        <input type="hidden" class="form-control" id="GroupIdEdit" placeholder="Enter a Name You want to add" required>
                        <label for="GroupNameEdit">Group Name</label>
                        <input type="text" class="form-control" id="GroupNameEdit" placeholder="Enter an Group Name" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="GroupCodeEdit">Group Code</label>
                        <input type="text" class="form-control" id="GroupCodeEdit" placeholder="Enter an Group Code" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="RebateAccEdit">Rebate Acc</label>
                        <input type="text" class="form-control" id="RebateAccEdit" placeholder="Enter Rebate Acc" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="RebatePercentEdit">Rebate Percent</label>
                        <input type="text" class="form-control" id="RebatePercentEdit" placeholder="Enter an RebateAcc" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="InvoiceSeperatelyEdit">InvoiceSeperately</label>
                        <select id="InvoiceSeperatelyEdit" class="form-control form-select">
                            <option value="1">True</option>
                            <option value="0">False</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="NewRecEdit">New Rec</label>
                        <select id="NewRecEdit" class="form-control form-select">
                            <option value="1">True</option>
                            <option value="0">False</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-sm" type="submit" id="edit">UPDATE</button>
                        <button class="btn btn-danger btn-sm" type="submit" id="delete">DELETE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('#QuoteDetails').hide();
            $('#extraInfo').hide();
            $('#salesQEmail').hide();
            $('#orderListing').hide();
            $('#pricing').hide();
            $('#callList').hide();
            $('#copyOrdersBtn').hide();
            $('#tabletLoadingApp').hide();
            $('#pricingOnCustomer').hide();
            $('#salesOnOrder').hide();
            $('#posCashUp').hide();
            $('#dropdown').hide();
            $('#salesInvoiced').hide();
            $('#editGroup').hide();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function(xhr) {
                    $(".general-loader").show();
                },
                complete: function(xhr, status) {
                    $(".general-loader").hide();
                },
                error: function(xhr, status, error) {
                    message = error;
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showAlert('danger', message, 10000);
                }
            });

            $("#add").click(function() {
                $(".general-loader").show();
                $.ajax({
                    url: '{!!url("/addGroup")!!}',
                    type: "POST",
                    data: {
                        GroupId: $('#GroupId').val(),
                        GroupName: $('#GroupName').val(),
                        GroupCode: $('#GroupCode').val(),
                        RebateAcc: $('#RebateAcc').val(),
                        RebatePercent: $('#RebatePercent').val(),
                        InvoiceSeperately: $('#InvoiceSeperately').val(),
                        NewRec: $('#NewRec').val(),
                        statement: 'Insert'
                    },
                    success: function (data) {
                        location.reload(true);
                    },
                    error: function(xhr){
                        $(".general-loader").hide();
                    }
                });
            });

            $('#tableGroups tbody').on('dblclick', 'tr', function() {
                // $(this).closest("tr").hide();
                $('#editGroup').show();
                var $this = $(this);
                var row = $this.closest("tr");
                var groupId = row.find('td:eq(0)').text();
                var groupName = row.find('td:eq(1)').text();
                var groupCode = row.find('td:eq(2)').text();
                var rebateAcc = row.find('td:eq(3)').text();
                var rebatePercent = row.find('td:eq(4)').text();
                var invoiceSeperately = row.find('td:eq(5)').text();
                var newRec= row.find('td:eq(6)').text();
                showDialog('#editGroup',600,600);
                $('#updatemessage').empty();
                $('#GroupIdEdit').val(groupId);
                $('#GroupNameEdit').val(groupName);
                $('#GroupCodeEdit').val(groupCode);
                $('#RebateAccEdit').val(rebateAcc);
                $('#RebatePercentEdit').val(rebatePercent);
                $('#InvoiceSeperatelyEdit').val(invoiceSeperately);
                $('#NewRecEdit').val(newRec);
                $('#updatemessage').append("You are now editing the Group of " + groupName+"!");
            });

            $('#tableGroups tbody').on('click', 'button', function (e) {
                $('#deleteGroups').show();
                var $this = $(this);
                var row = $this.closest("button");
                showDialog('#deleteGroups',600,600);
            });

            $("#edit").click(function() {
                $(".general-loader").show();
                $.ajax({
                    url: '{!!url("/editGroup")!!}',
                    type: "POST",
                    data: {
                        GroupId: $('#GroupIdEdit').val(),
                        GroupName: $('#GroupNameEdit').val(),
                        GroupCode: $('#GroupCodeEdit').val(),
                        RebateAcc: $('#RebateAccEdit').val(),
                        RebatePercent: $('#RebatePercentEdit').val(),
                        InvoiceSeperately: $('#InvoiceSeperatelyEdit').val(),
                        NewRec: $('#NewRecEdit').val(),
                        statement: 'Update'
                    },
                    success: function (data) {
                        location.reload(true);
                    },
                    error: function(xhr){
                        $(".general-loader").hide();
                    }
                });
            });

            $("#delete").click(function() {
                $(".general-loader").show();
                $.ajax({
                    url: '{!!url("/deleteGroup")!!}',
                    type: "POST",
                    data: {
                        GroupId: $('#GroupIdEdit').val(),
                        GroupName: $('#GroupNameEdit').val(),
                        GroupCode: $('#GroupCodeEdit').val(),
                        RebateAcc: $('#RebateAccEdit').val(),
                        RebatePercent: $('#RebatePercentEdit').val(),
                        InvoiceSeperately: $('#InvoiceSeperatelyEdit').val(),
                        NewRec: $('#NewRecEdit').val(),
                        statement: 'Delete'
                    },
                    success: function (data) {
                        location.reload(true);
                    },
                    error: function(xhr){
                        $(".general-loader").hide();
                    }
                });
            });
        });
        function showDialog(tag,width,height) {
            $(tag).dialog({height: height, modal: false, width: width,containment: false})
            .dialogExtend({
                "closable" : true, // enable/disable close button
                "maximizable" : false, // enable/disable maximize button
                "minimizable" : true, // enable/disable minimize button
                "collapsable" : true, // enable/disable collapse button
                "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                "titlebar" : false, // false, 'none', 'transparent'
                "minimizeLocation" : "right", // sets alignment of minimized dialogues
                "icons" : { // jQuery UI icon class
                    "maximize" : "ui-icon-circle-plus",
                    "minimize" : "ui-icon-circle-minus",
                    "collapse" : "ui-icon-triangle-1-s",
                    "restore" : "ui-icon-bullet"
                },
                "load" : function(evt, dlg){ }, // event
                "beforeCollapse" : function(evt, dlg){ }, // event
                "beforeMaximize" : function(evt, dlg){ }, // event
                "beforeMinimize" : function(evt, dlg){ }, // event
                "beforeRestore" : function(evt, dlg){ }, // event
                "collapse" : function(evt, dlg){  }, // event
                "maximize" : function(evt, dlg){ }, // event
                "minimize" : function(evt, dlg){  }, // event
                "restore" : function(evt, dlg){  } // event
            });
        }
    </script>

</x-app-layout>

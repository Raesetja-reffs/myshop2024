<x-app-layout>

    <x-slot name="header">
        {{ __('Picking Team') }}
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
            Picking Team </li>
        <!--end::Item-->
    </x-slot>

    <style>
        /* h2{color:red;}
        h3 {color:blue;}
        h4 {color:orange;}
        td{color:orange;}
        tbody{background-color:black;}


        input[type=text], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 2px;
            box-sizing: border-box;
            cursor: text;
        }

        div.scrollable
        {
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
                            <label for="PickingTeam">Picking Team</label>
                            <input type="text" class="form-control" id="PickingTeam" placeholder="Enter a Picking Team" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="Commision">Commision</label>
                            <input type="text" class="form-control" id="Commision" placeholder="Enter a Commission" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="PickingSlipPath">Picking Slip Path</label>
                            <input type="text" class="form-control" id="PickingSlipPath" placeholder="Enter a Picking Team" required>
                        </div>
                        <button class="btn btn-success btn-sm w-100" type="submit" id="add">
                            <i class="fas fa-plus-circle fs-4 me-2"></i>ADD
                        </button>
                    </form>
                </div>
                <div class="col-md-8">
                    <div id="PickingTeam" title="PickingTeam List">
                        <form>
                            <div class="table-responsive scrollable overflow-y-auto" style="max-height: 480px;">
                                <table id="tablePickingTeam" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Picking Team ID</th>
                                            <th>Picking Team</th>
                                            <th>Commision</th>
                                            <th>Picking Slip Path</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($readPickingTeam as $values)
                                            <tr class="item{{$values->PickingTeamId}}">
                                                <td>{{$values->PickingTeamId}}</td>
                                                <td>{{$values->PickingTeam}}</td>
                                                <td>{{$values->Commision}}</td>
                                                <td>{{$values->PickingSlipPath}}</td>
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

    <div id="editPickingTeam" title="Please Edit Picking Team Information" style="background-color: #F1F1F2;">
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
                        <input type="hidden" class="form-control" id="PickingTeamIdEdit" placeholder="Enter a Name You want to add" required>
                        <label for="PickingTeamEdit">Picking Team</label>
                        <input type="text" class="form-control" id="PickingTeamEdit" placeholder="Enter a Picking Team" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="CommisionEdit">Commision</label>
                        <input type="text" class="form-control" id="CommisionEdit" placeholder="Enter a Commision" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="PickingSlipPathEdit">Picking Slip Path</label>
                        <input type="text" class="form-control" id="PickingSlipPathEdit" placeholder="Enter a Picking Slip Path" required>
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
            $('#editPickingTeam').hide();
            $('#salesInvoiced').hide();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#add").click(function() {
                $(".general-loader").show();
                $.ajax({
                    url: '{!!url("/addPickingTeam")!!}',
                    type: "POST",
                    data: {
                        PickingTeamId: $('#PickingTeamId').val(),
                        PickingTeam: $('#PickingTeam').val(),
                        Commision: $('#Commision').val(),
                        PickingSlipPath: $('#PickingSlipPath').val(),
                        statement: 'Insert'
                    },
                    success: function (data)
                    {
                        location.reload(true);
                    },
                    error: function(xhr){
                        $(".general-loader").hide();
                    }
                });
            });

            $('#tablePickingTeam tbody').on('dblclick', 'tr', function() {
                // $(this).closest("tr").hide();
                $('#editPickingTeam').show();
                var $this = $(this);
                var row = $this.closest("tr");
                var pickingteamId = row.find('td:eq(0)').text();
                var pickingteam = row.find('td:eq(1)').text();
                var commision = row.find('td:eq(2)').text();
                var pickingslippath = row.find('td:eq(3)').text();
                showDialog('#editPickingTeam',600,400);
                $('#updatemessage').empty();
                $('#PickingTeamIdEdit').val(pickingteamId);
                $('#PickingTeamEdit').val(pickingteam);
                $('#CommisionEdit').val(commision);
                $('#PickingSlipPathEdit').val(pickingslippath);
                $('#updatemessage').append("You are now editing the Picking Team of " + pickingteam+"!");
            });

            $('#tablePickingTeam tbody').on('click', 'button', function (e) {
                $('#deletePickingTeam').show();
                var $this = $(this);
                var row = $this.closest("button");
                showDialog('#deletePickingTeam',600,600);
            });

            $("#edit").click(function() {
                $(".general-loader").show();
                $.ajax({
                    url: '{!!url("/editPickingTeam")!!}',
                    type: "POST",
                    data: {
                        PickingTeamId: $('#PickingTeamIdEdit').val(),
                        PickingTeam: $('#PickingTeamEdit').val(),
                        Commision: $('#CommisionEdit').val(),
                        PickingSlipPath: $('#PickingSlipPathEdit').val(),
                        statement: 'Update'
                    },
                    success: function (data)
                    {
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
                    url: '{!!url("/deletePickingTeam")!!}',
                    type: "POST",
                    data: {
                        PickingTeamId: $('#PickingTeamIdEdit').val(),
                        PickingTeam: $('#PickingTeamEdit').val(),
                        Commision: $('#CommisionEdit').val(),
                        PickingSlipPath: $('#PickingSlipPathEdit').val(),
                        statement: 'Delete'
                    },
                    success: function (data)
                    {
                        location.reload(true);
                    },
                    error: function(xhr){
                        $(".general-loader").hide();
                    }
                });
            });
        });
        function showDialog(tag,width,height)
        {
            $( tag ).dialog({height: height, modal: false, width: width,containment: false})
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

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
        h2{color:red;}
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
        }
    </style>
    <div class="container" style="width: 100%;">
            <div class="form-group row add">
            <div class="col-lg-12" >
                    <div class="col-lg-4">

                        <form>
                            <fieldset class="well">
                                <legend class="well-legend">Add Screen</legend>
                                <div class="form-group ">
                                    <label class="control-label" for="PickingTeam"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Picking Team</h4></label>
                                    <input type="text" class="form-control input-sm col-s-2" id="PickingTeam" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Picking Team" required>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label" for="Commision"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Commision</h4></label>
                                    <input type="text" class="form-control input-sm col-s-2" id="Commision" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Commission" required>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label" for="PickingSlipPath"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Picking Slip Path</h4></label>
                                    <input type="text" class="form-control input-sm col-s-2" id="PickingSlipPath" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Picking Team" required>
                                </div>


                            </fieldset>
                        </form>
                        <button class=" btn btn-success fa fa-plus-circle" type="submit" id="add" >ADD</button>

                    </div>
                    <div class="col-lg-8">
                            <div class="col-lg-12  visible-md visible-lg" >
                                <div id="PickingTeam" title="PickingTeam List">
                                    <div class="col-lg-12">
                                        <form>
                                            <div class="table-responsive scrollable text-center">
                                                <table class="table table-borderless" id="tablePickingTeam">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center " >Picking Team ID</th>
                                                        <th class="text-center ">Picking Team</th>
                                                        <th class="text-center " >Commision</th>
                                                        <th class="text-center ">Picking Slip Path</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($readPickingTeam as $values)
                                                    <tr class="item{{$values->PickingTeamId}}">
                                                        <td class="text-center" >{{$values->PickingTeamId}}</td>
                                                        <td class="text-center" >{{$values->PickingTeam}}</td>
                                                        <td class="text-center" >{{$values->Commision}}</td>
                                                        <td class="text-center" >{{$values->PickingSlipPath}}</td>
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
    </div>
        <div id="editPickingTeam" title="Please Edit Picking Team Information">
            <form>
                <fieldset class="well">
                    <legend class="well-legend">Edit Screen</legend>
                    <div><h2 id="updatemessage">  </h2>
                    </div>
                    <div class="form-group ">
                        <input type="hidden" class="form-control input-sm col-xs-1" id="PickingTeamIdEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Name You want to add" required>
                    </div>

                    <div class="form-group ">
                                    <label class="control-label" for="PickingTeamEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Picking Team</h4></label>
                                    <input type="text" class="form-control input-sm col-s-2" id="PickingTeamEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Picking Team" required>
                    </div>
                    <div class="form-group ">
                        <label class="control-label" for="CommisionEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Commision</h4></label>
                            <input type="text" class="form-control input-sm col-s-2" id="CommisionEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Commision" required>
                        </div>
                    <div class="form-group ">
                                    <label class="control-label" for="PickingSlipPathEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Picking Slip Path</h4></label>
                                    <input type="text" class="form-control input-sm col-s-2" id="PickingSlipPathEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Picking Slip Path" required>
                    </div>



                </fieldset>
            </form>
            <div class="col-lg-4">
            <button class="btn btn-primary " type="submit" id="edit">UPDATE</button>
            </div>
            <div class="col-lg-4">
            <button class=" btn btn-danger "  type="submit" id="delete">DELETE</button>
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

    $("#add").click(function()
    {


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
            showDialog('#editPickingTeam',600,600);
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


    $("#edit").click(function()
    {


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


                        }




                    });


    });

    $("#delete").click(function()
    {


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
                        }

                    });


    });




    });
    function showDialog(tag,width,height)
        {
            $( tag ).dialog({height: height, modal: false,
                width: width,containment: false}).dialogExtend({
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

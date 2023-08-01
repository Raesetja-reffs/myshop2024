<x-app-layout>

    <x-slot name="header">
        {{ __('Trucks') }}
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
            Trucks </li>
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
                                    <label class="control-label" for=  "TruckName" style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Truck Name</h4></label>
                                    <input type="text" class="form-control input-sm col-s-2" id="TruckName" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Truck You Want To Add" required>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label" for="RegNo"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Truck Reg No.</h4></label>
                                    <input type="text" class="form-control input-sm col-s-2" id="RegNo" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Reg No." required>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label" for="Capacity"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Capacity</h4></label>
                                    <input type="text" class="form-control input-sm col-s-2" id="Capacity" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter The Trucks Capacity" required>
                                </div>
                            <button class=" btn btn-success fa fa-plus-circle" type="submit" id="add" >ADD</button>

                            </fieldset>
                        </form>

                    </div>
                    <div class="col-lg-8">
                            <div class="col-lg-12  visible-md visible-lg" >
                                <div id="Trucks" title="Trucks List">
                                    <div class="col-lg-12">
                                        <form>
                                            <div class="table-responsive scrollable text-center">
                                                <table class="table table-borderless" id="tableTrucks">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center " ><h3>Truck ID</h3></th>
                                                        <th class="text-center "><h3>Truck Name</h3></th>
                                                        <th class="text-center "><h3> Truck Reg No.</h3></th>
                                                        <th class="text-center "><h3> Truck Capacity</h3></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($readTrucksItems as $values)
                                                    <tr class="item{{$values->TruckId}}">
                                                        <td class="text-center" >{{$values->TruckId}}</td>
                                                        <td class="text-center" >{{$values->TruckName}}</td>
                                                        <td class="text-center" >{{$values->RegNo}}</td>
                                                        <td class="text-center" >{{$values->Capacity}}</td>
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
        <div id="editTrucks" title="Please Edit Truck Information">
            <form>
                <fieldset class="well">
                    <legend class="well-legend">Edit Truck Screen</legend>
                    <div><h2 id="updatemessage">  </h2>
                    </div>
                    <div class="form-group ">
                        <label class="control-label" for="TruckNameEdit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Truck Name</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="TruckNameEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Name You want to add" required>
                        <input type="hidden" class="form-control input-sm col-xs-1" id="TruckIdEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Name You want to add" required>
                    </div>
                    <div class="form-group ">
                        <label class="control-label" for="RegNoEdit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Truck Reg No.</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="RegNoEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter the Reg No." required>
                    </div>
                    <div class="form-group ">
                        <label class="control-label" for="CapacityEdit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Truck Capacity</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="CapacityEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter Truck Capacity" required>
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
            $('#editTrucks').hide();
            $('#salesInvoiced').hide();
                            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

    $("#add").click(function()
    {


        $.ajax({
                        url: '{!!url("/addTrucksItem")!!}',
                        type: "POST",
                        data: {
                            TruckId: $('#TruckId').val(),
                            TruckName: $('#TruckName').val(),
                            RegNo: $('#RegNo').val(),
                            Capacity: $('#Capacity').val(),
                            statement: 'Insert'
                        },
                        success: function (data)
                        {
                            //location.reload(true);
                        }
                    });


    });

    $('#tableTrucks tbody').on('dblclick', 'tr', function() {
            // $(this).closest("tr").hide();
            $('#editTrucks').show();
            var $this = $(this);
            var row = $this.closest("tr");
            var truckId = row.find('td:eq(0)').text();
            var truckName = row.find('td:eq(1)').text();
            var regNo = row.find('td:eq(2)').text();
            var capacity = row.find('td:eq(3)').text();
            showDialog('#editTrucks',600,600);
            $('#updatemessage').empty();
            $('#TruckNameEdit').val(truckName);
            $('#RegNoEdit').val(regNo);
            $('#CapacityEdit').val(capacity);
            $('#TruckIdEdit').val(truckId);
            $('#updatemessage').append("You are now editing the information of " + truckName+"!");

    });
    $('#tableTrucks tbody').on('click', 'button', function (e) {
            $('#deleteTrucks').show();
            var $this = $(this);
            var row = $this.closest("button");
            showDialog('#deleteTrucks',600,600);

    });

    $("#edit").click(function()
    {


        $.ajax({
                        url: '{!!url("/editTrucksItem")!!}',
                        type: "POST",
                        data: {
                            TruckId: $('#TruckIdEdit').val(),
                            TruckName: $('#TruckNameEdit').val(),
                            RegNo: $('#RegNoEdit').val(),
                            Capacity: $('#CapacityEdit').val(),
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
                        url: '{!!url("/deleteTrucksItem")!!}',
                        type: "POST",
                        data: {
                            TruckId: $('#TruckIdEdit').val(),
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

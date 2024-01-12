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
                            <label for="TruckName">
                                Truck Name
                            </label>
                            <input type="text" class="form-control" id="TruckName" placeholder="Enter a Truck You Want To Add" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="RegNo">
                                Truck Reg No.
                            </label>
                            <input type="text" class="form-control" id="RegNo" placeholder="Enter a Reg No." required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="Capacity">
                                Capacity
                            </label>
                            <input type="text" class="form-control" id="Capacity" placeholder="Enter The Trucks Capacity" required>
                        </div>
                        <button class="btn btn-success btn-sm w-100" type="submit" id="add">
                            <i class="fas fa-plus-circle fs-4 me-2"></i>ADD
                        </button>
                    </form>
                </div>
                <div class="col-md-8">
                    <div id="Trucks" title="Trucks List">
                        <form>
                            <div class="table-responsive scrollable overflow-y-auto" style="max-height: 480px;">
                                <table id="tableTrucks" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Truck ID</th>
                                            <th>Truck Name</th>
                                            <th>Truck Reg No.</th>
                                            <th>Truck Capacity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($readTrucksItems as $values)
                                            <tr class="item{{$values->TruckId}}">
                                                <td>{{$values->TruckId}}</td>
                                                <td>{{$values->TruckName}}</td>
                                                <td>{{$values->RegNo}}</td>
                                                <td>{{$values->Capacity}}</td>
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

    <div id="editTrucks" title="Please Edit Truck Information" style="background-color: #F1F1F2;">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <p>Edit Truck Screen</p>
                        </div>
                        <div class="col-md-12">
                            <h2 id="updatemessage"></h2>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="TruckNameEdit">Truck Name</label>
                            <input type="text" class="form-control" id="TruckNameEdit" placeholder="Enter a Name You want to add" required>
                            <input type="hidden" class="form-control" id="TruckIdEdit" placeholder="Enter a Name You want to add" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="RegNoEdit">Truck Reg No.</label>
                            <input type="text" class="form-control" id="RegNoEdit" placeholder="Enter the Reg No." required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="CapacityEdit">Truck Capacity</label>
                            <input type="text" class="form-control" id="CapacityEdit" placeholder="Enter Truck Capacity" required>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-sm" type="submit" id="edit">UPDATE</button>
                            <button class="btn btn-danger btn-sm" type="submit" id="delete">DELETE</button>
                        </div>
                    </div>
                </form>
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
            showDialog('#editTrucks', 600, 400);
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

        $("#edit").click(function() {
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

        $("#delete").click(function() {
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

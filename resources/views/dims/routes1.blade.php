<x-app-layout>
    <x-slot name="header">
        {{ __('Sales Order') }}
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
            Dashboard </li>
        <!--end::Item-->
    </x-slot>

    <head>
    <style>
    h2{color:red;}
    h3 {color:blue;}
    h4 {color:orange;}
    td{color:orange;}
    /* tbody{background-color:black;} */


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
    </head>


    <div class="container" style="width: 100%;">
            <div class="form-group row add">
            <div class="col-lg-12" >
                    <div class="col-lg-4">
                    @if($routesfullaccess !="0")
                        <form>
                            <fieldset class="well">
                                <legend class="well-legend">Add Screen</legend>
                                <div class="form-group ">
                                    <label class="control-label" for=  "Route" style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Route</h4></label>
                                    <input type="text" class="form-control input-sm col-s-2" id="Route" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Route You Want To Add" required>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label" for=  "Route" style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Location</h4></label>
                                <select id="location" required>
                                    <option value="">Select Location</option>
                                    @foreach($locations as $val)
                                        <option value="{{$val->ID}}">{{$val->locationName}}</option>
                                    @endforeach
                                </select>
                                </div>



                            </fieldset>
                        </form><button class=" btn btn-success fa fa-plus-circle" id="add" >ADD</button>
                        @endif
                    </div>
                    <div class="col-lg-8">
                            <div class="col-lg-12  visible-md visible-lg" >
                                <div id="Routes" title="Routes List">
                                    <div class="col-lg-12">
                                        <form>
                                            <div class="table-responsive scrollable text-center">
                                                <table class="table table-borderless" id="tableRoutes">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center " ><h3>Route ID</h3></th>
                                                        <th class="text-center "><h3>Route</h3></th>
                                                        <th class="text-center "><h3>Location</h3></th>
                                                        <th class="text-center "><h3>Location ID</h3></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($readRoutesItems as $values)
                                                    <tr class="item{{$values->Routeid}}">
                                                        <td class="text-center" >{{$values->Routeid}}</td>
                                                        <td class="text-center" >{{$values->Route}}</td>
                                                        <td class="text-center" >{{(isset($locations[$values->LocationId]) ? $locations[$values->LocationId]->locationName : '')}}</td>
                                                        <td class="text-center" >{{$values->Routeid}}</td>
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
        <div id="editRoutes" title="Please Edit Route Information">
            @if($routesfullaccess !="0")
            <form>
                <fieldset class="well">
                    <legend class="well-legend">Edit Route Screen</legend>
                    <div><h2 id="updatemessage">  </h2>
                    </div>
                    <div class="form-group ">
                        <label class="control-label" for="RouteEdit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route </label>
                        <input type="text" class="form-control input-sm col-xs-1" id="RouteEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Route You want to add" required>
                        <input type="hidden" class="form-control input-sm col-xs-1" id="RouteidEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Name You want to add" required>
                    </div>
                    <div class="form-group ">
                        <label class="control-label" for=  "Route" style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Location</h4></label>
                        <select id="locationnew" required>

                            @foreach($locations as $val)
                                <option value="{{$val->ID}}">{{$val->locationName}}</option>
                            @endforeach
                        </select>
                    </div>

                </fieldset>
            </form>
            <div class="col-lg-4">
            <button class="btn btn-primary " type="submit" id="edit">UPDATE</button>
            </div>
            <div class="col-lg-4">
            <button class=" btn btn-danger "  type="submit" id="delete">DELETE</button>
                @else
                    <h3>YOU DON'T HAVE ACCESS TO EDIT ROUTE, PLEASE SPEAK TO YOUR MANAGER</h3>
                    @endif
            </div>





        </div>
    </div>

    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

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
            $('#editRoutes').hide();
            $('#salesInvoiced').hide();
                            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

    $("#add").click(function()
    {


        $.ajax({
                        url: '{!!url("/addRoutesItem")!!}',
                        type: "POST",
                        data: {
                            Routeid: $('#Routeid').val(),
                            Route: $('#Route').val(),
                            location: $('#location').val(),
                            statement: 'Insert'
                        },
                        success: function (data)
                        {
                            location.reload(true);
                        }
                    });


    });

    $('#tableRoutes tbody').on('dblclick', 'tr', function() {
            // $(this).closest("tr").hide();
            $('#editRoutes').show();
            var $this = $(this);
            var row = $this.closest("tr");
            var routeId = row.find('td:eq(0)').text();
            var route = row.find('td:eq(1)').text();
            var locationID = row.find('td:eq(3)').text();
        $('#locationnew').prepend('<option value="'+locationID+'" selected="selected">Current Location('+locationID+')</option>');
            showDialog('#editRoutes',600,600);
            $('#updatemessage').empty();
            $('#RouteEdit').val(route);
            $('#RouteidEdit').val(routeId);
            $('#updatemessage').append("You are now editing " + route+" route information!");

    });
    $('#tableRoutes tbody').on('click', 'button', function (e) {
            $('#deleteRoutes').show();
            var $this = $(this);
            var row = $this.closest("button");
            showDialog('#deleteRoutes',600,600);

    });

    $("#edit").click(function()
    {


        $.ajax({
                        url: '{!!url("/editRoutesItem")!!}',
                        type: "POST",
                        data: {
                            Routeid: $('#RouteidEdit').val(),
                            Route: $('#RouteEdit').val(),
                            locationID:$('#locationnew').val(),
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
                        url: '{!!url("/deleteRoutesItem")!!}',
                        type: "POST",
                        data: {
                            Routeid: $('#RouteidEdit').val(),
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


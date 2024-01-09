<x-app-layout>
    <x-slot name="header">
        {{ __('Route List') }}
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
            Route List </li>
        <!--end::Item-->
    </x-slot>

    <head>
        <style>
            /*h2 {
                color: red;
            }

            h3 {
                color: blue;
            }

            h4 {
                color: orange;
            }

            td {
                color: orange;
            }*/

            /*tbody{background-color:black;}*/


            /*input[type=text],
            select {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 2px;
                box-sizing: border-box;
                cursor: text;
            }

            div.scrollable {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                overflow-y: scroll
            }*/
        </style>
    </head>

    <div class="card mt-5">
        <div class="card-body">
            <div class="row">
                @if ($routesfullaccess != '0')
                    <div class="col-md-4">
                        <form>
                            <h5>Add Screen</h5>
                            <div class="form-group mb-3">
                                <label for="Route">Route</label>
                                <input type="text" class="form-control" id="Route" placeholder="Enter a Route You Want To Add" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="location">Location</label>
                                <select id="location" class="form-control form-select" required>
                                    <option value="">Select Location</option>
                                    @foreach ($locations as $val)
                                        <option value="{{ $val->ID }}">{{ $val->locationName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-success btn-sm w-100" type="submit" id="add">
                                <i class="fas fa-plus-circle fs-4 me-2"></i>ADD
                            </button>
                        </form>
                    </div>
                @endif
                <div class="col-md-8">
                    <div id="Routes" title="Routes List">
                        <form>
                            <div class="table-responsive scrollable overflow-y-auto" style="max-height: 480px;">
                                <table id="tableRoutes" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Route ID</th>
                                            <th>Route</th>
                                            <th>Location</th>
                                            <th>Location ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($readRoutesItems as $values)
                                            <tr class="item{{$values->Routeid}}">
                                                <td>{{$values->Routeid}}</td>
                                                <td>{{$values->Route}}</td>
                                                <td>
                                                    {{ isset($locations[$values->LocationId]) ? $locations[$values->LocationId]->locationName : '' }}
                                                </td>
                                                <td>{{$values->Routeid}}</td>
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

    <div id="editRoutes" title="Please Edit Route Information" style="background-color: #F1F1F2;">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @if ($routesfullaccess != '0')
                        <div class="col-md-12">
                            <p>Edit Route Screen</p>
                        </div>
                        <div class="col-md-12">
                            <h2 id="updatemessage"></h2>
                        </div>
                        <div class="col-md-12 mb-3">
                            <input type="hidden" class="form-control" id="RouteidEdit" placeholder="Enter a Name You want to add" required>
                            <label for="RouteEdit">Route</label>
                            <input type="text" class="form-control" id="RouteEdit" placeholder="Enter a Route You want to add" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="locationnew">Location</label>
                            <select id="locationnew" class="form-control form-select" required>
                                @foreach ($locations as $val)
                                    <option value="{{ $val->ID }}">{{ $val->locationName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-sm" type="submit" id="edit">UPDATE</button>
                            <button class="btn btn-danger btn-sm" type="submit" id="delete">DELETE</button>
                        </div>
                    @else
                        <div class="col-md-12">
                            <h3>YOU DON'T HAVE ACCESS TO EDIT ROUTE, PLEASE SPEAK TO YOUR MANAGER</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
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

            $("#add").click(function() {
                $(".general-loader").show();
                $.ajax({
                    url: '{!! url('/addRoutesItem') !!}',
                    type: "POST",
                    data: {
                        Routeid: $('#Routeid').val(),
                        Route: $('#Route').val(),
                        location: $('#location').val(),
                        statement: 'Insert'
                    },
                    success: function(data) {
                        location.reload(true);
                    },
                    error: function(xhr){
                        $(".general-loader").hide();
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
                $('#locationnew').prepend('<option value="' + locationID +
                    '" selected="selected">Current Location(' + locationID + ')</option>');
                showDialog('#editRoutes', 600, 300);
                $('#updatemessage').empty();
                $('#RouteEdit').val(route);
                $('#RouteidEdit').val(routeId);
                $('#updatemessage').append("You are now editing " + route + " route information!");
            });

            $('#tableRoutes tbody').on('click', 'button', function(e) {
                $('#deleteRoutes').show();
                var $this = $(this);
                var row = $this.closest("button");
                showDialog('#deleteRoutes', 600, 600);
            });

            $("#edit").click(function() {
                $(".general-loader").show();
                $.ajax({
                    url: '{!! url('/editRoutesItem') !!}',
                    type: "POST",
                    data: {
                        Routeid: $('#RouteidEdit').val(),
                        Route: $('#RouteEdit').val(),
                        locationID: $('#locationnew').val(),
                        statement: 'Update'
                    },
                    success: function(data) {
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
                    url: '{!! url('/deleteRoutesItem') !!}',
                    type: "POST",
                    data: {
                        Routeid: $('#RouteidEdit').val(),
                        statement: 'Delete'
                    },
                    success: function(data) {
                        location.reload(true);
                    },
                    error: function(xhr){
                        $(".general-loader").hide();
                    }
                });
            });
        });

        function showDialog(tag, width, height) {
            $(tag).dialog({
                height: height,
                modal: false,
                width: width,
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
        }
    </script>
</x-app-layout>

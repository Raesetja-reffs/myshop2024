<x-app-layout>

    <x-slot name="header">
        {{ __('Order Types') }}
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
            Order Types
        </li>
        <!--end::Item-->
    </x-slot>

    <head>
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
    </head>

    <div class="card mt-5">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <form>
                        <h5>Add Screen</h5>
                        <div class="form-group mb-3">
                            <label for="OrderType">
                                Order Type
                            </label>
                            <input type="text" class="form-control" id="OrderType" placeholder="Enter an Order Type" required>
                        </div>
                        <button class="btn btn-success btn-sm w-100" type="submit" id="add">
                            <i class="fas fa-plus-circle fs-4 me-2"></i>ADD
                        </button>
                    </form>
                </div>
                <div class="col-md-8">
                    <div id="OrderTypes" title="OrderTypes List">
                        <form>
                            <div class="table-responsive scrollable overflow-y-auto" style="max-height: 480px;">
                                <table id="tableOrderTypes" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Order Type ID</th>
                                            <th>Order Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($readOrderTypes as $values)
                                            <tr class="item{{$values->OrderTypeId}}">
                                                <td>{{$values->OrderTypeId}}</td>
                                                <td>{{$values->OrderType}}</td>
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

    <div id="editOrderTypes" title="Please Edit Order Type Information" style="background-color: #F1F1F2;">
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
                            <label for="OrderTypeEdit">Order Type</label>
                            <input type="text" class="form-control" id="OrderTypeEdit" placeholder="Enter a Order Type" required>
                            <input type="hidden" class="form-control" id="OrderTypeIdEdit" placeholder="Enter a Name You want to add" required>
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
            $('#editOrderTypes').hide();
            $('#salesInvoiced').hide();

            $("#add").click(function() {
                $.ajax({
                    url: '{!!url("/addOrderType")!!}',
                    type: "POST",
                    data: {
                        OrderTypeId: $('#OrderTypeId').val(),
                        OrderType: $('#OrderType').val(),
                        statement: 'Insert'
                    },
                    success: function (data)
                    {
                        location.reload(true);
                    }
                });
            });

            $('#tableOrderTypes tbody').on('dblclick', 'tr', function() {
                // $(this).closest("tr").hide();
                $('#editOrderTypes').show();
                var $this = $(this);
                var row = $this.closest("tr");
                var orderTypeId = row.find('td:eq(0)').text();
                var orderType = row.find('td:eq(1)').text();
                showDialog('#editOrderTypes', 600, 250);
                $('#updatemessage').empty();
                $('#OrderTypeIdEdit').val(orderTypeId);
                $('#OrderTypeEdit').val(orderType);
                $('#updatemessage').append("You are now editing the Order Type of " + orderType+"!");
            });

            $('#tableOrderTypes tbody').on('click', 'button', function (e) {
                $('#deleteOrderTypes').show();
                var $this = $(this);
                var row = $this.closest("button");
                showDialog('#deleteOrderTypes',600,600);
            });

            $("#edit").click(function() {
                $.ajax({
                    url: '{!!url("/editOrderType")!!}',
                    type: "POST",
                    data: {
                        OrderTypeId: $('#OrderTypeIdEdit').val(),
                        OrderType: $('#OrderTypeEdit').val(),
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
                    url: '{!!url("/deleteOrderType")!!}',
                    type: "POST",
                    data: {
                        OrderTypeId: $('#OrderTypeIdEdit').val(),
                        OrderType: $('#OrderTypeEdit').val(),
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

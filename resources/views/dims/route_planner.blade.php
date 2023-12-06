<x-app-layout>

    <x-slot name="header">
        {{ __('Route Planner') }}
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
            Route Planner </li>
        <!--end::Item-->
    </x-slot>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <button id="startPlanning" class="btn btn-success btn-auto-height">START</button>
                    <button id="ordersNotCorrect" class="btn btn-success btn-auto-height" style="display:none;">ROUTES DIFFERENCES</button>
                    <button id="tripSheetInfo" class="btn btn-success btn-auto-height">Trip Sheets Information</button>
                    <button id="visualise" class="btn btn-success btn-auto-height" style="display:none;">Search</button>
                    <button id="printTruckSheet" class="btn btn-success btn-auto-height" style="display:none;">Print</button>
                </div>
            </div>
        </div>
    </div>

    <div id="routePlanningPopUp" title="Route Planning">
        <div class="col-lg-12">
            <div class="col-lg-10" >
                <div class="col-lg-12">
                    <form>
                        <fieldset class="well">
                            <legend class="well-legend">Create</legend>
                            <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="deliveryDatesonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                                <input name="deliveryDatesonPlanning" class="form-control input-sm col-xs-1" id="deliveryDatesonPlanning" >
                            </div>
                            <div class="form-group  col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="orderTypesTabletLoadingonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Type</label>
                                <select name="orderTypesTabletLoadingonPlanning" class="form-control input-sm col-xs-1" id="orderTypesTabletLoadingonPlanning" style="height:30px;font-size: 10px;"></select>
                            </div>
                            <div class="form-group col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="rouTabletLoadingtesonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                                <select  id="rouTabletLoadingtesonPlanning" class="form-control input-sm col-xs-1" >
                                    <option value="-99">------All------</option>
                                </select>
                            </div>
                            <div class="form-group  col-md-1"  style="margin-top: 15px; margin-left: -14px;margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <button type="button" id="tabletLoadingGoonPlanning" class="btn-sm btn-success">Orders </button>
                            </div>
                            <div class="form-group  col-md-1"  style="display:none;margin-top: 15px; margin-left: -14px;margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <button type="button" id="tabletLoadingGoonProducts" class="btn-sm btn-success">Products </button>
                            </div>
                            <input name="mass" class="form-control input-sm col-xs-1" id="mass" style="color:blue;font-size:15px;font-weight: 900;" >
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="row tabbable">
                <div class="col-xs-12" id="theunsequencedInfo" >

                    <div style="overflow-y: scroll;font-size: 8px;height: 70%; background: white;">

                        <table class="table " id="unsequenced" style="overflow-y: scroll;height: 60%">
                            <thead>
                            <tr>
                                <th style="font-size: 10px;">Delv date</th>
                                <th style="font-size: 10px;">Route</th>
                                <th class="col-md-4" style="font-size: 10px;">Customer</th>
                                <th style="font-size: 10px;">InvNO</th>
                                <th style="font-size: 10px;">OrderID</th>
                                <th style="font-size: 10px;">Delivery Type</th>
                                <th style="font-size: 7px;width:1px;display: none;">Ignore</th>
                                <th style="font-size: 7px;width:1px;display: none;">Ignor2</th>
                                <th style="font-size: 10px;">Seq</th>
                                <th style="font-size: 10px;color:blue;">Mass</th>
                                <th>Action</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody class="connectedSortable">

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </div>
        <div class="col-lg-12" style="background: greenyellow">
            <div class="col-lg-4">

            </div>
            <div class="col-lg-4">
                <button id="doneSorting" class="btn-success btn-md center-block" style="margin-top: 20px;">Finished</button>
            </div>
            <div class="col-lg-4">
                <button id="moveSelectedOrders" class="btn-primary btn-md center-block" style="margin-top: 20px;">Move Orders</button>
            </div>
            <div class="col-lg-4"></div>

            <button id="instantPrint" class="btn-success btn-md pull-right" style="margin-top: 20px;">Print</button>
            <button id="updateSorting" class="btn-success btn-md center-block" style="margin-top: 20px;">Update</button>
        </div>
    </div>
    </div>
    <div id="popupmoveThis" title="Order Change">
        <h5>Please move an order by chosing below</h5>
        <form>
            <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="truckNameSheetMaster"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                <select name="eRouteName" class="form-control input-sm col-sm-1"  id="eRouteName" style="font-size: 14px;" >
@foreach($routes as $value)
    <option value="{{$value->Routeid}}">{{$value->Route}}</option>
    @endforeach
                </select>
            </div>
            <div class="form-group  col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="deliveryTypeRun"  style="margin-bottom: 0px;font-weight: 700;font-size: 14px;">Delivery Type(Run)</label>
                <select name="deliveryTypeRun" class="form-control input-sm col-sm-1" id="deliveryTypeRun" style="font-size: 14px;">
                    @foreach($orderTypes as $value)
                        <option value="{{$value->OrderTypeId}}">{{$value->OrderType}}</option>
                    @endforeach
                </select>
            </div>

        </form>
        <div class="form-group col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 14px;">
            <button class="btn-success btn-xs" id="submitChanges">submit</button>
        </div>
    </div>
    <div style="display:none;">
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="dateCreateForControlSheetSheetMaster"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date Created</label>
            <input id="dateCreateForControlSheetSheetMaster" class="form-control input-sm col-xs-1" name="dateCreateForControlSheetSheetMaster" style="height:21px;font-size: 8px;" >
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="dateCreateForControlSheetSheetMaster"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
            <input id="delvDateForControlSheetSheetMaster" class="form-control input-sm col-xs-1" name="dateCreateForControlSheetSheetMaster" style="height:21px;font-size: 8px;" >
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="routeSheetMaster"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
            <select id="routeSheetMaster" class="form-control input-sm col-xs-1" name="routeSheetMaster" style="height:21px;font-size: 8px;" ></select>
        </div><button id="doneWithTruckSheetMasterData" class="btn-success btn-md center-block">Submit</button>
    </div>

    </div>
    <div id="straightForwardPrintThtTruckControlId" class="col-lg-12" title="Print Truck Control Sheet">
        <div class="col-lg-12">

            <fieldset class="well">
                <legend class="well-legend">Filters</legend>
                <div class="form-group col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="truckControlIDsOnPrintButton"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Truck Id Search</label>
                    <input type="text" name="truckControlIDsOnPrintButton" class="form-control input-sm col-md-3" id="truckControlIDsOnPrintButton" >
                    <input type="hidden" name="truckControlKeeper" id="truckControlKeeper">
                </div>
                <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="delivDateFilter" id="lrecentTruckIDOnPrintButton"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Truck Control IDs</label>
                    <select name="recentTruckIDOnPrintButton" class="form-control input-sm col-md-3"  id="recentTruckIDOnPrintButton"  ></select>
                </div>
            </fieldset>
            <p id="truckCotrolMessageAfterPrint"></p>

        </div>
    </div>
    <div id="trucSheetViewPopUp" title="Truck Control Sheet">
        <button id="printTruckSheet" class="btn-sm btn-success">Print TruckSheet</button>
    </div>


<style>
    .onDrag {
        height: 26px !important;
    }
</style>
{{-- <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script> --}}
<script>

    var jArrayOrderTypes = JSON.stringify({!! json_encode($orderTypes) !!});
    var jArraydelivDates = JSON.stringify({!! json_encode($delivDates) !!});
    var jArraydelivroutes = JSON.stringify({!! json_encode($routes) !!});
    var jArraydDrivers = JSON.stringify({!! json_encode($drivers) !!});
    var jArraydtrucks = JSON.stringify({!! json_encode($trucks) !!});

    var computerName = '<?php echo gethostname() ?>';

    $(document).ready(function() {
        $('#routePlanningPopUp').hide();
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#tabletLoadingApp').hide();
        $('#salesQuotebtn').hide();
        $('#afterFiltering').hide();
        $('#doneSorting').hide();
        $('#updateSorting').hide();
        $('#popUpForNewTruckControlSheetHeader').hide();
        $('#messageNB').hide();
        $('#straightForwardPrintThtTruckControlId').hide();
        $('#instantPrint').hide();
        $('#trucSheetViewPopUp').hide();
        $('#popupmoveThis').hide();
        $('#pricingOnCustomer').hide();
        $('#salesOnOrder').hide();
        $('#posCashUp').hide();
        $('#salesInvoiced').hide();


        $('#visualise').click(function () {
            window.open('{!!url("/routeplannermap")!!}');
        });
        var toAppendOrderTypes = '';
        $.each(JSON.parse(jArrayOrderTypes),function(i,o){
            toAppendOrderTypes += '<option value="'+o.OrderTypeId+'">'+o.OrderType+'</option>';
        });
        $('#orderTypesTabletLoadingonPlanning').append(toAppendOrderTypes);
       // $('#deliveryTypeRun').append(toAppendOrderTypes);

        var toAppenddelvdates = '';
        $.each(JSON.parse(jArraydelivDates),function(i,o){
            toAppenddelvdates += '<option value="'+o.DeliveryDate+'">'+o.DeliveryDate+'</option>';
        });
        // $('#deliveryDatesonPlanning').append(toAppenddelvdates);

        var toAppendRecentTruckIdFilter = '<option value=""></option>';


        $('#recentTruckIDOnPrintButton').append(toAppendRecentTruckIdFilter);

        //DRIVERS
        var toAppendDrivers = '';
        $.each(JSON.parse(jArraydDrivers),function(i,o){
            toAppendDrivers += '<option value="'+o.DriverId+'">'+o.DriverName+'</option>';
        });
        $('#driver').append(toAppendDrivers);
        $('#driverSheetMaster').append(toAppendDrivers);
        $('#assistant').append(toAppendDrivers);
        $('#assistantSheetMaster').append(toAppendDrivers);

        var toAppendroute = '';
        $.each(JSON.parse(jArraydelivroutes),function(i,o){
            toAppendroute += '<option value="'+o.Routeid+'">'+o.Route+'</option>';
        });
        $('#rouTabletLoadingtesonPlanning').append(toAppendroute);
        $('#eRouteName').append(toAppendroute);
       // $('#routeSheetMaster').append(toAppendroute);
        //TRUCKS
        var toAppendTrucks = '';
        $.each(JSON.parse(jArraydtrucks),function(i,o){
            toAppendTrucks += '<option value="'+o.TruckId+'">'+o.TruckName+'</option>';
        });
        $('#truckName').append(toAppendTrucks);
        $('#truckNameSheetMaster').append(toAppendTrucks);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $tabs = $("#unsequenced");
        $( "tbody.connectedSortable" )
            .sortable({
                containerSelector: 'table',
                connectWith: ".connectedSortable",
                items: "tr",
                appendTo: $tabs,
                helper:"clone",
                zIndex: 99999999,
                start: function(e, ui ){ ui.placeholder.height(ui.helper.outerHeight());$tabs.addClass("dragging") },
                stop: function(){ $tabs.removeClass("dragging") }
            })
            .disableSelection()
        ;

        $('#unsequenced tbody').on('dblclick', 'tr', function () {
            var orderId = $(this).closest('tr').find('td:eq(4)').text();
            var orderType = $(this).closest('tr').find('td:eq(5)').text();
            var orderTypeID = $(this).closest('tr').find('td:eq(6)').text();
            var routeId = $(this).closest('tr').find('td:eq(7)').text();
            var routeName = $(this).closest('tr').find('td:eq(1)').text();
            var invoiceNo = $(this).closest('tr').find('td:eq(3)').text();

            if(($.trim(invoiceNo)).length < 5)
            {
                showDialog('#popupmoveThis','60%',220);
                $('#submitChanges').click(function(){
                    $.ajax({
                        url: '{!!url("/moveTheOrder")!!}',
                        type: "POST",
                        data: {orderTypeId:$('#deliveryTypeRun').val(),routeId:$('#eRouteName').val(),orderId:orderId},
                        success: function (data) {

                            $('#tabletLoadingGoonPlanning').click();

                            $("#popupmoveThis").dialog('close');

                        }
                    });
                });
            }
            else
            {
                alert("SORRY ,THIS IS ALREADY INVOICED YOU CAN NOT MOVE IT");
            }

            //popupmoveThis
        });
        $('#ordersNotCorrect').click(function(){

            window.open ('{!!url("/ordersNotONDefaultRoutes")!!}', "ordersNotOnDefaultRoute",'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0');

        });
        $('#printTruckSheet').click(function(){

            $('#straightForwardPrintThtTruckControlId').show();
            showDialog('#straightForwardPrintThtTruckControlId','60%',620);
        });
        $('#serchInvBtn').click(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //Order Header

        });

        $('#tripSheetInfo').click(function(){
            window.open ('{!!url("/showTripSheets")!!}', "showTripSheets",'left=20,top=20,width=1200,height=900,toolbar=1,resizable=0');

        });
        $('#startPlanning').click(function(){
            var todayDate = '2018-01-01';
            var orderType = 1;
            var route = -99;
            window.open ('{!!url("/routePlannerExtParam")!!}/'+todayDate+'/'+orderType+'/'+route+'/'+3);
            //$('#routePlanningPopUp').show();
            //showDialog('#routePlanningPopUp','100%',1500);

           // selections();
            $('#tabletLoadingGoonPlanning').click(function(){

                $('#afterFiltering').hide();
                $('#doneSorting').show();
                $('#updateSorting').hide();
                $('#messageNB').show();
                $('#instantPrint').hide();

                //console.debug($('#rouTabletLoadingtesonPlanning').val());
               // getMultiRoutSelected();

                //routesToSequence();
            });
            $('#tabletLoadingGoonProducts').click(function(){
                if (($('#deliveryDatesonPlanning').val()).length > 6)
                {
                    window.open('{!!url("/listallProductsRoutePlanner")!!}/'+$('#deliveryDatesonPlanning').val()+'/'+$('#orderTypesTabletLoadingonPlanning').val()+'/'+$('#rouTabletLoadingtesonPlanning').val(), "products", "width=760, height=500, scrollbars=yes")

                }
                else {
                    alert("Please select Date")
                }

            });

        });

        $('#instantPrint').click(function(){
            window.open('{!!url("/testTruckSheetView")!!}/'+this.value);
        });
        $('#recentTruckIDOnPrintButton').on("change", function() {
            $("#truckControlIDsOnPrintButton").val('');
            $('#truckCotrolMessageAfterPrint').empty();
            printDoc('{!!url("/printTruckControlID")!!}', 7,this.value, 0,this.value);
            consoleManagement('{!!url("/logMessageAjax")!!}', 300, 1,'Truck Control Sheet sent to the Printer', 0, 0, 0, 0, 0, 0, 0, 0, this.value, 0, computerName, this.value, 0);
            $('#truckCotrolMessageAfterPrint').append('Instruction has been sent to the Printer for Document number <strong>'+this.value+'</strong>')
        });
        //$('#truckControlIDsOnPrintButton')
        $("#truckControlIDsOnPrintButton").autocomplete({
            source: function (request, response) {
                $.getJSON("{!!url("/truckControlId")!!}", {term: request.term},
                    response);
            },
            minlength: 1,
            delay: 0,
            appendTo: "#straightForwardPrintThtTruckControlId",
            autoFocus: true,
            select: function (e, ui) {
                $("#truckControlIDsOnPrintButton").val(ui.item.TruckControlId);
                $('#truckCotrolMessageAfterPrint').empty();
                printDoc('{!!url("/printTruckControlID")!!}', 7,ui.item.TruckControlId, 0,ui.item.TruckControlId);
                consoleManagement('{!!url("/logMessageAjax")!!}', 300, 1,'Truck Control Sheet sent to the Printer', 0, 0, 0, 0, 0, 0, 0, 0, ui.item.TruckControlId, 0, computerName,ui.item.TruckControlId, 0);
                $('#truckCotrolMessageAfterPrint').append('Instruction has been sent to the Printer for Document number <strong>'+ui.item.TruckControlId+'</strong>')

            }
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            var table ='<table class="table2" ><tr style="font-size: 12px;color:black;width:300px"><td style="background: green;width:50px !important;color:white">'+
                item.TruckControlId+'</td><td style="width:50px !important">'+
                item.Route+'</td></tr></table>';
            return $( "<li>" )
                .data( "ui-autocomplete-item", item )
                .append("<a>"+ table +"</a>" )
                .appendTo( ul );
        };

        $('#updateSorting').click(function(){
            var UnsortedOrderIds = new Array();
            var updateSort = new Array();
            var stringyFy = '';
            $('#unsequenced > tbody ').each(function() {
                var data = $(this);
                var index =  $(this).closest('tr').index();
                UnsortedOrderIds.push({'index':index,'orderId': $(data).find('td:eq(4)').text(),'seq':$(data).find('td:eq(9)').text()});

            });
            $('#sequenced > tbody  > tr:not(:first)').each(function() {
                var dataSeq = $(this);
                var index =  $(this).closest('tr').index();
                updateSort.push({'index':index,'orderId': $(dataSeq).find('td:eq(4)').text(),'seq':$(dataSeq).find('td:eq(6)').text()});

            });
            $.ajax({
                url: '{!!url("/stopsUnmapped")!!}',
                type: "POST",
                data: {ordersToStop:UnsortedOrderIds,updateSort:updateSort,truckControlKeeper:$('#truckControlKeeper').val()},
                success: function (data) {
                    var dialog = $('<p><strong style="color:red">'+data.updateSort+'</strong>Finished Updating ,You can <button id="printThisTruckControl" class="btn-success btn-xs" value="'+data.truckId+'">Print</button> here.</p>').dialog({height:200,width:700,
                        buttons: {
                            "Close": function() { dialog.dialog('close')  }
                        }
                    });
                    $('#printThisTruckControl').click(function () {

                        printTruckSheetOrders('{!!url("/printTruckControlIDOrders")!!}',$('#printThisTruckControl').val());

                        // location.reload(true);
                    });
                }
            });

        });
        $("#deliveryDatesonPlanning").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true,
            dateFormat: 'yy-mm-dd' });
        $('#doneSorting').click(function(){
            var sortedOrderIds = new Array();
            var stringyFy = '';
            $('#unsequenced > tbody > tr').each(function() {
                var data = $(this);
                var index =  $(this).closest('tr').index();
                sortedOrderIds.push({'index':index,'orderId': $(data).find('td:eq(4)').text()});//

            });

            $.ajax({
                url: '{!!url("/sequencingTheStops")!!}',
                type: "POST",
                data: {ordersToStop:sortedOrderIds},
                success: function (data) {
                    var dialog = $('<p><strong style="color:red">'+data.count+'</strong> Stops being Sequenced' +' </p>').dialog({height:200,width:700,
                        buttons: {
                            "Okay": function() { dialog.dialog('close');location.reload(true);  }
                        }
                    });

                }
            });
            // });
            //console.debug(sortedOrderIds);

        });
        $('#unsequenced').on('click', 'button', function (e) {
            var $this = $(this);
            var row_index = $this.closest('tr').index();
            var row_closestTrColumns = $this.closest('tr');
            var orderId = row_closestTrColumns.find('td:eq(4)').text();
            console.debug("**********************orderId "+orderId);
            window.open('{!!url("/productontheminiorderform")!!}/'+orderId, "productsontheorder", "width=760, height=500, scrollbars=yes")

        });
        $('#moveSelectedOrders').on('click',function(){
            var valuesProd = new Array();
            $.each($("input[name='caseProd[]']:checked"),
                function () {
                    var data = $(this).parents('tr:eq(0)');
                    valuesProd.push({ 'orderId':$(data).find('td:eq(4)').text()});
                });
            showDialog('#popupmoveThis','60%',220);
            $('#submitChanges').click(function(){
                console.debug("after clicking submit****************"+valuesProd);
                $.ajax({
                    url: '{!!url("/moveTheOrderArray")!!}',
                    type: "POST",
                    data: {orderTypeId:$('#deliveryTypeRun').val(),routeId:$('#eRouteName').val(),orderId:valuesProd},
                    success: function (data) {

                        $('#tabletLoadingGoonPlanning').click();

                        $("#popupmoveThis").dialog('close');

                    }
                });
            });


        });
    });
    function selections()
    {
        /*$('#rouTabletLoadingtesonPlanning').multiselect({
         columns: 1,
         placeholder: 'Select Routes',
         selectAll: true
         });*/

        /*  $('#deliveryDatesonPlanning').multiselect({
         columns: 1,
         placeholder: 'Select Delivery Dates',
         selectAll: true
         });*/
    }
    function printTruckSheetOrders(url,truckId)
    {
        $.ajax({
            url: url ,
            type: "POST",
            data:{truckId:truckId},
            success: function(data){
                var dialog = $('<p><strong style="color:red"></strong>Continue to View and Print the Truck Sheet.</p>').dialog({height:200,width:700,
                    buttons: {
                        "Continue": function() {
                            window.open('{!!url("/testTruckSheetView")!!}/'+truckId);
                            dialog.dialog('close');
                        }
                    }
                });
            }
        });
    }
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
                "close" : "ui-icon-circle-close",
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
    function getMultiRoutSelected()
    {
        console.debug($('#deliveryDatesonPlanning').val());

        $.ajax({
            url: '{!!url("/getRouteDataMultiSelected")!!}',
            type: "POST",
            data: {
                routeId: $('#rouTabletLoadingtesonPlanning').val(),
                deliveryDate: $('#deliveryDatesonPlanning').val(),
                OrderType: $('#orderTypesTabletLoadingonPlanning').val()
            },
            success: function (data) {
                var trHTML = '';
                var style = '';
                $('.onDrag').remove();
                var massTotal = 0;
                $.each(data, function (key, value) {

                    massTotal =  parseFloat(massTotal) + parseFloat(value.Mass);
                    trHTML += '<tr role="row" class="onDrag" style="height: 26px !important;"  ><td>' +
                        value.DeliveryDate + '</td><td>' +
                        value.Route + '</td><td style="background:yellow">' +

                        value.StoreName + '</td><td>' +
                        value.InvoiceNo + '</td><td>' +
                        value.OrderId + '</td><td style="font-weight:900">' +
                        value.OrderType + '</td><td style="display: none;">' +
                        value.OrderTypeId + '</td><td style="display: none;">' +
                        value.RouteId + '</td><td>' +
                        value.DeliverySequence + '</td><td style="color:blue">' +
                        parseFloat(value.Mass).toFixed(3) + '</td><td>' +
                        '<button class="btn-xs btn-success" style="width: 76px;height: 24px;font-size: 8px;"  value="'+value.OrderId+'">View Products</button></td><td><input type="checkbox" name="caseProd[]" style="height:20px;width:30px" value="'+value.OrderId+'"></td>' +

                        '</tr>';
                });
                $('#unsequenced').append(trHTML);
                $('#mass').val(parseFloat(massTotal).toFixed(3));

            }
        });
    }
    function printDoc(url,docType,docID,isDeliveryNote,invoiceNumber)
    {
        $.ajax({
            url: url ,
            type: "POST",
            data:{DocType:docType,DocId:docID,PrintDeliveryNote:isDeliveryNote,invoiceNumber:invoiceNumber},
            success: function(data){

            }
        });
    }
    function truckControlSheetHeaderOnFiltering(truckControlId)
    {
//getTruckControlSheetHeaderByTruckId
        $.ajax({
            url: '{!!url("/getTruckControlSheetHeaderByTruckId")!!}',
            type: "POST",
            data: {
                truckControlID: truckControlId
            },
            success: function (data) {
                $('#truckName').prepend('<option value="'+data[0].TruckId+'" selected="selected">'+data[0].TruckName+'</option>');
                $('#driver').prepend('<option value="'+data[0].DriverId+'" selected="selected">'+data[0].DriverName+'</option>');
                $('#assistant').prepend('<option value="'+data[0].assistantId+'" selected="selected">'+data[0].Assistant+'</option>');
                $('#dateCreateForControlSheet').val(data[0].DateCreated);
                $('#delvDateForControlSheet').val(data[0].DeliveryDate);
            }
        });
    }
    function truckControlSheetDetails(truckControlId)
    {
        $.ajax({
            url: '{!!url("/truckControlSheetDetails")!!}',
            type: "GET",
            data: {
                truckControlID: truckControlId
            },
            success: function (data) {
                var trHTML = '';
                // $('.onDrag').remove();
                $.each(data, function (key, value) {
                    trHTML += '<tr role="row" class="onDrag2"  style="font-size: 9px;color:black;height: 26px;"><td>' +
                        value.DeliveryDate + '</td><td>' +
                        value.Route + '</td><td>' +
                        value.StoreName + '</td><td>' +
                        value.InvoiceNo + '</td><td>' +
                        value.OrderId + '</td><td  style="font-weight:900">' +
                        value.OrderValue + '</td><td>' +
                        value.DeliverySequence + '</td><td>' +
                        '</tr>';
                });
                $('#sequenced').append(trHTML);
            }
        });
    }
    /**
     * Log data into tblManagementConsole
     * @param url
     * @param ConsoleTypeId
     * @param Importance
     * @param Message
     * @param Reviewed
     * @param OrderId
     * @param productid
     * @param CustomerId
     * @param OldQty
     * @param NewQty
     * @param OldPrice
     * @param NewPrice
     * @param ReferenceNo
     * @param DocType
     *  @param machine
     * @param DocNumber
     * @param ReturnId
     */
    function consoleManagement(url,ConsoleTypeId,Importance,Message,Reviewed,OrderId,productid,
                               CustomerId,OldQty,NewQty,OldPrice,NewPrice,ReferenceNo,DocType,machine,DocNumber,ReturnId)
    {
        $.ajax({
            url:url,
            type: "POST",
            data:{ConsoleTypeId:ConsoleTypeId,
                Importance:Importance,
                Message:Message,
                Reviewed:Reviewed,
                OrderId:OrderId,
                productid:productid,
                CustomerId:CustomerId,
                OldQty:OldQty,
                NewQty:NewQty,
                ReviewedUserId:0,
                OldPrice:OldPrice,
                NewPrice:NewPrice,
                ReferenceNo:ReferenceNo,
                DocType:DocType,
                DocNumber:DocNumber,
                machine:machine,
                ReturnId:ReturnId,

            },
            success: function(data){
                //dd(data);
                //Try to use web sql
            }});

    }
    function consoleManagementAuths(url,ConsoleTypeId,Importance,Message,Reviewed,OrderId,productid,
                                    CustomerId,OldQty,NewQty,OldPrice,NewPrice,ReferenceNo,DocType,machine,DocNumber,ReturnId,userId,userName)
    {
        $.ajax({
            url:url,
            type: "POST",
            data:{ConsoleTypeId:ConsoleTypeId,
                Importance:Importance,
                Message:Message,
                Reviewed:Reviewed,
                OrderId:OrderId,
                productid:productid,
                CustomerId:CustomerId,
                OldQty:OldQty,
                NewQty:NewQty,
                ReviewedUserId:0,
                OldPrice:OldPrice,
                NewPrice:NewPrice,
                ReferenceNo:ReferenceNo,
                DocType:DocType,
                DocNumber:DocNumber,
                machine:machine,
                ReturnId:ReturnId,
                userId:userId,
                userName:userName,

            },
            success: function(data){
                // dd(data);
                //Try to use web sql
            }});

    }


</script>

</x-app-layout>

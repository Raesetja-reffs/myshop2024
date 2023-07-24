@extends('layouts.app')

@section('content')

    <div class="col-lg-12" style="background: white;height: 520px;">
        <h5 style="text-align:center">Bulk Picking</h5>
        <div class="col-lg-6">
            <div class="col-lg-6" style="-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
            box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);background: mediumpurple;height: 500px;overflow-y: scroll;font-size: 10px !important">
                <h4>Choose Route(s)</h4>
                @foreach($routes as $value)
                    <label class="containercheckbox">{{$value->Route}}
                        <input type="checkbox" name="routeVal[]" class="routescheckd" value="{{$value->Routeid}}">
                        <span class="checkmark"></span>
                    </label>
                    @endforeach

            </div>
            <div class="col-lg-6" style="-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
            box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);height: 500px;background: mediumpurple;overflow-y: scroll;font-size: 12px !important">
                <h4>Choose Picking Team(s)</h4>
                @foreach($pickingteams as $value)
                    <label class="containercheckbox">{{$value->PickingTeam}}
                        <input type="checkbox" name="pickingteamsVal[]" value="{{$value->PickingTeamId}}">
                        <span class="checkmark"></span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="col-lg-6">
            <fieldset class="well">
                <legend class="well-legend">Parameters</legend>
                <div class="form-group col-md-6">
                    <label class="control-label" for="delvDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="delvDate" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">

                </div>
                <div class="form-group col-md-6">
                    <div class="form-group  col-md-6" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="inputOrderId"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Type</label>
                        <select class="form-control input-sm " id="orderType" style="height:26px;font-size: 10px;">
                            <option value="">Choose here</option>
                            <option value="-99">ALL</option>
                            @foreach($orderTypes as $value)
                            <option value="{{$value->OrderTypeId}}">{{$value->OrderType}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="button" id="createbulk" class="btn-xs btn-success pull-right">Create Bulk Picking Report</button>
                <button type="button" class="btn-md btn-primary  pull-left" id="pickingslipperteam">Print Picking Team Report</button>
            </fieldset>
            <div class="col-lg-12" style="-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
                    -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
                    box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);height: 300px;">
                <fieldset class="well">
                    <legend class="well-legend">Other Reports</legend>
                    <button type="button" class="btn-md btn-danger" id="individualbulk" >Print Individual Bulk Picking Slip</button>
                    <button type="button" class="btn-md btn-info" id="batchbulk">Print Bulk Picking Slip Batch</button>

                </fieldset>

            </div>
        </div>
    </div>
    <div id="popUpIndividualBulk" title="Individual Bulk Selection" style="    background: black;color:white;">
        <h4>Please choose below</h4>
        <div id="popUpIndividualBulkList" style="overflow-y: scroll">

        </div>
    </div>
    <div id="popUpBatchBulk" title="Batch Bulk Selection" style="    background: black;color:white;">
        <h4>Please choose below</h4>
        <div id="popUpBatchBulkList" style="overflow-y: scroll">

        </div>
    </div>
    @endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>

    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).keydown(function(e) {
        if (e.keyCode == 27) return false;
    });
    $(document).ready(function() {
        $("#delvDate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $('#popUpIndividualBulk').hide();
        $('#popUpBatchBulk').hide();
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#pricingOnCustomer').hide();
        $('#callList').hide();
        $('#tabletLoadingApp').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#salesInvoiced').hide();
        $('#posCashUp').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#createbulk').click(function(){

            if($('#orderType').val() == -99)
            {
                alert("Sorry you can only choose 1");
            }else {

            var searchIDs = $("input[name='routeVal[]']:checked").map(function(){
                return $(this).val();
            }).get(); // <----
             var PickingIDs = $("input[name='pickingteamsVal[]']:checked").map(function(){
                return $(this).val();
            }).get(); // <----
            console.log(searchIDs);
            $.ajax({
                url: '{!!url("/createBulkpicking")!!}',
                type: "POST",
                data: {
                    routes: searchIDs,
                    PickingIDs: PickingIDs,
                    orderType: $('#orderType').val(),
                    delvDate: $('#delvDate').val()
                },
                success: function (data) {

                    var dialog = $('<p><strong>Done Creating Picking Slip</strong></p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": function () {

                                dialog.dialog('close');

                            }
                        }
                    });
                }
            });
            }
        });
        $('#individualbulk').click(function(){
            $('#popUpIndividualBulk').show();
            showDialog('#popUpIndividualBulk',800,500);
            $.ajax({
                url: '{!!url("/selectBulkPickingHeader")!!}',
                type: "POST",

                success: function (data) {

                     var trHTML = '';
                     $('#popUpIndividualBulkList').empty();
                     var checkStatus = 0;
                     $.each(data, function (key, value) {
                       //  checkStatus = value.PrintedStatus;

                             trHTML += '<a href={!!url("/bulpickingPerRoutePreview")!!}/' + value.BulkPickingSlipId + ' style="color: white;"  target="_blank">' + value.Timestamp + ' : ' + value.Route + '- ' + value.orderTypeName + ' </a><br>';
                     });
                     $('#popUpIndividualBulkList').append(trHTML);
                }
            });
        });
        $('#batchbulk').click(function(){
            $('#popUpBatchBulk').show();
            showDialog('#popUpBatchBulk',800,500);
            $.ajax({
                url: '{!!url("/selectBulkBatchPickingHeader")!!}',
                type: "POST",

                success: function (data) {

                    var trHTML = '';
                     $('#popUpBatchBulkList').empty();
                     var checkStatus = 0;

                     $.each(data, function (key, value) {
                        checkStatus = value.PrintedStatus;

                        console.log("checkStatus**********"+checkStatus);
                         if (checkStatus ==1)
                         {
                             trHTML += '<a href={!!url("/bulpickingbyBatch")!!}/'+value.BulkPickingSlipId+' style="color: yellow;" target="_blank">'+value.Timestamp+' [PRINTER] </a><br>';
                         }
                         if (checkStatus ==2)
                         {
                             trHTML += '<a href={!!url("/bulpickingbyBatch")!!}/'+value.BulkPickingSlipId+' style="color: green;" target="_blank">'+value.Timestamp+' [PRINTED]</a><br>';
                         }
                         if (checkStatus ==0)
                         {
                             trHTML += '<a href={!!url("/bulpickingbyBatch")!!}/'+value.BulkPickingSlipId+' style="color: white;" target="_blank">'+value.Timestamp+' </a><br>';
                         }


                     });
                     $('#popUpBatchBulkList').append(trHTML);
                }
            });
            $('.bulkBatchlist').on('click',function(){
                alert('this is it');
                // $('#'+$priceToken).val($('#lastprice').val());

            });
        });

        $('#pickingslipperteam').click(function(){
            var PickingIDs = $("input[name='pickingteamsVal[]']:checked").map(function(){
                return $(this).val();
            }).get();
            var routeIDS = $("input[name='routeVal[]']:checked").map(function(){
                return $(this).val();
            }).get();
            if ($.trim($('#delvDate').val()).length  > 0 && $.trim($('#orderType').val()).length  > 0)
            {
                window.location = '{!!url("/pickingbyteam")!!}/' + PickingIDs + '/' + $('#delvDate').val() + '/' + $('#orderType').val() + '/' + routeIDS;
            }else
            {
                alert("Please Make sure ,you select Date,Route,Order Type and Picking Team");
            }
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
@extends('layouts.app')

@section('content')
    <div class="col-lg-12"  style="background: white;    font-family: 'Helvetica Neue', arial, sans-serif;">
        <h3 style="text-align: center;">Reprinting Invoices</h3>
        <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="deliveryDatesonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">From</label>
                                <input name="dateFrom" class="form-control input-sm col-xs-1" id="dateFrom">
                            </div>
                            <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="deliveryDatesonPlanning2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">To</label>
                                <input name="dateTo" class="form-control input-sm col-xs-1" id="dateTo">
                            </div>
        <div class="form-group  col-md-2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="orderTypesTabletLoadingonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Type</label>
                                <select name="orderTypesTabletLoadingonPlanning" class="form-control input-sm col-xs-1" id="orderTypesSelectBox" style="height:30px;font-size: 10px;">

                                    @foreach($orderTypes  as $values)
                                        <option value="{{$values->OrderTypeId}}">{{$values->OrderType}}</option>
                                    @endforeach
                                    <option value="-99">All</option>

                                </select>
                            </div>
                            <div class="form-group col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="rouTabletLoadingtesonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                                <select  id="rouTabletLoadingtesonPlanning" class="form-control input-sm col-xs-1"  >

                                    @foreach($routes as $values)
                                        <option value="{{$values->Routeid}}">{{$values->Route}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-lg-1">
                <button id="reprinting" class="btn-success btn-md center-block" style="margin-top: 20px;">Reprint</button>
            </div>
    </div>
    
  

@endsection

<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy  + '-' +mm  + '-' +dd ;
    console.debug(today);
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   
    $(document).ready(function() {
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#tabletLoadingApp').hide();
        $('#salesQuotebtn').hide();
        $('#afterFiltering').hide();
        //$('#doneSorting').hide();
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
        $('#confirmMove').hide();
        $("#creditOnHold").hide();

        $("#dateFrom,#dateTo").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $('#reprinting').click(function(){
            $.ajax({
                        url: '{!!url("/reprintPrintedInvoicesParameters")!!}',
                        type: "POST",
                        data: {
                            deldatestart:$('#dateFrom').val(),
                            deldateend:$('#dateTo').val(),
                            routeId:$('#rouTabletLoadingtesonPlanning').val(),
                            orderTypeId:$('#orderTypesSelectBox').val()
                        },
                        success: function (data) {

                            location.reload(true);

                        }
                    });
        });
      
    });
    function showDialogWithoutClose(tag,width,height)
    {
        $( tag ).dialog({height: height, modal: true,
            width: width,containment: false}).dialogExtend({
            "closable" : false, // enable/disable close button
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
        $('#authorisations').keydown(function(event) {
            if (event.keyCode == 27) {
                return false;
            }
        });


    }


</script>

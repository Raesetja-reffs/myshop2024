@extends('layouts.app')

@section('content')
    <div class="container" style="width: 100%;">
        <div class="row">

            <div class="col-lg-12  visible-md visible-lg" >
                <div id="callListDialog" title="Call List">
                    <div class="col-lg-12">
                        <form>
                            <div class="form-group col-md-3">
                                <label class="control-label" for="cashFloatDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">New Cash Float Date</label>
                                <input type="text" class="form-control input-sm col-xs-1" id="cashFloatDate" style="font-weight:900;font-size: 16px;color: black;">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label" for="cashFloatAmountOpening"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">New Float Amount</label>
                                <input type="text" class="form-control input-sm col-xs-1" onkeypress="return isFloatNumber(this,event)" id="cashFloatAmountOpening" style="font-weight:900;font-size: 16px;color: black;">
                            </div>
                            <div class="form-group col-md-3">
                                <button type="button" id="cashFloatButtonSubmit" class="btn-xs btn-success" style="background: deeppink;border-color: deeppink;">Done</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-10  visible-md visible-lg" style=" overflow-y: auto;width:50%;height:63%;background: #32cd32;">
                    <table class="table  search-table" id="cashFloatTable" style="color:black;font-size: 16px;font-weight: 700;font-family: sans-serif;">
                        <thead>
                        <tr style="font-size: 19px">
                            <th>Date</th><th>Float Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
    <div id="dialogUpDate" title="Update Cash Float">
        <div class="col-lg-12">
            <form>
                <div class="form-group col-md-3">
                    <label class="control-label" for="cashFloatDateDialog"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">New Cash Float Date</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="cashFloatDateDialog" style="font-weight:900;font-size: 16px;color: black;">
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label" for="cashFloatAmountOpeningDialog"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">New Float Amount</label>
                    <input type="text" class="form-control input-sm col-xs-1" onkeypress="return isFloatNumber(this,event)" id="cashFloatAmountOpeningDialog" style="font-weight:900;font-size: 16px;color: black;">
                </div>
                <div class="form-group col-md-3">
                    <button type="button" id="cashFloatButtonSubmitDialog" class="btn-xs btn-success" style="background: deeppink;border-color: deeppink;">Done</button>
                </div>
            </form>
        </div>
    </div>

@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>

var cashFloat = ''
    $(document).ready(function() {
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#tabletLoadingApp').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#pricingOnCustomer').hide();
        $('#posCashUp').show();
        $('#dialogUpDate').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#cashFloatDate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat:"dd-mm-yy"

        });
        cashFloat = $('#cashFloatTable').DataTable( {
            "ajax": {url:'{!!url("/posCashFloat")!!}',"type": "POST",
                data:function(data) {

                }
            },
            "columns": [
                { "data": "CashFloatDate","class":"small","bSortable": true },
                { "data": "CashFloatAmount","class":"small"}
                ],
            "deferRender": true,
            "scrollY": "365px",
            "scrollCollapse": true,
            searching: true,
            bPaginate: false,
            bFilter: false,
            "LengthChange": false,
            "info":     false,
            "bDestroy": true
        });

        $('#cashFloatButtonSubmit').click(function(){
            $.ajax({
                url: '{!!url("/postPOSfloat")!!}',
                type: "POST",
                data: {floatDate: $('#cashFloatDate').val(),floatAmount: $('#cashFloatAmountOpening').val()},
                success: function (data) {
                    if ( data === 'Inserted')
                    {
                        console.debug(data);
                        location.reload(true);
                    }
                    else {
                        $('#dialogUpDate').show();
                        showDialog('#dialogUpDate',800,286);
                        $('#cashFloatDateDialog').val(data.floatDate);
                        $('#cashFloatAmountOpeningDialog').val(data.floatAmount);
                    }
                }
            });
        });
        $('#cashFloatTable').on('dblclick', 'tbody tr', function () {
            var $this = $(this);
            var row = $this.closest("tr");
            var floatDateDelete = row.find('td:eq(0)').text();
            var dialog = $('<p><strong style="color:red">Are you sure you want to Delete this Line</strong></p>').dialog({
                height: 200, width: 700,modal: true,containment: false,
                buttons: {
                    "Yes": function () {
                        $.ajax({
                            url: '{!!url("/deletePOSfloat")!!}',
                            type: "POST",
                            data: {
                                floatDate: floatDateDelete,

                            },
                            success: function (dataDelete) {
                                location.reload(true);
                            }
                        });
                    }
                }
            });
        });
        $('#posCashUp').click(function(){

        });
    });

function isFloatNumber(item,evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode==46)
    {
        var regex = new RegExp(/\./g)
        var count = $(item).val().match(regex).length;
        if (count > 1)
        {
            return false;
        }
    }
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
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
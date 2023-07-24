@extends('layouts.app')

@section('content')
    <div class="col-lg-12 ">
        <form>
            <div class="form-group col-md-12">
            <label class="control-label" for="from"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">FROM</label>
            <input class="form-control  " name="from" id="from" style="color:black;font-weight:900;height:30px;font-size: 10px;" value="{{$today}}" autocomplete="off">


            <label class="control-label" for="to"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">TO</label>
            <input class="form-control  " name="to" id="to" style="color:black;font-weight:900;height:30px;font-size: 10px;" value="{{$today}}" autocomplete="off">
    </div>
        </form>
        <button class="btn-success" id="list">Get</button>
    </div>
    <div class="col-lg-12" style="">
        <table class="table2 table-bordered  search-table" id="listOfdamages" style="overflow-y: auto;width:100%;color: black;    font-weight: 700;">
            <thead>
            <tr>
                <th class="col-sm-2">ID</th>
                <th class="col-sm-1">CustomerCode</th>
                <th class="col-sm-3">CustomerStoreName</th>
                <th class="col-sm-1">Date Created</th>
                <th class="col-sm-1">Reference NO</th>
                <th class="col-sm-1">Notes</th>
                <th class="col-sm-1">UserName</th>
                <th class="col-sm-1">Number Of Items</th>

            </tr>
            </thead>

        </table>
    </div>
    <div class="col-lg-12" id="popUpHistoryLines" tite="Lines" style="background: darkgoldenrod;height:65%;    overflow-y: scroll;">
        <h5 id="storeName"></h5>
        <table class="table search-table" id="damagesLines"  style=" color: black;overflow-y: scroll; width: 100%;font-family: sans-serif;font-weight: 700;" >
            <thead>

            <tr>
                <th class="col-sm-1">Product Code</th>
                <th class="col-md-3">Product Desc</th>
                <th class="col-md-2">Quantity To Uplift</th>
                <th></th>
            </tr>
            </thead>
            <tbody></tbody>

        </table>
    </div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#from,#to").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });

        $('#popUpHistoryLines').hide();$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var otable = '';

            $('#list').click(function () {
                otable = $('#listOfdamages').DataTable({
                    "ajax": {
                        url: '{!!url("/getDamagesHistoryHeader")!!}', "type": "POST", data: function (data) {
                            data.from = $('#from').val();
                            data.to = $('#to').val();
                        }
                    },
                    "processing": false,
                    "serverSide": false,
                    "stateSave": false,
                    "columns": [
                        {"data": "ID", "class": "small"},
                        {"data": "CustomerCode", "class": "small"},
                        {"data": "CustomerStoreName", "class": "small"},
                        {"data": "OrderDate", "class": "small", "bSortable": true},
                        {"data": "OrderNumber", "class": "small"},
                        {"data": "Notes", "class": "small"},
                        {"data": "UserName", "class": "small"},
                        {"data": "lines", "class": "small"}

                    ],
                    "deferRender": true,
                    "scrollY": "405px",
                    "scrollCollapse": true,
                    searching: true,
                    bPaginate: false,
                    bFilter: false,
                    "LengthChange": false,
                    "info": false,
                    "ordering": true,
                    "bDestroy": true
                });
                $('#listOfdamages tbody').on('dblclick', 'tr', function () {

                    var data = otable.row(this).data();
                    $('#storeName').empty();
                    $('#storeName').append(data.CustomerStoreName);
                    console.debug(data.ID);
                    var IdPrint = data.ID;
                    IdPrint = IdPrint.trim();
                    $('#popUpHistoryLines').show();
                    showDialog('#popUpHistoryLines','85%',400);
                    $.ajax({
                        url: '{!!url("/getDamgedLines")!!}',
                        type: "POST",
                        data: {
                            ID: data.ID
                        },
                        success: function (data) {
                            var trHTML = '';
                            $('.invoiceslistedHeaderPopUp').empty();
                            trHTML +="<tr role='row' class='invoiceslistedHeaderPopUp'  style='font-size: 11px;color:black'><td></td><td></td> <td><a href='{!!url("/print_damages")!!}/'"+IdPrint+ " class='btnPrint' style='background:white;color:black;padding: 1px;font-weight: 900;'>Print</a>"+' </td>';
                            $.each(data, function (key, value) {
                                trHTML +='<tr role="row" class="invoiceslistedHeaderPopUp"  style="font-size: 11px;color:black"><td>'+
                                    value.strPartNumber +'</td><td>'+
                                    value.strDesc +'</td><td>' +
                                    parseFloat(value.Quantity).toFixed(2) +'</td><td>' +
                                    '</tr>';
                            });
                            $('#damagesLines').append(trHTML);
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

    });
</script>
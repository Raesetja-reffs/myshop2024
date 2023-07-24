@extends('layouts.app')

@section('content')

        <div class="col-md-12 ">
            <div class="col-md-4">

            </div>
            <div class="col-md-4 pull-right">
                <a href='{!!url("/damageshistory")!!}' onclick="window.open(this.href, 'mywin',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >See History</a>
            </div>
        </div>

    <div class="col-lg-12"  style="height:35%;overflow-y: scroll;">
        <table class="table" id="tblDamagesHeader" style="font-size:12px;  color: black;overflow-y: scroll; width: 100%;font-family: sans-serif;" >
            <thead>

            <tr>
                <th class="col-sm-2">ID</th>
                <th class="col-sm-1">CustomerCode</th>
                <th class="col-sm-3">CustomerStoreName</th>
                <th class="col-sm-1">Date Created</th>
                <th class="col-sm-1">Date to Uplift</th>
                <th class="col-sm-1">Reference NO</th>
                <th class="col-sm-1">Notes</th>
                <th class="col-sm-1">UserName</th>
                <th class="col-sm-1">Action1 </th>
                <th class="col-sm-1">Action2 </th>
                <th class="col-sm-1">Action3 </th>

            </tr>
            </thead>
            <tbody>
            @foreach($damages as $value)
                <tr>
                    <td class="col-sm-1">{{$value->ID}}<input type="hidden" class="_id" value="{{$value->ID}}"></td>
                    <td class="col-sm-1">{{$value->CustomerCode}}</td>
                    <td>{{$value->CustomerStoreName}}</td>
                    <td>{{$value->OrderDate}}</td>
                    <td>{{$value->DeliveryDate}}</td>
                    <td class="col-sm-1">{{$value->OrderNumber}}</td>
                    <td>{{$value->Notes}}</td>
                    <td class="col-sm-1">{{$value->UserName}}</td>
                    <td  class="col-sm-1"><button class="btn-info btn-md">View</button></td>
                    <td  class="col-md-2"><a href='{!!url("/print_damages")!!}/{{$value->ID}}' class="btnPrint">Print</a></td>
                    <td  class="col-md-2"><a href='{!!url("/process_damage")!!}/{{$value->ID}}'>Process</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-lg-12" style="background: darkgoldenrod;height:45%;    overflow-y: scroll;">
        <table class="table" id="damagesLines"  style=" color: black;overflow-y: scroll; width: 100%;font-family: sans-serif;font-weight: 700;" >
            <thead>

            <tr>
                <th class="col-sm-1">Product Code</th>
                <th class="col-md-3">Product Desc</th>
                <th class="col-md-2">Quantity To Uplift</th>
                <th class="col-md-2"></th>
                <th class="col-md-2"><input type="hidden" class="hiddenQuant"></th>
                <th></th>
            </tr>
            </thead>


        </table>
    </div>
    <div class="col-lg-12" title="Edit Screen" id="popUpEditScreen">
        <input name="newValue" id="newValue" value="">
        <input name="productCode" id="productCode" value="">
        <input type="hidden" name="ID" id="ID" value="">
        <button class="btn-primary  btn-md">Done</button>
    </div>

@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $("#delvDate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#popUpEditScreen').hide();
        $('#tblDamagesHeader').on('click', 'button', function (e) {
            var $this = $(this);

            var row_closestTrColumns = $this.closest('tr');
            var prodCode1 = row_closestTrColumns.find('._id').val();

            $.ajax({
                url: '{!!url("/getDamgedLines")!!}',
                type: "POST",
                data: {
                    ID: prodCode1
                },
                success: function (data) {
                    var trHTML = '';
                    $('.invoiceslistedHeader').empty();
                    $.each(data, function (key, value) {
                        trHTML +='<tr role="row"  id="new_row_ajax'+value.strPartNumber+value.ID+'" class="invoiceslistedHeader"  style="font-size: 11px;color:black"><td>'+
                            value.strPartNumber +'</td><td>'+
                            value.strDesc +'</td><td>' +
                            parseFloat(value.Quantity).toFixed(2) +'<input type="hidden" class="hiddenCode" value="'+value.strPartNumber+'"><input type="hidden" class="hiddenID" value="'+value.ID+'"></td><td>' +
                            '<td><button class="btn-danger btn-md" >Remove</button></td></tr>';
                    });
                    $('#damagesLines').append(trHTML);
                }
            });


        });
        $('#damagesLines').on('click', 'button', function (e) {
            var $this = $(this);

            var row_closestTrColumns = $this.closest('tr');
            var prodCode1 = row_closestTrColumns.find('.hiddenCode').val();
            var id = row_closestTrColumns.find('.hiddenID').val();
            $.ajax({
                url: '{!!url("/deleteDamagedLine")!!}',
                type: "POST",
                data: {
                    ID: id,
                    prodCode: prodCode1
                },
                success: function (data) {
                    $('#new_row_ajax'+prodCode1+id).remove();
                }
            });
            alert(prodCode1);
        });
        $('.btnPrint').printPage();
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

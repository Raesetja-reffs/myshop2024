@extends('layouts.app')

@section('content')
    <div class="col-lg-12"  style="text-align: center;    background: white;    height: 68px;" > <h4>Visits</h4></div>
    <div class="col-lg-12"  style="    background: white;    height: 68px;" >


        <div class="col-lg-6 ">

            <div  class="col-lg-2" ><a href='{!!url("/viewVisits")!!}' style="background: darkgreen;color: white;    font-size: 21px;">Visits</a> </div>
            <div  class="col-lg-2" ><a href='{!!url("/viewDeals")!!}' style="background: darkgreen;color: white;    font-size: 21px;">Deals</a> </div>
        </div>
        <div class="col-lg-6 ">
            <div  class="col-lg-2" >Date From<input  class="form-control input-sm col-xs-2" id="dateFrom" placeholder="Start Date" style="font-weight: 900;" value="" ></div>
            <div  class="col-lg-2" >Date To<input  class="form-control input-sm col-xs-2" id="dateTo" placeholder="End Date" style="font-weight: 900;"></div>
            <div  class="col-lg-2" >  <button type="button" id="datefilter" class="btn-md btn-success">Filter</button></div>
            <div  class="col-lg-4" ><a href='{!!url("/missedvisit")!!}' style="background: #f30303;color: white;    font-size: 21px;">Missed Visits</a> </div>

        </div>
    </div>
    <div class="col-lg-12"  style="height:80%;overflow-y: scroll;">

        <table id="visits" class="table2 table-bordered  search-table" id="visits" style="  font-weight: 700;  color: black;overflow-y: scroll; width: 100%;font-family: sans-serif;" >
            <thead>

            <tr>
                <th class="col-sm-2">Coordinates</th>
                <th class="col-sm-1">Code</th>
                <th class="col-sm-3">Store Name</th>
                <th class="col-sm-1">Date Created</th>
                <th class="col-sm-1">Token</th>
                <th class="col-sm-1">User Name (Rep)</th>
                <th class="col-sm-1">Signature</th>

            </tr>
            </thead>
            <tbody>
            @foreach($visits as $value)
                <?php
                $imagestring = $value->strImageString;
                $data = "$imagestring";
                ?>
                <tr>
                    <td class="col-sm-1">{{$value->fltLat}}.",".{{$value->fltLon}}</td>
                    <td class="col-sm-1">{{$value->strCustCode}}</td>
                    <td>{{$value->strCustomerName}}</td>
                    <td>{{$value->dteCreated}}</td>
                    <td>{{$value->strTabletID}}</td>
                    <td class="col-sm-1">{{$value->UserName}}</td>
                    <td><?php echo '<img style="height: 50;" src="data:image/gif;base64,' . $data . '" />'; ?></td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
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
        $('#editTrucks').hide();
        $('#salesInvoiced').hide();
        $('#visits').DataTable( {
            dom: 'Bfrtip',
            "pageLength": 150,
            scrollY:        650,
            scrollCollapse: true,
            scroller:       true,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        } );
        $("#dateFrom").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $("#dateTo").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#datefilter').click(function() {
            window.location = '{!!url("/visitsdates")!!}/' + $('#dateFrom').val() + '/' + $('#dateTo').val()

        });
        $('#visits tbody').on('click', 'tr', function (e){
            $("#visits tbody tr").removeClass('row_selectedYellowish');
            $(this).addClass('row_selectedYellowish');
        });
      //  $('.btnPrint').printPage();
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

@extends('layouts.app')

@section('content')
    <div class="col-lg-12"  style="text-align: center;    background: white;    height: 68px;" > <h4>Missed Visits</h4></div>
    <div class="col-lg-12"  style="    background: white;    height: 68px;" >


        <div class="col-lg-6 ">

            <div  class="col-lg-2" ><a href='{!!url("/viewVisits")!!}' style="background: darkgreen;color: white;    font-size: 21px;">Visits</a> </div>
            <div  class="col-lg-2" ><a href='{!!url("/viewDeals")!!}' style="background: darkgreen;color: white;    font-size: 21px;">Deals</a> </div>

        </div>
        <div class="col-lg-6 ">
            <div  class="col-lg-4" ><a href='{!!url("/missedvisit")!!}' style="background: #f30303;color: white;    font-size: 21px;">Missed Visits</a> </div>

        </div>
    </div>
    <div class="col-lg-12"  style="height:80%;overflow-y: scroll;">

        <table id="missed_visits" class="table2 table-bordered  search-table" id="visits" style="  font-weight: 700;  color: black;overflow-y: scroll; width: 100%;font-family: sans-serif;" >
            <thead>

            <tr>
                <th class="col-sm-2">Code</th>
                <th class="col-sm-1">Store Name</th>
                <th class="col-sm-3">Address</th>
                <th class="col-sm-1">Last Visit</th>
                <th class="col-sm-1">Next Visit</th>
                <th class="col-sm-1">Margin</th>
                <th class="col-sm-1">Rep Code</th>
                <th class="col-sm-1">Rep Name</th>

            </tr>
            </thead>
            <tbody>
            @foreach($missedvisit as $value)

                <tr>
                    <td class="col-sm-1">{{$value->CustomerCode}}</td>
                    <td class="col-sm-1">{{$value->CustomerStoreName}}</td>
                    <td>{{$value->addresses}}</td>
                    <td>{{$value->dteLastVisit}}</td>
                    <td>{{$value->dteNextVisit}}</td>
                    <td>{{$value->margin}}</td>
                    <td>{{$value->CustomerRepresentitiveID}}</td>
                    <td>{{$value->UserName}}</td>


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
        $('#missed_visits').DataTable( {
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#missed_visits tbody').on('click', 'tr', function (e){
            $("#missed_visits tbody tr").removeClass('row_selectedYellowish');
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

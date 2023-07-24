@extends('layouts.app')

@section('content')

    <div class="col-lg-12"  style="text-align: center;display: none;">
        <div class="col-lg-6">

        </div>
        <div class="col-lg-6">
            <div  class="col-lg-5" >Customer Code<input  class="form-control input-sm " id="inputCustAcc" style="font-weight: 900;" value="" ></div>
            <div  class="col-lg-5" >Customer Name<input  class="form-control input-sm " id="inputCustAccName" style="font-weight: 900;"></div>
            <div  class="col-lg-2" >  <button type="button" id="datefilter" class="btn-md btn-success">Filter</button></div>
        </div>
    </div>
    <button class=" btn btn-success fa fa-plus-circle" type="submit" id="addupdate" >ADD NEW ASSET</button>


    <div class="col-lg-12"  style="height:90%;overflow-y: scroll;">


        <table id="missed_visits" class="table2 table-bordered  search-table" id="visits" style="  font-weight: 700;  color: black;overflow-y: scroll; width: 100%;font-family: sans-serif;" >
            <thead>

            <tr>
                <th >ID</th>
                <th>Customer Code</th>
                <th >Customer Name</th>
                <th >Asset Number</th>
                <th>Quantity</th>
                <th>Base</th>
                <th>Area</th>
                <th>Make</th>
                <th>Description</th>
                <th>Branding</th>
                <th >Model</th>
                <th>Last Visit</th>
                <th>Contacts</th>
                <th>History</th>

            </tr>
            </thead>
            <tbody>
            @foreach($assets as $value)

                <tr>
                    <td >{{$value->ID}}</td>
                    <td>{{$value->strCustomerCode}}</td>
                    <td >{{$value->strCustomerName}}</td>
                    <td>{{$value->strAssetName}}</td>
                    <td>{{$value->strAssetQty}}</td>
                    <td>{{$value->strBase}}</td>
                    <td>{{$value->strAssetArea}}</td>
                    <td>{{$value->strAssetMake}}</td>
                    <td>{{$value->strAssetDescription}}</td>
                    <td>{{$value->strAssetBranding}}</td>
                    <td>{{$value->strAssetModel}}</td>
                    <td>{{$value->dteLastVisit}}</td>
                    <td>{{$value->strAssetAreaTelephone}} <br>  {{$value->strAssetCellContacts}} <br> {{$value->strAssetsHoldersContactPeople}}</td>
                    <td>{{$value->strAssetHistory}}</td>

                </tr>
            @endforeach
            </tbody>

        </table> <button class=" btn btn-primary" type="submit" id="discrapancy" >Discrepancies</button>
    </div>



@endsection

<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});

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
            scrollY:        420,
            scrollCollapse: true,
            scroller:       true,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        } );

        var finalData =$.map(JSON.parse(jArrayCustomer), function(item) {

            return {

                CustomerName:item.strCustomerName,
                CustomerCode:item.strCustomerCode,

            }

        });


        var inputCustAccount = $('#inputCustAcc').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerCode","CustomerName"],
            searchIn: 'CustomerCode',
            data: finalData
        });
        var inputCustAccName = $('#inputCustAccName').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerCode","CustomerName"],
            searchIn: 'CustomerName',
            data: finalData
        });
        inputCustAccount.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerCode);
            $('#inputCustAccName').val(data.CustomerName);

        });
        inputCustAccName.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerCode);
            $('#inputCustAccName').val(data.CustomerName);

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#addupdate").click(function () {
        //do here
            var r = Math.random().toString(36).slice(-5);
            window.open('{!!url("/crudasset")!!}/xxxx', "random"+r, "location=1,status=1,scrollbars=1, width=1500,height=1000");
        });

        $('#missed_visits tbody').on('click', 'tr', function (e){
            $("#missed_visits tbody tr").removeClass('row_selectedYellowish');
            $(this).addClass('row_selectedYellowish');

        });
        $('#missed_visits tbody').on('dblclick', 'tr', function (e){
            $("#missed_visits tbody tr").removeClass('row_selectedYellowish');
            var r = Math.random().toString(36).slice(-5);
            var id = $(this).closest('tr').find('td:eq(0)').text();
            window.open('{!!url("/crudasset")!!}/'+id, "random"+r, "location=1,status=1,scrollbars=1, width=1500,height=1000");
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

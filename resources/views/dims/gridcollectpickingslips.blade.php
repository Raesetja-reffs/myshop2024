@extends('layouts.app')

@section('content')
    <div class="container" style="width: 100%">
        <div id="grid" class="col-md-12">
            <button id="savechanges" class="btn-success btn-lg">SAVE CHANGES</button>

        <table class="table table-bordered table-condensed" id="gridcollection" style="font-size: 22px;">
            <tr>
                <th>OrderId</th>
                <th>Route</th>
                <th>Print</th>
                <th>StoreName</th>
                <th>DeliveryDate</th>
                <th>OrderId</th>
                <th>Check</th>
            </tr>
            @foreach($pickingslips as $values)
                <tr>
                 <td>{{$values->OrderId}}</td>
                 <td>{{$values->Route}}</td>
                 <td><button  class="reprint btn-primary" value="{{$values->OrderId}}">Print-Again</button></td>
                 <td style="font-size:13px">{{$values->StoreName}}</td>
                 <td>{{$values->DeliveryDate}}</td>
                    <td>{{$values->OrderId}}</td>
                <td><input type="checkbox" name="caseProd[]" value="{{$values->OrderId}}" style="height: 37px !important;" ></td>
                </tr>
            @endforeach
        </table>
    </div>
    </div>

@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

<script>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       $('#savechanges').click(function(){
           var valuesProd = new Array();
           $.each($("input[name='caseProd[]']:checked"),
               function () {
                   var data = $(this).parents('tr:eq(0)');
                   valuesProd.push({ 'orderId':$(data).find('td:eq(0)').text()});
               });
           $.ajax({
               url: '{!!url("/updateiscollected")!!}',
               type: "POST",
               data: {orderId:valuesProd},
               success: function (data) {
alert("Picked Orders");
location.reload(true);
               }
           });
       });
       $('.reprint').click(function(){

           $.ajax({
               url: '{!!url("/reprintPickingSlip")!!}',
               type: "POST",
               data: {reprintorderId:$(this).val()},
               success: function (data) {
                   alert("Reprint Orders");
                   location.reload(true);
               }
           });
       });
    });
</script>
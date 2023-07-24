@extends('layouts.app')

@section('content')

    <div class="col-lg-12"  style="background: white;">
        <a href='{!!url("/createtripsheet")!!}' class="btn-danger btn-md pull-right" style="padding: 14px;">Create Trip Sheet</a>
        <a href='{!!url("/outstandingDriversCashoff")!!}' class="btn-danger btn-md pull-right" style="padding: 14px;">Outstanding Drivers Cashoff</a>
        <div class="form-group col-md-3 "  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="deliveryDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
            <input type="text" class="form-control input-sm col-xs-1" id="deliveryDate" value="{{$date}}" style="font-weight: 900;    color: black;font-size: 13px;">
        </div>
        <div class="form-group col-md-3 "  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="submit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">.</label>
            <button class="form-control btn-md btn-success" id="submit">GO</button>
        </div>
    </div>
    <div class="col-lg-12"  style="background: white;">
        <table class="table" id="tripSheetList" style="width:100%">
            <thead>
            <tr>
                <th>Routing ID</th>
                <th>Route Name</th>
                <th>Order Type</th>
                <th>Driver</th>
                <th>Truck</th>
                <th>Mass</th>
                <th>Exported</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
@endsection
<style>
    .backgroundexported{
        background:#fd00ff8a;
        font-weight:900;
    }
</style>

<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

<script>
    $(document).ready(function() {
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
        $("#deliveryDate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $('#submit').click(function(){
            $.ajax({
                url: '{!!url("/getDayTripSheetList")!!}',
                type: "POST",
                data: {

                    deliveryDate: $('#deliveryDate').val()
                },
                success: function (data) {
                    var trHTML = '';
                    var style = '';
                    $('.onDrag').remove();
                    var classes = 'onDrag';

                    $.each(data, function (key, value) {
                        if (value.Exported ==1)
                        {
                            classes = 'onDrag backgroundexported';
                        }else{
                            classes = 'onDrag';
                        }
                        trHTML += '<tr role="row" class="'+classes+'" style="height: 26px !important;font: Arial"  >' +
                            '<td style="height: 26px ;font-size:10px;color:black;">' +
                            value.DeliveryDateRoutingID + '</td><td style="height: 26px ;font-size:15px;color:black;">' +
                            value.Route + '</td><td style="background:yellow">' +

                            value.OrderType + '</td><td style="height: 26px ;font-size:10px;color:black;">' +
                            value.DriverName + '</td><td style="height: 26px ;font-size:10px;color:black;">' +
                            value.TruckName + '</td><td style="height: 26px ;font-size:20px;color:black;">'+
                            value.TruckName + '</td><td style="height: 26px ;font-size:20px;color:black;">'+
                            value.Exported + '</td>' +
                            '</tr>';
                    });
                    $('#tripSheetList tbody').append(trHTML);
                }
            });
        });

        $('#tripSheetList').on('dblclick', 'tbody tr', function () {

            var $this = $(this);
            var row = $this.closest("tr");
            var routingId = row.find('td:eq(0)').text();
            console.debug("**********"+routingId);
            window.open('{!!url("/getTripSheetDetails")!!}/'+routingId, "tripSheetDetails", "width=760, height=500, scrollbars=yes");
        });

    });
</script>
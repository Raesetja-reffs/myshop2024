@extends('layouts.app')

@section('content')

    <div class="col-lg-12"  style="background: white;">
        <div class="form-group col-md-3 "  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
        </div>
        <div class="form-group col-md-3 "  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="submit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">.</label>
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
                    <th>Delivery Date</th>
                </tr>
            </thead>
            <tbody>
            @foreach($outstandingtripsheets as $val)
            <tr>
            <td>{{ $val->DeliveryDateRoutingID}}</td>
            <td>{{ $val->Route}}</td>
            <td>{{ $val->OrderType}}</td>
            <td>{{ $val->DriverName}}</td>
            <td>{{ $val->TruckName}}</td>
            <td>{{ $val->DeliveryDate}}</td>
            </tr>

            @endforeach
            </tbody>
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

        $('#tripSheetList').on('dblclick', 'tbody tr', function () {

                var $this = $(this);
                var row = $this.closest("tr");
                var routingId = row.find('td:eq(0)').text();
                console.debug("**********"+routingId);
                window.open('{!!url("/getTripSheetDetails")!!}/'+routingId, "tripSheetDetails", "width=760, height=500, scrollbars=yes");
            });

    });
</script>
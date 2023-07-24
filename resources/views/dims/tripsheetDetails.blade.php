@extends('layouts.app')

@section('content')
    <div class="col-lg-12"  style="background: white;">
    @if (Auth::user()->bitAllowedToSeeTruckLogs == "1")
        <a href='{!!url("/LoadLogs")!!}/{{$routingId}}' style="color:white;font-weight: 900;font-size: 17px;padding:5px;background: green">Load Logs</a>
                @endif
        
        <a href='{!!url("/reprintTripSheet")!!}/{{$routingId}}' style="color:white;font-weight: 900;font-size: 17px;padding:5px;background: green">PrintThis</a>
        <table class="table"  id="tripSheetList" style="width:100%">
            <thead>
            <tr>
                <th>Delivery Sequence</th>
                <th>Store Name</th>
                <th>Invoice No</th>
                <th>Inv Value</th>
                <th>Payment Terms</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tripsheetDetails as $values)
                <tr>
                    <td>{{$values->DeliverySequence}}</td>
                    <td>{{$values->DeliveryName}}</td>
                    <td>{{$values->InvoiceNo}}</td>
                    <td>{{number_format((float)$values->AccessTotal, 2, ',', ' ')}}</td>
                    <td>{{$values->strPaymentTerm}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection
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
    });
</script>
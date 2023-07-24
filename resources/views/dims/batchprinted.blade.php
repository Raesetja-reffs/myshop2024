@extends('layouts.app')

@section('content')
    <div class="col-lg-12" style="background: white;font-weight: 900;padding: 0px 126px 3px 129px">
        <h1>BATCH SENT TO PRINTER</h1>
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
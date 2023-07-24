@extends('layouts.app')

@section('content')
    <div class="col-lg-12" >
        <a href='{!!url("/showTripSheets")!!}' class="btn-danger btn-md pull-right" style="padding: 14px;">Load Other Trip sheets</a>
    </div>
    <h3>Create Trip Sheet</h3>
    <div class="col-lg-6"  style="background: white;">
        <label class="control-label" for="deliverydate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
        <input type="text" class="form-control input-sm " id="deliverydate" style="font-family: sans-serif;font-weight: 900;">

        <label class="control-label" for="route"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route Name</label>
        <select class="form-control input-sm " id="route" style="font-family: sans-serif;font-weight: 900;">
            @foreach($route as $val)
            <option value="{{$val->Routeid}}">{{$val->Route}}</option>
            @endforeach
        </select>
        <label class="control-label" for="ordertype"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Type</label>
        <select class="form-control input-sm " id="ordertype" style="font-family: sans-serif;font-weight: 900;">
            @foreach($ordertype as $val)
            <option option="{{$val->OrderType}}">{{$val->OrderType}}</option>
            @endforeach
        </select>
        <label class="control-label" for="DriverName"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Driver Name</label>
        <select class="form-control input-sm " id="DriverName" style="font-family: sans-serif;font-weight: 900;">
            @foreach($drivers as $val)
            <option option="{{$val->DriverName}}">{{$val->DriverName}}</option>
            @endforeach
        </select>
        <label class="control-label" for="assistant"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Assistant</label>
        <select class="form-control input-sm " id="assistant" style="font-family: sans-serif;font-weight: 900;">
            @foreach($drivers as $val)
            <option option="{{$val->DriverName}}">{{$val->DriverName}}</option>
            @endforeach
        </select>

        <label class="control-label" for="truck"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Truck</label>
        <select class="form-control input-sm " id="truck" style="font-family: sans-serif;font-weight: 900;">
            @foreach($trucks as $val)
            <option option="{{$val->TruckName}}">{{$val->TruckName}}</option>
            @endforeach
        </select>
        <button class="btn-md btn-success" id="submit">Submit</button>

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

        $("#deliverydate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat:"yy-mm-dd"
        });
        $('#submit').click(function(){
            window.location = 'http://192.168.0.11:8888/AdcanCodeigniter/index.php/welcome/getData/'+$('#deliverydate').val()+'/'+$('#ordertype').val()+'/'+$('#route').val()+'/'+$('#DriverName').val()+'/'+$('#assistant').val()+'/'+$('#truck').val();

        });
        //
    });
</script>
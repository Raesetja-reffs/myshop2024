@extends('layouts.app')

@section('content')
    <div class="col-lg-12" >

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
                <option value="{{$val->OrderTypeId}}">{{$val->OrderType}}</option>
            @endforeach
        </select>
        <button class="btn-md btn-success" id="get">GET</button>
        <div id="notediv">
        <label  class="control-label">Notes</label><br>
        <textarea class="form-control" rows="20"  id="routenote" style="font-weight: 900;color: black;">

        </textarea>
            <button class="btn-md btn-success" id="submit">Submit</button>
        </div>

    </div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

<script>
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
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
        $('#notediv').hide();

        $("#deliverydate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat:"yy-mm-dd"
        });
        $('#submit').click(function(){
            $.ajax({
                url: '{!!url("/saveRoutingIdNotes")!!}',
                type: "POST",
                data: {

                    deliveryDate: $('#deliverydate').val(),
                    routeid: $('#route').val(),
                    ordertypeid: $('#ordertype').val(),
                    note:$('#routenote').val()
                },
                success: function (data) {
                    console.debug(data);
                    //$('#routenote').val(data[0].strRouteNote);

                }
            });

        });

        $('#get').click(function(){
            $('#notediv').show();

            $.ajax({
                url: '{!!url("/getRoutingIdNotes")!!}',
                type: "POST",
                data: {

                    deliveryDate: $('#deliverydate').val(),
                    routeid: $('#route').val(),
                    ordertypeid: $('#ordertype').val()
                },
                success: function (data) {

                    $('#routenote').val(data[0].strRouteNote);

                }
            });

        });
        //
    });
</script>
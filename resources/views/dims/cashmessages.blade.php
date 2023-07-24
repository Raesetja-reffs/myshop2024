@extends('layouts.app')

@section('content')

    <div class="container" style="width: 100%;font-family: sans-serif">

        <div class="row">
            <div class="col-lg-12 ">
                <h2>{{$invoicenumber}}</h2>

            @foreach($invoiceinfo as $val)
                <h5>{{$val->checkedagainstpall}}</h5>
                <h5>{{$val->podpalladium}}</h5>
                <h5>{{$val->cashdealtwithit}}</h5>

                <div class="form-group col-md-12"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="notes"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Notes</label>
                    <input type="hidden" id="orderid" value="{{$val->OrderId}}">
                    <textarea id="notes" class="form-control input-sm col-xs-1" rows="4" >{{$val->strCashUpMessages}}</textarea>

                </div>
                @if($val->cashdealtwithit =="Not Dealt With It")
                        <div class="form-group col-md-12"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                          <input id="sorted" type="checkbox">Checked Cash
                        </div>

                @else
                        <div class="form-group col-md-12"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                            <input id="sorted" type="checkbox" checked disabled>Checked Cash
                        </div>
                    @endif
            @endforeach
                <button id="save" class="btn-success btn-lg">SAVE</button>

            </div>
        </div>
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
            $('#afterFilter').hide();
            $('#popUpdateLine').hide();
            $('#updatedspecials').hide();
            $('#extend').hide();
            $('#extedingspecial').hide();
            $('#deleteSelected').hide();
            $('#deleteSelected').hide();

            $('#save').click(function () {


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var sorted = 0;
                if($("#sorted").is(':checked')){
                    // Code in the case checkbox is checked.
                    sorted = 1;
                } else {
                    // Code in the case checkbox is NOT checked.
                    sorted = 0;
                }

                $.ajax({
                    url: '{!!url("/postcashupscheckinvoice")!!}' ,
                    type: "POST",
                    data:{
                        invoiceMessage:$('#notes').val(),
                        orderid:$('#orderid').val(),
                        sorted:sorted
                    },
                    success: function(data){

                        alert("Data saved");

                    }
                });
            });



        });


    </script>
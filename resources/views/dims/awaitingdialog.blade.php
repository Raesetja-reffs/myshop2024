@extends('layouts.app')

@section('content')
    <div  style="color: black">
        <button id="closeminiorderform" class="btn-md btn-primary pull-right" style="padding: 18px;display: none;">CLOSE</button>
       <strong  style="color: black">Delivery Date</strong> <input type="text" id="deliverydate" value="{{$products[0]->DeliveryDate}}" readonly>
        <input type="hidden" id="OrderId" value="{{$products[0]->OrderId}}" readonly>
        <br><br>
    </div>
    <hr  style="border: 1px solid black;">
    <div class="container" style="width: 100%;">

        <table class="table" id="minitable">
            <thead>
            <tr>
                <th>Product Code</th>
                <th>Product Description</th>

                <th>Qty</th>
                <th>Unit Of Measure</th>
                <th>Comment</th>

                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php $orderValue = 0;$customerName = "";$OrderNo = "";$noOfLines = 0; ?>
            @foreach($products as $value)
                <tr>

                    <td>{{$value->PastelCode}}</td>
                    <td>{{$value->PastelDescription}}</td>


                    <td><input type="text" value="{{round($value->Qty,3)}}" onkeypress="return isFloatNumber(this,event)" id="quantity" class="qty" readonly></td>
                    <td>{{$value->UnitSize}}</td>
                    <td>
                        <input type="text" value="{{$value->Comment}}" id="comments" class="comments" readonly>
                        <input type="hidden" value="{{$value->OrderDetailId}}" id="OrderDetailId" class="OrderDetailId">
                    </td>

                    <td style="display: none;">{{$value->OrderDetailId}}</td>
                </tr>
                <?php $orderValue = $orderValue + $value->IncNettPrice; $customerName = $value->StoreName;$OrderNo = $value->OrderNo;$noOfLines++; ?>
            @endforeach
            </tbody>
        </table>
        <div>

            Lines :  <input name="lines"  id="lines" style="color:blue;font-size:15px;font-weight: 900;" value="{{$noOfLines}}" readonly >
            <input name="orderValue" class="form-control input-sm col-xs-1" id="mass" style="color:blue;font-size:15px;font-weight: 900;" value="{{$orderValue}}" >
            <input name="customer" class="form-control input-sm col-xs-1" id="customer" style="color:red;font-size:15px;font-weight: 900;" value="{{$customerName}}" >
            <input name="OrderNo" class="form-control input-sm col-xs-1" id="OrderNo" style="color:red;font-size:15px;font-weight: 900;" value="{{$OrderNo}}" >


        </div>
        <div>
            <br><br>
            <hr  style="border: 1px solid black;">
            <h3  style="color: black">Remove From Awaiting Stock
            <input type="checkbox" id="awaitingstock" style="height: 22px;width: 30px;"></h3>
            <button id="saveid" class="btn-success btn-lg">Save</button>
        </div>
    </div>
@endsection

<script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
<script>
    var orderid = JSON.stringify({!! json_encode($orderId) !!});
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).keydown(function(e) {
        if (e.keyCode == 27) return false;
    });
    $(document).ready(function() {
        $('#routePlanningPopUp').hide();
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#tabletLoadingApp').hide();
        $('#salesQuotebtn').hide();
        $('#popupmoveThis').hide();
        $('#pricingOnCustomer').hide();
        $('#salesOnOrder').hide();
        $('#posCashUp').hide();
        $('#salesInvoiced').hide();


        $("#deliverydate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#saveid').click(function(){
            $.ajax({
                url: '{!!url("/removeorderfromawaitingstock")!!}',
                type: "post",
                data: {
                    OrderId:$('#OrderId').val(),
                    deliverydate:$("#deliverydate").val()
                },
                success: function (data) {
                    alert(data);
                    let new_window = open(location, '_self');
                    // Close this window
                    new_window.close();

                }
            });

        });
    });

    function isFloatNumber(item,evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode==46)
        {
            var regex = new RegExp(/\./g)
            var count = $(item).val().match(regex).length;
            if (count > 1)
            {
                return false;
            }
        }
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $(document).keyup(function(e){
        if(e.keyCode==27){
            // alert('not allowed !!!');
            // or any other code
            return false;
        }
    });

</script>

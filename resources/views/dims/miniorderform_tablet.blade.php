@extends('layouts.app')

@section('content')
    <div>
        <button id="closeminiorderform" class="btn-md btn-primary pull-right" style="padding: 18px;display: none;">CLOSE</button>
    </div>
    <div class="container" style="width: 100%;">

        <table class="table" id="minitable">
            <thead>
            <tr>
                <th>Product Code</th>
                <th>Product Description</th>
                <th>WareHouse</th>
                <th>Qty</th>
                <th>Unit Of Measure</th>
                <th>Comment</th>
                <th>Is Loaded?</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php $orderValue = 0;$customerName = "";$OrderNo = "";$noOfLines = 0; ?>
            @foreach($products as $value)
                <tr>

                    <td>{{$value->PastelCode}}</td>
                    <td>{{$value->PastelDescription}}</td>
                    <td>{{$value->locationName}}</td>

                    <td><input type="text" value="{{round($value->Qty,3)}}" onkeypress="return isFloatNumber(this,event)" id="quantity" class="qty"></td>
                    <td>{{$value->UnitSize}}</td>
                    <td>
                        <input type="text" value="{{$value->Comment}}" id="comments" class="comments">
                        <input type="hidden" value="{{$value->OrderDetailId}}" id="OrderDetailId" class="OrderDetailId">
                    </td>
                    @if($value->Loaded == 1 )
                        <td><input type="checkbox" class="checkbox_check" name="loaded[]" style="width:18px;height:15px !important" checked="checked" ></td>
                        @else
                        <td><input type="checkbox" class="checkbox_check" name="loaded[]" style="width:18px;height:15px !important"  ></td>
                    @endif
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
    </div>
@endsection

<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
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

        $('#closeminiorderform').click(function(){
            var values = new Array();
            var lines = $('#lines').val();
            var linesLoaded = 0;
            var linesNotLoaded = 0;

            $.each($("input[name='loaded[]']"),
                function () {
                    var str = $(this).closest('tr').find('.comments').val();
                    str = str.replace("'","");
                    if($(this).closest('tr').find('.checkbox_check').prop('checked')){
                        values.push({
                            'qty': $(this).closest('tr').find('.qty').val(),
                            'comment': str,
                            'orderdetailId': $(this).closest('tr').find('.OrderDetailId').val(),
                            'loaded': 1
                        });
                        linesLoaded++;
                    }else{

                        values.push({
                            'qty': $(this).closest('tr').find('.qty').val(),
                            'comment':  str,
                            'orderdetailId': $(this).closest('tr').find('.OrderDetailId').val(),
                            'loaded': 0

                        });
                        linesNotLoaded++;
                    }
                });


            $.ajax({
                url: '{!!url("/updateTableLoadingAppProducts")!!}',
                type: "GET",
                data: {
                    OrderId:orderid,
                    orderDetails: values
                },
                success: function (data) {
                    console.debug(data.statements);
                    if(data.statements == "CLOSE")
                    {
                        var dialog = $('<p><strong style="color:red">'+data.Result+'</strong> </p>').dialog({height:200,width:700,
                            buttons: {
                                "Yes": function() {  window.close(); },
                                "No":function() {
                                    dialog.dialog('close');

                                }
                            }
                        });

                    }
                    else{
                        var dialog = $('<p><strong style="color:red">'+data.Result+'</strong> </p>').dialog({height:200,width:700,
                            buttons: {
                                "Yes": function() {

                                    $.ajax({
                                        url: '{!!url("/invoicedoc")!!}',
                                        type: "POST",
                                        data: {
                                            OrderId: orderid
                                        },
                                        success: function (data) {
                                            dialog.dialog('close');

                                            window.close();
                                        }
                                    });
                                    //invoicedoc
                                    //location.reload(true);
                                },
                                "No": function() {
                                    dialog.dialog('close');
                                    window.close();
                                    //location.reload(true);
                                }
                            }
                        });

                    }


                }
            });

        });
    });
    function SelectallColorsForStyle(e, val) {
        console.debug("e.value//////"+e.value);
        console.debug("val***+-//////"+val);
        /* $.ajax({
         url: ,
         type: "POST",
         data: {
         CustomerCode: e.value,
         DeivDate: $('#callListDeliveryDate').val(),
         Show:"0",
         DeliveryAddressId: "0"
         },
         success: function (data) {
         console.debug("data saved");
         }
         });*/
    }
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

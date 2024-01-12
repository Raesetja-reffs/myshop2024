<x-app-layout>

    <x-slot name="header">
        {{ __('Mini Order Form Tablet') }}
    </x-slot>

    <x-slot name="breadcrum">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <!--end::Item-->

        <!--begin::Item-->
        <li class="breadcrumb-item text-dark">
            Mini Order Form Tablet
        </li>
        <!--end::Item-->
    </x-slot>

    <div class="card mt-5">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <button id="closeminiorderform" class="btn btn-primary btn-sm" style="display: none;">
                        CLOSE
                    </button>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive scrollable overflow-y-auto" style="max-height: 480px;">
                        <table id="minitable" class="table table-bordered">
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
                                        <td>
                                            <input type="text" value="{{round($value->Qty,3)}}" onkeypress="return isFloatNumber(this,event)" id="quantity" class="qty form-control">
                                        </td>
                                        <td>{{$value->UnitSize}}</td>
                                        <td>
                                            <input type="text" value="{{$value->Comment}}" id="comments" class="comments form-control">
                                            <input type="hidden" value="{{$value->OrderDetailId}}" id="OrderDetailId" class="OrderDetailId">
                                        </td>
                                        @if($value->Loaded == 1 )
                                            <td>
                                                <input type="checkbox" class="checkbox_check custom-checkbox-sm" name="loaded[]" checked="checked">
                                            </td>
                                        @else
                                            <td>
                                                <input type="checkbox" class="checkbox_check custom-checkbox-sm" name="loaded[]">
                                            </td>
                                        @endif
                                        <td style="display: none;">{{$value->OrderDetailId}}</td>
                                    </tr>
                                    <?php $orderValue = $orderValue + $value->IncNettPrice; $customerName = $value->StoreName;$OrderNo = $value->OrderNo;$noOfLines++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="text-">Lines :</label>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4">
                    <input name="lines" id="lines" class="form-control" style="color:blue;font-weight: 900;" value="{{$noOfLines}}" readonly>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4">
                    <input name="orderValue" class="form-control" id="mass" style="color:blue;font-weight: 900;" value="{{$orderValue}}">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4">
                    <input name="customer" class="form-control" id="customer" style="color:red;font-weight: 900;" value="{{$customerName}}">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4">
                    <input name="OrderNo" class="form-control" id="OrderNo" style="color:red;font-weight: 900;" value="{{$OrderNo}}">
                </div>
            </div>
        </div>
    </div>

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
</x-app-layout>


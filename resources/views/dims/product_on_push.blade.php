@extends('layouts.app')

@section('content')
    <div class="col-lg-6"  style="height:100%;background: white;height:70%;overflow-y: scroll">
        <div class="col-lg-12">
        <input type="hidden" id="customerId" value="{{$customerId}}">
        <h4>Push Products</h4>
        <i>Please remove the product</i>
        <table class="table table-bordered stripe search-table" tabindex=0 id="productOnPush"  style="font-size:11px;  color: black;font-family: sans-serif;" >
            <thead style="font-size: 17px;">
            <tr>
                <th class="col-sm-2">Product Code</th>
                <th class="col-sm-3">Product Description</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($pushProducts as $value)
                <tr>
                    <td>{{$value->PastelCode}}</td>
                    <td>{{$value->PastelDescription}}</td>
                    <td class="col-sm-1"> <input type="checkbox" name="productsOnPush[]" class="productsOnPush" value="{{$value->ProductId}}" style="height: 18px !important;"></td>
                </tr>
            @endforeach

            </tbody>

        </table>
        </div>
        <button class="btn-md btn-success" id="removeProduct">Remove Product(s)</button>
    </div>
    <div class="col-lg-6">
    <div class="col-lg-12" style="height:100%;background : linen;height:70%;overflow-y: scroll">
        <h4>All Products</h4>
        <table class="table table-bordered stripe search-table" tabindex=0 id="allProduct" style="font-size:11px;  color: black;font-family: sans-serif;" >
            <thead style="font-size: 17px;">
            <tr>
                <th class="col-sm-1">Product Code</th>
                <th class="col-sm-1">Product Description</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($allProducts as $value)
                <tr>
                    <td>{{$value->PastelCode}}</td>
                    <td>{{$value->PastelDescription}}</td>
                    <td class="col-sm-1"><input type="checkbox" name="productsAll[]" class="productsAll" value="{{$value->ProductId}}" style="height: 18px !important;"></td>
                </tr>
                @endforeach

            </tbody>

        </table>
    </div>
        <button class="btn-md btn-success" id="pushTheProduct">Add To Push List</button>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#pushTheProduct').click(function() {

            var productsAll = $("input[name='productsAll[]']:checked").map(function () {
                return $(this).val();
            }).get()
            $.ajax({
                url: '{!!url("/insertIntoPushProducts")!!}',
                type: "POST",
                data: {
                    productsAll: productsAll,
                    customerId: $('#customerId').val()

                },
                success: function (data) {

                    var dialog = $('<p><strong>Products Added into Push List</strong></p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": function () {

                                dialog.dialog('close'); location.reload(true);

                            }
                        }
                    });
                }
            });
        });
        $('#removeProduct').click(function() {

            var productOnPush = $("input[name='productsOnPush[]']:checked").map(function () {
                return $(this).val();
            }).get()
            $.ajax({
                url: '{!!url("/removePushProducts")!!}',
                type: "POST",
                data: {
                    productOnPush: productOnPush,
                    customerId: $('#customerId').val()

                },
                success: function (data) {

                    var dialog = $('<p><strong>Products Removed from the Push List</strong></p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": function () {

                                dialog.dialog('close'); location.reload(true);

                            }
                        }
                    });
                }
            });
        });
    });
    </script>
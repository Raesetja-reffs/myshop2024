@extends('layouts.app')

@section('content')
    <div class="container" style="width: 100%;">

        <div class="row">
            <div id="salesQuotesPreviewScreen" title="Sales Quotation">
                <div id="printOut">
                    <div class="col-lg-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                <div class=" pull-right" id="orderinfoAddress" style="font-size: 10px;">
                                    <input type="hidden" id="hiddenSalesQ" value="{{$id}}">
                                    <img src="{{URL::asset('/images/logo.png')}}" />
                                </div>
                                <div class="pull-left" id="orderinfo" style="font-size: 13px;">
                                    {{$quoteHeader[0]->strRawString}}
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-12" id="wrapthis">
                            <table class="table" id="tableQuotePreview">
                                <th>Item Code</th>
                                <th>Description</th>
                                <th>Measure</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>PriceInc</th>
                                <th>LineTotalInc</th>
                            </table>

                            <div class="col-md-5 pull-right hidebody">
                                <table class="table table-condensed-footer">
                                    <tr>
                                        <td>Total In</td>
                                        <td><input id="totalIncPreview"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="editor"></div>
                <button type="button" id="printThisOut" class="btn-info btn-xs" style="display: none">Print</button>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>


<script>
    $(document).ready(function() {
        $(document).attr("title", "Quotation#"+$('#hiddenSalesQ').val());
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{!!url("/previewSaleQuotes")!!}',
            type: "POST",
            data: {
                saleQuoteID: $('#hiddenSalesQ').val(),
            },
            success: function (data) {
                var trHTML = '';
                var totalPriceIn = 0;
                $('.remthis').remove();
                $.each(data, function (key,value) {
                    trHTML += '<tr  class="remthis" style="font-size: 11px;color:black;"><td>' +
                        value.PastelCode + '</td><td style="text-align: center;">' +
                        value.PastelDescription+ '</td><td style="text-align: center;">' +
                        value.strUnitSize + '</td><td style="text-align: center;">' +
                        parseFloat(value.fltQuantity).toFixed(2)  + '</td><td>' +
                        parseFloat(value.fltPrice).toFixed(2) + '</td><td>' +
                        parseFloat(value.fltPriceInc).toFixed(2) + '</td><td>' +
                        parseFloat(value.priceIncLineTot).toFixed(2) + '</td></tr>';
                    totalPriceIn = (parseFloat(totalPriceIn) + parseFloat(value.priceIncLineTot)).toFixed(2);

                });
                $('#tableQuotePreview').append(trHTML);
                $('#totalIncPreview').val(totalPriceIn);
            }
        });

    });
</script>
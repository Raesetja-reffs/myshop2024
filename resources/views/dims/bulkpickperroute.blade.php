@extends('layouts.app')

@section('content')
    <div class="col-lg-12" style="background: white;font-weight: 900;padding: 0px 126px 3px 129px">
        <div class="form-group  col-md-6" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <button id="bulkID" class=" form-control btn-success btn-md" value="{{$bulkID}}">Preview PDF & Print</button>
        </div>
        <div class="form-group  col-md-6" style="margin-bottom: 0px;font-weight: 700;font-size: 11px">
            <label class="control-label" for="inputOrderId"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Printers</label>
            <select class="form-control input-sm " id="printerVal" style="height:26px;font-size: 10px;color:black;">
                @foreach($printers as $value)
                    <option value="{{$value->ID}}">{{$value->strPrinter}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-12" style="background: white;font-weight: 900;padding: 0px 126px 3px 129px">

        @if(count($bulkperroute) > 0)
        <h5>Bulk Picking Slip Id : {{$bulkperroute[0]->BulkPickingSlipId}}</h5>
        <hr style="color:black;font-weight: 900;background: black;height: 3px;">
        <div class="col-lg-12" >
            <div class="col-lg-4">{{$bulkperroute[0]->Route}}</div>
            <div class="col-lg-4">{{$bulkperroute[0]->OrderType}}</div>
            <div class="col-lg-4"></div>
        </div>
            @else
        There is no data
            @endif
    </div>
    <div class="col-lg-12" style="background: white;font-weight: 900;padding: 0px 126px 3px 129px;font-family: serif;">
        <table class="table2">
            <tr>
                <th>Description</th>
                <th>UnitSize</th>
                <th>Prior Qty</th>
                <th>Current Qty</th>
                <th>Adjustments</th>
            </tr>
            @foreach($bulkperroute as $value)
                <tr>
                    <td> {{$value->PastelDescription}}</td>
                    <td> {{$value->UnitSize}}</td>
                    <td> {{$value->PriorQty}}</td>
                    <td> {{$value->CurrentQty}}</td>
                    <td> {{$value->Adjustment}}</td>
                </tr>
                @endforeach
        </table>

    </div>
@endsection
<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    th, td {
        text-align: left;
        padding: 16px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2
    }
</style>
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

<script>
    var isJasper = "<?php  echo env('JASPER'); ?>";
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
        $('#bulkID').click(function(){
            var bulkId = $('#bulkID').val();
            if(isJasper !="LTRUE"){
            $.ajax({
                url: '{!!url("/insertIntoTblPickingPerRoute")!!}',
                type: "POST",
                data: {
                    bulkID:$('#bulkID').val(),
                    printerVal: $('#printerVal').val()
                },
                success: function (data) {
                    if ( data != 'false'){
                        var dialog = $('<p><strong>Done Printing Picking Slip</strong></p>').dialog({
                            height: 200, width: 700, modal: true, containment: false,
                            buttons: {
                                "OKAY": function () {
                                    dialog.dialog('close');
                                }
                            }
                        });
                    }

                }
            });
            }else{
                window.open('{!!url("/bulkpickingslip")!!}/'+bulkId, bulkId, "location=1,status=1,scrollbars=1, width=1200,height=850");
            }
            //insertIntoTblPickingPerRoute

        });
    });
</script>

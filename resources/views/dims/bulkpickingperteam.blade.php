@extends('layouts.app')

@section('content')
    <div class="col-lg-12" style="background: white;font-weight: 900;padding: 0px 126px 3px 129px">
        <h3><strong>Route Per Picking Team Report</strong></h3>
        <?php $reginald = '201103202' ?>
        <div class="form-group  col-md-6" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <input type="hidden" id="pickingteams" value="{{$pickingId}}">
            <input type="hidden" id="deldate" value="{{$deldate}}">
            <input type="hidden" id="ordertype" value="{{$ordertype}}">
            <input type="hidden" id="routes" value="{{$routes}}">
            <button id="printBulkPerRoute" class=" form-control btn-success btn-md" >Print</button>
        </div>
        <div class="form-group  col-md-6" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="inputOrderId"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Printers</label>
            <select class="form-control input-sm " id="printerVal" style="height:26px;font-size: 10px;color:black;">
                @foreach($printers as $value)
                    <option value="{{$value->ID}}">{{$value->strPrinter}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <hr style="color:black;font-weight: 900;background: black;height: 3px;">
    <div class="col-lg-12" style="background: white;font-weight: 900;overflow-y: scroll;height:70%;padding: 0px 126px 3px 129px">
        @foreach($bulkperteamresults as $value)
            @if($value->PastelCode != $reginald )
                <div class="col-lg-12" style="background: white;font-weight: 900;padding: 0px 126px 3px 129px">
                    <div class="col-lg-4">
                        <strong>{{$value->PastelCode}}</strong>
                    </div>
                    <div class="col-lg-4">
                        <strong>{{$value->PastelDescription}}</strong>
                    </div>
                    <div class="col-lg-4">
                        <strong>{{$value->UnitSize}}</strong>
                    </div>
                </div>
                    <div class="col-lg-12" style="background: white;font-weight: 900;padding: 0px 126px 3px 129px">
                        <table class="table table-bordered table-condensed">

                                <tr style=" font-size: 14px;"   >
                                    <td class="col-md-4"> {{$value->StoreName}}</td>
                                    <td class="col-md-1"> {{$value->InvoiceNo}}</td>
                                    <td class="col-md-1"> {{$value->Qty}}</td>
                                    <td class="col-md-4"> {{$value->Comment}}</td>
                                </tr>
                        </table>
                    </div>
                <?php $reginald = $value->PastelCode ?>
                @else
                <div class="col-lg-12" style="background: white;font-weight: 900;padding: 0px 126px 3px 129px">
                    <table class="table table-bordered table-condensed">
                        <tr style=" font-size: 14px;" >
                            <td class="col-md-4"> {{$value->StoreName}}</td>
                            <td class="col-md-1"> {{$value->InvoiceNo}}</td>
                            <td class="col-md-1"> {{$value->Qty}}</td>
                            <td class="col-md-4"> {{$value->Comment}}</td>
                        </tr>
                    </table>
                    <?php $reginald = $value->PastelCode ?>
                </div>
                @endif



            @endforeach
            </div>

@endsection
<style>
   /* table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }*/

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

        $('#printBulkPerRoute').click(function(){

            $.ajax({
                url: '{!!url("/insertIntoTblPicking")!!}',
                type: "POST",
                data: {
                    pickingteams:$('#pickingteams').val() ,
                    deldate: $('#deldate').val() ,
                    ordertype:$('#ordertype').val() ,
                    routes: $('#routes').val(),
                    printerVal: $('#printerVal').val()

                },
                success: function (data) {
                    alert(data);
                }
            });
        });

    });
</script>
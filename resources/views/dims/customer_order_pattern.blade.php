@extends('layouts.app')
@section('content')
<div class="col-lg-12" >
    <table class="table search-table" id="orderPatternIdTable" style="overflow-y: scroll; width: 100%;font-family: sans-serif;height:62% !important;">
        <thead>

        <tr >
            <th>Code</th>
            <th class="col-md-8" >Description</th>
            <th class="col-xs-1">2Week</th>
            <th class="col-xs-1">Avg</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($order_pattern as $value)
        <tr>
            <td >{{$value->PastelCode}}</td>
            <td class="col-md-8" >{{$value->PastelDescription}}</td>
            <td class="col-xs-1">{{round($value->twoWeeks,3)}}</td>
            <td class="col-xs-1">{{round($value->Avg,3)}}</td>
            <td><button class="btn-md btn-danger" value="{{$value->ID}}" id="deleteline">Delete</button></td>
        </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $('#popUpIndividualBulk').hide();
        $('#popUpBatchBulk').hide();
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
        $('#orderPatternIdTable').on('click', 'button', function (e) {
            var $thisParentRow = $(this);
            var $thisval = $(this).val();

            $.ajax({
                url: '{!!url("/deletepatternline")!!}',
                type: "POST",
                data: {
                    defaultID: $thisval
                },
                success: function (data) {
                    alert('deleted '+data);
                    $thisParentRow.closest('tr').remove();
                }
            });

        });
        $('#orderPatternIdTable tbody').on('click', 'tr', function (e){
            $("#orderPatternIdTable tbody tr").removeClass('row_selectedYellowish');
            $(this).addClass('row_selectedYellowish');
        });
    });
 </script>
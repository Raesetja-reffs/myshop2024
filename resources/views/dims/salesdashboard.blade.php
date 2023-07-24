@extends('layouts.app')

@section('content')
    <div class="container" style="width: 100%;">
        <div class="row">
            <div class="col-lg-12">

                    <div class="col-lg-12" style="background: black;color: white;font-family: sans-serif;font-weight: 900;">
                        <div class="col-lg-4">
                        <h1>{{$rVal}}</h1>
                        </div>
                        @foreach($mDate as $val)
                        <div class="col-lg-4">

                        <h1>{{$val->MonthToDate}}</h1>

                        </div>
                         <div class="col-lg-4">

                        <h1>{{$val->InvoicedValue}}</h1>

                        </div>

                        @endforeach
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>USERNAME</th>
                            <th>VALUE</th>
                            <th>GP%</th>
                        </tr>
                        </thead>
                        <tbody style="font-size: 25px;font-family: sans-serif;font-weight: 900;color: white;background: black;">
                        @foreach($teledata as $val)
                        <tr>
                            <td>{{$val->UserName}}</td>
                            <td>{{$val->RandVal}}</td>
                            <td>{{round($val->GPPercent,2)}}</td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>



            </div>
            <div class="col-lg-12">
                        <div id="perf_div"></div>
                        {!! $lava->render('ColumnChart', 'EWA', 'perf_div') !!}
            </div>
        </div>
    </div>
    @endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<meta http-equiv="refresh" content="900">
<script>
    $(document).ready(function() {
        $('#QuoteDetails').hide();
        $('#extraInfo').hide();
        $('#salesQEmail').hide();
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#tabletLoadingApp').hide();
        $('#pricingOnCustomer').hide();
        $('#salesOnOrder').hide();
        $('#posCashUp').hide();
        $('#dropdown').hide();
        $('#editTrucks').hide();
        $('#salesInvoiced').hide();
    });
</script>
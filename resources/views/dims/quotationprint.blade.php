@extends('layouts.pdfapp')

@section('content')
<div class="col-lg-12"  style="font-family: Helvetica, Arial, sans-serif;font-size: 12px;">
    <h3 style="text-align: center">Quotation</h3>
    <div class="col-lg-4" class="pull-left">
        <h4>ADCAN MARINE SUPPLIERS</h4>
        <h5>P O BOX 146</h5>
        <h5>PARK RYNIE</h5>
        <h5>4182</h5>

    </div>
    <div class="col-lg-4" class="pull-right">
        <h4>VAT NO:4350107290</h4>
        <h5>TEL:(039) 9761909/7</h5>
        <h5>FAX:(039) 9781341</h5>

    </div>
</div>
<div class="col-lg-12"  style="font-family: Helvetica, Arial, sans-serif">

    <div class="col-lg-4" class="pull-left">
       @foreach($pobox as $value)
        <h5>{{$value->Adress1}}</h5>
        <h5>{{$value->Adress2}}</h5>
        <h5>{{$value->Adress3}}</h5>
        <h5>{{$value->Adress4}}</h5>
        <h5>{{$value->Adress5}}</h5>
           @endforeach

    </div>
    <div class="col-lg-4" class="pull-right">
        @foreach($pobox as $value)
            <h5>{{$value->DeliveryAddress1}}</h5>
            <h5>{{$value->DeliveryAddress2}}</h5>
            <h5>{{$value->DeliveryAddress3}}</h5>
            <h5>{{$value->DeliveryAddress4}}</h5>
            <h5>{{$value->DeliveryAddress5}}</h5>
        @endforeach
        <h3>{{$customerCode}}</h3>
    </div>
    <div class="col-lg-4" class="pull-right">
        <h2>QUA{{$quoteId}}</h2>

    </div>
</div>

    @endsection
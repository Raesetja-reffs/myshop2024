@extends('layouts.app')

@section('content')
<div>
    <a href='{!!url("/briefcaseDamages")!!}'style="color:black;background: yellow;font-weight: 900;padding:6px;">Back</a>
    <h3 style="text-align: center">This is Processed you cannot undo this,Please press print to print your document.</h3>
    <div>
        <h4>{{$damagesheader[0]->CustomerCode}}</h4>
        <h4>{{$damagesheader[0]->CustomerStoreName}}</h4>
        <p style="text-align: center;"><a href='{!!url("/print_damages")!!}/{{$damagesheader[0]->ID}}' class="btnPrint" style="color:red;background: white;font-weight: 900;padding:6px;">Print</a></p>

    </div>
    <table border="1" cellspacing="0" width="100%">
        <thead>
        <tr>
            <td>Code</td>
            <td>Product Description</td>
            <td>Quantity </td>
            <td>Notes </td>
        </tr>
        </thead>
        <tbody >
        @foreach($damageslines as $value)
            <tr>
                <td>{{$value->strPartNumber}}</td>
                <td>{{$value->strDesc}}</td>
                <td>{{round($value->Quantity,2)}}</td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br><br>
    <h5>Signature...............................................................................</h5>
</div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.btnPrint').printPage();
    });
</script>
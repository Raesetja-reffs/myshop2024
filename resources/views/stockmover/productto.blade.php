<!DOCTYPE html>
<html xmlns:font-size="http://www.w3.org/1999/xhtml" xmlns:background="http://www.w3.org/1999/xhtml"
      xmlns:padding="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 10px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>

<div>
    Shelf From:{{$shelffrom}} <br>Shelf To: {{$shelfto}}

    <form action="{{url('gofinish')}}" method="post">
        @csrf
    <label style="font-size: 21px;font-weight: 900">Scan Product {{$productfrom}}</label><br>
    <input type="text" id="productto" value="" required style="width: 100%;height:95px;"><br>
        <label style="font-size: 21px;font-weight: 900">Quantity</label><br>
    <input type="text" id="confirmqty" value="" required style="width: 100%;height:60px;"><br>
        <label style="font-size: 21px;font-weight: 900">Expiry Date</label><br>
        <input type="date" id="expiry" value="" required style="width: 100%;height:60px;"><br>
    <input type="hidden" id="shelffrom"  value="{{$shelffrom}}">
    <input type="hidden" id="productfrom"  value="{{$productfrom}}">
    <input type="hidden" id="shelfto"  value="{{$shelfto}}">
    <input type="hidden" id="Qty"  value="{{$Qty}}">
    <br><br><br>
        <input type="submit" value="NEXT" style="background: #802e6a;font-weight: 900;color:black;width: 100%;height:65px;color: white;font-weight: 900">
    </form>
</div>

<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {


        $('#nextfromshelf').click(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{!!url("/gofinish")!!}',
                type: "POST",
                data: {
                    shelffrom: $('#shelffrom').val(),
                    shelfto: $('#shelfto').val(),
                    productto: $('#productto').val(),
                    productfrom: $('#productfrom').val(),
                    Qty: $('#Qty').val(),
                    confirmqty: $('#confirmqty').val(),

                },
                success: function (data) {

                } });
        });
    });
</script>

</body>
</html>

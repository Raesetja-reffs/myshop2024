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
    {{$shelffrom}}
    <label>Scan Product From</label><br>
    <input type="text" id="productfrom" value="" required style="width: 100%;height:95px;">
    <input type="hidden" id="shelffrom"  value="{{$shelffrom}}">
    <input type="hidden" id="Qty"  value="">
    <br><br><br>
    <button id="nextfromshelf" style="background: green;font-weight: 900;color:black;width: 100%;height:65px;color: white;font-weight: 900">NEXT</button>
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
                url: '{!!url("/goscanshelfto")!!}',
                type: "POST",
                data: {
                    shelffrom: $('#shelffrom').val(),
                    productfrom: $('#productfrom').val(),
                    Qty: $('#Qty').val()

                },
                success: function (data) {

                } });
        });
    });
</script>

</body>
</html>

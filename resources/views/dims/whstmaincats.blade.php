<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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



    @foreach($products as $val)
        <tr>
            <div style="text-align: center;background: #c7baba;padding: 10px;color: white"><a href='{!!url("/getProductsnames")!!}/{{$val->group1}}'>{{$val->group1}}</a> </div>
            <br>

        </tr>
    @endforeach

</body>
</html>

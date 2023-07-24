<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 4px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>

<table>
    <tr>
        @foreach($routes as $value)
            <td><h2>{{$value->Route}}</h2></td>
        @endforeach
        @foreach($OrderTypes as $value)
            <td><h2>{{$value->OrderType}}</h2></td>
        @endforeach


    </tr>
</table>
    <table style="width:100%;font-size:13px;">
        <thead>
        <tr>
            <th style="font-size: 10px;">Delv date</th>
            <th style="font-size: 10px;">Route</th>
            <th class="col-md-4" id="facility_header"  style="font-size: 10px;">Customer</th>
            <th style="font-size: 10px;">InvNO</th>
            <th style="font-size: 10px;">OrderID</th>
            <th style="font-size: 10px;">Delivery Type</th>

            <th style="font-size: 10px;">Seq</th>
            <th style="font-size: 10px;color:blue;">Mass</th>
            <th style="font-size: 10px;color:red;">OrderValue</th>
            <th style="font-size: 10px;color:blue;">Address</th>
            <th style="font-size: 10px;color:blue;">Notes</th>

        </tr>
        </thead>

        <tbody>
        @foreach($stops as $value)
            <tr>
                <td>{{$value->DeliveryDate}}</td>
                <td>{{$value->Route}}</td>
                <td>{{$value->StoreName}}</td>
                <td>{{$value->InvoiceNo}}</td>
                <td>{{$value->OrderId}}</td>
                <td>{{$value->OrderType}}</td>
                <td>{{$value->DeliverySequence}}</td>
                <td>{{round($value->Mass,3)}}</td>
                <td>{{round($value->OrderValue,2)}}</td>
                <td>{{$value->deliveryAddress1}}</td>
                <td>{{$value->optionalField}}</td>
            </tr>
            @endforeach

        </tbody>
    </table>

</body>
</html>
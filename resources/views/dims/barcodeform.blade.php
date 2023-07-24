<!DOCTYPE html>
<html>
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

<form action="{{url('savebarcode')}}" method="post">
    @foreach($products as $val)
        @csrf
    <label for="Code">Item Name: {{$val->Description_1}}</label><br>
    <input type="text" id="Code" name="Code" value="{{$val->Code}}" readonly><br>
    <input type="hidden" id="cat" name="cat" value="{{$val->cat}}" >
    <label for="barcode">Scan/Enter Barcode</label><br>
    <input type="text" id="barcode" name="barcode"  style="height: 60px; width: 100%"  autocomplete="off" required><br><br>

        <label for="location">Scan/Enter Location</label><br>
        <input type="text" id="location" name="location" style="height: 60px; width: 100%"  autocomplete="off" required><br><br>

        <label for="location">Expiry Date</label><br>
        <input type="date" id="expdate" name="expdate" style="height: 60px; width: 100%"  autocomplete="off" required><br><br>
    @endforeach
    <input type="submit" value="Submit">
</form>


</body>
</html>

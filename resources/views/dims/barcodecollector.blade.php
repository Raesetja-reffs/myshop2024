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

        #myInput {
            background-position: 10px 10px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
<a href={!!url("/productscats")!!}  style="float:right;background:red;padding:6px;">BACK To CATEGORIES</a>
<h3 style="text-align: center;">{{$cat}}</h3>
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for product..."  autocomplete="off">

<table id="myTable">
    <tr>
        <th>Code</th>
        <th>Barcode</th>

    </tr>

    @foreach($products as $val)
        <tr>
            <td><a href={!!url("/recordbarcode")!!}/{{$val->Code}}>{{$val->Description_1}}</a> <br>{{$val->Code}}<br> {{$val->group3}}</td>
            <td>{{$val->strItemBarcode}}<br>{{$val->strLocationName}}<br>{{$val->dteExpiryDate}}</td>

        </tr>
    @endforeach
</table>

<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

</body>
</html>

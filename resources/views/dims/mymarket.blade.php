<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .collapsible {
            background-color: #777;
            color: white;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
        }

        .active, .collapsible:hover {
            background-color: #555;
        }

        .content {
            padding: 0 18px;
            display: none;
            overflow: hidden;
            background-color: #f1f1f1;
        }
        .hidden_row {
            display: none;
        }
        .nostock{
            background: orange;
        }
    </style>
</head>
<body>

<h3>My Market Orders </h3>
<div style="overflow: scroll;height: 300px;width: 100%;">
<table id="pastInvoices" class="table" style="width: 100%">
    <tr style="font-size: 16px;" >
        <th>ID</th>
        <th>name</th>
        <th>orgID</th>
        <th>Purchase Date</th>

    </tr>
    <tbody>

    </tbody>
</table>
</div>
<button id="pullorders">Pull Orders To Deal With</button>
<div style="overflow: scroll;height: 300px;width: 100%;">

    <table id="progress" class="table" style="width: 70%">
        <tr style="font-size: 16px;" >
            <th></th>
            <th>My Market Cust Code</th>
            <th>DIMS Cust Code</th>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Available</th>
            <th>Qty Requesting</th>
            <th>Line Delivery Date</th>
            <th>Purchase Date</th>

        </tr>
        <tbody>

        </tbody>
    </table>

</div>
<button style="background: #0bc90b;color: black;height: 35px;" id="commit">Commit Orders</button>
<script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;
    var a = new Array();

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }

    $('#commit').hide();
    $.ajax({
        url: '{!!url("/mymarketGetSales")!!}',
        type: "GET",
        success: function (data) {
            var trHTML = '';
            var inv = 'id';
            var counter = 0;
            console.debug(data);

            var b = new Array();

            for(var k=0; k < data.length;k++)
            {
                console.debug(data[k][0]['salesOrderNumber']);
                console.debug(data[k].length);
                for( var i=0;i < data[k].length; i++){
                if (inv != data[k][i]['salesOrderNumber'] )
                {
                    console.debug("inside"+data[k][i]['salesOrderNumber']);
                    var x = parseInt(counter)+1;
                   // a.push(data[k][i]['salesOrderNumber']);
                    trHTML +='<tr ondblclick="this.style.display = none" class="fast_remove" style="font-size: 16px;background: #bbbaa6" onclick="show_hide_row(\'hidden_row1'+ x +'\') ;"><td><input type="checkbox" name="salesordersselected" class="orderid" value="'+data[k][i]['salesOrderNumber']+'">'+
                        data[k][i]['salesOrderNumber'] +'</td><td>'+
                        data[k][i]['name'] +'</td><td>'+
                        data[k][i]['orgID'] +'</td><td>'+
                        data[k][i]['purchaseOrderDate'] +'<input type="hidden" class="dontTakeme" value="thisIsIt"></td><td></tr>';
                    counter++;

                }

                trHTML +='<tr style="font-size: 13px;color: black" class="hidden_row1'+counter+' hidden_row">'+
                    '<td style="padding: 0px;">Name:  '+data[k][i]['shortDescription']+'</td>'+
                    '<td style="padding: 0px;">Qty:   '+parseFloat(data[k][i]['quantity']).toFixed(2)+'</td>'+
                    '<td style="padding: 0px;">Code:  '+data[k][i]['partNumber']+'</td>'+
                    '<td style="padding: 0px;">Price: '+parseFloat(data[k][i]['unitPriceExclTax']).toFixed(2)+'</td>'+


                    '<tr>';


                inv = data[k][i]['salesOrderNumber'];
                }
            }

              $('#pastInvoices').append(trHTML);
        }

    });

    $('#pullorders').click(function(){
        a = new Array();
        $("input:checkbox[name=salesordersselected]:checked").each(function(){
            a.push( $(this).val());

        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.debug(a);
        $('#pullorders').hide();
       //getMymarketOrdersToDealWith
        $.ajax({
            url: '{!!url("/getMymarketOrdersToDealWith")!!}',
            type: "Post",
            data: {

                salesorderids: a
            },
            success: function (data) {
                var trHTML = '';
                var classAnonymouscols="stock";
                 var ischeckornot="checked";
                $('#removethis').empty();

                if(data[0].Result !="FAILED"){

                    $.each(data, function (key, value) {
                        if (value.enoughstock == 0)
                        {
                            classAnonymouscols="nostock";
                            ischeckornot="";
                        }
                        if (value.enoughstock == 1 )
                        {
                            classAnonymouscols="stock";
                            ischeckornot="checked";
                        }//intAutoId
                        trHTML += '<tr style="font-size: 13px;color:black" class="removethis '+classAnonymouscols+'"><td><input type="checkbox" name="checkAutos" '+ ischeckornot+' value="'+value.intAutoId+'" ></dt><td>' +
                            value.strCustomerCode + '</td><td>' +
                            value.strDimsCustomerCode + '</td><td>' +
                            value.strPartNumber+ '</td><td>' +
                            value.strDesc + '</td><td>' +
                            value.Available+'</td><td> <input type="number" class="qty" value="'+value.mnyQty+'" ><input type="hidden" class="strSalesOrderId" value="'+value.strSalesOrderId+'" ></td><td>' +
                            value.dteLinedeliveryDate+ '</td><td>' +
                            value.dtepurchaseOrderDate+ '</td><td>' +
                            '</td></tr>';
                    });
                    $('#progress').append(trHTML);
                    $('#commit').show();


                }

            }
        });
    });

    $('#commit').click(function(){


        var selected = [];
        var checkedLines = new Array();
        var notCheckedLines = new Array();
        $('[name="checkAutos"]:checked').each(function(checkbox) {
           // selected.push(checkbox);
            var id = $(this).val();
            checkedLines.push({
                'autoId': id,
                'qty': $(this).closest('tr').find('.qty').val(),
                'strSalesOrderId': $(this).closest('tr').find('.strSalesOrderId').val()
            });

        });
        $('[name="checkAutos"]:not(:checked)').each(function(checkbox) {
           // selected.push(checkbox);
            var id = $(this).val();
            notCheckedLines.push({
                'autoId': id,
                'qty': $(this).closest('tr').find('.qty').val(),
                'strSalesOrderId': $(this).closest('tr').find('.strSalesOrderId').val()
            });
        });
  console.debug(checkedLines);
  console.debug(notCheckedLines);

        $.ajax({
            url: '{!!url("/postMyMarketOrders")!!}',
            type: "POST",
            data: {

                checkedLines: checkedLines,
                notCheckedLines: notCheckedLines
            },
            success: function (data) {
                console.debug(data);
                // upDateOrderHeaderAndPOS();
            }
        });

    });
    function show_hide_row(row)
    {
        $("."+row).toggle();
    }
</script>

</body>
</html>

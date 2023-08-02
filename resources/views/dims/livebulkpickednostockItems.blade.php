<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css" />
    <style>
        .rag-red {
            background-color: #f00f0c;
        }
        .rag-green {
            background-color: lightgreen;
        }
        .rag-amber {
            background-color: lightsalmon;
        }
        .rag-yellow {
            background-color: #f6ff23;
        }

        .rag-red-outer .rag-element {
            background-color: lightcoral;
        }

        .rag-green-outer .rag-element {
            background-color: lightgreen;
        }

        .rag-amber-outer .rag-element {
            background-color: lightsalmon;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        th, td {
            text-align: left;
            border: 1px solid #dddddd;

        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }
        .table-container{
            height: 200px;
            overflow: scroll;
        }

        tr.row_selectedYellowish td{background-color:#91ff00 !important;}


    </style>
</head>
<body style="font-family: Sans-serif">
<div>
<h2>NO STOCK ITEM </h2>

    <a style="float:right;color:red" href='{!!url("/getViewItemsOutOfStock")!!}' onclick="window.open(this.href, 'getViewItemsOutOfStock',
'left=20,top=20,width=1600,height=800,toolbar=1,resizable=0'); return false;" >Out Of Stock Report on Picking</a>
</div>
<?php
if ((Auth::guest()))
{

}else{
?>
<select id="userviewingbackorders">
    <option value="{{Auth::user()->UserName}}">{{Auth::user()->UserName}}</option>
    <option value="-99">ALL</option>
</select>
<?php
}
?>


<br>

<div class="table-container" style="height:360px">
    <div >
        <table id="orderheaders" class="table">
            <thead>
            <tr>
                <th>Description</th>
                <th>QtyPicked</th>
                <th>PickerName</th>
                <th>OrderId</th>
                <th>SalesPerson</th>
                <th>Route</th>
                <th>OrderType</th>
                <th>Customer Name</th>
                <th>EstimatedInstockQty</th>
                <th>DeliveryDate</th>


            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div>


    </div>
</div>



<script type="text/javascript" charset="utf-8">


    $(document).ready(function() {
        $('#authRemoteOrder').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        retreiveorders();
//here
        $("#userviewingbackorders").on('change', function () {
            retreiveorders();

        });


    });

    function retreiveorders()
    {
        console.debug("***********"+$('#userviewingbackorders').val());
        $.ajax({
            url: '{!!url("/getItemWithNoStock")!!}',
            type: "GET",
            data: {
                userName:$('#userviewingbackorders').val()
            },
            success: function (data) {
                var trHTML = '';
                $('.fast_removeOrders').empty();
                $.each(data, function (key, value) {
                    trHTML += '<tr role="row" class="fast_removeOrders"  style="font-size: 13px;color:black"><td>' +
                        value.strPastelDescription + '</td><td>' +
                        value.decQtyPicked + '</td><td>' +
                        value.strPickerName + '</td><td>'+
                        value.OrderId + '</td><td>' +
                        value.SalesPerson + '</td><td>' +
                        value.Route + '</td><td>' +
                        value.OrderType + '</td><td>' +
                        value.StoreName + '</td><td>' +
                        value.EstimatedInstockQty + '</td><td>' +
                        value.DeliveryDate + '</td></tr>'
                        ;
                });
                $('#orderheaders').append(trHTML);

                $('#orderheaders tbody').on('click', 'tr', function (e){
                    $("#orderheaders tbody tr").removeClass('row_selectedYellowish');
                    $(this).addClass('row_selectedYellowish');
                });

                /*$('input[type="checkbox"]').on('change', function() {
                    $(this).siblings('input[type="checkbox"]').not(this).prop('checked', false);
                });*/
            }
        });

    }
    function getBooleanValue(cssSelector) {
        return document.querySelector(cssSelector).checked === true;
    }

    function numberParser(params) {
        var newValue = params.newValue;
        var valueAsNumber;
        if (newValue === null || newValue === undefined || newValue === '') {
            valueAsNumber = null;
        } else {
            valueAsNumber = parseFloat(params.newValue);
        }
        return valueAsNumber;
    }

    function onBtForEachNode() {
    }
    function printNode(node, index) {

        values.push({
            'ProductID': node.data.ProductID,
            'Price': node.data.Price,
            'Quantity': node.data.Quantity,
            'Cost': node.data.Cost,
            'strComment': node.data.strComment,
            'ID': node.data.ID,
            'strPartNumber': node.data.strPartNumber,
            'Authorised': node.data.BitAuthorised,

        });
    }
    function showDialog(tag,width,height)
    {
        $( tag ).dialog({height: height, modal: false,
            width: width,containment: false}).dialogExtend({
            "closable" : true, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class

                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });
    }
    $(document).on('dblclick', 'tr', function(e) {
        //checkid
        var orderid = $(this).closest('tr').find('.checkid').val();
        console.debug(orderid);
        var dialogthis = $('<p><strong style="color:red">Are you sure you want to delete this order?</strong></p>').dialog({
            height: 200, width: 700,modal: true,containment: false,
            buttons: {
                "YES": function () {
                    $.ajax({
                        url: '{!!url("/deleteRemoteOrder")!!}',
                        type: "POST",
                        data: {
                            ID: orderid
                        },
                        success: function (data) {

                            location.reload(true);
                        }
                    });
                },
                "NO": function () {
                    dialogthis.dialog('close');
                }
            }
        });
    });
</script>
</body>
</html>

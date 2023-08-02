<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
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
<body style="font-family: Sans-serif;background: #c5c2bf;">
<h2>Outstanding Online Orders </h2>

Orders Discount is <input type="text" id="orderdiscount" value="{{env('APP_ONLINE_MARGIN_PERCENTAGE')}}" readonly>
<div class="table-container">
    <div >
        <table id="orderheaders" class="table">
            <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Order Date</th>
                <th>Delivery Date</th>
                <th>Order Number</th>
                <th>User Name</th>
                <th>Notes</th>
                <th>Delivery Add</th>
                <th>Route</th>
                <th>AddressID</th>
                <th>O.OrderId</th>
                <th>Selected</th>

            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div>

        <input type="hidden" id="orderdate">
        <input type="hidden" id="deldate">
        <input type="hidden" id="ordernumber">
        <input type="hidden" id="username">
        <input type="hidden" id="notes">
        <input type="hidden" id="addressID">

    </div>
</div>

ACCOUNT SELECTED <input type="text" id="account">
<table style="display:none">
    <tr>
        <td valign="top">
            <label style="margin-right: 20px;">
                <input type="checkbox" id="columnGroups"/>
                Column groups
            </label>
            <br/>
            <label style="margin-right: 20px;">
                <input type="checkbox" id="useSpecificColumns"/>
                Specify Columns
            </label>
            <br/>
            <label style="margin-right: 20px;">
                <input type="checkbox" id="allColumns"/>
                All Columns
            </label>
            <br/>
            <label style="margin-right: 20px;">
                <input type="checkbox" id="onlySelected"/>
                Only Selected
            </label>
        </td>
        <td valign="top">
            <label style="margin-right: 20px;">
                <input type="checkbox" id="customHeader"/>
                Custom Header
            </label>
            <br/>
            <label style="margin-right: 20px;">
                <input type="checkbox" id="customFooter"/>
                Custom Footer
            </label>
            <br/>
            <label style="margin-right: 20px;">
                <input type="checkbox" id="skipHeader"/>
                Skip Header
            </label>
            <br/>
            <label style="margin-right: 20px;">
                <input type="checkbox" id="skipFooters"/>
                Skip Footers
            </label>
        </td>
        <td valign="top">
            <label style="margin-right: 20px;">
                <input type="checkbox" id="useCellCallback"/>
                Use Cell Callback
            </label>
            <br/>
            <label style="margin-right: 20px;">
                <input type="checkbox" id="suppressQuotes"/>
                Suppress Quotes
            </label>
            <br/>
            <label style="margin-right: 20px;">
                <input type="checkbox" id="skipGroups"/>
                Skip Groups
            </label>
            <br/>
            <label style="margin-right: 20px;">
                <input type="checkbox" id="skipGroupR"/>
                Skip Group R
            </label>
        </td>
        <td valign="top">
            <label style="margin-right: 20px;">
                <input type="checkbox" id="processHeaders"/>
                Format Headers
            </label>
            <br/>
            <label style="margin-right: 20px;">
                <input type="checkbox" id="skipPinnedTop"/>
                Skip Pinned Top
            </label>
            <br/>
            <label style="margin-right: 20px;">
                <input type="checkbox" id="skipPinnedBottom"/>
                Skip Pinned Bottom
            </label>
        </td>
    </tr>
</table>

<div style="display: flex">

    <div id="myGrid" style="height: 700px;width:95%;" class="ag-theme-balham"></div>

</div>


<script type="text/javascript" charset="utf-8">

    var gridOptions = {};
    var marg = 10;
    var hadMarginProblem = 0;
    var belowMarginProblem = [];

    var columnDefs = [
        {headerName: "Product ID", field: "ProductID",width: 180},
        {headerName: "Code", field: "strPartNumber",width: 100},
        {headerName: "Name", field: "strDesc",width: 300},
        {headerName: "Quantity", field: "Quantity",width: 150},
        {headerName: "OrgQty", field: "OrigQty",width: 150},
        {headerName: "Price", field: "Price",width: 100},
        {headerName: "Vat %", field: "Vat",width: 120},
        {headerName: "Vat Amount", field: "vatPrice",width: 150},
        {headerName: "Line Totals", field: "total",width: 100},
        {headerName: "Margin %", field: "Margin",width: 100,cellClassRules: {
                'rag-red': 'x < '+marg
            }},
        {headerName: "NO Issues", field: "Authorised",width: 150},
    ];

    // let the grid know which columns and what data to use
    var gridOptions = {
        columnDefs: columnDefs,
        floatingFilter: true,
        enableSorting: true,
        enableFilter: true,
        enableColResize: true
    };

    gridOptions.getRowStyle = function(params) {
        if (params.node.data.Margin< params.node.data.ProductMarginPercentage) {
            belowMarginProblem.push(params.node.data.strDesc);
        }
    }
    $(document).ready(function() {
        //$('#myGrid').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        retreiveorders();
//here
        $('#incompleted').click(function(){
            window.open('{!!url("/outstandingorders")!!}', 'outstandingorders', "location=1,status=1,scrollbars=1, width=1500,height=850");
        });


    });

    function retreiveorders()
    {
        $.ajax({
            url: '{!!url("/getFreshOrderHeadersOutstanding")!!}',
            type: "GET",
            data: {
            },
            success: function (data) {
                var trHTML = '';
                $('.fast_removeOrders').empty();
                $.each(data, function (key, value) {
                    trHTML += '<tr role="row" class="fast_removeOrders"  style="font-size: 13px;color:black"><td>' +
                        value.CustomerCode + '</td><td>' +
                        value.CustomerStoreName + '</td><td>' +
                        value.OrderDate + '</td><td><input type="text" class="deldateinfo" value="'+  value.DeliveryDate +'" id="deliverydate"'+  value.ID +'"> ' +
                        '</td><td>' +
                        value.OrderNumber + '</td><td>' +
                        value.UserName + '</td><td>' +
                        value.Notes + '</td><td>' +
                        value.CustomerAddress1 + '</td><td>' +
                        value.Route + '</td><td>' +
                        value.DeliveryAddressID + '</td><td>' +
                        value.OrigOrderID + '</td><td><input type="checkbox" class="checkid" value="'+  value.ID +'" id="ID"> ' +
                        '</td></tr>';
                });
                $('#orderheaders').append(trHTML);
                $(".checkid").change(function() {
                    var customerCode = $(this).closest('tr').find('td:eq(0)').text();
                    var Orderdate = $(this).closest('tr').find('td:eq(2)').text();
                    var deliverydate = $(this).closest('tr').find('.deldateinfo').val();
                    var orderNumber = $(this).closest('tr').find('td:eq(4)').text();
                    var userName = $(this).closest('tr').find('td:eq(5)').text();
                    var notes = $(this).closest('tr').find('td:eq(6)').text();
                    var addressID = $(this).closest('tr').find('td:eq(9)').text();


                    $('#account').val(customerCode);
                    $('#orderdate').val(Orderdate);
                    $('#deldate').val(deliverydate);
                    $('#ordernumber').val(orderNumber);
                    $('#username').val(userName);
                    $('#notes').val(notes);
                    $('#addressID').val(addressID);
                    $( "#myGrid" ).empty();
                    $('#myGrid').show();
                    // specify the columns
                    // lookup the container we want the Grid to use
                    var eGridDiv = document.querySelector('#myGrid');

                    // create the grid passing in the div to use together with the columns & data we want to use
                    new agGrid.Grid(eGridDiv, gridOptions);

                    var ids = $(this).val();
                    if($(this).is(":checked")) {
                        fetch('{!!url("/getOrderLines")!!}/' + ids ).then(function (response) {
                            return response.json();
                        }).then(function (data) {
                            gridOptions.api.setRowData(data);
                        });
                    }
                    // $('#textbox1').val($(this).is(':checked'));
                });
                $('#orderheaders tbody').on('click', 'tr', function (e){
                    $("#orderheaders tbody tr").removeClass('row_selectedYellowish');
                    $(this).addClass('row_selectedYellowish');
                });
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        console.log('### api.forEachNode() ###');
        values = new Array();
        gridOptions.api.forEachNode(this.printNode) ;
        console.debug(values);
        $.ajax({
            url: '{!!url("/Xmlcommitremoteorder")!!}',
            type: "POST",
            data: {
                value: values,
                custCode:$('#account').val(),
                orderdate:$('#orderdate').val(),
                deldate:$('#deldate').val(),
                ordernumber:$('#ordernumber').val(),
                username:$('#username').val(),
                notes:$('#notes').val(),
                addressID:$('#addressID').val(),
                orderdiscount:$('#orderdiscount').val()
            },
            success: function (data) {

                if(data.result =="SUCCESS"){

                    location.reload(true);
                }else {
                    var dialog = $('<p><strong style="color:black">'+data.result+'</strong></p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "Okay": function () {
                                dialog.dialog('close');
                            },

                        }
                    });
                }

            }
        });

        //but xml here
    }
    function printNode(node, index) {

        values.push({
            'ProductID': node.data.ProductID,
            'Price': node.data.Price,
            'Quantity': node.data.Quantity,
            'Cost': node.data.Cost,
            'strComment': node.data.strComment,
            'ID': node.data.ID,
        });
    }
</script>
</body>
</html>

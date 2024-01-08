<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
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
<h2>Orders To Release </h2>

<div class="table-container" style="height:360px">
    <div >
        <table id="orderheaders" class="table">
            <thead>
            <tr>
                <th>Code</th>
                <th>Store Name</th>
                <th>Delivery Date</th>
                <th>Order Id</th>
                <th>Created By</th>
                <th>Selected</th>

            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div>

        <input type="hidden" id="orderids">

    </div>
</div>

OrderID selected <input type="text" id="account">
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
    <div>
        <button onclick="onBtForEachNode()" class="btn-success btn-lg" id="commit">Authorize</button>
    </div>
</div>
<div title="Remote Orders Error" id="authRemoteOrder">
    <h3 id="errormsg"></h3>
    <form>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userauthproduct"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
            <input class="form-control col-md-4 auto-complete-off" id="userauthproduct" name="userauthproduct"  style="height:30px;font-size: 10px;"  autocomplete="off"></input>
        </div>
        <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthPassWord"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
            <input type="password" name="userAuthPassWord" class="form-control col-md-4 auto-complete-off" id="userAuthPassWord" style="height:30px;font-size: 10px;"   autocomplete="off">
        </div>

        <div class="form-group  col-md-12" >
            <div class="form-group  col-md-6" >
                <button type="button" id="doAuthLine" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Authorise</button>
            </div>
            <div class="form-group  col-md-6" >
                <button type="button" id="doCancelAuth" class="btn-danger btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">CANCEL</button>
            </div>
        </div>
    </form>
</div>
<style>
    .backgroudnormal{
        background:white !important;
    }
    .backgroudcolorbad{
        background: red !important ;
    }
</style>

<script type="text/javascript" charset="utf-8">

    var gridOptions = {};
    var marg = 10;
    var hadMarginProblem = 0;
    var belowMarginProblem = [];
// PastelDescription,PastelCode,Price,CostPrice,Cost,o.OrderId,StoreName,u.UserName,(1-(CostPrice/iif(Price=0,0.01,price)))*100 GP,DeliveryDate,CustomerPastelCode,od.ProductId
    var columnDefs = [
        {headerName: "Product ID", field: "ProductId",width: 180},
        {headerName: "Code", field: "PastelCode",width: 100},
        {headerName: "Name", field: "PastelDescription",width: 300},
        {headerName: "Quantity", field: "Quantity",width: 150},
        {headerName: "Price", field: "Price",width: 150},
        {headerName: "GP", field: "GP",width: 150},
    ];

    // let the grid know which columns and what data to use
    var gridOptions = {
        columnDefs: columnDefs,
        floatingFilter: true,
        enableSorting: true,
        enableFilter: true,
        enableColResize: true
    };

    $(document).ready(function() {
        $('#authRemoteOrder').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        retreiveorders();
    });

    function retreiveorders()
    {
        $.ajax({
            url: '{!!url("/getbelowgpheader")!!}',
            type: "GET",
            data: {
            },
            success: function (data) {
                var trHTML = '';
                $('.fast_removeOrders').empty();
                var classes = 'backgroudnormal';
                $.each(data, function (key, value) {

                    trHTML += '<tr role="row" class="fast_removeOrders '+classes+'"  style="font-size: 13px;color:black"><td>' +
                        value.CustomerPastelCode + '</td><td>' +
                        value.StoreName + '</td><td>' +
                        value.DeliveryDate + '</td><td>' +
                        value.UserName + '</td><td>' +
                        value.OrderId + '</td>' +
                        '<td><input type="checkbox" class="checkid" value="' +value.OrderId +'" id="ID">' +
                        '</td></tr>';
                });
                $('#orderheaders').append(trHTML);
                $(".checkid").change(function() {

                    var $val = $(this).val();

                    $('#orderids').val($val);
                    $('#account').val($val);
                    $( "#myGrid" ).empty();
                    $('#myGrid').show();
                    // specify the columns
                    // lookup the container we want the Grid to use
                    var eGridDiv = document.querySelector('#myGrid');

                    // create the grid passing in the div to use together with the columns & data we want to use
                    new agGrid.Grid(eGridDiv, gridOptions);

                    var ids = $(this).val();
                    if($(this).is(":checked")) {
                        fetch('{!!url("/getbelowgplines")!!}/' + ids ).then(function (response) {
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
        // console.debug(values);
        $.ajax({
            url: '{!!url("/postreleaseorder")!!}',
            type: "POST",
            data: {

                orderids:$('#orderids').val()

            },
            success: function (data) {
                console.debug(data);
                //  if (data.Result == "SUCCESS") {

                location.reload();
                //}


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

</script>
</body>
</html>

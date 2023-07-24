<!DOCTYPE html>
<html>
<head>
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
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

    </style>
</head>
<body style="font-family: Sans-serif">
<h2>Credit Requisition Report</h2>

<div style="padding-bottom: 4px;">
    <label>
        File Name:
        <input type="text" id="fileName"/>
    </label>
    <label style="margin-left: 20px;">
        Separator
        <input type="text" style="width: 20px;" id="columnSeparator" value=","/>
    </label>
    <label style="margin-left: 20px;">
        <button onclick="onBtExport()" style="background: #10f310;">Export to CSV</button>
    </label>
</div>

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
<div style="background: yellow;    padding: 15px;" >
    Date From <input id="datefrom1">
    Date To<input id="dateeto1">

    <button id="submit">Submit</button>
</div>

<div id="myGrid" style="height: 700px;width:95%;" class="ag-theme-balham"></div>
<hr>
<h4>Credit Requests Not Mapped To The Drivers Trip.</h4>
<div id="myGridwithbook" style="height: 700px;width:95%;" class="ag-theme-balham"></div>

<script type="text/javascript" charset="utf-8">
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).ready(function() {
        $('#myGrid').hide();
        $('#myGridwithbook').hide();
        $("#datefrom1").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });
        $("#dateeto1").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });

        /*$("#datefrom1", "#date11", "#datefrom2", "#date12").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });*/

    });
    var columnDefs = [ 
        {headerName: "OrderId", field: "OrderId",width: 90},
        {headerName: "Req No", field: "reqNo",width: 90},
        {headerName: "Invoice No", field: "InvoiceNo",width: 90},
        {headerName: "Created By", field: "UserName",width: 90},
        {headerName: "StoreName", field: "StoreName",width: 150},
        {headerName: "Customer Code", field: "CustomerPastelCode",width: 100},
        {headerName: "Item Code", field: "PastelCode",width: 100},
        {headerName: "Description", field: "PastelDescription",width: 200},
        {headerName: "Reason", field: "strCustomerReason",width: 100},
        {headerName: "Return Qty", field: "returnQty",width: 90},
        {headerName: "Qty", field: "Qty",width: 80},
        {headerName: "Dispatch Comments", field: "strDispatchComments",width: 180},
        {headerName: "Dispatch Auth By", field: "strDispatchReturnsAuthBy",width: 60},
        {headerName: "Credit Dept Comment", field: "strCreditDeptComment",width: 180},
        {headerName: "Credit Auth By", field: "strCreditReturnApprovedBy",width: 60},
        {headerName: "Route(Area)", field: "Route",width: 150},
        {headerName: "Type", field: "OrderType",width: 150},
        {headerName: "DeliveryDate", field: "DeliveryDate",width: 100},
        {headerName: "Reg No", field: "RegNo",width: 150},
        {headerName: "Driver Name", field: "DriverName",width: 150},
        {headerName: "Order Offloaded Time", field: "dteOffloadedTime",width: 100},
        {headerName: "Generated time", field: "dteLineRequisition",width: 100},
        {headerName: "OrderDetailId", field: "OrderDetailId",hide: true}

    ];
    var columnDefWithBook = [
        {headerName: "Customer Name", field: "strCustomerName",width: 180},
        {headerName: "Date Create", field: "dteDeliveryDate",width: 200},
        {headerName: "Product Name", field: "strProductName",width: 100},
        {headerName: "Quantity", field: "mnyQty",width: 90},
        {headerName: "Weights", field: "mnyWeights",width: 90},
        {headerName: "Notes", field: "strComment",width: 90},
        {headerName: "Signed By", field: "strSignedBy",width: 90},
        {headerName: "Email List", field: "strEmail",width: 90}


    ];
    // let the grid know which columns and what data to use
    var gridOptions = {
        columnDefs: columnDefs,
        floatingFilter: true,
        enableSorting: true,
        enableFilter: true,
        onRowDoubleClicked: doSomething,
        enableColResize: true
    };
    var gridOptionsWithBook = {
        columnDefs: columnDefWithBook,
        floatingFilter: true,
        enableSorting: true,
        enableFilter: true,
        enableColResize: true
    }

    gridOptions.rowStyle = {background: 'white'};
    gridOptions.getRowStyle = function(params) {
        console.debug(params.node.data.strDispatchReturnsAuthBy);
        console.debug(params.node.data.strCreditReturnApprovedBy);
        if (params.node.data.strDispatchReturnsAuthBy !="" && params.node.data.strCreditReturnApprovedBy =="") {
            return { background: '#aca9a9' }
        }
        if (params.node.data.strCreditReturnApprovedBy !="") {
            return { background: '#13e335' }
        }
    }

    var Odate = new Date();
    var newODate = $.datepicker.formatDate('yy-mm-dd', new Date(Odate));
    var eGridDiv = document.querySelector('#myGrid');
    var eGridDivWithBook = document.querySelector('#myGridwithbook');
    new agGrid.Grid(eGridDiv, gridOptions);
    new agGrid.Grid(eGridDivWithBook, gridOptionsWithBook);

    console.log(newODate);

    fetch('{!!url("/driverreq_reportJson")!!}/' + newODate + "/" + newODate).then(function (response) {
        return response.json();
    }).then(function (data) {
        gridOptions.api.setRowData(data);
    });

    fetch('{!!url("/creditNoteReasonsJSonWithBook")!!}/' + newODate + "/" + newODate).then(function (response) {
        return response.json();
    }).then(function (data) {
        gridOptionsWithBook.api.setRowData(data);
    });

    $('#submit').click(function () {
        $( "#myGrid" ).empty();
        $( "#myGridwithbook" ).empty();
        $('#myGrid').show();
        $('#myGridwithbook').show();
        // specify the columns

        // lookup the container we want the Grid to use
        var eGridDiv = document.querySelector('#myGrid');
        var eGridDivWithBook = document.querySelector('#myGridwithbook');
        new agGrid.Grid(eGridDiv, gridOptions);
        new agGrid.Grid(eGridDivWithBook, gridOptionsWithBook);

        var datefrom1 = $('#datefrom1').val();
        var dateto1 = $('#dateeto1').val();

        fetch('{!!url("/driverreq_reportJson")!!}/' + datefrom1 + "/" + dateto1).then(function (response) {
            return response.json();
        }).then(function (data) {
            gridOptions.api.setRowData(data);
        });
        fetch('{!!url("/creditNoteReasonsJSonWithBook")!!}/' + datefrom1 + "/" + dateto1).then(function (response) {
            return response.json();
        }).then(function (data) {
            gridOptionsWithBook.api.setRowData(data);
        });


    });
    function getBooleanValue(cssSelector) {
        return document.querySelector(cssSelector).checked === true;
    }
    function doSomething(row){
        console.log(row);
        console.log(row.data.OrderDetailId);
        var OrderDetailId = row.data.OrderDetailId;


        window.open('{!!url("/CreditDeptComment")!!}/'+OrderDetailId, OrderDetailId, "location=1,status=1,scrollbars=1, width=1200,height=850");

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
    function onBtExport() {
        var params = {
            skipHeader: getBooleanValue('#skipHeader'),
            columnGroups: getBooleanValue('#columnGroups'),
            skipFooters: getBooleanValue('#skipFooters'),
            skipGroups: getBooleanValue('#skipGroups'),
            skipPinnedTop: getBooleanValue('#skipPinnedTop'),
            skipPinnedBottom: getBooleanValue('#skipPinnedBottom'),
            allColumns: getBooleanValue('#allColumns'),
            onlySelected: getBooleanValue('#onlySelected'),
            suppressQuotes: getBooleanValue('#suppressQuotes'),
            fileName: document.querySelector('#fileName').value,
            columnSeparator: document.querySelector('#columnSeparator').value
        };

        if (getBooleanValue('#skipGroupR')) {
            params.shouldRowBeSkipped = function (params) {
                return params.node.data.country.charAt(0) === 'R';
            };
        }

        if (getBooleanValue('#useCellCallback')) {
            params.processCellCallback = function (params) {
                if (params.value && params.value.toUpperCase) {
                    return params.value.toUpperCase();
                } else {
                    return params.value;
                }
            };
        }

        if (getBooleanValue('#useSpecificColumns')) {
            params.columnKeys = ['country', 'bronze'];
        }

        if (getBooleanValue('#processHeaders')) {
            params.processHeaderCallback = function (params) {
                return params.column.getColDef().headerName.toUpperCase();
            };
        }

        if (getBooleanValue('#customHeader')) {
            params.customHeader = '[[[ This ia s sample custom header - so meta data maybe?? ]]]\n';
        }
        if (getBooleanValue('#customFooter')) {
            params.customFooter = '[[[ This ia s sample custom footer - maybe a summary line here?? ]]]\n';
        }

        gridOptions.api.exportDataAsCsv(params);
    }

</script>
</body>
</html>
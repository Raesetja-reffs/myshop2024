<!DOCTYPE html>
<html>
<head>
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css" />
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
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
        #productnames-flexdatalist{
            width: 350px;
        }
    </style>
</head>
<body style="font-family: Sans-serif">
<h2>SALES(NB No Credits Included) </h2>

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
    Delivery Date1<input id="datefrom1">
    Delivery Date2<input id="dateeto1">
    Product Name<input type="text" name="productnames" class="form-control input-md col-sm-12" id="productnames" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
    ID<input type="text" name="productnameId" class="input-md col-sm-1" id="productnameId" style="height:22px;font-size: 10px;font-weight: 900;    color: black;" readonly>

    <button id="submit">Submit</button>
</div>

<div id="myGrid" style="height: 700px;width:95%;" class="ag-theme-balham"></div>

<script type="text/javascript" charset="utf-8">
    var jArray = JSON.stringify({!! json_encode($products) !!});
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    var finalData =$.map(JSON.parse(jArray), function(item) {

        return {
            PastelDescription:item.PastelDescription,
            ProductId:item.ProductId,
        }

    });
    var productNames = $('#productnames').flexdatalist({
        minLength: 1,
        valueProperty: '*',
        selectionRequired: true,
        searchContain:true,
        focusFirstResult: true,
        visibleProperties: ["PastelDescription"],
        searchIn: 'PastelDescription',
        data: finalData
    });

    productNames.on('select:flexdatalist', function (event, data) {

        $('#productnameId').val(data.ProductId);
        $('#productnames').val(data.PastelDescription);
    });
    $(document).ready(function() {
        $('#myGrid').hide();
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
        {headerName: "Invoice No", field: "InvoiceNo",width: 90},
        {headerName: "OrderId", field: "OrderId",width: 90},
        {headerName: "Pastel Code", field: "PastelCode",width: 90},
        {headerName: "Pastel Description", field: "PastelDescription",width: 500},
        {headerName: "Order Date", field: "OrderDate"},
        {headerName: "Del Date", field: "DeliveryDate",width: 90},
        {headerName: "Qty", field: "Qty",width: 90},
        {headerName: "Price", field: "Price",width: 90},
        {headerName: "CostPrice", field: "CostPrice",width: 90},
        {headerName: "Comment", field: "Comment",width: 90},
        {headerName: "UnitOfSale", field: "UnitOfSale",width: 90},
        {headerName: "UserName", field: "UserName",width: 90},
    ];

    // let the grid know which columns and what data to use
    var gridOptions = {
        columnDefs: columnDefs,
        floatingFilter: true,
        enableSorting: true,
        enableFilter: true,
        enableColResize: true,
        onRowDoubleClicked: doSomething
    };
    $('#submit').click(function () {
        $( "#myGrid" ).empty();
        $('#myGrid').show();
        // specify the columns

        // lookup the container we want the Grid to use
        var eGridDiv = document.querySelector('#myGrid');

        // create the grid passing in the div to use together with the columns & data we want to use
        new agGrid.Grid(eGridDiv, gridOptions);

        var datefrom1 = $('#datefrom1').val();
        var dateto1 = $('#dateeto1').val();
        var productnameId = $('#productnameId').val();


        fetch('{!!url("/productbydatejson")!!}/' + datefrom1 + "/" + dateto1 + "/" + productnameId).then(function (response) {
            return response.json();
        }).then(function (data) {
            gridOptions.api.setRowData(data);
        });

        //onBtExport();

        //getBooleanValue(cssSelector);

    });
    function getBooleanValue(cssSelector) {
        return document.querySelector(cssSelector).checked === true;
    }
    function doSomething(row){
        console.log(row);
        console.log(row.data.CustomerPastelCode);
        var customer = row.data.CustomerPastelCode;
        var date = new Date();
        /*  var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
          var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
          var formattedfirst = $.datepicker.formatDate('yy-mm-dd', new Date(firstDay));
          var formattedlast = $.datepicker.formatDate('yy-mm-dd', new Date(lastDay));*/
        var datefrom1 = $('#datefrom1').val();
        var dateto1 = $('#dateeto1').val();
        var datefrom2 = $('#datefrom2').val();
        var dateto2 = $('#dateto2').val();
        window.open('{!!url("/customerupdatepricingfromcustomerssalespage")!!}/'+customer+"/"+datefrom1+"/"+dateto1+"/"+datefrom2+"/"+dateto2, customer, "location=1,status=1,scrollbars=1, width=1200,height=850");

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

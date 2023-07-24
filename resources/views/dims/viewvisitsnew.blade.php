<!DOCTYPE html>
<html>
<head>
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
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
<h2>Visits </h2>
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
    Date From <input id="datefrom">
    Date To <input id="dateeto">

    <button id="submit">Submit</button>
</div>

<div id="myGrid" style="height: 700px;width:95%;" class="ag-theme-balham"></div>

<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {
        $('#myGrid').hide();
        $("#datefrom").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });
        $("#dateeto").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });
    });
    var columnDefs = [
        {headerName: "Coordinates", field: "Coordinates",width: 90},
        {headerName: "No Of Orders", field: "NoOfOrders",width: 90},
        {headerName: "Mass Picked", field: "MassPicked",filter: 'agNumberColumnFilter',width: 90},
        {headerName: "Lines Picked", field: "LinesPicked",filter: 'agNumberColumnFilter'},
        {headerName: "Mass Loaded", field: "MassLoaded",filter: 'agNumberColumnFilter'},
        {headerName: "Lines Loaded", field: "LinesLoaded",filter: 'agNumberColumnFilter'},
        {headerName: "Total Mass", field: "TotalMass",filter: 'agNumberColumnFilter'},
        {headerName: "Total Lines", field: "TotalLines",width: 90}
    ];

    // let the grid know which columns and what data to use
    var gridOptions = {
        columnDefs: columnDefs,
        floatingFilter: true,
        enableSorting: true,
        enableFilter: true,
        enableColResize: true
    };
    $('#submit').click(function () {
        $( "#myGrid" ).empty();
        $('#myGrid').show();
        // specify the columns

        // lookup the container we want the Grid to use
        var eGridDiv = document.querySelector('#myGrid');

        // create the grid passing in the div to use together with the columns & data we want to use
        new agGrid.Grid(eGridDiv, gridOptions);

        var datefrom = $('#datefrom').val();
        var dateto = $('#dateeto').val();

        fetch('{!!url("/userpickingloadingperformancereportJson")!!}/' + datefrom + "/" + dateto ).then(function (response) {
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
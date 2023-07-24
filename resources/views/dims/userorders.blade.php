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


<h4 style="color: white;">Transactions For {{$name}}</h4>

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

    <input id="from" value="{{$from}}">
    <input id="to" value="{{$to}}">

    <select id="userid" >
        <option value="{{$userid}}" >{{$name}} </option>
        @foreach($listofusers as $val)
            <option value="{{$val->UserID}}" >{{$val->UserName}}</option>
         @endforeach
    </select>

    <button id="submit">Submit</button>
</div>
<div style="display: flex;">

<div id="myGrid" style="height: 700px;width:50%;" class="ag-theme-balham"></div>
<div id="lines" style="height: 700px;width:45%;" class="ag-theme-balham"></div>


</div>
Print:<input type="button" type="submit" id="orderid" value="NOTHING" >
</body>

<script type="text/javascript" charset="utf-8">
    $( document ).on( 'focus', ':input', function(){
        $(this).attr( 'autocomplete', 'off' );
    });
    var gridOptions = {};
    var gridOptionsLines = {};

    $(document).ready(function() {

        returngrid();

        $('#submit').click(function(){
            $( "#myGrid" ).empty();
            returngrid();
        });




    });
    function returngrid()
    {
        var dateFrom = $('#from').val();
        var to = $('#to').val();
        var userid = $('#userid').val();
        fetch('{!!url("/getUserOrders")!!}/'+dateFrom+"/"+to+"/"+userid,{'tableName': 'Tables'} ).then(function (response) {
            return response.json();
        }).then(function (data) {

            var columnDefs = [];
            $.each(data[0], function(k, v) {
                //display the key and value pair
                console.log(k + ' is ' + v);
                columnDefs.push({
                    "headerName": k,
                    "field": k,
                    "width": 200
                });
            });
            console.debug(columnDefs);
            var gridDiv = document.querySelector('#myGrid');
            gridOptions = {
                columnDefs: columnDefs,
                floatingFilter: true,
                enableSorting: true,
                enableFilter: true,
                enableColResize: true,
                onRowDoubleClicked: doSomething
            };
            new agGrid.Grid(gridDiv, gridOptions);

            gridOptions.api.setRowData(data);

            $('#dataloading').empty();

        });
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
    function getBooleanValue(cssSelector) {
        return document.querySelector(cssSelector).checked === true;
    }
    function doSomething(row){
        var OrderId = row.data.OrderId;
        $('#orderid').val(OrderId);
        $( "#lines" ).empty();


        fetch('{!!url("/userorderslines")!!}/'+OrderId ,{'tableName': 'Tables2'} ).then(function (response) {
            return response.json();
        }).then(function (data) {

            var columnDefs = [];
            $.each(data[0], function(k, v) {
                //display the key and value pair
                console.log(k + ' is ' + v);
                columnDefs.push({
                    "headerName": k,
                    "field": k,
                    "width": 130
                });
            });
            console.debug(columnDefs);
            var gridDiv = document.querySelector('#lines');
            gridOptionsLines = {
                columnDefs: columnDefs,
                floatingFilter: true,
                enableSorting: true,
                enableFilter: true,
                enableColResize: true,
                onRowDoubleClicked: doSomething
            };
            new agGrid.Grid(gridDiv, gridOptionsLines);

            gridOptionsLines.api.setRowData(data);

            $('#dataloading').empty();

        });

        $('#orderid').click(function(){

            var oID =   $('#orderid').val();
            window.open('{!!url("/pdforder")!!}/'+oID, oID, "location=1,status=1,scrollbars=1, width=1200,height=850");
        });
    }
</script>
</html>

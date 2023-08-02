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

    </style>
</head>
<body style="font-family: Sans-serif">
<h2>Print Barcodes</h2>

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
    <select id="pricelistname">
        @foreach($pricelistdata as $val)
            <option value="{{$val->PriceList}}">{{$val->PriceList}}</option>
            @endforeach
    </select>

    <button id="submit">Submit</button>
</div>

<div id="myGrid" style="height: 700px;width:95%;" class="ag-theme-balham"></div>
<button onclick="onBtForEachNode()" id="updatepricelists">Print B</button>

<script type="text/javascript" charset="utf-8">
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
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
        {headerName: "Item ID", field: "ProductId",width: 180},
        {headerName: "Item Code", field: "strPartNumber",width: 180},
        {headerName: "Item Description", field: "PastelDescription",width: 200},
        {headerName: "Price From", field: "decPriceFrom",width: 200},
        {headerName: "Price To", field: "decPriceTo",width: 200},
        {headerName: "Printed", field: "Printed",width: 200}
    ];

    // let the grid know which columns and what data to use
    var gridOptions = {
        columnDefs: columnDefs,
        floatingFilter: true,
        enableSorting: true,
        enableFilter: true,
        enableColResize: true,
        defaultColDef: {
            editable: true,
            resizable: true
        }
        //onRowDoubleClicked: doSomething

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


        fetch('{!!url("/listChangedProducts")!!}/' + datefrom1 + "/" + dateto1+ "/" + $('#pricelistname').val()).then(function (response) {
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

        var user = row.data.UserID;
        var UserName = row.data.UserName;
        var date = new Date();
        /*  var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
          var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
          var formattedfirst = $.datepicker.formatDate('yy-mm-dd', new Date(firstDay));
          var formattedlast = $.datepicker.formatDate('yy-mm-dd', new Date(lastDay));*/
        var datefrom1 = $('#datefrom1').val();
        var dateto1 = $('#dateeto1').val();


        window.open('{!!url("/userorders")!!}/'+datefrom1+"/"+dateto1+"/"+user+"/"+UserName, dateto1, "location=1,status=1,scrollbars=1, width=1200,height=850");

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
    function onBtForEachNode() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        console.log('### api.forEachNode() ###');
        values = new Array();
        gridOptions.api.forEachNode(this.printNode) ;

        //   console.debug(values);
        $.ajax({
            url: '{!!url("/printbulklabels")!!}',
            type: "POST",
            data: {
                griddetails: values

            },
            success: function (data) {
              alert("DONE!!");

            }
        });
        // console.debug(values) ;
    }
    function getBooleanValue(cssSelector) {
        return document.querySelector(cssSelector).checked === true;
    }
    // inScope[printNode]
    function printNode(node, index) {
        /*   if (node.group) {
               console.log(index + ' -> group: ' + node.key);
           } else {
               console.log(index + ' -> data: ' + node.data.PastelCode + ', ' + node.data.PastelDescription+ ', '+ node.data.Price + ', ' + node.data.Cost+ ', ' + node.data.Margin);
           }*/
        values.push({

            'id_': node.data.ProductId,
            'printed': node.data.Printed


        });
    }

</script>
</body>
</html>

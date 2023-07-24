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
<h2>Create New Price List </h2>
<label style="margin-left: 20px; float: right;">
    <button onclick="onBtExport()" style="background: #10f310;">Export Template</button>
</label>

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

    <button id="submit">GET</button>


</div>

<div id="myGrid" style="height: 700px;width:99%;" class="ag-theme-balham"></div>

<button onclick="onBtForEachNode()" id="updatepricelists">UPDATE</button>

<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {
        //$('#myGrid').hide();
        var values = new Array();
        $("#effectivedate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });/*
        $("#dateeto1").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });;*/


    });
    //select CustomerCode,CustomerStoreName,Email,UserName,CustomerRepresentitiveID from tblDIMSUSERS
    var columnDefs = [
        {headerName: "CustomerCode", field: "CustomerCode",width: 100},
        {headerName: "CustomerStoreName", field: "CustomerStoreName",width: 180},
        {headerName: "Email", field: "Email",width: 250},
        {headerName: "UserName", field: "UserName",width: 90 },//, valueGetter:'data.Cost/(1-(data.Margin/100))'
        {headerName: "CustomerRepresentitiveID", field: "CustomerRepresentitiveID",width: 90}
    ];

    // let the grid know which columns and what data to use
    var gridOptions = {
        columnDefs: columnDefs,

        defaultColDef: {
            editable: true,
            resizable: true
        },
        onCellEditingStopped: function (event) {
            console.log(event.data);
        },
        floatingFilter: true,
        enableSorting: true,
        enableFilter: true,
        enableColResize: true
    };
    $( "#myGrid" ).empty();
    $('#myGrid').show();

    var eGridDiv = document.querySelector('#myGrid');

    // create the grid passing in the div to use together with the columns & data we want to use
    new agGrid.Grid(eGridDiv, gridOptions);

    //before saving  getPriceListTemplate
    fetch('{!!url("/getWebstoreCustomers")!!}' ).then(function (response) {
        return response.json();
    }).then(function (data) {
        gridOptions.api.setRowData(data);
    });
    $('#submit').click(function () {
        $( "#myGrid" ).empty();
        $('#myGrid').show();
        var eGridDiv = document.querySelector('#myGrid');

        // create the grid passing in the div to use together with the columns & data we want to use
        new agGrid.Grid(eGridDiv, gridOptions);

        var newname = $('#newprice').val();
        var pricelist = $('#pricelist').val();
        var groups = $('#groups').val();
        var gp = $('#gp').val();
        var effectivedate = $('#effectivedate').val();
        //  var dateto1 = $('#dateeto1').val();


        fetch('{!!url("/getWebstoreCustomers")!!}').then(function (response) {
            return response.json();
        }).then(function (data) {
            gridOptions.api.setRowData(data);
        });


    });
    function onBtForEachNode() {
        console.log('### api.forEachNode() ###');
        return gridOptions.api.forEachNode(this.printNode);
    }
    function getBooleanValue(cssSelector) {
        return document.querySelector(cssSelector).checked === true;
    }
    // inScope[printNode]
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
            url: '{!!url("/updateWebstoremasterFileInfo")!!}',
            type: "POST",
            data: {
                value: values
            },
            success: function (data) {
                $( "#myGrid" ).empty();
                var eGridDiv = document.querySelector('#myGrid');
                new agGrid.Grid(eGridDiv, gridOptions);
                fetch('{!!url("/getListPriceListPrices")!!}/' + $('#pricelist').val() ).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    gridOptions.api.setRowData(data);
                });
            }
        });
        // console.debug(values) ;
    }
    function printNode(node, index) {
        if (node.group) {
            console.log(index + ' -> group: ' + node.key);
        } else {
            console.log(index + ' -> data: ' + node.data.CustomerCode + ', ' + node.data.CustomerStoreName+ ', '+ node.data.Email + ', ' + node.data.UserName+ ', ' + node.data.CustomerRepresentitiveID);
        }
        values.push({
            'CustomerCode': node.data.CustomerCode,
            'Email': node.data.Email,
            'UserName': node.data.UserName

        });
    }
    function NumericCellEditor() {
    }
    NumericCellEditor.prototype.isKeyPressedNavigation = function (event){
        return event.keyCode===39
            || event.keyCode===37;
    };

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
    function isFloatNumber(item,evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode==46)
        {
            var regex = new RegExp(/\./g)
            var count = $(item).val().match(regex).length;
            if (count > 1)
            {
                return false;
            }
        }
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
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
            fileName: 'pricelisttemplate',
            columnSeparator:","
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
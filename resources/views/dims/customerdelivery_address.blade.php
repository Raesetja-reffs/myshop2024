<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">

    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
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
<h2>Customer Address</h2>
<i style="display: none"><strong>Please double click on the First column to copy Address and history</strong></i><br>
<i>Please click on a cell and hit enter to change the Address</i>


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
    <button onclick="onAddRow()" style="display: none;">Add New Line</button>
    Account Code <input id="inputCustAcc" name="inputCustAcc" class="form-control input-sm col-xs-1" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
   Account Name<input id="inputCustName" name="inputCustName" class="form-control input-sm col-xs-1" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">

    <button id="submit">Submit</button>


</div>

<div id="myGrid" style="height: 450px;width:99%;" class="ag-theme-balham"></div>


<div id="exportsection" style="padding-bottom: 4px;float: right;">
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
<script type="text/javascript" charset="utf-8">
    var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
    $(document).ready(function() {
        var finalData =$.map(JSON.parse(jArrayCustomer), function(item) {

            return {
                BalanceDue:item.BalanceDue,
                CustomerPastelCode:item.CustomerPastelCode,
                StoreName:item.StoreName,
                UserField5:item.UserField5,
                CustomerId:item.CustomerId,
                CreditLimit:item.CreditLimit,
                Email:item.Email,
                Routeid:item.Routeid,
                Discount:item.Discount,
                OtherImportantNotes:item.OtherImportantNotes,
                Routeid:item.Routeid,
                strRoute:item.strRoute,
                mnyCustomerGp:item.mnyCustomerGp,
                Warehouse:item.Warehouse,
                ID:item.ID
            }

        });

        var inputCustNames = $('#inputCustName').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            focusFirstResult: true,
            searchContain:true,
            visibleProperties: ["StoreName","CustomerPastelCode"],
            searchIn: 'StoreName',
            data: finalData
        });
        inputCustNames.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
        });

        var inputCustAccount = $('#inputCustAcc').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'CustomerPastelCode',
            data: finalData
        });
        inputCustAccount.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);

        });

        $('#myGrid').hide();
        $('#exportsection').hide();
        $('#updatepricelists').hide();

        /* $("#datefrom1").datepicker({
             changeMonth: true,//this option for allowing user to select month
             changeYear: true, //this option for allowing user to select from year range
             dateFormat: 'yy-mm-dd'
         });
         $("#dateeto1").datepicker({
             changeMonth: true,//this option for allowing user to select month
             changeYear: true, //this option for allowing user to select from year range
             dateFormat: 'yy-mm-dd'
         });
 */

    });
    var values = new Array();
    var columnDefs = [
        {headerName: "DeliveryAddressId", field: "DeliveryAddressId",width: 90},
        {headerName: "DeliveryAddress1", field: "DeliveryAddress1",width: 300},
        {headerName: "DeliveryAddress2", field: "DeliveryAddress2",width: 180},
        {headerName: "DeliveryAddress3", field: "DeliveryAddress3",width: 250},
        {headerName: "DeliveryAddress4", field: "DeliveryAddress4",width: 180 },//, valueGetter:'data.Cost/(1-(data.Margin/100))'
        {headerName: "DeliveryAddress5", field: "DeliveryAddress5",width: 180}
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
        enableColResize: true, onRowDoubleClicked: doSomething
    };
    $('#submit').click(function () {
        $( "#myGrid" ).empty();
        $('#myGrid').show();
        $('#exportsection').show();
        $('#updatepricelists').show();
        var eGridDiv = document.querySelector('#myGrid');

        // create the grid passing in the div to use together with the columns & data we want to use
        new agGrid.Grid(eGridDiv, gridOptions);

        var inputCustAcc = $('#inputCustAcc').val();
        //  var dateto1 = $('#dateeto1').val();


        fetch('{!!url("/customerDeliveryAddress")!!}/' + inputCustAcc ).then(function (response) {
            return response.json();
        }).then(function (data) {
            gridOptions.api.setRowData(data);
        });




    });
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
            url: '{!!url("/postupdatecustomerAddress")!!}',
            type: "POST",
            data: {
                value: values,
                pricelistid:$('#pricelist').val()
            },
            success: function (data) {
                $( "#myGrid" ).empty();
                var eGridDiv = document.querySelector('#myGrid');
                new agGrid.Grid(eGridDiv, gridOptions);
                fetch('{!!url("/customerDeliveryAddress")!!}/' + $('#inputCustAcc').val() ).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    gridOptions.api.setRowData(data);
                });
            }
        });
        // console.debug(values) ;
    }
    var newCount = 1;
    function createNewRowData() {
        var newData = {
            DeliveryAddressId: "-999 " ,
            DeliveryAddress1: " " ,
            DeliveryAddress2: " ",
            DeliveryAddress3: " ",
            DeliveryAddress4: " ",
            DeliveryAddress5: " "
        };
        newCount++;
        return newData;
    }
    function onAddRow() {
        var newItem = createNewRowData();
        var res = gridOptions.api.updateRowData({add: [newItem]});
        printResult(res);
    }
    function getBooleanValue(cssSelector) {
        return document.querySelector(cssSelector).checked === true;
    }
    function doSomething(row){
        console.log(row);
        console.log(row.data.CustomerPastelCode);
        var DeliveryAddressId = row.data.DeliveryAddressId;
        var DeliveryAddress1 = row.data.DeliveryAddress1;
        var DeliveryAddress2 = row.data.DeliveryAddress2;
        var DeliveryAddress3 = row.data.DeliveryAddress3;
        var DeliveryAddress4 = row.data.DeliveryAddress4;
        var DeliveryAddress5 = row.data.DeliveryAddress5;
        var date = new Date();
        if (DeliveryAddress1.length < 1)
        {DeliveryAddress1 = '0';}
        if (DeliveryAddress5.length < 1) {DeliveryAddress5 = '0';}
        if (DeliveryAddress2.length < 1) {DeliveryAddress2 = '0';}
        if (DeliveryAddress3.length < 1) {DeliveryAddress3 = '0';}
        if (DeliveryAddress4.length < 1) {DeliveryAddress4 = '0';}

        window.open('{!!url("/selectCustomerAddressToUpdate")!!}/'+DeliveryAddressId+"/"+DeliveryAddress1+"/"+DeliveryAddress2+"/"+DeliveryAddress3+"/"+DeliveryAddress4+"/"+DeliveryAddress5+"/"+ $('#inputCustAcc').val(), DeliveryAddressId, "location=1,status=1,scrollbars=1, width=1200,height=850");

    }

    function printResult(res) {
        console.log('---------------------------------------')
        if (res.add) {
            res.add.forEach( function(rowNode) {
                console.log('Added Row Node', rowNode);
            });
        }
        if (res.remove) {
            res.remove.forEach( function(rowNode) {
                console.log('Removed Row Node', rowNode);
            });
        }
        if (res.update) {
            res.update.forEach( function(rowNode) {
                console.log('Updated Row Node', rowNode);
            });
        }
    }
    // inScope[printNode]
    function printNode(node, index) {

        values.push({

            'DeliveryAddressId': node.data.DeliveryAddressId,
            'DeliveryAddress1': node.data.DeliveryAddress1,
            'DeliveryAddress2': node.data.DeliveryAddress2,
            'DeliveryAddress3': node.data.DeliveryAddress3,
            'DeliveryAddress4': node.data.DeliveryAddress4,
            'DeliveryAddress5': node.data.DeliveryAddress5,

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
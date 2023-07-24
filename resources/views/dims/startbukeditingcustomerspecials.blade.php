<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
<h2>Bulk Editing </h2>
<p>Please Edit only Price ,DateFrom and DateTo columns</p>
<i>Before clicking Update button ,please move off the cell after editing so that the data can be committed</i>

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

   <input id="custcode" value="{{$custcode}}">
   <input id="datefrom" value="{{$datefrom}}">
   <input id="dateTo" value="{{$dateTo}}">

    <button id="submit">Submit</button>


</div>

<div id="myGrid" style="height: 700px;width:99%;" class="ag-theme-balham"></div>
<div id="bulkdate">
<fieldset class="well">
    <legend class="well-legend">NB :This will change all your date from and date to .Please note that you cannot undo all the changes after clicking update. </legend>
   <input type="checkbox" id="agree" style="height: 21px;width: 25px;">Agree that you are changing all the dates by using the below dates.<br>
Change Date From<input id="alterdatefrom" input="text" value="{{$datefrom}}">
Change Date To<input id="alterdateto" input="text" value="{{$dateTo}}">
<button onclick="onBtForEachNode()" id="updatepricelists">UPDATE</button>
</fieldset>
</div>
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

    $(document).ready(function() {

        $('#myGrid').hide();
        $('#bulkdate').hide();
        $('#exportsection').hide();
        $('#updatepricelists').hide();

        $("#alterdatefrom").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });
        $("#alterdateto").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });

    });
    //Date Editor
    function DateEditor () {}

    // gets called once before the renderer is used
    DateEditor.prototype.init = function(params) {
        // create the cell
        this.eInput = document.createElement('input');
        this.eInput.value = params.value;

        // https://jqueryui.com/datepicker/
        $(this.eInput).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true
        });
    };

    // gets called once when grid ready to insert the element
    DateEditor.prototype.getGui = function() {
        return this.eInput;
    };

    // focus and select can be done after the gui is attached
    DateEditor.prototype.afterGuiAttached = function() {
        this.eInput.focus();
        this.eInput.select();
    };

    // returns the new value after editing
    DateEditor.prototype.getValue = function() {
        return this.eInput.value;
    };

    // any cleanup we need to be done here
    DateEditor.prototype.destroy = function() {
        // but this example is simple, no cleanup, we could
        // even leave this method out as it's optional
    };

    // if true, then this editor will appear in a popup
    DateEditor.prototype.isPopup = function() {
        // and we could leave this method out also, false is the default
        return false;
    };
    var values = new Array();
    var columnDefs = [
        {headerName: "CustomerSpecialID", field: "CustomerSpecial",width: 10},
        {headerName: "CustId", field: "custIdOnALine",width: 10},
        {headerName: "OP", field: "OP",width: 10},
        {headerName: "ProductId", field: "ProductId",width: 50},
        {headerName: "Item Code", field: "PastelCode",width: 180},
        {headerName: "Item Name", field: "PastelDescription",width: 350},
        {headerName: "Price", field: "Price",width: 180},
        {headerName: "Date From", field: "Date",width: 250  ,cellRenderer: function(params) {
                return  '<i class="fa fa-calendar-o" aria-hidden="true"></i>'+params.value;
            },

            cellEditor: DateEditor},
        {headerName: "Date To", field: "DateTo",width: 90 ,cellRenderer: function(params) {
                return  '<i class="fa fa-calendar-o" aria-hidden="true"></i>'+params.value;
            },

            cellEditor: DateEditor },//, valueGetter:'data.Cost/(1-(data.Margin/100))'
        {headerName: "Cost", field: "Cost",width: 90},
        {headerName: "GP", field: "GP",width: 90, valueGetter:'(1-(data.Cost/data.Price))*100',filter: 'agNumberColumnFilter'},
        {headerName: "Cost Created With Special", field: "costCreated",width: 90, filter: 'agNumberColumnFilter'}
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
    $('#submit').click(function () {
        $( "#myGrid" ).empty();
        $('#myGrid').show();
        $('#bulkdate').show();
        $('#exportsection').show();
        $('#updatepricelists').show();
        var eGridDiv = document.querySelector('#myGrid');

        // create the grid passing in the div to use together with the columns & data we want to use
        new agGrid.Grid(eGridDiv, gridOptions);

        var pricelist = $('#pricelist').val();
        //  var dateto1 = $('#dateeto1').val();

        fetch('{!!url("/customerspecialsbulkediting")!!}/' + $('#custcode').val()+'/'+ $('#datefrom').val()+'/'+ $('#dateTo').val() ).then(function (response) {
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
            url: '{!!url("/XmlBulkEditingCustomerSpecials")!!}',
            type: "POST",
            data: {
                value: values
            },
            success: function (data) {
                $( "#myGrid" ).empty();
                var eGridDiv = document.querySelector('#myGrid');
                new agGrid.Grid(eGridDiv, gridOptions);
                fetch('{!!url("/customerspecialsbulkediting")!!}/' + $('#custcode').val()+'/'+ $('#datefrom').val()+'/'+ $('#dateTo').val() ).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    gridOptions.api.setRowData(data);
                });
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
        if ($('#agree').is(':checked')) {
            // Do something...
            values.push({

                'ProductId': node.data.ProductId,
                'custIdOnALine': node.data.custIdOnALine,
                'CustomerSpecial': node.data.CustomerSpecial,
                'Price': node.data.Price,
                'Date': $('#alterdatefrom').val(),
                'DateTo':$('#alterdateto').val()

            });
        }else {

            values.push({

                'ProductId': node.data.ProductId,
                'custIdOnALine': node.data.custIdOnALine,
                'CustomerSpecial': node.data.CustomerSpecial,
                'Price': node.data.Price,
                'Date': node.data.Date,
                'DateTo': node.data.DateTo

            });
        }
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
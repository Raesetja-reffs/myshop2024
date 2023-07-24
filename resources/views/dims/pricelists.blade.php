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
<h2>Price List Prices</h2>
<a href='{!!url("/createpricelist")!!}' onclick="window.open(this.href, 'creatingpricelist'+Math.random().toString(36).substring(7),
'left=30,top=20,width=1350,height=900,toolbar=1,resizable=0'); return false;" style="float:right;background: #007eff;padding: 1px;text-decoration: none;color: black;font-family: sans-serif;font-weight: 900;">Create New Price List</a>

<a href='{!!url("/deletepricelist")!!}' onclick="window.open(this.href, 'deletingpricelist'+Math.random().toString(36).substring(7),
'left=30,top=20,width=1350,height=900,toolbar=1,resizable=0'); return false;"  style="display:none;float:right;background: red;padding: 1px;text-decoration: none;color: black;font-family: sans-serif;font-weight: 900;">Delete Price List</a>

<a href='{!!url("/importexcelpricelist")!!}' onclick="window.open(this.href, 'importexcelpricelist'+Math.random().toString(36).substring(7),
'left=30,top=20,width=1350,height=900,toolbar=1,resizable=0'); return false;"  style="float:right;background: gray;padding: 1px;text-decoration: none;color: black;font-family: sans-serif;font-weight: 900;">Import Price List</a>


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
<div style="background: yellow;    padding: 15px;" class="col-lg-4"  >

    <div id="pricelistselection" class="col-lg-6 ">
        Choose Price List
        <select id="pricelist">
        @foreach($pricelist as $val)
            <option value="{{$val->PriceListId}}">{{$val->PriceList}}</option>
        @endforeach
        </select>
    </div>
    <div id="pricelistusedCage" class="col-lg-6 " >
        Choose Date<select id="pricelistused">

        </select>
        <button id="submit">Submit</button>
    </div>




</div>

<div id="myGrid" style="height: 700px;width:99%;" class="ag-theme-balham"></div>
Margin % <input type="number" name="margin" id="margin" value="0">
<button onclick="onBtForEachNode()" id="updatepricelists">UPDATE</button>

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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#myGrid').hide();
        $('#pricelistusedCage').hide();
        $('#exportsection').hide();
        $('#updatepricelists').hide();

        $("#pricelist").change(function () {
            var theVal = this.value;
            $.ajax({
                url: '{!!url("/getPriceListUsed")!!}',
                type: "POST",
                data: {
                    pricelistid:theVal
                },
                success: function (data) {

                    $('#pricelistused').empty();
                    $('#pricelistusedCage').show();
                    var trHTML = '';
                    $.each(data, function (key, value) {
                        trHTML += '<option value="' + value.PriceListUsedId + '" >' +value.Date + '</option>';

                    });
                    $('#pricelistused').append(trHTML);
                }
            });

        });

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
        {headerName: "Id", field: "ProductId",width: 100},
        {headerName: "Code", field: "PastelCode",width: 180},
        {headerName: "Description", field: "PastelDescription",width: 250},
        {headerName: "Price", field: "Price",width: 90 },//, valueGetter:'data.Cost/(1-(data.Margin/100))'
        {headerName: "Cost", field: "Cost",width: 90},
        {headerName: "Margin", field: "Margin",width: 90, valueGetter:'(1-(data.Cost/data.Price))rice*100',filter: 'agNumberColumnFilter'}
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
        $('#exportsection').show();
        $('#updatepricelists').show();
        var eGridDiv = document.querySelector('#myGrid');

        // create the grid passing in the div to use together with the columns & data we want to use
        new agGrid.Grid(eGridDiv, gridOptions);

        var pricelist = $('#pricelist').val();
        var pricelistused = $('#pricelistused').val();
      //  var dateto1 = $('#dateeto1').val();


        fetch('{!!url("/getListPriceListPrices")!!}/' + pricelist+'/'+pricelistused ).then(function (response) {
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
            url: '{!!url("/postupdatepricelistinfo")!!}',
            type: "POST",
            data: {
                value: values,
                pricelistid:$('#pricelist').val(),
                margin:$('#margin').val()
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

            'ProductId': node.data.ProductId,
            'Price': node.data.Price,
            'Cost': node.data.Cost

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
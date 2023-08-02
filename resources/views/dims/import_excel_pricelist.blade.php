<?php header('Access-Control-Allow-Origin: *'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('js/ag_grid_excel.js') }}"></script>
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
<h2>Price List Import</h2>


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





</div>

<input type="file" id="file-object">
<div id="result"></div>
<div id="myGrid" style="height: 700px;width:99%;" class="ag-theme-balham"></div>
<div id="namingbox" style="    background: #f5f1f1;">

   <select id="pricelisttype" name="pricelisttype" style="display: none">
       <option value="newpricelist">New Price List</option>
       <option value="overridepricelist">Override Price List</option>
       <option value="extendpricelist">Extend Price List</option>
   </select>
    <br>
    <div id="pricelistusedCage" class="col-lg-6 " style="display: none" >
        Choose Price List<select name="existinglists" id="existinglists">
            <option value="-9999">--Choose here--</option>
        @foreach($pricelist as $val)
            <option value="{{$val->PriceListId}}">{{$val->PriceList}}</option>
        @endforeach
    </select>
        Choose Date<select id="pricelistused">
            <option value="-99999999"></option>
        </select>
        <input id="extendpricelist" name="extendpricelist" >
    </div>
    <div id="brandnewlist" style="display: none">
        Name<input name="newprice" id="newprice" value="none" >
        Effective date <input id="effectivedate" value="1991-01-01">
    </div>
<button onclick="onBtForEachNode()" id="updatepricelists">SAVE</button>


</div>
<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       $("#effectivedate").datepicker({
             changeMonth: true,//this option for allowing user to select month
             changeYear: true, //this option for allowing user to select from year range
             dateFormat: 'yy-mm-dd'
         });

       $("#extendpricelist").datepicker({
             changeMonth: true,//this option for allowing user to select month
             changeYear: true, //this option for allowing user to select from year range
             dateFormat: 'yy-mm-dd'
         });

        $('#namingbox').hide();
        $('#existinglists').hide();
        $('#pricelistusedCage').hide();

        $("#pricelisttype").change(function () {
            var theVal = this.value;
            if(theVal =='overridepricelist')
            {
                $('#existinglists').show();
                $('#pricelistusedCage').show();
                $('#brandnewlist').hide();
            }
            if(theVal =='newpricelist')
            {
                $('#existinglists').hide();
                $('#pricelistusedCage').hide();
                $('#brandnewlist').show();
            }
            if(theVal =='extendpricelist')
            {
                $('#existinglists').show();
                $('#pricelistusedCage').show();
                $('#brandnewlist').hide();
                $('#extendpricelist').show();
            }
        });

        $("#existinglists").change(function () {
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


    });

    var pricelistDynamic = JSON.stringify({!! json_encode($pricelistnames) !!});
    var parser = JSON.parse(pricelistDynamic);
    var columns=new Array();



    // Example:


    // we expect the following columns to be present
    /*var alphabets = new Array();
    for(var i=0;i<parser.length;i++) {
        alphabets.push({
            parser: parser[i].PriceList,
            field:parser[i].PriceList,
            headerClass: 'grid-halign-left',
            width:180,
            filter: 'set',
        });
        console.debug(parser[i]);
    }*/
    //console.debug(parser.length);

    function coldef()
    {
        var productsLinesOnPickingOneOrder = new Array();

       /* productsLinesOnPickingOneOrder = [
        {headerName: "ProductId", field: "ProductId",width: 180},
        {headerName: "PastelCode", field: "PastelCode",width: 250},
        {headerName: "PastelDescription", field: "PastelDescription",width: 250},
        {headerName: "Cost", field: "Cost",width: 90 },//, valueGetter:'data.Cost/(1-(data.Margin/100))'

        ];*/

        for(var i=0;i<parser.length;i++) {
            productsLinesOnPickingOneOrder.push({
                headerName: parser[i].PriceList,
                field:parser[i].PriceList,
                width:180

            });
          //  console.debug(parser[i]);
        }
       // console.debug(productsLinesOnPickingOneOrder);
        return productsLinesOnPickingOneOrder;
    }
    document.getElementById('file-object').addEventListener("change", function(e) {
        var files = e.target.files,file;
        if (!files || files.length == 0) return;
        file = files[0];
        var fileReader = new FileReader();
        fileReader.onload = function (e) {
            var filename = file.name;
            console.debug(e);
            // call 'xlsx' to read the file
            var binary = "";
            var bytes = new Uint8Array(e.target.result);

            var length = bytes.byteLength;
            for (var i = 0; i < length; i++) {
                binary += String.fromCharCode(bytes[i]);
            }
            var oFile = XLSX.read(binary, {type: 'binary', cellDates:true, cellStyles:true});
            console.debug(oFile);

            var workbook = convertDataToWorkbook(bytes);

            populateGrid(workbook);
        };
        fileReader.readAsArrayBuffer(file);
    });
    $("form#data").submit(function(event){

        //disable the default form submission
        event.preventDefault();

        //grab all form data
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: '{!!url("/uploader")!!}',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (returndata) {
                alert(returndata);
                var data = new Uint8Array(returndata);
                console.debug(data);

             /*   var workbook = convertDataToWorkbook(returndata);
asset("uploads/your_file")
                populateGrid(workbook);*/
            makeRequest('GET',
                '{!!url('uploads')!!}/'+returndata,
                  //  'http://linxsystems.dedicated.co.za:8890/apks/pricelisttemplate.xlsx',
                    // success
                    function (data) {

                        var workbook = convertDataToWorkbook(data);

                        populateGrid(workbook);
                    },
                    // error
                    function (error) {
                        throw error;
                    }
                );
            }
        });

        return false;
    });

    var values = new Array();
   /* var columnDefs = [
        {headerName: "Id", field: "ProductId",width: 100},
        {headerName: "Code", field: "PastelCode",width: 180},
        {headerName: "Description", field: "PastelDescription",width: 250},
        {headerName: "Price", field: "Price",width: 90 },//, valueGetter:'data.Cost/(1-(data.Margin/100))'
        {headerName: "Cost", field: "Cost",width: 90},
        {headerName: "Margin", field: "Margin",width: 90, valueGetter:'(1-(data.Cost/data.Price))*100',filter: 'agNumberColumnFilter'}
    ];*/

    // let the grid know which columns and what data to use
    var gridOptions = {
        columnDefs: coldef(),

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

    function getBooleanValue(cssSelector) {
        return document.querySelector(cssSelector).checked === true;
    }
    // inScope[printNode]
    function printNode(node, index) {
        /*if (node.group) {
            console.log(index + ' -> group: ' + node.key);
        } else {
            //console.log(index + ' -> data: ' + node.data.PastelCode + ', ' + node.data.PastelDescription+ ', '+ node.data.Price + ', ' + node.data.Cost+ ', ' + node.data.Margin);
            values[index] = node.data
        }*/
        /*if (node.group) {
              console.log(index + ' -> group: ' + node.key);
          } else {
              //console.log(index + ' -> data: ' + node.data.PastelCode + ', ' + node.data.PastelDescription+ ', '+ node.data.Price + ', ' + node.data.Cost+ ', ' + node.data.Margin);
              values[index] = node.data
          }*/

        //  slut = node.data;
        //console.debug(node.data[0]);
        // values[index] = node.data;
        var obLen = Object.keys(node.data).length;
        var colmToExport = {};
        for(n = 0; n < obLen; n++) {
            //values[parser[n].PriceList]  = node.data+'.'+parser[n].PriceList;
            //console.debug(node.data.parser[n].PriceList);
            var colms = 'Col'+n;
            colmToExport[colms] = escapeHtml(node.data[Object.keys(node.data)[n]]);

        }
        values[index] = colmToExport;
//debugger;
        //console.debug( Object.keys(node.data));
        //console.debug( Object.keys(node.data).length);
        // console.debug( node.data[Object.keys(node.data)[0]]);
        /* values.push({

             'Id': node.data.Id,
             'Price': node.data.Price

         });*/

        // console.debug(node.data);
        //debugger;
        console.debug('+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++'+index);
        console.debug(values);
        // return node.data;
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

    //Excel import function


    // XMLHttpRequest in promise format
    function makeRequest(method, url, success, error) {
        var httpRequest = new XMLHttpRequest();
        httpRequest.open("GET", url, true);
        httpRequest.responseType = "arraybuffer";

        httpRequest.open(method, url);
        httpRequest.onload = function () {
            success(httpRequest.response);
        };
        httpRequest.onerror = function () {
            error(httpRequest.response);
        };
        httpRequest.send();
    }

    // read the raw data and convert it to a XLSX workbook
    function convertDataToWorkbook(data) {
        /* convert data to binary string */
        var data = new Uint8Array(data);
        var arr = new Array();

        for (var i = 0; i !== data.length; ++i) {
            arr[i] = String.fromCharCode(data[i]);
        }

        var bstr = arr.join("");

        return XLSX.read(bstr, {type: "binary"});
    }

    // pull out the values we're after, converting it into an array of rowData
    function orderKeys(obj, expected) {

        var keys = Object.keys(obj).sort(function keyOrder(k1, k2) {
            if (k1 < k2) return -1;
            else if (k1 > k2) return +1;
            else return 0;
        });

        var i, after = {};
        for (i = 0; i < keys.length; i++) {
            after[keys[i]] = obj[keys[i]];
            delete obj[keys[i]];
        }

        for (i = 0; i < keys.length; i++) {
            obj[keys[i]] = after[keys[i]];
        }
        return obj;
    }
    function populateGrid(workbook) {
        // our data is in the first sheet
        var firstSheetName = workbook.SheetNames[0];
        var worksheet = workbook.Sheets[firstSheetName];

     /*   columns[ 'A'] = 'ProductId';
        columns[ 'B'] = 'PastelCode';
        columns[ 'C'] = 'PastelDescription';
        columns[ 'D'] = 'Cost';*/

        console.debug(parser.length);
        var arr = new Array();
        for(n = 0; n < parser.length; n++) {
           // document.write(n + ":" + colName(n) + "<br>");
            var colm = colName(n);
            console.debug(colm +'----'+ parser[n].PriceList);
           columns[colm]  = parser[n].PriceList;
           // arr [n] = columns[n];
        }

        //console.log(arr);
        console.debug(columns);
       // var obj = orderKeys(columns);
        //console.debug(obj);

        var rowData = [];

        // start at the 2nd row - the first row are the headers
        var rowIndex = 2;

        // iterate over the worksheet pulling out the columns we're expecting
        while (worksheet['A' + rowIndex]) {
            var row = {};
            Object.keys(columns).forEach(function(column) {

                row[columns[column]] = worksheet[column + rowIndex].w;
            });

            rowData.push(row);

            rowIndex++;
        }
        // finally, set the imported rowData into the grid
        gridOptions.api.setRowData(rowData);
        $('#file-object').hide();
        $('#namingbox').show();

    }


    // specify the columns
    var columnDefs = [
        {headerName: "Id", field: "Id", width: 90},
        {headerName: "Code", field: "Code", width: 90},
        {headerName: "Description", field: "Description", width: 210},
        {headerName: "Price", field: "Price"},
        {headerName: "Cost", field: "Cost"},
        {headerName: "Margin", field: "Margin"},
    ];

    // no row data to begin with
    var rowData = [];

    // let the grid know which columns and what data to use
    var gridOptions = {
        columnDefs: coldef(),
        rowData: rowData,
        onGridReady: function () {
            gridOptions.api.sizeColumnsToFit();
        },
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

    function onBtForEachNode() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        console.log('### api.forEachNode() ###');
        //values = new Array();
        gridOptions.api.forEachNode(this.printNode) ;

           console.debug('==================================================================');
           var lenVal = values.length;

           console.debug($('#effectivedate').val());
           console.debug($('#existinglists').val());
           console.debug($('#pricelisttype').val());
           console.debug($('#pricelistused').val());
           console.debug("sluuttttttttttttttttttt");


        $.ajax({
            url: '{!!url("/savedatafromimport")!!}',
            type: "POST",
            data: {
                effectivedate:$('#effectivedate').val(),
                value: values,
                length: lenVal,
                newprice:$('#newprice').val(),
                existinglists:$('#existinglists').val(),
                pricelisttype:$('#pricelisttype').val(),
                pricelistused:$('#pricelistused').val()
            },
            success: function (data) {

                var dialog = $('<p><strong style="color:black">' + data[0].Result + '</strong></p>').dialog({
                    height: 200, width: 700, modal: true, containment: false,
                    buttons: {
                        "Okay": function () {

                           location.reload(true);
                        }
                    }
                });

            }
        });


    }
    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
    function printNode(node, index) {
           /*if (node.group) {
               console.log(index + ' -> group: ' + node.key);
           } else {
               //console.log(index + ' -> data: ' + node.data.PastelCode + ', ' + node.data.PastelDescription+ ', '+ node.data.Price + ', ' + node.data.Cost+ ', ' + node.data.Margin);
               values[index] = node.data
           }*/

      //  slut = node.data;
        //console.debug(node.data[0]);
       // values[index] = node.data;
        var obLen = Object.keys(node.data).length;

        var colmToExport = {};
        for(n = 0; n < obLen; n++) {
            //values[parser[n].PriceList]  = node.data+'.'+parser[n].PriceList;
            //console.debug(node.data.parser[n].PriceList);
            var colms = 'Col'+n;
            colmToExport[Object.keys(node.data)[n]] = escapeHtml(node.data[Object.keys(node.data)[n]]);
            //console.debug(Object.keys(node.data)[n]);//pricelist
            //console.debug(node.data[Object.keys(node.data)[n]])

        }


        values[index] = colmToExport;
//debugger;
        //console.debug( Object.keys(node.data));
        //console.debug( Object.keys(node.data).length);
       // console.debug( node.data[Object.keys(node.data)[0]]);
       /* values.push({

            'Id': node.data.Id,
            'Price': node.data.Price

        });*/

   // console.debug(node.data);
    //debugger;
        console.debug('+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++');
     console.debug(values);

       // return node.data;
    }
    function colName(n) {
        var ordA = 'A'.charCodeAt(0);
        var ordZ = 'Z'.charCodeAt(0);
        var len = ordZ - ordA + 1;

        var s = "";
        while(n >= 0) {
            s = String.fromCharCode(n % len + ordA) + s;
            n = Math.floor(n / len) - 1;
        }
        return s;
    }
    // wait for the document to be loaded, otherwise
    // ag-Grid will not find the div in the document.
    document.addEventListener("DOMContentLoaded", function () {

        // lookup the container we want the Grid to use
        var eGridDiv = document.querySelector('#myGrid');

        // create the grid passing in the div to use together with the columns & data we want to use
        new agGrid.Grid(eGridDiv, gridOptions);
    });


</script>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        th, td {
            text-align: left;
            border: 1px solid #dddddd;

        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }
        .table-container{
            height: 200px;
            overflow: scroll;
        }

        tr.row_selectedYellowish td{background-color:#91ff00 !important;}


    </style>
</head>
<body style="font-family: Sans-serif">
<h2>AWAITING AUTHORISATION</h2>

<br>
Orders Discount is <input type="text" id="orderdiscount" value="{{env('APP_ONLINE_MARGIN_PERCENTAGE')}}" readonly>
<div class="table-container" style="height:360px">
    <div >
        <table id="orderheaders" class="table">
            <thead>
            <tr>
                <th>CustomerCode</th>
                <th>CustomerName</th>
                <th>Order Id</th>
                <th>Order Value</th>
                <th>Order Date</th>
                <th>Delivery Date</th>
                <th>Actions</th>

            </tr>
            </thead>
            <tbody>
@foreach($customerorders as $val)
    <tr>
        <td>{{$val->CustomerPastelCode}}</td>
        <td>{{$val->StoreName}}</td>
        <td>{{$val->OrderId}}</td>
        <td>{{$val->ordervalue}}</td>
        <td>{{$val->OrderDate}}</td>
        <td>{{$val->DeliveryDate}}</td>
        <td><input type="checkbox" class="checkid" value="{{$val->OrderId}}" id="ID">
    </tr>
    @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <input type="hidden" id="OrderId" readonly>
    </div>
</div>

ACCOUNT SELECTED <input type="text" id="orderidselected" readonly><input type="submit" id="authorisethisaccount" value="NO ACCOUNT SELECTED" class="btn-primary btn-md">
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

<div style="display: flex">

    <div id="myGrid" style="height: 700px;width:65%;" class="ag-theme-balham"></div>


</div>
<div title="Remote Orders Error" id="authRemoteOrder">
    <h3 id="errormsg"></h3>
    <form>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userauthproduct"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label>
            <input class="form-control col-md-4 auto-complete-off" id="userauthproduct" name="userauthproduct"  style="height:30px;font-size: 10px;"  autocomplete="off"></input>
        </div>
        <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="userAuthPassWord"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label>
            <input type="password" name="userAuthPassWord" class="form-control col-md-4 auto-complete-off" id="userAuthPassWord" style="height:30px;font-size: 10px;"   autocomplete="off">
        </div>

        <div class="form-group  col-md-12" >
            <div class="form-group  col-md-6" >
                <button type="button" id="doAuthLine" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Authorise</button>
            </div>
            <div class="form-group  col-md-6" >
                <button type="button" id="doCancelAuth" class="btn-danger btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">CANCEL</button>
            </div>
        </div>
    </form>
</div>
<div title="ACCOUNT ON HOLD" id="authonholdaccount">
    <h2>PLEASE AUTHORIZE</h2>
    <form>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="onholdaccountmanagername"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Name</label><br>
            <input class="" id="onholdaccountmanagername" name="onholdaccountmanagername"  style="height:30px;font-size: 10px;"  autocomplete="off" value="-"></input>
        </div>
        <div class="form-group  col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="onholdaccountmanagerpassword"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">PassWord</label><br>
            <input type="password" name="onholdaccountmanagerpassword" class="" id="onholdaccountmanagerpassword" style="height:30px;font-size: 10px;"   autocomplete="off" value="-">
        </div><br>
        <div  >
            <button type="button" id="doAuthZeroonholdaccount" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Authorise</button>
        </div>
        <div class="form-group  col-md-12" >

            <div  >
                <fieldset>
                    <legend>NB :IF THE DELIVERY DATE OF THIS ORDER IS OLD ,PLEASE MAKE SURE YOU PUT THE CORRECT DATE.</legend>
                    <button type="button" id="treattheauthaccountasquotation" class="btn-danger btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Close Dialog</button>
                </fieldset>
            </div>
        </div>
    </form>

</div>


<script type="text/javascript" charset="utf-8">

    var gridOptions = {};
    var marg = 10;
    var hadMarginProblem = 0;
    var belowMarginProblem = [];

    var columnDefs = [
        {headerName: "Item Code", field: "PastelCode",width: 180},
        {headerName: "Description", field: "PastelDescription",width: 200},
        {headerName: "Qty", field: "Qty",width: 300},
        {headerName: "Price", field: "Price",width: 150},
        {headerName: "ProductId", field: "ProductId",width: 90,hide: true},
    ];

    // let the grid know which columns and what data to use
    var gridOptions = {
        columnDefs: columnDefs,
        floatingFilter: true,
        enableSorting: true,
        enableFilter: true,
        enableColResize: true
    };


    $(document).ready(function() {
        $('#authRemoteOrder').hide();
        $('#authonholdaccount').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".checkid").change(function() {
            //console.debug($(this).val());
            $( "#myGrid" ).empty();
            $('#myGrid').show();
            var eGridDiv = document.querySelector('#myGrid');

            // create the grid passing in the div to use together with the columns & data we want to use
            new agGrid.Grid(eGridDiv, gridOptions);
            var orderid = $(this).val();
            $('#orderidselected').val(orderid);
            $('#authorisethisaccount').val('AUTHORISE ' + orderid);
            if($(this).is(":checked")) {

                fetch('{!!url("/getoutstandingorderstoauthjson")!!}/' + orderid ).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    gridOptions.api.setRowData(data);
                });
            }
        });
//here

        $('#authorisethisaccount').click(function(){
            authoriseonholdaccount();
        });

    });

    function retreiveorders()
    {
        $.ajax({
            url: '{!!url("/getFreshOrderHeaders")!!}',
            type: "GET",
            data: {
            },
            success: function (data) {
                var trHTML = '';
                $('.fast_removeOrders').empty();
                $.each(data, function (key, value) {
                    trHTML += '<tr role="row" class="fast_removeOrders"  style="font-size: 13px;color:black"><td>' +
                        value.CustomerCode + '</td><td>' +
                        value.CustomerStoreName + '</td><td>' +
                        value.OrderDate + '</td><td><input type="text" class="deldateinfo" value="'+  value.DeliveryDate +'" id="deliverydate"'+  value.ID +'"> ' +
                        '</td><td>' +
                        value.OrderNumber + '</td><td>' +
                        value.UserName + '</td><td>' +
                        value.Notes + '</td><td>' +
                        value.CustomerAddress1 + '</td><td>' +
                        value.Route + '</td><td>' +
                        value.DeliveryAddressID + '</td><td>' +
                        value.OrigOrderID + '</td><td><input type="checkbox" class="checkid" value="'+  value.ID +'" id="ID"> <input type="hidden" class="hiddenUserName" value="'+  value.UserName +'" id="hiddenUserName">' +
                        '</td></tr>';
                });
                $('#orderheaders').append(trHTML);
                $(".checkid").change(function() {
                    var customerCode = $(this).closest('tr').find('td:eq(0)').text();
                    var Orderdate = $(this).closest('tr').find('td:eq(2)').text();
                    var deliverydate = $(this).closest('tr').find('.deldateinfo').val();
                    var orderNumber = $(this).closest('tr').find('td:eq(4)').text();
                    var userName = $(this).closest('tr').find('td:eq(5)').text();
                    var notes = $(this).closest('tr').find('td:eq(6)').text();
                    var addressID = $(this).closest('tr').find('td:eq(9)').text();
                    var hiddenUserName = $(this).closest('tr').find('.hiddenUserName').val();
                    //console.debug(hiddenUserName);

                    //$(this).siblings('input[type="checkbox"]').not(this).prop('checked', false);
                    $('#account').val(customerCode);
                    $('#orderdate').val(Orderdate);
                    $('#deldate').val(deliverydate);
                    $('#ordernumber').val(orderNumber);
                    $('#username').val(hiddenUserName);
                    $('#notes').val(notes);
                    $('#addressID').val(addressID);
                    $( "#myGrid" ).empty();
                    $('#myGrid').show();
                    // specify the columns
                    // lookup the container we want the Grid to use
                    var eGridDiv = document.querySelector('#myGrid');

                    // create the grid passing in the div to use together with the columns & data we want to use
                    new agGrid.Grid(eGridDiv, gridOptions);

                    var ids = $(this).val();
                    if($(this).is(":checked")) {
                        fetch('{!!url("/getOrderLines")!!}/' + ids ).then(function (response) {
                            return response.json();
                        }).then(function (data) {
                            gridOptions.api.setRowData(data);
                        });
                    }

                    // $('#textbox1').val($(this).is(':checked'));
                });
                $('#orderheaders tbody').on('click', 'tr', function (e){
                    $("#orderheaders tbody tr").removeClass('row_selectedYellowish');
                    $(this).addClass('row_selectedYellowish');
                });

                /*$('input[type="checkbox"]').on('change', function() {
                    $(this).siblings('input[type="checkbox"]').not(this).prop('checked', false);
                });*/
            }
        });

    }
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

    function onBtForEachNode() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        console.log('### api.forEachNode() ###');
        values = new Array();
        gridOptions.api.forEachNode(this.printNode) ;
        console.debug(values);
        $.ajax({
            url: '{!!url("/Xmlcommitremoteorder")!!}',
            type: "POST",
            data: {
                value: values,
                custCode:$('#account').val(),
                orderdate:$('#orderdate').val(),
                deldate:$('#deldate').val(),
                ordernumber:$('#ordernumber').val(),
                username:$('#username').val(),
                notes:$('#notes').val(),
                addressID:$('#addressID').val(),
                orderdiscount:$('#orderdiscount').val()
            },
            success: function (data) {

                console.debug(data);
                $.each(data, function (key, value) {
                    console.debug("if "+value.Result);
                    if (value.Result == "SUCCESS") {

                        //Orderid

                        $.ajax({
                            url: '{!!url("/updateOnlineLinesAndHeaders")!!}',
                            type: "POST",
                            data: {
                                Orderid: value.Orderid,
                                ID: value.ID
                            },
                            success: function (data) {

                                console.debug("API");
                                console.debug(data);
                                console.log(data);

                                $.ajax({
                                    url: '{!!url("/testAPI")!!}',
                                    type: "POST",
                                    data: {
                                        Orderid: value.Orderid,
                                        ID: value.ID,
                                        lists:data
                                    },
                                    success: function (data) {

                                    }
                                });
                                /* var settings = {
                                     "async": true,
                                     "crossDomain": true,
                                     "url": "http://stage-sifu.ufs.com:80/ecom/order/feedback/",
                                     "method": "POST",

                                     "headers": {
                                         "Content-Type": "application/json",
                                         "x-api-key": "11mG1mr1JwsOXM5DpxKZJGXSkJK7TrmuoyPO0ns5",

                                         "Cache-Control": "no-cache",
                                         "Accept-Encoding": "gzip, deflate",
                                         "Content-Length": "130",
                                         "Connection": "keep-alive",
                                         "cache-control": "no-cache"
                                     },
                                     "processData": false,
                                     "data": {"transactionId":"aff5e290-fd80-4270-bfcf-d489220c0343","liteApiEnabled":false,"lineItems":[{"ean":"6001087308847","quantity":1}]}
                                 };

                                 $.ajax(settings).done(function (response) {
                                     console.log(response);
                                 });*/


                                location.reload(true);
                            }
                        });

                        //
                    } else {
                        //PartNumber

                        console.debug("***************************************");
                        console.debug(value.Result);
                        console.debug("--------------------------------------");
                        $('#errormsg').empty();
                        $('#errormsg').append(value.Result);
                        $('#authRemoteOrder').show();
                        showDialog('#authRemoteOrder', 600, 350);

                        $('#doAuthLine').off().click(function () {

                            $.ajax({
                                url: '{!!url("/AuthExternaOrders")!!}',
                                type: "POST",
                                data: {
                                    userName: $('#userauthproduct').val(),
                                    userPassword: $('#userAuthPassWord').val(),
                                    type: 'Auth Import Of Orders',
                                    ID: value.ID,
                                    code: value.PartNumber,
                                },
                                success: function (data) {

                                    if ($.isEmptyObject(data)) {
                                        alert("Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                                    } else {
                                        $('#userauthproduct').val('');
                                        $('#userAuthPassWord').val('');
                                        console.debug(data);
                                        $("#authRemoteOrder").dialog('close');
                                        $('#commit').click();

                                    }
                                }
                            });

                        });
                        $('#doCancelAuth').click(function () {
                            location.reload(true);
                        });
                    }
                });

                //Feed back loop here


            }
        });

        //but xml here
    }
    function printNode(node, index) {

        values.push({
            'ProductID': node.data.ProductID,
            'Price': node.data.Price,
            'Quantity': node.data.Quantity,
            'Cost': node.data.Cost,
            'strComment': node.data.strComment,
            'ID': node.data.ID,
            'strPartNumber': node.data.strPartNumber,
            'Authorised': node.data.BitAuthorised,

        });
    }
    function showDialog(tag,width,height)
    {
        $( tag ).dialog({height: height, modal: false,
            width: width,containment: false}).dialogExtend({
            "closable" : true, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class

                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });
    }
    $(document).on('dblclick', 'tr', function(e) {

    });
    function authoriseonholdaccount()
    {
        $('#authonholdaccount').show();

        $( "#authonholdaccount" ).dialog({height: 800, modal: true, closeOnEscape: false,
            width: 800,containment: false}).dialogExtend({
            "closable" : false, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class
                "close" : "ui-icon-circle-close",
                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });

        $('#authonholdaccount').keydown(function(event) {
            if (event.keyCode == 27){
                return false;
            }
        });
        $('#treattheauthaccountasquotation').off().click(function(){

            $('#authonholdaccount').dialog('close');

        });
        $('#doAuthZeroonholdaccount').off().click(function(){

            $('#onholdaccountmanagerpassword').val();
            $.ajax({
                url: '{!!url("/verifyAuthCreditors")!!}' ,
                type: "POST",
                data:{userName:$('#onholdaccountmanagername').val(),
                    userPassword:$('#onholdaccountmanagerpassword').val(),
                    OrderId:$('#orderidselected').val()},
                success: function(data){

                    if (data.done=="DONE") {
                        $('#onholdaccountmanagername').val('');
                        $('#onholdaccountmanagerpassword').val('');

                        consoleManagementAuths('{!!url("/logMessageAjax")!!}', 12, 1, 'Account on hold-USING VIEW authorised by ' + data.result[0].UserName,
                            0, $('#orderidselected').val(), 0, '', 0, 0, 0, $('#onholdaccountmanagername').val(), $('#orderidselected').val(), 0, '', $('#orderidselected').val(), 0, data.result[0].UserID, data.result[0].UserName);
                        $("#authonholdaccount").dialog('close');
                       // allInoneDocumentsave("NO");
                        location.reload(true);
                    }else
                    {
                        alert("SOMETHING WENT WRONG,PLEASE TRY AGAIN ");
                    }
                }
            });

        });

    }
    function consoleManagementAuths(url,ConsoleTypeId,Importance,Message,Reviewed,OrderId,productid,
                                    CustomerId,OldQty,NewQty,OldPrice,NewPrice,ReferenceNo,DocType,machine,DocNumber,ReturnId,userId,userName)
    {
        $.ajax({
            url:url,
            type: "POST",
            data:{ConsoleTypeId:ConsoleTypeId,
                Importance:Importance,
                Message:Message,
                Reviewed:Reviewed,
                OrderId:OrderId,
                productid:productid,
                CustomerId:CustomerId,
                OldQty:OldQty,
                NewQty:NewQty,
                ReviewedUserId:0,
                OldPrice:OldPrice,
                NewPrice:NewPrice,
                ReferenceNo:ReferenceNo,
                DocType:DocType,
                DocNumber:DocNumber,
                machine:machine,
                ReturnId:ReturnId,
                userId:userId,
                userName:userName,

            },
            success: function(data){
                // dd(data);
                //Try to use web sql
            }});

    }
</script>
</body>
</html>

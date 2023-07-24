<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <link href="{{ asset('css/grid.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
<div class="col-lg-12" style="background: white;">
    <div class="col-lg-2" style="height: 700px;overflow-y: scroll">
       <input type="text"  id="deliverydate" value="{{$deldate}}"><button class="btn-primary" id="searchdeliverydate">Search</button>
        <table class="table2 table-bordered" id="routinglist" style="overflow-y: auto;width:100%" tabindex=0>
            <thead>
            <tr>
                <th>RoutingID</th>
                <th>Route</th>
                <th>O.Type</th>
                <th>Driver</th>

            </tr>
            </thead>

        </table>
    </div>
    <div class="col-lg-8" style="height: 700px;">
        <object type="application/pdf" id="pdf_object" style="width:100%; min-height:400px; height:100%;"></object>
    </div>
    <div class="col-lg-2" style="height: 700px; background: cornsilk;overflow-y: scroll">
        <a href='{!!url("/getCashCollected")!!}'  onclick="window.open(this.href, 'getCashCollected',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Cash Collected</a>
        <div class="col-lg-12" style="height:200px;">
            <input type="text" id="searchinvoice" placeholder="Invoice Number" >
            <button id="search"  class="btn-success">Search</button>
            <br>
            <div id="searchedresult">

            </div>
        </div>
        <div class="col-lg-12" style="background:red; color: black;">
            <h5>Use Routing Id Below</h5>
            <input type="text" id="searchTripsid"  >
            <button id="submittripsheet"  class="btn-primary">Search</button>
            <br>
            <div >

                <table id="sheetresulttrip">

                    <thead><tr>
                        <th></th>
                        <th></th>
                        <th>Invoice Number</th>

                    </tr></thead>
                    <tbody id="tblsheetresulttrip">

                    </tbody>
                </table>
                <input type="button" id="savepodtoaccounting" class="btn-xs btn-success" value="Post Selected POD">
            </div>
        </div>
    </div>

</div>
<div class="col-lg-12" style="background: #f7f5f5;height: 270px;">
    <div  class="col-lg-4">
        <h5 id="cashPaid" style="color:red"></h5>
        <div id="notes">

        </div>

    </div>
    <div  class="col-lg-4" style="height: 300px;overflow-y: scroll" >
        <table class="table2 table-bordered" id="items" style="overflow-y: auto;width:100%" tabindex=0>
            <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Original Qty</th>
                <th>Return Qty</th>
                <th>Reason</th>
            </tr>
            </thead>

        </table>


    </div>
    <div class="col-lg-4">
        <input type="text"  id="deliverydatesigned" value="{{$deldate}}"><button class="btn-primary" id="searchdeliverydateinvoicessugnedaround">Invoices Signed Around</button>
        <div id="signedaroundpremises">

        </div>
    </div>

</div>

<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#deliverydatesigned").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $("#deliverydate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });


        $(".pdfs").click(function () {
            var fired_button = $(this).val();
            var invbutton = $(this).text();
            $('#items').empty();
            $('#pdf_object').attr('data', 'data:application/pdf;base64,' + fired_button);

            returnsubdata(invbutton);
        });
        returnroutingIDs();
        $("#searchdeliverydate").click(function () {
            returnroutingIDs();
        });

        //
        $("#search").click(function () {
            $.ajax({
                url: '{!!url("/driverspdfdocsByInv")!!}',
                type: "POST",
                dataType: 'json',
                data: {
                    InvocieNo: $('#searchinvoice').val()
                },
                success: function (data) {
                    console.debug(data);
                   // $('#savepodtoaccounting').Show();
                    var trHTML = '';
                    var driverLoaders = '';
                   // $('#searchedresult').empty();
                    $('#tblsheetresulttrip').empty();
                    $('#searchedresult').empty();
                    trHTML += '<i>Search result</i><br>';
                    $.each(data.pdfdocs, function (key, value) {
                        trHTML += '<tr role="row"  style="font-size: 11px;color:black"><td>' +
                            '<input type="checkbox" name="checkproduct[]" value="' + value.strDocNumber + '" class="invoiceDocsii"    >' +'</td><td>' +
                            '<button class="pdfs" value="' + value.strPDF + '">' + value.strDocNumber +"-"+ value.strDocumentType + '</button></td>' +
                            '<td>' + value.strDocNumber + '</td>' +
                            '</tr>';
                        driverLoaders = 'Driver Name ' + value.DriverName + ' :LD ' + value.strLoadedBy;
                       // trHTML += '<br><h4>Driver Name ' + value.DriverName + ' :LD ' + value.strLoadedBy + '</h4><br>';
                    });

                    $('#tblsheetresulttrip').append(trHTML);
                    $('#searchedresult').append(driverLoaders);

                    $.each(data.pdfdocsrequ, function (key, value) {
                        trHTML += '<br><i>Credit Requisition</i><br>';
                        trHTML += '<tr role="row"  style="font-size: 11px;color:black"><td>' +
                            '<button class="pdfs" value="' + value.strPDF + '">' + value.strDocNumber + '</button></td>' +
                            '</tr>';
                    });

                    $('#searchedresult').append(trHTML);
                    $(".pdfs").click(function () {
                        var fired_button = $(this).val();
                        $('#items').empty();
                        $('#pdf_object').attr('data', 'data:application/pdf;base64,' + fired_button);
                        returnsubdata($(this).text());
                    });
                }
            });
        });

        $("#submittripsheet").click(function () {
            $.ajax({
                url: '{!!url("/driverspdfdocsBytripsheet")!!}',
                type: "POST",
                dataType: 'json',
                data: {
                    routingId: $('#searchTripsid').val()
                },
                success: function (data) {
                    console.debug(data.pdfdocs);
                  //  $('#savepodtoaccounting').Show();
                    var trHTML = '';
                    $('#sheetresulttrip').empty();
                    var cashpaid = 0;
                    var driverName = '';
                    var loader = '';
                    var isInvoiceCheck = '';
                    trHTML += '<i>Search result</i><br>';
                    $.each(data.pdfdocs, function (key, value) {
                        if(value.cashdealtwithit == 1){
                            isInvoiceCheck = 'checked';
                        }
                        console.debug("is checked"+value.cashdealtwithit);
                        trHTML += '<tr role="row"  style="font-size: 11px;color:black"><td>' +
                            '<input type="checkbox" name="checkproduct[]" value="' + value.strDocNumber + '" class="invoiceDocs"'+   isInvoiceCheck+' >' +'<td></td>' +
                            '<button class="pdfs" value="' + value.strPDF + '">' + value.strDocNumber + '</button></td>' +
                            '<td><button class="docMessage" value="' + value.strDocNumber + '">Message</button></td>' +
                            '</tr><br>';
                        driverName = value.DriverName;
                        loader = value.strLoadedBy;
                        isInvoiceCheck = '';

                    });

                    trHTML += '';
                    trHTML += '<h5 style="color:white;">PAID(CASH)</h5><br>';

                    $.each(data.pdfdocspaid, function (key, value) {
                        trHTML += '<tr role="row"  style="font-size: 11px;color:black"><td>' +
                            '<button class="pdfs" class="btn-primary" value="' + value.strPDF + '">' + value.strDocNumber + '</button></td>' +

                            '</tr><br>';
                        console.log("*****" + value.mnyDriverCash);
                        cashpaid = parseFloat(value.mnyDriverCash);

                    });
                    trHTML += '<h5 style="color:white;font-weight:900;font-weight:900;">TOTAL = ' + cashpaid + '</h5><br>';
                    trHTML += '<h5 style="color:white;">Credit Requisition</h5><br>';
                    $.each(data.pdfdocrequisition, function (key, value) {
                        trHTML += '<tr role="row"  style="font-size: 11px;color:black"><td>' +
                            '<button class="pdfs" class="btn-primary" value="' + value.strPDF + '">' + value.strDocNumber + '</button></td>' +
                            '</tr><br>';
                    });
                    trHTML += '<h5 style="color:white;font-weight:900;">Driver ' + driverName + ' <br>:LD ' + loader + '</h5><br>';
                    $('#sheetresulttrip').append(trHTML);


                    $(".pdfs").click(function () {
                        var fired_button = $(this).val();

                        $('#items').empty();
                        $('#pdf_object').attr('data', 'data:application/pdf;base64,' + fired_button);
                        returnsubdata($(this).text());
                    });
                    $(".docMessage").click(function () {
                        var orderIdClicked = $(this).val();
                        window.open('{!!url("/cashupscheckinvoice")!!}/'+orderIdClicked, 'orderIdClicked'+orderIdClicked,
                            'left=100,top=100,width=800,height=400,toolbar=1,resizable=0');
                    });

//ischeckedcash

                }
            });
        });


        $('#savepodtoaccounting').click(function(){
            var valuesProd = new Array();
            var customerId = $('#customerId').val();

            alert("test");
            $.each($("input[name='checkproduct[]']:checked"),
                function () {
                    var data = $(this).parents('tr:eq(0)');


                    var codeID =$(this).val(); //data.find('.invoiceDocs').val();
                    console.debug("codeID+++++++"+codeID);
                    //  console.debug( data);
                    // var datefrom = data.find('td:eq(4)').text();
                    // var dateto = data.find('td:eq(5)').text();

                    valuesProd.push({'invoiceNo':codeID});
                });
            $.ajax({
                url: '{!!url("/postPODSToTheAccounting")!!}',
                type: "POST",
                data: {
                    checkedInvoices: valuesProd
                },
                success: function (data) {

                    var dialog = $('<p>Done</p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": function () {
                                location.reload(true);

                            }
                        }
                    });

                }
            });
        });
        $("#searchdeliverydateinvoicessugnedaround").click(function () {
            $.ajax({
                url: '{!!url("/invoicessignedaroundpremises")!!}',
                type: "POST",
                dataType: 'json',
                data: {
                    deldate: $('#deliverydatesigned').val()
                },
                success: function (data) {
                    $('#savepodtoaccounting').Show();
                    var trHTML = '';
                    $('#signedaroundpremises').empty();
                    trHTML += '<i>Search result</i><br>';
                    $.each(data, function (key, value) {
                        trHTML += '<tr role="row"  style="font-size: 11px;color:black"><td>' +
                            '<button class="pdfs" value="' + value.strPDF + '">' + value.InvoiceNo + '</button></td>' +
                            '</tr><br>';
                    });
                    $('#signedaroundpremises').append(trHTML);
                }
            });
        });



        function returnsubdata(invbutton) {
            $.ajax({
                url: '{!!url("/driverspdfdocsByInvsubinfo")!!}',
                type: "POST",
                dataType: 'json',
                data: {
                    InvocieNo: invbutton
                },
                success: function (data) {
                    console.debug(data);
                    var trHTML = '';

                    $('#notes').empty();
                    $('#cashPaid').empty();
                    var img = "<img "
                        + "src='" + "data:image/jpg;base64,"
                        + data[0].strNotesDrivers + "' style='width:250px;height:250px'/>";
                    $('#notes').append(img);
                    $('#cashPaid').append('PAID : ' + data[0].mnyDriverCash);
                    // trHTML +='<h3>Items Reason</h3>';
                    $.each(data, function (key, value) {

                        if ((value.strCustomerReason).length > 4) {
                            trHTML += '<tr role="row" class="invoiceslistedHeaderPopUp"  style="font-size: 11px;color:black"><td>' +
                                value.PastelCode + '</td><td>' +
                                value.PastelDescription + '</td><td>' +
                                parseFloat(value.Qty).toFixed(2) + '</td><td>' +
                                parseFloat(value.returnQty).toFixed(2) + '</td><td>' +
                                value.strCustomerReason + '</td>' +
                                '</tr>';
                        }

                    });

                    $('#items').append(trHTML);


                }
            });
        }

        function returnroutingIDs() {
            $.ajax({
                url: '{!!url("/getRoutingIds")!!}',
                type: "GET",
                data: {
                    deliveryDate: $('#deliverydate').val()
                },
                success: function (data) {
                    var trHTML = '';
                    $('.fast_removeOrders').empty();
                    $.each(data, function (key, value) {
                        trHTML += '<tr role="row" class="fast_removeOrders"  style="font-size: 9px;color:black"><td>' +
                            value.DeliveryDateRoutingID + '</td><td>' +
                            value.Route + '</td><td>' +
                            value.OrderType + '</td><td>' +
                            value.DriverName + '</td>' +
                            '</tr>';
                    });
                    //routinglist
                    $('#routinglist').append(trHTML);
                }
            });
        }

    });


</script>
</body>
</html>
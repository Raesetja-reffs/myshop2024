<!DOCTYPE html>
<html>
<head>
    <!-- ... -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>     <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
    <!-- DevExtreme themes -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/3.3.1/exceljs.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>    <script src="https://cdn3.devexpress.com/jslib/20.1.8/js/dx.all.js"></script>



    <style>
        .dx-datagrid{
            font:10px verdana;
        }

    </style>
</head>
<body class="dx-viewport" style="font-family: Sans-serif">
<a href='{!!url("/cardsList")!!}'>View Cards IDs</a>
<h5 style="  color: white; ">Customer List</h5>
<div style="display: flex">
<div id="gridContainer" style="width: 70%">

</div>
    <div id="updateSide" style="width: 30%">
        <h2>Customer Basic Information Update</h2>
        <label class="form-control">Email</label><br>
        <input id="email" class="form-control" style="    width: 90%;"><br>
        <label class="form-control">Cell Number</label><br>
        <input id="cellnumber" class="form-control" style="    width: 90%;"><br>


        <label class="form-control">Customer Name</label><br>
        <input type="text" id="custname" class="form-control" style="    width: 90%;">

        <label class="form-control">Address Line 1</label><br>
        <input type="text" id="address1" class="form-control" style="    width: 90%;">
        <label class="form-control">Address Line 2</label><br>
        <input type="text" id="address2" class="form-control" style="    width: 90%;">
        <label class="form-control">Address Line 3</label><br>
        <input type="text" id="address3" class="form-control" style="    width: 90%;"><br>

        <label class="form-control">Card Number</label><br>
        <input type="number" id="cardnumber" class="form-control" style="    width: 90%;" readonly><br>
        <button style="background: green;padding: 10px;float: right;color: white;font-weight: 900;margin-right: 10%;margin-top: 14px;" id="updatebasiccustomerinfo">Update</button>

    </div>

</div>

<div>
            <label class="control-label" for="userid"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">User ID</label>
<input type = "text" id = "userid"readonly>
            <label class="control-label" for="CustomerStorename"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Name</label>
<input type = "text" id = "CustomerStorename"readonly>
            <label class="control-label" for="intPoints"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Points</label>
<input type = "text" id = "intPoints" readonly>
            <label class="control-label" for="CustomerContactCellphone"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Cell Number</label>
<input type = "text" id = "CustomerContactCellphone"readonly>
            <label class="control-label" for="CustomerContactCellphone"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Increase points by</label>
<input type = "number" id = "IncreasePoints" min = "0" value = "0">
            <button class="form-control btn-md btn-success" id="increase">Increase</button>
</div>
<hr style="border: 1px solid red">
<div>
Points Earned After <input type="date" class="form-control" id="dates" data-date-format="yyyy-mm-dd" value="{{$dates}}"><br>
    <button class="btn-primary form-control" id="refreshdateinfo"> Refresh</button>

</div>
<hr style="border: 1px solid black">
<h4>Redeemed</h4>
<div id="gridredeemed">

</div>
<hr style="border: 1px solid black">
<h4>Earned</h4>
<div id="gridearned">

</div>
<div class="row">
    <script type="text/javascript" charset="utf-8">
        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'off' );
        });
        var clickTimer, lastRowClickedId;
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#updatebasiccustomerinfo').click(function() {
                $.ajax({
                    url: '{!!url("/updatecustomerwebstoreinfo")!!}',
                    type: "POST",
                    data: {
                        email: $('#email').val(),
                        cellnumber: $('#cellnumber').val(),
                        address1: $('#address1').val(),
                        custname: $('#custname').val(),
                        address2: $('#address2').val(),
                        address3: $('#address3').val(),
                        cardnumber: $('#cardnumber').val(),
                        userid: $('#userid').val()
                    },
                    success: function (data) {
                        alert("SAVED");
                        location.reload();
                    }
                });
            });
                $('#increase').click(function () {
                    alert("this is it ");
                    $.ajax({
                        url: '{!!url("/increasePoints")!!}',
                        type: "POST",
                        data: {

                            userid: $('#userid').val(),
                            IncreasePoints: $('#IncreasePoints').val()
                        },
                        success: function (data) {

                            if (data) {
                                var dialog = $('<p><strong style="color:black"> Data Saved.</strong></p>').dialog({
                                    height: 200, width: 700, modal: true, containment: false,
                                    buttons: {
                                        "Okay": function () {

                                            location.reload();
                                            dialog.dialog('close');
                                        }
                                    }
                                });
                            } else {
                                var dialog = $('<p><strong style="color:red">Sorry something went wrong, please try again.</strong></p>').dialog({
                                    height: 200, width: 700, modal: true, containment: false,
                                    buttons: {
                                        "Okay": function () {

                                            dialog.dialog('close');
                                        }
                                    }
                                });
                            }

                        }
                    });
                });


            $('#refreshdateinfo').click(function(){
                pointswebstore($('#userid').val(),$('#dates').val());;
            });
            $(function(){
                $("#gridContainer").dxDataGrid({
                    dataSource:'{!!url("/getPointGrid")!!}',

                    showBorders: true,
                    allowDeleting: false,
                    filterRow: { visible: true },
                    allowColumnResizing: true,

                    columns: [
                        {
                            dataField: "userid",
                            caption: "User ID",
                            width: 120

                        },

                        {
                            dataField: "CustomerStorename",
                            caption: "Customer Name",
                            width: 300
                        },
                        {
                            dataField: "username",
                            caption: "Email",
                            width: 300
                        },

                        {
                            dataField: "CustomerContactCellphone",
                            caption: "Customer Contact Number",
                            width: 120

                        },

                        {
                            dataField: "intPoints",
                            caption: "Points",
                            format: {
                                type: String, // one of the predefined formats
                                precision: Number // the precision of values

                            },
                            width: 150
                        },
                        {
                            dataField: "strCardUid",
                            caption: "Card Id",
                            width: 100
                        },
                        {
                            dataField: "strCustomerCode",
                            caption: "Customer Code",
                            width: 100
                        },
                        {
                            dataField: "DeliveryDate",
                            caption: "Last Invoice",
                            width: 100
                        } ,{
                            dataField: "CustomerAddress1",
                            caption: "Address 1",
                            width: 300
                        } ,{
                            dataField: "CustomerAddress2",
                            caption: "Address 2",
                            width: 300
                        },{
                            dataField: "CustomerAddress3",
                            caption: "Address 3",
                            width: 300
                        }, {
                            dataField: "CustomerAddress4",
                            caption: "Address 4",
                            width: 300
                        },
                        {
                            dataField: "Email",
                            caption: "Email",
                            width: 300
                        }
                    ] ,
                    export: {
                        enabled: true,
                        allowExportSelectedData: true
                    },
                    onExporting: function(e) {
                        var workbook = new ExcelJS.Workbook();
                        var worksheet = workbook.addWorksheet('loyaltylist');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet: worksheet,
                            autoFilterEnabled: true
                        }).then(function() {
                            // https://github.com/exceljs/exceljs#writing-xlsx
                            workbook.xlsx.writeBuffer().then(function(buffer) {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'loyaltylist.xlsx');
                            });
                        });
                        e.cancel = true;
                    },
                    onRowClick: function (e) {

                        //OBTAIN YOUR GRID DATA HERE
                        //var data = e.selectedRowsData;


                        $('#userid').val(e.key.userid);
                        $('#CustomerStorename').val(e.key.CustomerStorename);
                        $('#intPoints').val(e.key.intPoints);
                        $('#CustomerContactCellphone').val(e.key.CustomerContactCellphone);
                        $('#cellnumber').val(e.key.CustomerContactCellphone);
                        $('#email').val(e.key.Email);
                        $('#address1').val(e.key.CustomerAddress1);
                        $('#address2').val(e.key.CustomerAddress2);
                        $('#address3').val(e.key.CustomerAddress3);
                        $('#cardnumber').val(e.key.strCardUid);
                        $('#custname').val(e.key.CustomerStorename);
                        alert(e.key.userid);
                        pointswebstore(e.key.userid,$('#dates').val());


                    },
                    onEditingStart: function(e) {
                        console.debug("EditingStart");
                    },
                    onInitNewRow: function(e) {
                        console.debug("InitNewRow");
                    },
                    onRowInserting: function(e) {
                        console.debug("RowInserting");
                    },
                    onRowInserted: function(e) {
                        console.debug("RowInserted");
                    },
                    onRowUpdating: function(e) {
                        console.debug("RowUpdating");
                    },
                    onRowUpdated: function(e) {
                        console.debug("RowUpdated");
                    },
                    onRowRemoving: function(e) {
                        console.debug("RowRemoving");
                    },
                    onRowRemoved: function(e) {
                        console.debug("RowRemoved");
                    }
                });
            });


function pointswebstore(userid,dates)
{
    $.ajax({
        url: '{!!url("/customerPointsTrends")!!}',
        type: "GET",
        data: {
            delvdate:$('#dates').val(),
            userid:userid
        },
        success: function (data) {

            console.debug(data.redeemed);
            $(function(){
                $("#gridredeemed").dxDataGrid({
                    dataSource: data.redeemed,
                    showBorders: true,
                    allowDeleting: false,
                    columnResizingMode: "nextColumn",
                    export: {
                        enabled: true,
                        allowExportSelectedData: true
                    },
                    onExporting: function(e) {
                        var workbook = new ExcelJS.Workbook();
                        var worksheet = workbook.addWorksheet('redeemed');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet: worksheet,
                            autoFilterEnabled: true
                        }).then(function() {
                            // https://github.com/exceljs/exceljs#writing-xlsx
                            workbook.xlsx.writeBuffer().then(function(buffer) {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'redeemed.xlsx');
                            });
                        });
                        e.cancel = true;
                    }

                });

            });
            $(function(){
                $("#gridearned").dxDataGrid({
                    dataSource: data.earned,
                    showBorders: true,
                    allowDeleting: false,
                    columnResizingMode: "nextColumn",
                    export: {
                        enabled: true,
                        allowExportSelectedData: true
                    },
                    onExporting: function(e) {
                        var workbook = new ExcelJS.Workbook();
                        var worksheet = workbook.addWorksheet('earned');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet: worksheet,
                            autoFilterEnabled: true
                        }).then(function() {
                            // https://github.com/exceljs/exceljs#writing-xlsx
                            workbook.xlsx.writeBuffer().then(function(buffer) {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'earned.xlsx');
                            });
                        });
                        e.cancel = true;
                    }

                });

            });

        }
    });
}


        });
    </script>
</div>
</body>
</html>

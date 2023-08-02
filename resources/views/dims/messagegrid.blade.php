<!DOCTYPE html>
<html>
<head>
    <!-- ... -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>     <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
    <!-- DevExtreme themes -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>



    <style>
        .dx-datagrid{
            font:10px verdana;
        }

    </style>
</head>
<body class="dx-viewport" style="font-family: Sans-serif">
<h5 style="  color: white; ">Message List</h5>
<div style="display: flex">
<div id="gridContainer" style="width: 70%">

</div>
    <div id="updateMessage" style="width: 30%">

        <h2>Message Information</h2>

        <label class="form-control">Message ID</label><br>
        <input id="MessageID" class="form-control" style="    width: 90%;"><br>

        <label class="form-control">Message Header</label><br>
        <input id="MessageHeader" class="form-control" style="    width: 90%;"><br>

        <label class="form-control">Message</label><br>
        <input type="text" id="Message" class="form-control" style="    width: 90%;">

        <button style="background: green;padding: 10px;float: right;color: white;font-weight: 900;margin-right: 10%;margin-top: 14px;" id="updateMessagebtn">Update</button>

    </div>

</div>


<div class="row">
    <script type="text/javascript" charset="utf-8">
        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'off' );
        });
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

                $('#updateMessagebtn').click(function () {
                    $.ajax({
                        url: '{!!url("/updateMessage")!!}',
                        type: "POST",
                        data: {

                            MessageID: $('#MessageID').val(),
                            MessageHeader: $('#MessageHeader').val(),
                            Message: $('#Message').val()
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                });



            $(function(){
                $("#gridContainer").dxDataGrid({
                    dataSource:'{!!url("/getMessageGrid")!!}',

                    showBorders: true,
                    allowDeleting: false,
                    filterRow: { visible: true },
                    allowColumnResizing: true,

                    columns: [
                        {
                            dataField: "MessageID",
                            caption: "Message ID",
                            width: 120

                        },

                        {
                            dataField: "MessageHeader",
                            caption: "Message Header",
                            width: 200
                        },
                        {
                            dataField: "Message",
                            caption: "Message",
                            width: 500
                        }
                    ] ,
                    onRowClick: function (e) {

                        //OBTAIN YOUR GRID DATA HERE
                        //var data = e.selectedRowsData;


                        $('#MessageID').val(e.key.MessageID);
                        $('#MessageHeader').val(e.key.MessageHeader);
                        $('#Message').val(e.key.Message);

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



        });
    </script>
</div>
</body>
</html>

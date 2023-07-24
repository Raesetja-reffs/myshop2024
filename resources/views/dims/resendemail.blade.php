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
<h2>Checking Screen </h2>

<div class="table-container" style="height:100%">
    <div >
       <input id="invoiceNumber">
        <button class="btn-primary btn-md" id="search">SEARCH</button>
        <fieldset>
            <legend>Mail Info</legend>
            Sent To <br><input class="form-control"  id="sentto" readonly><input type="hidden" id="id" >
            Offloaded Time<br><input class="form-control"  id="offloaded" readonly>
            Time Sent <br><input class="form-control"  id="timesent" readonly>
             Current Customer Email  <br><input class="form-control"  id="emailaddress">

            <button id="resendemail">Resend Email</button>
        </fieldset>

    </div>
</div>

<script type="text/javascript" charset="utf-8">


    $(document).ready(function() {
        $('#authRemoteOrder').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $("#search").click(function(){
            retrieveInvoiceInfo();

        });

        $("#resendemail").click(function(){
            $.ajax({
                url: '{!!url("/postResendEmailJson")!!}',
                type: "POST",
                data:{
                    id:$('#id').val(),
                    Email:$('#emailaddress').val(),
                    invoiceNumber:$('#invoiceNumber').val()
                },
                success: function(data){

                    if(data)
                    {

                        var dialog = $('<p><strong style="color:red">Email Sent</strong></p>').dialog({
                            height: 200, width: 700,modal: true,containment: false,
                            buttons: {
                                "Okay": function () {

                                    dialog.dialog('close');
                                    if (data == "true")
                                    {
                                        window.close();
                                    }
                                }
                            }
                        });
                    }else{
                        var dialog = $('<p><strong style="color:red">Something Went Wrong</strong></p>').dialog({
                            height: 200, width: 700,modal: true,containment: false,
                            buttons: {
                                "Okay": function () {

                                    dialog.dialog('close');
                                    if (data == "true")
                                    {
                                        window.close();
                                    }
                                }
                            }
                        });
                    }

                }
            });

        });

        $(document).keypress(function (e) {
            if (e.which == 13) {
                retrieveInvoiceInfo();
            }
        });

        function retrieveInvoiceInfo()
        {
            $.ajax({
                url: '{!!url("/getResendEmailJson")!!}',
                type: "POST",
                data:{
                    invoiceNumber:$('#invoiceNumber').val()
                },
                success: function(data){
                    console.debug(data);
                    $('#sentto').val(data[0].sendto);
                    $('#timesent').val(data[0].timesent);
                    $('#offloaded').val(data[0].dteOffloadedTime);
                    $('#emailaddress').val(data[0].currentCustomerEmail);
                    $('#id').val(data[0].ID);

                }
            });
        }
    });


</script>
</body>
</html>
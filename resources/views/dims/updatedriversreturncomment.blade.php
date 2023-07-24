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
       Product Name<br> <input id="productname" class="form-control" value="{{$orderdetailID[0]->PastelDescription}}" readonly><input type="hidden" id="orderdetailId" value="{{$orderdetailID[0]->OrderDetailId}}"><br>
       Return Reason<br> <input id="strCustomerReason"  class="form-control" value="{{$orderdetailID[0]->strCustomerReason}}" readonly><br>
        Dispatch Comment<br><input id="strDispatchComments"  class="form-control" value="{{$orderdetailID[0]->strDispatchComments}}"><br>
        <button class="btn-primary btn-md" id="save">SAVE</button>

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


        $("#save").click(function(){

            $.ajax({
                url: '{!!url("/updatereturndispatchmessage")!!}',
                type: "POST",
                data:{
                    orderdetailId:$('#orderdetailId').val(),
                    strDispatchComments:$('#strDispatchComments').val()
                },
                success: function(data){
                    var dialog = $('<p><strong style="color:red">Data saved</strong></p>').dialog({
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
            });
        });
    });


</script>
</body>
</html>
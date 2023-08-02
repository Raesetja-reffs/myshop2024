<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>

    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
    <style>
        body {font-family: Arial, Helvetica, sans-serif;}
        * {box-sizing: border-box;}

        input[type=text], select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
            resize: vertical;
        }

        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }
    </style>
</head>
<body>

<h3>Card Registration For Personal Customers</h3>

<div class="container">

    <fieldset>
        <legend>Customer Info</legend>
        <input type="text" id="customerid" placeholder="Do not type in anything." readonly required>
        <input type="email" id="verifyemailinput" placeholder="Please type in the email.">

        <button id="verifyemail">VERIFY EMAIL</button>

        <label>ID NUMBER</label>
        <input type="text" id="inputID" name="inputID" placeholder="ID Number"><br>

        <button class="btn-success btn-lg" id="allocate" style="background: red;">Allocate</button><br>

        <label for="lname">Card Number Look Up</label>
        <input type="text" id="cardlookup" name="cardlookup" placeholder="Card Number">

    </fieldset>

    <fieldset>
        <legend>Final Step</legend>
        <button id="save" style="    background: green;
        color: white;
        font-weight: 900;
        padding: 23px;">SAVE DATA</button>
    </fieldset>


</div>

<script>
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).keydown(function(e) {
        if (e.keyCode == 27) return false;
    });
    var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});

    $(document).ready(function() {

        $('#verifyemail').click(function(){

            $.ajax({
                url: '{!!url("/verifyemail")!!}',
                type: "get",
                data: {
                    verifyemail: $('#verifyemailinput').val()
                },
                success: function (data) {

                 if(data.length)
                 {
                     $('#customerid').val(data[0].UserID);
                    var dialog = $('<p> Customer Info<br> <strong style="color:red"> Customer Name '+data[0].CustomerStoreName+' <br> Cell Number '+data[0].CustomerContactCellphone+'</strong></p>').dialog({
                        height: 300, width: 700,modal: true,containment: false,
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
                 else{
                     var dialog = $('<p><strong style="color:red">Please Create An Online Profile First <a href="https://online.groceryexpress.co.za/publicRegistration" target="_blank"> here</a></strong></p>').dialog({
                         height: 300, width: 700,modal: true,containment: false,
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

    $('#allocate').click(function(){

        if($('#inputID').val().length == 13){
            $.ajax({
                url: '{!!url("/checkifIdexists")!!}',
                type: "get",
                data: {
                    ID: $('#inputID').val()
                },
                success: function (data) {

                    if(data.length)
                    {
                        var dialog = $('<p><strong style="color:red"> The ID Number already Exist.</strong></p>').dialog({
                            height: 300, width: 700,modal: true,containment: false,
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
                    else{
                        var dialog = $('<p><strong style="color:red">You may proceed with the registration.</strong></p>').dialog({
                            height: 300, width: 700,modal: true,containment: false,
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
        }else{
            alert("Make sure you have entered correct ID number.");

        }



        });




        $('#save').click(function(){


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if($('#inputID').val().length == 13){
              //  $('#save').hide();
            $.ajax({
                url: '{!!url("/saveinfocardwalking")!!}',
                type: "get",
                data: {
                    CustomerId: $('#customerid').val(),

                    cardlookup: $('#cardlookup').val(),
                    IdNumber: $('#inputID').val()
                },
                success: function (data) {

                    var dialog = $('<p><strong style="color:red">'+data[0].Result+' No of existing cards '+ data[0].noCards+'</strong></p>').dialog({
                        height: 200, width: 700,modal: true,containment: false,
                        buttons: {
                            "Okay": function () {
                                dialog.dialog('close');
                                if (data == "true")
                                {
                                    window.close();
                                    location.reload();
                                }
                            }
                        }
                    });
                }
            });
            }else{
                alert("Make sure you have entered correct ID number or check if the email is correct.");
            }

        });
    });
</script>
</body>
</html>

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

<h3>Card Registration For Business</h3>

<div class="container">

        <fieldset>
            <legend>Customer Info</legend>
        <label for="fname">Customer Name</label>
        <input type="text" id="inputCustName" name="inputCustName" placeholder="Customer Name">

        <label for="lname">Customer Code</label>
        <input type="text" id="inputCustAcc" name="inputCustAcc" placeholder="Account Number">
        <input type="hidden" id="CustomerId" name="CustomerId"  >

        <label for="lname">Card Number Look Up</label>
        <input type="text" id="cardlookup" name="cardlookup" placeholder="Card Number">
        <button class="btn-success btn-lg" id="submit">SEARCH</button>
        </fieldset>
    <fieldset>
        <legend>Card Result</legend>
        <label for="subject">Current Owner</label>
        <input type="text" name="currentowner" id="currentowner" readonly>
        <input id="uid" readonly>
        <input id="datecreate" readonly>
       <br><br>
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
        var finalData = $.map(JSON.parse(jArrayCustomer), function (item) {

            return {

                CustomerPastelCode: item.CustomerPastelCode,
                StoreName: item.StoreName,
                CustomerId: item.CustomerId

            }

        });
        var inputCustNames = $('#inputCustName').flexdatalist({
            minLength: 2,
            valueProperty: '*',
            selectionRequired: true,
            focusFirstResult: true,
            searchContain: true,
            visibleProperties: ["StoreName", "CustomerPastelCode"],
            searchIn: 'StoreName',
            data: finalData
        });
        inputCustNames.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#CustomerId').val(data.CustomerId);

        });
        var inputCustCode = $('#inputCustAcc').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            focusFirstResult: true,
            searchContain: true,
            visibleProperties: ["StoreName", "CustomerPastelCode"],
            searchIn: 'CustomerPastelCode',
            data: finalData
        });
        inputCustCode.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#CustomerId').val(data.CustomerId);

        });

        $('#submit').click(function(){

            if(($('#cardlookup').val().trim()).length < 4 )
            {
                alert("YOUR CARD NUMBER FORMAT IS INCORRECT");
            }else{
                $.ajax({
                    url: '{!!url("/cardnumberlookup")!!}' ,
                    type: "get",
                    data:{
                        cardlookupNumber:$('#cardlookup').val()
                    },
                    success: function(data){

                        console.debug(data);

                        if(data.length){
                            $('#currentowner').val(data.StoreName);
                            $('#uid').val(data.strCardUid);
                            $('#datecreate').val(data.dteupdated);

                            var dialog = $('<p><strong style="color:red">Sorry, This Card Is Already Assigned To '+data.StoreName+'</strong></p>').dialog({
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
                            $('#currentowner').val('YOU ARE MORE THAN WELCOME TO USE THIS CUSTOMER');
                        }
                    }
                });
            }


        });

        $('#save').click(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{!!url("/saveinfocard")!!}',
                type: "get",
                data: {
                    CustomerId: $('#CustomerId').val(),
                    inputCustAcc: $('#inputCustAcc').val(),
                    cardlookup: $('#cardlookup').val()
                },
                success: function (data) {

                    var dialog = $('<p><strong style="color:red">'+data[0].Result+'</strong></p>').dialog({
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

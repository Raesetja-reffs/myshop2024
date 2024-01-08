<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">

    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
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
<h2>Customer Address ID {{$DeliveryAddressId}}</h2>
<input id="DeliveryAddressId" type="hidden" value="{{$DeliveryAddressId}}" >
<input id="customercode" type="hidden" value="{{$customercode}}" >
<input id="DeliveryAddress1" value="{{$DeliveryAddress1}}" >
<input id="DeliveryAddress2" value="{{$DeliveryAddress2}}" >
<input id="DeliveryAddress3" value="{{$DeliveryAddress3}}" >
<input id="DeliveryAddress4" value="{{$DeliveryAddress4}}" >
<input id="DeliveryAddress5" value="{{$DeliveryAddress5}}" >

<div style="background: yellow;    padding: 15px;" >
    <h2>Copy to </h2>
    Account Name<input id="inputCustName" name="inputCustName" class="form-control input-sm col-xs-1" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
    Account Code <input id="inputCustAcc" name="inputCustAcc" class="form-control input-sm col-xs-1" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
<h4>Customer Basket</h4>
    <div id="myGrid" style="height: 700px;width:99%;" class="ag-theme-balham"></div>
    <button id="submit">Start Copying</button>



</div>

<script type="text/javascript" charset="utf-8">
var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
$(document).ready(function() {
    var finalData =$.map(JSON.parse(jArrayCustomer), function(item) {

    return {
    BalanceDue:item.BalanceDue,
    CustomerPastelCode:item.CustomerPastelCode,
    StoreName:item.StoreName,
    UserField5:item.UserField5,
    CustomerId:item.CustomerId,
    CreditLimit:item.CreditLimit,
    Email:item.Email,
    Routeid:item.Routeid,
    Discount:item.Discount,
    OtherImportantNotes:item.OtherImportantNotes,
    Routeid:item.Routeid,
    strRoute:item.strRoute,
    mnyCustomerGp:item.mnyCustomerGp,
    Warehouse:item.Warehouse,
    ID:item.ID
    }

    });

    var inputCustNames = $('#inputCustName').flexdatalist({
    minLength: 1,
    valueProperty: '*',
    selectionRequired: true,
    focusFirstResult: true,
    searchContain:true,
    visibleProperties: ["StoreName","CustomerPastelCode"],
    searchIn: 'StoreName',
    data: finalData
    });
    inputCustNames.on('select:flexdatalist', function (event, data) {

    $('#inputCustAcc').val(data.CustomerPastelCode);
    $('#inputCustName').val(data.StoreName);
    });

    var inputCustAccount = $('#inputCustAcc').flexdatalist({
    minLength: 1,
    valueProperty: '*',
    selectionRequired: true,
    searchContain:true,
    focusFirstResult: true,
    visibleProperties: ["CustomerPastelCode","StoreName"],
    searchIn: 'CustomerPastelCode',
    data: finalData
    });
    inputCustAccount.on('select:flexdatalist', function (event, data) {

    $('#inputCustAcc').val(data.CustomerPastelCode);
    $('#inputCustName').val(data.StoreName);

    });
    var values = new Array();
    var columnDefs = [
        {headerName: "ProductId", field: "ProductId",width: 50},
        {headerName: "PastelCode", field: "PastelCode",width: 120},
        {headerName: "PastelDescription", field: "PastelDescription",width: 300}
    ];
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
    $( "#myGrid" ).empty();
    $('#myGrid').show();
    $('#exportsection').show();
    $('#updatepricelists').show();
    var eGridDiv = document.querySelector('#myGrid');

    // create the grid passing in the div to use together with the columns & data we want to use
    new agGrid.Grid(eGridDiv, gridOptions);

    //  var dateto1 = $('#dateeto1').val();


    fetch('{!!url("/getDeliveryAddressOrderPattern")!!}/'  +$('#customercode').val()+'/'+$('#DeliveryAddressId').val() ).then(function (response) {
        return response.json();
    }).then(function (data) {
        gridOptions.api.setRowData(data);
    });

    // let the grid know which columns and what data to use

});

$('#submit').click(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '{!!url("/startcopyingorderpatternhistorytoaccount")!!}',
        type: "POST",
        data: {
            deliveryaddressid: $('#DeliveryAddressId').val() ,
            newCustomerode:$('#inputCustAcc').val()
        },
        success: function (data) {
            var dialog = $('<p><strong style="color:red">Done Copying, Would you like to delete this address from '+$('#customercode').val()+' ? </strong></p>').dialog({
                height: 200, width: 700,modal: true,containment: false,
                buttons: {
                    "YES": function () {
                        dialog.dialog('close');
                        $.ajax({
                            url: '{!!url("/deleteaddressonthecustomerdeliveryaddresstbl")!!}',
                            type: "POST",
                            data: {
                                deliveryaddressid: $('#DeliveryAddressId').val(),
                            },
                            success: function (data2) {

                                var dialog = $('<p><strong style="color:black">' + data2 + '</strong></p>').dialog({
                                    height: 200, width: 700, modal: true, containment: false,
                                    buttons: {
                                        "Okay": function () {
                                            $('#submit').hide();
                                            window.close();
                                            dialog.dialog('close');
                                        }
                                    }
                                });

                            }
                        });

                    },
                    "NO": function () {

                        dialog.dialog('close');
                    }
                }
            });
        }
    });
});
</script>
</body>
</html>

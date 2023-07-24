<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
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
<input type="text" id="transferId" >
<button id="get">GET</button>
<table>
    <thead><tr>
    <th>Product Code</th>
    <th>Product Name</th>
    <th>Qty</th>
    <th>Comment</th>
    <th>Return Comment</th>
    </tr>
    </thead>
    <tbody id="transfertbl" >

    </tbody>
</table>


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
        $('#get').click(function(){
            $.ajax({
                url: '{!!url("/getTransfers")!!}',
                type: "GET",
                data: {
                    transferId: $('#transferId').val()
                },
                success: function (data) {

                    var trHTML = '';
                    $.each(data.customerSpecials, function (key, value) {
                        trHTML += '<tr class="fast_remove" style="font-size: 9px;color:black"><td>' +
                            value.PastelDescription + '</td><td>' +
                            value.PastelCode + '</td><td>' +
                            '<input type="number"  id="qty" value="' + parseFloat(value.Qty).toFixed(2) + '" style="width:1px" >'+
                            '<input type="hidden"  id="productid" value="' + value.ProductId + '" style="width:1px" >'+
                            '</td><td>' +
                             value.Comment + '</td><td>' +
                            '<input type="hidden" class="rtncomment" value="' + value.strCustomerReason + '" style="width:1px" class="foo"></td>' +
                            '</tr>';
                    });
                    $('#transfertbl').empty();
                    $('#transfertbl').append(trHTML);
                }
            });

        });

        $('#submit').click(function () {



            $.ajax({
                url: '{!!url("/printbarcode")!!}',
                type: "POST",
                data: {
                    productId: ProductId

                },
                success: function (data) {
                    alert("DONE!!");

                }
            });

        });
    });


</script>
</body>
</html>
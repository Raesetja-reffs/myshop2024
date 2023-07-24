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
        #tillusers,#receiptstbl,#cashups {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        #tillusers td, #notdone th {
            border: 1px solid #ddd;
            padding: 8px;
        }
        #receiptstbl td{
            border: 1px solid #ddd;
            padding: 8px;
        }#cashups td{
             border: 1px solid #ddd;
             padding: 8px;
         }#auths td{
             border: 1px solid #ddd;
             padding: 8px;
         }

        #tillusers tr:nth-child(even){background-color: #f2f2f2;}
        #receiptstbl tr:nth-child(even){background-color: #f2f2f2;}
        #cashups tr:nth-child(even){background-color: #f2f2f2;}
        #auths tr:nth-child(even){background-color: #f2f2f2;}

        #tillusers tr:hover {background-color: #ddd;}
        #receiptstbl tr:hover {background-color: #ddd;}
        #cashups tr:hover {background-color: #ddd;}
        #auths tr:hover {background-color: #ddd;}

        #tillusers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #bb1523;
            color: white;
        }
        #receiptstbl th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #bb1523;
            color: white;
        }
        #cashups th {
             padding-top: 12px;
             padding-bottom: 12px;
             text-align: left;
             background-color: #bb1523;
             color: white;
         } #auths th {
             padding-top: 12px;
             padding-bottom: 12px;
             text-align: left;
             background-color: #bb1523;
             color: white;
         }

    </style>
</head>
<body style="font-family: Sans-serif">
<div style="display: flex;width: 100%;">
    <div style="width: 50%">
        <input id="deliverydate" value="{{$delDate}}" style="color:black;font-weight: 900;"><button class="btn-success" id="lplan"> SUBMIT</button>
        <?php
        $totalFloat = 0;
        $totalCredit = 0;
        $totalCash = 0;
        $totalSales = 0;
        ?>
        <table class="table" id="tillusers">
            <thead><tr>
                <th>Till</th>
                <th>Status</th>
                <th>Session</th>
                <th>Last Synced</th>

                <th>Float</th>
                <th>Cash</th>
                <th>Credit</th>

                <th>Total Sales</th>
                <th> </th>
            </tr>
            </thead>
            <tbody id="transfertbl" >
            @foreach($tillusers as $val)
                <tr>
                    <td>{{$val->strTill}}</td>
                    <td>{{$val->strStatus}}</td>
                    <td>{{$val->strSession}}</td>
                    <td>{{$val->synced}}</td>

                    <td>{{$val->mnfloat}}</td>
                    <td>{{$val->cash}}</td>
                    <td>{{$val->credit}}</td>

                    <td>{{$val->mnyTotalSales}}</td>
                    <td><button class="closedrawer">Close Drawer</button></td>
                    <?php

                    $totalFloat = $totalFloat + $val->mnfloat;
                    $totalCredit = $totalCredit + $val->credit;
                    $totalCash = $totalCash + $val->cash;
                    $totalSales = $totalSales + $val->mnyTotalSales;
                    ?>
                </tr>

            @endforeach
            <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>

                <td>{{$totalFloat}}</td>
                <td>{{$totalCash}}</td>
                <td>{{$totalCredit}}</td>
                <td>{{$totalSales}}</td>
            </tr>
            </tbody>
        </table>

        </table>
        <hr>
        <h4>Receipts</h4>
        <table class="table" id="receiptstbl">
            <thead><tr>
                <th>Customer Code</th>
                <th>Customer Name</th>
                <th>Date</th>
                <th>Receipt Number</th>
                <th>Pos Machine</th>
                <th>UserName</th>
                <th>Cash</th>
                <th>Card</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($receipts as $value)
                <tr>
                    <td>{{$value->CustomerPastelCode}}</td>
                    <td>{{$value->StoreName}}</td>
                    <td>{{$value->dateselected}}</td>
                    <td>{{$value->strDocNo}}</td>
                    <td>{{$value->strMachinePosName}}</td>
                    <td>{{$value->UserName}}</td>
                    <td>{{$value->mnyCash}}</td>
                    <td>{{$value->mnyCard}}</td>
                    <td>{{$value->mnyTotal}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>


    </div>
    <div style="margin-left: 5%">

        Cash Up Info
        <table class="table" id="cashups">
            <thead>
            <tr>
                <th>Machine Ref</th>
                <th>User Name</th>
                <th>Cash</th>
                <th>Card</th>
                <th>Time</th>
            </tr>
            </thead>
            <tbody>
            @foreach($dailycashups as $value)
                <tr>
                    <td>{{$value->strMachine}}</td>
                    <td>{{$value->UserName}}</td>
                    <td>{{$value->mnyCash}}</td>
                    <td>{{$value->mnyCard}}</td>
                    <td>{{$value->dteCreatedTime}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <hr>
        Authorizations of Items
        <table class="table" id="auths">
            <thead>
            <tr>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>DocNumber</th>
                <th>Price From</th>
                <th>Price To</th>
                <th>Auth By</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posauths as $value)
                <tr>
                    <td>{{$value->strPartNumber}}</td>
                    <td>{{$value->PastelDescription}}</td>
                    <td>{{$value->strDocNumber}}</td>
                    <td>{{$value->mnyPriceFrom}}</td>
                    <td>{{$value->mnyPriceTo}}</td>
                    <td>{{$value->UserName}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript" charset="utf-8">
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).ready(function() {

        $("#deliverydate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd',

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#save').click(function(){
            $.ajax({
                url: '{!!url("/submittillusers")!!}',
                type: "POST",
                data: {
                    username: $('#username').val(),
                    till: $('#availabletills').val(),
                    floatamount: $('#floatamount').val()
                },
                success: function (data) {
                    location.reload(true);
                    if(data == "SUCCESS")
                    {
                        location.reload(true);
                    }
                }
            });

        });
        $('#lplan').click(function(){
            var newODate = $('#deliverydate').val();
            window.open('{!!url("/viewassignuserstotill")!!}/'+newODate, 'tillstatus', "location=1,status=1,scrollbars=1, width=1500,height=850");
        });

        $('#tillusers').on('click', 'button', function (e) {
            var $this = $(this);
            var posname = $this.closest('tr').find('td:eq(0)').text();

            $.ajax({
                url: '{!!url("/closedrawer")!!}',
                type: "POST",
                data: {
                    till:posname
                },
                success: function (data) {
                    location.reload(true);
                    if(data == "SUCCESS")
                    {
                        location.reload(true);
                    }
                }
            });

        });

    });


</script>
</body>
</html>
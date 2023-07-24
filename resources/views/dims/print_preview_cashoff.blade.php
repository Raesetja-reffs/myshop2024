<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 4px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
<div>
    <h3>Cash Off Ref No : {{$invoices[0]->ref}} </h3>
    <h3>Routing ID  :{{$invoices[0]->DeliveryDateRoutingID}}</h3>
    <div style="display: flex;">
        <div style="display: flex;" >
            <h3>Driver      :{{$invoices[0]->DriverName}}</h3>

            <h3 style="margin-left: 100px;">Truck       :{{$invoices[0]->TruckName}}</h3>

            <h3 style="margin-left: 100px;">Route Name  :{{$invoices[0]->Route}}</h3>
        </div>
    </div>
</div>
<div style="display: flex;">
    <div >
<table class="table table-bordered table-condensed" tabindex=0 id="cashoftable" style="overflow-y: auto;width:100%;color: black;    font-weight: 700;" tabindex=0" >
    <thead style="font-size: 17px;">
    <tr>
        <th class="col-md-2">Name</th>

        <th >InvoiceNo</th>
        <th class="col-sm-1">InvoiceAmount</th>
        <th class="col-sm-1">Cash</th>
        <th class="col-sm-1">Unpaid</th>


    </tr>
    </thead>
    <tbody>
    <?php
            $numberOfCustomers = 0;
            $unpaidTotal= 0;
            $invoiceTotal = 0;
            $CashCollected = 0

    ?>
    @foreach($invoices as $val)
        <tr>
        <td>{{$val->StoreName}}</td>
        <td >{{$val->InvoiceNo}}</td>
        <td>{{round($val->mnyTotal,2)}}</td>
        <td>{{round($val->captured,2)}}</td>
        <td>{{round($val->Unpaid,2)}}</td>

        </tr>
        <?php
        $numberOfCustomers++;
        $unpaidTotal= $unpaidTotal + round($val->Unpaid,2);
        $invoiceTotal= $invoiceTotal + round($val->mnyTotal,2);
        $CashCollected= $CashCollected + round($val->captured,2);

        ?>
        @endforeach
    <tr>
        <td>TOTAL</td>
        <td>{{$numberOfCustomers}}</td>

        <td>{{round($invoiceTotal,2)}}</td>
        <td>{{round($CashCollected,2)}}</td>
        <td>{{$unpaidTotal}}</td>
    </tr>
    </tbody>

</table>
<div>
    <h3>Driver.......................................................................................</h3>
    <h3>Assistant....................................................................................</h3>
    <h3>Cash ........................................................................................</h3>
</div>
<div>
    <h3>Message............{{$invoices[0]->msg}}</h3>

</div>
    </div>
    <div>
        <table class="table2 table-bordered" id="cash_tray" style="border: 1px solid #312f2f;background: #989292;font-size: 11px;">
            <thead>
            <tr>
                <td style="width: 50px;">Note</td>
                <td style="width: 50px;">Qty</td>
                <td style="width: 50px;">Total</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>R 200<input type="hidden" class="note_val" value="200"></td>
                <td>{{$invoices[0]->n200}}</td>
                <td>{{$invoices[0]->n200 * 200}}</td>
            </tr>
            <tr>
                <td>R 100<input type="hidden" class="note_val" value="100"></td>
                <td>{{$invoices[0]->n100}}</td>
                <td>{{$invoices[0]->n100 *100}}</td>
            </tr>
            <tr>
                <td>R 50 <input type="hidden" class="note_val" value="50"></td>
                <td>{{$invoices[0]->n50}}</td>
                <td>{{$invoices[0]->n50 * 50}}</td>
            </tr>
            <tr>
                <td>R 20 <input type="hidden" class="note_val" value="20"></td>
                <td>{{$invoices[0]->n20}}</td>
                <td>{{$invoices[0]->n20 * 20}}</td>
            </tr>
            <tr>
                <td>R 10<input type="hidden" class="note_val" value="10"></td>
                <td>{{$invoices[0]->n10}}</td>
                <td>{{$invoices[0]->n10 *10}}</td>
            </tr>
            <tr>
                <td>R 5 <input type="hidden" class="note_val" value="5"></td>
                <td>{{$invoices[0]->n5}}</td>
                <td>{{$invoices[0]->n5 * 5}}</td>
            </tr>
            <tr>
                <td>R 2<input type="hidden" class="note_val" value="2"></td>
                <td>{{$invoices[0]->n2}}</td>
                <td>{{$invoices[0]->n2 * 2}}</td>
            </tr>
            <tr>
                <td>R 1<input type="hidden" class="note_val" value="1"></td>
                <td>{{$invoices[0]->n1}}</td>
                <td>{{$invoices[0]->n1}}</td>
            </tr>
            <tr>
                <td>50c<input type="hidden" class="note_val" value="0.5"></td>
                <td>{{$invoices[0]->n50c}}</td>
                <td>{{$invoices[0]->n50c*0.5}} </td>
            </tr>
            <tr>
                <td>20c<input type="hidden" class="note_val" value="0.2"></td>
                <td>{{$invoices[0]->n20c}}</td>
                <td>{{$invoices[0]->n20c * 0.2}}</td>
            </tr>
            <tr>
                <td>10c <input type="hidden" class="note_val" value="0.1"></td>
                <td>{{$invoices[0]->n10c}}</td>
                <td>{{$invoices[0]->n10c*0.1}}</td>
            </tr>
            <tr>
                <td>5c <input type="hidden" class="note_val" value="0.05"></td>
                <td>{{$invoices[0]->n5c}}</td>
                <td>{{$invoices[0]->n5c*0.05}}</td>
            </tr>
            <tr>
                <td>2c <input type="hidden" class="note_val" value="0.02"></td>
                <td>{{$invoices[0]->n2c}}</td>
                <td>{{$invoices[0]->n2c * 0.02}}</td>
            </tr>
            <tr>
                <td>1c <input type="hidden" class="note_val" value="0.01"></td>
                <td>{{$invoices[0]->n1c}}</td>
                <td>{{$invoices[0]->n1c*0.01}}</td>
            </tr>
            </tbody>
        </table>
        <div class="form-group">
            <h3>CASH DIFFERENCE</h3>
            <table class="table2 table-bordered" id="cash_tray" style="border: 1px solid #312f2f;background: #989292">
                <thead>
                <tr>
                    <td class="col-md-2">Note</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Cash Off Total</td>
                    <td>{{round($invoices[0]->grandTotal,2)}}</td>
                </tr>
                <tr>
                    <td>Cash on Inv</td>
                    <td>{{round($CashCollected,2)}}</td>
                </tr>
                <tr>
                    <td>Differences</td>
                    <td>{{round($invoices[0]->Diff,2)}}</td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>
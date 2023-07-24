@extends('layouts.app')

@section('content')

    <div class="col-lg-3" style="color:black;font-weight: 900;">
        <label for="routename">Delv Date</label>
        <input id="deliveryDate" class="form-control input-sm " >
    </div>
    <div class="col-lg-3">
        <label for="routename">Ref Number</label>
        <input id="referenceNo" class="form-control input-sm " >
    </div>
    <div class="col-lg-3" style="    padding: 7px;">

        <button id="go" style="  margin-top: 6%;padding: 7px;">GO</button>
    </div>
    <div class="col-lg-2 " >
        <button id="newCashOff" style="float: right;padding: 7px;">New Sheet</button>
    </div>
    <div class="col-lg-1" >
        <button id="print_screen" style="float: right;padding: 7px; " value="Print">Print</button>
    </div>

<hr style="background: #0a0a0a;height:3px;">
    <div class="col-lg-12" id="mainboard"   style="height:100%;font-family: Sans-serif;color:black;">
        <a href='{!!url("/getdriverscashoff")!!}' style="background: #78341a;font-weight: 900;color:white;padding:5px;border-color:#411c0e;" >Close Without Exporting</a>
        <div class="col-lg-10" style="height: 100%;">
            <div></div>
            <div class="panel panel-default hidebody" id="toAutoScroll"  >
                <div id="two-columns" >
        <input id="routingId" type="text" ><button class="btn-md btn-primary" id="getroutingidinfo">GET</button>
                    <div class="col-lg-8" style="float:right;">

                        <div class="col-lg-3">
                            <label for="routename">Route Name</label>
                            <input type="text" class="form-control input-sm " id="routename" readonly>
                        </div>
                        <div class="col-lg-3">
                            <label for="drivername">Driver</label>
                            <input type="text" id="drivername" class="form-control input-sm " readonly>
                            <input type="hidden" id="driverId" readonly>
                        </div>
                        <div class="col-lg-3">
                            <label for="assistantdriver">Assistant</label>
                            <input type="text" class="form-control input-sm " id="assistantdriver" readonly>
                        </div>
                        <div class="col-lg-3">
                            <label for="deliverydate">Del Date</label>
                            <input type="text" class="form-control input-sm " id="deliverydate" readonly>
                        </div>

                    </div>
                    <div style="    height: 80%;min-height: 200px;overflow: scroll;width: 100%;">
                        <button type="button" id="button_row" class="btn-xs btn-success">Add</button>
        <table class="table table-bordered table-condensed" tabindex=0 id="cashoftable" style="overflow-y: auto;width:100%;color: black;    font-weight: 700;" tabindex=0" >
            <thead style="font-size: 17px;">
            <tr>
                <th class="col-md-2">Name</th>
                <th class="col-sm-1">Code</th>
                <th >InvoiceNo</th>
                <th class="col-sm-1">InvoiceAmount</th>
                <th class="col-sm-1">Cash</th>
                <th class="col-sm-1">Chq</th>
                <th class="col-sm-1">EFT</th>
                <th class="col-sm-1">Acc</th>
                <th class="col-sm-1">Unpaid</th>
                <th class="col-sm-1">Terms</th>
                <th class="col-sm-1">Company</th>
            </tr>
            </thead>
            <tbody>

            </tbody>

        </table>
                </div>
            <div style="margin-top:10%;background: #eaeaea;">
                <h5>EXPENSES</h5>
                <table class="table table-bordered table-condensed" id="tblexpenses">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>GLCode</th>
                        <th>ExportReference</th>
                        <th>TaxID</th>
                    </tr>
                    </thead>
                    <tbody id="rowc">


                    @foreach($tax as $val)
                        <tr>
                            <td><input name="type" id="type" class="type set_autocomplete inputs"></td>
                            <td><input name="amount" id="amount" class="amount set_autocomplete inputs"></td>
                            <td>
                                <select id="glcode" name="glcode" class="glcode resize-input-inside inputs">
                                    <option value="-99"></option>
                            @foreach($glCode as $valGLCode)
                                <option value="{{$valGLCode->GLCode}}">{{$valGLCode->GLCodeDesc}}</option>
                                @endforeach
                                </select>
                            </td>
                            <td><input name="exportreference" id="exportreference" class="exportreference set_autocomplete inputs"></td>
                            <td>
                                <select id="taxID" name="taxID" class="taxID resize-input-inside inputs">
                                    <option value="-99"></option>
                                    @foreach($tax as $valtax)
                                        <option value="{{$valtax->TaxId}}">{{$valtax->TaxCode}}</option>
                                    @endforeach
                                </select>
                            </td>

                        </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
            </div>
        </div>
        <div class="col-lg-2" style="height: 100%;font-size: 11px;">



            <div class="form-group">
                <label class="control-label" for="cashtotals"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Message</label>
                <textarea class="form-control input-sm " id="notes"></textarea>
            </div>
            <div class="form-group"  >
                <table class="table2 table-bordered" id="cash_tray" style="border: 1px solid #312f2f;background: #989292;font-size: 11px;">
                    <thead>
                    <tr>
                        <td class="col-md-2">Note</td>
                        <td>Qty</td>
                        <td>Total</td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>R 200<input type="hidden" class="note_val" value="200"></td>
                            <td><input type="text" id="qty_200" pattern="^\d*(\.\d{0,2})?$" class="qty_notes q" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                            <td><input type="number" id="total_note_200" class="total_notes n" onkeypress="return isFloatNumber(this,event)" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td>R 100<input type="hidden" class="note_val" value="100"></td>
                            <td><input type="text" id="qty_100" class="qty_notes q" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                            <td><input type="number" id="total_note_100" class="total_notes n" onkeypress="return isFloatNumber(this,event)" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td>R 50 <input type="hidden" class="note_val" value="50"></td>
                            <td><input type="text" id="qty_50" class="qty_notes q" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                            <td><input type="number" id="total_note_50" class="total_notes n" onkeypress="return isFloatNumber(this,event)" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td>R 20 <input type="hidden" class="note_val" value="20"></td>
                            <td><input type="text" id="qty_20"class="qty_notes q" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                            <td><input type="number" id="total_note_20" class="total_notes" onkeypress="return isFloatNumber(this,event)" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td>R 10<input type="hidden" class="note_val" value="10"></td>
                            <td><input type="text" id="qty_10" class="qty_notes q"  onkeypress="return isFloatNumber(this,event)" value="0"></td>
                            <td><input type="number" id="total_note_10" class="total_notes n" onkeypress="return isFloatNumber(this,event)" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td>R 5 <input type="hidden" class="note_val" value="5"></td>
                            <td><input type="text" id="qty_5" class="qty_notes q" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                            <td><input type="number" id="total_note_5" class="total_notes n" onkeypress="return isFloatNumber(this,event)" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td>R 2<input type="hidden" class="note_val" value="2"></td>
                            <td><input type="text" id="qty_2" class="qty_notes q" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                            <td><input type="number" id="total_note_2" class="total_notes n" onkeypress="return isFloatNumber(this,event)" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td>R 1<input type="hidden" class="note_val" value="1"></td>
                            <td><input type="text" id="qty_1" class="qty_notes q" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                            <td><input type="number" id="total_note_1" class="total_notes n" onkeypress="return isFloatNumber(this,event)" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td>50c<input type="hidden" class="note_val" value="0.5"></td>
                            <td><input type="text" id="qty_50c" class="qty_notes q" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                            <td><input type="number" id="total_note_50c" class="total_notes n" onkeypress="return isFloatNumber(this,event)" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td>20c<input type="hidden" class="note_val" value="0.2"></td>
                            <td><input type="text" id="qty_20c" class="qty_notes q" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                            <td><input type="number" id="total_note_20c"class="total_notes n" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                        </tr>
                        <tr>
                            <td>10c <input type="hidden" class="note_val" value="0.1"></td>
                            <td><input type="text" id="qty_10c" class="qty_notes q" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                            <td><input type="number" id="total_note_10c" class="total_notes n" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                        </tr>
                        <tr>
                            <td>5c <input type="hidden" class="note_val" value="0.05"></td>
                            <td><input type="text" id="qty_5c" class="qty_notes q" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                            <td><input type="number" id="total_note_5c" class="total_notes n" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                        </tr>
                        <tr>
                            <td>2c <input type="hidden" class="note_val" value="0.02"></td>
                            <td><input type="text" id="qty_2c" class="qty_notes q" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                            <td><input type="number" id="total_note_2c" class="total_notes n" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                        </tr>
                        <tr>
                            <td>1c <input type="hidden" class="note_val" value="0.01"></td>
                            <td><input type="text" id="qty_1c" class="qty_notes q" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                            <td><input type="number" id="total_note_1c" class="total_notes n" onkeypress="return isFloatNumber(this,event)" value="0"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <label class="control-label" for="cashtotals"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Cash Collected</label>
                    <input type="text" class="form-control input-sm "  id="cashtotals" onkeypress="return isFloatNumber(this,event)" >
                </div>
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
                            <td>Invoices</td>
                            <td><input type="number" class="form-control input-sm "  id="invtotals" readonly></td>
                        </tr>
                        <tr>
                            <td>Expenses</td>
                            <td><input type="number" class="input-sm "  id="expensestotal" readonly></td>
                        </tr>
                        <tr>
                            <td>Differences</td>
                            <td><input type="number" class="input-sm "  id="differences" readonly><button id="recalculatediff" >Recalculate</button></td>
                        </tr>

                        </tbody>
                    </table>
                </div>

            </div>


            <div valign="bottom" style="float: right;">
                <button class="btn-md btn-danger" id="Save" style="padding:18px;float: right;margin-bottom: 5px;display: none;" value="save">SAVE CASHOFF</button><br>
                <button class="btn-md btn-primary" id="exportdriverscash" value="export">EXPORT OVERS AND UNDERS</button>

            </div>
        </div>
    </div>
    <div id="referenceTableDialog">
        <input type="text" class="col-md-5" id="myInput" onkeyup="myFunction()" placeholder="Search Ref..."><button id="advancesearchreference" class="btn-primary btn-md">Advance</button>
        <table id="tablewithreference" class="table2 table-bordered ">
            <thead>
            <tr>
                <td>Ref</td>
                <td>Driver</td>
                <td>RoutingId</td>
                <td>DeliveryDate</td>
            </tr>
            </thead>
            <tbody id="gridEditProducts">
            @foreach($references as $val)
                <tr>
                    <td><input name="Ref_" id ="Ref_{{$val->Ref}}" class="Ref_ set_autocomplete inputs" value="{{$val->Ref}}" ></td>
                    <td><input name="DriverName_" id ="DriverName_{{$val->DriverName}}" class="DriverName_ set_autocomplete inputs" value="{{$val->DriverName}}" ></td>
                    <td><input name="DeliveryDateRoutingID_" id ="DeliveryDateRoutingID_{{$val->DeliveryDateRoutingID}}" class="DeliveryDateRoutingID_ set_autocomplete inputs" value="{{$val->DeliveryDateRoutingID}}" ></td>
                    <td><input name="DeliveryDate_" id ="DeliveryDate_{{$val->DeliveryDate}}" class="DeliveryDate_ set_autocomplete inputs" value="{{$val->DeliveryDate}}" ></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

<link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet">
<script>
    var tax = JSON.stringify({!! json_encode($tax) !!});
    var openSheet =0;
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).keydown(function(e) {
        if (e.keyCode == 27) return false;
    });
    $(document).ready(function() {
        var today = new Date();

        $("#deliveryDate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $('#referenceNo').click(function(){
            var delDate = $("#deliveryDate").val();
            if ($.trim(delDate).length > 7)
            {
                //pull date from t
                $('#referenceNo').val("Testing");
            }else{
                $('#referenceTableDialog').show();
                showDialog('#referenceTableDialog',500,300);
                $('#tablewithreference tbody').on('dblclick', 'tr', function () {
                    var doublecLickedRef = $(this).closest('tr').find('.Ref_').val();
                    $('#referenceNo').val(doublecLickedRef);
                    getDiversCashOffs("USEREF",doublecLickedRef);
                    $('#referenceTableDialog').dialog('close');
                    $('#mainboard').show();
                });
            }

        });

        $.each(JSON.parse(tax), function (i, o) {
            //console.debug("i======================"+i+"----------------------------------"+o.TaxId);
        });
        $('#orderListing').hide();

        $('#pricing').hide();
        $('#pricingOnCustomer').hide();
        $('#callList').hide();
        $('#tabletLoadingApp').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#salesInvoiced').hide();
        $('#posCashUp').hide();
        $('#mainboard').hide();
        $('#referenceTableDialog').hide();
        $('.qty_notes').select();
        $('.total_notes').select();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#newCashOff').click(function(){
            var dialog = $('<p><strong style="color:red">Do you want to create new sheet?</strong></p>').dialog({
                height: 200, width: 700,modal: true,containment: false,
                buttons: {
                    "YES": function () {
                        if (openSheet > 0)
                        {
                            var dialogNewSheet = $('<p><strong style="color:red">There is a Cash Off page opened do you want to discard the changes ?</strong></p>').dialog({
                                height: 200, width: 700,modal: true,containment: false,
                                buttons: {
                                    "YES": function () {
                                        dialogNewSheet.dialog('close');
                                        dialog.dialog('close');
                                            openNewSheets();
                                    },
                                    "NO": function () {
                                        dialogNewSheet.dialog('close');
                                    }
                                }
                            });

                        }else{
                            openNewSheets();
                            dialog.dialog('close');
                        }

                    },
                    "NO": function () {
                        dialog.dialog('close');
                    }
                }
            });

        });

        $.ajax({
            url: '{!!url("/getDriversCashOffReference")!!}',
            type: "POST",
            data: {
                referenceNo: $('#referenceNo').val(),
            },success: function (data) {
            }
        });
        $('#go').click(function(){
           /* if ($.trim($('#referenceNo').val()).length > 0)
            {*/
                $('#Save').click();
            //}
            getDiversCashOffs("USEREF",$('#referenceNo').val());
        });
        //Deprecated
        $('#getroutingidinfo').click(function(){
            getDiversCashOffs("ROUTING",$('#routingId').val());
        });

        $('#exportdriverscash,#Save,#print_screen').click(function(){
            var btnVal = $(this).val();
            var xmls = new Array();
            var xmlsExpense = new Array();
            var xmlsCashQtyCollected = new Array();
            var xmlsCashNotesCollected = new Array();
            calculatorCash();
            var totalPrice = 0;
            $('#cash_tray tbody tr').each(function () {

                $(this).find(".total_notes").each(function () {
                    totalPrice = parseFloat(totalPrice) + (parseFloat($(this).val())) ;
                });
            });
            //$('#cashtotals').val(totalPrice.toFixed(2));
            var cashDiff =parseFloat($('#cashtotals').val())- parseFloat($('#invtotals').val())+parseFloat($('#expensestotal').val())  ;
            $('#differences').val(cashDiff);
            $('#cashoftable > tbody  > tr').each(function() {

                console.debug($(this).closest('tr').find('.invoiceno_').val());
                if( ($(this).closest('tr').find('.invoiceno_').val()).length > 4)
                {
                    //alert($(this).closest('tr').find('.invoiceno_').val());
                    xmls.push({
                        'invoiceno_': $(this).closest('tr').find('.invoiceno_').val(),
                        'cashcollected_': $(this).closest('tr').find('.cashcollected_').val(),
                        'OwnerID_': $(this).closest('tr').find('.OwnerID_').val(),
                        'Chq_': $(this).closest('tr').find('.Chq_').val(),
                        'EFT_': $(this).closest('tr').find('.EFT_').val(),
                        'Acc_': $(this).closest('tr').find('.Acc_').val(),
                        'Unpaid': $(this).closest('tr').find('.Unpaid').val()
                    });
                }
            });

            xmlsCashQtyCollected.push({
                'q200q': $('#qty_200').val(), 'q100q': $('#qty_100').val(), 'q50q': $('#qty_50').val(), 'q20q': $('#qty_20').val(),
                'q10q': $('#qty_10').val(), 'q5q': $('#qty_5').val(), 'q2q': $('#qty_2').val(), 'q1q': $('#qty_1').val(), 'q50cq': $('#qty_50c').val(),
                'q20cq': $('#qty_20c').val(), 'q10cq': $('#qty_10c').val(), 'q5cq': $('#qty_5c').val(), 'q2cq': $('#qty_2c').val(), 'q1cq': $('#qty_1c').val()
            });
            xmlsCashNotesCollected.push({
                'n200n': $('#total_note_200').val(), 'n100n': $('#total_note_100').val(), 'n50n': $('#total_note_50').val(), 'n20n': $('#total_note_20').val(),
                'n10n': $('#total_note_10').val(), 'n5n': $('#total_note_5').val(), 'n2n': $('#total_note_2').val(), 'n1n': $('#total_note_1').val(),
                'n50cn': $('#total_note_50c').val(), 'n20cn': $('#total_note_20c').val(), 'n10cn': $('#total_note_10c').val(), 'n5cn': $('#total_note_5c').val(),
                'n2cn': $('#total_note_2c').val(), 'n1cn': $('#total_note_1c').val()
            });
            console.debug(xmls);
            $('#tblexpenses > tbody  > tr').each(function() {
                //taxID
                if( $(this).closest('tr').find('.amount').val() != 0 && $(this).closest('tr').find('.glcode').val() != -99 && $(this).closest('tr').find('.taxID').val() != -99 ) {
                    xmlsExpense.push({
                        'type': $(this).closest('tr').find('.type').val(),
                        'amount': $(this).closest('tr').find('.amount').val(),
                        'glcode': $(this).closest('tr').find('.glcode').val(),
                        'taxID': $(this).closest('tr').find('.taxID').val(),
                        'exportReference': $(this).closest('tr').find('.exportreference').val(),
                    });
                }
            });

        if(xmlsExpense.length <1) {
                xmlsExpense.push({
                    'type': '0',
                    'amount': '0',
                    'glcode': '0',
                    'taxID': '0',
                    'exportReference':'0',
                });
            }
            console.debug(xmlsExpense);
            $.ajax({
                url: '{!!url("/postDriversCashOff")!!}',
                type: "POST",
                data: {
                    xmls: xmls,
                    xmlsExpense: xmlsExpense,
                    driverId:$('#driverId').val(),
                    routingID:$('#routingId').val(),
                    notes:$('#notes').val(),
                    cashtotals:$('#cashtotals').val(),
                    invtotals:$('#invtotals').val(),
                    btnVal:btnVal,
                    ref:$('#referenceNo').val(),
                    xmlcashqty:xmlsCashQtyCollected,
                    xmlcashNotes:xmlsCashNotesCollected
                },
                success: function (data) {
                    if (data == "Print") {
                        //PRINT
                        window.open('{!!url("/printDriversCashOff")!!}/'+$('#referenceNo').val() , "cashprint", "width=760, height=500, scrollbars=yes");

                    }else{
                    var dialog = $('<p><strong style="color:red">Data saved, would you like do post the cash off</strong></p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "Yes": function () {
                                dialog.dialog('close');
                                $.ajax({
                                    url: '{!!url("/exportCashOff")!!}',
                                    type: "POST",
                                    data: {
                                        ref: $('#referenceNo').val()
                                    },
                                    success: function (data) {

                                        location.reload(true);
                                    }
                                });
                            },
                            "No": function () {
                                dialog.dialog('close');
                                location.reload(true);
                            }
                        }
                    });
                }

                }
            });

        });

        $(document).on('keydown', '.inputs', function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            var testLst = $(this).closest('tr');
            if ((code == 13 || code == 39)) {
                var index = $('.inputs').index(this) + 1;
                $('.inputs').eq(index).focus();
            }
            if (code == 37) {
                var index = $('.inputs').index(this) - 1;
                $('.inputs').eq(index).focus();
                calculatorCash();
            }
            calculatorCash();

        });
        $('#button_row').click(function () {

            generateALine2();
        });


    });
    $(document).on('keyup', '.cashcollected_', function(e) {
        calculatorCash();
    });

    function isFloatNumber(item,evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode==46)
        {
            var regex = new RegExp(/\./g)
            var count = $(item).val().match(regex).length;
            if (count > 1)
            {
                return false;
            }
        }
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    function getDiversCashOffs(referencetype,referenceid)
    {
        $.ajax({
            url: '{!!url("/getDriversCashOffJson")!!}',
            type: "POST",
            data: {
                refNo:referenceid,
                refType:referencetype
            },
            success: function (data) {
                var trHTML = '';
                var trHTML = '';
                var trHTMLExpens = '';
                $('.fast_remove').empty();
                var totalCash = 0;
                var totalExpenses = 0;
                calculatorCash();
                $.each(data.expenses, function (key, value) {

                    trHTMLExpens += '<tr>'+
                    '<td><input name="type" id="type" class="type set_autocomplete inputs"  value="'+value.Type+'" ></td>'+
                    '<td><input name="amount" id="amount" class="amount set_autocomplete inputs" value="'+value.Amount+'"></td>'+
                    '<td>'+
                    '<select id="glcode" name="glcode" class="glcode resize-input-inside inputs">'+
                    '<option value="'+value.GLCode+'">'+value.GLCodeDesc+'</option> </select></td>'+
                    '<td><input name="exportreference" id="exportreference" class="exportreference set_autocomplete inputs" value="'+value.exportRef+'"></td>'+
                     '<td>'+
                        '<select id="taxID" name="taxID" class="taxID resize-input-inside inputs">'+
                    '<option value="'+value.TaxId+'">'+value.TaxCode+'</option></select>  </td>  </tr>';
                    totalExpenses =  parseFloat(totalExpenses)+parseFloat(value.Amount);

                });

                $("#tblexpenses tbody").prepend(trHTMLExpens);
                $.each(data.infoList, function (key, value) {
                    var tokenId=new Date().valueOf();
                    trHTML += '<tr class="fast_remove" style="font-size: 12px;color:black">' +
                        '<td contenteditable="false" class="col-sm-1"><input name="StoreName" id ="StoreName_'+tokenId+value.orderid+'" value="'+value.StoreName+'"   class="StoreName set_autocomplete inputs"></td>' +
                        '<td contenteditable="false" class="col-sm-1"><input name="CustomerPastelCode" id ="CustomerPastelCode'+tokenId+'" value="'+value.CustomerPastelCode+'"   class="CustomerPastelCode set_autocomplete inputs"></td>' +
                        '<td contenteditable="false" class="col-sm-1"><input name="invoiceno" id ="invoiceno_'+tokenId+'" value="'+value.InvoiceNo+'"   class="invoiceno_ set_autocomplete inputs"></td>' +
                        '<td contenteditable="false" class="col-md-1"><input name="invoicetotal_" value="'+parseFloat(value.mnyTotal).toFixed(2)+'" id ="invoicetotal_'+tokenId+value.orderid+'" class="invoicetotal_ set_autocomplete inputs"  tabindex="-1"></td>' +
                        '<td style=""  contenteditable="false" class="col-md-1"><input type="text" value="'+parseFloat(value.captured).toFixed(2)+'" name="cashcollected_"  id ="cashcollected_'+tokenId+value.orderid+'" class="cashcollected_ resize-input-inside inputs" onkeypress="return isFloatNumber(this,event)" ></td>' +
                        '<td style=""  contenteditable="false" class="col-md-1"><input type="text" value="'+parseFloat(value.Chq).toFixed(2)+'" name="Chq_"  id ="Chq_'+tokenId+'" class="Chq_ resize-input-inside inputs" onkeypress="return isFloatNumber(this,event)" ></td>' +
                        '<td style=""  contenteditable="false" class="col-md-1"><input type="text" value="'+parseFloat(value.EFT).toFixed(2)+'" name="EFT_"  id ="EFT_'+tokenId+'" class="EFT_ resize-input-inside inputs" onkeypress="return isFloatNumber(this,event)" ></td>' +
                        '<td style=""  contenteditable="false" class="col-md-1"><input type="text" value="'+parseFloat(value.Acc).toFixed(2)+'" name="Acc_"  id ="Acc_'+tokenId+'" class="Acc_ resize-input-inside inputs" onkeypress="return isFloatNumber(this,event)" ></td>' +
                        '<td style=""  contenteditable="false" class="col-md-1"><input type="text" value="'+parseFloat(value.Unpaid).toFixed(2)+'" name="Unpaid"  id ="Unpaid'+tokenId+'" class="Unpaid resize-input-inside inputs" onkeypress="return isFloatNumber(this,event)" ></td>' +
                        '<td  contenteditable="false" class="col-md-1"><input type="text" name="terms_" value="'+value.strPaymentTerm+'" id ="terms_'+tokenId+'"   onkeypress="return isFloatNumber(this,event)"   class="terms_ resize-input-inside inputs"></td>' +
                        '<td contenteditable="false"  class="col-md-1"><input type="text" name="CompanyName_" value="'+value.CompanyName+'" id ="CompanyName_'+tokenId+'"  class="CompanyName_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" >' +
                        '<input type="hidden" name="OwnerID" value="'+value.OwnerID+'" id ="OwnerID_'+tokenId+'"  class="OwnerID_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" >' +
                        '<input type="hidden" name="customerid" value="'+value.CustomerId+'" id ="CustomerId'+tokenId+'"  class="CustomerId resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
                        '</tr>';
                    $('#routename').val(value.Route);
                    $('#drivername').val(value.DriverName);
                    $('#assistantdriver').val(value.AssistantDriver);
                    $('#deliverydate').val(value.DeliveryDate);
                    $('#driverId').val(value.DriverId);
                    openSheet++;
                    totalCash = parseFloat(totalCash)+parseFloat(value.captured);
                   // console.debug("************totalCash"+totalCash);
                });
                $('#cashoftable').append(trHTML);
                $('#invtotals').val(totalCash);
                $('#expensestotal').val(totalExpenses);
                $('#routingId').val(data.reference[0].DeliveryDateRoutingID);
                $('#referenceNo').val(data.reference[0].Ref);
                if( (data.reference[0].Exported) == "1")
                {
                    $("#exportdriverscash").prop("disabled", true).css('opacity',0.5);
                    $(':button').prop('disabled', true);
                    $(':input').prop('disabled', true);
                    $('#print_screen').prop('disabled', false);
                    $('#newCashOff').prop('disabled', false);
                    //
                }
                $('#differences').val(parseFloat( data.cashoffcash[0].grandTotal - totalCash + totalExpenses).toFixed(2));
                //cashoffcash
                $('#cashtotals').val(data.cashoffcash[0].grandTotal);
                $('#qty_200').val(data.cashoffcash[0].n200q);
                $('#qty_100').val(data.cashoffcash[0].n100q);
                $('#qty_50').val(data.cashoffcash[0].n50q);
                $('#qty_20').val(data.cashoffcash[0].n20q);
                $('#qty_10').val(data.cashoffcash[0].n10q);
                $('#qty_5').val(data.cashoffcash[0].n5q);
                $('#qty_2').val(data.cashoffcash[0].n2q);
                $('#qty_1').val(data.cashoffcash[0].n1q);
                $('#qty_50c').val(data.cashoffcash[0].n50cq);
                $('#qty_20c').val(data.cashoffcash[0].n20cq);
                $('#qty_10c').val(data.cashoffcash[0].n10cq);
                $('#qty_5c').val(data.cashoffcash[0].n5cq);
                $('#qty_2c').val(data.cashoffcash[0].n2cq);
                $('#qty_1c').val(data.cashoffcash[0].n1cq);

                $('#total_note_200').val(data.cashoffcash[0].t200);
                $('#total_note_100').val(data.cashoffcash[0].t100);
                $('#total_note_50').val(data.cashoffcash[0].t50);
                $('#total_note_20').val(data.cashoffcash[0].t20);
                $('#total_note_10').val(data.cashoffcash[0].t10);
                $('#total_note_5').val(data.cashoffcash[0].t5);
                $('#total_note_2').val(data.cashoffcash[0].t2);
                $('#total_note_1').val(data.cashoffcash[0].t1);
                $('#total_note_50c').val(data.cashoffcash[0].t50c);
                $('#total_note_20c').val(data.cashoffcash[0].t20c);
                $('#total_note_10c').val(data.cashoffcash[0].t10c);
                $('#total_note_5c').val(data.cashoffcash[0].t5c);
                $('#total_note_2c').val(data.cashoffcash[0].t2c);
                $('#total_note_1c').val(data.cashoffcash[0].t1c);
                console.debug("I am reference"+data.reference[0].Ref);
            }
        });
    }
    function openNewSheets()
    {
        $('#mainboard').show();
        $.ajax({
            url: '{!!url("/createnewsheet")!!}',
            type: "POST",
            data: {
                referenceNo: $('#referenceNo').val()
            },success: function (data) {
                //console.debug(data);
                $('#referenceNo').val(data[0].Results);
                getDiversCashOffs("USEREF",data[0].Results);

            }
        });
    }
    function calculateUnpaid()
    {
        var TotalPaidPerOrder = 0;
        var TotalUnpaid = 0;
        $('#cashoftable tbody tr').each(function () {
            var $this = $(this);
            var cash = 0;
            var chq = 0;
            var EFT_ = 0;
            var Acc_ = 0;
            var individualCash =$this.closest("tr").find(".cashcollected_").val();
            var individualChq_ = $this.closest("tr").find(".Chq_").val();
            var individualEFT_ = $this.closest("tr").find(".EFT_").val();
            var individualAcc_ = $this.closest("tr").find(".Acc_").val();
            var invoicetotal_ = $this.closest("tr").find(".invoicetotal_").val();


            TotalPaidPerOrder = parseFloat(individualChq_).toFixed(2)+parseFloat(individualEFT_).toFixed(2)+parseFloat(individualAcc_).toFixed(2)+parseFloat(individualCash).toFixed(2);
            TotalUnpaid = parseFloat(invoicetotal_).toFixed(2) - parseFloat(TotalPaidPerOrder).toFixed(2);
           // $(this).find(".Unpaid").val(TotalUnpaid);

        });
    }

    function calculatorCash() {

        var sumTotalCost = 0.00;
        var totalPrice = 0.00;
        var Expenses = 0.00;
        $('#cashoftable tbody tr').each(function () {


            $(this).find(".cashcollected_").each(function () {
                     if(($.trim($(this).val())).length <1 )
                     {
                         totalPrice = parseFloat(totalPrice) + (parseFloat(0)) ;
                     }else{
                         totalPrice = parseFloat(totalPrice) + (parseFloat($(this).val())) ;
                     }

            });
        });
        $('#tblexpenses tbody tr').each(function () {


            $(this).find(".amount").each(function () {
                     if(($.trim($(this).val())).length <1 )
                     {
                         Expenses = parseFloat(Expenses) + (parseFloat(0)) ;
                     }else{
                         Expenses = parseFloat(Expenses) + (parseFloat($(this).val())) ;
                     }

            });
        });
        $('#invtotals').val(totalPrice);
        $('#expensestotal').val(Expenses);
        calculateUnpaid();
    }
    function generateALine2()
    {
        var tokenId=new Date().valueOf();
        var $row = $('<tr class="fast_remove" id="new_row_ajax'+tokenId+'" style="font-size: 13px;color:black">' +
            '<td contenteditable="false" class="col-sm-1"><input name="StoreName" id ="StoreName_'+tokenId+'"    class="StoreName set_autocomplete inputs rem"></td>' +
            '<td contenteditable="false" class="col-sm-1"><input name="CustomerPastelCode" id ="CustomerPastelCode'+tokenId+'"    class="CustomerPastelCode set_autocomplete inputs rem"></td>' +
            '<td contenteditable="false" class="col-sm-1"><input name="invoiceno" id ="invoiceno_'+tokenId+'"   class="invoiceno_ set_autocomplete inputs rem"></td>' +
            '<td contenteditable="false" class="col-md-1"><input name="invoicetotal_" id ="invoicetotal_'+tokenId+'" class="invoicetotal_ set_autocomplete inputs"  tabindex="-1"></td>' +
            '<td style=""  contenteditable="false" class="col-md-1"><input type="text"  name="cashcollected_"  id ="cashcollected_'+tokenId+'" class="cashcollected_ resize-input-inside inputs" onkeypress="return isFloatNumber(this,event)" ></td>' +
            '<td style=""  contenteditable="false" class="col-md-1"><input type="text"  name="Chq_"  id ="Chq_'+tokenId+'" class="Chq_ resize-input-inside inputs" onkeypress="return isFloatNumber(this,event)" ></td>' +
            '<td style=""  contenteditable="false" class="col-md-1"><input type="text" name="EFT_"  id ="EFT_'+tokenId+'" class="EFT_ resize-input-inside inputs" onkeypress="return isFloatNumber(this,event)" ></td>' +
            '<td style=""  contenteditable="false" class="col-md-1"><input type="text"  name="Acc_"  id ="Acc_'+tokenId+'" class="Acc_ resize-input-inside inputs" onkeypress="return isFloatNumber(this,event)" ></td>' +
            '<td style=""  contenteditable="false" class="col-md-1"><input type="text"  name="Unpaid"  id ="Unpaid'+tokenId+'" class="Unpaid resize-input-inside inputs" onkeypress="return isFloatNumber(this,event)" ></td>' +
            '<td  contenteditable="false" class="col-md-1"><input type="text" name="terms_"  id ="terms_'+tokenId+'"   onkeypress="return isFloatNumber(this,event)"   class="terms_ resize-input-inside inputs"></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="CompanyName_"  id ="CompanyName_'+tokenId+'"  class="CompanyName_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" >' +
            '<input type="hidden" name="OwnerID" value="1" id ="OwnerID_'+tokenId+'"  class="OwnerID_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" >' +
            '<input type="hidden" name="customerid" id ="CustomerId'+tokenId+'"  class="CustomerId resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
            '</tr>');
        $('#cashoftable tbody')
        .append( $row )
        .trigger('addRows', [ $row, false ]);
        $('input').on('click keyup' ,function() {
            // $('input').click(function(){
           // console.debug($(this));
            var ID = $(this).attr('id');
            var jID = '#' + ID;

          //  var x = ID.indexOf("_");
          //  var get_token_number = ID.substring(x + 1, ID.length);
            if ($(this).hasClass("invoiceno_") && $(this).hasClass("set_autocomplete")) {
                $("" + jID + "").autocomplete({
                    source: '{!!url("/invoiceLookUp")!!}',
                    minlength: 2,
                    autoFocus: true,
                    select: function (e, ui) {
                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        //  $('#invoiceNo').val(ui.item.value);
                        // $('#orderId').val(ui.item.id);

                        $('#StoreName_' + token_number).val(ui.item.StoreName);
                        $('#CustomerPastelCode' + token_number).val(ui.item.CustomerPastelCode);
                        $('#CompanyName_' + token_number).val(ui.item.CompanyName);
                        $('#terms_' + token_number).val(ui.item.PaymentTerms);
                        $('#cashcollected_' + token_number).val(0);
                        $('#invoicetotal_' + token_number).val(ui.item.mnyTotal);
                        $('#Chq_' + token_number).val(0);
                        $('#EFT_' + token_number).val(0);
                        $('#Acc_' + token_number).val(0);
                        $('#Unpaid' + token_number).val(0);
                        $('#OwnerID_' + token_number).val(ui.item.OwnerID);
                        $('#CustomerId' + token_number).val(ui.item.CustomerId);

                    }
                }).data("ui-autocomplete")._renderItem = function (ul, item) {
                    var table = '<table class="table2"><tr style="font-size: 12px;color:black"><td style="background: green;width:25px;color:white">' +
                        item.value + '</td><td>' +
                        item.CustomerPastelCode + '</td><td>' +
                        item.StoreName + '</td>' +
                        '</tr></table>';
                    return $("<li>")
                        .data("ui-autocomplete-item", item)
                        .append("<a>" + table + "</a>")
                        .appendTo(ul);
                };
            }
        });

        calculateUnpaid();
    }
    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("gridEditProducts");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    function showDialog(tag,width,height)
    {
        $( tag ).dialog({height: height, modal: false,
            width: width,containment: false}).dialogExtend({
            "closable" : true, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class

                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });
    }
    $(document).on('keyup', '.qty_notes', function(e) {

        var qty= $(this).closest("tr").find(".qty_notes").val();
        var total_notes = $(this).closest("tr").find(".total_notes").val();
        var note_val = $(this).closest("tr").find(".note_val").val();
        var linetotal = qty * note_val;
        $(this).closest("tr").find(".total_notes").val(linetotal.toFixed(2));
        var totalPrice = 0;
        $('#cash_tray tbody tr').each(function () {

            $(this).find(".total_notes").each(function () {
                totalPrice = parseFloat(totalPrice) + (parseFloat($(this).val())) ;
            });
        });
        $('#cashtotals').val(totalPrice.toFixed(2));
        var cashDiff =parseFloat($('#cashtotals').val())- parseFloat($('#invtotals').val()) ;
        $('#differences').val(cashDiff);
    });

    $(document).on('keyup', '.Chq_', function(e) {
        calculateUnpaid();
    });
    $(document).on('keyup', '.EFT_', function(e) {
        calculateUnpaid();
    });
    $(document).on('dblclick', '.StoreName', function(e) {
        var ID = $(this).attr('id');
        var jID = '#' + ID;
        var n = ID.indexOf("_");
        var token_number = ID.substring(n + 1, ID.length);
        var dialogthis = $('<p><strong style="color:red">Remove line</strong></p>').dialog({
            height: 200, width: 700,modal: true,containment: false,
            buttons: {
                "YES": function () {
                    $('#new_row_ajax'+token_number).remove();
                    dialogthis.dialog('close');
                },
                "NO": function () {
                    dialogthis.dialog('close');
                }
            }
        });
    });
    $(document).on('click', '.StoreName', function(e) {
        var ID = $(this).attr('id');
        var jID = '#' + ID;
        var n = ID.indexOf("_");
        var token_number = ID.substring(n + 1, ID.length);

        $('#cashcollected_'+token_number).val($('#invoicetotal_'+token_number).val());
      //  alert( $('#cashcollected_'+token_number).val() +'*************'+$('#invoicetotal_'+token_number).val());

    });
    $(document).on('click', '#recalculatediff', function(e) {
        calculatorCash();
        var totalPrice = 0;
        $('#cash_tray tbody tr').each(function () {

            $(this).find(".total_notes").each(function () {
                totalPrice = parseFloat(totalPrice) + (parseFloat($(this).val())) ;
            });
        });
        //$('#cashtotals').val(totalPrice.toFixed(2));
        var cashDiff =parseFloat($('#cashtotals').val())- parseFloat($('#invtotals').val())+parseFloat($('#expensestotal').val())  ;
        $('#differences').val(cashDiff);
    });
    $(document).on('keydown', '.q', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        // var testLst = $(this).closest('tr');
        if ((code == 13 || code==39) ) {
            var index = $('.q').index(this) + 1;
            $('.q').eq(index).focus();
        }
        if(code==40)
        {
            var index = $('.q').index(this) +1;
            $('.q').eq(index).focus();
        }
        if (code == 38)
        {
            var index = $('.q').index(this) -1;
            $('.q').eq(index).focus();
        }

    });
</script>
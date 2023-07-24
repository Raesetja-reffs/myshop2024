@extends('layouts.app')

@section('content')

    <div class="col-lg-12"  >
        <a href='{!!url("/invoicesnotprinting")!!}' onclick="window.open(this.href, 'invoicesnotprinting',
'left=20,top=20,width=500,height=600,toolbar=1,resizable=0'); return false;" style="color:black;font-size: 15px;font-weight:900;background: red;padding: 2px;">Check Again</a>
        <h3>Invoices needed before the truck sheet gets printed</h3>
        <table class="table2" tabindex=0 id="tblMassProducts" style="font-size:13px;  color: black;overflow-y: scroll; width: 100%;font-family: monospace;" >
            <thead style="font-size: 17px;">
                <tr>
                    <th class="col-sm-1">InvoiceNo</th>
                    <th class="col-sm-1">OrderId</th>
                    <th class="col-sm-1">Account</th>
                    <th class="col-sm-1">Route</th>
                    <th class="col-sm-1">Delivery Type</th>
                    <th class="col-sm-1">Date Created</th>
                    <th class="col-sm-1">Delivery Date</th>
                    <th class="col-sm-1">Create By</th>
                    <th class="col-sm-8">Reason</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($notprinted as $val)
                <tr>
                    <td>{{$val->DocNumber}}</td>
                    <td>{{$val->DIMS_OrderId}}</td>
                    <td>{{$val->CustomerNumber}}</td>
                    <td>{{$val->UserDef12}}</td>
                    <td>{{$val->UserDef14}}</td>
                    <td>{{$val->OrderDate}}</td>
                    <td>{{$val->DeliveryDate}}</td>
                    <td>{{$val->UserDef10}}</td>
                    <td>{{$val->ErrorMessage}}</td>
                    <td><input type="checkbox" name="caseProd[]" style="height:20px !important;width:30px" value="{{$val->DocNumber}}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-lg-12">
            <div class="col-lg-4">
                <button id="selectAll" style="margin-top: 20px;" class="btn-danger btn-md ">Select All</button>
            </div>
            <div class="col-lg-4">
                <button id="Deselectselect" style="margin-top: 20px;"  class="btn-primary btn-md  ">Deselect</button>
            </div>
            <div class="col-lg-4">
                <button id="pushAgain" class="btn-success btn-md " style="margin-top: 20px;">Update Invoice/Printer Transactions</button>
            </div>
        </div>
    </div>

    <div class="col-lg-12"  >

        <h3>Invoices needed to be reprinted</h3>
        <table class="table2" tabindex=0 id="tblMiddlelayer" style="font-size:13px;  color: black;overflow-y: scroll; width: 100%;font-family: monospace;" >
            <thead style="font-size: 17px;">
                <tr>
                    <th class="col-sm-1">InvoiceNo</th>
                    <th class="col-sm-1">InvoiceID</th>
                    <th class="col-sm-1">IntFlag</th>
                    <th class="col-sm-1">DeliveryDate</th>
                    <th class="col-sm-1">Order Id</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($middlelayer as $val)
                <tr>
                    <td>{{$val->DocNumber}}</td>
                    <td>{{$val->InvoiceNo}}</td>
                    <td>{{$val->intFlag}}</td>
                    <td>{{$val->DeliveryDate}}</td>
                    <td>{{$val->OrderId}}</td>
                    <td><input type="checkbox" name="middlelayerInv[]" style="height:20px !important;width:30px" value="{{$val->OrderId}}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-lg-12">

        <div class="col-lg-4">
            <button id="pushAgainMiddleLayer" class="btn-primary btn-md " style="margin-top: 20px;">Update Invoice/Printer Transactions</button>
        </div>
    </div>



    <div class="col-lg-12"  style="background: white;" >
        <h3>The below information is Related to the Returns</h3>
        <table class="table2" tabindex=0 id="tblCreditsNotPullingThrough" style="font-size:13px;  color: black;overflow-y: scroll; width: 100%;font-family: monospace;" >
            <thead style="font-size: 17px;">
            <tr>
                <th class="col-sm-1">DocNumber</th>
                <th class="col-sm-1">DocDate</th>
                <th class="col-sm-1">CustomerNumber</th>
                <th class="col-sm-1">OriginalDocNumber</th>
                <th class="col-sm-1">DIMS_ReturnId</th>
                <th class="col-sm-3">Reason</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($credits as $val)
                <tr>
                    <td>{{$val->DocNumber}}</td>
                    <td>{{$val->DIMS_OrderId}}</td>
                    <td>{{$val->CustomerNumber}}</td>
                    <td>{{$val->OriginalDocNumber}}</td>
                    <td>{{$val->DIMS_ReturnId}}</td>
                    <td>{{$val->CreditNoteReason}}</td>

                    <td><input type="checkbox" name="caseProdCred[]" style="height:20px !important;width:30px" value="{{$val->DocNumber}}"></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-lg-12">
        <div class="col-lg-4">
            <button id="selectAllCred" style="margin-top: 20px;" class="btn-danger btn-md ">Select All Cred</button>
        </div>
        <div class="col-lg-4">
            <button id="DeselectselectCred" style="margin-top: 20px;"  class="btn-primary btn-md  ">Deselect Cred</button>
        </div>
        <div class="col-lg-4">
            <button id="pushAgainCred" class="btn-success btn-md " style="margin-top: 20px;">Update Credit Transaction</button>
        </div>
    </div>



@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#pricingOnCustomer').hide();
        $('#callList').hide();
        $('#tabletLoadingApp').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#salesInvoiced').hide();
        $('#posCashUp').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#selectAll').on('click',function(){
            $($("input[name='caseProd[]']")).each(function(){
                $(this).prop('checked',true);
            });
        });

        $('#Deselectselect').on('click',function(){
            $($("input[name='caseProd[]']")).each(function(){
                $(this).prop('checked',false);
            });
        });
        $('#selectAllCred').on('click',function(){
            $($("input[name='caseProdCred[]']")).each(function(){
                $(this).prop('checked',true);
            });
        });

        $('#DeselectselectCred').on('click',function(){
            $($("input[name='caseProdCred[]']")).each(function(){
                $(this).prop('checked',false);
            });
        });

        $('#pushAgain').click(function(){
            var valuesProd = new Array();

            $.each($("input[name='caseProd[]']:checked"),
                function () {
                    var data = $(this).parents('tr:eq(0)');
                    valuesProd.push({ 'invNumber':$(data).find('td:eq(0)').text()});
                });
            $.ajax({
                url: '{!!url("/forceinvoicetoprint")!!}',
                type: "POST",
                data: {invNumber:valuesProd},
                success: function (data) {

                    window.location = '{!!url("/invoicesnotprinting")!!}';
                }
            });
        });
        $('#pushAgainMiddleLayer').click(function(){
            var valuesProd = new Array();

            $.each($("input[name='middlelayerInv[]']:checked"),
                function () {

                    var data = $(this).parents('tr:eq(0)');
                    console.debug("***********"+$(data).find('td:eq(4)').text());
                    valuesProd.push({ 'OrderId':$(data).find('td:eq(4)').text()});
                });
            $.ajax({
                url: '{!!url("/updateIQInvoices")!!}',
                type: "POST",
                data: {OrderId:valuesProd},
                success: function (data) {

                    window.location = '{!!url("/invoicesnotprinting")!!}';
                }
            });
        });

        $('#pushAgainCred').click(function(){
            var valuesProd = new Array();
            $.each($("input[name='caseProdCred[]']:checked"),
                function () {
                    var data = $(this).parents('tr:eq(0)');
                    valuesProd.push({ 'invNumber':$(data).find('td:eq(0)').text()});
                });
            $.ajax({
                url: '{!!url("/forcecredits")!!}',
                type: "POST",
                data: {invNumber:valuesProd},
                success: function (data) {

                    window.location = '{!!url("/invoicesnotprinting")!!}';
                }
            });
        });
    });
</script>
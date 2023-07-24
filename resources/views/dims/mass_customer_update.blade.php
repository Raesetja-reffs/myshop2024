@extends('layouts.app')

@section('content')
    <div class="col-lg-12">
    <div class="col-md-4">
        <a href='{!!url("/productOnPush")!!}/{{$customerId}}' style="padding: 3px;font-weight: 900;color: white;background: black;" onclick="window.open(this.href, 'push_prod','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Push Products</a>
    </div>
    <div class="col-md-4">
        <a href='{!!url("/productOnprohibit")!!}/{{$customerId}}' style="padding: 3px;font-weight: 900;color: white;background: black;" onclick="window.open(this.href, 'push_prod','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Prohibit Products</a>
    </div>
        <div class="col-md-4">
        <a href='{!!url("/customerorderpattern")!!}/{{$customerId}}' style="padding: 3px;font-weight: 900;color: white;background: black;" onclick="window.open(this.href, 'push_prod','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Customer Order Pattern</a>
    </div>
    </div>
    @foreach($custInfo as $value)
        <div class="col-lg-12" >
            <div class="col-lg-6">
                <form>
                    <fieldset class="well">
                        <legend class="well-legend">Basic Info</legend>
                        <div class="form-group col-md-4">
                            <input type="hidden" id="hiddenCustomerID" value="{{$customerId}}">
                            <label class="control-label" for="custCode"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Code</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="custCode" value="{{trim($value->CustomerPastelCode)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">

                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="custName"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Name</label>
                            <input type="text" class="form-control input-sm col-xs-1"  value="{{trim($value->StoreName)}}" id="custName" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="control-label" for="route"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                            <select name="routes"  class="form-control input-sm " id="route">
                                <option value="{{$value->Routeid}}">{{$value->strRoute}}</option>
                            </select>

                        </div>
                        <div class="form-group col-md-4">
                            [ 1 = ACTIVE , 0=NOT ACTIVE ]<br>
                            <label class="control-label" for="status"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Status</label>
                            <select name="status" id="status">

                                    <option value="{{$value->StatusId}}">{{$value->StatusId}}</option>
                                    <option value="0">NOT ACTIVE</option>
                                    <option value="1">ACTIVE</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">

                            <label class="control-label" for="salesman"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Sales Rep</label>
                            <select name="salesman" class="form-control input-sm " id="salesman">

                                <option value="{{$value->UserID}}">{{$value->UserName}}</option>
                                @foreach($dimsusers as $val)
                                    <option value="{{$val->UserID}}">{{$val->UserName}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">

                            <label class="control-label" for="currentgp"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Margin</label>
                            <input type="text" class="form-control input-sm col-xs-1"  value="{{trim($value->mnyCustomerGp)}}" id="currentgp" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">

                        </div>

                    </fieldset>
                </form>
                <button id="basicInfo" class="btn-md btn-success">Update Basic Info</button>
            </div>

            <div class="col-lg-6">
                <form>
                    <fieldset class="well">
                        <legend class="well-legend">Payments</legend>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="pricelist"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Price List</label>
                            <select name="pricelist" id="pricelist">
                                <option value="{{$value->PriceListId}}">{{trim($value->PriceListName)}}</option>
                                    @foreach($priceLists as $val)

                                        <option value="{{$val->PriceListId}}">{{$val->PriceList}}</option>

                                    @endforeach
                            </select>


                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="pTerms"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Payment Terms</label>
                            <select id="pTerms" name="pTerms">
                                <option value="{{trim($value->strPaymentTerm)}}">{{trim($value->strPaymentTerm)}}</option>
                                <option value="1-IN-1-OUT">1-IN-1-OUT</option>
                                <option value="CASH">CASH</option>
                                <option value="EFT">EFT</option>
                                <option value="ACCOUNT">ACCOUNT</option>
                            </select>
                          </div>

                        <div class="form-group col-md-4">
                            <label class="control-label" for="creditlimit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Credit Limits</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="creditlimit" value="{{trim(round($value->CreditLimit,2))}}"   style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="balDue"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Balance Due</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="balDue" value="{{trim(round($value->BalanceDue,2))}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>

                    </fieldset>
                </form>
                <button id="updatePayments" class="btn-md btn-success">Update Payment Terms</button>
            </div>
        </div>


    <div class="col-lg-12" >
            <div class="col-lg-4">
                <form>
                    <fieldset class="well">
                        <legend class="well-legend">Postal Address</legend>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="padress1"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Postal Address 1</label>
                            <input type="text" class="form-control input-sm col-md-1" id="paddress1" value="{{trim($value->Adress1)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">

                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="paddress2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Postal Address 2</label>
                            <input type="text" class="form-control input-sm col-md-1" id="padress2" value="{{trim($value->Adress2)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="control-label" for="paddress3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Postal Address 3</label>
                            <input type="text" class="form-control input-sm col-md-1" id="padress3"  value="{{trim($value->Adress3)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="paddress4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Postal Address 4</label>
                            <input type="text" class="form-control input-sm col-md-1" id="padress4" value="{{trim($value->Adress4)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="paddress5"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Postal Address 5</label>
                            <input type="text" class="form-control input-sm col-md-1" id="padress5" value="{{trim($value->Adress5)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <button id="basicInfo" class="btn-md btn-success">Update Postal Address</button>
                    </fieldset>
                </form>

            </div>

            <div class="col-lg-4">
                <form>
                    <fieldset class="well">
                        <legend class="well-legend">Delivery Address</legend>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="address1"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 1</label>
                            <input type="text" class="form-control input-sm col-md-1" id="address1" value="{{trim($value->DeliveryAddress1)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">

                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="address2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 2</label>
                            <input type="text" class="form-control input-sm col-md-1" id="address2" value="{{trim($value->DeliveryAddress2)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="control-label" for="address3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 3</label>
                            <input type="text" class="form-control input-sm col-md-1" id="address3"  value="{{trim($value->DeliveryAddress3)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="address4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 4</label>
                            <input type="text" class="form-control input-sm col-md-1" id="address4" value="{{trim($value->DeliveryAddress4)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="address5"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address 5</label>
                            <input type="text" class="form-control input-sm col-md-1" id="address5" value="{{trim($value->DeliveryAddress5)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div><br>
                        <div class="form-group col-md-4">
                            [ 1 = YES , 0=NO ]<br>
                            <label class="control-label" for="diffDelv"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Different Delivery Addresses</label>
                            <select name="differentDelv" id="differentDelv">
                            <option value="{{trim($value->UniqueDelivery)}}">{{trim($value->UniqueDelivery)}}</option>
                            <option value="0">NO</option>
                            <option value="1">YES</option>
                            </select>

                        </div>

                    </fieldset>
                </form>
                <button id="updateDelvAdress" class="btn-md btn-success">Update Delivery Address</button>

            </div>

            <div class="col-lg-4">
                <form>
                    <fieldset class="well">
                        <legend class="well-legend">Contact Info</legend>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="ContactTel"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Tel</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="ContactTel" value="{{trim($value->BuyerTelephone)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">

                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="CellPhone"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Cell Phone</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="CellPhone" value="{{trim($value->BuyerContact)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="ContactFax"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Contact Fax</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="ContactFax" value="{{trim($value->ContactFax)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="ContactPerson"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Contact Person</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="ContactPerson" value="{{trim($value->ContactPerson)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="Email"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Email</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="Email" value="{{trim($value->Email)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="strDriversAppEmail"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;font-family: Sans-serif;">Drivers App Invoice Email</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="strDriversAppEmail" value="{{trim($value->strDriversAppEmail)}}" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                    </fieldset>

                </form>
                <button class="btn-success btn-md" id="bntUpdateContInfo">Update Contacts</button>
            </div>
        </div>
        <div class="col-lg-12">
            <a href='{!!url("/custometPricingPage")!!}/{{$customerId}}' style="padding: 3px;font-weight: 900;color: white;background: #f21908;" onclick="window.open(this.href, 'spec','left=20,top=20,width=1250,height=950,toolbar=1,resizable=0'); return false;">Customer Prices</a>

        </div>

        <div class="col-lg-12"  >
            <div class="col-lg-6" style="background: darkgoldenrod">
            <h4 style="text-align: center">Customer Invoice History</h4>
            <div class="form-group col-md-12">
                <div class="form-group col-md-5">
                <label class="control-label" for="diffDelv"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">From</label>
                <input type="text" class="form-control input-sm col-xs-1" id="dateFrom"></div>
                <div class="form-group col-md-5">
                <label class="control-label" for="diffDelv"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">To</label>
                <input type="text" class="form-control input-sm col-xs-1" id="dateTo"></div>
                <button id="dateFilters" class="btn-primary btn-md">Submit</button>
            </div>
            <table class="table table-bordered stripe search-table" tabindex=0 id="tblOrderListingHeader" style="height:75%;font-size:11px;  color: black;overflow-y: scroll; width: 100%;font-family: sans-serif;" >
                <thead style="font-size: 17px;">
                <tr>
                    <th class="col-sm-1">OrderId</th>
                    <th class="col-sm-1">InvoiceNo</th>
                    <th class="col-sm-3">OrderNo</th>
                    <th class="col-sm-3">DeliveryDate</th>
                    <th class="col-sm-1">OrderDate</th>
                    <th class="col-sm-1">Value(Exc)</th>
                    <th class="col-sm-1">Lines</th>

                </tr>
                </thead>
                <tbody>

                </tbody>

            </table>
        </div>
            <div class="col-lg-6">



                <div class="form-group col-md-12">
                    <div class="form-group col-md-5">
                        <label class="control-label" for="dateFromCall"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">From</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="dateFromCall"></div>
                    <div class="form-group col-md-5">
                        <label class="control-label" for="dateToCall"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">To</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="dateToCall"></div><br>
                    <button id="checkevents" class="btn-primary btn-md">Check Call Notes</button>
                </div>
            </div>
        </div>
    @endforeach
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
        getRoutes('#route','{!!url("/getCommonRoutes")!!}');

        $("#dateFrom,#dateTo").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#dateFilters').click(function(){
            $('#tblOrderListingHeader').DataTable({
                "ajax": {
                    url: '{!!url("/customerOrderListingHeader")!!}', "type": "POST", data: function (data) {
                        data.customerID = $('#hiddenCustomerID').val();
                        data.dateFrom = $('#dateFrom').val();
                        data.dateTo = $('#dateTo').val();
                    }
                },
                "processing": false,
                "serverSide": false,
                "stateSave": false,
                "columns": [
                    {"data": "OrderId", "class": "small"},
                    {"data": "InvoiceNo", "class": "small"},
                    {"data": "OrderNo", "class": "small"},
                    {"data": "OrderDate", "class": "small"},
                    {"data": "DeliveryDate", "class": "small", "bSortable": true},
                    {"data": "valExt", "class": "small",
                        render:function(data, type, row, meta) {
                            // check to see if this is JSON
                            try {
                                var jsn = JSON.parse(data);
                                //console.log(" parsing json" + jsn);
                            } catch (e) {

                                return jsn.data;
                            }
                            return parseFloat(jsn).toFixed(2);

                        }},
                    {"data": "Lines", "class": "small"}
                ],
                "deferRender": true,
                "scrollY": "300",
                "scrollCollapse": true,
                searching: true,
                bPaginate: false,
                bFilter: false,
                "LengthChange": false,
                "info": false,
                "ordering": true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf'
                ],

                "bDestroy": true
            });
        });
        $('#basicInfo').click(function(){
            $.ajax({
                url: '{!!url("/updatebasicinfo")!!}',
                type: "POST",
                data: {
                    hiddenCustomerID: $('#hiddenCustomerID').val(),
                    route: $('#route').val(),
                    status: $('#status').val(),
                    salesrep:$('#salesman').val(),
                    currentgp:$('#currentgp').val()
                },
                success: function (data) {
                    if (data == 1)
                    {
                        var dialog = $('<p><strong style="color:red">Customer Basic information has been updated successfully</strong></p>').dialog({
                            height: 200, width: 700,modal: true,containment: false,
                            buttons: {
                                "Okay": function () {
                                    dialog.dialog('close');
                                }
                            }
                        });
                    }
                    else {
                        alert("Something went Wrong");
                    }

                }
            });
        });
        $('#bntUpdateContInfo').click(function(){
            $.ajax({
                url: '{!!url("/updateContactInfo")!!}',
                type: "POST",
                data: {
                    hiddenCustomerID: $('#hiddenCustomerID').val(),
                    ContactTel: $('#ContactTel').val(),
                    CellPhone: $('#CellPhone').val(),
                    ContactFax: $('#ContactFax').val(),
                    ContactPerson: $('#ContactPerson').val(),
                    Email: $('#Email').val(),
                    strDriversAppEmail: $('#strDriversAppEmail').val()
                },
                success: function (data) {
                    if (data == 1)
                    {
                        var dialog = $('<p><strong style="color:red">Customer Contact information has been updated successfully</strong></p>').dialog({
                            height: 200, width: 700,modal: true,containment: false,
                            buttons: {
                                "Okay": function () {
                                    dialog.dialog('close');
                                }
                            }
                        });
                    }
                    else {
                        alert("Something went Wrong");
                    }

                }
            });
        });
        $('#updatePayments').click(function(){
            $.ajax({
                url: '{!!url("/updatePayments")!!}',
                type: "POST",
                data: {
                    hiddenCustomerID: $('#hiddenCustomerID').val(),
                    pricelist: $('#pricelist').val(),
                    creditlimit: $('#creditlimit').val(),
                    pTerms: $('#pTerms').val()

                },
                success: function (data) {
                    if (data == 1)
                    {
                        var dialog = $('<p><strong style="color:red">Customer Payment information has been updated successfully</strong></p>').dialog({
                            height: 200, width: 700,modal: true,containment: false,
                            buttons: {
                                "Okay": function () {
                                    dialog.dialog('close');
                                }
                            }
                        });
                    }
                    else {
                        alert("Something went Wrong");
                    }

                }
            });
        });
        $('#updateDelvAdress').click(function(){
            $.ajax({
                url: '{!!url("/updateDelvAdress")!!}',
                type: "POST",
                data: {
                    hiddenCustomerID: $('#hiddenCustomerID').val(),
                    differentDelv: $('#differentDelv').val()
                },
                success: function (data) {
                    if (data == 1)
                    {
                        var dialog = $('<p><strong style="color:red">Customer Delivery address updated successfully</strong></p>').dialog({
                            height: 200, width: 700,modal: true,containment: false,
                            buttons: {
                                "Okay": function () {
                                    dialog.dialog('close');
                                }
                            }
                        });
                    }
                    else {
                        alert("Something went Wrong");
                    }

                }
            });
        });
    });
</script>
<x-app-layout>

    <x-slot name="header">
        {{ __('Customer Update') }}
    </x-slot>

    <x-slot name="breadcrum">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <!--end::Item-->

        <!--begin::Item-->
        <li class="breadcrumb-item text-dark">
            Customer Update
        </li>
        <!--end::Item-->
    </x-slot>

    @foreach($custInfo as $value)
        <div class="row mt-3">
            <div class="col-lg-6">
                <div class="card smaller-card">
                    <div class="card-header p-5">
                        <h3 class="card-title">Basic Info</h3>
                        <div class="card-toolbar">
                            <a
                                class="btn btn-info btn-sm mb-1 mb-sm-0 me-1"
                                href='{!!url("/productOnPush")!!}/{{$customerId}}'
                                onclick="window.open(this.href, 'push_prod','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"
                            >
                                Push Products
                            </a>
                            <a
                                class="btn btn-primary btn-sm mb-1 mb-sm-0 me-1"
                                href='{!!url("/productOnprohibit")!!}/{{$customerId}}'
                                onclick="window.open(this.href, 'push_prod','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"
                            >
                                Prohibit Products
                            </a>
                            <button id="basicInfo" class="btn btn-success btn-sm">Update Basic Info</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <input type="hidden" id="hiddenCustomerID" value="{{$customerId}}">
                                <label for="custCode">Customer Code</label>
                                <input type="text" class="form-control" id="custCode" value="{{trim($value->CustomerPastelCode)}}">
                            </div>
                            <div class="col-md-4">
                                <label for="custName">Customer Name</label>
                                <input type="text" class="form-control" value="{{trim($value->StoreName)}}" id="custName">
                            </div>
                            <div class="col-md-4">
                                <label for="route">Route</label>
                                <select name="routes" class="form-control form-select" id="route">
                                    <option value="{{$value->Routeid}}">{{$value->strRoute}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="status">Status [1=ACTIVE, 0=NOT ACTIVE]</label>
                                <select name="status" id="status" class="form-control form-select">
                                    <option value="{{$value->StatusId}}">{{$value->StatusId}}</option>
                                    <option value="0">NOT ACTIVE</option>
                                    <option value="1">ACTIVE</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="salesman">Sales Rep</label>
                                <select name="salesman" class="form-control form-select" id="salesman">
                                    <option value="{{$value->UserID}}">{{$value->UserName}}</option>
                                    @foreach($dimsusers as $val)
                                        <option value="{{$val->UserID}}">{{$val->UserName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="currentgp">Customer Margin</label>
                                <input type="text" class="form-control" value="{{trim($value->mnyCustomerGp)}}" id="currentgp">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card smaller-card">
                    <div class="card-header p-5">
                        <h3 class="card-title">Payments</h3>
                        <div class="card-toolbar">
                            <a
                                class="btn btn-primary btn-sm mb-1 mb-sm-0 me-1"
                                href='{!!url("/customerorderpattern")!!}/{{$customerId}}'
                                onclick="window.open(this.href, 'push_prod','left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;"
                            >
                                Customer Order Pattern
                            </a>
                            <button id="updatePayments" class="btn btn-success btn-sm">Update Payment Terms</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label for="pricelist">Price List</label>
                                <select name="pricelist" id="pricelist" class="form-control form-select">
                                    <option value="{{$value->PriceListId}}">{{trim($value->PriceListName)}}</option>
                                    @foreach($priceLists as $val)
                                        <option value="{{$val->PriceListId}}">
                                            {{$val->PriceList}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="pTerms">Payment Terms</label>
                                <select id="pTerms" name="pTerms" class="form-control form-select">
                                    <option value="{{trim($value->strPaymentTerm)}}">{{trim($value->strPaymentTerm)}}</option>
                                    <option value="1-IN-1-OUT">1-IN-1-OUT</option>
                                    <option value="CASH">CASH</option>
                                    <option value="EFT">EFT</option>
                                    <option value="ACCOUNT">ACCOUNT</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="creditlimit">Credit Limits</label>
                                <input type="text" class="form-control" id="creditlimit" value="{{trim(round($value->CreditLimit,2))}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="balDue">Balance Due</label>
                                <input type="text" class="form-control" id="balDue" value="{{trim(round($value->BalanceDue,2))}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-4">
                <div class="card smaller-card">
                    <div class="card-header p-5">
                        <h3 class="card-title">Postal Address</h3>
                        <div class="card-toolbar">
                            <button id="basicInfo" class="btn btn-success btn-sm">Update Postal Address</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label for="padress1">Postal Address 1</label>
                                <input type="text" class="form-control" id="paddress1" value="{{trim($value->Adress1)}}">
                            </div>
                            <div class="col-md-4">
                                <label for="paddress2">Postal Address 2</label>
                                <input type="text" class="form-control" id="padress2" value="{{trim($value->Adress2)}}">
                            </div>
                            <div class="col-md-4">
                                <label for="paddress3">Postal Address 3</label>
                                <input type="text" class="form-control" id="padress3" value="{{trim($value->Adress3)}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="paddress4">Postal Address 4</label>
                                <input type="text" class="form-control" id="padress4" value="{{trim($value->Adress4)}}">
                            </div>
                            <div class="col-md-4">
                                <label for="paddress5">Postal Address 5</label>
                                <input type="text" class="form-control" id="padress5" value="{{trim($value->Adress5)}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card smaller-card">
                    <div class="card-header p-5">
                        <h3 class="card-title">Delivery Address</h3>
                        <div class="card-toolbar">
                            <button id="updateDelvAdress" class="btn btn-success btn-sm">Update Delivery Address</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label for="address1">Address 1</label>
                                <input type="text" class="form-control" id="address1" value="{{trim($value->DeliveryAddress1)}}">
                            </div>
                            <div class="col-md-4">
                                <label for="address2">Address 2</label>
                                <input type="text" class="form-control" id="address2" value="{{trim($value->DeliveryAddress2)}}">
                            </div>
                            <div class="col-md-4">
                                <label for="address3">Address 3</label>
                                <input type="text" class="form-control" id="address3"  value="{{trim($value->DeliveryAddress3)}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="address4">Address 4</label>
                                <input type="text" class="form-control" id="address4" value="{{trim($value->DeliveryAddress4)}}">
                            </div>
                            <div class="col-md-4">
                                <label for="address5">Address 5</label>
                                <input type="text" class="form-control" id="address5" value="{{trim($value->DeliveryAddress5)}}">
                            </div>
                            <div class="col-md-4">
                                <label for="diffDelv">Different Delivery Addresses [1=YES, 0=NO]</label>
                                <select name="differentDelv" id="differentDelv" class="form-control form-select">
                                    <option value="{{trim($value->UniqueDelivery)}}">{{trim($value->UniqueDelivery)}}</option>
                                    <option value="0">NO</option>
                                    <option value="1">YES</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card smaller-card">
                    <div class="card-header p-5">
                        <h3 class="card-title">Contact Info</h3>
                        <div class="card-toolbar">
                            <button id="bntUpdateContInfo" class="btn btn-success btn-sm">Update Contacts</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label for="ContactTel">Tel</label>
                                <input type="text" class="form-control" id="ContactTel" value="{{trim($value->BuyerTelephone)}}">
                            </div>
                            <div class="col-md-4">
                                <label for="CellPhone">Cell Phone</label>
                                <input type="text" class="form-control" id="CellPhone" value="{{trim($value->BuyerContact)}}">
                            </div>
                            <div class="col-md-4">
                                <label for="ContactFax">Contact Fax</label>
                                <input type="text" class="form-control" id="ContactFax" value="{{trim($value->ContactFax)}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="ContactPerson">Contact Person</label>
                                <input type="text" class="form-control" id="ContactPerson" value="{{trim($value->ContactPerson)}}">
                            </div>
                            <div class="col-md-4">
                                <label for="Email">Email</label>
                                <input type="text" class="form-control" id="Email" value="{{trim($value->Email)}}">
                            </div>
                            <div class="col-md-4">
                                <label for="strDriversAppEmail">Drivers App Invoice Email</label>
                                <input type="text" class="form-control" id="strDriversAppEmail" value="{{trim($value->strDriversAppEmail)}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-8">
                <div class="card smaller-card">
                    <div class="card-header p-5">
                        <h3 class="card-title">Customer Invoice History</h3>
                        <div class="card-toolbar">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label for="dateFrom">From</label>
                                    <input type="text" class="form-control" id="dateFrom">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="dateTo">To</label>
                                    <input type="text" class="form-control" id="dateTo">
                                </div>
                                <div class="col-md-4 mb-2 d-flex">
                                    <button id="dateFilters" class="btn btn-primary btn-sm mt-md-6 me-1">Submit</button>
                                    <a
                                        class="btn btn-danger btn-sm mb-1 mb-sm-0 mt-md-6 me-1"
                                        href='{!!url("/custometPricingPage")!!}/{{$customerId}}'
                                        onclick="window.open(this.href, 'spec','left=20,top=20,width=1250,height=950,toolbar=1,resizable=0'); return false;">
                                        Customer Prices
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive scroll h-400px">
                            <table id ="tblOrderListingHeader" class="table table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th>OrderId</th>
                                        <th>InvoiceNo</th>
                                        <th>OrderNo</th>
                                        <th>DeliveryDate</th>
                                        <th>OrderDate</th>
                                        <th>Value(Exc)</th>
                                        <th>Lines</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card smaller-card">
                    <div class="card-header p-5">
                        <div class="card-toolbar">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label for="dateFromCall">From</label>
                                    <input type="text" class="form-control" id="dateFromCall">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="dateToCall">To</label>
                                    <input type="text" class="form-control" id="dateToCall">
                                </div>
                                <div class="col-md-4 mb-2 d-flex">
                                    <button id="checkevents" class="btn btn-primary btn-sm mt-md-6">Check Call Notes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    @endforeach

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
                    //dom: 'Bfrtip',
                    dom: `<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>
                        <'row'<'col-sm-12'tr>>
                        <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>
                    `,
                    buttons: [
                        {
                            extend: 'copy',
                            className: 'btn btn-primary btn-sm me-2',
                        },
                        {
                            extend: 'csv',
                            className: 'btn btn-primary btn-sm me-2',
                        },
                        {
                            extend: 'excel',
                            className: 'btn btn-primary btn-sm me-2',
                        },
                        {
                            extend: 'pdf',
                            className: 'btn btn-primary btn-sm',
                        }
                    ],
                    "bDestroy": true
                });
                $("#tblOrderListingHeader_wrapper .dt-buttons button").removeClass('btn-secondary');
                $("#tblOrderListingHeader_wrapper .dataTables_filter input").removeClass('form-control-sm form-control-solid');
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
                        if (data == 1) {
                            var dialog = $('<p><strong style="color:red">Customer Basic information has been updated successfully</strong></p>').dialog({
                                height: 200, width: 700,modal: true,containment: false,
                                buttons: {
                                    "Okay": {
                                        text: "Okay",
                                        class: "btn btn-success btn-sm",
                                        click: function() {
                                            dialog.dialog('close');
                                        }
                                    },
                                }
                            });
                        } else {
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
                        if (data == 1) {
                            var dialog = $('<p><strong style="color:red">Customer Contact information has been updated successfully</strong></p>').dialog({
                                height: 200, width: 700,modal: true,containment: false,
                                buttons: {
                                    "Okay": {
                                        text: "Okay",
                                        class: "btn btn-success btn-sm",
                                        click: function() {
                                            dialog.dialog('close');
                                        }
                                    },
                                }
                            });
                        } else {
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
                        if (data == 1) {
                            var dialog = $('<p><strong style="color:red">Customer Payment information has been updated successfully</strong></p>').dialog({
                                height: 200, width: 700,modal: true,containment: false,
                                buttons: {
                                    "Okay": {
                                        text: "Okay",
                                        class: "btn btn-success btn-sm",
                                        click: function() {
                                            dialog.dialog('close');
                                        }
                                    },
                                }
                            });
                        } else {
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
                        if (data == 1) {
                            var dialog = $('<p><strong style="color:red">Customer Delivery address updated successfully</strong></p>').dialog({
                                height: 200, width: 700,modal: true,containment: false,
                                buttons: {
                                    "Okay": {
                                        text: "Okay",
                                        class: "btn btn-success btn-sm",
                                        click: function() {
                                            dialog.dialog('close');
                                        }
                                    },
                                }
                            });
                        } else {
                            alert("Something went Wrong");
                        }
                    }
                });
            });
        });
    </script>

</x-app-layout>

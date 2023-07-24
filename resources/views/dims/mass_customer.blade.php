@extends('layouts.app')

@section('content')
    <div class="col-lg-12">
        <a href='{!!url("/gridCustomermanagement")!!}/{{ Auth::user()->UserID}}/all' onclick="window.open(this.href, 'gridCustomermanagement',
'left=20,top=20,width=1000,height=1000,toolbar=1,resizable=0'); return false;" style="color:black;font-size: 15px;font-weight:900">Other Settings</a>

        <a href='{!!url("/customerAddressLandingPage")!!}' onclick="window.open(this.href, 'customerdeliveryaddresses',
'left=20,top=20,width=1000,height=1000,toolbar=1,resizable=0'); return false;" style="color:black;font-size: 15px;font-weight:900; background: darkgrey;padding: 0px;border: 1px solid grey;">Other Delivery Address</a>
    </div>
    <div class="col-lg-12"  style="height:100%;">
        <table class="table table-bordered stripe search-table" tabindex=0 id="tblMassCustomer" style="font-size:11px;  color: black;overflow-y: scroll; width: 100%;font-family: sans-serif;" >
            <thead style="font-size: 17px;">
            <tr>
                <th class="col-sm-1">Id</th>
                <th class="col-sm-1">Code</th>
                <th class="col-sm-3">StoreName</th>
                <th class="col-sm-3">strRoute</th>
                <th class="col-sm-1">StatusId</th> 
                <th class="col-sm-1">ContactTel</th>
                <th class="col-sm-1">CellPhone</th>
                <th class="col-sm-1">ContactFax</th>
                <th class="col-sm-1">ContactPerson</th>
                <th class="col-sm-1">Email</th>
                <th class="col-sm-1">UniqueDelivery</th>
                <th class="col-sm-1">PriceListName </th>
                <th class="col-sm-1">NTerms </th>
                <th class="col-sm-1">Sales Code </th>
                <th class="col-sm-1">Customer Category </th>
                <th class="col-sm-1">BuyerContact </th>
                <th class="col-sm-1">BuyerTelephone </th>
                <th class="col-sm-1">strPaymentTerm </th>
                <th class="col-sm-1">bitCreditHold </th>
                <th class="col-sm-1">HighOrderValue </th>
                <th class="col-sm-1">CustomerOnHold </th>
                <th class="col-sm-1">HighOrderValue </th>
                <th class="col-sm-1">BalanceDue </th>
                <th class="col-sm-1">Credit Limit </th>
            </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot style="font-size: 17px;">

            <tr style="overflow-y: scroll; width: 100%;">
                <th class="col-sm-1">Id</th>
                <th class="col-sm-1">Code</th>
                <th class="col-sm-3">StoreName</th>
                <th class="col-sm-3">strRoute</th>
                <th class="col-sm-1">StatusId</th>
                <th class="col-sm-1">ContactTel</th>
                <th class="col-sm-1">CellPhone</th>
                <th class="col-sm-1">ContactFax</th>
                <th class="col-sm-1">ContactPerson</th>
                <th class="col-sm-1">Email</th>
                <th class="col-sm-1">UniqueDelivery</th>
                <th class="col-sm-1">PriceListName </th>
                <th class="col-sm-1">NTerms </th>
                <th class="col-sm-1">Sales Code </th>
                <th class="col-sm-1">Customer Category </th>
                <th class="col-sm-1">BuyerContact </th>
                <th class="col-sm-1">BuyerTelephone </th>
                <th class="col-sm-1">strPaymentTerm </th>
                <th class="col-sm-1">bitCreditHold </th>
                <th class="col-sm-1">HighOrderValue </th>
                <th class="col-sm-1">CustomerOnHold </th>
                <th class="col-sm-1">HighOrderValue </th>
                <th class="col-sm-1">BalanceDue </th>
                <th class="col-sm-1">Credit Limit </th>
            </tr>
            </tfoot>
        </table>
    </div>

@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

<link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet">
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
        var otable = '';
        otable = $('#tblMassCustomer').DataTable({
            "ajax": {
                url: '{!!url("/masscustomerdatatable")!!}', "type": "POST", data: function (data) {

                }
            },
            "processing": false,
            "serverSide": false,
            "stateSave": false,
            "columns": [
                {"data": "CustomerId", "class": "small"},
                {"data": "CustomerPastelCode", "class": "small"},
                {"data": "StoreName", "class": "small"},
                {"data": "strRoute", "class": "small", },
                {"data": "StatusId", "class": "small"},
                {"data": "ContactTel", "class": "small"},
                {"data": "CellPhone", "class": "small"},
                {"data": "ContactFax", "class": "small"},
                {"data": "ContactPerson", "class": "small"},
                {"data": "Email", "class": "small"},
                {"data": "UniqueDelivery", "class": "small"},
                {"data": "PriceListName", "class": "small"},
                {"data": "PaymentTerms", "class": "small"},
                {"data": "SalesAnalysisCode", "class": "small"},
                {"data": "CCDesc", "class": "small"},
                {"data": "BuyerContact", "class": "small"},
                {"data": "BuyerTelephone", "class": "small"},
                {"data": "strPaymentTerm", "class": "small"},
                {"data": "bitCreditHold", "class": "small"},
                {"data": "HighOrderValue", "class": "small"},
                {"data": "CustomerOnHold", "class": "small"},
                {"data": "HighOrderValue", "class": "small"},
                {"data": "BalanceDue", "class": "small"},
                {"data": "CreditLimit", "class": "small"}

            ],
            "deferRender": true,
            "scrollY": "500px",
            "scrollX": "600px",
            "scrollCollapse": true,
            searching: true,
            bPaginate: false,
            bFilter: false,
            "LengthChange": false,
            "info": false,
            /*"ordering": true,*/
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel'
            ],
            "initComplete": function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            },
            "bDestroy": true
        });
        $('#tblMassCustomer tbody').on('dblclick', 'tr', function () {
            $("#tblMassCustomer tbody tr").removeClass('row_selected');
            $(this).addClass('row_selected');

            var data = otable.row(this).data();
            var custID = data.CustomerId;
            window.open('{!!url("/massCustomerUpdate")!!}/'+custID, 'mywin',
                'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0');
        });
        $('#tblMassCustomer tbody').on('click', 'tr', function () {
            $("#tblMassCustomer tbody tr").removeClass('row_selected');
            $(this).addClass('row_selected');

            var data = otable.row(this).data();
        });
       // var table = $('#tblMassCustomer').DataTable();

    });
</script>
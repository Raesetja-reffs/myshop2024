<x-app-layout>

    <x-slot name="header">
        {{ __('Web Store') }}
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
            Web Store </li>
        <!--end::Item-->
    </x-slot>

    <div class="col-lg-12" >
        <button id="products" class="btn-md btn-success" style="    padding: 11px;    width: 200px;">Sync Products</button>
    </div>
    <div class="col-lg-12" >
        <button id="stock" class="btn-md btn-success" style="    padding: 11px;    width: 200px;">Sync Stock Available</button>
    </div>
    <div class="col-lg-12">
        <button id="customers" class="btn-md btn-success" style="    padding: 11px;    width: 200px;">Sync Customers</button>
    </div>
    <div class="col-lg-12" >
        <button id="orderpattern" class="btn-md btn-success" style="    padding: 11px;    width: 200px;">Sync Order Pattern</button>
    </div>
    <div class="col-lg-12" >
        <button id="pricelists" class="btn-md btn-primary" style="    padding: 11px;    width: 200px;">Sync Price List Names</button>
    </div>
    <div class="col-lg-12" >
        <button id="pricelistsprices" class="btn-md btn-success" style="    padding: 11px;    width: 200px;">Sync Price List Prices</button>
    </div>
    <div class="col-lg-12" >
        <button id="custspecials" class="btn-md btn-success" style="    padding: 11px;    width: 200px;">Sync Customer Specials</button>
    </div>
    <div class="col-lg-12" >
        <button id="groupspecials" class="btn-md btn-success" style="    padding: 11px;    width: 200px;">Sync Group Specials</button>
    </div>
    <div class="col-lg-12" >
        <button id="overall" class="btn-md btn-success" style="    padding: 11px;    width: 200px;">Sync Overall Specials</button>
    </div>

    <script>
        $(document).ready(function() {

            $('#popUpIndividualBulk').hide();
            $('#popUpBatchBulk').hide();
            $('#orderListing').hide();
            $('#pricing').hide();
            $('#pricingOnCustomer').hide();
            $('#callList').hide();
            $('#tabletLoadingApp').hide();
            $('#copyOrdersBtn').hide();
            $('#salesOnOrder').hide();
            $('#salesInvoiced').hide();
            $('#posCashUp').hide();

            $('#outstandingcust').DataTable( {
                dom: 'Bfrtip',
                "pageLength": 150,
                scrollY:        650,
                scrollCollapse: true,
                scroller:       true,
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            } );
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#products').click(function(){
                $.ajax({
                    url: '{!!url("/syncproducts")!!}',
                    type: "POST",
                    success: function (data) {
                        console.debug(data[0].results);
                        alert('Returns ' + data[0].results+' Rows');
                    }
                });
            });
            $('#stock').click(function(){
                $.ajax({
                    url: '{!!url("/syncpricelistStock")!!}',
                    type: "POST",
                    success: function (data) {

                        alert('Returns ' + data[0].results+' Rows');
                    }
                });
            });
            $('#customers').click(function(){
                $.ajax({
                    url: '{!!url("/synccustomers")!!}',
                    type: "POST",
                    success: function (data) {

                        alert('Returns ' + data[0].results+' Rows');
                    }
                });
            });

            $('#orderpattern').click(function(){
                $.ajax({
                    url: '{!!url("/syncorderpattern")!!}',
                    type: "POST",
                    success: function (data) {

                        alert('Returns ' + data[0].results+' Rows');
                    }
                });
            });
            $('#pricelists').click(function(){
                $.ajax({
                    url: '{!!url("/syncpricelist")!!}',
                    type: "POST",
                    success: function (data) {
                        alert('Returns ' + data[0].results+' Rows');
                    }
                });
            });
            $('#pricelistsprices').click(function(){
                $.ajax({
                    url: '{!!url("/syncpricelistPrices")!!}',
                    type: "POST",
                    success: function (data) {
                        alert('Returns ' + data[0].results+' Rows');
                    }
                });
            });
            $('#custspecials').click(function(){
                $.ajax({
                    url: '{!!url("/synccustomerspecials")!!}',
                    type: "POST",
                    success: function (data) {
                        alert('Returns ' + data[0].results+' Rows');
                    }
                });
            });

            $('#groupspecials').click(function(){
                $.ajax({
                    url: '{!!url("/syncgroupspecials")!!}',
                    type: "POST",
                    success: function (data) {
                        alert('Returns ' + data[0].results+' Rows');
                    }
                });
            });
            $('#overall').click(function(){
                $.ajax({
                    url: '{!!url("/syncoverallspecials")!!}',
                    type: "POST",
                    success: function (data) {
                        alert('Returns ' + data[0].results+' Rows');
                    }
                });
            });

        });

    </script>
</x-app-layout>

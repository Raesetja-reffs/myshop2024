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

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex flex-wrap">
                            <button id="products" type="button" class="btn btn-success btn-sm mt-md-6 mb-2 me-2">
                                Sync Products
                            </button>
                            <button id="stock" type="button" class="btn btn-success btn-sm mt-md-6 mb-2 me-2">
                                Sync Stock Available
                            </button>
                            <button id="customers" type="button" class="btn btn-success btn-sm mt-md-6 mb-2 me-2">
                                Sync Customers
                            </button>
                            <button id="orderpattern" type="button" class="btn btn-success btn-sm mt-md-6 mb-2 me-2">
                                Sync Order Pattern
                            </button>
                            <button id="pricelists" type="button" class="btn btn-success btn-sm mt-md-6 mb-2 me-2">
                                Sync Price List Names
                            </button>
                            <button id="pricelistsprices" type="button" class="btn btn-success btn-sm mt-md-6 mb-2 me-2">
                                Sync Price List Prices
                            </button>
                            <button id="custspecials" type="button" class="btn btn-success btn-sm mt-md-6 mb-2 me-2">
                                Sync Customer Specials
                            </button>
                            <button id="groupspecials" type="button" class="btn btn-success btn-sm mt-md-6 mb-2 me-2">
                                Sync Group Specials
                            </button>
                            <button id="overall" type="button" class="btn btn-success btn-sm mt-md-6 mb-2 me-2">
                                Sync Overall Specials
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                },
                beforeSend: function(xhr) {
                    $(".general-loader").show();
                },
                complete: function(xhr, status) {
                    $(".general-loader").hide();
                },
                error: function(xhr, status, error) {
                    message = error;
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showAlert('danger', message, 10000);
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

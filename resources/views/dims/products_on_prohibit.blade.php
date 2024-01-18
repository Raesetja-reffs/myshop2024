<x-app-layout>

    <x-slot name="header">
        {{ __('Prohibited Products') }}
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
            Prohibited Products
        </li>
        <!--end::Item-->
    </x-slot>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @if ($customerId == 0)
                            <div class="col-md-6 table-main-container">
                                <input type="hidden" id="customerId" value="{{$customerId}}">
                                <div class="d-flex">
                                    <h4 class="me-2">All Customers</h4>
                                    <i class="show-green-info-text">Double Click to open customer push product page</i>
                                </div>
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-2"><span class="path1"></span><span class="path2"></span></i>
                                        <input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-10" placeholder="Search Customers"/>
                                    </div>
                                    <!--end::Search-->

                                    <!--begin::Toolbar-->
                                    <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                                        <div class="fw-bold me-5 d-none">
                                            <span data-kt-docs-table-select="selected_count"></span> Selected
                                        </div>
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                <!--end::Wrapper-->
                                <div class="table-responsive scrollable overflow-y-auto" style="max-height: 480px;">
                                    <table class="table table-bordered stripe search-table customer-table" tabindex=0 id="generalTable">
                                        <thead>
                                            <tr>
                                                <th class="w-10px pe-2">
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                        <input class="form-check-input selectAll" type="checkbox" value="1"/>
                                                    </div>
                                                </th>
                                                <th>Customer Name</th>
                                                <th>Customer Code</th>
                                                <th>Email Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($customers as $value)
                                                <tr
                                                    push-product-url="{{ url('/productOnPush/' . $value->CustomerId) }}"
                                                >
                                                    <td>
                                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                            <input type="checkbox" name="customers[]" class="form-check-input tableItem productsOnPush" value="{{$value->CustomerId}}">
                                                        </div>
                                                    </td>
                                                    <td>{{$value->StoreName}}</td>
                                                    <td>{{$value->CustomerPastelCode}}</td>
                                                    <td>{{$value->Email}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6 table-main-container">
                                <input type="hidden" id="customerId" value="{{$customerId}}">
                                <div class="d-flex">
                                    <h4 class="me-2">Push Products</h4>
                                    <i>Please remove the product</i>
                                </div>
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-2"><span class="path1"></span><span class="path2"></span></i>
                                        <input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-10" placeholder="Search Products"/>
                                    </div>
                                    <!--end::Search-->

                                    <!--begin::Toolbar-->
                                    <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                                        <div class="fw-bold me-5 d-none">
                                            <span data-kt-docs-table-select="selected_count"></span> Selected
                                        </div>
                                        <!--begin:: Add To Push List-->
                                        <button class="btn btn-success btn-sm" id="removeProduct">Remove Product(s)</button>
                                        <!--end::Add Add To Push List-->
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                <!--end::Wrapper-->
                                <div class="table-responsive scrollable overflow-y-auto" style="max-height: 480px;">
                                    <table class="table table-bordered stripe search-table" tabindex=0 id="generalTable">
                                        <thead>
                                            <tr>
                                                <th class="w-10px pe-2">
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                        <input class="form-check-input selectAll" type="checkbox" value="1"/>
                                                    </div>
                                                </th>
                                                <th>Product Code</th>
                                                <th>Product Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pushProducts as $value)
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                            <input type="checkbox" name="productsOnPush[]" class="form-check-input tableItem productsOnPush" value="{{$value->ProductId}}">
                                                        </div>
                                                    </td>
                                                    <td>{{$value->PastelCode}}</td>
                                                    <td>{{$value->PastelDescription}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6 table-main-container">
                            <h4>All Products</h4>
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-2"><span class="path1"></span><span class="path2"></span></i>
                                    <input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-10" placeholder="Search Products"/>
                                </div>
                                <!--end::Search-->

                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                                    <div class="fw-bold me-5 d-none">
                                        <span data-kt-docs-table-select="selected_count"></span> Selected
                                    </div>
                                    <!--begin:: Add To Push List-->
                                    <button type="button" class="btn btn-success btn-sm" id="pushTheProduct">Add To Push List</button>
                                    <!--end::Add Add To Push List-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Datatable-->
                            <div class="table-responsive scrollable overflow-y-auto" style="max-height: 480px;">
                                <table class="table table-bordered stripe search-table" tabindex=0 id="allProduct">
                                    <thead>
                                        <tr>
                                            <th class="w-10px pe-2">
                                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                    <input class="form-check-input selectAll" type="checkbox" value="1"/>
                                                </div>
                                            </th>
                                            <th>Product Code</th>
                                            <th>Product Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allProducts as $value)
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input type="checkbox" name="productsAll[]" class="form-check-input tableItem productsAll" value="{{$value->ProductId}}">
                                                    </div>
                                                </td>
                                                <td>{{$value->PastelCode}}</td>
                                                <td>{{$value->PastelDescription}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Datatable-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6"  style="height:100%;background: white;height:70%;overflow-y: scroll">
        <div class="col-lg-12">
            <input type="hidden" id="customerId" value="{{$customerId}}">
            <h4>Prohibited Products</h4>
            <i>Please remove the product</i>
            <table class="table table-bordered stripe search-table" tabindex=0 id="productOnPush"  style="font-size:11px;  color: black;font-family: sans-serif;" >
                <thead style="font-size: 17px;">
                <tr>
                    <th class="col-sm-2">Product Code</th>
                    <th class="col-sm-3">Product Description</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($pushProducts as $value)
                    <tr>
                        <td>{{$value->PastelCode}}</td>
                        <td>{{$value->PastelDescription}}</td>
                        <td class="col-sm-1"> <input type="checkbox" name="productsOnPush[]" class="productsOnPush" value="{{$value->ProductId}}" style="height: 18px !important;"></td>
                    </tr>
                @endforeach

                </tbody>

            </table>
        </div>
        <button class="btn-md btn-danger" id="removeProduct">Remove Product(s)</button>
    </div>
    <div class="col-lg-6">
        <div class="col-lg-12" style="height:100%;background : linen;height:70%;overflow-y: scroll">
            <h4>All Products</h4>
            <table class="table table-bordered stripe search-table" tabindex=0 id="allProduct" style="font-size:11px;  color: black;font-family: sans-serif;" >
                <thead style="font-size: 17px;">
                <tr>
                    <th class="col-sm-1">Product Code</th>
                    <th class="col-sm-1">Product Description</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($allProducts as $value)
                    <tr>
                        <td>{{$value->PastelCode}}</td>
                        <td>{{$value->PastelDescription}}</td>
                        <td class="col-sm-1"><input type="checkbox" name="productsAll[]" class="productsAll" value="{{$value->ProductId}}" style="height: 18px !important;"></td>
                    </tr>
                @endforeach

                </tbody>

            </table>
        </div>
        <button class="btn-md btn-danger" id="pushTheProduct">Add To Prohibit List</button>
    </div>

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

            $('#pushTheProduct').click(function() {
                var productsAll = $("input[name='productsAll[]']:checked").map(function () {
                    return $(this).val();
                }).get()
                $.ajax({
                    url: '{!!url("/insertIntoProhibitProducts")!!}',
                    type: "POST",
                    data: {
                        productsAll: productsAll,
                        customerId: $('#customerId').val()

                    },
                    success: function (data) {

                        var dialog = $('<p><strong>Products Added into Push List</strong></p>').dialog({
                            height: 200, width: 700, modal: true, containment: false,
                            buttons: {
                                "OKAY": function () {

                                    dialog.dialog('close'); location.reload(true);

                                }
                            }
                        });
                    }
                });
            });
            $('#removeProduct').click(function() {

                var productOnPush = $("input[name='productsOnPush[]']:checked").map(function () {
                    return $(this).val();
                }).get()
                $.ajax({
                    url: '{!!url("/removeProhibitProducts")!!}',
                    type: "POST",
                    data: {
                        productOnPush: productOnPush,
                        customerId: $('#customerId').val()

                    },
                    success: function (data) {

                        var dialog = $('<p><strong>Products Removed from the Push List</strong></p>').dialog({
                            height: 200, width: 700, modal: true, containment: false,
                            buttons: {
                                "OKAY": function () {

                                    dialog.dialog('close'); location.reload(true);

                                }
                            }
                        });
                    }
                });
            });
        });
    </script>

</x-app-layout>

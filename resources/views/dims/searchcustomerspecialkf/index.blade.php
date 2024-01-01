
<x-app-layout>

    <x-slot name="header">
        {{ __('Customer Specials') }}
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
            Customer Specials </li>
        <!--end::Item-->
    </x-slot>

    @include('dims.searchcustomerspecialkf.partials.searchbar')

    <div class="row mt-3" id="afterFilter">
        <div class="col-lg-12">
            <div class="card smaller-card">
                <div class="card-body">
                    <div id="gridContainer">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            hideAll();
            $('#customerMulti').multiselect({
                columns: 1,
                placeholder: 'Select Customer(s)',
                selectAll: true,
                search:true

            });
            $('#productMulti').multiselect({
                columns: 1,
                placeholder: 'Select Product(s)',
                selectAll: true,
                search:true
            });
            $(".ms-options-wrap button").addClass('form-control');
            $('#getCustomerSpecials').click(function(){
                $.ajax({
                    url: '{!!url("/getCurrentSpecialsSearch")!!}',
                    type: "POST",
                    data: {
                        customers:$('#customerMulti').val(),
                        products:$('#productMulti').val()
                    },
                    success: function (data) {
                        $("#gridContainer").dxDataGrid({
                            dataSource:data,
                            showBorders: true,
                            filterRow: { visible: true },
                            allowColumnResizing: true,
                            paging:{
                                pageSize: 50,
                            },
                            columns: [
                                {
                                    dataField: "PastelCode",
                                    caption: "Code",
                                    width: 125
                                },{
                                    dataField: "PastelDescription",
                                    caption: "Description",
                                    width: 250
                                },{
                                    dataField: "CustomerPastelCode",
                                    caption: "Customer Code",
                                    width: 125
                                },{
                                    dataField: "StoreName",
                                    caption: "Customer Description",
                                    width: 250
                                },{
                                    dataField: "Date",
                                    dataType: 'date',
                                    caption: "Date From",
                                    width: 125,
                                    format:"dd-MM-yyyy"
                                },{
                                    dataField: "DateTo",
                                    dataType: 'date',
                                    caption: "Date To",
                                    width: 125,
                                    format:"dd-MM-yyyy"
                                },{
                                    dataField: "Price",
                                    caption: "Price",
                                    width: 125
                                },
                            ],
                        });
                    }
                })
            });
        });
        function hideAll(){
            //$('#routePlanningPopUp').hide();
            $('#orderListing').hide();
            $('#pricing').hide();
            $('#callList').hide();
            $('#copyOrdersBtn').hide();
            $('#tabletLoadingApp').hide();
            $('#salesQuotebtn').hide();
            $('#afterFiltering').hide();
            //$('#doneSorting').hide();
            $('#updateSorting').hide();
            $('#popUpForNewTruckControlSheetHeader').hide();
            $('#messageNB').hide();
            $('#straightForwardPrintThtTruckControlId').hide();
            $('#instantPrint').hide();
            $('#trucSheetViewPopUp').hide();
            $('#popupmoveThis').hide();
            $('#pricingOnCustomer').hide();
            $('#salesOnOrder').hide();
            $('#posCashUp').hide();
            $('#salesInvoiced').hide();
            $('#confirmMove').hide();
            $("#creditOnHold").hide();
        }
    </script>
</x-app-layout>


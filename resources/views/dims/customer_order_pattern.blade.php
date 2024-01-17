<x-app-layout>

    <x-slot name="header">
        {{ __('Customer Order Pattern') }}
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
            Customer Order Pattern
        </li>
        <!--end::Item-->
    </x-slot>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card smaller-card">
                <div class="card-header p-5">
                    <h3 class="card-title">Customer Order Pattern</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive scroll h-400px">
                        <table id ="orderPatternIdTable" class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>2Week</th>
                                    <th>Avg</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order_pattern as $value)
                                    <tr>
                                        <td >{{$value->PastelCode}}</td>
                                        <td>{{$value->PastelDescription}}</td>
                                        <td>{{round($value->twoWeeks,3)}}</td>
                                        <td>{{round($value->Avg,3)}}</td>
                                        <td>
                                            <button class="btn btn-icon btn-danger btn-sm btn-sm-icon remove_customer_order_pattern" value="{{$value->ID}}">
                                                <i class="bi bi-trash3-fill fs-4"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
            $(document).on('click', '.remove_customer_order_pattern', function(e) {
                var $thisParentRow = $(this);
                var $thisVal = $(this).attr("value");

                $.ajax({
                    url: '{!!url("/deletepatternline")!!}',
                    type: "POST",
                    data: {
                        defaultID: $thisval
                    },
                    success: function (data) {
                        alert('deleted '+data);
                        $thisParentRow.closest('tr').remove();
                    }
                });
            });
            $('#orderPatternIdTable tbody').on('click', 'tr', function (e){
                $("#orderPatternIdTable tbody tr").removeClass('row_selectedYellowish');
                $(this).addClass('row_selectedYellowish');
            });
        });
    </script>

</x-app-layout>

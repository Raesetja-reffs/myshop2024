<x-app-layout>
    <x-slot name="header">
        {{ __('GRV') }}
    </x-slot>
    <x-slot name="breadcrum">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('grv.dashboard') }}" class="text-muted text-hover-primary">
                Dashboard
            </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">
            Received
        </li>
    </x-slot>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Filters</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-2 itCanHide">
                                <label for="dateFrom">Date From</label>
                                <input type="text" class="form-control" id="dateFrom">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="dateTo">Date To</label>
                                <input type="text" class="form-control" id="dateTo">
                            </div>
                            <div class="col-md-4 mb-2">
                                <button type="button" class="btn btn-success btn-sm mt-md-6 search_data">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card smaller-card">
                <div class="card-body">
                    <div class="table-responsive scroll h-400px">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Supplier</th>
                                    <th>PO</th>
                                    <th>Date Time Received</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($pos)
                                    @foreach ($pos as $po)
                                        <tr>
                                            <td>{{ $po['customer_name'] }}</td>
                                            <td>{{ $po['po'] }}</td>
                                            <td>{{ $po['datetime'] }}</td>
                                            <td>
                                                <button type="button" customer_name="{{ $po['customer_name'] }}" class="btn btn-primary btn-sm ps-6 pe-6 view_pos">
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="showPosDetails">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Items
                    </h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var pos = {!! json_encode($pos) !!};
        $(document).ready(function() {
            $("#dateTo,#dateFrom").datepicker({
                changeMonth: true, //this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: 'dd-mm-yy'
            });
            $(".search_data").click(function(event) {

            });
            $(".view_pos").click(function(event) {
                var rows = '';
                $.each(pos, function(index, value) {
                    if (value.customer_name == $(this).attr('customer_name')) {
                        $.each(value.items, function(index1, item) {
                            rows += `
                                <tr>
                                    <td>${item.item_code}</td>
                                    <td>${item.item_name}</td>
                                    <td>${item.quantity}</td>
                                </tr>
                            `;
                        });
                    }
                });
                $('#showPosDetails').find('table tbody').html(rows);
                $('#showPosDetails').modal('show');
            });
        });
    </script>
</x-app-layout>

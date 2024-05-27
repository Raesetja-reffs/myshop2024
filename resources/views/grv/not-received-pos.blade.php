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
            Not Received POs
        </li>
    </x-slot>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="gridNotReceivedPos" style="width: 100%;"></div>
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
                    <div class="table-responsive scroll h-400px">
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
            var dataGrid = $("#gridNotReceivedPos").dxDataGrid({
                dataSource: pos,
                filterRow: { visible: true },
                // searchPanel: { visible: true },
                grouping: {
                    autoExpandAll: false,
                    contextMenuEnabled: true
                },
                columns: [
                    {
                        dataField: 'customer_name',
                        caption: 'Supplier Name',
                        groupIndex: 0,
                    },
                    {
                        dataField: 'item_code',
                        caption: 'Customer Name',
                    },
                    {
                        caption: 'Actions',
                        cellTemplate: function (container, options) {
                            $(`
                                <button type="button" customer_name="${options.data.customer_name}" class="btn btn-primary btn-sm ps-6 pe-6">
                                    View
                                </button>
                            `)
                                .on('click', function () {
                                    var groupedData = getGroupedData($(this).attr('customer_name'), dataGrid.getDataSource().items());
                                    var rows = '';
                                    if (groupedData) {
                                        groupedData.forEach(function(item) {
                                            rows += `
                                                <tr>
                                                    <td>${item.item_code}</td>
                                                    <td>${item.item_name}</td>
                                                    <td>${item.quantity}</td>
                                                </tr>
                                            `;
                                        });
                                    }
                                    $('#showPosDetails').find('table tbody').html(rows);
                                    $('#showPosDetails').modal('show');
                                })
                                .appendTo(container);
                        },
                        width: 150
                    }
                ],
            }).dxDataGrid("instance");

            function getGroupedData(customer_name, items) {
                var groupedData = [];
                items.forEach(function (item) {
                    if (item.key == customer_name) {
                        groupedData = item.items;
                    }
                });

                return groupedData;
            }
        });
    </script>
</x-app-layout>

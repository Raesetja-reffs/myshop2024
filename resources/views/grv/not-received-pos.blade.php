<x-app-layout>
    <x-slot name="header">
        {{ __('GRV') }}
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
            Dashboard </li>
        <!--end::Item-->
    </x-slot>
    <div id="gridNotReceivedPos" style="width: 100%;"></div>
    <script>
        var pos = {!! json_encode($pos) !!};
        $(document).ready(function() {
            $("#gridNotReceivedPos").dxDataGrid({
                dataSource: pos,
                filterRow: { visible: true },
                searchPanel: { visible: true },
                grouping: {
                    autoExpandAll: false,
                    contextMenuEnabled: true
                },
                columns: [
                    {
                        dataField: 'customer_name',
                        caption: 'Customer Name',
                        groupIndex: 0,
                    },
                    {
                        dataField: 'customer_name',
                        caption: 'Customer Name',
                    },
                    {
                        dataField: '',
                        caption: 'Action',
                    },
                ],
            });
        });
    </script>
</x-app-layout>

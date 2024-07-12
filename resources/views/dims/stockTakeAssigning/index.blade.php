<x-app-layout>

    <x-slot name="header">
        {{ __('Stock Take Assigning') }}
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
            Stock Take Assigning</li>
        <!--end::Item-->
    </x-slot>
    <strong>Stock Take Name:</strong> {{ request()->segment(2) }}
    <strong>User:</strong> {{ request()->segment(3) }}
    <script>
            // Assuming the reference is in the URL like /confirmStocktakeFor/{reference}
            var reference = "{{ request()->segment(2) }}";
            var username = "{{ request()->segment(3) }}";
        </script>
    <div id="gridStockTake" class="col-lg-12"></div>
    @include('dims.stockTakeAssigning.partials.allscripts')

</x-app-layout>

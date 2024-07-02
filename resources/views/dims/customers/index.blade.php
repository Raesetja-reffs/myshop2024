<x-app-layout>

    <x-slot name="header">
        {{ __('Customers') }}
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
            Customers </li>
        <!--end::Item-->
    </x-slot>

    <div id="gridCustomers" style="height: 100%;"></div>

    @include('dims.customers.partials.allscripts')

</x-app-layout>

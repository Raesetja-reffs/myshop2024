<x-app-layout>

    <x-slot name="header">
        {{ __('Credit Requisition Report') }}
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
            Credit Requisition Report 
        </li>
        <!--end::Item-->
    </x-slot>

    <div id="gridCreditRequisitionReport" style="height: 50%;"></div>
    <div id="gridCreditRequests" style="height: 50%;"></div>

    @include('dims.reports.partials.creditRequisitionScripts')

</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        {{ __('Sales Order') }}
    </x-slot>
    <!--begin::Row-->
    <div class="card">
        <div class="card-body">
            @include('dims.sales-order.partials.searchbar')
        </div>
    </div>
    <!--end::Row-->
</x-app-layout>

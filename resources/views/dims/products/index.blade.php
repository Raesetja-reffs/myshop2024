<x-app-layout>

    <x-slot name="header">
        {{ __('Products') }}
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
            Products </li>
        <!--end::Item-->
    </x-slot>

    <div id="gridProducts" style="height: 100%;"></div>

    <div id="popupPushProhibit">
        <div class="dx-field">
            <div class="dx-field-label">Pushed Customers</div>
            <div class="dx-field-value">
                <div id="selectPushed"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Prohibited Customers</div>
            <div class="dx-field-value">
                <div id="selectProhibited"></div>
            </div>
        </div>
    </div>

    @include('dims.products.partials.allscripts')

</x-app-layout>

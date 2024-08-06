<x-app-layout>

    <x-slot name="header">
        {{ __('Drivers Map') }}
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
            Drivers Map </li>
        <!--end::Item-->
    </x-slot>

    <div class="col-12 d-inline-flex h-100">
        <div class="col-4">
            <div id="gridRoutes"></div>
        </div>

        <div class="col-8 position-relative">
            <div id="selectGroups"></div>
            <div id="mapRoutes"></div>
        </div>
    </div>

    <div id="popupGetStops">
        <div class="dx-field">
            <div class="dx-field-label">Delivery Date</div>
            <div class="dx-field-value">
                <div id="selectDeliveryDate"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Route</div>
            <div class="dx-field-value">
                <div id="selectRoute"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Order Type</div>
            <div class="dx-field-value">
                <div id="selectType"></div>
            </div>
        </div>
    </div>

    @include('dims.routeOptimization.partials.driversMapAllscripts')

</x-app-layout>

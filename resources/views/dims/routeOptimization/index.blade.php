<x-app-layout>

    <x-slot name="header">
        {{ __('Route Optimization') }}
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
            Route Optimization </li>
        <!--end::Item-->
    </x-slot>

    <style>
        #gridRoutes .dx-selection {
            background-color: #8bc34a !important;
            color: white !important;
            font-weight: bold !important;
        }

        /* Additional custom styles if needed */
    </style>

    <div class="col-12 d-inline-flex h-100">
        <div class="col-4">
            <div id="gridRoutes"></div>
        </div>

        <div class="col-8 position-relative">
            <div id="mapRoutes" style="height: 78vh;"></div>
            <!-- Floating button container -->
            <div id="btnOverview" class="position-absolute top-0 end-0 m-2"></div>
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

    <div id="popupOverview">
        
    </div>

    @include('dims.routeOptimization.partials.allscripts')

</x-app-layout>

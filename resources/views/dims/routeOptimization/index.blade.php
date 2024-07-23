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

    <div class="container-fluid h-100">
        <div class="row full-height h-100">
            <div class="col-md-2 full-height p-2">
                <div class="mb-3">
                    <label for="deliveryDate" class="form-label">Delivery Date</label>
                    <input type="date" class="form-control" id="deliveryDate" aria-describedby="deliveryDateHelp">
                    <div id="deliveryDateHelp" class="form-text">Select a date that you would like to view the otimized route</div>
                </div>
                <div class="mb-3">
                    <label for="routeId" class="form-label">Route</label>
                    <select id="routeId" class="form-select" aria-describedby="routeHelp">
                        <option></option>
                        @foreach ($routes as $route)
                            <option value="{{ $route->Routeid }}">{{ $route->Route }}</option>
                        @endforeach
                    </select>
                    <div id="routeHelp" class="form-text">Select route to optimize or leave blank to optimize all routes</div>
                </div>
                <div class="mb-3">
                    <label for="typeId" class="form-label">Type</label>
                    <select id="typeId" class="form-select" aria-describedby="typeHelp">
                        <option></option>
                        @foreach ($types as $type)
                            <option value="{{ $type->OrderTypeId }}">{{ $type->OrderType }}</option>
                        @endforeach
                    </select>
                    <div id="typeHelp" class="form-text">Select type or leave blank to optimize all types</div>
                </div>
                <button id='btnGetStops' class="btn btn-primary btn-sm w-100">Get Stops</button>
            </div>
            <div class="col-md-6 full-height p-0 overflow-auto" style="background-color: lightgrey;">
                <div id="map" style="height: 100%;"></div>
                
            </div>
            <div class="col-md-4 p-0 full-height mh-100 p-2">
                <div id="gridRoute"></div>
                <div class="d-inline-flex w-100">
                    <button id='btnOptimize' class="btn btn-primary btn-sm w-50 mt-2 me-2" disabled>Optimize Route</button>
                    <button id='btnUpdateMap' class="btn btn-primary btn-sm w-50 mt-2" disabled>Update Map</button>
                </div>
                
                <button id='btnUpdateSequence' class="btn btn-primary btn-sm w-100 mt-2" disabled>Update Sequence</button>
                
            </div>
        </div>
    </div>

    @include('dims.routeOptimization.partials.allscripts')

</x-app-layout>

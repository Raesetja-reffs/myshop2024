<x-app-layout>

    <x-slot name="header">
        {{ __('Logistics Route Report') }}
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
            Logistics Route Report
        </li>
        <!--end::Item-->
    </x-slot>

    <div class="row">
        <div class="col-2 p-3">
            <h5 style="font-weight: 700;">Route Details</h5>
            <div class="form-group mb-2">
                <label for="driverId" class="control-label fw-bold">Driver Name</label>
                <select id="driverId" class="form-select p-2">
                    @foreach ($routingInfo as $info)
                        <option value="{{ $info->DriverId }}">{{ $info->DriverName }}</option>
                    @endforeach
                    @foreach ($drivers as $driver)
                        <option value="{{ $driver->DriverId }}">{{ $driver->DriverName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-2">
                <label for="assistantId" class="control-label fw-bold">Van Assistant</label>
                <select id="assistantId" class="form-select p-2">
                    @foreach ($routingInfo as $info)
                        <option value="{{ $info->assId }}">{{ $info->AssitName }}</option>
                    @endforeach
                    @foreach ($drivers as $driver)
                        <option value="{{ $driver->DriverId }}">{{ $driver->DriverName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-2">
                <label for="truckId" class="control-label fw-bold">Truck Name</label>
                <select id="truckId" class="form-select p-2">
                    @foreach ($routingInfo as $info)
                        <option value="{{ $info->TruckId }}">{{ $info->RegNo }}</option>
                    @endforeach
                    @foreach ($trucks as $truck)
                        <option value="{{ $truck->TruckId }}">{{ $truck->RegNo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-2">
                <label for="dispatchId" class="control-label fw-bold">Dispatch Area</label>
                <select id="dispatchId" class="form-select p-2">
                    @foreach ($dispatchLocations as $location)
                        <option value="{{ $truck->intAutodispatchlocations }}">{{ $truck->strDoorName }}</option>
                    @endforeach
                </select>
            </div>

            <button id="btnUpdateDetails" class="btn btn-success w-100 h-auto mb-2"
                value="{{ $deliveryDateId }}">Update Details</button>

            @foreach ($routingInfo as $info)
                <div class="form-group mb-2">
                    <label class="control-label fw-bold">Driver Signed For Stock</label>
                    <input class="form-control p-2" value="{{ $info->strdrivername }}" readonly>
                </div>

                <div class="form-group mb-2">
                    <label class="control-label fw-bold">Km Out</label>
                    <input class="form-control p-2" value="{{ $info->mnykmoutt }}" readonly>
                </div>

                <div class="form-group mb-2">
                    <label class="control-label fw-bold">Km In</label>
                    <input class="form-control p-2" value="{{ $info->mnykmdone }}" readonly>
                </div>

                <div class="form-group mb-2">
                    <label class="control-label fw-bold">Trip End Time</label>
                    <input class="form-control p-2" value="{{ $info->dtm }}" readonly>
                </div>
            @endforeach
        </div>
        <div class="col-10">
            <div id="gridRouteCreditRequisition"></div>
        </div>
    </div>

    @include('dims.reports.partials.logisticsRouteReportScripts')

</x-app-layout>

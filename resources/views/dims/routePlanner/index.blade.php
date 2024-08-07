<x-app-layout>

    <x-slot name="header">
        {{ __('Route Planner') }}
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
            Route Planner </li>
        <!--end::Item-->
    </x-slot>

    <div class="row p-2">
        <div class="row h-100">
            <div class="col-10">
                <div class="row">
                    <div class="col-5 p-1">
                        <div class="field mb-2">
                            <div class="value">
                                <div id="selectDateRange"></div>
                            </div>
                        </div>
                        <div class="field mb-2">
                            <div class="value">
                                <div id="selectStatus"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5 p-1">
                        <div class="field mb-2">
                            <div class="value">
                                <div id="selectOrderType"></div>
                            </div>
                        </div>
                        <div class="field mb-2">
                            <div class="value">
                                <div id="selectRoute"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-1">
                        <div class="field mb-2">
                            <div class="value">
                                <div id="inputMass"></div>
                            </div>
                        </div>
                        <div class="field mb-2">
                            <div class="value">
                                <div id="inputOrderVal"></div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="gridRoutePlanner"></div>
            </div>
            <div class="col-2 p-2">
                <h1 id="inputStops" class="text-center p-5">STOPS: 0</h1>
                <div class="field mb-2">
                    <div class="value">
                        <div id="btnGetStops"></div>
                    </div>
                </div>
                {{-- @if($routeplanner !="1") --}}
                    <div class="field mb-2">
                        <div class="value">
                            <div id="btnMoveOrders"></div>
                        </div>
                    </div>
                    <div class="field mb-2">
                        <div class="value">
                            <div id="btnSetSequence"></div>
                        </div>
                    </div>
                    <div class="field mb-2">
                        <div class="value">
                            <div id="btnPreview"></div>
                        </div>
                    </div>
                    <div class="field mb-2">
                        <div class="value">
                            <div id="btnNotifyPickers"></div>
                        </div>
                    </div>
                    @if(viewCheckCompanyPermission('isallowrouteoptomo'))
                        <div class="field mb-2">
                            <div class="value">
                                <div id="btnRouteOptimization"></div>
                            </div>
                        </div>
                    @endif

                    <div class="field mb-2">
                        <div class="value">
                            <div id="btnReprintRoutes"></div>
                        </div>
                    </div>
                    <div class="field mb-2">
                        <div class="value">
                            <div id="btnInvoicesNotPrinting"></div>
                        </div>
                    </div>
                    <div class="field mb-2">
                        <div class="value">
                            <div id="btnLogisticsPlan"></div>
                        </div>
                    </div>
                    <div class="field mb-2">
                        <div class="value">
                            <div id="btnInvoice"></div>
                        </div>
                    </div>
                    <div class="field mb-2">
                        <div class="value">
                            <div id="btnAssignTruck"></div>
                        </div>
                    </div>
                {{-- @endif --}}
            </div>
        </div>
    </div>

    <div id="popupMoveOrders">
        <div class="dx-field">
            <div class="dx-field-label">Delivery Date</div>
            <div class="dx-field-value">
                <div id="selectMoveDeliveryDate"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Delivery Type (Run)</div>
            <div class="dx-field-value">
                <div id="selectMoveOrderType"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Route</div>
            <div class="dx-field-value">
                <div id="selectMoveRoute"></div>
            </div>
        </div>
    </div>


    @include('dims.routePlanner.partials.allscripts')

</x-app-layout>

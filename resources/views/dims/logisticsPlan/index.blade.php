<x-app-layout>

    <x-slot name="header">
        {{ __('Logistics Plan') }}
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
            Logistics Plan 
        </li>
        <!--end::Item-->
    </x-slot>

    <style>
        .container-xxl {
            padding-left: 0px !important;
            padding-right: 0px !important;
        }

        #livedrivers {
            border: 2px solid black; /* Dark grey border */
        }

        #livedrivers th, #livedrivers td {
            border: 1px solid black; /* Dark grey border for table cells */
        }
    </style>

    @php $amountTotal = 0; @endphp

    <div class="col-md-12 w-100 h-100 p-3" style="background: black; color: white;">
        <div class="row g-2 mb-2">
            <div class="col-auto">
                <button id="btnDriversMap" class="btn btn-primary h-auto">Drivers Map</button>
            </div>
            <div class="col-auto">
                <button id="btnCreditReqReport" class="btn btn-primary h-auto">Credit Req</button>
            </div>
            <div class="col-auto">
                <input type="text" class="form-control h-100" id="inputDeliveryDate" value="{{ $delDate }}">
            </div>
            <div class="col-auto">
                <button class="btn btn-success h-auto" id="btnSearchPlan">Search</button>
            </div>
        </div>
        
        <table class="table" id="livedrivers">
            <thead>
                <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Routing ID</th>
                <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Route</th>
                <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Area</th>
                <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">DriverName</th>
                <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Assistant</th>
                <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">TruckName</th>
                <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Inv<i
                        style="color:red">Ret</i></th>
                <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Stops</th>
                <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Dispatch Area</th>
                <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Time Spent</th>
                <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Amount</th>
            </thead>

            <tbody style="font-size: 16px;font-family: sans-serif;font-weight: 900;">
                @foreach ($performance as $val)
                    <tr style="background: red;color: black">
                        <td>{{ $val->DeliveryDateRoutingID }} </td>
                        <td>{{ trim($val->OrderType) }}</td>
                        <td>{{ trim($val->Route) }}</td>
                        <td>{{ $val->DriverName }}</td>
                        <td>{{ $val->ASSIS }}</td>
                        <td>{{ $val->TruckName }}</td>
                        <td>{{ $val->stopsDelv }} <i style="color:red">{{ $val->cReq }}</i></td>
                        <td>{{ $val->NoOfStops }}</td>
                        <td>{{ $val->strDoorName }}</td>
                        <td>{{ $val->Travelling }}</td>
                        <td>{{ $val->routeAmaount }}</td>
                        <?php $amountTotal = $amountTotal + $val->routeAmaount; ?>
                    </tr>
                @endforeach
                @foreach ($planned as $val2)
                    @if ($val2->doneBusy == 'done')
                        <tr style="color: black;background:green;">
                        @else
                        <tr style="color: white">
                    @endif
                    <td>{{ $val2->DeliveryDateRoutingID }} </td>
                    <td>{{ trim($val2->OrderType) }}</td>
                    <td>{{ trim($val2->Route) }}</td>
                    <td>{{ $val2->DriverName }}</td>
                    <td>{{ $val2->ASSIS }}</td>
                    <td>{{ $val2->TruckName }}</td>
                    <td>{{ $val2->stopsDelv }}<i style="color:red">{{ $val2->cReq }}</i></td>
                    <td>{{ $val2->NoOfStops }}</td>
                    <td>{{ $val2->strDoorName }}</td>
                    <td>{{ $val2->Travelling }}</td>
                    <td>{{ $val2->routeAmaount }}</td>
                    <?php $amountTotal = $amountTotal + $val2->routeAmaount; ?>
                    </tr>
                @endforeach
                <tr style="color: white">
                    <td> </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="color: green;">{{ $amountTotal }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @include('dims.logisticsPlan.partials.allScripts')

</x-app-layout>

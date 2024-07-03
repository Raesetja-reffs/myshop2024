<x-app-layout>

    <x-slot name="header">
        {{ __('Group Specials') }}
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
            Group Specials </li>
        <!--end::Item-->
    </x-slot>

    <style>
        .menu-button .dx-button-text {
            font-size: 12px !important;
        }

        .action-icon-button .dx-icon.fa {
            font-size: 12px !important;
        }
    </style>

    <div id="gridGroupSpecials" class="p-2"></div>

    <div id="popupSpecials">
        <div class="dx-field">
            <div class="dx-field-label">Deal name</div>
            <div class="dx-field-value">
                <div id="inputDealName"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Select Groups</div>
            <div class="dx-field-value">
                <div id="selectGroups"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Select Date Range</div>
            <div class="dx-field-value">
                <div id="selectDateRange"></div>
            </div>
        </div>
        <div class="dx-field">
            <div id="gridProducts"></div>
        </div>
    </div>

    @include('dims.groupSpecials.partials.allscripts')

</x-app-layout>

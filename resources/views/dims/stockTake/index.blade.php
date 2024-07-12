<x-app-layout>

    <x-slot name="header">
        {{ __('Stock Take') }}
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
            Stock Take </li>
        <!--end::Item-->
    </x-slot>

    <div id="gridStockTake" class="col-lg-12"></div>
    <div id="popupCreate">
    <div class="dx-field">
            <div class="dx-field-label">Reference</div>
            <div class="dx-field-value">
                <div id="inputStockTakeName"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Assign Red Team Members</div>
            <div class="dx-field-value">
                <div id="selectReds"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Assign Blue Team Members</div>
            <div class="dx-field-value">
                <div id="selectBlues"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Assign Manager Team Members</div>
            <div class="dx-field-value">
                <div id="selectManagers"></div>
            </div>
        </div>
<!--
        <div class="dx-field">
            <div class="dx-field-label">Select Location</div>
            <div class="dx-field-value">
                <div id="selectLocations"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Select Bins</div>
            <div class="dx-field-value">
                <div id="selectBins"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Select Product Groups</div>
            <div class="dx-field-value">
                <div id="selectProductGroups"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Select Stock Take Teams</div>
            <div class="dx-field-value">
                <div id="selectTeams"></div>
            </div>
        </div>-->
    </div>

    
    @include('dims.stockTake.partials.allscripts')

</x-app-layout>

<x-app-layout>

    <x-slot name="header">
        {{ __('Price Printing') }}
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
            Price Printing</li>
        <!--end::Item-->
    </x-slot>
    
    <div class="dx-field">
            <div class="dx-field-label">Group</div>
            <div class="dx-field-value">
                <div id="inputGroup"></div>
            </div>
        </div>

        <div class="dx-field">
            <div class="dx-field-label">Customer</div>
            <div class="dx-field-value">
                <div id="inputCustomer"></div>
            </div>
        </div>
        
    <div class="col-md-4 mb-2">
            <button type="button" id="submitCustomerData" class="btn btn-success btn-sm mt-md-6">
            Submit Customer Data
            </button>
    </div>
    <div class="col-md-4 mb-2">
            <button type="button" id="submitGroupData" class="btn btn-success btn-sm mt-md-6">
            Submit Group Data
            </button>
    </div>

    <div id="gridContainer" class="col-lg-12"></div>
    

    @include('dims.priceprinting.partials.allscripts')

</x-app-layout>

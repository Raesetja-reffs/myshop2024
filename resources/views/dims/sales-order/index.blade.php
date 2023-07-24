<x-app-layout>
    <x-slot name="header">
        {{ __('Sales Order') }}
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
            Dashboard </li>
        <!--end::Item-->
    </x-slot>
    <?php
    if ((Auth::guest()))
    {

    }else{
        $v  =  new \App\Http\Controllers\SalesForm();
        $thingsAllowDiscount = $v->getThings(Auth::user()->GroupId,'Discountinput');
        $userActions = $v->getThings(Auth::user()->GroupId,'Access User Actions');
    }
    $discountProperty = "";
    if($thingsAllowDiscount != 1)
    {
        $discountProperty = "readonly";
    }

    ?>
    @include('dims.sales-order.partials.searchbar')
    @include('dims.sales-order.partials.order-details')
    @include('dims.sales-order.partials.order-listing')
    <!-- Script: -->
    @include('dims.sales-order.partials.allscript')
</x-app-layout>

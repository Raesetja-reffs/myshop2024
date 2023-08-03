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
    <x-slot name="salestotalorder">
        <table class="table flex-end w-400px mt-5">
            <tr>
                <td class="p-1">No.Orders Today</td>
                <td class="p-1">Order Val</td>
                <td class="p-1">Avg Ord Val</td>
            </tr>
            @foreach ($userperformance as $value)
                <tr>
                    <td class="p-1">{{ $value->NoOfOrders }}</td>
                    <td class="p-1">{{ round($value->OrderValue, 2) }}</td>
                    <td class="p-1">{{ round($value->AvgOrderValue, 2) }}</td>
                </tr>
            @endforeach
        </table>
    </x-slot>
    @include('dims.sales-order.partials.searchbar')
    @include('dims.sales-order.partials.order-details')
    @include('dims.sales-order.partials.order-listing')
    @include('dims.sales-order.partials.alldialogs')
    @include('dims.on_order')
    @include('dims.oninvoiced')
    <!-- Script: -->
    @include('dims.sales-order.partials.allscript')
</x-app-layout>

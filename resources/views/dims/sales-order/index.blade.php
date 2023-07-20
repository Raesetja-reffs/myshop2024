<x-app-layout>
    <x-slot name="header">
        {{ __('Sales Order') }}
    </x-slot>
    <!--begin::Row-->
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
    <!--end::Row-->
    @include('dims.sales-order.partials.allscript')
    <script>
    </script>
</x-app-layout>

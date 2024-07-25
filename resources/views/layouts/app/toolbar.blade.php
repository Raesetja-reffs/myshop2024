<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::This is for mobile screen-->
    @if (isset($salestotalorder))
        <div class="d-flex d-sm-none w-300px ms-6">
            {{ $salestotalorder }}
        </div>
    @endif
    <!--end::This is for mobile screen-->
    <!--begin::Container-->
    <div id="kt_toolbar_container" class=" container-fluid  d-flex flex-stack">

        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center me-3 flex-wrap lh-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">
                @if (isset($header))
                    {{ $header }}
                @endif
            </h1>
            <!--end::Title-->

            <!--begin::Separator-->
            <span class="h-20px border-gray-200 border-start mx-4"></span>
            <!--end::Separator-->

            @if (isset($breadcrum))
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                    {{ $breadcrum }}
                </ul>
                <!--end::Breadcrumb-->
            @endif
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Container-->
    <!--begin::This is for full screen-->
    @if (isset($salestotalorder))
        <div class="d-none d-sm-flex">
            {{ $salestotalorder }}
        </div>
    @endif
    @if (isset($toolbarrightside))
        <div class="d-flex justify-content-end" style="width: 1100px;">
            {{ $toolbarrightside }}
        </div>
    @endif
    <!--end::This is for full screen-->
</div>
<!--end::Toolbar-->

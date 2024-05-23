<!--begin::Col-->
<div class="col-sm-6 col-xl-2">
    <!--begin::Card widget 2-->
    <a href="{{ $link }}">
        <div class="card h-lg-100">
            <!--begin::Body-->
            <div class="card-body d-flex justify-content-between align-items-start flex-column p-5">
                <!--begin::Icon-->
                <div class="m-0">
                    <i class="ki-outline ki-{{ $icon }} fs-2hx text-gray-600"></i>
                </div>
                <!--end::Icon-->

                <!--begin::Section-->
                <div class="d-flex flex-column my-7">
                    <!--begin::Number-->
                    <span class="fw-semibold fs-3 text-gray-800 lh-1 ls-n2">{{ $count }}</span>
                    <!--end::Number-->
                    <!--begin::Follower-->
                    <div class="m-0">
                        <span class="fw-semibold fs-6 text-gray-400">{{ $title }}</span>
                    </div>
                    <!--end::Follower-->
                </div>
                <!--end::Section-->
            </div>
            <!--end::Body-->
        </div>
    </a>
    <!--end::Card widget 2-->
</div>
<!--end::Col-->

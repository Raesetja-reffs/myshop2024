<div id="kt_aside" class="aside  aside-dark aside-hoverable " data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">

    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ route('home') }}">
            <img alt="Logo" src="{{ asset('images/Logo-01.png') }}" class="logo" style="width: 100%;background-color: white;padding: 0 10px;" />
        </a>
        <!--end::Logo-->

        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle me-n2"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">

            <i class="ki-outline ki-double-left fs-1 rotate-180"></i>
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Brand-->

    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y py-2" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true">
                @php $menuItems = getMenuItems(); @endphp

                @foreach ($menuItems as $menuItem)
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        @if (isset($menuItem['href']))
                            <a class="menu-link" href="{{ $menuItem['href'] }}"
                                @if (isset($menuItem['windowopen']))
                                    onclick="window.open(this.href, '{{ $menuItem['windowopen']['name'] }}','left=20,top=20,width={{ $menuItem['windowopen']['width'] }},height={{ $menuItem['windowopen']['height'] }},toolbar=1,resizable=0'); return false;"
                                @else
                                    onclick="window.location.href = '{{ $menuItem['href'] }}'; return false;"
                                @endif>
                                <span class="menu-icon">
                                    <i class="{{ $menuItem['icon'] }}"></i>
                                </span>
                                <span class="menu-title">{{ $menuItem['name'] }}</span>
                            </a>
                        @else
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="{{ $menuItem['icon'] }}"></i>
                                </span>
                                <span class="menu-title">{{ $menuItem['name'] }}</span>
                                <span class="menu-arrow"></span>
                            </span>
                        @endif
                        @if (isset($menuItem['submenuitems']))
                            <div class="menu-sub menu-sub-accordion">
                                @foreach ($menuItem['submenuitems'] as $subMenuItem)
                                    <div class="menu-item">
                                        @if (isset($subMenuItem['windowopen']))
                                            <a class="menu-link" href="{{ $subMenuItem['href'] }}"
                                                onclick="window.open(this.href, '{{ $subMenuItem['windowopen']['name'] }}','left=20,top=20,width={{ $subMenuItem['windowopen']['width'] }},height={{ $subMenuItem['windowopen']['height'] }},toolbar=1,resizable=0'); return false;">
                                                <span class="menu-icon">
                                                    <span class="{{ $subMenuItem['icon'] }}"></span>
                                                </span>
                                                <span class="menu-title">{{ $subMenuItem['name'] }}</span>
                                            </a>
                                        @elseif (isset($subMenuItem['target']))
                                            <a class="menu-link" href="{{ $subMenuItem['href'] }}"
                                                target="{{ $subMenuItem['target'] }}">
                                                <span class="menu-icon">
                                                    <span class="{{ $subMenuItem['icon'] }}"></span>
                                                </span>
                                                <span class="menu-title">{{ $subMenuItem['name'] }}</span>
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link--><a class="menu-link"
                        href="https://preview.keenthemes.com/html/metronic/docs/getting-started/changelog"
                        target="_blank">
                            <span class="menu-icon">
                                <i class="ki-outline ki-code fs-2"></i>
                            </span>
                            <span class="menu-title">DIMS24: V 23.02.22.01</span>
                        </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
            </div>
            <!--end::Menu-->
        </div>
    </div>
    <!--end::Aside menu-->
</div>

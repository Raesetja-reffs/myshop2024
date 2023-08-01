<div class="d-flex align-items-stretch" id="kt_header_nav">
    <!--begin::Menu wrapper-->
    <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu"
        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
        data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end"
        data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend"
        data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
        <!--begin::Menu-->
        <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-state-primary menu-title-gray-800 menu-arrow-gray-400 align-items-stretch my-5 my-lg-0 px-2 px-lg-0 fw-semibold fs-6"
            id="#kt_header_menu" data-kt-menu="true">

            @auth
                @php $navBarItems = getNavBarItems(); @endphp
                @foreach ($navBarItems as $navBarItem)
                    <div class="menu-item  menu-lg-down-accordion me-0 me-lg-2" style="{{ isset($navBarItem['menu_item_style']) ? $navBarItem['menu_item_style'] : '' }} ">
                        @if (isset($navBarItem['isLink']) && $navBarItem['isLink'])
                            <a class="menu-link py-3 {{ request()->routeIs($navBarItem['route']) ? 'active' : '' }}"
                                href="{{ route($navBarItem['route']) }}">
                                <span class="menu-title">
                                    {{ $navBarItem['name'] }}
                                </span>
                            </a>
                        @else
                            <a href="javascript:void(0);" id="{{ $navBarItem['id'] }}"
                                class="menu-link py-3 {{ request()->routeIs($navBarItem['route']) ? 'active' : '' }}">
                                <span class="menu-title">
                                    {{ $navBarItem['name'] }}
                                </span>
                            </a>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="menu-item me-lg-1">
                    <a class="menu-link py-3 {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                        <span class="menu-title">Login</span>
                    </a>
                </div>
                <div class="menu-item me-lg-1">
                    <a class="menu-link py-3 {{ request()->routeIs('register') ? 'active' : '' }}"
                        href="{{ route('register') }}">
                        <span class="menu-title">Register</span>
                    </a>
                </div>
            @endauth
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>

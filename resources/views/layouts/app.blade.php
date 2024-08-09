<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="{{ asset('images/dimslogo.png') }}" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('css/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.bundle.css?v=' . config('app.css_version')) }}" rel="stylesheet" type="text/css" />

    <!-- begin: Page level CSS -->
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/jquery.multiselect.css') }}" rel="stylesheet" type="text/css" />
    <!-- end: Page level CSS -->

    <!--end::Global Stylesheets Bundle-->
    <link href="{{ asset('css/myicons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/tippop.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/contextMenu.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/jquery.flexdatalist.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/dx.material.dims-theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.css?v=' . config('app.css_version')) }}" rel="stylesheet" type="text/css" />

    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('js/plugins.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->

    <!-- begin: Page level JS -->
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/colResizable-1.6.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.tippop.min.js') }}"></script>
    <script src="{{ asset('js/contextMenu.js') }}"></script>
    <script src="{{ asset('js/jquery.flexdatalist.js') }}"></script>
    <script src="{{ asset('js/jquery.mcautocomplete.js') }}"></script>
    <script src="{{ asset('js/jquery.multiselect.js') }}"></script>
    <script src="{{ asset('js/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <script src="{{ asset('js/jquery.pleaseWait.js') }}"></script>
    <script src="{{ asset('js/dx.all.js') }}"></script>
    <script src="{{ asset('js/exceljs.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset('js/jspdf.umd.min.js') }}"></script>
    <!-- end: Page level JS -->
    <script src="{{ asset('js/commonScript.js?v=' . config('app.js_version')) }}"></script>
    <script src="{{ asset('js/app.js?v=' . config('app.js_version')) }}"></script>
</head>

@php $sidebaropenValue = 'on'; @endphp
@if (isset($sidebaropen))
    @php $sidebaropenValue = ''; @endphp
@endif

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px" data-kt-aside-minimize="{{ $sidebaropenValue }}">
    <!--begin::Theme mode setup on page load-->
    @include('layouts.theme-mode')
    <!--end::Theme mode setup on page load-->

    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Aside-->
            @include('layouts.app.asidemenu')
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                @include('layouts.app.header')
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid " id="kt_content">
                    <!--begin::Toolbar-->
                    @include('layouts.app.toolbar')
                    <!--end::Toolbar-->
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class=" container-xxl ">
                            <x-general-loader />
                            @if (session('success'))
                                <x-general-alert-message type="success" :message="session('success')" />
                            @endif
                            @if (session('error'))
                                <x-general-alert-message type="danger" :message="session('error')" />
                            @endif
                            {{ $slot }}
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                @include('layouts.app.footer')
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Scrolltop-->
    @include('layouts.app.scrolltop')
    <!--end::Scrolltop-->
    <!-- Auth modal -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true" style="z-index: 99999 !important;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-3 border-danger">
                <div class="modal-header">
                    <h5 class="modal-title" id="authModalLabel">Special below margin, please authorize.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeauthModal"></button>
                </div>
                <div class="modal-body">
                    <form id="AuthForm">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter password">
                        </div>
                        <button type="submit" class="btn btn-danger mt-2" style="height:40px;">Authorize</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#clearlocks').click(function(){
                //console.debug($('#orderId').val());
                if ($('#orderId').length > 0) {
                    if($('#orderId').val().length < 3) {
                        $.ajax({
                            url: '{!!url("/deleteuserOrderLocks")!!}',
                            type: "POST",
                            data: {
                                userId: $('#clearlocks').val()
                            },
                            primary: function (data) {

                            },
                            success: function(data) {
                                showAlert('success', "All locks has been successfully deleted.")
                            }
                        });
                    }else {
                        var dialog = $('<p>Please Reload you DIMS before clearing your locks and also make sure everything is saved.</p>').dialog({
                            height: 200, width: 700, modal: true, containment: false,
                            buttons: {
                                "OKAY": {
                                    text: "OKAY",
                                    class: "btn btn-primary btn-sm",
                                    click: function() {
                                        dialog.dialog('close');
                                    }
                                }
                            }
                        });
                    }
                }
            });

            $('#offcanv').click(function(){
                $('#offcanvas').toggle();
            });
        });
        var today = new Date();
        var date = today.toISOString().substr(0, 10); // get the date in YYYY-MM-DD format
        var link = document.getElementById("logisticsplan");
        if (link) {
            link.href += "/" + date; // append the date as a parameter to the href attribute
        }
    </script>
    @stack('scripts')
</body>

</html>

<!DOCTYPE html>
<html lang="en" data-topbar-color="dark">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="ws_url" content="{{ env('WS_URL') }}">
    <meta name="user_id" content="{{Auth::id() }}">
    <!-- Title -->
    <title> {{env('APP_NAME') }} @hasSection('title') - @yield('title') @else - @endif </title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('ubold/assets/images/favicon.ico')}}">

    <!-- third party css -->
    <link href="{{asset('ubold/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('ubold/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('ubold/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('ubold/assets/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- Plugins css -->
    <link href="{{asset('ubold/assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('ubold/assets/libs/selectize/css/selectize.bootstrap3.css')}}" rel="stylesheet" type="text/css" />

    <!-- Theme Config Js -->
    <script src="{{asset('ubold/assets/js/head.js')}}"></script>

    <!-- Bootstrap css -->
    <link href="{{asset('ubold/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- App css -->
    <link href="{{asset('ubold/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Icons css -->
    <link href="{{asset('ubold/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" type="text/css" href="{{asset('tables/css/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('tables/css/datatable/responsive.bootstrap4.min.css')}}">


    <link rel="stylesheet" href="{{asset('lib/charts/css/chart-apex.css')}}">
    <link rel="stylesheet" href="{{asset('lib/charts/css/apexcharts.css')}}">


    <link rel="stylesheet" type="text/css" href="{{asset('lib/bootstrap-fileinput/css/fileinput.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('lib/font-awesome/css/font-awesome.min.css')}}">

    {{-- <link rel="stylesheet" type="text/css" href="{{asset('tables/css/pickers/flatpickr/flatpickr.min.css')}}">--}}

    <link rel="stylesheet" type="text/css" href="{{asset('lib/select2/css/select2.min.css')}}">

    @yield('stylesheet')

</head>

<body>
    <div id="wrapper">
        <div class="app-menu">
            <!-- Brand Logo -->
            <div class="logo-box">
                <!-- Brand Logo Light -->
                <a href="index.html" class="logo-light">
                    <img src="{{asset('ubold/assets/images/logo-light.png')}}" alt="logo" class="logo-lg">
                    <img src="{{asset('ubold/assets/images/logo-sm.png')}}" alt="small logo" class="logo-sm">
                </a>

                <!-- Brand Logo Dark -->
                <a href="index.html" class="logo-dark">
                    <img src="{{asset('ubold/assets/images/logo-dark.png')}}" alt="dark logo" class="logo-lg">
                    <img src="{{asset('ubold/assets/images/logo-sm.png')}}" alt="small logo" class="logo-sm">
                </a>
            </div>
            <!-- menu-left -->
            <div class="scrollbar">

                <!--- Menu -->
                @include('admin.templates.sidebar')
                <!--- End Menu -->
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="content-page">
            <!-- ========== HEADER ========== -->
            @include('admin.templates.header')
            <!-- ========== END HEADER ========== -->

            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    @yield('breadcumbs')
                    <!-- end page title -->

                    @yield('content')
                    <!-- end row-->

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            @include('admin.templates.footer')
            <!-- end Footer -->
        </div>
    </div>
    <!-- ========== END MAIN CONTENT ========== -->

    <!-- ========== END SECONDARY CONTENTS ========== -->

    <!-- Vendor js -->
    <script src="{{asset('ubold/assets/js/vendor.min.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('ubold/assets/js/app.min.js')}}"></script>

    <!-- Plugins js-->
    <script src="{{asset('ubold/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{asset('ubold/assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('ubold/assets/libs/selectize/js/standalone/selectize.min.js')}}"></script>

    <!-- third party js -->
    <script src="{{asset('ubold/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('ubold/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('ubold/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('ubold/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
    <script src="{{asset('ubold/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('ubold/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js')}}"></script>
    <script src="{{asset('ubold/assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('ubold/assets/libs/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('ubold/assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('ubold/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('ubold/assets/libs/datatables.net-select/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('ubold/assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('ubold/assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
    <!-- third party js ends -->

    <!-- Datatables init -->
    <!-- <script src="{{asset('ubold/assets/js/pages/datatables.init.js')}}"></script> -->

    <!-- Dashboar 1 init js-->
    <script src="{{asset('ubold/assets/js/pages/dashboard-1.init.js')}}"></script>

    <!-- jquery-validation Js -->

    <script src="{{asset('lib/jquery-validation/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('lib/form/form-validation.js')}}"></script>
    <script src="{{asset('lib/sweetalert2/sweetalert2.js')}}"></script>

    <!-- JS Front -->
    <script src="{{asset('tables/js/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('tables/js/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('tables/js/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('tables/js/datatable/responsive.bootstrap4.js')}}"></script>
    <script src="{{asset('js/core.js')}}"></script>

    <script src="{{asset('lib/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('lib/select2/js/form-select2.js')}}"></script>

    <script src="{{asset('lib/bootstrap-fileinput/js/fileinput.js')}}"></script>
    <script src="{{asset('lib/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('lib/fa-theme/theme.js')}}"></script>
    <script src="{{asset('lib/charts/js/chart-apex.js')}}"></script>
    <script src="{{asset('lib/charts/js/apexcharts.js')}}"></script>

    <!-- {{--SOCKET JS--}}
    <script src="{{ asset('lib/socket/vue.js') }}"></script>
    <script src="{{ asset('lib/socket/socket.io.js') }}"></script>
    <script src="{{ asset('lib/socket/moment.min.js') }}"></script>
    <script src="{{ asset('lib/socket/chat.js') }}"></script>
    <script src="{{ asset('lib/socket/notif.js') }}"></script>
    {{--SOCKET JS--}} -->


    <!-- End Style Switcher JS -->

    @yield('script')
</body>

</html>
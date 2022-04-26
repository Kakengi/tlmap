<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TIE-TLMAP</title>
    <link rel="shortcut icon" href="{{ asset('backend/dist/img/logo.ico') }}" />


    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('../../backend/plugins/select2/css/select2.min.css') }}">
    {{-- <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" /> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    @stack('styles')
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 1px !important;
        }

        .invalid-feedback {
            display: block !important;
        }

    </style>
</head>

<body class="layout-fixed sidebar-mini-md sidebar-collapse layout-navbar-fixed">


    {{-- control-sidebar-slide-open --}}


    <div class="wrapper">

        <!-- Navbar -->
        @include('layouts.backend.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->
        @include('layouts.backend.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> --}}
    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('backend/dist/js/adminlte.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('backend/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('backend/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('backend/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('backend/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('backend/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/daterangepicker/daterangepicker.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('backend/dist/js/pages/dashboard.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('backend/dist/js/demo.js') }}"></script>
    <script src="{{ asset('../../backend/plugins/select2/js/select2.full.min.js') }}"></script>
    {{-- <script src="{{ asset('js/select2.min.js') }}"></script> --}}

    <script src="{{ asset('js/toastr.min.js') }}"></script>
    {{-- <script src="{{ LarapexChart::cdn() }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    {{-- <script src="{{ asset('vendor/larapex-charts/apexchart.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('js/ajax_request.js') }}"></script>
    <script>
        @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}")
        @endif

        @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}")
        @endif

        $(function() {
            $(".date-range-picker").daterangepicker({
                singleDatePicker: true
                , showDropdowns: true
                , minYear: 2020
                , maxYear: parseInt(moment().format('YYYY'), 10) + 1
                , locale: {
                    format: "YYYY-MM-DD"
                }

            });


            $('#years').select2({
                theme: 'classic'
                , placeholder: 'Select Year ...'
                , clear: true
            , });

            $('#region').select2({
                theme: 'classic'
                , placeholder: 'Select Region ...'
                , clear: true
            , });

            $('#district').select2({
                theme: 'classic'
                , placeholder: 'Select Region First ...'
                , clear: true
            , });

            $.widget.bridge('uibutton', $.ui.button)
            $('.btn-delete').on('click', function() {
                var x = confirm("Are you sure you want to delete this item?")
                if (x) {
                    return true
                }
                return false
            })

            $('.btn-restore').on('click', function() {
                var x = confirm("Are you sure you want to restore this item?")
                if (x) {
                    return true
                }
                return false
            })


            $('#page-length').on('change', function() {
                var url = removeParam('per_page', $(this).closest('form').attr('action'))
                var per_page = $(this).val();
                url = url.includes('?') ? url + "&per_page=" + per_page : url +
                    "?per_page=" + per_page;
                window.location.href = url
            })

            function removeParam(key, sourceURL) {
                var rtn = sourceURL.split("?")[0]
                    , param
                    , params_arr = []
                    , queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
                if (queryString !== "") {
                    params_arr = queryString.split("&");
                    for (var i = params_arr.length - 1; i >= 0; i -= 1) {
                        param = params_arr[i].split("=")[0];
                        if (param === key) {
                            params_arr.splice(i, 1);
                        }
                    }
                    if (params_arr.length) rtn = rtn + "?" + params_arr.join("&");
                }
                return rtn;
            }


            var selected_region_id = "{{ request('region_id') }}";
            var url = "{{ route('ajax.get_districts_by_region') }}"

            if (selected_region_id) {
                var select_district_id = "{{ request('district_id') }}"
                var data = {
                    region_id: selected_region_id
                    , district_id: select_district_id
                }
                ajaxRequest(url, data, "JSON", "GET", ajaxResponse)
            }

            $('#region').on("change", function() {
                var region_id = $(this).val();
                var data = {
                    region_id: region_id
                }
                ajaxRequest(url, data, "JSON", "GET", ajaxResponse)
            })

            function ajaxResponse(res) {
                $("#district").html(res);
            }


        })

    </script>

    @stack('scripts')
    {{-- Handle datatable session expired --}}
    <script src="{{ asset('js/bootbox.min.js') }}"></script>
    <script src="{{ asset('js/ajax-datatables-expired-session.js') }}"></script>

</body>

</html>

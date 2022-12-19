<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">

    {{-- <link rel="stylesheet" href="{{asset('css/them1.css')}}"> --}}
    {{-- <link rel="stylesheet" href="{{asset('css/them2.css')}}"> --}}
    {{-- <link rel="stylesheet" href="{{asset('css/them5.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <link rel="stylesheet" href="{{asset('css/them3.css')}}"> --}}

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    <script src="{{ asset('backend/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @livewireStyles
</head>

{{-- <body class="hold-transition sidebar-mini sidebar-collapse"> --}}

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">

        <!-- Navbar -->
        @include('layouts.partials.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.partials.sidebar')
        <!--/.main sidebar container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            {{ $slot }}
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @include('layouts.partials.footer')
    </div>
    <!-- ./wrapper -->
    @stack('style')
    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->

    {{-- <script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script> --}}

    <!-- Bootstrap 4 -->
    <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="{{ asset('backend/dist/js/excel/read-excel-file.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('backend/plugins/toastr/toastr.min.css') }}">


    {{-- icheck box --}}
    <link rel="stylesheet" href="{{ asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <script src="{{ asset('backend/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('backend/plugins/moment/moment.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/plugins/moment/locale/km.js') }}"></script> --}}

    <link rel="stylesheet"
        href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    @livewireScripts
    @stack('js')
    <script>
        const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            // activate tooltip and popover
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="popover"]').popover();
            })

        window.addEventListener('alert-success', e => {
            Swal.fire({
                title: 'Success!',
                text: e.detail.message,
                icon: 'success',
                confirmButtonText: 'OK',
            });
        });

        window.addEventListener('alert-warning', e => {
            Swal.fire({
                title: 'Warning!',
                text: e.detail.message,
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        });

        window.addEventListener('alert-info', e => {
            Swal.fire({
                title: 'Info!',
                text: e.detail.message,
                icon: 'info',
                confirmButtonText: 'OK'
            });
        });

        window.addEventListener('alert-error', e => {
            Swal.fire({
                title: 'Error!',
                text: e.detail.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });

        window.addEventListener('alert', e => {
            Swal.fire({
                title: e.detail.title ?? 'Success!',
                text: e.detail.message ?? '',
                icon: e.detail.icon ?? 'success',
                confirmButtonText: e.detail.button ?? 'OK',
                showCloseButton: e.detail.closeButton ?? false,
                background: e.detail.background ?? false,
                color: e.detail.color ?? false,
                iconColor: e.detail.iconColor ?? false
            });
        });

        window.addEventListener('toast', e => {
            Toast.fire({
                icon: e.detail.icon ?? 'success',
                title: e.detail.title ?? 'Signed in successfully',
                showCloseButton: e.detail.closeButton ?? true,
                background: e.detail.background ?? false,
                color: e.detail.color ?? false,
                iconColor: e.detail.iconColor ?? false
            })
        });

        window.addEventListener('toastr', e => {
            if(e.detail.type == 'error'){
                toastr.error(e.detail.message)
            }
            else if(e.detail.type == 'info'){
                toastr.info(e.detail.message)
            }
            else if(e.detail.type == 'warning'){
                toastr.warning(e.detail.message)
            }else{
                toastr.success(e.detail.message);
            }

        });

        window.addEventListener('reach_the_last_record', e => {
            toastr.info('You Reach The Last Record.',null,
            {
                "closeButton": true,
                "positionClass": "toast-bottom-center",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            });
        });

        function goToTop(){
            $(window).scrollTop(0);
        }
        // function globleSearch(val){
        //     console.log(val);
        //     $('#table_search').val(val);
        //
        // }
        function toastError(message){
            toastr.error(message,null,
            {
                "closeButton": true,
                "positionClass": "toast-top-center",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            });
        }
    </script>
</body>

</html>

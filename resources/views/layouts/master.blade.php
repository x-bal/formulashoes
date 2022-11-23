<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('/images') }}/favicon.ico">
    <title>{{ $title }} - {{ config('app.name') }}</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}css/feather.css">
    <link rel="stylesheet" href="{{ asset('/') }}css/dataTables.bootstrap4.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="{{ asset('/') }}css/app-dark.css" id="darkTheme" disabled>

    @stack('style')
</head>

<body class="vertical light">
    <div class="wrapper">
        <!-- Component Navbar -->
        <x-navbar></x-navbar>
        <!-- Component Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Main Content -->
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h1 class="page-title">{{ $title }}</h1>

                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>


    <script src="{{ asset('/') }}js/jquery.min.js"></script>
    <script src="{{ asset('/') }}js/popper.min.js"></script>
    <script src="{{ asset('/') }}js/moment.min.js"></script>
    <script src="{{ asset('/') }}js/bootstrap.min.js"></script>
    <script src="{{ asset('/') }}js/simplebar.min.js"></script>
    <script src="{{ asset('/') }}js/daterangepicker.js"></script>
    <script src="{{ asset('/') }}js/jquery.stickOnScroll.js"></script>
    <script src="{{ asset('/') }}js/tinycolor-min.js"></script>
    <script src="{{ asset('/') }}js/config.js"></script>
    <script src="{{ asset('/') }}js/apps.js"></script>
    <script src="{{ asset('/') }}js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/') }}js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('/') }}js/sweetalert.min.js"></script>


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-56159088-1');
    </script>

    <script>
        $('#table').DataTable({
            autoWidth: true,
            "lengthMenu": [
                [10, 20, 50, -1],
                [10, 20, 50, "All"]
            ]
        });

        $(".table").on('click', '.btn-delete', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Hapus data?',
                text: "Hapus data bersifat permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parent().submit()
                }
            })
        });

        $(".logout").on('click', function() {
            Swal.fire({
                title: 'Logout?',
                text: "Anda akan logout!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#logout-form").submit()
                }
            })
        })

        $(document).ready(function() {
            let mode = localStorage.getItem('mode')
            let image = '';

            if (mode == 'light') {
                image = "{{ asset('images/fs-white.png') }}";
            } else {
                image = "{{ asset('images/fs-dark.png') }}";
            }

            $(".img-logo").attr('src', image)
        })

        $(".collapseSidebar").on('click', function() {
            let mode = localStorage.getItem('mode');
            let logo = '';
            let width = ''

            if (mode == 'light') {
                if ($(".vertical").hasClass("collapsed")) {
                    logo = "{{ asset('images/side-white.png') }}"
                    width = 50
                } else {
                    logo = "{{ asset('images/fs-white.png') }}";
                    width = 140
                }
            } else {
                if ($(".vertical").hasClass("collapsed")) {
                    logo = "{{ asset('images/side-dark.png') }}"
                    width = 50
                } else {
                    logo = "{{ asset('images/fs-dark.png') }}";
                    width = 140
                }
            }

            $(".img-logo").attr("width", width)
            $(".img-logo").attr('src', logo)
        })
    </script>

    @stack('script')
</body>

</html>